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
                'dish_id' => str_replace("dish_", "", $key),
                'unit' => $dish[0],
                'price' => $dish[1],
            ]);

            $array_dish = array_merge($array_dish, $plate);
        }

        foreach ($array_dish as $key => $item) {
            $order->dishes()->attach( [ $order->id => 
                [
                    'order_id' => $order->id,
                    'dish_id' => $item['dish_id'],
                    'unit' => $item['unit'],            
                    'price' => number_format($item['price'], 2, '.', ''),
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
        $order = Order::find($id);

        $dishes = $order->dishes()->get();

        $array_dish = array();

        foreach ($dishes as $key => $dish) {
            $array_dish[] = $dish->pivot->id;
        }

        return view('employee.dashboard.orders.edit')
            ->with('array_dish', json_encode($array_dish))
            ->with('order', $order);
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
        if ($request->ajax()) {

            $order = Order::find($id);

            if ($request->form == 'edit_order') {
                $this->editOrder($request, $order);
            }

            if ($request->form == 'edit_order_dish') {
                $this->editOrderDish($request, $order);
            }

        }

        return $order;
    }

    public function editOrder($request, $order)
    {
        foreach ($request->all() as $key => $value) {
            switch ($key) {
                case 'customer_name':

                    $fields = [
                        "customer_name" => ['required'],
                    ];

                    break;
                case 'table':

                    $fields = [
                        "table" => ['required'],
                    ];

                    break;
                case 'status':

                    $fields = [
                        "status" => ['required'],
                    ];
        
                    break;
                default:

                    break;
            }
        }

        $msj = [
            'customer_name.required' => 'El nombre del cliente es requerido',
            'table.required' => 'La mesa es requerida',
        ];

        $this->validate($request, $fields, $msj);

        $order->update($request->all());
    }

    public function editOrderDish($request, $order)
    {
        foreach ($request->all() as $key => $value) {
            switch ($key) {
                case 'unit':

                    $fields = [
                        "unit" => ['required'],
                    ];

                    break;
                case 'price':

                    $fields = [
                        "price" => ['required'],
                    ];

                    break;

                default:

                    break;
            }
        }

        $msj = [
            'unit.required' => 'El n° de unidades del plato es requerido',
            'price.required' => 'El precio por unidad del plato es requerido',
        ];

        $this->validate($request, $fields, $msj);

        if ($request->unit != null) {
            $order->dishes()->wherePivot('id', $request->id)->update([
                'unit' => $request->unit,
            ]);
        }

        if ($request->price != null) {
            $order->dishes()->wherePivot('id', $request->id)->update([
                'price' => number_format($request->price, 2, '.', ''),
            ]);
        }

        $order->update([
            'total_amount' => $request->total_amount,
        ]);
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

    public function dishRemove(Request $request, $id)
    {
        $order = Order::find($request->order_id);

        $dish = $order->dishes()->wherePivot('id', $id)->first();

        if ($dish != null) {
            $order->decrement('total_amount', number_format($dish->pivot->unit * $dish->pivot->price, 2, '.', '') );

            $order->dishes()->wherePivot('id', $id)->detach();
        }

        return redirect()->route('orders.edit', $request->order_id)->with('success', 'Plato Removido de la Órden');


    }

    public function dishAdd(Request $request, $order_id)
    {
        $fields = [
            'dish_id' => ['required'],
            'unit' => ['required'],
            'price' => ['required'],
        ];

        $msj = [
            'dish_id.required' => 'El plato es requerido.',
            'unit.required' => 'La número de unidades es requerida.',
            'price.required' => 'El precio por unidad es requerido'
        ];

        $this->validate($request, $fields, $msj);

        $order = Order::find($order_id);

        $dish = $order->dishes()->wherePivot('dish_id', $request->dish_id)->get();

        if ($dish != '[]') {
            return redirect()->route('orders.edit', $order->id)->with('danger', 'Este Plato ya está añadido en está Órden');
        }

        $order->dishes()->attach( [ $order->id => 
            [
                'order_id' => $order->id,
                'dish_id' => $request->dish_id,
                'unit' => $request->unit,          
                'price' => number_format($request->price, 2, '.', ''),
            ]
        ]);

        $order->increment('total_amount', number_format($request->unit * $request->price, 2, '.', '') );

        return redirect()->route('orders.edit', $order->id)->with('success', 'Plato Añadido a la Órden');
    }
}
