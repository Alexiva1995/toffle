<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Category;
use DataTables;
use Carbon\Carbon;
use Session;


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
        $categories = Category::all();
        return view('admin.expenses.create')
            ->with('categories', $categories);
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
            'category_id' => ['required'],
            'description' => ['required'],
            'status' => ['required'],
        ];

        $msj = [
            'amount.required' => 'El monto es requerido.',
            'category_id.required' => 'La categoría es requerida.',
            'status.required' => 'El Estado es requerido.',
            'description.required' => 'La descripción es requerida.',
        ];

        $this->validate($request, $fields, $msj);

        $expense = Expense::create($request->all());

        if ($request->status == '0') {
            return redirect()->route('expenses.list.to.pay')->with('success', 'Gasto Añadido');
        }else{
            return redirect()->route('expenses.list.historical')->with('success', 'Gasto Añadido');
        }
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

        $expense_details = Expense::selectRaw('DATE(updated_at) as date')
        ->whereDate('updated_at', $date)
        ->groupBy('date')
        ->first();

        if ($expense_details == null) {
            return redirect()->route('expenses.list.historical');
        }

        $expenses = Expense::whereDate('updated_at', $date)
            ->orderBy('updated_at', 'ASC')
            ->get();

        $categories = Category::all();

        return view('admin.expenses.show')
            ->with('categories', $categories)
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
        $expense = Expense::find($id);

        $fields = [
            'amount' => ['required'],
            'category_id' => ['required'],
            'description' => ['required'],
        ];

        $msj = [
            'amount.required' => 'El monto es requerido.',
            'category_id.required' => 'La categorá es requerida.',
            'description.required' => 'La descripción es requerida.',
        ];

        $this->validate($request, $fields, $msj);

        $expense->update($request->all());
        
        if ($request->type == 'to_pay') {
            return redirect()->route('expenses.list.to.pay')->with('success', 'Gasto Actualizado');
        }

        if ($request->type == 'paid_out') {   
            return redirect()->route('expenses.show', date('Y-m-d', strtotime($expense->updated_at)) )->with('success', 'Gasto Actualizado');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $expense = Expense::find($id);

        $expense->delete();

        if ($request->status == 'to_pay') {
            return redirect()->route('expenses.list.to.pay')->with('success', 'Gasto Eliminado');
        }

        if ($request->status == 'paid_out') {   
            return redirect()->route('expenses.show', date('Y-m-d', strtotime($expense->updated_at)) )->with('success', 'Gasto Eliminado');
        }

    }

    public function listHistorical()
    {
        return view('admin.expenses.list_historical');
    }

    public function listToPay()
    {
        $expenses = Expense::where("status", '0')
        ->orderBy('created_at', 'ASC')
        ->get();

        $categories = Category::all();

        return view('admin.expenses.list_to_pay')
            ->with('categories', $categories)
            ->with('expenses', $expenses);
    }

    public function data(Request $request)
    {
        $expenses = Expense::where('status', '1')->selectRaw('DATE(updated_at) as updated_at,
        sum(amount) as amount')
        ->orderBy('updated_at', 'DESC')
        ->groupBy('updated_at');
            
        return Datatables::of($expenses)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }
        }, true)
        ->addColumn('day_at_timezone', function (Expense $expenses) {
            return $expenses->getDay($expenses->updated_at);
        })
        ->addColumn('updated_at_timezone', function (Expense $expenses) {
            return $expenses->updated_at_timezone;
        })
        ->toJson();
    }
}
