<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Ingredient;
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

        $ingredients = Ingredient::orderBy('id', 'DESC')->get();

        return response()->view('admin.dishes.index', compact('dishes', 'ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.dishes.create');
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

        $dish = Dish::create($request->all());

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
        return response()->view('admin.dishes.edit', compact('dish'));
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
