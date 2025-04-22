@extends('layouts/contentLayoutMaster')

@section('title', 'Mas Vendido')

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

                            <div class="col-12 col-md-4">
                                <label for="category_id">Categorías</label>
                                <select class="select2 form-control" name="category_id" id="category_id" data-toggle="select"
                                    class="form-control" id="category">
                                    <option value="" selected>Seleccionar Todas</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
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

<script>
    $(document).ready(function () {
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
                    d.from  = $('#from').val();
                    d.to    = $('#to').val();
                    d.category_id  = $('#category_id').val();
                    d.order_by_for  = $('#order_by_for').val();
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

        $('#category_id').change(function() {
            table.search('').draw();
        });

        $('#order_by_for').change(function() {
            table.search('').draw()
        });

        $('#timestamp').change(function() {
            table.search('').draw();
        });

        flatpickrRange('#timestamp', '#from', '#to');
    });
</script>

@endsection