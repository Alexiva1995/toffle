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
    <div class="row">
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
                    return (row.total_amount).toFixed(2);
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
                    return (row.gain).toFixed(2);
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
            feather.replace();
        });

        $('#timestamp').change(function() {
            table.search('').draw();
        });

        flatpickrRange('#timestamp', '#from', '#to');
    });
</script>

@endsection 