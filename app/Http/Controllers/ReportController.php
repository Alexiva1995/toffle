<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Expense;
use App\Models\Order;

use Illuminate\Http\Request;

class ReportController extends Controller
{

    //Permite  obtener el listado de informes
    public function index()
    {
        $reports = Report::orderBy('id', 'desc')->get();

        return view('admin.reports.index', compact('reports'));
    }

    //permite obtener el listado de informes de ganancias
    public function gain()
    {

        return view('admin.reports.gain');
    }
    //Permite obtener el llistado de informes de Gastos
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
}
