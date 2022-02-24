<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Inventory;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function dashboardAnalytics()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
  }

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
  }

  public function dashboard()
  {
    if (Auth::user()->role == 0) {
      return redirect()->route('dashboard-employee');
    }

    if (Auth::user()->role == 1) {
      return redirect()->route('dashboard-admin');
    }
  }

  public function dashboardAdmin()
  {
    $pageConfigs = ['pageHeader' => false];

    $orders = Order::all();

    $orders_today = Order::where('status', '2')->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

    $tables = Order::select('table')->whereIn('status', ['0', '1'])->groupBy('table')->get();

    $dishes_under_review = Dish::where('status', '2')
      ->whereColumn('suggested_price', '>','designated_price')
      ->get();

    $inventories = Inventory::all();

    return view('admin.dashboard.index', ['pageConfigs' => $pageConfigs])
      ->with('tables', $tables)
      ->with('inventories', $inventories)
      ->with('dishes_under_review', $dishes_under_review)
      ->with('orders_today', $orders_today)
      ->with('orders', $orders);
  }

  public function dashboarEmployee()
  {
    $pageConfigs = ['pageHeader' => false];

    // $orders = Order::all();

    // $tables = Order::select('table')->whereIn('status', ['0', '1'])->groupBy('table')->get();

    // $inventories = Inventory::all();

    return view('employee.dashboard.index', ['pageConfigs' => $pageConfigs]);
      // ->with('tables', $tables)
      // ->with('inventories', $inventories)
      // ->with('orders', $orders);
  }

  public function dataChartAmountVsGain() {
      $orders = Order::selectRaw('orders.created_at as date')
        ->selectRaw('ROUND(orders.total_amount, 2) as total_amount')
        ->selectRaw('ROUND( (b.price - b.cost) * b.unit, 2 ) as gain')
        ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
        // ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
        ->where('orders.status', '2')
        ->orderBy('date', 'ASC')
        ->get();

      return response()->json([
          'data' => $orders,
      ]);
 }

 
  public function dataChartWeeklySales(Request $request) {

      $dates = [];
      $dates_found = [];
      $dates_not_found = [];
      $array_dates_found = [];

      $year = substr($request->week, 0, -4);
      $week_number = substr($request->week, -2);
      $weekdays = $this->weekdays($year, $week_number);

      $custom_date = strtotime( date('Y-m-d', strtotime($request->week.'0')) );

      $week_start = date('Y-m-d', strtotime('this week sunday', $custom_date));
      $week_end = date('Y-m-d', strtotime('this week next saturday', $custom_date));

      $orders = Order::selectRaw('DATE(created_at) as date')
      ->selectRaw('sum(total_amount) as total_amount')
      ->where('status', '2')
      ->whereBetween('created_at', [$week_start. " 00:00:00", $week_end. " 23:59:59"])
      ->orderBy('date', 'DESC')
      ->groupBy('date')
      ->get();

      if ($orders != null) {
        foreach ($orders as $key => $order) {
          if (in_array($order->date, $weekdays)) {
             $array = array( $order->date => [
               'total_amount' => $order->total_amount,
               'date' => date('d', strtotime($order->date)).' '.$this->getDay($order->date),
             ]);
 
             $dates_found = array_merge($dates_found, $array);
 
             $array_dates = array($order->date);
             $array_dates_found = array_merge($array_dates_found, $array_dates);
          }
        }
      }

      foreach ($weekdays as $key => $weekday) {
        if (in_array($weekday, $array_dates_found)) {
        }else{
            $array = array( $weekday => [
              'total_amount' => 0,
              'date' => date('d', strtotime($weekday)).' '.$this->getDay($weekday),
            ]);

            $dates_not_found = array_merge($dates_not_found, $array);
        }
      }

      $dates = array_merge($dates, $dates_not_found, $dates_found);

      ksort($dates);

      $keys = array(0, 1, 2, 3, 4, 5, 6);
      
      $dates = array_combine($keys, $dates); 

      return response()->json([
          'dates' => $dates
      ]);
  }

  public function weekdays($year, $week_number) {

      $weekdays = [];
      $days = ['0', '1', '2', '3', '4', '5', '6'];
     
      foreach ($days as $key => $day) {
        $dates = array(date('Y-m-d', strtotime($year."W".$week_number.$day)));
          $weekdays = array_merge($weekdays, $dates) ;
      }

      return $weekdays;
 }

 public function getDay($date)
 {
     $days = array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
     return $days[date('N', strtotime($date)) - 1 ];
 }

 public function loadData(Request $request, $type)
 {
     switch ($type) {
         case 'statistics':
             $orders = Order::all();
             return view('employee.dashboard.orders.statistics')
                 ->with('orders', $orders)
                 ->render();
             break;
         case 'order_history':
             $orders = Order::all();
             return view('employee.dashboard.orders.history')
                 ->with('orders', $orders)
                 ->render();
             break;
         case 'tables':
             $tables = Order::select('table')->whereIn('status', ['0', '1'])->groupBy('table')->get();
             return view('employee.dashboard.table.list')
                 ->with('tables', $tables)
                 ->render();
             break;
         case 'cash_flow':
             $orders_today = Order::where('status', '2')->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
             return view('employee.dashboard.money_flow.list')
                 ->with('orders_today', $orders_today)
                 ->render();
             break;
         case 'inventory_replenishment':
             $inventories = Inventory::all();
             return view('employee.dashboard.inventory_reposition.list')
                 ->with('inventories', $inventories)
                 ->render();
             break;
         default:
             # code...
             break;
     }
 }
}
