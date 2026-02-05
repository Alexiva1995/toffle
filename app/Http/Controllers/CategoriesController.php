<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;

class CategoriesController extends Controller
{

    public function store(Request $request): RedirectResponse
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

    public function update(Request $request, Category $category): RedirectResponse
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

    public function destroy(int $id): RedirectResponse
    {
        $category = Category::find($id);

        $category->delete();

        return redirect()->route('categories.list')->with('success', 'Categoría Eliminada');
    }

    public function list(): View
    {
        $categories = Category::all();
        return view('admin.categories.list')
            ->with('categories', $categories);
    }
}
