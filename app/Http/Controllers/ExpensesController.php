<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Category;
use DataTables;
use Illuminate\Support\Facades\Auth;


class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Index para empleados
    public function index()
    {
        return view('employee.expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Obtiene las categorias de tipo 'Gastos'
        $categories = Category::where('type', 0)->get();
        if(Auth::user()->role == '0'){
            return view('employee.expenses.create')->with('categories', $categories);
        }
        return view('admin.expenses.create')->with('categories', $categories);
    }

    public function employeeCreate()
    {
        return view('employee.expenses.create');
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

        if ($request->status == '0' && Auth::user()->role == '1') {
            return redirect()->route('expenses.list.to.pay')->with('success', 'Gasto Añadido');
        }else{
            // Role 1 es admin
            if(Auth::user()->role == '1'){
                return redirect()->route('expenses.list.historical')->with('success', 'Gasto Añadido');
            }
            return redirect()->route('employee.expenses.index')->with('success', 'Gasto Añadido');
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
            ->with('category')
            ->orderBy('updated_at', 'ASC')
            ->get();

        $categories = Category::all();
        if(Auth::user()->role == '1'){
            return view('admin.expenses.show', compact('categories', 'expense_details', 'expenses'));
        }
        return view('employee.expenses.show', compact('categories', 'expense_details', 'expenses'));

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
            // return redirect()->route('expenses.list.to.pay')->with('success', 'Gasto Eliminado');
            return true;
        }

        if ($request->status == 'paid_out') {   
            return redirect()->route('expenses.show', date('Y-m-d', strtotime($expense->updated_at)) )->with('success', 'Gasto Eliminado');
        }

    }

    public function listHistorical()
    {
        return view('admin.expenses.list_historical');
    }

    public function listHistoricalData(Request $request)
    {
        $expenses = Expense::where('status', '1')
            ->selectRaw('DATE(updated_at) as updated_date')
            ->selectRaw('sum(amount) as amount')
            ->orderBy('updated_date', 'DESC')
            ->groupBy('updated_date');
            
        return Datatables::of($expenses)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }
        }, true)
        ->addColumn('day_at_timezone', function (Expense $expenses) {
            return $expenses->getDay($expenses->updated_date);
        })
        ->addColumn('updated_date', function (Expense $expenses) {
            return $expenses->updated_date;
        })
        ->toJson();
    }

    public function listToPay()
    {
        $categories = Category::all();

        return view('admin.expenses.list_to_pay')
            ->with('categories', $categories);
    }

    public function listToPayData(Request $request)
    {
        $expenses = Expense::with('category')
            ->where('status', '0')
            ->orderBy('created_at', 'ASC');
            
        return Datatables::of($expenses)->filter(function ($query) use($request) {
            if (request()->has('from') && request('from')!='' && request('to')!='' && request()->has('to')) {
                $start = date("Y-m-d",strtotime(request('from')));
                $end = date("Y-m-d",strtotime(request('to')));
                $query->whereBetween('updated_at',[$start. " 00:00:00", $end. " 23:59:59"]);
            }
        }, true)
        ->addColumn('category_name', function (Expense $expenses) {
            return $expenses->category->name;
        })
        ->addColumn('created_at_timezone', function (Expense $expenses) {
            return $expenses->created_at_timezone;
        })
        ->toJson();
    }

    public function markAsPaid($id)
    {
        $expenses = Expense::where('id', $id)->first();

        $expenses->update([
            'status' => '1',
        ]);

        return $expenses;
    }
}
