@extends('layouts/contentLayoutMaster')

@section('title', 'Mas Vendido')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                {{-- <h3>Más Vendidos</h3> --}}
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="row justify-content-init mt-1">
                            <div class="col-12 col-md-3">
                                <label for="start_date">Fecha de Inicio</label>
                                <input type="text" class="form-control flatpickr-basic" placeholder="dd/mm/yyyy" id="start_date">
                            </div>

                            <div class="col-12 col-md-3">
                                <label for="end_date">Fecha Fin</label>
                                <input type="text" class="form-control flatpickr-basic" placeholder="dd/mm/yyyy" id="end_date">
                            </div>

                            <div class="col-12 col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-primary w-100" id="btn-filter">
                                    <i data-feather="filter"></i> Filtrar
                                </button>
                            </div>

                            <div class="col-12 col-md-2">
                                <label for="category_id">Categorías</label>
                                <select class="select2 form-control" name="category_id" id="category_id" data-toggle="select"
                                    class="form-control" id="category">
                                    <option value="" selected>Seleccionar Todas</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-2">
                                <label for="order_by_for">Organizar Por:</label>
                                <select class="select2 form-control" name="order_by_for" id="order_by_for" data-toggle="select"
                                    class="form-control" id="category">
                                    <option value="units">Mas Vendido</option>
                                    <option value="gain">Ganancia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table rounded border-table" id="best_seller_table"></table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')

@include('panels.datatable.scripts')

<script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/flatpickr/locales/es.js') }}"></script>

<script>
    $(document).ready(function () {
        // Inicialización de Flatpickr para las fechas
        flatpickr('#start_date', {
            dateFormat: 'Y-m-d',
            locale: 'es',
        });

        flatpickr('#end_date', {
            dateFormat: 'Y-m-d',
            locale: 'es',
        });

        // Inicialización de DataTable
        table = $('#best_seller_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            pageLength: 50,
            searching: false,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('reports.best.seller.data') !!}',
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.category_id = $('#category_id').val();
                    d.order_by_for = $('#order_by_for').val();
                }
            },
            columns: [
                {
                    data: "name_dish",
                    name: "name_dish",
                    title: "Plato",
                    "class": "text-center",
                    visible: true,
                    searchable: false,
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
                    title: "# de Ventas",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                {
                    data: "gain",
                    name: "gain",
                    title: "Ganancia",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                    render: function (data, type, row, meta) {
                        return row.gain.toLocaleString();
                    }  
                },

            ],
        }).on('processing.dt', function (e, settings, processing) {
            feather.replace();
        });

        // Evento para el botón de filtrar
        $('#btn-filter').on('click', function() {
            table.search('').draw();
        });

        // Eventos para los otros filtros
        $('#category_id').change(function() {
            table.search('').draw();
        });

        $('#order_by_for').change(function() {
            table.search('').draw();
        });
    });
</script>

@endsection