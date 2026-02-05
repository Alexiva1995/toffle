<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Inventory;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use stdClass;

class OrdersController extends Controller
{
    public function index(Request $request, ?string $type = null): View
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

    public function flowDays(Request $request): View
    {
        return $this->index($request, 'flow_days');
    }

    public function create(): View
    {
        $dish_category = Dish::select('category_id')->distinct()->get();

        return view('employee.dashboard.orders.create')
            ->with('dish_category', $dish_category);
    }

    public function store(Request $request): RedirectResponse
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

    public function modifyDishes(Request $request, int $order_id): View
    {
        $order = Order::find($order_id);

        $dish_category = Dish::select('category_id')->distinct()->get();

        return view('employee.dashboard.orders.partials.modify_dishes')
            ->with('dish_category', $dish_category)
            ->with('order', $order);
    }

    public function show(int $id): void
    {
        //
    }

    public function edit(int $id): View
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

    public function update(Request $request, int $id): mixed
    {
        if ($request->ajax()) {
            $order = Order::find($id);

            if ($request->form == 'update_general_data') {
                $order_ingredients = DB::table('order_ingredient')->where('order_id', $order->id)->get();
                foreach($order_ingredients as $ingredient)
                {
                    if($ingredient->it_has_flavors == 1 && $ingredient->flavor_name == null)
                    {
                        $response = new stdClass;
                        $response->error = true;
                        $response->message = 'Esta orden tiene ingredientes con sabores sin definir';
                        return $response;
                    }
                }
                $this->updateGeneralData($request, $order);
            }

            if ($request->form == 'update_order_dish') {
                $this->updateDishOrder($request, $order);
            }
        }

        return $order;
    }

    public function updateGeneralData(Request $request, Order $order): void
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

        if ($request->status == '3') {
            $order_dishes = $order->dishes()->get();

            if ($order_dishes->isNotEmpty()) {
                foreach ($order_dishes as $key => $order_dish) {

                    $order_ingredients = $order->ingredients()->wherePivot('code_operation', $order_dish->pivot->code_operation)->get();

                    foreach ($order_ingredients as $key => $value) {

                        $inventory = Inventory::where('id', $value->pivot->inventory_id)->first();
                        if (!$inventory || !$inventory->product) {
                            continue;
                        }
                        $gr = (float) $inventory->product->gr;
                        if ($gr <= 0) {
                            continue;
                        }
                        $grams_used = $value->pivot->portion * $order_dish->pivot->unit;
                        $units = $grams_used / $gr;

                        $inventory->increment('local', $units);
                        $inventory->update([
                            'total' => $inventory->deposit + $inventory->local + $inventory->public
                        ]);
                    }

                }
            }
        }
        if($request->status == '2') {
            $order_ingredients = DB::table('order_ingredient')->where('order_id', $order->id)->get();
            foreach($order_ingredients as $ingredient)
            {
                if($ingredient->it_has_flavors == 1)
                {
                    $item_base = Inventory::find($ingredient->inventory_id);

                    $item = Inventory::where('product_id', $item_base->product_id)
                                             ->where('flavor_name',$ingredient->flavor_name)
                                             ->first();
                                             $item->local -= $ingredient->portion;
                                             $item->save();
                }
            }
        }

