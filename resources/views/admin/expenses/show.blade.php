@extends('layouts/contentLayoutMaster')

@section('title', 'Detalles de Gasto')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('page-style')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('expenses.list.historical') }}">
                                    Gastos
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                Detalles 
                            </li>
                        </ol>
                  </div>
                  <div class="row align-items-center">
                    <div class="col-12">
                        <div class="row my-3">
                            <div class="col-auto">
                                <h5>Fecha de Pago: <span class="h6"> {{ $expense_details->date }} </span> </h5> 
                            </div>
                            <div class="col-auto">
                                <h5>Día <span class="h6"> {{ $expense_details->getDay($expense_details->date) }} </span> </h5>
                            </div>
                            <div class="col-auto">
                                <h5>Monto Total Pagado: <span class="h6"> {{ number_format($expenses->where('status', 1)->sum('amount'), 2, '.', '') }} </span> </h5>
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
                                <td class="text-center">{{ $expense->category->name }}</td>
                                <td class="text-center">{{ number_format($expense->amount, 2, '.', '') }}</td>
                                <td class="text-center"> 
                                    <span class="badge badge-light-success">
                                        Pagado
                                    </span>
                                </td>
                                
                                <td class="text-center">{{ $expense->description }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info my-1" data-description = "{{ $expense->description }}"
                                        onclick="editExpense( $(this), {{ $expense->id }}, {{ $expense->category_id }}, {{ $expense->amount }}, {{ $expense->status }}, 'paid_out' )">
                                        <i data-feather="edit"></i> 
                                    </button> 
                
                                    <button class="btn btn-sm btn-danger" onclick="deleteElement( {{ $expense->id }}, '#delete_expense_', 'este Gasto' )"> 
                                        <i data-feather="trash-2"></i> 
                                    </button>
                                    <form id="delete_expense_{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')      
                                        <input type="hidden" name="status" value="paid_out">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Edit Product -->
<div
  class="modal fade text-start"
  id="modal_edit_expense"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Editar Gasto</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @include('admin.expenses.edit')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_expense">
                <span class="loading_edit_exp mr-2"></span> Editar
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
    <script>

        submitForms('#edit_expense', '.loading_edit_exp', '#form_edit_expense');

        function editExpense(element, id, category_id, amount, status, type) {
            var route = '{{route('expenses.update', 'replace_this')}}'.replace('replace_this', id);
            $('#form_edit_expense').attr('action', route);
            $("#category_id option[value="+ category_id +"]").attr("selected", true).trigger('change');
            $('#amount').val(amount);
            $('#description').val(element.data('description'));
            $('#type').val(type);

            if (status == '0') {
                $("#to_pay").prop('checked', true);               
            }else{
                $("#paid_out").prop('checked', true);               
            }

            $('#modal_edit_expense').modal('show');
        }

        dataTable('#table_orders_paid_out');
        dataTable('#table_orders_to_pay');

        $(document).ready(function() {

            $('#to_pay').click( function() {
                if ($(this).prop('checked')) {
                    $("#paid_out").prop('checked', false);
                }
            });

            $('#paid_out').click( function() {
                if ($(this).prop('checked')) {
                    $("#to_pay").prop('checked', false);
                }
            });
        });

    </script>
@endsection