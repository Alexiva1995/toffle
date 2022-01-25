
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
  <div class="row match-height">
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
    <div class="col-lg-6 col-12">
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
    <div class="col-lg-6 col-12">
      @include('employee.dashboard.inventory_reposition.list')
    </div>
    {{--/ Inventory Reposition --}}

  </div>

</section>
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
      dataTable('#pending_order_table');
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
  </script>
@endsection
