<div class="row align-items-center">
    <div class="col-12 col-md-6">
        <div class="row my-3">
            <div class="col-auto">
                <h5>Fecha de Creación: <span class="h6"> {{ $expense_details->date }} </span> </h5> 
            </div>
            <div class="col-auto">
                <h5>Día <span class="h6"> {{ $expense_details->getDay($expense_details->date) }} </span> </h5>
            </div>
            <div class="col-auto">
                <h5>Monto Total Pagado: <span class="h6"> {{ $expenses->where('status', 1)->sum('amount') }} </span> </h5>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table" id="table_orders_paid_out">
        <thead>
            <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Categoría</th>
                <th class="text-center">Monto</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses->where('status', 1) as $expense)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $expense->category->name}}</td>
                <td class="text-center">{{ $expense->amount}}</td>
                <td class="text-center"> 
                    <span class="badge badge-light-success">
                        Pagado
                    </span>
                </td>
                
                <td class="text-center">{{ $expense->description }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info my-1" data-description = "{{ $expense->description }}"
                        onclick="editExpense( $(this), {{ $expense->id }}, {{ $expense->category_id }}, {{ $expense->amount }}, {{ $expense->status }} )">
                        <i data-feather="edit"></i> 
                    </button> 

                    <button class="btn btn-sm btn-danger" onclick="deleteElement( {{ $expense->id }}, '#delete_expense_', 'este Gasto' )"> 
                        <i data-feather="trash-2"></i> 
                    </button>
                    <form id="delete_expense_{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                        @csrf
                        @method('DELETE')      
                        <input type="hidden" name="status" value="1">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>