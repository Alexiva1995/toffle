<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->fecha_ini) && !isset($request->fecha_fin)){
            $orders = Order::orderBy('id', 'desc')->whereDate('created_at', '>=' ,$request->fecha_ini)->get();
        }elseif(!isset($request->fecha_ini) && isset($request->fecha_fin)){
            $orders = Order::orderBy('id', 'desc')->whereDate('created_at', '<=' ,$request->fecha_fin)->get();
        }elseif(isset($request->fecha_ini) && isset($request->fecha_fin)){
            $orders = Order::orderBy('id', 'desc')->whereBetween('created_at', [$request->fecha_ini. " 00:00:00", $request->fecha_fin. " 23:59:59"])->get();
        }else{
            $today = Carbon::now();
            $orders = Order::orderBy('id', 'desc')->whereDate('created_at', $today)->get();
        }
        
    
        return view('/orders/index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dish_category = Dish::select('category_id')->distinct()->get();

        return view('employee.dashboard.orders.create')
            ->with('dish_category', $dish_category);
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

        $units = array_combine($request->num_rows, $request->unit); 
        $prices = array_combine($request->num_rows, $request->price); 
        $dish_ids = array_combine($request->num_rows, $request->dish_ids);
        $dishes = array_merge_recursive($dish_ids, $units, $prices); 

        $array_dish = [];

        foreach ($dishes as $key => $dish) {

            $plate = array([
                'dish_id' => $dish[0],
                'unit' => $dish[1],
                'price' => $dish[2],
            ]);

            $array_dish = array_merge($array_dish, $plate);
        }

        foreach ($array_dish as $key => $item) {

            $dish = Dish::find($item['dish_id']);

            foreach ($dish->ingredients()->get() as $key => $value) {

                $order->ingredients()->attach( [ $order->id => 
                    [
                        'order_id' => $order->id,
                        'dish_id' => $item['dish_id'],
                        'inventory_id' => $value->pivot->inventory_id,
                        'portion' => $value->pivot->portion,            
                        'designated_cost' => $value->pivot->designated_cost,
                        'it_has_flavors' => $value->product->it_has_flavors,
                    ]
                ]);
                $inventory = Inventory::where('id', $value->pivot->inventory_id)->first();
                $grams = $value->pivot->portion;
                $grams_used = $value->pivot->portion * $item['unit'];
                $units = $grams_used / 1000;

                $inventory->decrement('local', $units);
                $inventory->update([
                    'total' => $inventory->deposit + $inventory->local + $inventory->public
                ]);
            }

            $order->dishes()->attach( [ $order->id => 
                [
                    'order_id' => $order->id,
                    'dish_id' => $item['dish_id'],
                    'unit' => $item['unit'],            
                    'price' => number_format($item['price'], 2, '.', ''),
                    'cost' => number_format($dish->cost_price, 2, '.', ''),
                ]
            ]);
        }

        return redirect()->route('order.edit.ingredients', $order->id)->with('success', 'Pedido Agregado');
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

    public function editIngredients($id)
    {
        $order = Order::find($id);

        $dish_category = Dish::select('category_id')->distinct()->get();

        return view('employee.dashboard.orders.partials.additional_modifications')
            ->with('dish_category', $dish_category)
            ->with('order', $order);
    }

    public function updateIngredients(Request $request, $id)
    {
        return view('employee.dashboard.orders.partials.additional_modifications');
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

        $dish_category = Dish::select('category_id')->distinct()->get();

        $array_dish = array();

        foreach ($dishes as $key => $dish) {
            $array_dish[] = $dish->pivot->id;
        }

        return view('employee.dashboard.orders.edit')
            ->with('array_dish', json_encode($array_dish))
            ->with('dish_category', $dish_category)
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

    public function orderTableData(Request $request, $type)
    {
        if ($type == 'pending') {
            $orders = Order::whereIn('status', ['0', '1'])
            ->orderBy('id', 'DESC');
        }else{
            $orders = Order::orderBy('id', 'DESC');
        }

            
        return Datatables::of($orders)->filter(function ($query) use($request) {
        }, true)
        ->toJson();
    }

    public function showOrderDetails(Request $request)
    {
        $order = Order::where('id', $request->id)->first();

        return view('admin.reports.show_orders_details')
            ->with('order', $order)
            ->render();
    }
}
