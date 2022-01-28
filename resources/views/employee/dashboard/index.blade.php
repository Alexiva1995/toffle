
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  @include('panels.datatable.styles')
@endsection
@section('page-style')
  {{-- Page css files --}}
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_order">Agregar Pedido</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Add Order Card -->

    {{-- Modals --}}
    @include('employee.dashboard.orders.modals.create')

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
@endsection

@section('vendor-script')
  {{-- vendor files --}}
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
      // dataTable('#pending_order_table');
      dataTable('#table_list');
      dataTable('#money_flow_table');
      dataTable('#inventory_reposition_table');

      submitForms('#add_order', '.loading_add_order', '#form_add_order');

      numRows = 0;
      
      var ids = [];

      function addRow(){

        var repeated = false;

        if ($("#selected_dish option:selected").val() == null || $("#selected_dish option:selected").val() == '') {
            toastr['error']('', 'Debes seleccionar primero un plato, para luego añadirlo', {
                  closeButton: true,
                  tapToDismiss: false,
            });
        }else{

            for(var i = 0; i < ids.length; i++){
                if(ids[i] == $("#selected_dish option:selected").val() ){ 
                  repeated = true;
                }           
            }

            if (!repeated) {
                ids.push( $("#selected_dish option:selected").val() );
                numRows++;
                let content = '<tr id="row_'+numRows+'">\
                <td><input type="text" name="dish[]" class="form-control dish" id="dish_'+numRows+'" value="'+$("#selected_dish option:selected").text()+'" required disabled></td>\
                <input type="hidden" name="dish_ids[]" class="form-control dish_ids" id="dish_ids_'+numRows+'" value="'+$("#selected_dish option:selected").val()+'" required>\
                <td><input type="number" name="unit[]" class="form-control units" id="unit_'+numRows+'" value="1" oninput="calculate('+numRows+')" required></td>\
                <td><input type="text" name="price[]" class="form-control price" id="price_'+numRows+'" value="'+$("#selected_dish option:selected").data("price").toFixed(2)+'" readonly required></td>\
                <td><input type="text" name="total[]" class="form-control total" id="total_'+numRows+'" value="'+$("#selected_dish option:selected").data("price")+'" readonly></td>\
                <td><a href="javascript:;" onclick="deleteRow('+numRows+')"> <i class="text-danger" data-feather="x-circle"></i> </a></td>\
                </tr>';
                $("#items_table>tbody").append(content);
                feather.replace();
                $("#selected_dish").val("").trigger('change');

                calculate(numRows);

            }else{
              toastr['error']('', 'Este Plato ya fue añadido', {
                  closeButton: true,
                  tapToDismiss: false,
              });
            }
        }
      }

      function deleteRow(row){

          for( var i = 0; i < ids.length; i++){ 
            if ( ids[i] === $("#dish_ids_"+row).val()) { 
              ids.splice(i, 1); 
            }
          }
          
          $("#row_"+row).remove();
          numRows--;

          calculate(numRows);
      }

      function calculate(row){
          let unit = $("#unit_"+row).val();
          let price = $("#price_"+row).val();

          $("#total_"+row).val( (parseInt(unit) * parseFloat(price)).toFixed(2) );
          var total = 0;

          for (var i = 1; i <= numRows; i++){
              total += parseFloat($("#total_"+i).val());
          }

          $("#total_amount").val(total.toFixed(2));
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
