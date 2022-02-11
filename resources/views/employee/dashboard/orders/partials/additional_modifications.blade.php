@extends('layouts/contentLayoutMaster')

@section('title', 'Moficaciones Adicionales')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

    @include('panels.datatable.styles')
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

                                <div class="row justify-content-center my-2">
                                  <div class="col-auto">
                                      <span><strong>TOTAL =</strong> {{ $order->total_amount }} </span>
                                  </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table" id="dish_to_order_table"> </table>
                                    {{-- <table class="table" id="items_table">
                                        <thead class="thead-light text-center">
                                            <th class="text-center">Plato</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Precio Unitario</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Detalles</th>
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
                                                        @if ($order->productRequiresFlavor($order->id, $item->pivot->id) == true)
                                                            <span class="text-danger"><i data-feather="edit"></i> </span>
                                                            Se debe agregar el sabor a uno de los ingredientes de este plato.
                                                        @else
                                                            <span class="text-center text-primary"> ---- </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center"> 
                                                        <button class="btn btn-sm btn-info" onclick="modifyIngredients({{ $order->id }}, {{ $item->pivot->id }}, {{ $item->pivot->dish_id }})"> 
                                                            <i data-feather="edit"></i> 
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>            --}}
                                </div> 

                                <div class="row justify-content-center mt-2">
                                    <div class="col-auto">
                                        <a href="{{ route('check.order.ingredients', $order->id) }}" class="btn btn-primary">
                                            Finalizar
                                        </a>
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
  <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('custom-js')

    @include('panels.datatable.scripts')

  <script>

    submitForms('#add_order', '.loading_add_order', '#form_add_order');

    function dataDetails(td, rowData) {
        $(td).html(rowData.details);
    }

    $(document).ready(function () {
        table = $('#dish_to_order_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            searching: false, 
            paging: false, 
            info: false,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('orders.dishes.table.data', $order->id) !!}',
                data: function (d) {
                }
            },
            columns: [
                {
                    data: "name",
                    name: "name",
                    title: "Plato",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                {
                    data: "pivot.unit",
                    name: "pivot.unit",
                    title: "Cantidad",
                    "class": "text-center",
                    visible: true,
                    searchable: true
                },
                {
                    data: "pivot.price",
                    name: "pivot.price",
                    title: "Precio Unitario",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                    render: function (data, type, row, meta) {
                        return row.pivot.price.toFixed(2);
                    }  
                },
                {
                    data: "pivot.price",
                    name: "pivot.price",
                    title: "Total",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                    render: function (data, type, row, meta) {
                        return ( row.pivot.price * row.pivot.unit ).toFixed(2);
                    }  
                },
                {
                    data: "details",
                    name: "details",
                    title: "Detalles",
                    "class": "text-center",
                    visible: true,
                    searchable: true, 
                    render: function (data, type, row) {
                        return $("<div/>").html(row.details).text();
                    }
                },
                {
                    data: "pivot.id",
                    name: "pivot.id",
                    title: "Ingredientes",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },

            ],
            fnCreatedRow: function (elemt, data, iDataIndex) {
                var indice = iDataIndex + 1;

                field=$('td:eq(5)', elemt);
                buttons='';

                button = '<button class="btn btn-sm btn-info" onclick="modifyIngredients({{ $order->id }}, '+data.pivot.id+', '+data.pivot.dish_id+')"> <i data-feather="edit"></i></button>'
                buttons+=button;
                field=field.html(buttons);
            },

            }).on('processing.dt', function (e, settings, processing) {
            feather.replace();
        });

    });

    function modifyIngredients(order_id, pivot_id, dish_id) {
        $.get("{{ route('orders.modal.modify.ingredients') }}", { order_id: order_id, pivot_id: pivot_id, dish_id: dish_id},
            function (data, textStatus, jqXHR) {
                $('.ingredients_details').html(data);
                $("#modal_show_ingredients").modal("show");
                feather.replace();
            }
        );
    }

    function modalDataModifyIngredients(order_id, pivot_id, dish_id) {
        $.get("{{ route('orders.modal.modify.ingredients') }}", { order_id: order_id, pivot_id: pivot_id, dish_id: dish_id},
            function (data, textStatus, jqXHR) {
                $('.ingredients_details').html(data);
                feather.replace();
            }
        );
    }

    function addIngredient(order_id, pivot_id, dish_id) {

        if (($("#ingredient option:selected").val() == null || $("#ingredient option:selected").val() == '') || ($("#portion").val() == null || $("#portion").val() == '')) {
          toastr['error']('', 'Debes seleccionar un ingrediente y la porción del mismo para agregarlo.', {
              closeButton: true,
              tapToDismiss: false,
          });

          $('#ingredient').addClass('is-invalid');
          $('#portion').addClass('is-invalid');

        }else{

            var this_button = $('#add_ingredient_order');
            this_button.attr('disabled', 'disabled').addClass('disabled');
            $('#loading_add_ingredient_order').addClass('spinner-border spinner-border-sm');

            $.post("{{ route('orders.add.ingredients') }}", { order_id: order_id, pivot_id: pivot_id, dish_id: dish_id, inventory_id: $("#ingredient option:selected").val(), portion: $("#portion").val()},
                function (data, textStatus, jqXHR) {
                    toastr['success']('', 'Ingrediente añadido exitosamente', {
                        closeButton: true,
                        tapToDismiss: false,
                    });

                    modalDataModifyIngredients(order_id, pivot_id, dish_id);

                    table.search('').draw();

                    setTimeout(() => {
                        this_button.removeAttr('disabled').removeClass('disabled');
                        $('#loading_add_ingredient_order').removeClass('spinner-border spinner-border-sm');
                    },1000)
                }
            );
        }
    }

    function updateFlavorName(element, order_id, id) {
        let input = element;

        $.post("{{ route('orders.update.ingredients') }}", { order_id: order_id, id: id, flavor_name: $('#flavor_name_'+id).val()})
        .done(function(data){
            $(input).removeClass('is-invalid')
            $(input).addClass('is-valid')
            setTimeout(() => {
                $(input).removeClass('is-valid')
            },1000)

            table.search('').draw();
        })
        .fail(function(xhr, status, error) {
            $(input).addClass('is-invalid')
        });
    }

    function deleteIngredient(order_id, pivot_id, dish_id, id) {

        $.confirm({
            title: 'Confirmar!',
            content: 'Estas seguro que quieres eliminar este Ingrediente ?',
            columnClass: 'col-12 col-md-4 col-xs-4',
            containerFluid: true,
            buttons: {
                confirm: {
                    text: 'Eliminar',
                    btnClass: 'btn-danger',
                    action: function () {
                        $.post("{{ route('orders.remove.ingredients') }}", { order_id: order_id, id: id, pivot_id:pivot_id, dish_id: dish_id },
                            function (data, textStatus, jqXHR) {
                                toastr['success']('', 'El Ingrediente fue Removido exitosamente', {
                                    closeButton: true,
                                    tapToDismiss: false,
                                });

                                modalDataModifyIngredients(order_id, pivot_id, dish_id);

                                table.search('').draw();
                            }
                        );
                    }
                },
                cancelar: function () {
                },
            }
        });
    }
  </script>
@endsection

