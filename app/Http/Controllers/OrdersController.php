<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Category;


class OrdersController extends Controller
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
            'customer_name' => ['required'],
            'table' => ['required'],
            'total_amount' => ['required'],
            'dish_ids' => ['required'],
        ];

        $msj = [
            'customer_name.required' => 'El nombre del cliente es requerido.',
            'table.required' => 'La mesa es requerida.',
            'total_amount.required' => 'El monto total es requerido',
            'dish_ids.required' => 'Los Platos son requeridos',
        ];

        $this->validate($request, $fields, $msj);

        $order = Order::create($request->all());

        $units = array_combine($request->dish_ids, $request->unit); 
        $prices = array_combine($request->dish_ids, $request->price); 
        $dishes = array_merge_recursive($units, $prices); 
        $array_dish = [];


        foreach ($dishes as $key => $dish) {

            $plate = array([
                'dish_id' => str_replace("plate", "", $key),
                'unit' => $dish[0],
                'price' => $dish[1],
            ]);

            $array_dish = array_merge($array_dish, $plate);
        }

        foreach ($array_dish as $key => $item) {
            $order->dishes()->attach( [ $order->id => [
                'order_id' => $order->id,
                'dish_id' => $item['dish_id'],
                'unit' => $item['unit'],            
                'price' => number_format($item['price'], 2),
                ]
            ]);
        }

        return redirect()->route('dashboard-employee')->with('success', 'Pedido Agregado');
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
