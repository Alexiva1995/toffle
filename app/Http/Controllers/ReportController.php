<?php

namespace App\Http\Controllers;


use App\Models\Expense;
use App\Models\Order;
use App\Models\Dish;

class ReportController extends Controller
{
    //Permite  obtener el listado de los productos mas vendidos
    public function BestSeller()
    {
        $dishes = Dish::all();

        return view('admin.reports.bestSeller',compact('dishes'));
    }

    //permite obtener el listado de informes de ganancias
    public function gain()
    {
        $dishes = Dish::all();

        return view('admin.reports.gain',compact('dishes'));
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
        $profit = Order::where('status', '=', '2')->sum('total_amount');

        $discharge = expense::
        selectRaw('SUM(amount) as expense')
        ->selectRaw('created_at as date')->groupBy('date')->get();
        
        $income = Order::
        selectRaw('SUM(total_amount) as gain')
        ->selectRaw('created_at as date')->groupBy('date')->get();

        return view('admin.reports.cashflow', compact('income','profit', 'discharge'));
    }
}
