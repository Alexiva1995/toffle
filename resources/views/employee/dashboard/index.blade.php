@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    @include('panels.datatable.styles')
@endsection
@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection


@section('content')
    <section id="dashboard-ecommerce">
        <div class="row match-height justify-content-center">

            <div class="col-xl-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Buscar Cliente por Cédula</h4>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" id="client_id_card" class="form-control" placeholder="Cédula del Cliente">
                            <button class="btn btn-primary" type="button" id="search_client">Buscar</button>
                        </div>
                        <div id="client_info" class="mt-2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-12">
                <div class="card card-congratulation-medal">
                    <div class="col-xl-12 col-md-12 col-12" id="statistics"></div>
                    <h4 class="fw-bolder mb-1"> Ventas = <span class="text-success">
                            {{ number_format($orders_today->sum('total_amount'), 0, ' ', '.') }} COP</span></h4>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg btn-block btn-center-height"
                        role="button" aria-pressed="true">Agregar Pedido</a>
                </div>
            </div>

            <div class="col-12">
                @include('employee.dashboard.orders.pending')
            </div>
        </div>

        <div class="modal fade text-start" id="modal_show_order_details" tabindex="-1" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content order_details">
                </div>
            </div>
        </div>
    </section>
@endsection

    @section('vendor-script')
        {{-- vendor files --}}
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
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
                var id = '#' + type;

                $.get(route, {},
                    function(data, textStatus, jqXHR) {
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

            $(document).on('click', '.update_status', function() {
                let item = {};
                let input = this;
                let $button = $(this);
                let originalButtonContent = $button.html();

                // Deshabilitar el botón y mostrar indicador de carga
                $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Cargando...');

                item['status'] = this.value;
                item['form'] = 'update_general_data';

                var url = "{{ route('orders.update', 'id') }}";
                url = url.replace('id', $(this).data('id'));

                item['_method'] = 'PATCH';
                $.post(url, item)
                    .done(function(data) {
                        if ('error' in data) {
                            toastr['error']('', data.message, {
                                closeButton: true,
                                tapToDismiss: false,
                            });
                            restoreButton();
                        } else {
                            $(input).removeClass('is-invalid').addClass('is-valid');

                            // Recargar los datos y la tabla
                            Promise.all([
                                loadDataAsync('statistics'),
                                loadDataAsync('order_history'),
                                loadDataAsync('cash_flow')
                            ]).then(() => {
                                table.ajax.reload(function() {
                                    restoreButton();
                                    setTimeout(() => {
                                        $(input).removeClass('is-valid');
                                    }, 1000);
                                });
                            });
                        }
                    })
                    .fail(function(data) {
                        $(input).addClass('is-invalid');
                        restoreButton();
                    });

                function restoreButton() {
                    $button.prop('disabled', false).html(originalButtonContent);
                    feather.replace();
                }
            });

            // Función para cargar datos de forma asíncrona
            function loadDataAsync(type) {
                return new Promise((resolve, reject) => {
                    var route = "{{ route('load.data', 'parameter') }}";
                    route = route.replace('parameter', type);
                    var id = '#' + type;

                    $.get(route, {},
                        function(data, textStatus, jqXHR) {
                            $(id).html(data);
                            feather.replace();
                            resolve();
                        }
                    ).fail(reject);
                });
            }

            function showOrderDetails(id) {
                $.get("{{ route('reports.show.order.details') }}", {
                        id: id
                    },
                    function(data, textStatus, jqXHR) {
                        $('.order_details').html(data);
                        $("#modal_show_order_details").modal("show");
                    }
                );
            }

            $(document).ready(function() {
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
                        data: function(d) {}
                    },
                    columns: [{
                            data: "table",
                            name: "table",
                            title: "Mesa",
                            "class": "text-center totable",
                            visible: true,
                            searchable: true,
                        },

                        {
                            data: "total_amount",
                            name: "total_amount",
                            title: "Monto",
                            "class": "text-right totable",
                            visible: true,
                            searchable: true,
                            render: function(data, type, row, meta) {
                                console.log(new Intl.NumberFormat().format(row.total_amount));
                                amount = new Intl.NumberFormat('de-DE').format(row.total_amount);
                                return amount;
                            }
                        },
                        {
                            data: "status",
                            name: "status",
                            title: "Estado",
                            "class": "text-center totable",
                            visible: true,
                            searchable: true,
                        },
                        {
                            data: "id",
                            name: "id",
                            title: "Acción",
                            "class": "text-center totable",
                            visible: true,
                            searchable: true
                        },
                    ],
                    fnCreatedRow: function(elemt, data, iDataIndex) {
                        var indice = iDataIndex + 1;

                        field = $('td:eq(2)', elemt);
                        buttons = '';

                        if (data.status == '0') {
                            options = '<span class="badge badge-light-warning" >En Espera</span> ';
                        }

                        if (data.status == '1') {
                            options = '<span class="badge badge-light-info" >Pendiente</span> ';
                        }

                        if (data.status == '2') {
                            options = '<span class="badge badge-light-success" >Completado</span> ';
                        }

                        if (data.status == '3') {
                            options = '<span class="badge badge-light-danger" >Cancelado</span> ';
                        }


                        button = ' ' + options + ' '

                        buttons += button;
                        field = field.html(buttons);


                        field = $('td:eq(3)', elemt);
                        buttons = '';

                        url = "{{ route('orders.edit', 'id') }}";
                        url = url.replace('id', data.id);

                        buttonApprove =
                            '<button class="btn btn-sm btn-info  green update_status tobutton" name="status" data-id="' +
                            data.id + '" value="2"> <i data-feather="check"></i> </button>';

                        buttonShow =
                            "<button type='button' class='btn btn-sm btn-primary  tobutton' onclick='showOrderDetails(" +
                            data.id + ")' > <i data-feather='eye'></i> </button>";

                        buttonEdit = '<a href="' + url +
                            '" class="btn btn-sm btn-info  tobutton"> <i data-feather="edit"></i> </a>';

                        buttonCancel =
                            '<button class="btn btn-sm btn-info  red update_status tobutton" name="status" data-id="' +
                            data.id + '" value="3"> <i data-feather="slash"></i> </button>';


                        if (data.status == '0') {
                            button = buttonApprove + buttonShow + buttonEdit + buttonCancel;
                        }

                        if (data.status == '1') {
                            button = buttonApprove + buttonShow + buttonEdit + buttonCancel;
                        }

                        if (data.status == '2') {
                            button = buttonShow + buttonCancel;
                        }

                        if (data.status == '3') {
                            button = buttonShow;
                        }





                        buttons += button;
                        field = field.html(buttons);
                    },
                }).on('processing.dt', function(e, settings, processing) {
                    feather.replace();
                });
                $('#search_client').click(function() {
                var idCard = $('#client_id_card').val();
                if (idCard) {
                    $.ajax({
                        url: "{{ route('clients.search') }}",
                        type: 'GET',
                        data: {
                            id_card: idCard
                        },
                        success: function(response) {
                            if (response.exists) {
                                $('#client_info').html('<p class="text-success">' + response.message + '</p>');
                            } else {
                                $('#client_info').html('<p class="text-danger">' + response.message + '</p>');
                            }
                        },
                        error: function() {
                            $('#client_info').html('<p class="text-danger">Error al buscar el cliente.</p>');
                        }
                    });
                } else {
                    $('#client_info').html('<p class="text-warning">Por favor, ingresa la cédula del cliente.</p>');
                }
            });
        });
        </script>

    @endsection
