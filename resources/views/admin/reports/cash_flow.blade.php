@extends('layouts/contentLayoutMaster')

@section('title', 'Flujo de caja')

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
<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-12">
                        <h4 class="card-text text-center mb-2">Capital a Favor</h3>
                        <div class="d-flex flex-row justify-content-center">
                            <div class="avatar bg-light-success me-1">
                                <div class="avatar-content">
                                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                                </div>
                            </div>
                            <div class="my-auto">
                                <h4 class="fw-bolder mb-0">$
                                    {{ number_format($capital_available, 2, '.', '') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="d-flex flex-row">
                            <div class="avatar bg-light-danger me-2">
                                <div class="avatar-content">
                                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                                </div>
                            </div>
                            <div class="my-auto">
                                <h4 class="fw-bolder mb-0">$
                                    @if(isset($capitalDisponible))
                                    {{$capitalDisponible}}
                                    @else
                                    0
                                    @endif
                                </h4>
                                <p class="card-text font-small-3 mb-0">Capital en contra</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<section id="basic-datatable">
    <section id="nav-tabs-aligned">
        <div class="row match-height">
          <!-- Centered Aligned Tabs starts -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a
                      class="nav-link active"
                      id="inventories-tab-center"
                      data-bs-toggle="tab"
                      href="#inventories-center"
                      aria-controls="inventories-center"
                      role="tab"
                      aria-selected="false"
                      >Ingresos</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      id="products-tab-center"
                      data-bs-toggle="tab"
                      href="#products-center"
                      aria-controls="products-center"
                      role="tab"
                      aria-selected="false"
                      >Egresos</a
                    >
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="inventories-center" aria-labelledby="inventories-tab-center" role="tabpanel">
                    @include('admin.reports.cash_flow.income')
                  </div>
                  <div class="tab-pane" id="products-center" aria-labelledby="products-tab-center" role="tabpanel">
                    @include('admin.reports.cash_flow.expenses')
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</section>
@endsection

@section('custom-js')

@include('panels.datatable.scripts')

<script>
    $(document).ready(function () {
        income_table = $('#income_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            pageLength: 50,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('reports.income.data') !!}',
                data: function (d) {
                    d.from  = $('#income_from').val();
                    d.to    = $('#income_to').val();
                    d.category_id  = $('#income_category_id').val();
                }
            },
            columns: [
            { 
                data: "dish_id",
                name: "dish_id",
                title: "#",
                "class": "text-center",
                visible: true,
                searchable: true,
            },
            { 
                data: "order_id",
                name: "order_id",
                title: "Órden Id",
                "class": "text-center",
                visible: true,
                searchable: true,
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
            // {
            //     data: "status",
            //     name: "status",
            //     title: "Estado",
            //     "class": "text-center",
            //     visible: true,
            //     searchable: true,
            //     render: function (data, type, row, meta) {
            //         switch (row.status) {
            //             case '0':
            //                 return '<span class="badge badge-light-warning">Pendiente</span>';
            //                 break;
            //             case '1':
            //                 return '<span class="badge badge-light-info">En Espera</span>';
            //                 break;
            //             case '2':
            //                 return '<span class="badge badge-light-success">Finalizado</span>';
            //                 break;
            //             case '3':
            //                 return '<span class="badge badge-light-danger">Cancelado</span>';
            //                 break;
            //             default:
            //                 break;
            //         }
                    
            //     }  
            // },
            {
                data: "total_amount",
                name: "total_amount",
                title: "Monto",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row, meta) {
                    return '<strong class="text-success">+'+row.total_amount.toFixed(2)+'</strong>';
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
        ],
        fnCreatedRow: function (elemt, data, iDataIndex) {},

        }).on('processing.dt', function (e, settings, processing) {
            feather.replace();
        });

        $('#income_timestamp').change(function() {
            income_table.search('').draw();
        });

        $('#income_category_id').change(function() {
            income_table.search('').draw();
        });

        flatpickrRange('#income_timestamp', '#income_from', '#income_to');


        expenses_table = $('#expenses_table').DataTable({
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
                    d.from  = $('#expenses_from').val();
                    d.to    = $('#expenses_to').val();
                    d.category_id  = $('#expenses_category_id').val();
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
                    return '<strong class="text-danger">-'+row.amount.toFixed(2)+'</strong>';
                }  
            },
            // {
            //     data: "status",
            //     name: "status",
            //     title: "Estado",
            //     "class": "text-center",
            //     visible: true,
            //     searchable: true,
            //     render: function (data, type, row, meta) {
            //         if (row.status == '0') {
            //             return '<span class="badge badge-light-warning">Por Pagar</span>';
            //         }else{
            //             return '<span class="badge badge-light-success">Pagado</span>';
            //         }
                    
            //     }  
            // },
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

        $('#expenses_category_id').change(function() {
            expenses_table.search('').draw();
        });

        $('#expenses_timestamp').change(function() {
            expenses_table.search('').draw();
        });

        flatpickrRange('#expenses_timestamp', '#expenses_from', '#expenses_to');

    });
</script>

@endsection
