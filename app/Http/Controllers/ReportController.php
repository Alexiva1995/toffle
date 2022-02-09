<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Category;
use DataTables;

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
        ->where('orders.status', '2')
        ->orderBy('units', 'DESC')
        ->groupBy('name_dish', 'category_id');
            
        return Datatables::of($best_sellers)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('orders.updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }

            if(request()->has('category_id') && request('category_id')!= ''){
                $query->where('category_id', request('category_id'));
            }
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
        $gains = Order::selectRaw('ROUND( (b.price - b.cost) * b.unit, 2 ) as gain')
        ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
        ->where('orders.status', '2')
        ->get();

        $profit_total = $gains->sum('gain');

        return view('admin.reports.gain')
            ->with('profit_total', $profit_total);
    }

    public function gainData(Request $request)
    {
        $month_start = date('Y-m-d', strtotime('first day of this month', time()));
        $month_end = date('Y-m-d', strtotime('last day of this month', time()));

        $gains = Order::selectRaw('DATE(orders.updated_at) as updated_at')
            ->selectRaw('SUM(ROUND(orders.total_amount, 2)) as total_amount')
            ->selectRaw('SUM(ROUND( (b.price - b.cost) * b.unit, 2 )) as gain')
            ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
            ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
            ->where('orders.status', '2')
            ->orderBy('updated_at', 'DESC')
            ->groupBy('updated_at');
            
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

    //Permite obtener el listado de informes de Ventas
    public function sales()
    {
        $categories = Category::all();
        $capital_available = Order::where('status', '2')->sum('total_amount');

        return view('admin.reports.sales')
        ->with('categories', $categories)
        ->with('capital_available', $capital_available);
    }

    public function salesData(Request $request)
    {
        $sales = Order::orderBy('id', 'DESC');
            
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
