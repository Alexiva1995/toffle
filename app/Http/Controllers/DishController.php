<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Product;
use App\CustomClass\Ingredient;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $dishes = Dish::with('category')->orderBy('id', 'DESC')->get();

        $ingredients = Inventory::orderBy('id', 'DESC')->get();
        //Obtiene las categorias de tipo 'Ingresos' (Asumo que type = 1 es para platos/productos)
        $category = Category::where('type', 1)->orderBy('id', 'DESC')->get();

        return view('admin.dishes.list', compact('dishes', 'ingredients', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dishes = Dish::orderBy('id', 'DESC')->get();
        $ingredients = Inventory::with('product')->orderBy('id', 'DESC')->get();
        $category = Category::where('type', 1)->orderBy('id', 'DESC')->get();
        $dish = new Dish;

        return view('admin.dishes.create', compact('dishes','ingredients','category','dish'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $fields = [
            'name' => ['required', 'min:2'],
            'category_id' => ['required'],
            'percentage_profit' => ['required'],
            'cost_price' => ['required'],
            'suggested_price' => ['required'],
            'designated_price' => ['required'],
            'status' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'category_id.required' => 'La categoria es requerida.',
            'percentage_profit.required' => 'El porcentage es requerido.',
            'cost_price.required' => 'El costo es requerido.',
            'suggested_price.required' => 'El precio sugerido es requerido.',
            'designated_price.required' => 'El precio designado es requerido.',
            'status.required' => 'El estado del plato es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        if ($request->ingredient_ids == null || $request->portion == null || $request->price == null) {
            return redirect()->back()->withInput()->with('danger', 'Debes Agregar Ingredientes en el Plato');
        }else{

            // 1. INICIO - CÁLCULO DEL CPV
            $cost_price = (float)$request->cost_price;
            $cpv_deduction = 0.0;

            // Recorre los IDs de ingredientes que se van a adjuntar.
            // Asumiendo que ingredient_ids y price están sincronizados por índice
            foreach ($request->ingredient_ids as $index => $id) {
                // Limpia el ID y lo convierte a entero para la comparación.
                $clean_id = (int)str_replace("ingredient_", "", $id);

                // Si el ingrediente es el 1 o el 2, acumula su costo designado para la deducción
                if ($clean_id === 88 || $clean_id === 97) {
                    $designated_cost = (float)$request->price[$index];
                    $cpv_deduction += $designated_cost;
                }
            }

            $cpv_final = $cost_price - $cpv_deduction;
            // 1. FIN - CÁLCULO DEL CPV

            // Prepara los datos del plato y agrega el CPV
            $dishData = $request->all();
            $dishData['cpv'] = $cpv_final;

            $dish = Dish::create($dishData);

            // 2. INICIO - Lógica para adjuntar ingredientes a la tabla pivote
            $portions = array_combine($request->ingredient_ids, $request->portion);
            $costs = array_combine($request->ingredient_ids, $request->price);
            $dish_ingredient = array_merge_recursive($portions, $costs);
            $array_dish = [];

            foreach ($dish_ingredient as $key => $dishe) {

                $ingredient_ = array([
                    'ingredient_id' => str_replace("ingredient_", "", $key),
                    'portion' => $dishe[0],
                    'designated_cost' => $dishe[1],
                ]);

                $array_dish = array_merge($array_dish, $ingredient_);
            }

            foreach ($array_dish as $key => $item) {
                $dish->ingredients()->attach([ $dish->id =>
                    [
                        'dish_id' => $dish->id,
                        'inventory_id' => $item['ingredient_id'],
                        'portion' => $item['portion'],
                        'designated_cost' => $item['designated_cost'],
                    ]
                ]);
            }
            // 2. FIN - Lógica para adjuntar ingredientes

            return redirect()->route('dishes.index')->with('success', 'Plato Añadido');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dish = Dish::find($id);
        $ingredients = Inventory::orderBy('id', 'DESC')->with('product')->get();
        $category = Category::orderBy('id', 'DESC')->get();

        return view('admin.dishes.edit', compact('dish', 'ingredients', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = [
            'name' => ['required', 'min:2'],
            'category_id' => ['required'],
            'percentage_profit' => ['required'],
            'cost_price' => ['required'],
            'suggested_price' => ['required'],
            'designated_price' => ['required'],
            'status' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'category_id.required' => 'La categoria es requerida.',
            'percentage_profit.required' => 'El porcentage es requerido.',
            'cost_price.required' => 'El costo es requerido.',
            'suggested_price.required' => 'El precio sugerido es requerido.',
            'designated_price.required' => 'El precio designado es requerido.',
            'status.required' => 'El estado del plato es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $dish = Dish::find($id);

        // 1. INICIO - CÁLCULO DEL CPV
        $cost_price_total = (float)$request->cost_price;
        $cpv_deduction = 0.0;

        // Recorre los IDs de ingredientes del request.
        foreach ($request->ingredient_ids as $index => $id) {
            $clean_id = (int)str_replace("ingredient_", "", $id);

            if ($clean_id === 88 || $clean_id === 97) {
                $designated_cost = (float)$request->price[$index];
                $cpv_deduction += $designated_cost;
            }
        }

        $cpv_final = $cost_price_total - $cpv_deduction;
        // 1. FIN - CÁLCULO DEL CPV

        $dish->update([
            'name' => $request->name,
            'cost_price' => $request->cost_price,
            'cpv' => $cpv_final, // <--- CAMBIO: AGREGADO CPV
            'suggested_price' => $request->suggested_price,
            'designated_price' => $request->designated_price,
            'percentage_profit' => $request->percentage_profit,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        // 2. INICIO - Lógica para adjuntar/sincronizar ingredientes
        $portions = array_combine($request->ingredient_ids, $request->portion);
        $costs = array_combine($request->ingredient_ids, $request->price);
        $dish_ingredient = array_merge_recursive($portions, $costs);
        $array_dish = [];

        foreach ($dish_ingredient as $key => $dishe) {

            $ingredient_ = array([
                'ingredient_id' => str_replace("ingredient_", "", $key),
                'portion' => $dishe[0],
                'designated_cost' => $dishe[1],
            ]);

            $array_dish = array_merge($array_dish, $ingredient_);
        }

        // Esta lógica usa attach, lo cual podría duplicar registros si los ingredientes no cambian.
        // Lo correcto sería usar syncWithoutDetaching o un update/sync más limpio.
        // Pero mantendremos tu lógica original con el 'if' para evitar duplicados.
        foreach ($array_dish as $key => $item) {
            if ($dish->ingredients()->wherePivot('inventory_id', $item['ingredient_id'])->first() == null) {
                $dish->ingredients()->attach([ $dish->id =>
                    [
                        'dish_id' => $dish->id,
                        'inventory_id' => $item['ingredient_id'],
                        'portion' => $item['portion'],
                        'designated_cost' => $item['designated_cost'],
                    ]
                ]);
            }

        }
        // 2. FIN - Lógica para adjuntar/sincronizar ingredientes

        return redirect()->route('dishes.index')->with('success', 'Plato editado');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dish = Dish::find($id);

        $orders = Order::whereHas('dishes', function($q) use($dish) {
            $q->where('dish_id', $dish->id);
        })->get();

        if ($orders != '[]') {
            return redirect()->route('dishes.index')->with('danger', 'Este Plato no puede ser eliminado, porque está añadido en '.count($orders).' órdenes.');
        }

        $dish->ingredients()->detach();

        $dish->delete();

        return redirect()->route('dishes.index')->with('success', 'Plato Eliminado');
    }

    /**
     * Elimina un ingrediente de un plato y recalcula los precios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id El ID en la tabla pivote (pivot table)
     * @return string
     */
    public function removeIngredient(Request $request, $id)
    {
        $dish = Dish::find($request->dish_id);

        // Elimina el ingrediente de la tabla pivote
        $dish->ingredients()->wherePivot('id', $id)->detach();

        $cost_price = 0;
        $cpv_deduction = 0.0; // <--- Inicializa la deducción para el CPV

        // Recalcula el costo base (cost_price) y la deducción del CPV
        if ($dish->ingredients()->get()->isNotEmpty()) {
            foreach ($dish->ingredients()->get() as $item) {
                // Se utiliza el valor de la tabla pivote
                $costo_ingrediente = (float)$item->pivot->designated_cost;
                $cost_price += $costo_ingrediente;

                // LÓGICA DE DEDUCCIÓN PARA CPV
                // Asumo que $item->id es el inventory_id del ingrediente
                if ($item->id === 1 || $item->id === 2) {
                    $cpv_deduction += $costo_ingrediente;
                }
            }
        }

        $cpv_final = $cost_price - $cpv_deduction; // <--- Calcula el CPV

        // Recalcula el precio sugerido
        $price_dish = number_format($cost_price * $dish->percentage_profit, 2, '.', '');

        // Actualiza el plato en la base de datos
        $dish->update([
            'cost_price' => $cost_price,
            'cpv' => $cpv_final, // <--- CAMBIO: AGREGADO CPV
            'suggested_price' => $price_dish,
            'designated_price' => $price_dish, // Se mantiene igual que el sugerido
        ]);

        return 'Ingrediente Eliminado del Plato';
    }


}
