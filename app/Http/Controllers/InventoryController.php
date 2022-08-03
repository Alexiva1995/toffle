<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Dish;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories= Inventory::with('product')->orderBy('id', 'DESC')->get();

        $products= Product::orderBy('id', 'DESC')->get();

        return view('admin.inventory.index', compact('inventories','products'));
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
        if ($request->it_has_flavors == true) {
            $fields = [
                'product_id' => ['required'],
                'unit_package' => ['required'],
                'price' => ['required'],
                'unit_cost' => ['required'],
                'flavor_name' => ['required'],
                'currency' => ['required'],
            ];
        }else{
            $fields = [
                'product_id' => ['required'],
                'unit_package' => ['required'],
                'price' => ['required'],
                'unit_cost' => ['required'],
                'currency' => ['required'],
            ];
        }

        $msj = [
            'product_id.required' => 'El producto es requerido.',
            'unit_package.required' => 'Las unidades son requerida.',
            'price.required' => 'El precio es requerido.',
            'unit_cost.required' => 'El precio unitario es requerido.',
            'flavor_name.required' => 'El nombre del sabor es requerido.', 
            'currency.required' => 'El tipo de moneda es necesario.', 
        ];

        $this->validate($request, $fields, $msj);
        $i_model = new Inventory();
        
        if ($request->it_has_flavors == true) {
            $inventories = Inventory::where('product_id', $request->product_id)->get();
            if ($inventories == null) { $this->store($request); }
            else{
                $inventory = $inventories->first();
                $promedial_price = $i_model->promedialPrice($inventory->price, $request->price, $inventories->sum('local'), $request->unit_package);
                $request->price = $promedial_price;
                $request->unit_price = $promedial_price;
                foreach ($inventories as $item) {
                    $this->update($request, $item->id);
                }
            }
        }else{
            $inventory = Inventory::where('product_id', $request->product_id)->first();
            $promedial_price = $i_model->promedialPrice($inventory->price, $request->price, $inventory->unit_package, $request->unit_package);
            $request->price = $promedial_price;
            $request->unit_price = $promedial_price;
            if ($inventory == null) { $this->store($request); }
            else {
                $this->update($request, $inventory->id);
            }
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
        $inventory = new Inventory;
        $inventory->product_id = request()->product_id;
        $inventory->flavor_name = request()->it_has_flavors == true ? strtolower($request->flavor_name) : null;
        $inventory->deposit = $request->input('unit_package');
        $inventory->unit_package = request()->unit_package;
        $inventory->local = request()->unit_package;
        $inventory->price = request()->price;
        $inventory->cost = doubleval(request()->unit_cost);
        $inventory->save();
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
        $inventory = Inventory::with('product')->find($id);
        //Pregunta si el metodo update viene desde la acción Editar
        if ($request->update_type == "1") {
            if ($inventory->product->it_has_flavors) {
                $inventory_flavors = Inventory::where('product_id', $inventory->product->id)->get();
                foreach ($inventory_flavors as $item) {
                    $item->update(['cost' => $request->cost]);
                }
            }
            $data = ['cost' => $request->cost,'local' => $request->total,'unit_package' => $request->total];
            $inventory->update($data);

        }else{
            $inventory->deposit +  $request->unit_package;

            $inventory->update([
                // 'qty_package' => $request->qty_package,
                'unit_package' => $inventory->unit_package + $request->unit_package,
                'price' => $request->price,
                'cost' => number_format($request->price / $request->unit_package, 2, '.', ''),
                'local' => $inventory->local + $request->unit_package,
            ]);
        }
 
        $cost_product = $inventory->cost;
        $unit_product = $inventory->product->gr != null ? $inventory->product->gr : $inventory->product->quantity;

        $dishes = Dish::whereHas('ingredients', function($q) use($inventory) {
            $q->where('inventory_id', $inventory->id);
        })->get();

        if ($dishes != '[]') {
            foreach ($dishes as $key => $dish) {

                $profit = $dish->percentage_profit;
                $designated_cost = 0;
                $suggested_price = 0;
                $cost_price = 0;

                foreach ($dish->ingredients()->get() as $key => $item) {
                    $portion = $item->pivot->portion;

                    if ($item->pivot->inventory_id == $inventory->id) {
                        $designated_cost = ($portion * $cost_product) / $unit_product;
    
                        $dish->ingredients()->wherePivot('inventory_id', $inventory->id)->update([
                            'designated_cost' => $designated_cost,
                        ]);
        
                    }else{
                        $designated_cost = $item->pivot->designated_cost;
                    }

                    $cost_price = $cost_price + $designated_cost;
                }
                
                $suggested_price = $cost_price * $profit;

                if ($suggested_price > $dish->designated_price) {
                    $dish->update([
                        'status' => '2',
                    ]);
                }

                $dish->update([
                    'cost_price' => $cost_price,
                    'suggested_price' => $cost_price * $profit,
                ]);
            }
        }

        if ($request->update_type == "1") {
            return redirect()->route('inventory.index')->with('success', 'Inventario Actualizado');
        }
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

        $dishes = Dish::whereHas('ingredients', function($q) use($inventory) {
            $q->where('inventory_id', $inventory->id);
        })->get();

        if ($dishes != '[]') {
            $selected_dishes = '';
            $count = 0;

            foreach ($dishes as $key => $dish) {
                if ($count == 0) {
                    $selected_dishes = $dish->name;
                }else{
                    $selected_dishes = $selected_dishes.', '.$dish->name.'.';
                }

                $count = $count + 1;

            }

            return redirect()->route('inventory.index')->with('danger', 'Este Producto del Inventario no puede ser eliminado, porque está añadido en los siguientes platos: '.$selected_dishes);
        }

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
