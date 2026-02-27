@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@include('panels.datatable.styles')
@endsection
@section('page-style')
{{-- Page css files --}}
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-wizard.css') }}">
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
              <a href="{{ route('orders.create') }}" class="btn btn-primary">Agregar Pedido</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Add Order Card -->

    <div class="col-xl-9 col-md-6 col-12" id="statistics"></div>

    <div class="col-12">
      @include('employee.dashboard.orders.pending')
    </div>

    <div class="col-12" id="order_history"></div>

    {{-- <div class="col-lg-6 col-12" id="tables"></div> --}}

    <div class="col-12" id="cash_flow"></div>

    {{-- <div class="col-12" id="inventory_replenishment"></div> --}}

  </div>

  <div class="modal fade text-start" id="modal_show_order_details" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content order_details">
      </div>
    </div>
  </div>
  @endsection

  @section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
  @endsection
  @section('page-script')
  {{-- Page js files --}}
  @endsection

  @section('custom-js')

  @include('panels.datatable.scripts')
  <script>
    dataTable('#order_history_table');
      // dataTable('#table_list');
      dataTable('#money_flow_table');
      // dataTable('#inventory_reposition_table');
      function loadData(type) {
          var route = "{{ route('load.data', 'parameter') }}";
          route = route.replace('parameter', type);
          var id = '#'+type;

          $.get(route, {},
            function (data, textStatus, jqXHR) {
              $(id).html(data);
              feather.replace();
            }
          );
      }

      loadData('statistics');
      loadData('order_history');
      // loadData('tables');
      loadData('cash_flow');
      // loadData('inventory_replenishment');

      $(document).on('click', '.update_status_item', function (e) {
        e.preventDefault();
        let item = {};
        let input = this;
        let orderId = $(this).data('id');
        let newStatus = $(this).data('status');
        let dropdownButton = $(this).closest('.dropdown').find('.dropdown-toggle');

        item.status = newStatus;
        item.form = 'update_general_data';
        item._method = 'PATCH';
        item._token = $('meta[name="csrf-token"]').attr('content');

        var url = "{{ route('orders.update', 'id') }}";
        url = url.replace('id', orderId);

        $.ajax({
          url: url,
          type: 'POST',
          data: item,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        })
        .done( function(data){
          if('error' in data){
            toastr['error']('', data.message, {
                closeButton: true,
                tapToDismiss: false,
            });
          }else{
            // Actualizar el botón del dropdown visualmente sin recargar toda la tabla si es posible,
            // aunque loadData se llama después.
            dropdownButton.text(data.status_label);
            dropdownButton.removeClass(function (index, className) {
                return (className.match (/(^|\s)badge-light-\S+/g) || []).join(' ');
            }).addClass('badge-light-' + data.status_color);

            if (item.status == '2' || item.status == '3') {
              let title = item.status == '2' ? 'Pedido Finalizado' : 'Pedido Cancelado';
              let msg = item.status == '2' ? 'Unidades gastadas: ' : 'Unidades devueltas: ';
              toastr['success'](msg + data.total_portions, title, {
                closeButton: true,
                tapToDismiss: false,
              });
            }

            loadData('statistics');
            loadData('order_history');
            loadData('cash_flow');
          }
          if (typeof table !== 'undefined') {
              table.ajax.reload(null, false); // Recargar tabla sin perder paginación
          }
        })
        .fail(function(xhr) {
            if (xhr.status === 419) {
              toastr['error']('', 'Sesión expirada. Recarga la página (F5) e intenta de nuevo.', {
                closeButton: true,
                tapToDismiss: false,
              });
            }
        });
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

              let dropdown = `
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle badge badge-light-${data.status_color}"
                    data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-boundary="viewport">
                    ${data.status_label}
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item update_status_item" href="javascript:void(0)" data-id="${data.id}" data-status="0">Pendiente</a>
                    <a class="dropdown-item update_status_item" href="javascript:void(0)" data-id="${data.id}" data-status="1">En Espera</a>
                    <a class="dropdown-item update_status_item" href="javascript:void(0)" data-id="${data.id}" data-status="2">Finalizado</a>
                    <a class="dropdown-item update_status_item" href="javascript:void(0)" data-id="${data.id}" data-status="3">Cancelado</a>
                  </div>
                </div>
              `;

              field.html(dropdown);


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
