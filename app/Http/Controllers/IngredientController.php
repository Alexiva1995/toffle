<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ingredients = Ingredient::orderBy('id', 'DESC')->get();

        return response()->view('admin.ingredients.create', compact('ingredients'));
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
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'El nombre debe contener al menos 2 caracteres.',
        ];

        $this->validate($request, $fields, $msj);

        $dish = Ingredient::create($request->all());

        return redirect()->route('index.dishes')->with('success', 'Ingrediente Añadido');
    }
}
