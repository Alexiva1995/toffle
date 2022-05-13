@extends('layouts/contentLayoutMaster')

@section('title', 'Ventas')

@section('vendor-style')
<!-- vendor css files -->
@include('panels.datatable.styles')
@endsection

@section('page-style')
{{-- Page css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
@endsection

@section('content')
<section id="basic-datatable">
    <div class="row justify-content-center">
        <div class="row">
            <div class="col-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12 col-12">
                                <h4 class="card-text text-center mb-2">Total de Ventas</h3>
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="avatar bg-light-success me-1">
                                        <div class="avatar-content">
                                            <i data-feather="dollar-sign" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">
                                            $ <span id="total"></span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row 1000011justify-content-center">
                            <div class="col-md-12 col-12">
                                <h4 class="card-text text-center mb-2">Costos Fijos</h3>
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="avatar bg-light-success me-1">
                                        <div class="avatar-content">
                                            <i data-feather="dollar-sign" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">
                                            $ <span id="fixed_cost"></span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12 col-12">
                                <h4 class="card-text text-center mb-2">Imprevistos</h3>
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="avatar bg-light-success me-1">
                                        <div class="avatar-content">
                                            <i data-feather="dollar-sign" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">
                                            $ <span id="unexpected"></span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                {{-- <h3>Más Vendidos</h3> --}}
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="row justify-content-init mt-1">
                            <div class="col-12 col-md-4">
                                <label for="timestamp">Rango de Fecha</label>
                                <input type="text" class="form-control" placeholder="Rango de Fecha" id="timestamp">
                                <input type="hidden" id="from">
                                <input type="hidden" id="to">
                            </div>

                            {{-- <div class="col-12 col-md-4">
                                <label for="category_id">Categorías</label>
                                <select class="select2 form-control" name="category_id" id="category_id"
                                    data-toggle="select" class="form-control" id="category">
                                    <option value="" selected>Seleccionar Todas</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-12 col-md-4">
                                <label for="status">Estados</label>
                                <select class="select2 form-control" name="status" id="status" data-toggle="select"
                                    class="form-control" id="status">
                                    <option value="" selected>Seleccionar Todas</option>
                                    <option value="0"> Pendientes </option>
                                    <option value="1"> En Espera </option>
                                    <option value="2"> Finalizados </option>
                                    <option value="3"> Cancelados </option>
                                </select>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="sales_table"> </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-start" id="modal_show_order_details" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content order_details">
        </div>
    </div>
</div>

@endsection

@section('custom-js')

@include('panels.datatable.scripts')

<script>
    function showOrderDetails(id) {
        $.get("{{ route('reports.show.order.details') }}", { id: id },
            function (data, textStatus, jqXHR) {
                $('.order_details').html(data);
                $("#modal_show_order_details").modal("show");
            }
        );
    }
    // Calcula y dibuja el Total en ventas
    function getTotalAmount(){
        var request = $.ajax({
            method: "GET",
            url: '{!! route('reports.total.sales.amount.data') !!}',
            data:{ from : $('#from').val(), to : $('#to').val() }
        });

        request.done(function(data) {
            $('#total').html(data);
        });

        request.fail(function() {
            $('#total').html(0);
        });
    }
    // Calcula y dibuja Los Costos Fijos
    function getfixedCostAmount(){
        var request = $.ajax({
            method: "GET",
            url: '{!! route('reports.fixed.cost.data') !!}',
            data:{ from : $('#from').val(), to : $('#to').val() }
        });
        
        request.done(function(data) {
            $('#fixed_cost').html(data);
        });

        request.fail(function() {
            $('#fixed_cost').html(0);
        });
    }
    // Calcula el imprevisto
    function getUnexpectedAmount(){
        var request = $.ajax({
            method: "GET",
            url: '{!! route('reports.unexpected.data') !!}',
            data:{ from : $('#from').val(), to : $('#to').val() }
        });
        
        request.done(function(data) {
            $('#unexpected').html(data);
        });

        request.fail(function() {
            $('#unexpected').html(0);
        });
    }

    $(document).ready(function () {
        table = $('#sales_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            pageLength: 50,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('reports.sales.data') !!}',
                data: function (d) {
                    d.from  = $('#from').val();
                    d.to    = $('#to').val();
                    d.category_id  = $('#category_id').val();
                    d.status  = $('#status').val();
                }
            },
            columns: [
            { 
                data: "id",
                name: "id",
                title: "# Pedido",
                "class": "text-center",
                visible: true,
                searchable: true,
            },
            {
                data: "total_amount",
                name: "total_amount",
                title: "Monto",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row, meta) {
                    return '<strong class="text-success amount">'+row.total_amount.toFixed(2)+'</strong>';
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
                    switch (row.status) {
                        case '0':
                            return '<span class="badge badge-light-warning">Pendiente</span>';
                            break;
                        case '1':
                            return '<span class="badge badge-light-info">En Espera</span>';
                            break;
                        case '2':
                            return '<span class="badge badge-light-success">Finalizado</span>';
                            break;
                        case '3':
                            return '<span class="badge badge-light-danger">Cancelado</span>';
                            break;
                        default:
                            break;
                    }
                    
                }  
            },
            {
                data: "updated_at_timezone",
                name: "updated_at_timezone",
                title: "Fecha",
                "class": "text-center",
                visible: true,
                searchable: true,
            },
            {
                data: "id",
                name: "id",
                title: "Detalles",
                "class": "text-center",
                visible: true,
                searchable: true,
            },
        ],
        fnCreatedRow: function (elemt, data, iDataIndex) {
            var index = iDataIndex + 1;
            column=$('td:eq(4)', elemt);
            buttons='';

            button="<button type='button' class='btn btn-sm btn-primary' onclick='showOrderDetails("+data.id+")'> <i data-feather='eye'></i> </button>";

            buttons+=button;
            column=column.html(buttons);
        },

        }).on('processing.dt', function (e, settings, processing) {
            getUnexpectedAmount();
            getTotalAmount();
            getfixedCostAmount();
            feather.replace();
        });

        $('#status').change(function() {
            table.search('').draw();
        });

        $('#category_id').change(function() {
            table.search('').draw();
        });

        $('#timestamp').change(function() {
            table.search('').draw();
        });

        flatpickrRange('#timestamp', '#from', '#to');
    });

    dataTable('#table');
</script>

@endsection