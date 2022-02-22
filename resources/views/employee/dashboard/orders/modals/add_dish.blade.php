
<div class="modal-header">
    <h4>Agregar Platos</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="breadcrumb-wrapper mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard-employee') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                Agregar Platos
            </li>
        </ol>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="bs-stepper horizontal-wizard-example" style="box-shadow:none">
                <div class="bs-stepper-header" role="tablist">
                    <div class="step" data-target="#general-data" role="tab" id="general-data-trigger">
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
                    <div class="step active" data-target="#add-dishes" role="tab" id="add-dishes-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">2</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Platos</span>
                                <span class="bs-stepper-subtitle">Agregar platos de la órden y modificar sus ingredientes</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i data-feather="chevron-right" class="font-medium-2"></i>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <div id="add-dishes" class="content active" role="tabpanel" aria-labelledby="add-dishes-trigger">
                        <div class="content-header">
                            <h5 class="mb-0">Agregar Platos</h5>
                            <small class="text-muted">Agregar platos de la órden y modificar sus ingredientes.</small>
                        </div>
                        <form class="form form-vertical">
                            @csrf
                            <h5 class="mb-2 text-center">Añadir Platos</h5>
                            <div class="row justify-content-center align-items-center">
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
                                <div class="col-auto mb-1">
                                    <a class="btn btn-info" id="add_dish">
                                        <i data-feather="plus-circle"></i> 
                                        <span class="loading_add_dish mr-2"></span>
                                        Añadir
                                    </a>
                                </div>
                            </div>
                        </form> 
    
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
    
                        <div class="table-responsive mx-2">
                            <table class="table" id="dish_to_order_table">
                            </table>           
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn btn-primary" id="add_order">
        <span class="loading_add_order mr-2"></span> Finalizar Órden
    </a>
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
</div>

<script>

    // $('#dish_id').select2({
    //     dropdownParent: $('#modal_add_order')
    // });

    $(document).on('click', '#add_dish', function () {
        button = $(this);

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
            // button.attr('disabled', 'disabled').addClass('disabled');
            // $('.icon_dish').addClass('d-none');
            // $('#loading_add_dish').addClass('spinner-border spinner-border-sm');

            $.post("{{ route('order.add.dish', $order->id) }}", { dish_id: $('#dish_id').val(), unit: $('#units').val() })
            .done(function(data){
                table.search('').draw();
                setTimeout(() => {
                    button.removeAttr('disabled').removeClass('disabled');
                    $('#loading_add_dish').removeClass('spinner-border spinner-border-sm');
                    $('.icon_dish').removeClass('d-none');
                },1000)

                $('#total_amount').val(data);
            })
            .fail(function(data) {
            });
        }
    });

    function deleteDish(order_id, pivot_id) {
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
                        $.post("{{ route('order.remove.dish', $order->id) }}", { order_id: order_id, pivot_id:pivot_id},
                            function (data, textStatus, jqXHR) {
                                toastr['success']('', 'El Plato fue Removido exitosamente', {
                                    closeButton: true,
                                    tapToDismiss: false,
                                });

                                table.search('').draw();
                                $('#total_amount').val(data);
                            }
                        );
                    }
                },
                cancelar: function () {
                },
            }
        });
    }

    function editOrder(element) {
        let item = {}
        let input = element

        item [element.attributes.name.value] = element.value;
        item ['form'] = 'edit_order';

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

    function dataDetails(td, rowData) {
        $(td).html(rowData.details);
    }


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
</script>