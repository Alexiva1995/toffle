@extends('layouts/contentLayoutMaster')

@section('title', 'Moficaciones Adicionales')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')
<!-- Vertical Wizard -->
<section class="vertical-wizard">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard-employee') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                Modificaciones Adicionales
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card-body">
                    <section class="horizontal-wizard">
                        <div class="bs-stepper horizontal-wizard-example">
                          <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#account-details" role="tab" id="account-details-trigger">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">1</span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">Agregar Pedido</span>
                                  <span class="bs-stepper-subtitle">Se agregara el pedido con  los datos generales</span>
                                </span>
                              </button>
                            </div>
                            <div class="line">
                              <i data-feather="chevron-right" class="font-medium-2"></i>
                            </div>
                            <div class="step active" data-target="#personal-info" role="tab" id="personal-info-trigger">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">Modificaciones Adicionales</span>
                                  <span class="bs-stepper-subtitle">Podrán moficarse los ingredientes de los platos</span>
                                </span>
                              </button>
                            </div>
                            <div class="line">
                              <i data-feather="chevron-right" class="font-medium-2"></i>
                            </div>
                          </div>
                          <div class="bs-stepper-content">
                            <div id="personal-info" class="content active" role="tabpanel" aria-labelledby="personal-info-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">Modificaciones Adicionales</h5>
                                    <small class="text-muted">Podrán moficarse los ingredientes de los platos.</small>
                                </div>

                                <h4 class="text-center mb-2">Platos del Pedido </h4>
                                
                                <div class="table-responsive">
                                    <table class="table" id="items_table">
                                        <thead class="thead-light text-center">
                                            <th class="text-center">Plato</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Precio Unitario</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Detalle</th>
                                            <th class="text-center">Ingredientes</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->dishes()->get() as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $item->name }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $item->pivot->unit }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format( $item->pivot->price, 2, '.', '' ) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format( $item->pivot->unit *  $item->pivot->price, 2, '.', '' ) }}
                                                    </td>
                                                    <td class="text-center"> 
                                                       {{ $order->productRequiresFlavor($order->id, $item->pivot->dish_id) }} 
                                                    </td>
                                                    <td class="text-center"> 
                                                        <button class="btn btn-sm btn-info"> 
                                                            <i data-feather="edit"></i> 
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>           
                                </div> 

                                <div class="row justify-content-center mt-2">
                                    <div class="col-auto">
                                        <span><strong>TOTAL =</strong> {{ $order->total_amount }} </span>
                                    </div>
                                </div>

                                <div class="row justify-content-center mt-2">
                                    <div class="col-auto">
                                        <button class="btn btn-primary" id="add_order">
                                            <span class="loading_add_order mr-2"></span> Finalizar
                                        </button>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </section>
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
  <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection

@section('custom-js')
  <script>

      submitForms('#add_order', '.loading_add_order', '#form_add_order');

      numRows = 0;
      
    //   var ids = [];

      function addRow(){

        var repeated = false;

        if ($("#selected_dish option:selected").val() == null || $("#selected_dish option:selected").val() == '') {
            toastr['error']('', 'Debes seleccionar primero un plato, para luego añadirlo', {
                  closeButton: true,
                  tapToDismiss: false,
            });
        }else{

            // for(var i = 0; i < ids.length; i++){
            //     if(ids[i] == $("#selected_dish option:selected").val() ){ 
            //       repeated = true;
            //     }           
            // }

            if (!repeated) {
                // ids.push( $("#selected_dish option:selected").val() );
                numRows++;
                let content = '<tr id="row_'+numRows+'">\
                <td><input type="text" name="dish[]" class="form-control dish text-center" id="dish_'+numRows+'" value="'+$("#selected_dish option:selected").text()+'" required disabled></td>\
                <input type="hidden" name="dish_ids[]" class="form-control dish_ids text-center" id="dish_ids_'+numRows+'" value="'+$("#selected_dish option:selected").val()+'" required>\
                <td><input type="number" name="unit[]" class="form-control units text-center" id="unit_'+numRows+'" value="'+$("#plate_quantity").val()+'" oninput="calculate('+numRows+')" required></td>\
                <td><input type="text" name="price[]" class="form-control price text-center" id="price_'+numRows+'" value="'+$("#selected_dish option:selected").data("price").toFixed(2)+'" readonly required></td>\
                <td><input type="text" name="total[]" class="form-control total text-center" id="total_'+numRows+'" value="'+$("#selected_dish option:selected").data("price")+'" readonly></td>\
                <td><a href="javascript:;" onclick="deleteRow('+numRows+')"> <i class="text-danger" data-feather="x-circle"></i> </a></td>\
                </tr>';
                $("#items_table>tbody").append(content);
                feather.replace();
                $("#selected_dish").val("").trigger('change');
                $("#plate_quantity").val("");

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

