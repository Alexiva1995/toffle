@extends('layouts/contentLayoutMaster')

@section('title', 'Gastos Por Pagar')

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
                            Por Pagar
                        </li>
                    </ol>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-init mt-1">
                            <div class="col-12 col-md-6">
                                <label for="timestamp">Rango de Fecha</label>
                                  <input type="text" class="form-control" placeholder="Rango de Fecha" id="timestamp">
                                  <input type="hidden" id="from">
                                  <input type="hidden" id="to">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="expenses_payable_table">
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

        function editExpense(id, category_id, amount, status, description) {
            var route = '{{route('expenses.update', 'replace_this')}}'.replace('replace_this', id);
            $('#form_edit_expense').attr('action', route);
            $("#category_id option[value="+ category_id +"]").attr("selected", true).trigger('change');
            $('#amount').val(amount);
            $('#description').val(description);
            $('#type').val('to_pay');

            if (status == '0') {
                $("#to_pay").prop('checked', true);               
            }else{
                $("#paid_out").prop('checked', true);               
            }

            $('#modal_edit_expense').modal('show');
        }

        function markAsPaid(id) {
            $.confirm({
                title: 'Confirmar!',
                content: 'Quieres Marcar este gasto como Pagado?',
                columnClass: 'col-12 col-md-4 col-xs-4',
                containerFluid: true,
                buttons: {
                    confirm: {
                        text: 'Confirmar',
                        btnClass: 'btn-success',
                        action: function () {
                            $(this).addClass('disabled');
                            $(this).addClass('spinner-border spinner-border-sm');

                            url = "{{ route('expenses.mark.as.paid', 'parameter') }}";
                            url = url.replace('parameter', id);
                            $.post(url, {},
                                function (data, textStatus, jqXHR) {

                                    table.search('').draw();
                                    
                                    toastr['success']('', 'Gasto Marcado como Pagado', {
                                        closeButton: true,
                                        tapToDismiss: false,
                                    });
                                },
                            );
                        }
                    },
                    cancelar: function () {
                    },
                }
            });
        }

        $(document).ready(function() {

            table = $('#expenses_payable_table').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                pageLength: 50,
                language: {
                    url: '{!! asset('data/datatable/Spanish.json') !!}'
                },
                ajax: {
                    url: '{!! route('expenses.list.to.pay.data') !!}',
                    data: function (d) {
                        d.from    = $('#from').val();
                        d.to      = $('#to').val();
                    }
                },
                columns: [
                { 
                    data: "id",
                    name: "id", 
                    title: "Id",
                    "class": "text-center",
                    visible: true,
                    searchable: true, 
                },
                {
                    data: "category_name",
                    name: "category_name",
                    title: "Categoría",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                {
                    data: "amount",
                    name: "amount",
                    title: "Monto",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                    render: function (data, type, row, meta) {
                        return row.amount.toFixed(2);
                    }  
                },
                {
                    data: "status",
                    name: "status",
                    title: "Estado",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                    render: function (data, type, row, meta) {
                        return '<span class="badge badge-light-warning">Por Pagar</span>';
                    }  
                },
                {
                    data: "description",
                    name: "description",
                    title: "Descripción",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                {
                    data: "created_at_timezone",
                    name: "created_at_timezone",
                    title: "Fecha de Creación",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                {
                    data: "id",
                    name: "id",
                    title: "Acción",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },

            ],
            fnCreatedRow: function (elemt, data, iDataIndex) {
                var indice = iDataIndex + 1;

                field = $('td:eq(6)', elemt);
                buttons = '';
                
                var description = "'"+data.description+"'";

                buttonMarkAsPaid = '<button class="btn btn-sm btn-success" onclick="markAsPaid( '+data.id+' )"> <i data-feather="check-square"></i></button>';

                buttonEdit = '<button class="btn btn-sm btn-info my-1 mx-1" data-description = "'+data.description+'" onclick="editExpense('+data.id+', '+data.category_id+', '+data.amount+', '+data.status+', '+description+' )"><i data-feather="edit"></i> </button>';

                buttonDelete = '<button class="btn btn-sm btn-danger delete_expense" data-id="'+data.id+'"><i data-feather="trash-2"></i></button>';

                button = buttonMarkAsPaid+buttonEdit+buttonDelete;

                buttons += button;
                field = field.html(buttons);
            },

            }).on('processing.dt', function (e, settings, processing) {
                feather.replace();
            });

            $('#timestamp').change(function() {
                table.search('').draw();
            });

            flatpickrRange('#timestamp', '#from', '#to');

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

            $(document).on('click', '.delete_expense', function () {
                var id = $(this).data('id');
                $.confirm({
                    title: 'Confirmar!',
                    content: 'Estás seguro que quieres eliminar este Gasto?',
                    columnClass: 'col-12 col-md-4 col-xs-4',
                    containerFluid: true,
                    buttons: {
                        confirm: {
                            text: 'Confirmar',
                            btnClass: 'btn-danger',
                            action: function () {
                                $(this).addClass('disabled');
                                $(this).addClass('spinner-border spinner-border-sm');

                                url = "{{ route('expenses.destroy', 'parameter') }}";
                                url = url.replace('parameter', id );

                                $.ajax({
                                    url: url,
                                    type: 'DELETE',
                                    data: { status : 'to_pay' },
                                    success: function(result) {
                                        table.search('').draw();
                                    
                                        toastr['success']('', 'Gasto Eliminado Exitosamente', {
                                            closeButton: true,
                                            tapToDismiss: false,
                                        });
                                    }
                                });
                            }
                        },
                        cancelar: function () {
                        },
                    }
                });
            });
        });
        

    </script>
@endsection