<?php

namespace App\Http\Controllers;

use App\Models\Dish;
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

        return view('admin.dishes.list', compact('dishes', 'ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ingredients = Inventory::orderBy('id', 'DESC')->get();

        return view('admin.dishes.create', compact('ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // dd($request);
        $fields = [
            'name' => ['required', 'min:2'],
            'ingredient' => ['required'],
            'portion' => ['required'],
            // 'total' => ['required'],
            // 'deposit' => ['required'],
            // 'local' => ['required'],
            // 'public' => ['required'],
            // 'cost' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'El nombre debe contener al menos 2 caracteres.',
            'ingredient.required' => 'El ingrediente es requerido.',
            'portion.required' => 'La porción es requerida',
            // 'total.required' => 'La cantidad total es requerida.',
            // 'deposit.required' => 'La cantidad de deposito es requerida.',
            // 'local.required' => 'La cantidad local es requerida.',
            // 'public.required' => 'La cantidad pública es requerida.',
            // 'cost.required' => 'El correo es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        // $dish->dishes()->attach( [ $dish->id => 
        //         [
        //             'order_id' => $dish->id,
        //             'dish_id' => $item['dish_id'],
        //             'unit' => $item['unit'],            
        //             'price' => number_format($item['price'], 2, '.', ''),
        //         ]
        //     ]);


        $dish = Dish::create($request->all());

        // dd($request->ingredient);
        foreach($request->ingredient as $ingredient){
            $dish->ingredients()->attach($ingredient);
        }

        return redirect()->route('index.dishes')->with('success', 'Plato Añadido');
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
        //
    }
}
