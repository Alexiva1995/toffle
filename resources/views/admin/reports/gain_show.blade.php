@extends('layouts/contentLayoutMaster')

@section('title', 'Detalles de Ganancias')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
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
                            <a href="{{ route('reports.gain') }}">
                                Ganancias
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
                                <h5>Fecha: <span class="h6"> {{ $gain_details->updated_at_timezone }} </span> </h5> 
                            </div>
                            <div class="col-auto">
                                <h5>Día: <span class="h6"> {{ $gain_details->getDay($gain_details->date) }} </span> </h5>
                            </div>
                            <div class="col-auto">
                                <h5>Monto Total de Venta: <span class="h6"> {{ number_format($gain_details->total_amount, 2, '.', '') }} </span> </h5>
                            </div>
                            <div class="col-auto">
                                <h5>Monto de Ganancia: <span class="h6"> {{ number_format($gain_details->gain, 2, '.', '') }} </span> </h5>
                            </div>
                        </div>
                    </div>
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

                            <div class="col-12 col-md-6">
                                <label for="category_id">Categorías</label>
                                <select class="select2 form-control" name="category_id" id="category_id" data-toggle="select"
                                    class="form-control" id="category">
                                    <option value="" selected>Seleccionar Todas</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="gain_details_table"> </table>
                </div>
            </div>
        </div>
    </div>
</section>

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
        $(document).ready(function () {
            table = $('#gain_details_table').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                pageLength: 50,
                language: {
                    url: '{!! asset('data/datatable/Spanish.json') !!}'
                },
                ajax: {
                    url: '{!! route('gain.data.show', $gain_details->updated_at) !!}',
                    data: function (d) {
                        d.from  = $('#from').val();
                        d.to    = $('#to').val();
                        d.category_id  = $('#category_id').val();
                    }
                },
                columns: [
                {
                    data: "order_id",
                    name: "order_id",
                    title: "Órden Id",
                    "class": "text-center",
                    visible: true,
                    searchable: true
                },
                {
                    data: "name_dish",
                    name: "name_dish",
                    title: "Plato",
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
                    data: "units",
                    name: "units",
                    title: "Unidades",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                {
                    data: "status",
                    name: "status",
                    title: "Estado",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                    render: function (data, type, row, meta) {
                        return '<span class="badge badge-light-success"> Finalizado </span>';
                    }  
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
    
            ],
            fnCreatedRow: function (elemt, data, iDataIndex) {},
    
            }).on('processing.dt', function (e, settings, processing) {
                feather.replace();
            });

            $('#category_id').change(function() {
                table.search('').draw();
            });
    
            $('#timestamp').change(function() {
                table.search('').draw();
            });
    
            flatpickrRange('#timestamp', '#from', '#to');
        });
    </script>

@endsection