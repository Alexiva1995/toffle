<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Dish;
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
            'name' => 'required',
            'type' => 'required',
            'quantity' => 'required',
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'type.required' => 'El tipo de unidades es requerido.',
            'quantity.required' => 'La cantidad es requerida.',
        ];

        $this->validate($request, $fields, $msj);
        //Verificar el tipo de unidad y guardar en consecuencia.
        if(request()->type == 'units')
        {
            Product::create([
                'name' => request()->name,
                'quantity' => request()->quantity,
                'it_has_flavors' => request()->it_has_flavors
            ]);
        }elseif(request()->type == 'gr')
        {
            Product::create([
                'name' => request()->name,
                'gr' => request()->quantity,
                'it_has_flavors' => request()->it_has_flavors
            ]);
        }

        Session::flash('products', true); 
        return redirect()->route('inventory.index')->with('success', 'Producto Añadido');
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
            'mark' => ['required'],
            'gr' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'mark.required' => 'La marca del producto es requerida.',
            'gr.required' => 'El Gr. es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $gr_old_product = $product->gr;

        $product->update($request->all());

        if ($gr_old_product != $product->gr) {
            $inventory = Inventory::where('product_id', $product->id)->first();

            if ($inventory != null) {
                $cost_product = $inventory->cost;
    
                $dishes = Dish::whereHas('ingredients', function($q) use($inventory) {
                    $q->where('inventory_id', $inventory->id);
                })->get();
        
                if ($dishes != '[]') {
                    foreach ($dishes as $key => $dish) {
        
                        $profit = $dish->percentage_profit;
                        $designated_cost = 0;
                        $suggested_price = 0;
                        $cost_price = 0;
        
                        foreach ($dish->ingredients()->get() as $key => $item) {
                            $portion = $item->pivot->portion;
        
                            if ($item->pivot->inventory_id == $inventory->id) {
                                $designated_cost = ($portion * $cost_product) / $product->gr;
            
                                $dish->ingredients()->wherePivot('inventory_id', $inventory->id)->update([
                                    'designated_cost' => $designated_cost,
                                ]);
                
                            }else{
                                $designated_cost = $item->pivot->designated_cost;
                            }

                            $cost_price = $cost_price + $designated_cost;
                        }
        
                        $suggested_price = $cost_price * $profit;
        
                        if ($suggested_price > $dish->designated_price) {
                            $dish->update([
                                'status' => '2',
                            ]);
                        }
        
                        $dish->update([
                            'cost_price' => $cost_price,
                            'suggested_price' => $cost_price * $profit,
                        ]);
                    }
                }
            }
        }

        Session::flash('products', true); 
        return redirect()->route('inventory.index')->with('success', 'Producto Editado');
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

        $inventories = Inventory::where('product_id', $product->id)->first();

        if ($inventories != null) {
            Session::flash('products', true); 
            return redirect()->route('inventory.index')->with('danger', 'El Producto no puede ser Eliminado, porque está añadido en el Inventario. Debe remover primero el producto del inventario para poder eliminarlo.');
        }

        $product->delete();

        Session::flash('products', true); 
        return redirect()->route('inventory.index')->with('success', 'Producto Eliminado');
    }
}
