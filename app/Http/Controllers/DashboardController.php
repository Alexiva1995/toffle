<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Inventory;
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

    $tables = Order::select('table')->whereIn('status', ['0', '1'])->groupBy('table')->get();

    $inventories = Inventory::all();

    return view('admin.dashboard.index', ['pageConfigs' => $pageConfigs])
      ->with('tables', $tables)
      ->with('inventories', $inventories)
      ->with('orders', $orders);
  }

  public function dashboarEmployee()
  {
    $pageConfigs = ['pageHeader' => false];

    $orders = Order::all();

    $dishes = Dish::all();

    $tables = Order::select('table')->whereIn('status', ['0', '1'])->groupBy('table')->get();

    $inventories = Inventory::all();

    return view('employee.dashboard.index', ['pageConfigs' => $pageConfigs])
      ->with('tables', $tables)
      ->with('inventories', $inventories)
      ->with('dishes', $dishes)
      ->with('orders', $orders);
  }

  public function dataChartAmountVsGain() {
    $orders = Order::where('status', '2')->get();
 
    return response()->json([
        'data' => $orders
    ]);
 }
}
