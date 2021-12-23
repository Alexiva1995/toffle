<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    return view('admin.dashboard.index', ['pageConfigs' => $pageConfigs]);
  }

  public function dashboarEmployee()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('employee.dashboard.index', ['pageConfigs' => $pageConfigs]);
  }
}
