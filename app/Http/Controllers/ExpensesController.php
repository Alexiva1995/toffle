<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use DataTables;
use Carbon\Carbon;


class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.expenses.create');
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
            'amount' => ['required'],
            'description' => ['required'],
        ];

        $msj = [
            'amount.required' => 'El monto es requerido.',
            'description.required' => 'La descripción es requerida.',
        ];

        $this->validate($request, $fields, $msj);

        $expense = Expense::create($request->all());

        return redirect()->route('expenses.list')->with('success', 'Gasto Añadido');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $date = $id;

        $expense_details = Expense::selectRaw('DATE(created_at) as date, sum(amount) as amount')
            ->whereDate('created_at', $date)
            ->groupBy('date')
            ->first();

        $expenses = Expense::whereDate('created_at', $date)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.expenses.show')
            ->with('expense_details', $expense_details)
            ->with('expenses', $expenses);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function list()
    {
        return view('admin.expenses.list');
    }

    public function data(Request $request)
    {
        $expenses = Expense::selectRaw('DATE(created_at) as date, sum(amount) as amount')
        ->orderBy('date', 'DESC')
        ->groupBy('date');
            
        return Datatables::of($expenses)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('created_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }
        }, true)
        ->addColumn('day_at_timezone', function (Expense $expenses) {
            return $expenses->getDay($expenses->date);
        })
        ->addColumn('created_at_timezone', function (Expense $expenses) {
            return $expenses->created_at_timezone;
        })
        ->toJson();
    }
}
