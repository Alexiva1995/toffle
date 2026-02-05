@extends('layouts/contentLayoutMaster')

@section('title', 'Agregar Pedido')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset('vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">

    @include('panels.datatable.styles')
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-wizard.css') }}">
@endsection

@section('content')
<!-- Vertical Wizard -->
<section class="vertical-wizard">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" id="content_order">
                <div class="card-header">
                    <div class="breadcrumb-wrapper">
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
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
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
                                                        <i class="icon_dish" data-feather="plus-circle"></i> 
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

                                        <h6 class="my-2">Platos en esta orden</h6>
                                        <p class="text-muted small mb-1">Aquí aparecen los platos que vas agregando; puedes eliminar si te equivocaste.</p>
                                        <div class="table-responsive mx-2 border rounded">
                                            <table class="table table-hover mb-0 table-striped" id="dish_to_order_table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-center">Plato</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center">Eliminar</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <div id="dish_to_order_table_placeholder" class="text-muted text-center py-3 small">Cargando platos…</div>
                                        <div id="dish_table_error" class="alert alert-danger py-2 small mt-2 d-none" role="alert"></div> 

                                        <div class="row justify-content-center mt-3">
                                            <div class="col-auto">
                                                <a onclick="completeOrder()" id="finalizar_orden" class="btn btn-primary me-1">
                                                     Finalizar Órden
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
  data-bs-backdrop="static" data-bs-keyboard="false"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content ingredients_details">
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
  <!-- Axios (necesario antes de custom-js para añadir plato y tabla) -->
  <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
  <!-- vendor files -->
  <script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/pickadate/picker.time.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/pickadate/legacy.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
  {{-- DataTables vienen del bundle Vite (app.js); no cargar de nuevo --}}
@endsection

@section('page-script')
  <!-- Page js files (jQuery ya viene en vendors.min.js; no cargar de nuevo para evitar que DataTable quede en otro contexto) -->
  <script src="{{ asset('js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endsection

@section('custom-js')
<script>
    // Configurar Axios para Laravel (CSRF y peticiones AJAX)
    (function(){
        var token = document.querySelector('meta[name="csrf-token"]');
        if (token) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    })();

    function completeOrder(){
        window.location.href = "{!! route('dashboard-employee') !!}";
    }

    function closeModal(){
        $("#modal_show_ingredients").modal("hide");
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
            this_button.prop('disabled', true).addClass('disabled');
            $('.icon_dish').addClass('d-none');
            $('.loading_add_dish').addClass('spinner-border spinner-border-sm');

            var completed = false;
            function resetButton() {
                this_button.prop('disabled', false).removeClass('disabled');
                $('.loading_add_dish').removeClass('spinner-border spinner-border-sm');
                $('.icon_dish').removeClass('d-none');
            }
            function safeReset() { completed = true; setTimeout(resetButton, 300); }

            axios.post("{{ route('order.add.dish', $order->id) }}", {
                dish_id: $('#dish_id').val(),
                unit: $('#units').val()
            }).then(function(res) {
                $('#total_amount').val(res.data);
                refreshDishTable();
                toastr['success']('', 'Plato añadido correctamente', { closeButton: true, tapToDismiss: false });
            }).catch(function(err) {
                var xhr = err.response;
                var msg = 'No se pudo añadir el plato.';
                if (xhr && xhr.data) {
                    if (xhr.data.errors) {
                        var e = xhr.data.errors;
                        msg = (e.dish_id && e.dish_id[0]) || (e.unit && e.unit[0]) || msg;
                    } else if (xhr.data.message) msg = xhr.data.message;
                }
                if (xhr && xhr.status === 419) msg = 'Sesión expirada. Recarga la página e intenta de nuevo.';
                if (xhr && xhr.status === 500) msg = 'Error en el servidor. Revisa la consola (F12).';
                toastr['error']('', msg, { closeButton: true, tapToDismiss: false });
            }).finally(safeReset);

            setTimeout(function() {
                if (!completed && this_button.prop('disabled')) {
                    completed = true;
                    resetButton();
                    toastr['warning']('', 'La petición tardó demasiado. Comprueba la conexión.', { closeButton: true });
                }
            }, 15000);
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
                                refreshDishTable();
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

                    $('#total_amount').val(data.total_amount);

                    modalDataModifyIngredients(order_id, code_operation, dish_id);
                    refreshDishTable();

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

            refreshDishTable();
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

                                console.log(data.total_amount);

                                $('#total_amount').val(data.total_amount);

                                modalDataModifyIngredients(order_id, code_operation, dish_id);
                                refreshDishTable();
                            }
                        );
                    }
                },
                cancelar: function () {
                },
            }
        });
    }

    var tableDishesUrl = '{{ route('orders.dishes.table.data.fallback', $order->id) }}';
    var tableDishesUrlFallback = '{{ route('orders.dishes.table.data', $order->id) }}';

    function setTableData(rows) {
        $('#dish_to_order_table_placeholder').hide();
        $('#dish_table_error').addClass('d-none').empty();
        if (typeof table !== 'undefined' && table && $.fn.DataTable.isDataTable('#dish_to_order_table')) {
            table.clear();
            table.rows.add(rows || []);
            table.draw();
        } else {
            initDishTable(rows || []);
        }
        if (typeof feather !== 'undefined') feather.replace();
    }

    function showTableError(reason) {
        $('#dish_to_order_table_placeholder').hide();
        $('#dish_table_error').removeClass('d-none').text(reason);
        setTableData([]);
    }

    function loadTableWithAxios() {
        $('#dish_table_error').addClass('d-none').empty();
        if (typeof window.axios === 'undefined') {
            showTableError('Axios no está cargado. Comprueba que el script de Axios se cargue en esta página.');
            return;
        }
        if (!tableDishesUrl) {
            showTableError('URL de la tabla no definida. Recarga la página.');
            return;
        }
        var opts = {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            timeout: 15000
        };
        function doRequest(url) {
            return window.axios.get(url, opts).then(function(res) {
                var rows = (res.data && res.data.data) ? res.data.data : [];
                setTableData(rows);
            });
        }
        function onFail(err, triedFallback) {
            var status = err.response ? err.response.status : null;
            var statusText = err.response ? err.response.statusText : '';
            var msg = err.response && err.response.data && err.response.data.message ? err.response.data.message : '';
            var reason = '';
            if (status === 404) reason = '404: Ruta no encontrada. URL: ' + tableDishesUrl;
            else if (status === 419) reason = '419: Token de sesión expirado. Recarga la página (F5).';
            else if (status === 500) reason = '500: Error del servidor. ' + (msg ? msg : 'Revisa storage/logs/laravel.log');
            else if (status) reason = status + ' ' + statusText + (msg ? ': ' + msg : '');
            else reason = 'Sin respuesta. URL: ' + tableDishesUrl + ' | ' + (err.message || '');
            console.error('Carga platos falló:', { status: status, url: tableDishesUrl, err: err });
            if (!triedFallback && tableDishesUrlFallback && (status === 404 || status === 0 || !status)) {
                window.axios.get(tableDishesUrlFallback, opts)
                    .then(function(res) {
                        var rows = (res.data && res.data.data) ? res.data.data : [];
                        setTableData(rows);
                    })
                    .catch(function(err2) {
                        toastr['error']('', 'No se pudieron cargar los platos.', { closeButton: true, tapToDismiss: false });
                        showTableError(reason);
                    });
            } else {
                toastr['error']('', 'No se pudieron cargar los platos.', { closeButton: true, tapToDismiss: false });
                showTableError(reason);
            }
        }
        doRequest(tableDishesUrl).catch(function(err) { onFail(err, false); });
    }

    function refreshDishTable() {
        loadTableWithAxios();
    }

    var initDishTableRetries = 0;
    function initDishTable(rows) {
        if (typeof $.fn.DataTable === 'undefined') {
            if (initDishTableRetries < 5) {
                initDishTableRetries++;
                setTimeout(function() { setTableData(rows); }, 300);
            } else {
                $('#dish_to_order_table_placeholder').hide();
                $('#dish_table_error').removeClass('d-none').text('DataTable no disponible. Recarga la página.');
            }
            return;
        }
        table = $('#dish_to_order_table').DataTable({
                data: rows || [],
                processing: false,
                ordering: true,
                searching: false,
                paging: false,
                info: false,
                language: {
                    url: '{!! asset('data/datatable/Spanish.json') !!}',
                    emptyTable: 'Aún no hay platos en esta orden. Agrega platos con el botón Añadir.'
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
                var field = $('td:eq(2)', elemt);
                var button = '<button class="btn btn-sm btn-danger" onclick="deleteDish({{ $order->id }}, '+data.pivot.code_operation+', '+data.pivot.id+', '+data.pivot.dish_id+')"><i data-feather="trash-2"></i></button>';
                field.html(button);
            }
        });
        if (typeof feather !== 'undefined') feather.replace();
    }

    $(document).ready(function () {
        $('#dish_id').change( function() {
          var price = $('option:selected',this).data("price");
          $('#price').val(price);
        });
    });
    $(window).on('load', function() {
        loadTableWithAxios();
    });
</script>
@endsection

