@extends('layouts/contentLayoutMaster')

@section('title', 'Añadir Órden')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
<!-- Vertical Wizard -->
<section class="vertical-wizard">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Datos Requeridos</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="{{ route('orders.store') }}" id="form_add_order" method="POST">
                        @csrf
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-6 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="customer_name">Nombre del Cliente</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="customer_name" class="form-control requerid @error('customer_name') is-invalid @enderror" name="customer_name"
                                        placeholder="Nombre" required/>
                                        @error('customer_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="table">Mesa</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="tag"></i></span>
                                        <input type="number" id="table" class="form-control requerid @error('table') is-invalid @enderror" name="table"
                                        placeholder="Mesa" required/>
                                        @error('table')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 mb-1">
                                <div class="mb-1">
                                    <div class="row justify-content-center">
                                        <h5 class="text-center mb-2">Añadir Platos</h5>
                                        <div class="col-12 col-md-6">
                                            <select class="select2 form-control" data-toggle="select" class="form-control" id="selected_dish">
                                                <option disabled selected value=''>Selecciona un Plato</option>
                                                @foreach ($dish_category as $item)
                                                    @if ( count( $item->collectionDishes($item->category_id) ) > 0 )
                                                        <optgroup label="{{ $item->category->name }}"> 
                                                            @foreach ($item->collectionDishes($item->category_id) as $dish)
                                                                <option data-price = {{ $dish->designated_price }} value="dish_{{ $dish->id }}">{{ $dish->name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-auto">
                                            <a class="btn btn-info" href="javascript:;" onclick="addRow();">
                                                <i class="" data-feather="plus-circle"></i> Añadir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>                                    

                            <div class="table-responsive">
                                <table class="table" id="items_table">
                                    <thead class="thead-light text-center">
                                        <th class="col-4">Plato</th>
                                        <th class="col-2">N°</th>
                                        <th class="col-3">Precio Unitario</th>
                                        <th class="col-3">Total</th>
                                        <th class="col-2"></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight: bold; font-size: 14px;">
                                            <td style="border-top: none !important;"></td>
                                            <td colspan="2" class="text-right">TOTAL</td>
                                            <td colspan="2" class="text-right" style="padding-right: 20px;"><input type="text" class="form-control" name="total_amount" id="total_amount" value="0.00" style="border: none !important; font-size: 14px !important;" readonly></td>
                                        </tr>
                                    </tfoot>
                                </table>           
                            </div> 
                        </div>
                        <div class="row justify-content-end mt-2">
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" id="add_order">
                                    <span class="loading_add_order mr-2"></span> Agregar
                                </button>
                                <a href="{{ route('dashboard-employee') }}"  class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection

@section('custom-js')
  <script>

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

