<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories= Inventory::orderBy('id', 'DESC')->get();

        $products= Product::orderBy('id', 'DESC')->get();

        return view('admin.inventories.index')
            ->with('inventories', $inventories)
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inventories.create');
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
            // 'total' => ['required'],
            // 'deposit' => ['required'],
            // 'local' => ['required'],
            // 'public' => ['required'],
            // 'cost' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            // 'total.required' => 'La cantidad total es requerida.',
            // 'deposit.required' => 'La cantidad de deposito es requerida.',
            // 'local.required' => 'La cantidad local es requerida.',
            // 'public.required' => 'La cantidad pública es requerida.',
            // 'cost.required' => 'El correo es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $inventory = Inventory::create($request->all());

        return redirect()->route('index.inventory')->with('success', 'Inventario Añadido');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
