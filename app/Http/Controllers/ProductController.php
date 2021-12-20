<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Session;

class ProductController extends Controller
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
        return view('admin.products.create');
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
            'gr' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'gr.required' => 'El Gr. es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $product = Product::create($request->all());

        Session::flash('products', true); 
        return redirect()->route('inventories.index')->with('success', 'Producto Añadido');
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
        $product = Product::find($id);

        $fields = [
            'name' => ['required'],
            'gr' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'gr.required' => 'El Gr. es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $product->update($request->all());

        Session::flash('products', true); 
        return redirect()->route('inventories.index')->with('success', 'Producto Editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

        Session::flash('products', true); 
        return redirect()->route('inventories.index')->with('success', 'Producto Eliminado');
    }
}
