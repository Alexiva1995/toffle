@extends('layouts/contentLayoutMaster')

@section('title', 'Ventas')

@section('vendor-style')
@include('panels.datatable.styles')
@endsection

@section('page-style')
{{-- Page css files --}}
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
<style>
    /* * CORRECCIÓN CSS PARA 5 CARDS:
     * Si necesitas que los 5 cuadros queden ajustados en una sola fila en desktop (20% c/u),
     * puedes usar flexbox directamente en la fila si la clase col-lg-2 no es suficiente
     * o si tu versión de Bootstrap/tema no permite la clase 'col-lg-2-4'
     */
    @media (min-width: 1200px) {
        .row.metrics-row .col-lg-2-4 {
            flex: 0 0 auto;
            width: 20%;
        }
    }
</style>
@endsection

@section('content')
<section id="basic-datatable">
    {{-- INICIO: Sección de 5 Métricas --}}
    {{-- Se usa la clase 'row' estándar de Bootstrap para el diseño lado a lado --}}
    <div class="row metrics-row justify-content-start">

        {{-- 1. Total de Ventas --}}
        {{-- USO DE CLASES CORREGIDO: col-lg-2 para 5 en desktop, col-md-4 para 3 en tablet, col-6 para 2 en móvil --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-12">
                            <h4 class="card-text text-center mb-2" style="white-space: nowrap;">Total de Ventas</h4>
                            <div class="d-flex flex-row justify-content-center">
                                <div class="avatar bg-light-success me-1">
                                    <div class="avatar-content">
                                        <i data-feather="dollar-sign" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0" style="white-space: nowrap;">
                                        $ <span id="total_sales">0,00</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Costo de Productos Vendidos (CPV) --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-12">
                            <h4 class="card-text text-center mb-2" style="white-space: nowrap;">CPV</h4>
                            <div class="d-flex flex-row justify-content-center">
                                <div class="avatar bg-light-danger me-1">
                                    <div class="avatar-content">
                                        <i data-feather="tag" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0" style="white-space: nowrap;">
                                        $ <span id="cpv_cost">0,00</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Ganancia Total (Ventas - CPV) --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-12">
                            <h4 class="card-text text-center mb-2" style="white-space: nowrap;">Ganancia Total</h4>
                            <div class="d-flex flex-row justify-content-center">
                                <div class="avatar bg-light-primary me-1">
                                    <div class="avatar-content">
                                        <i data-feather="trending-up" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0" style="white-space: nowrap;">
                                        $ <span id="total_profit">0,00</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Costos Fijos --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-12">
                            <h4 class="card-text text-center mb-2" style="white-space: nowrap;">Costos Fijos</h4>
                            <div class="d-flex flex-row justify-content-center">
                                <div class="avatar bg-light-warning me-1">
                                    <div class="avatar-content">
                                        <i data-feather="briefcase" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0" style="white-space: nowrap;">
                                        $ <span id="fixed_cost">0,00</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. Imprevistos --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-12">
                            <h4 class="card-text text-center mb-2" style="white-space: nowrap;">Imprevistos</h4>
                            <div class="d-flex flex-row justify-content-center">
                                <div class="avatar bg-light-info me-1">
                                    <div class="avatar-content">
                                        <i data-feather="alert-triangle" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0" style="white-space: nowrap;">
                                        $ <span id="unexpected">0,00</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- FIN: Sección de 5 Métricas --}}

    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="row justify-content-init mt-1">
                            {{-- INICIO: Inputs de Fecha Separados --}}
                            <div class="col-12 col-md-3">
                                <label for="from_date">Fecha de Inicio</label>
                                <input type="text" class="form-control flatpickr-basic" placeholder="dd/mm/yyyy" id="from_date">
                            </div>

                            <div class="col-12 col-md-3">
                                <label for="to_date">Fecha Fin</label>
                                <input type="text" class="form-control flatpickr-basic" placeholder="dd/mm/yyyy" id="to_date">
                            </div>

                            <input type="hidden" id="from">
                            <input type="hidden" id="to">
                            {{-- FIN: Inputs de Fecha Separados --}}

                            {{-- Filtro de Categoría (Descomentar si es necesario) --}}
                            {{-- <div class="col-12 col-md-3">
                                <label for="category_id">Categorías</label>
                                <select class="select2 form-control" name="category_id" id="category_id"
                                    data-toggle="select" class="form-control">
                                    <option value="" selected>Seleccionar Todas</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-12 col-md-3">
                                <label for="status">Estados</label>
                                <select class="select2 form-control" name="status" id="status" data-toggle="select"
                                    class="form-control">
                                    <option value="" selected>Seleccionar Todas</option>
                                    <option value="0"> Pendientes </option>
                                    <option value="1"> En Espera </option>
                                    <option value="2"> Finalizados </option>
                                    <option value="3"> Cancelados </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="sales_table"> </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-start" id="modal_show_order_details" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content order_details">
        </div>
    </div>
</div>

@endsection

@section('custom-js')

@include('panels.datatable.scripts')

<script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/cleave/cleave.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
<script src="{{ asset('vendors/js/forms/tagging/tagging.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/select/select2.min.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/moment.min.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/flatpickr/locales/es.js') }}"></script>
<script>
    // Inicialización de Flatpickr
    flatpickr('#from_date', {
        dateFormat: 'Y-m-d',
        locale: 'es',
        onChange: function(selectedDates, dateStr, instance) {
            $('#from').val(dateStr);
            if (typeof table !== 'undefined') {
                table.draw();
            }
        }
    });

    flatpickr('#to_date', {
        dateFormat: 'Y-m-d',
        locale: 'es',
        onChange: function(selectedDates, dateStr, instance) {
            $('#to').val(dateStr);
            if (typeof table !== 'undefined') {
                table.draw();
            }
        }
    });

    // Variable para el formato de moneda (ajusta si tu moneda es diferente a COP, CL, AR, etc.)
    const numberFormatOptions = {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    };

    // Función central para obtener las fechas del filtro
    function getDates() {
        return {
            from: $('#from_date').val(),
            to: $('#to_date').val()
        };
    }

    // Calcula y dibuja el Total en ventas (Corregido el formato con toLocaleString)
    function getTotalSalesAmount(){
        var request = $.ajax({
            method: "GET",
            url: '{!! route('reports.total.sales.amount.data') !!}',
            data: getDates()
        });

        request.done(function(data) {
            // El controlador devuelve 'X.XXX.XXX,XX' (string), pero si devuelve un float, usamos el formato.
            // Para asegurar el formato correcto y evitar cortes, usamos Intl.NumberFormat si el dato es parseable.
            let formattedAmount = new Intl.NumberFormat('es-CO', numberFormatOptions).format(parseFloat(data.replace(/\./g, '').replace(/,/g, '.')) || 0);
            $('#total_sales').html(formattedAmount);
        });

        request.fail(function() {
            $('#total_sales').html('0,00');
        });
    }

    // Calcula y dibuja el CPV (Corregido el formato con toLocaleString)
    function getCPVAmount(){
        var request = $.ajax({
            method: "GET",
            // Asegúrate que esta ruta exista: reports.cpv.cost.data
            url: '{!! route('reports.cpv.cost.data') !!}',
            data: getDates()
        });

        request.done(function(data) {
            let formattedAmount = new Intl.NumberFormat('es-CO', numberFormatOptions).format(parseFloat(data.replace(/\./g, '').replace(/,/g, '.')) || 0);
            $('#cpv_cost').html(formattedAmount);
            // Llama al cálculo de la ganancia después de tener CPV y Ventas
            calculateTotalProfit();
        });

        request.fail(function() {
            $('#cpv_cost').html('0,00');
            calculateTotalProfit();
        });
    }

    // Calcula la Ganancia Total (Ventas - CPV)
    function calculateTotalProfit() {
        // Obtenemos los valores de las cards. Quitamos puntos de miles y cambiamos la coma decimal por punto.
        var totalSalesText = $('#total_sales').text().replace(/\./g, '').replace(/,/g, '.');
        var cpvCostText = $('#cpv_cost').text().replace(/\./g, '').replace(/,/g, '.');

        var totalSales = parseFloat(totalSalesText) || 0;
        var cpvCost = parseFloat(cpvCostText) || 0;

        var totalProfit = totalSales - cpvCost;

        // Muestra el resultado formateado
        let formattedProfit = new Intl.NumberFormat('es-CO', numberFormatOptions).format(totalProfit);
        $('#total_profit').html(formattedProfit);
    }

    // Calcula y dibuja Los Costos Fijos (Corregido el formato)
    function getfixedCostAmount(){
        var request = $.ajax({
            method: "GET",
            url: '{!! route('reports.fixed.cost.data') !!}',
            data: getDates()
        });

        request.done(function(data) {
            let formattedAmount = new Intl.NumberFormat('es-CO', numberFormatOptions).format(parseFloat(data.replace(/\./g, '').replace(/,/g, '.')) || 0);
            $('#fixed_cost').html(formattedAmount);
        });

        request.fail(function() {
            $('#fixed_cost').html('0,00');
        });
    }

    // Calcula el imprevisto (Corregido el formato)
    function getUnexpectedAmount(){
        var request = $.ajax({
            method: "GET",
            url: '{!! route('reports.unexpected.data') !!}',
            data: getDates()
        });

        request.done(function(data) {
            let formattedAmount = new Intl.NumberFormat('es-CO', numberFormatOptions).format(parseFloat(data.replace(/\./g, '').replace(/,/g, '.')) || 0);
            $('#unexpected').html(formattedAmount);
        });

        request.fail(function() {
            $('#unexpected').html('0,00');
        });
    }

    // Función central para actualizar todas las métricas
    function updateAllMetrics() {
        // Llamar a las métricas necesarias
        getTotalSalesAmount();
        getCPVAmount();
        getfixedCostAmount();
        getUnexpectedAmount();
    }


    $(document).ready(function () {
        // 1. Inicialización de DataTables
        table = $('#sales_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            pageLength: 50,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('reports.sales.data') !!}',
                data: function (d) {
                    // Pasar los valores de los inputs de fecha directamente al controlador
                    d.from = $('#from_date').val();
                    d.to = $('#to_date').val();
                    d.category_id = $('#category_id').val();
                    d.status = $('#status').val();
                }
            },
            columns: [
            {
                data: "id",
                name: "id",
                title: "# Pedido",
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
                    // Usar toLocaleString para formatear en la columna
                    let formattedAmount = new Intl.NumberFormat('es-CO', numberFormatOptions).format(parseFloat(data) || 0);
                    return '<strong class="text-success amount">$ ' + formattedAmount + '</strong>';
                }  
            },
            {
                data: "status",
                name: "status",
                title: "Estado",
                "class": "text-center",
                visible: true,
                searchable: true,
                render: function (data, type, row, meta) {
                    switch (row.status) {
                        case '0':
                            return '<span class="badge badge-light-warning">Pendiente</span>';
                            break;
                        case '1':
                            return '<span class="badge badge-light-info">En Espera</span>';
                            break;
                        case '2':
                            return '<span class="badge badge-light-success">Finalizado</span>';
                            break;
                        case '3':
                            return '<span class="badge badge-light-danger">Cancelado</span>';
                            break;
                        default:
                            break;
                    }
                }  
            },
            {
                data: "updated_at_timezone",
                name: "updated_at_timezone",
                title: "Fecha",
                "class": "text-center",
                visible: true,
                searchable: true,
            },
            {
                data: "id",
                name: "id",
                title: "Detalles",
                "class": "text-center",
                visible: true,
                searchable: true,
            },
            ],
            fnCreatedRow: function (elemt, data, iDataIndex) {
                // Lógica de creación de botones...
                var index = iDataIndex + 1;
                column=$('td:eq(4)', elemt);
                buttons='';
                button="<button type='button' class='btn btn-sm btn-primary' onclick='showOrderDetails("+data.id+")'> <i data-feather='eye'></i> </button>";
                buttons+=button;
                column=column.html(buttons);
            },

        }).on('processing.dt', function (e, settings, processing) {
            // Se actualiza la llamada a la función central de métricas CADA VEZ que la tabla se redibuja/filtra
            updateAllMetrics();
            feather.replace();
        });

        // 2. Inicialización del Filtro de Mes Actual (Para forzar el mes inicial al cargar la página)

        // Obtener el primer y último día del mes actual
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

        // Formatear a 'YYYY-MM-DD' que es lo que espera el controlador
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Mínimo 2 dígitos (01-12)

        const start_date_str = yyyy + '-' + mm + '-' + String(firstDay.getDate()).padStart(2, '0');
        const end_date_str = yyyy + '-' + mm + '-' + String(lastDay.getDate()).padStart(2, '0');

        // Establecer los valores iniciales en los inputs (solo si están vacíos para no interferir con la sesión)
        if ($('#from_date').val() === '') {
            $('#from_date').val(start_date_str);
        }
        if ($('#to_date').val() === '') {
            $('#to_date').val(end_date_str);
        }

        // 3. Eventos de filtro
        $('#status').change(function() {
            table.search('').draw();
        });

        $('#category_id').change(function() {
            table.search('').draw();
        });

        // 4. Carga inicial de métricas y tabla
        // DataTables ya se dibujará al final del 'ready' o al detectar los valores iniciales.
        updateAllMetrics();

    });

    // Función showOrderDetails (debe estar disponible globalmente)
    function showOrderDetails(orderId) {
        // Debes implementar esta lógica si aún no lo has hecho
        // Ejemplo:
        // $.ajax({
        //     url: '/orders/' + orderId + '/details', // Asegúrate de tener esta ruta
        //     success: function(data) {
        //         $('.order_details').html(data);
        //         $('#modal_show_order_details').modal('show');
        //     }
        // });
        console.log("Mostrando detalles de la orden: " + orderId);
    }
</script>

@endsection
