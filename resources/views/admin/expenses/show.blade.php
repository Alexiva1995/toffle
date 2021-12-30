@extends('layouts/contentLayoutMaster')

@section('title', 'Detalles de Gasto')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
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
                                <a href="{{ route('expenses.list') }}">
                                    Gastos
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                Detalles {{  Session::has('paid_out')  }}
                            </li>
                        </ol>
                  </div>
                  <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                      
                      <a
                        class="nav-link {{ Session::has('paid_out') == true ? '' : 'active' }}"
                        id="paid-out-tab-center"
                        data-bs-toggle="tab"
                        href="#paid-out-center"
                        aria-controls="paid-out-center"
                        role="tab"
                        aria-selected="false"
                        >Pagados</a
                      >
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link {{ Session::has('paid_out') == true ? 'active' : '' }}"
                        id="to-pay-tab-center"
                        data-bs-toggle="tab"
                        href="#to-pay-center"
                        aria-controls="to-pay-center"
                        role="tab"
                        aria-selected="false"
                        >Por Pagar</a
                      >
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane {{ Session::has('paid_out') == true ? '' : 'active' }}" id="paid-out-center" aria-labelledby="paid-out-tab-center" role="tabpanel">
                      @include('admin.expenses.partials.paid_out')
                    </div>
                    <div class="tab-pane {{ Session::has('paid_out') == true ? 'active' : '' }}" id="to-pay-center" aria-labelledby="to-pay-tab-center" role="tabpanel">
                        @include('admin.expenses.partials.to_pay')
                    </div>
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

        function editExpense(element, id, category_id, amount, status) {
            var route = '{{route('expenses.update', 'replace_this')}}'.replace('replace_this', id);
            $('#form_edit_expense').attr('action', route);
            $("#category_id option[value="+ category_id +"]").attr("selected", true).trigger('change');
            $("#status option[value="+ status +"]").attr("selected", true).trigger('change');
            $('#amount').val(amount);
            $('#description').val(element.data('description'));
            $('#modal_edit_expense').modal('show');
        }

        dataTable('#table_orders_paid_out');
        dataTable('#table_orders_to_pay');

    </script>
@endsection