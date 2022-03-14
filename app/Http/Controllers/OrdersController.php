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

    public function index(Request $request, $type = null)
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
        
        $type == 'flow_days' ? 'flow_days' : '';
        return view('orders.index', ['orders' => $orders, 'type' =>$type ]);
    }

    public function flowDays(Request $request)
    {
        return $this->index($request, 'flow_days');

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
            "customer_name" => ['required'],
            "table" => ['required'],
        ];

        $msj = [
            'customer_name.required' => 'El nombre del cliente es requerido',
            'table.required' => 'La mesa es requerida',
        ];

        $this->validate($request, $fields, $msj);

        $order = Order::create([
            'customer_name'=> $request->customer_name,
            'table'=> $request->table,
            'total_amount' => 0,
        ]);

        return redirect()->route('order.modify.dishes', $order->id);
    }

    public function modifyDishes(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        $dish_category = Dish::select('category_id')->distinct()->get();

        return view('employee.dashboard.orders.partials.modify_dishes')
            ->with('dish_category', $dish_category)
            ->with('order', $order);
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

            if ($request->form == 'update_general_data') {
                $this->updateGeneralData($request, $order);
            }

            if ($request->form == 'update_order_dish') {
                $this->updateDishOrder($request, $order);
            }
        }

        return $order;
    }

    public function updateGeneralData($request, $order)
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

    public function updateDishOrder($request, $order)
    {
        if ($request->is_for_carry != null) {
            $order->dishes()->wherePivot('id', $request->id)->update([
                'is_for_carry' => $request->is_for_carry,
            ]);
        }
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

    public function removeDish(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        $order_dish = $order->dishes()->wherePivot('code_operation', $request->code_operation)->first();

        if ($order_dish != null) {
            $order->decrement('total_amount', number_format($order_dish->pivot->unit * $order_dish->pivot->price, 2, '.', '') );

            $dish = Dish::find($order_dish->pivot->dish_id);
        
            foreach ($dish->ingredients()->get() as $key => $value) {
    
                $inventory = Inventory::where('id', $value->pivot->inventory_id)->first();
                $grams = $value->pivot->portion;
                $grams_used = $value->pivot->portion * $order_dish->pivot->unit;
                $units = $grams_used / 1000;
    
                $inventory->increment('local', $units);
                $inventory->update([
                    'total' => $inventory->deposit + $inventory->local + $inventory->public
                ]);
            }

            $order->ingredients()->wherePivot('code_operation', $order_dish->pivot->code_operation)->detach();

            $order->dishes()->wherePivot('code_operation', $request->code_operation)->detach();
        }

        return $order->total_amount;
    }

    public function addDish(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $dish = Dish::find($request->dish_id);

        for ($i=1; $i <= $request->unit; $i++) { 

            do {
                $code_operation = mt_rand(100000000, 999999999);
                $validator = \Validator::make(
                  ['code_operation' => $code_operation],
                  ['code_operation' => 'unique:order_dish,code_operation']
                );
            } while ($validator->fails());

            $order_dish = $order->dishes()->attach( [ $order->id => 
                [
                    'code_operation'=> $code_operation,
                    'order_id' => $order->id,
                    'dish_id' => $request->dish_id,
                    'unit' => 1,          
                    'price' => number_format($dish->designated_price, 2, '.', ''),
                    'cost' => number_format($dish->cost_price, 2, '.', ''),
                ]
            ]);

            $dish = Dish::find($request->dish_id);

            foreach ($dish->ingredients()->get() as $key => $value) {
    
                $order->ingredients()->attach( [ $order->id => 
                    [
                        'order_id' => $order->id,
                        'code_operation'=> $code_operation,
                        'dish_id' => $dish->id,
                        'inventory_id' => $value->pivot->inventory_id,
                        'portion' => $value->pivot->portion,            
                        'designated_cost' => $value->pivot->designated_cost,
                        'it_has_flavors' => $value->product->it_has_flavors,
                    ]
                ]);
                $inventory = Inventory::where('id', $value->pivot->inventory_id)->first();
                $grams = $value->pivot->portion;
                $grams_used = $value->pivot->portion * 1;
                $units = $grams_used / 1000;
    
                $inventory->decrement('local', $units);
                $inventory->update([
                    'total' => $inventory->deposit + $inventory->local + $inventory->public
                ]);
            }
    
            $total_amount = $dish->designated_price;
    
            $order->increment('total_amount', number_format($total_amount, 2, '.', '') );
        }

        return $order->total_amount;
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

    public function modalModifyIngredients(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();

        $order_ingredients = $order->ingredients()->wherePivot('code_operation', $request->code_operation)->get();

        $order_dish= $order->dishes()->wherePivot('code_operation', $request->code_operation)->first();

        $ingredients = Inventory::orderBy('id', 'DESC')->get();

        $dish = Dish::where('id', $request->dish_id)->first();

        $code_operation = $request->code_operation;

        return view('employee.dashboard.orders.modals.modify_ingredients')
            ->with('dish', $dish)
            ->with('order_ingredients', $order_ingredients)
            ->with('order_dish', $order_dish)
            ->with('ingredients', $ingredients)
            ->with('order', $order)
            ->with('code_operation', $code_operation)
            ->render();
    }

    public function addIngredientsOrder(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $inventory = Inventory::where('id', $request->inventory_id)->first();
        $dish = Dish::where('id', $request->dish_id)->first();

        $cost = $inventory->cost;
        $gr = $inventory->product->gr;
        $cost_ingredient = number_format( ($request->portion * $cost) / $gr, 2, '.', '');

        $order_ingredient = $order->ingredients()->attach( [ $order->id => 
            [
                'order_id' => $order->id,
                'code_operation' => $request->code_operation,
                'dish_id' => $request->dish_id,
                'inventory_id' => $request->inventory_id,
                'portion' => $request->portion,            
                'designated_cost' => $cost_ingredient,
                'flavor_name' => $inventory->flavor_name,
                'it_has_flavors' => $inventory->product->it_has_flavors,
            ]
        ]);

        $order_dish = $order->dishes()->wherePivot('code_operation', $request->code_operation)->first();

        $inventory = Inventory::where('id', $request->inventory_id)->first();
        $grams = $request->portion;
        $grams_used = $request->portion * $order_dish->pivot->unit;
        $units = $grams_used / 1000;

        $inventory->decrement('local', $units);
        $inventory->update([
            'total' => $inventory->deposit + $inventory->local + $inventory->public
        ]);

        $order->calculatePriceDish($order, $request->code_operation, $dish);

        return $order;
    }

    public function updateIngredientsOrder(Request $request)
    {
        $fields = [
            'flavor_name' => ['required'],
        ];

        $msj = [
            'flavor_name.required' => 'El nombre del cliente es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $order = Order::where('id', $request->order_id)->first();

        $order->ingredients()->wherePivot('id', $request->id)->update([
            'order_ingredient.flavor_name' => $request->flavor_name,
        ]);
    }

    public function removeIngredientsOrder(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();

        $order_ingredient = $order->ingredients()->wherePivot('id', $request->pivot_id)->first();

        $code_operation = $order_ingredient->pivot->code_operation;

        $order_dish = $order->dishes()->wherePivot('code_operation', $code_operation)->first();

        $inventory = Inventory::where('id', $order_ingredient->pivot->inventory_id)->first();
        $grams = $order_ingredient->pivot->portion;
        $grams_used = $order_ingredient->pivot->portion * $order_dish->pivot->unit;
        $units = $grams_used / 1000;

        $inventory->increment('local', $units);
        $inventory->update([
            'total' => $inventory->deposit + $inventory->local + $inventory->public
        ]);

        $order->ingredients()->wherePivot('id', $request->pivot_id)->detach();
        $dish = Dish::where('id', $request->dish_id)->first();

        $order->calculatePriceDish($order, $code_operation, $dish);
    }

    public function orderDishesTableData(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();

        $ingredients = $order->dishes;
            
        return Datatables::of($ingredients)->filter(function ($query) use($request) {
        }, true)
        ->addColumn('details', function ($ingredients) use($order) {
            if ($order->productRequiresFlavor($order->id, $ingredients->pivot->id) == true) {
                return '<span class="text-danger"><i data-feather="edit"></i> </span>
                Se debe agregar el sabor a uno de los ingredientes de este plato.';
            }else{
                return '<span class="text-center text-primary"> ---- </span>';
            }
        })
        ->toJson();
    }

    public function checkOrderIngredients($id)
    {
        $order = Order::where('id', $id)->first();

        $ingredients = $order->ingredients()->get();

        $validate = true;

        foreach ($ingredients as $key => $item) {
            if ($item->pivot->it_has_flavors == true && $item->pivot->flavor_name == null) {
                $validate = false;
            }
        }

        if ($validate == false) {
            return redirect()->route('order.additional.modifications', $order->id)->with('danger', 'Hay Platos aún con Detalles (Debe agregarle los sabores correspondientes en los ingredientes a los platos con Detalles Pendientes)');
        }else{
            return redirect()->route('dashboard-employee');
        }
        
    }
}
