<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{

    public function store(Request $request)
    {
        $fields = [
            'name' => ['required'],
            'type' => 'required',
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'type.required' => 'El tipo es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        Category::create($request->all());

        return redirect()->route('categories.list')->with('success', 'Categoría Creada');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $fields = [
            'name' => ['required'],
            'type' => 'required',
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'type.required' => 'El tipo es requerido.',
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
