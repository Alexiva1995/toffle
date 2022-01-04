<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::orderBy('id', 'DESC')->get();

        $ingredients = Inventory::orderBy('id', 'DESC')->get();

        $category = Category::orderBy('id', 'DESC')->get();

        return view('admin.dishes.list', compact('dishes', 'ingredients', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // dd($request->all());

        // $fields = [
        //     'name' => ['required', 'min:2'],
        //     'category_id' => ['required'],
        //     'portion' => ['required'],
        //     'percentage_profit' => ['required'],
        //     'cost_price' => ['required'],
        //     'suggested_price' => ['required'],
        //     'designated_price' => ['required'],
        //     'ingredient' => ['required'],
        //     'price' => ['required'],
        // ];

        // $msj = [
        //     'name.required' => 'El nombre es requerido.',
        //     'category_id.required' => 'La categoria es requerido.',
        //     'portion.required' => 'La porcion es requerido.',
        //     'percentage_profit.required' => 'El porcentage es requerido.',
        //     'cost_price.required' => 'El costo es requerido.',
        //     'suggested_price.required' => 'El sugerido es requerido.',
        //     'designated_price.required' => 'El designado es requerido.',
        //     'ingredient.required' => 'El ingrediente es requerido.',
        //     'price.required' => 'El precio es requerido.',
        // ];

        // $this->validate($request, $fields, $msj);

        $dish = Dish::create($request->all());

         $ingredient = array_combine($request->ingredient_ids, $request->portion); 
         $dish_ingredient = array_merge_recursive($ingredient); 
         $array_dish = [];


        foreach ($dish_ingredient as $key => $dishe) {

            $ingredient_ = array([
                'ingredient_id' => str_replace("ingredient_", "", $key),
                'portion' => $dishe,
            ]);

            $array_dish = array_merge($array_dish, $ingredient_);
        }

        foreach ($array_dish as $key => $item) {
            $dish->ingredients()->attach([ $dish->id => 
                [
                    'dish_id' => $dish->id,
                    'inventory_id' => $item['ingredient_id'],
                    'portion' => $item['portion'],            
                ]
            ]);
        }

        return redirect()->route('dishes.index')->with('success', 'Plato Añadido');
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
    public function edit(Request $request)
    {
        $dish = Dish::find($request->id);
        $ingredients = Inventory::orderBy('id', 'DESC')->get();
        return view('admin.dishes.edit', compact('dish', 'ingredients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $pivote = DB::delete('DELETE FROM dish_ingredient WHERE dish_id = ?', [$dish->id]);
        $dish = Dish::find($dish->id);
        $dish->delete();

        return redirect()->route('dishes.index')->with('success', 'Plato Eliminado');
    }
}
