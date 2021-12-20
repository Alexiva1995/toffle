<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories= Inventory::orderBy('id', 'DESC')->get();

        $products= Product::orderBy('id', 'DESC')->get();

        return view('admin.inventories.index')
            ->with('inventories', $inventories)
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = [
            'name' => ['required'],
            // 'total' => ['required'],
            // 'deposit' => ['required'],
            // 'local' => ['required'],
            // 'public' => ['required'],
            // 'cost' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            // 'total.required' => 'La cantidad total es requerida.',
            // 'deposit.required' => 'La cantidad de deposito es requerida.',
            // 'local.required' => 'La cantidad local es requerida.',
            // 'public.required' => 'La cantidad pública es requerida.',
            // 'cost.required' => 'El correo es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $inventory = Inventory::create($request->all());

        return redirect()->route('inventories.index')->with('success', 'Inventario Añadido');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = Inventory::find($id);
        $products = Product::all();
                
        return view('admin.inventories.show')
        ->with('products', $products)
        ->with('inventory', $inventory);
    }

    public function productToInventoryStore(Request $request, $id)
    {
        $inventory = Inventory::find($id);

        $fields = [
            'product_id' => ['required'],
            'qty_package' => ['required'],
            'unit_package' => ['required'],
            'price' => ['required'],
        ];

        $msj = [
            'product_id.required' => 'El producto es requerido.',
            'qty_package.required' => 'La cantidad de bultos es requerida.',
            'unit_package.required' => 'La unidad del bulto es requerida.',
            'price.required' => 'El precio es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $inventory->products()->attach( [ $inventory->id => [
            'product_id' => $request->product_id,
            'qty_package' => $request->qty_package,
            'unit_package' => $request->unit_package,
            'price' => $request->price,
            ]
        ]);

        $count_deposit = count($inventory->products()->get());

        $inventory->update([
            'deposit' => $count_deposit,
            'total' => (int) ($count_deposit + $inventory->local + $inventory->public)
        ]);
        
        return redirect()->route('inventories.show', $inventory->id)->with('success', 'Producto Agregado al Inventario');
    }

    public function productToInventoryUpdate(Request $request, $id)
    {
        $inventory_id = $request->inventory_id;
        $inventory = Inventory::find($inventory_id);

        $fields = [
            'product_id' => ['required'],
            'qty_package' => ['required'],
            'unit_package' => ['required'],
            'price' => ['required'],
        ];

        $msj = [
            'product_id.required' => 'El producto es requerido.',
            'qty_package.required' => 'La cantidad de bultos es requerida.',
            'unit_package.required' => 'La unidad del bulto es requerida.',
            'price.required' => 'El precio es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $inventory->products()->wherePivot('id', $id)->update([ 
            'product_id' => $request->product_id,
            'qty_package' => $request->qty_package,
            'unit_package' => $request->unit_package,
            'price' => $request->price,
        ]);

        return redirect()->route('inventories.show', $inventory->id)->with('success', 'Producto del Inventario Editado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);

        $fields = [
            'name' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $inventory->update($request->all());

        return redirect()->route('inventories.index')->with('success', 'Inventario Editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);

        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventario Eliminado');
    }

    public function productToInventoryDestroy(Request $request, $id)
    {
        $inventory_id = $request->inventory_id;

        $inventory = Inventory::find($inventory_id);

        $inventory->products()->wherePivot('id', $id)->detach();

        $count_deposit = count($inventory->products()->get());

        $inventory->update([
            'deposit' => $count_deposit,
            'total' => (int) ($count_deposit + $inventory->local + $inventory->public)
        ]);

        return redirect()->route('inventories.show', $inventory->id)->with('success', 'Producto del Inventario Eliminado');
    }

    public function operation(Request $request, $id)
    {
        $inventory = Inventory::find($id);

        $fields = [
            'qty' => ['required'],
        ];

        $msj = [
            'qty.required' => 'La cantidad es requerida.',
        ];

        $this->validate($request, $fields, $msj);

        $department = $request->department;
        $operation = $request->operation;
        $msg_end = '';

        if ($operation == 'sum') {

            switch ($department) {
                // case 'deposit':
                //     $inventory->increment('deposit', $request->qty);
                //     $inventory->decrement('local', $request->qty);
                //     break;

                case 'local':
                    if ($request->qty > $inventory->deposit) {
                        return redirect()->route('inventories.index')->with('danger', 'La Cantidad a Sumar en Local es Mayor al Fondo Actual en Depósito');
                    }else{
                        $inventory->increment('local', $request->qty);
                        $inventory->decrement('deposit', $request->qty);
                        $msg_success = 'Operación de Suma en Local Éxitosa';
                    }
                    break;

                case 'public':
                    if ($request->qty > $inventory->local) {
                        return redirect()->route('inventories.index')->with('danger', 'La Cantidad a Sumar en Público es Mayor al Fondo Actual en Local');
                    }else{ 
                        $inventory->increment('public', $request->qty);
                        $inventory->decrement('local', $request->qty);
                        $msg_success = 'Operación de Suma en Público Éxitosa';
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }

        if ($operation == 'subtract') {

            switch ($department) {
                // case 'deposit':
                //     $inventory->increment('local', $request->qty);
                //     break;

                case 'local':
                    if ($request->qty > $inventory->local) {
                        return redirect()->route('inventories.index')->with('danger', 'La Cantidad a Restar en Local es Mayor al Fondo Actual en Local');
                    }else{ 
                        $inventory->decrement('local', $request->qty);
                        $inventory->increment('deposit', $request->qty);
                        $msg_success = 'Operación de Resta en Local Éxitosa';
                    }
                    break;

                case 'public':
                    if ($request->qty > $inventory->public) {
                        return redirect()->route('inventories.index')->with('danger', 'La Cantidad a Restar en Público es Mayor al Fondo Actual en Público');
                    }else{ 
                        $inventory->decrement('public', $request->qty);
                        $inventory->increment('local', $request->qty);
                        $msg_success = 'Operación de Resta en Público Éxitosa';
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }

        $inventory->update([
            'total' => ( $inventory->deposit + $inventory->local + $inventory->public )
        ]);

        return redirect()->route('inventories.index')->with('success', $msg_success);
    }

}
