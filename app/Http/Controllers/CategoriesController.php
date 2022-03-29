<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $category = Category::create($request->all());

        return redirect()->route('categories.list')->with('success', 'Categoría Creada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $category = Category::find($id);

        $fields = [
            'name' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $category->update($request->all());

        return redirect()->route('categories.list')->with('success', 'Categoría Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        return redirect()->route('categories.list')->with('success', 'Categoría Eliminada');
    }

    public function list()
    {
        $categories = Category::all();
        return view('admin.categories.list')
            ->with('categories', $categories);
    }
}
