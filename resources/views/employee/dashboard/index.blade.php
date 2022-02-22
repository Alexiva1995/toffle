
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  @include('panels.datatable.styles')
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')
<section id="dashboard-ecommerce">
  <div class="row match-height justify-content-center">
    <!-- Add Order Card -->
    <div class="col-xl-3 col-md-6 col-12">
      <div class="card card-congratulation-medal">
        <div class="card-body">
          <div class="row">
              <div class="col-auto">
                <h3 class="mb-5"> 
                    <span class="icon-wrapper">
                      <i data-feather="edit"></i>
                    </span> Pedidos
                </h3>

                {{-- <a href="{{ route('orders.create') }}" class="btn btn-primary">Agregar Pedido</a> --}}

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_order">
                  Agregar Pedido
                </button>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Add Order Card -->

    {{-- Order-Statistics --}}
    <div class="col-xl-9 col-md-6 col-12">
      @include('employee.dashboard.orders.statistics')
    </div>
    {{--/ Order-Statistics --}}
 
    {{-- Orders-Pending --}}
    <div class="col-12">
      @include('employee.dashboard.orders.pending')
    </div>
    {{--/ Orders-Pending --}}

    {{-- Orders-History --}}
    <div class="col-12">
      @include('employee.dashboard.orders.history')
    </div>
    {{--/ Orders-Pending --}}

    {{-- Tables --}}
    <div class="col-lg-6 col-12">
      @include('employee.dashboard.table.list')
    </div>
    {{--/ Tables --}}

    {{-- Money Flow --}}
    <div class="col-lg-6 col-12">
      @include('employee.dashboard.money_flow.list')
    </div>
    {{--/ Money Flow --}}

    {{-- Inventory Reposition --}}
    <div class="col-lg-10 col-12">
      @include('employee.dashboard.inventory_reposition.list')
    </div>
    {{--/ Inventory Reposition --}}

  </div>

<div class="modal fade text-start" id="modal_add_order" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" id="modal_content_order">
        @include('employee.dashboard.orders.modals.add_order')
      </div>
    </div>
</div>
</section>

<div
  class="modal fade text-start"
  id="modal_show_order_details"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content order_details">
        </div>
    </div>
</div>

<div
  class="modal fade text-start"
  id="modal_show_ingredients"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content ingredients_details">
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
  <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
@endsection

@section('custom-js')

  @include('panels.datatable.scripts')
  <script>
      dataTable('#order_history_table');
      dataTable('#table_list');
      dataTable('#money_flow_table');
      dataTable('#inventory_reposition_table');

      function viewModifyDishes(order_id) {
          $.get("{{ route('order.modify.dishes') }}", { order_id: order_id })
          .done(function(data){
              console.log(data);
              $('#modal_content_order').html(data);
          })
          .fail(function(data) {
              // console.log(data);
          });
      }

      $(document).on('change', '.update_status', function () {
        let item = {}
        let input = this;

        item ['status'] = this.value;
        item ['form'] = 'edit_order';

        var url = "{{ route('orders.update', 'id') }}";
        url = url.replace('id', $(this).data('id'));

        item ['_method'] = 'PATCH';
        $.post(url, item)
        .done(function(data){
            $(input).removeClass('is-invalid')
            $(input).addClass('is-valid')

            setTimeout(() => {
                $(input).removeClass('is-valid')
            },1000)
        })
        .fail(function(data) {
            $(input).addClass('is-invalid')
        });
      });

      $(document).on('click', '#add_order', function () {
          console.log('HOLA');
          button = $(this);

          if (($('#customer_name').val() == null || $('#customer_name').val() == '') && ($('#table').val() == null || $('#table').val() == '')) {

            $('#customer_name').addClass('is-invalid');
            $('#table').addClass('is-invalid');
            toastr['error']('', 'El nombre del cliente es requerido', {
                closeButton: true,
                tapToDismiss: false,
            });
            toastr['error']('', 'La mesa es requerida', {
                closeButton: true,
                tapToDismiss: false,
            });

          }else if ($('#customer_name').val() == null || $('#customer_name').val() == ''){
            $('#customer_name').addClass('is-invalid');
            toastr['error']('', 'El nombre del cliente es requerido', {
                closeButton: true,
                tapToDismiss: false,
            });
          }else if ($('#table').val() == null || $('#table').val() == ''){
            $('#table').addClass('is-invalid');
            toastr['error']('', 'La mesa es requerida', {
                closeButton: true,
                tapToDismiss: false,
            });
          }else{
            button.attr('disabled', 'disabled').addClass('disabled');
            $('#loading_add_order').addClass('spinner-border spinner-border-sm');

            $.post("{{ route('orders.store') }}", { customer_name: $('#customer_name').val(), table: $('#table').val() })
            .done(function(data){
              var order_id = data;
              viewModifyDishes(order_id);
            })
            .fail(function(data) {
            });
          }
      });

      function showOrderDetails(id) {
        $.get("{{ route('reports.show.order.details') }}", { id: id },
            function (data, textStatus, jqXHR) {
                $('.order_details').html(data);
                $("#modal_show_order_details").modal("show");
            }
        );
      }

      $(document).ready(function () {
        table = $('#pending_order_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            pageLength: 50,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('order.table.data', 'pending') !!}',
                data: function (d) {
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
                data: "customer_name",
                name: "customer_name",
                title: "Cliente",
                "class": "text-center",
                visible: true,
                searchable: true
            },
            {
                data: "table",
                name: "table",
                title: "Mesa",
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
                    return (row.total_amount).toFixed(2);
                }  
            },
            {
                data: "status",
                name: "status",
                title: "Estado",
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
                searchable: true
            },

        ],
        fnCreatedRow: function (elemt, data, iDataIndex) {
            var indice = iDataIndex + 1;

            field = $('td:eq(4)', elemt);
            buttons = '';

            if (data.status == '0') {
              options = '<option value="0">Pendiente</option><option value="1">En Espera</option>';
            }

            if (data.status == '1') {
              options = '<option value="1">En Espera</option><option value="0">Pendiente</option>';
            }

            button = '<select class="form-control text-center update_status" name="status" data-id="'+data.id+'" >'+options+'<option value="2">Finalizado</option><option value="3">Cancelado</option></select>'

            buttons += button;
            field = field.html(buttons);


            field = $('td:eq(5)', elemt);
            buttons = '';

            url = "{{ route('orders.edit', 'id') }}";
            url = url.replace('id', data.id);

            buttonShow = "<button type='button' class='btn btn-sm btn-primary me-1' onclick='showOrderDetails("+data.id+")'> <i data-feather='eye'></i> </button>";
            
            buttonEdit = '<a href="'+url+'" class="btn btn-sm btn-info my-1 me-1"> <i data-feather="edit"></i> </a>';

            button = buttonShow+buttonEdit;

            buttons += button;
            field = field.html(buttons);
        },

        }).on('processing.dt', function (e, settings, processing) {
            feather.replace();
        });
      });
      
  </script>

@endsection
