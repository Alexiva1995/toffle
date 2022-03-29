@extends('layouts/contentLayoutMaster')

@section('title', 'Gastos')

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
                                <label for="status">Estados</label>
                                <select class="select2 form-control" name="status" id="status" data-toggle="select"
                                    class="form-control" id="status">
                                    <option value="" selected>Seleccionar Todas</option>
                                    <option value="0"> Por Pagar </option>
                                    <option value="1"> Pagados </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="expenses_table"> </table>
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
        table = $('#expenses_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            pageLength: 50,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('reports.expenses.data') !!}',
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
                title: "#",
                "class": "text-center",
                visible: true,
                searchable: true,
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
                data: "amount",
                name: "amount",
                title: "Monto",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row, meta) {
                    return '<strong class="text-danger">'+row.amount.toFixed(2)+'</strong>';
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
                    if (row.status == '0') {
                        return '<span class="badge badge-light-warning">Por Pagar</span>';
                    }else{
                        return '<span class="badge badge-light-success">Pagado</span>';
                    }
                    
                }  
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
                data: "updated_at_timezone",
                name: "updated_at_timezone",
                title: "Fecha",
                "class": "text-center",
                visible: true,
                searchable: true,
            },
        ],
        fnCreatedRow: function (elemt, data, iDataIndex) {},

        }).on('processing.dt', function (e, settings, processing) {
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
</script>

@endsection