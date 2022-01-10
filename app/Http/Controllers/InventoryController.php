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

        return view('admin.inventory.index')
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
        //
    }

    public function addProductToInventory(Request $request)
    {
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

        $inventory = Inventory::where('product_id', $request->product_id)->first();
        if ($inventory == null) {
            $this->store($request);
        }else{
            $this->update($request, $inventory->id);
        }

        return redirect()->route('inventory.index')->with('success', 'Productos Añadidos al Inventario');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deposit = ($request->qty_package * $request->unit_package);
        $inventory = Inventory::create($request->all());
        $inventory->deposit = (int) $deposit;
        $inventory->total = (int) ($deposit + $inventory->local + $inventory->public);
        $inventory->cost = number_format($request->price / $request->unit_package, 2, '.', '');
        $inventory->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        
        $deposit = $inventory->deposit + ($request->qty_package * $request->unit_package);
        $inventory->update([
            'qty_package' => $request->qty_package,
            'unit_package' => $request->unit_package,
            'price' => $request->price,
            'cost' => number_format($request->price / $request->unit_package, 2, '.', ''),
            'total' => (int) ($deposit + $inventory->local + $inventory->public),
            'deposit' => (int) ($deposit),
            'local' => (int) ($inventory->local),
            'public' => (int) ($inventory->public),
        ]);
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

        return redirect()->route('inventory.index')->with('success', 'Producto Eliminado del Inventario');
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
                case 'deposit':
                    if ($request->qty > $inventory->local) {
                        return redirect()->route('inventory.index')->with('danger', 'La Cantidad a Sumar en Depósito es Mayor al Fondo Actual en Local');
                    }else{
                        $inventory->increment('deposit', $request->qty);
                        $inventory->decrement('local', $request->qty);
                        $msg_success = 'Operación de Suma en Depósito Éxitosa';
                    }
                    break;

                case 'local':
                    if ($request->qty > $inventory->deposit) {
                        return redirect()->route('inventory.index')->with('danger', 'La Cantidad a Sumar en Local es Mayor al Fondo Actual en Depósito');
                    }else{
                        $inventory->increment('local', $request->qty);
                        $inventory->decrement('deposit', $request->qty);
                        $msg_success = 'Operación de Suma en Local Éxitosa';
                    }
                    break;

                case 'public':
                    if ($request->qty > $inventory->local) {
                        return redirect()->route('inventory.index')->with('danger', 'La Cantidad a Sumar en Público es Mayor al Fondo Actual en Local');
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
                case 'deposit':
                    if ($request->qty > $inventory->deposit) {
                        return redirect()->route('inventory.index')->with('danger', 'La Cantidad a Restar en Depósito es Mayor al Fondo Actual en Depósito');
                    }else{ 
                        $inventory->decrement('deposit', $request->qty);
                        $inventory->increment('local', $request->qty);
                        $msg_success = 'Operación de Resta en Depósito Éxitosa';
                    }
                    break;

                case 'local':
                    if ($request->qty > $inventory->local) {
                        return redirect()->route('inventory.index')->with('danger', 'La Cantidad a Restar en Local es Mayor al Fondo Actual en Local');
                    }else{ 
                        $inventory->decrement('local', $request->qty);
                        $inventory->increment('deposit', $request->qty);
                        $msg_success = 'Operación de Resta en Local Éxitosa';
                    }
                    break;

                case 'public':
                    if ($request->qty > $inventory->public) {
                        return redirect()->route('inventory.index')->with('danger', 'La Cantidad a Restar en Público es Mayor al Fondo Actual en Público');
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

        return redirect()->route('inventory.index')->with('success', $msg_success);
    }

}