        $order->update($request->only($order->getFillable()));
    }

    public function updateDishOrder(Request $request, Order $order): void
    {
        if ($request->is_for_carry != null) {
            $order->dishes()->wherePivot('id', $request->id)->update([
                'is_for_carry' => $request->is_for_carry,
            ]);
        }
    }

    public function destroy(int $id): void
    {
        //
    }

    public function removeDish(Request $request, int $order_id): float
    {
        $order = Order::find($order_id);

        $order_dish = $order->dishes()->wherePivot('code_operation', $request->code_operation)->first();

        if ($order_dish != null) {

            $order->update([
                'total_amount' => $order->total_amount - $order_dish->pivot->price
            ]);

            if ($order->total_amount < 0) {
                $order->update([
                    'total_amount' => 0
                ]);
            }

            $order_ingredients = $order->ingredients()->wherePivot('code_operation', $order_dish->pivot->code_operation)->get();

            foreach ($order_ingredients as $key => $value) {

                $inventory = Inventory::where('id', $value->pivot->inventory_id)->first();
                $grams_used = $value->pivot->portion * $order_dish->pivot->unit;
                $product_quantity = $inventory->product->gr != null ? $inventory->product->gr : $inventory->product->quantity;
                $units = $grams_used / $product_quantity;
                // Si el producto base es distinto a un helado no se suma ya que no se resto.
                if($inventory->product_id != 75) {
                    $inventory->increment('local', $units);
                }
                // $inventory->update([
                //     'total' => $inventory->deposit + $inventory->local + $inventory->public
                // ]);
            }

            $order->ingredients()->wherePivot('code_operation', $request->code_operation)->detach();

            $order->dishes()->wherePivot('code_operation', $request->code_operation)->detach();
        }

        return (float) $order->total_amount;
    }

    public function addDish(Request $request, int $order_id): mixed
    {
        $request->validate(['dish_id' => 'required|exists:dishes,id', 'unit' => 'required|integer|min:1']);

        $order = Order::findOrFail($order_id);
        $dish = Dish::findOrFail($request->dish_id);

        // 🚀 LÍNEA AGREGADA: Obtener y formatear el valor CPV del plato
        // Usamos null coalescing (??) por si $dish->cpv es nulo, para evitar errores
        $cpv_value = number_format($dish->cpv ?? 0, 2, '.', '');

        for ($i=1; $i <= $request->unit; $i++) {

            do {
                $code_operation = mt_rand(100000000, 999999999);
                $validator = \Validator::make(
                    ['code_operation' => $code_operation],
                    ['code_operation' => 'unique:order_dish,code_operation']
                );
            } while ($validator->fails());

            $order->dishes()->attach( [ (int) $request->dish_id => [
                'code_operation' => $code_operation,
                'order_id' => $order->id,
                'dish_id' => $request->dish_id,
                'unit' => 1,
                'price' => number_format($dish->designated_price, 2, '.', ''),
                'cost' => number_format($dish->cost_price, 2, '.', ''),
                'cpv_value' => $cpv_value,
            ] ]);

            foreach ($dish->ingredients()->get() as $key => $value) {
                $inventory_id = $value->pivot->inventory_id;
                $order->ingredients()->attach( [ $inventory_id => [
                    'order_id' => $order->id,
                    'code_operation' => $code_operation,
                    'dish_id' => $dish->id,
                    'portion' => $value->pivot->portion,
                    'designated_cost' => $value->pivot->designated_cost,
                    'it_has_flavors' => $value->product->it_has_flavors,
                ] ]);
                $inventory = Inventory::where('id', $value->pivot->inventory_id)->first();
                $grams_used = $value->pivot->portion * 1;
                $product_quantity = $inventory->product->gr != null ? $inventory->product->gr : $inventory->product->quantity;
                $units = $grams_used / $product_quantity ;
                // Si el producto base es diferente a un helado se resta al momento.
                if($inventory->product_id != 75) {
                    $inventory->decrement('local', $units);
                }
                // $inventory->update([
                //     'total' => $inventory->deposit + $inventory->local + $inventory->public
                // ]);
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
            ->orderBy('id', 'DESC')->whereDate( 'created_at', now()->today() );
        }else{
            $orders = Order::orderBy('id', 'DESC')->whereDate( 'created_at', now()->today() );
        }


        return datatables()::of($orders)->filter(function ($query) use($request) {
        }, true)->toJson();
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

        $ingredients = Inventory::orderBy('id', 'DESC')
                                         ->where('local', '>', 0)
                                         ->get();

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
        $grams_used = $request->portion * $order_dish->pivot->unit;
        $units = $grams_used / $inventory->product->gr;

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
        $grams_used = $order_ingredient->pivot->portion * $order_dish->pivot->unit;
        $product_quantity = $inventory->product->gr != null ? $inventory->product->gr : $inventory->product->quantity;
        $units = $grams_used / $product_quantity;

        $inventory->increment('local', $units);
        $inventory->update([
            'total' => $inventory->deposit + $inventory->local + $inventory->public
        ]);

        $order->ingredients()->wherePivot('id', $request->pivot_id)->detach();
        $dish = Dish::where('id', $request->dish_id)->first();

        $order->calculatePriceDish($order, $code_operation, $dish);

        return $order;
    }

    public function orderDishesTableData(Request $request, $id)
    {
        try {
            $order = Order::where('id', $id)->with('dishes')->first();

            if (! $order) {
                return response()->json(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
            }

            $data = $order->dishes->map(function ($dish) {
                return [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'pivot' => [
                        'id' => $dish->pivot->id,
                        'order_id' => $dish->pivot->order_id,
                        'dish_id' => $dish->pivot->dish_id,
                        'code_operation' => $dish->pivot->code_operation,
                        'unit' => (int) $dish->pivot->unit,
                        'price' => (float) $dish->pivot->price,
                    ],
                ];
            })->values()->all();

            return response()->json([
                'data' => $data,
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data),
            ]);
        } catch (\Throwable $e) {
            \Log::error('orderDishesTableData: ' . $e->getMessage(), ['id' => $id, 'trace' => $e->getTraceAsString()]);
            return response()->json(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
        }
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
