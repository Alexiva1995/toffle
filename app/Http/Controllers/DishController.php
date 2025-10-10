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
        //Obtiene las categorias de tipo 'Ingresos'
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

            $dish = Dish::create($request->all());

            $portions = array_combine($request->ingredient_ids, $request->portion); 
            $costs = array_combine($request->ingredient_ids, $request->price); 
            $dish_ingredient = array_merge_recursive($portions, $costs); 
            $array_dish = [];

            foreach ($dish_ingredient as $key => $dishe) {

                $ingredient_ = [[
                    'ingredient_id' => str_replace("ingredient_", "", $key),
                    'portion' => $dishe[0],
                    'designated_cost' => $dishe[1],
                ]];
    
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
        $dish->update([
            'name' => $request->name,
            'cost_price' => $request->cost_price,
            'suggested_price' => $request->suggested_price,
            'designated_price' => $request->designated_price,
            'percentage_profit' => $request->percentage_profit,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        $portions = array_combine($request->ingredient_ids, $request->portion); 
        $costs = array_combine($request->ingredient_ids, $request->price); 
        $dish_ingredient = array_merge_recursive($portions, $costs); 
        $array_dish = [];

        foreach ($dish_ingredient as $key => $dishe) {

            $ingredient_ = [[
                'ingredient_id' => str_replace("ingredient_", "", $key),
                'portion' => $dishe[0],
                'designated_cost' => $dishe[1],
            ]];

            $array_dish = array_merge($array_dish, $ingredient_);
        }

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

    public function removeIngredient(Request $request, $id)
    {
        $dish = Dish::find($request->dish_id);

        $ingredient = $dish->ingredients()->wherePivot('id', $id)->detach();

        $cost_price = 0;

        if ($dish->ingredients()->get() != '[]') {
            foreach ($dish->ingredients()->get() as $key => $item) {
                $cost_price += number_format($item->pivot->designated_cost, 2, '.', '');
            }
        }

        $price_dish = number_format($cost_price * $dish->percentage_profit, 2, '.', '');

        $dish->update([
            'cost_price' => $cost_price,
            'suggested_price' => $price_dish,
            'designated_price' => $price_dish,
        ]);

        return 'Ingrediente Eliminado del Plato';
    }


}
