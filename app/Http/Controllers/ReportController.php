<?php

namespace App\Http\Controllers;


use App\Models\Expense;
use App\Models\Order;
use App\Models\Dish;

use Illuminate\Http\Request;

class ReportController extends Controller
{

    //Permite  obtener el listado de los productos mas vendidos
    public function BestSeller()
    {
        $dishes = Dish::select(\DB::raw('COUNT(category_id) as cantidad'), 'category_id')->groupBy('category_id')->get();
        return view('admin.reports.BestSeller',compact('dishes'));
    }

    //permite obtener el listado de informes de ganancias
    public function gain()
    {


        return view('admin.reports.gain');
    }

    //Permite obtener el listado de informes de Gastos
    public function expenses()
    {
        $expenses = Expense::orderBy('id', 'desc')->get();

        return view('admin.reports.expenses', compact('expenses'));
    }

    //Permite obtener el listado de informes de Ventas
    public function sales()
    {
        $orders = Order::orderBy('id', 'desc')->get();

        return view('admin.reports.sales', compact('orders'));
    }

    //premite obtener el listado de informes del flujo de caja
    public function cashflow()
    {
        $order = Order::where('status', '=', '2')->orderBy('id', 'desc')->get();
        $expenses = expense::where('status', '=', '1')->orderBy('id', 'desc')->get();

        $capitalDisponible = Order::where('status', '=', '2')->sum('total_amount');

        return view('admin.reports.cashflow', compact('order','capitalDisponible', 'expenses'));
    }
}
