@extends('layouts/contentLayoutMaster')

@section('title', 'Gastos')

@include('panels.datatable.styles')

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <h3>Gastos por Día</h3>
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
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-end mt-1">
                            <div class="col-auto">
                                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                                    <i data-feather="plus"></i> Añadir Gasto
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-10 col-sm-10 col-md-3 col-lg-3 mb-1">
                        {{-- <input type="search" id="search" class="form-control form-control-sm form-control-flush search bg-white" placeholder="Buscar"> --}}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="expense_table"> </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection


@section('page-script')
    <!-- Page js files -->
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
    <script>
        $(document).ready(function () {
            table = $('#expense_table').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                pageLength: 50,
                language: {
                    url: '{!! asset('data/datatable/Spanish.json') !!}'
                },
                ajax: {
                    url: '{!! route('expenses.data') !!}',
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
                    data: "day_at_timezone",
                    name: "day_at_timezone",
                    title: "Día",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                {
                    data: "created_at_timezone",
                    name: "created_at_timezone",
                    title: "Fecha",
                    "class": "text-center",
                    visible: true,
                    searchable: true
                },
                {
                    data: "amount",
                    name: "amount",
                    title: "Monto",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                {
                    data: "date",
                    name: "date",
                    title: "Detalles",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                    render: function (data, type, row) {
                        var url = '{{ route('expenses.show','replace_this')}}'.replace('replace_this', row.date);
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

            $('#timestamp').flatpickr({
                mode:'range',
                ariaDateFormat:'Y-m-d',
                dateFormat:'Y-m-d',
                onChange:function(selectedDates){
                    var _this=this;
                    var dateArr=selectedDates.map(function(date){return _this.formatDate(date,'Y-m-d');});
                    $('#from').val(dateArr[0]);
                    $('#to').val(dateArr[1]);
                },
            });
        });
    </script>
@endsection
