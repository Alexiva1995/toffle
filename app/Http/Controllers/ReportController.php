<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Category;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    //Permite  obtener el listado de los productos mas vendidos
    public function bestSeller()
    {
        $categories = Category::all();

        return view('admin.reports.best_seller')
            ->with('categories', $categories);
    }

    public function bestSellerData(Request $request)
    {
        $best_sellers = Order::selectRaw('c.name as name_dish')
        ->selectRaw('c.category_id as category_id')
        ->selectRaw('SUM(b.unit) as units')
        ->selectRaw('SUM( ROUND( (b.price - b.cost) * b.unit, 2 ) ) as gain')
        ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
        ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
        ->where('orders.status', '2');
            
        return DataTables::of($best_sellers)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('orders.updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }

            if(request()->has('category_id') && request('category_id')!= ''){
                $query->where('category_id', request('category_id'));
            }

            if(request()->has('order_by_for') && request('order_by_for') == 'units'){
                $query->orderBy('units', 'DESC');
            }
            if(request()->has('order_by_for') && request('order_by_for') == 'gain'){
                $query->orderBy('gain', 'DESC');
            }
            $query->groupBy('name_dish', 'category_id');
        }, true)
        ->addColumn('category_name', function (Order $best_sellers) {
            $category = Category::where('id', $best_sellers->category_id)->first();
            return $category->name;
        })
        ->toJson();
    }

    //permite obtener el listado de informes de ganancias
    public function gain()
    {
        // $gains = Order::selectRaw('ROUND( (order_dish.price - order_dish.cost) * order_dish.unit, 2 ) as gain')
        // ->leftJoin('order_dish', 'orders.id', '=', 'order_dish.order_id')
        // ->where('orders.status', '2')
        // ->get();
        // $profit_total = $gains->sum('gain');
        $month_start = date('Y-m-d', strtotime('first day of this month', time()));
        $month_end = date('Y-m-d', strtotime('last day of this month', time()));

        // $gains = Order::selectRaw('DATE(orders.updated_at) as updated_at')
        //     ->selectRaw('ROUND(orders.total_amount, 2) as total_amount')
        //     ->selectRaw('SUM(ROUND( (b.price - b.cost) * b.unit, 2 )) as gain')
        //     ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
        //     ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
        //     ->where('orders.status', '2')
        //     ->orderBy('updated_at', 'DESC')
        //     ->whereBetween('orders.updated_at', [$month_start. " 00:00:00", $month_end. " 23:59:59"])
        //     ->groupBy('updated_at', 'total_amount')->get();

        // return $gains;

        return view('admin.reports.gain');
    }

    public function gainData(Request $request)
    {
        $month_start = date('Y-m-d', strtotime('first day of this month', time()));
        $month_end = date('Y-m-d', strtotime('last day of this month', time()));

        $gains = Order::selectRaw('DATE(orders.updated_at) as updated_at')
            ->selectRaw('ROUND(orders.total_amount, 2) as total_amount')
            ->selectRaw('SUM(ROUND( (b.price - b.cost) * b.unit, 2 )) as gain')
            ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
            ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
            ->where('orders.status', '2')
            ->orderBy('updated_at', 'DESC')
            ->groupBy('updated_at', 'total_amount');
            
        if ( ( request()->has('from') && request('from') == '' ) || ( request('to') == '' && request()->has('to') ) ) {
            $gains->whereBetween('orders.updated_at', [$month_start. " 00:00:00", $month_end. " 23:59:59"]);
        }

        return Datatables::of($gains)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('orders.updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }
        }, true)
        ->addColumn('day_at_timezone', function (Order $gains) {
            return $gains->getDay($gains->updated_at);
        })
        ->addColumn('updated_at_timezone', function (Order $gains) {
            return $gains->updated_at_timezone;
        })
        ->toJson();
    }
    //Obtiene la Ganancia neta de la vista reports->gain
    //Y para el cuadro ganancias en flujo de caja
    public function gainAmount(Request $request)
    {
        if ( request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '' ) 
        {
            //Busca entre fechas
            $start = date("Y-m-d",strtotime(request('from')));
            $end = date("Y-m-d",strtotime(request('to')));

            $gains = Order::selectRaw('ROUND( (order_dish.price - order_dish.cost) * order_dish.unit, 2 ) as gain')
                ->leftJoin('order_dish', 'orders.id', '=', 'order_dish.order_id')
                ->where('orders.status', '2')
                ->whereBetween( 'orders.updated_at',[ $start. " 00:00:00", $end. " 23:59:59" ] )
                ->get();
                            
            $profit_total = $gains->sum('gain');
        }
        else
        {
            //Obtiene el mensual por defecto
            $month_start = date('Y-m-d', strtotime('first day of this month', time()));
            $month_end = date('Y-m-d', strtotime('last day of this month', time()));
            
            $gains = Order::selectRaw('ROUND( (order_dish.price - order_dish.cost) * order_dish.unit, 2 ) as gain')
                ->leftJoin('order_dish', 'orders.id', '=', 'order_dish.order_id')
                ->where('orders.status', '2')
                ->whereBetween('orders.updated_at', [$month_start. " 00:00:00", $month_end. " 23:59:59"])
                ->get();
                            
            $profit_total = $gains->sum('gain');
        }
        return number_format($profit_total, 2, ',', '.');
    }

    public function totalBalance()
    {
        $profits = Order::where('status', '2')->sum('total_amount');
        
        // $profits = Order::selectRaw('ROUND( (order_dish.price - order_dish.cost) * order_dish.unit, 2 ) as gain')
        //         ->leftJoin('order_dish', 'orders.id', '=', 'order_dish.order_id')
        //         ->where('orders.status', '2')
        //         ->sum('total_amount');

        $expenses = Expense::sum('amount');
        $total = $profits - $expenses;         
        return number_format($total, 2, ',', '.');
    }
    //Costo fijo para Ganancias
    public function gainFixedCost(Request $request)
    {
        if ( request()->has('from') && request('from')!= '' && request()->has('to') !='' && request('to') ) 
        {
            $start = date("Y-m-d",strtotime(request('from')));
            $end = date("Y-m-d",strtotime(request('to')));

            //Obtener el costo fijo (product_id 83) acumulado entre fechas
            $costo_fijo = Order::selectRaw('SUM(order_ingredient.designated_cost) as cost')
            ->leftJoin('order_ingredient', 'orders.id', '=', 'order_ingredient.order_id')
            ->leftJoin('inventories', 'order_ingredient.inventory_id', '=', 'inventories.id')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->where('orders.status', '2')
            ->whereBetween( 'orders.updated_at',[ $start. " 00:00:00", $end. " 23:59:59" ] )
            ->where('products.id', '=', 83)
            ->groupBy(['products.name'])->first('cost');

            $costo_fijo = $costo_fijo->cost;
            $costo_fijo = number_format($costo_fijo, 2, ',', '.');

            return $costo_fijo;
        }
        else
        {
            //Obtiene el mensual por defecto
            $month_start = date('Y-m-d', strtotime('first day of this month', time()));
            $month_end = date('Y-m-d', strtotime('last day of this month', time()));

            $costo_fijo = Order::selectRaw('SUM(order_ingredient.designated_cost) as cost')
            ->leftJoin('order_ingredient', 'orders.id', '=', 'order_ingredient.order_id')
            ->leftJoin('inventories', 'order_ingredient.inventory_id', '=', 'inventories.id')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->where('orders.status', '2')
            ->whereBetween('orders.updated_at', [$month_start. " 00:00:00", $month_end. " 23:59:59"])
            ->where('products.id', '=', 83)
            ->groupBy(['products.name'])->first('cost');

            $costo_fijo = $costo_fijo->cost;
            $costo_fijo = number_format($costo_fijo, 2, ',', '.');

            return $costo_fijo;
        }
    }
    // Obtener el imprevisto para Reportes -> Ganancias
    public function gainUnexpected(Request $request)
    {
        if ( request()->has('from') && request('from')!= '' && request()->has('to') !='' && request('to') ) 
        {
            $start = date("Y-m-d",strtotime(request('from')));
            $end = date("Y-m-d",strtotime(request('to')));

            //Obtener el imprevisto (product_id 93) acumulado entre fechas
            $costo_fijo = Order::selectRaw('SUM(order_ingredient.designated_cost) as cost')
            ->leftJoin('order_ingredient', 'orders.id', '=', 'order_ingredient.order_id')
            ->leftJoin('inventories', 'order_ingredient.inventory_id', '=', 'inventories.id')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->where('orders.status', '2')
            ->whereBetween( 'orders.updated_at',[ $start. " 00:00:00", $end. " 23:59:59" ] )
            ->where('products.id', '=', 93)
            ->groupBy(['products.name'])->first('cost');

            $costo_fijo = $costo_fijo->cost;
            $costo_fijo = number_format($costo_fijo, 2, ',', '.');

            return $costo_fijo;
        }
        else
        {
            //Obtiene el mensual por defecto
            //Obtener el imprevisto (product_id 93) acumulado de todas las ventas
            $month_start = date('Y-m-d', strtotime('first day of this month', time()));
            $month_end = date('Y-m-d', strtotime('last day of this month', time()));

            $costo_fijo = Order::selectRaw('SUM(order_ingredient.designated_cost) as cost')
            ->leftJoin('order_ingredient', 'orders.id', '=', 'order_ingredient.order_id')
            ->leftJoin('inventories', 'order_ingredient.inventory_id', '=', 'inventories.id')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->where('orders.status', '2')
            ->where('products.id', '=', 93)
            ->whereBetween('orders.updated_at', [$month_start. " 00:00:00", $month_end. " 23:59:59"])
            ->groupBy(['products.name'])->first('cost');

            $costo_fijo = $costo_fijo->cost;
            $costo_fijo = number_format($costo_fijo, 2, ',', '.');

            return $costo_fijo;
        }
    }

    public function gainShow($date)
    {
        $gain_details = Order::selectRaw('DATE(orders.updated_at) as updated_at')
            ->selectRaw('SUM( ROUND(orders.total_amount, 2) ) as total_amount')
            ->selectRaw('SUM( ROUND( (b.price - b.cost) * b.unit, 2 ) ) as gain')
            ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
            ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
            ->where('orders.status', '2')
            ->whereDate('orders.updated_at', $date)
            ->groupBy('updated_at')
            ->first();

        if ($gain_details == null) {
            return redirect()->route('reports.gain');
        }

        $categories = Category::all();

        return view('admin.reports.gain_show')
            ->with('categories', $categories)
            ->with('gain_details', $gain_details);
    }

    public function gainDataShow(Request $request, $date)
    {
        $gain_dishes = Order::selectRaw('orders.id as order_id')
            ->selectRaw('c.name as name_dish')
            ->selectRaw('b.unit as units')
            ->selectRaw('c.category_id as category_id')
            ->selectRaw('ROUND(b.price * b.unit, 2) as total_amount')
            ->selectRaw('ROUND( (b.price - b.cost) * b.unit, 2 ) as gain')
            ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
            ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
            ->whereDate('orders.updated_at', $date)
            ->where('orders.status', '2')
            ->orderBy('orders.id', 'DESC');
            
        return Datatables::of($gain_dishes)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('orders.updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }

            if(request()->has('category_id') && request('category_id')!= ''){
                $query->where('category_id', request('category_id'));
            }
        }, true)
        ->addColumn('category_name', function (Order $gain_dishes) {
            $category = Category::where('id', $gain_dishes->category_id)->first();
            return $category->name;
        })
        ->toJson();
    }

    //Permite obtener el listado de informes de Gastos
    public function expenses()
    {
        $categories = Category::all();

        return view('admin.reports.expenses')
            ->with('categories', $categories);
    }

    public function expensesData(Request $request, $status = null)
    {
        $month_start = date('Y-m-d', strtotime('first day of this month', time()));
        $month_end = date('Y-m-d', strtotime('last day of this month', time()));
        
        switch ($status) {
            case '1':
                $expenses = Expense::with('category')
                    ->where('status', $status)
                    ->orderBy('updated_at', 'DESC');
                break; 
            default:
                $expenses = Expense::with('category')
                ->orderBy('updated_at', 'DESC');
                break;
        }

        if ( ( request()->has('from') && request('from') == '' ) || ( request('to') == '' && request()->has('to') ) ) {
            $expenses->whereBetween('updated_at', [$month_start. " 00:00:00", $month_end. " 23:59:59"]);
        }
            
        return Datatables::of($expenses)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);    
            }

            if(request()->has('category_id') && request('category_id')!= ''){
                $query->where('category_id', request('category_id'));
            }

            if(request()->has('status') && request('status')!= ''){
                $query->where('status', request('status'));
            }
        }, true)
        ->addColumn('category_name', function (Expense $expenses) {
            return $expenses->category->name;
        })
        ->addColumn('updated_at_timezone', function (Expense $expenses) {
            return $expenses->updated_at_timezone;
        })
        ->toJson();
    }
    //Obtiene el total para el cuadro Ganancias de informes->Flujo de caja
    public function expensesTotalAmount()
    {
        
        if ( request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '' ) {
            $start = date("Y-m-d",strtotime(request('from')));
            $end = date("Y-m-d",strtotime(request('to')));
            $expenses_total_amount = Expense::whereBetween( 'expenses.updated_at',[ $start. " 00:00:00", $end. " 23:59:59" ] )->sum('amount');
        }
        else{
            $month_start = date('Y-m-d', strtotime('first day of this month', time()));
            $month_end = date('Y-m-d', strtotime('last day of this month', time()));
            $expenses_total_amount = Expense::whereBetween( 'expenses.updated_at',[ $month_start. " 00:00:00", $month_end. " 23:59:59" ] )->sum('amount');
        }

        return number_format($expenses_total_amount, 2, ',', '.');
    }

    //Permite obtener el listado de informes de Ventas
    public function sales()
    {
        $categories = Category::all();
        
        return view('admin.reports.sales', compact('categories'));
    }

    public function salesData(Request $request)
    {
        $sales = Order::whereStatus('2')->orderBy('id', 'DESC');
            
        return Datatables::of($sales)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('orders.updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }

            if(request()->has('category_id') && request('category_id')!= ''){
                $query->where('category_id', request('category_id'));
            }

            if(request()->has('status') && request('status')!= ''){
                $query->where('orders.status', request('status'));
            }
        }, true)
        // ->addColumn('category_name', function (Order $sales) {
        //     $category = Category::where('id', $sales->category_id)->first();
        //     return $category->name;
        // })
        ->addColumn('updated_at_timezone', function (Order $sales) {
            return $sales->updated_at_timezone;
        })
        ->toJson();
    }

    /*
     * Obtener el costo fijo para Ventas (Sales)
     */
    public function fixedCostAmount(Request $request)
    {
        if ( request()->has('from') && request('from')!= '' && request()->has('to') !='' && request('to') ) 
        {
            $start = date("Y-m-d",strtotime(request('from')));
            $end = date("Y-m-d",strtotime(request('to')));

            //Obtener el costo fijo (product_id 83) acumulado entre fechas
            $costo_fijo = Order::selectRaw('SUM(order_ingredient.designated_cost) as cost')
            ->leftJoin('order_ingredient', 'orders.id', '=', 'order_ingredient.order_id')
            ->leftJoin('inventories', 'order_ingredient.inventory_id', '=', 'inventories.id')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->where('orders.status', '2')
            ->whereBetween( 'orders.updated_at',[ $start. " 00:00:00", $end. " 23:59:59" ] )
            ->where('products.id', '=', 83)
            ->groupBy(['products.name'])->first('cost');

            $costo_fijo = $costo_fijo->cost;
            $costo_fijo = number_format($costo_fijo, 2, ',', '.');

            return $costo_fijo;
        }
        else
        {
            //Obtener el costo fijo (product_id 83) acumulado de todas las ventas
            $costo_fijo = Order::selectRaw('SUM(order_ingredient.designated_cost) as cost')
            ->leftJoin('order_ingredient', 'orders.id', '=', 'order_ingredient.order_id')
            ->leftJoin('inventories', 'order_ingredient.inventory_id', '=', 'inventories.id')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->where('orders.status', '2')
            ->where('products.id', '=', 83)
            ->groupBy(['products.name'])->first('cost');

            $costo_fijo = $costo_fijo->cost;
            $costo_fijo = number_format($costo_fijo, 2, ',', '.');

            return $costo_fijo;
        }
    }

    /*
     * Obtener el imprevisto para Reportes -> Ventas (Sales)
     */
    public function unexpectedAmount(Request $request)
    {
        if ( request()->has('from') && request('from')!= '' && request()->has('to') !='' && request('to') ) 
        {
            $start = date("Y-m-d",strtotime(request('from')));
            $end = date("Y-m-d",strtotime(request('to')));

            //Obtener el imprevisto (product_id 93) acumulado entre fechas
            $costo_fijo = Order::selectRaw('SUM(order_ingredient.designated_cost) as cost')
            ->leftJoin('order_ingredient', 'orders.id', '=', 'order_ingredient.order_id')
            ->leftJoin('inventories', 'order_ingredient.inventory_id', '=', 'inventories.id')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->where('orders.status', '2')
            ->whereBetween( 'orders.updated_at',[ $start. " 00:00:00", $end. " 23:59:59" ] )
            ->where('products.id', '=', 93)
            ->groupBy(['products.name'])->first('cost');

            $costo_fijo = $costo_fijo->cost;
            $costo_fijo = number_format($costo_fijo, 2, ',', '.');

            return $costo_fijo;
        }
        else
        {
            //Obtener el imprevisto (product_id 93) acumulado de todas las ventas
            $costo_fijo = Order::selectRaw('SUM(order_ingredient.designated_cost) as cost')
            ->leftJoin('order_ingredient', 'orders.id', '=', 'order_ingredient.order_id')
            ->leftJoin('inventories', 'order_ingredient.inventory_id', '=', 'inventories.id')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->where('orders.status', '2')
            ->where('products.id', '=', 93)
            ->groupBy(['products.name'])->first('cost');

            $costo_fijo = $costo_fijo->cost;
            $costo_fijo = number_format($costo_fijo, 2, ',', '.');

            return $costo_fijo;
        }
    }

    /*
     * Obtener el total de Ventas para Reportes -> ventas.
     */
    public function totalSalesAmount(Request $request)
    {
        if ( request()->has('from') && request('from')!= '' && request()->has('to') !='' && request('to') ) 
        {
            //Busca entre fechas
            $start = date("Y-m-d",strtotime(request('from')));
            $end = date("Y-m-d",strtotime(request('to')));
            $total_sales_amount = Order::where('status', '2')
                ->whereBetween( 'orders.updated_at',[ $start. " 00:00:00", $end. " 23:59:59" ] )
                ->sum('total_amount');
            $total_sales_amount = number_format($total_sales_amount, 2, ',', '.');

            return $total_sales_amount;
        }
        else
        {
            //Obtiene el general
            $total_sales_amount = Order::where('status', '2')->sum('total_amount');
            $total_sales_amount = number_format($total_sales_amount, 2, ',', '.');

            return $total_sales_amount;
        }
    }
    //premite obtener el listado de informes del flujo de caja
    public function cashFlow()
    {
        $income = Order::where('status', '2')->sum('total_amount');
        $expenses = Expense::where('status', '1')->sum('amount');
        $capital_available = $income - $expenses;

        $categories = Category::all();

        return view('admin.reports.cash_flow.index')
            ->with('categories', $categories)
            ->with('income', $income) 
            ->with('expenses', $expenses)
            ->with('capital_available', $capital_available);
    }
    //Obtiene el total de ventas para Flujo de caja
    public function salesTotal()
    {
        if ( request()->has('from') && request('from') != '' && request()->has('to') && request('to') !='') 
        {
            $start = date("Y-m-d",strtotime(request('from')));
            $end = date("Y-m-d",strtotime(request('to')));
            $orders_total = Order::where('status', '2')
                ->whereBetween('orders.updated_at',[$start. " 00:00:00", $end. " 23:59:59"])
                ->sum('total_amount');
        }
        else
        {
            $month_start = date('Y-m-d', strtotime('first day of this month', time()));
            $month_end = date('Y-m-d', strtotime('last day of this month', time()));
            $orders_total = Order::where('status', '2')
                ->whereBetween('orders.updated_at',[$month_start. " 00:00:00", $month_end. " 23:59:59"])
                ->sum('total_amount'); 
        }

        return number_format($orders_total, 2, ',', '.');
    }

    public function incomeData(Request $request)
    {
        $month_start = date('Y-m-d', strtotime('first day of this month', time()));
        $month_end = date('Y-m-d', strtotime('last day of this month', time()));

        $income = Order::select(
            'orders.id as order_id',
            'b.id as dish_id',
            'c.name as name_dish',
            'b.unit as units',
            'c.category_id as category_id',
            'orders.status as status',
            'orders.updated_at as updated_at'
            )
            ->selectRaw('ROUND(b.price, 2) * b.unit as total_amount')
            ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
            ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
            ->where('orders.status', '2')
            ->orderBy('b.id', 'DESC');

        if ( ( request()->has('from') && request('from') == '' ) || ( request('to') == '' && request()->has('to') ) ) {
            $income->whereBetween('orders.updated_at', [$month_start. " 00:00:00", $month_end. " 23:59:59"]);
        }

        return Datatables::of($income)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('orders.updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }

            if(request()->has('category_id') && request('category_id')!= ''){
                $query->where('category_id', request('category_id'));
            }

        }, true)
        ->addColumn('category_name', function (Order $income) {
            $category = Category::where('id', $income->category_id)->first();
            return $category->name;
        })
        ->addColumn('updated_at_timezone', function (Order $income) {
            return $income->updated_at_timezone;
        })
        ->toJson();
    }

}
