@extends('layouts/contentLayoutMaster')

@section('title', 'Editar Pedido')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@include('panels.datatable.styles')
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')

<section id="vertical-wizard">
    <div class="row justify-content-center mt-2">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard-employee') }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    Editar Pedido
                                </li>
                            </ol>
                      </div>
                </div>
                <div class="card-body px-2">
                    <h4 class="text-center mb-3">Datos del Pedido</h4>
                    <form class="form form-vertical mb-3" action="{{ route('orders.update', $order->id) }}" id="form_edit_order" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-4 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="customer_name">Nombre del Cliente</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="customer_name" class="form-control requerid" name="customer_name" value="{{ $order->customer_name }}" placeholder="Nombre" oninput="updateOrder(this)" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="table">Mesa</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="tag"></i></span>
                                        <input type="number" id="table" class="form-control requerid" name="table" value="{{ $order->table }}" placeholder="Mesa" oninput="updateOrder(this)" required/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 mb-2">
                                <h5 class="text-center">Estado</h5>
                                <div class="row justify-content-center @error('status') is-invalid @enderror">
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input border border-primary" type="checkbox" name="status" id="pending" value="0" {{ $order->status == 0 ? 'checked' : '' }} oninput="updateOrder(this)" />
                                            <label class="form-check-label" for="pending">Pendiente</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input border border-primary" type="checkbox" name="status" id="on_hold" value="1" {{ $order->status == 1 ? 'checked' : '' }} oninput="updateOrder(this)" />
                                            <label class="form-check-label" for="on_hold">En Espera</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input border border-primary" type="checkbox" name="status" id="finalized" value="2" {{ $order->status == 2 ? 'checked' : '' }} oninput="updateOrder(this)" />
                                            <label class="form-check-label" for="finalized">Finalizado</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input border border-primary" type="checkbox" name="status" id="cancelled" value="3" {{ $order->status == 3 ? 'checked' : '' }} oninput="updateOrder(this)" />
                                            <label class="form-check-label" for="cancelled">Cancelado</label>
                                        </div>  
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row justify-content-center mb-3">
                        <form class="form form-vertical" action="{{ route('order.add.dish', $order->id) }}" id="form_add_order" method="POST">
                            @csrf
                            <div class="row justify-content-center align-items-center">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <h5 class="mb-2 text-center">Añadir Platos</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-md-4 mb-1">           
                                                <select class="select2 form-control" data-toggle="select" class="form-control" id="dish_id">
                                                    <option disabled selected value=''>Selecciona un Plato</option>
                                                    @foreach ($dish_category as $item)
                                                        @if ( count( $item->collectionDishes($item->category_id) ) > 0 )
                                                            <optgroup label="{{ $item->category->name }}"> 
                                                                @foreach ($item->collectionDishes($item->category_id) as $dish)
                                                                    <option data-price = {{ $dish->designated_price }} value="{{ $dish->id }}">{{ $dish->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-12 col-md-4 mb-1">
                                                <input type="number" id="units" class="form-control" placeholder="Cantidad"/>
                                            </div>

                                            <div class="col-auto">
                                                <a class="btn btn-info" id="add_dish">
                                                    <i class="icon_dish" data-feather="plus-circle"></i> 
                                                    <span class="loading_add_dish mr-2"></span>
                                                    Añadir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                        </form> 
                    </div>

                    <div class="row justify-content-center my-2">
                        <div class="col-auto">

                            <div class="mb-1 row justify-content-center align-items-center">
                                <label for="total_amount" class="col-auto" style="font-size:15px">Monto Total:</label>
                                <div class="col-auto">
                                  <input type="number" id="total_amount" class="form-control requerid" name="total_amount" value="{{ $order->total_amount }}" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-3 mx-2">
                        <table class="table" id="dish_to_order_table">
                        </table>           
                    </div> 

                    <div class="row justify-content-center mt-3">
                        <div class="col-auto" id="dash-btn">
                            <a onclick="backToDash()" class="btn btn-primary me-1">
                                Volver al Dashboard
                            </a>
                        </div>
                    </div>
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

@endsection

@section('page-script')

<script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('custom-js')

    @include('panels.datatable.scripts')
    <script>
        const flavorAlert = () =>{
            toastr['error']('', 'El sabor es requerido', {
                closeButton: true,
                tapToDismiss: false,
            });
        }
        function backToDash(){
            let marcador = $('.helado span').html();
            let dash_btn = $('#dash-btn');
            let url = "{!! route('dashboard-employee')!!}";
            if( marcador == 'Seleccione un sabor ') flavorAlert();
            else window.location.href = url;
        }
        function closeModal(){
            let select_array = $('td select');
            let err = 0;
            for(let i = 0; i < (select_array.length); i++)
            {
                if(select_array[i].value == 'none') err++;
            }
            if(err > 0) flavorAlert();
            else $("#modal_show_ingredients").modal("hide");
        }

        $(document).on('click', '#add_dish', function () {
            this_button = $(this);
    
            if (($('#dish_id').val() == null || $('#dish_id').val() == '') && ($('#units').val() == null || $('#units').val() == '')) {
    
                $('#dish_id').addClass('is-invalid');
                $('#units').addClass('is-invalid');
                toastr['error']('', 'El plato es requerido', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                toastr['error']('', 'Las unidades por plato son requeridas', {
                    closeButton: true,
                    tapToDismiss: false,
                });
    
            }else if ($('#dish_id').val() == null || $('#dish_id').val() == ''){
                $('#dish_id').addClass('is-invalid');
                toastr['error']('', 'El plato es requerido', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }else if ($('#units').val() == null || $('#units').val() == ''){
                $('#units').addClass('is-invalid');
                toastr['error']('', 'Las unidades por plato son requeridas', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }else{
                this_button.attr('disabled', 'disabled').addClass('disabled');
                $('.icon_dish').addClass('d-none');
                $('.loading_add_dish').addClass('spinner-border spinner-border-sm');
    
                $.post("{{ route('order.add.dish', $order->id) }}", { dish_id: $('#dish_id').val(), unit: $('#units').val() })
                .done(function(data){
                    table.search('').draw();
                    setTimeout(() => {
                        this_button.removeAttr('disabled').removeClass('disabled');
                        $('.loading_add_dish').removeClass('spinner-border spinner-border-sm');
                        $('.icon_dish').removeClass('d-none');
                    },1000)
    
                    $('#total_amount').val(data);
                })
                .fail(function(data) {
                });
            }
        });
    
        function deleteDish(order_id, code_operation, dish_id) {
            $.confirm({
                title: 'Confirmar!',
                content: 'Estas seguro que quieres eliminar este Plato?',
                columnClass: 'col-12 col-md-4 col-xs-4',
                containerFluid: true,
                buttons: {
                    confirm: {
                        text: 'Eliminar',
                        btnClass: 'btn-danger',
                        action: function () {
                            $.post("{{ route('order.remove.dish', $order->id) }}", { order_id: order_id, code_operation:code_operation},
                                function (data, textStatus, jqXHR) {
                                    table.search('').draw();
                                    $('#total_amount').val(data);
    
                                    toastr['success']('', 'El Plato fue Removido exitosamente', {
                                        closeButton: true,
                                        tapToDismiss: false,
                                    });
                                }
                            );
                        }
                    },
                    cancelar: function () {
                    },
                }
            });
        }
    
        function updateOrder(element, id = null) {
            let marcador = $('.helado span').html();
            let dash_btn = $('#dash-btn');
            let url = "{!! route('dashboard-employee')!!}";
            let pending = $('#pending');
            if( marcador == 'Seleccione un sabor ')
            {
                toastr['error']('', 'El sabor es requerido', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                pending.prop('checked', true);
            }else{
                let item = {}
                let input = element

                if (element.attributes.name.value == 'is_for_carry' && $(element).is(':checked')) {
                    item [element.attributes.name.value] = 1;
                    item ['id'] = id;
                    item ['form'] = 'update_order_dish';
                }else if(element.attributes.name.value == 'is_for_carry'){
                    item [element.attributes.name.value] = 0;
                    item ['id'] = id;
                    item ['form'] = 'update_order_dish';
                }

                if(element.attributes.name.value != 'is_for_carry'){
                    item [element.attributes.name.value] = element.value;
                    item ['form'] = 'update_general_data';
                }

                item ['_method'] = 'PATCH';

                $.post('{{ route('orders.update', $order->id) }}', item)
                .done(function(data){
                    $(input).removeClass('is-invalid')
                    $(input).addClass('is-valid')
                    setTimeout(() => {
                        $(input).removeClass('is-valid')
                    },1000)
                })
                .fail(function(data) {
                    data_errors = data.responseJSON.errors;
                    errors = Object.values(data_errors);
                    for (var i = 0; i < errors.length; i++){
                        toastr['error']('', errors[i][0], {
                            closeButton: true,
                            tapToDismiss: false,
                        });
                    }
                    $(input).addClass('is-invalid')
                });
            }
        }

        // function updateOrder(element) {
        //     let item = {}
        //     let input = element
    
        //     item [element.attributes.name.value] = element.value;
        //     item ['form'] = 'update_general_data';
    
        //     item ['_method'] = 'PATCH';
    
        //     $.post('{{ route('orders.update', $order->id) }}', item)
        //     .done(function(data){
        //         $(input).removeClass('is-invalid')
        //         $(input).addClass('is-valid')
        //         setTimeout(() => {
        //             $(input).removeClass('is-valid')
        //         },1000)
        //     })
        //     .fail(function(data) {
        //         data_errors = data.responseJSON.errors;
        //         errors = Object.values(data_errors);
        //         for (var i = 0; i < errors.length; i++){
        //             toastr['error']('', errors[i][0], {
        //                 closeButton: true,
        //                 tapToDismiss: false,
        //             });
        //         }
        //         $(input).addClass('is-invalid')
        //     });
        // }
    
        function dataDetails(td, rowData) {
            $(td).html(rowData.details);
        }
    
    
        function modifyIngredients(order_id, code_operation, dish_id) {
            $.get("{{ route('orders.modal.modify.ingredients') }}", { order_id: order_id, code_operation: code_operation, dish_id: dish_id},
                function (data, textStatus, jqXHR) {
                    $('.ingredients_details').html(data);
                    $("#modal_show_ingredients").modal("show");
                    feather.replace();
                }
            );
        }

        
    
        function modalDataModifyIngredients(order_id, code_operation, dish_id) {
            $.get("{{ route('orders.modal.modify.ingredients') }}", { order_id: order_id, code_operation: code_operation, dish_id: dish_id},
                function (data, textStatus, jqXHR) {
                    $('.ingredients_details').html(data);
                    feather.replace();
                }
            );
        }
    
        function addIngredient(order_id, code_operation, dish_id) {
            if (($("#ingredient option:selected").val() == null || $("#ingredient option:selected").val() == '') || ($("#portion").val() == null || $("#portion").val() == '')) {
                toastr['error']('', 'Debes seleccionar un ingrediente y la porción del mismo para agregarlo.', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                $('#ingredient').addClass('is-invalid');
                $('#portion').addClass('is-invalid');
            }else{
                var this_button = $('#btn_add_ingredient');
                this_button.attr('disabled', 'disabled').addClass('disabled');
                $('.loading_add_ingredient_order').addClass('spinner-border spinner-border-sm');
    
                $.post("{{ route('orders.add.ingredients') }}", { order_id: order_id, code_operation: code_operation, dish_id: dish_id, inventory_id: $("#ingredient option:selected").val(), portion: $("#portion").val()},
                    function (data, textStatus, jqXHR) {
                        toastr['success']('', 'Ingrediente añadido exitosamente', {
                            closeButton: true,
                            tapToDismiss: false,
                        });
    
                        modalDataModifyIngredients(order_id, code_operation, dish_id);
                        table.search('').draw();
    
                        setTimeout(() => {
                            this_button.removeAttr('disabled').removeClass('disabled');
                            $('.loading_add_ingredient_order').removeClass('spinner-border spinner-border-sm');
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
    
        function deleteIngredient(order_id, code_operation, dish_id, pivot_id) {
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
                            $.post("{{ route('orders.remove.ingredients') }}", { order_id: order_id, pivot_id: pivot_id, dish_id: dish_id},
                                function (data, textStatus, jqXHR) {
                                    toastr['success']('', 'El Ingrediente fue Removido exitosamente', {
                                        closeButton: true,
                                        tapToDismiss: false,
                                    });
    
                                    modalDataModifyIngredients(order_id, code_operation, dish_id);
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
    
        $(document).ready(function () {
    
            $('#dish_id').change( function() {
              var price = $('option:selected',this).data("price");
              $('#price').val(price);
            });
    
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
                // {
                //   data: "pivot.unit",
                //   name: "pivot.unit",
                //   title: "Cantidad",
                //   "class": "text-center",
                //   visible: true,
                //   searchable: true
                // },
                // {
                //   data: "pivot.price",
                //   name: "pivot.price",
                //   title: "Precio Unitario",
                //   "class": "text-center",
                //   visible: true,
                //   searchable: true,
                //   render: function (data, type, row, meta) {
                //       return row.pivot.price.toFixed(2);
                //   }  
                // },
                {
                    data: "[relleno]",
                    name: "pivot.id",
                    title: "Sabor de Helado",
                    "class": "text-center helado",
                    visible: true,
                    searchable: true,
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
                // {
                //     data: "pivot.id",
                //     name: "pivot.id",
                //     title: "Para Llevar",
                //     "class": "text-center",
                //     visible: true,
                //     searchable: true,
                // },
                {
                    data: "pivot.id",
                    name: "pivot.id",
                    title: "Eliminar",
                    "class": "text-center",
                    visible: true,
                    searchable: true,
                },
                //   {
                //       data: "details",
                //       name: "details",
                //       title: "Detalles",
                //       "class": "text-center",
                //       visible: true,
                //       searchable: true, 
                //       render: function (data, type, row) {
                //           return $("<div/>").html(row.details).text();
                //       }
                //   },
                // {
                //   data: "pivot.id",
                //   name: "pivot.id",
                //   title: "Ingredientes",
                //   "class": "text-center",
                //   visible: true,
                //   searchable: true,
                //  },
            ],
            fnCreatedRow: function (elemt, data, iDataIndex) {
                var indice = iDataIndex + 1;

                field=$('td:eq(3)', elemt);
                buttons='';

                var checked = "";
                if (data.pivot.is_for_carry == 1) {
                    checked = "checked";
                }
                /* Inicio Opcion para llevar  */
                /*
                button = '<input type="hidden" name="is_for_carry" value="0"/><input class="form-check-input border border-primary" type="checkbox" name="is_for_carry" id="is_for_carry" value="1" '+checked+'  oninput="updateOrder(this, '+data.pivot.id+')"/>'
                buttons+=button;
                field=field.html(buttons);
                */
                /* Inicio Opcion para llevar  */
                if(data.name.includes('Helado') || data.category_id == 4){
                    field=$('td:eq(1)', elemt);
                    buttons='';
                    button = '<span>'+ (data.flavor != null ? data.flavor : 'Seleccione un sabor') +' </span><button class="btn btn-sm btn-info" onclick="modifyIngredients({{ $order->id }}, '+data.pivot.code_operation+', '+data.pivot.dish_id+')"><i data-feather="edit"></i></button>'
                    buttons+=button;
                    field=field.html(buttons);
                }
                

                field=$('td:eq(3)', elemt);
                buttons='';
                button = '<button class="btn btn-sm btn-danger" onclick="deleteDish({{ $order->id }}, '+data.pivot.code_operation+', '+data.pivot.id+', '+data.pivot.dish_id+')"> <i data-feather="trash-2"></i></button>'
                buttons+=button;
                field=field.html(buttons);
            },

            }).on('processing.dt', function (e, settings, processing) {
            feather.replace();
        });
        });
    </script>
@endsection