<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Dish;

class InventoryController extends Controller
{
    public function index(): View
    {
        $inventories = Inventory::with('product')->orderBy('id', 'DESC')->get();
        $products = Product::orderBy('id', 'DESC')->get();
        $total_inventory_value = $inventories->sum('cost') * $inventories->sum('local');
        return view('admin.inventory.index', compact('inventories','products','total_inventory_value'));
    }

    public function create(): void
    {
        //
    }

    public function addProductToInventory(Request $request): RedirectResponse
    {
        // 1. Validación (Sin cambios)
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

        // 2. Lógica para productos CON sabores (Corrección menor para precio)
        if ($request->it_has_flavors == true) {
            $inventory = Inventory::where('product_id', $request->product_id)
                                 ->where('flavor_name', strtolower($request->flavor_name))
                                 ->first();

            if($inventory == null || empty($inventory)){
                // Si el sabor no existe, se crea.
                $inventory = $this->store($request);

                // NOTA: Si es nuevo, el precio ya está establecido por store, no hay que promediar.
            } else {

                // **** LÓGICA DE PRECIO CORREGIDA PARA SABORES ****
                if ($inventory->local <= 0) {
                    // Si el inventario local es cero o negativo, toma el costo del paquete nuevo.
                    $promedial_price = floatval($request->unit_cost);
                } else {
                    // Si hay inventario, promedia.
                    $promedial_price = $i_model->promedialPrice($inventory->cost, floatval($request->unit_cost), $inventory->local, $request->unit_package);
                }

                // Se incrementa la cantidad local.
                $inventory->local += $request->unit_package;
                $inventory->save();

                // Se actualizan todos los sabores del producto con el nuevo precio/costo.
                $inventories = Inventory::where('product_id', $request->product_id)->get();
                foreach ($inventories as $item) {
                    $item->update([
                        'price' => $promedial_price,
                        'cost' => $promedial_price
                    ]);
                }
            }

        }else{
            // 3. Lógica para productos SIN sabores (CORRECCIÓN PRINCIPAL)
            $inventory = Inventory::where('product_id', $request->product_id)->first();

            if ($inventory == null || empty($inventory)) {
                // Si el inventario es NUEVO, solo lo creamos. 'store' se encarga de la cantidad y precio.
                $inventory = $this->store($request);
            } else {

                // **** LÓGICA DE PRECIO CORREGIDA ****
                if ($inventory->local <= 0) {
                    // Si el inventario local es cero o negativo, NO PROMEDIA.
                    // Toma el costo/precio del paquete que se está ingresando.
                    $promedial_price = floatval($request->unit_cost);
                    $price = floatval($request->price);
                } else {
                    // Si hay inventario, SÍ PROMEDIA el costo.
                    $promedial_price = $i_model->promedialPrice($inventory->cost, floatval($request->unit_cost), $inventory->local, $request->unit_package);
                    $price = $promedial_price; // Usar el costo promediado como nuevo precio (si esa es tu lógica de negocio)
                }

                // Preparamos el Request para la función update
                $request['price'] = $price;
                $request['cost'] = $promedial_price; // Aseguramos que el costo refleje el resultado de la lógica.
                $request['local'] = $inventory->local + $request->unit_package; // Calculamos el nuevo total

                // Llamamos a update para actualizar el precio/costo y la cantidad total.
                $this->update($request, $inventory->id);
            }
        }
        return back()->with('success', 'Productos Añadidos al Inventario');
    }

    public function store(Request $request): Inventory
    {
        $inventory = new Inventory;
        $inventory->product_id = request()->product_id;
        $inventory->flavor_name = request()->it_has_flavors == true ? strtolower($request->flavor_name) : null;
        $inventory->deposit = $request->input('unit_package');
        $inventory->unit_package = request()->unit_package;
        $inventory->local = request()->unit_package; // Aquí se inicializa con la cantidad
        $inventory->price = request()->price;
        $inventory->cost = doubleval(request()->unit_cost);
        $inventory->save();
        return $inventory;
    }

    public function update(Request $request, int $id): ?RedirectResponse
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
            // Este bloque se usa para actualizar después de 'addProductToInventory' (para productos existentes sin sabores)
            $inventory->deposit + $request->unit_package;
            $inventory->local = $inventory->local < 0 ? 0 : $inventory->local;

            // En este punto, $request->local, $request->price y $request->cost ya vienen calculados
            // desde addProductToInventory con la lógica de no-promediar si local es <= 0.
            $inventory->update([
                'unit_package' => $request->unit_package,
                'price' => $request->price,
                'cost' => $request->cost,
                'local' => $request->local,
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
        return null;
    }

    public function destroy(int $id): RedirectResponse
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

    public function operation(Request $request, int $id): RedirectResponse
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
