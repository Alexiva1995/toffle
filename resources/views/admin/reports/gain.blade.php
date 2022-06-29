@extends('layouts/contentLayoutMaster')

@section('title', 'Ganancia')

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
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12">
                                <h4 class="card-text text-center mb-2">Ganancia Neta</h3>
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

            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12">
                                <h4 class="card-text text-center mb-2">Costo Fijo</h3>
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

            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12">
                                <h4 class="card-text text-center mb-2">Imprevisto</h3>
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

        <div class="col-12">
            <div class="card p-2">
                <h3>Ganancias por Día</h3>
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
                    <table class="table" id="gain_table"> </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
<script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('custom-js')

@include('panels.datatable.scripts')

<script>
    // Calcula y dibuja el Total en Ganancia Netas
    function getGainAmount(){
        var request = $.ajax({
            method: "GET",
            url: '{!! route('reports.gain.amount.data') !!}',
            data:{ from : $('#from').val(), to : $('#to').val() }
        });

        request.done(function(data) {
            $('#total').html(data);
        });

        request.fail(function() {
            $('#total').html(0);
        });
    }

    // Calcula y dibuja el cuadro de Costos Fijos
    function getfixedCostAmount(){
        var request = $.ajax({
            method: "GET",
            url: '{!! route('reports.gain.fixed.cost') !!}',
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
            url: '{!! route('reports.gain.unexpected') !!}',
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
        table = $('#gain_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            pageLength: 50,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('reports.gain.data') !!}',
                data: function (d) {
                    d.from    = $('#from').val();
                    d.to      = $('#to').val();
                }
            },
            columns: [
            { 
                data: null,
                sortable: false, 
                title: "N°",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }  
            },
            {
                data: "updated_at_timezone",
                name: "updated_at_timezone",
                title: "Fecha de Pago",
                "class": "text-center",
                visible: true,
                searchable: true
            },
            {
                data: "day_at_timezone",
                name: "day_at_timezone",
                title: "Día",
                "class": "text-center",
                visible: true,
                searchable: true,
            },
            {
                data: "total_amount",
                name: "total_amount",
                title: "Monto de Venta",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row, meta) {
                    return data.toLocaleString();
                }  
            },
            {
                data: "gain",
                name: "gain",
                title: "Ganancia",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row, meta) {
                    return data.toLocaleString();
                }  
            },
            {
                data: null,
                sortable: true, 
                title: "Costo Fijo",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }  
            },
            {
                data: null,
                sortable: true, 
                title: "Imprevisto",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }  
            },
            {
                data: "updated_at",
                name: "updated_at",
                title: "Detalles",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row) {
                    var url = '{{ route('gain.show','replace_this')}}'.replace('replace_this', row.updated_at_timezone);
                    var html = '<a href="' + url + '" class="btn btn-sm btn-info"><i data-feather="eye"></i> </a>';
                    feather.replace();
                    return html;
                }
            },

        ],
        fnCreatedRow: function (elemt, data, iDataIndex) {},

        }).on('processing.dt', function (e, settings, processing) {
            getfixedCostAmount();
            getUnexpectedAmount();
            getGainAmount();
            feather.replace();
        });

        $('#timestamp').change(function() {
            table.search('').draw();
        });

        flatpickrRange('#timestamp', '#from', '#to');
    });
</script>

@endsection