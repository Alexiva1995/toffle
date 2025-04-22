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
<!-- Modal para agregar cliente -->
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Agregar Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addClientForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Apellido</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Tipo de Documento</label>
                            <select name="identity_type" class="form-select" required>
                                <option value="V">V-</option>
                                <option value="J">J-</option>
                                <option value="G">G-</option>
                                <option value="P">P-</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Número de Documento</label>
                            <input type="text" name="id_card" class="form-control" required readonly>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
    // Funciones globales
    dataTable('#order_history_table');
    dataTable('#money_flow_table');

    function loadData(type) {
        var route = "{{ route('load.data', 'parameter') }}";
        route = route.replace('parameter', type);
        $.get(route, {}, function(data) {
            $('#' + type).html(data);
            feather.replace();
        });
    }

    // Carga inicial de datos
    loadData('statistics');
    loadData('order_history');
    loadData('cash_flow');

    // Manejo de actualización de estado
    $(document).on('click', '.update_status', function() {
        let $button = $(this);
        let originalContent = $button.html();
        $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Cargando...');

        $.ajax({
            url: "{{ route('orders.update', 'id') }}".replace('id', $(this).data('id')),
            method: 'PATCH',
            data: {
                status: this.value,
                form: 'update_general_data'
            },
            success: function(response) {
                Promise.all([
                    loadDataAsync('statistics'),
                    loadDataAsync('order_history'),
                    loadDataAsync('cash_flow')
                ]).then(() => {
                    $('#pending_order_table').DataTable().ajax.reload();
                });
            },
            complete: function() {
                $button.prop('disabled', false).html(originalContent);
                feather.replace();
            }
        });
    });

    // Función asíncrona para cargar datos
    function loadDataAsync(type) {
        return new Promise((resolve) => {
            loadData(type);
            resolve();
        });
    }

    // Mostrar detalles del pedido
    function showOrderDetails(id) {
        $.get("{{ route('reports.show.order.details') }}", {
            id: id
        }, function(data) {
            $('.order_details').html(data);
            $("#modal_show_order_details").modal("show");
        });
    }

    // Document Ready
    $(document).ready(function() {
        // Configuración de DataTable
        var table = $('#pending_order_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            pageLength: 50,
            language: {
                url: '{!! asset('data/datatable/Spanish.json') !!}'
            },
            ajax: {
                url: '{!! route('order.table.data', 'pending') !!}'
            },
            columns: [{
                    data: "table",
                    name: "table",
                    class: "text-center totable"
                },
                {
                    data: "total_amount",
                    name: "total_amount",
                    class: "text-right totable",
                    render: function(data) {
                        return new Intl.NumberFormat('de-DE').format(data);
                    }
                },
                {
                    data: "status",
                    name: "status",
                    class: "text-center totable"
                },
                {
                    data: "id",
                    name: "id",
                    class: "text-center totable",
                    render: function(data, type, row) {
                        let buttons = '';
                        const editUrl = "{{ route('orders.edit', 'id') }}".replace('id', data);

                        // Botones basados en el estado
                        if (row.status == '0' || row.status == '1') {
                            buttons += `<button class="btn btn-sm btn-info green update_status" data-id="${data}" value="2"><i data-feather="check"></i></button>`;
                            buttons += `<a href="${editUrl}" class="btn btn-sm btn-info"><i data-feather="edit"></i></a>`;
                        }
                        if (row.status != '3') {
                            buttons += `<button class="btn btn-sm btn-danger red update_status" data-id="${data}" value="3"><i data-feather="slash"></i></button>`;
                        }
                        buttons += `<button class="btn btn-sm btn-primary" onclick="showOrderDetails(${data})"><i data-feather="eye"></i></button>`;

                        return buttons;
                    }
                }
            ],
            fnCreatedRow: function(row, data) {
                feather.replace();
            }
        }).on('processing.dt', function() {
            feather.replace();
        });

        // Búsqueda de clientes
        $('#search_client').click(function() {
            const idCard = $('#client_id_card').val().trim();
            if (!idCard) {
                $('#client_info').html('<div class="alert alert-warning">Ingrese un documento</div>');
                return;
            }

            $.ajax({
                url: "{{ route('clients.search') }}",
                data: {
                    id_card: idCard
                },
                success: function(response) {
                    if (response.exists) {
                        $('#client_info').html(`<div class="alert alert-success">${response.message}</div>`);
                    } else {
                        $('#addClientModal input[name="id_card"]').val(idCard);
                        $('#addClientModal').modal('show');
                        $('#client_info').html('<div class="alert alert-warning">Cliente no registrado</div>');
                    }
                }
            });
        });

        // Guardar nuevo cliente
        $('#addClientForm').submit(function(e) {
            e.preventDefault();
            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');

            $submitBtn.prop('disabled', true).html('Guardando...');

            $.ajax({
                url: "{{ route('clients.store') }}",
                method: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    if (response.success) {
                        // Cierra el modal
                        $('#addClientModal').modal('hide');

                        // Resetea el formulario
                        $form[0].reset();

                        $('#client_id_card').val('');
                        // Muestra mensaje de éxito
                        $('#client_info').html(`
                            <div class="alert alert-success">
                                ${response.message}
                            </div> `);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors || {};
                    let errorMessages = Object.values(errors).flat().join('<br>');

                    $('#client_info').html(`
                <div class="alert alert-danger">
                    ${errorMessages || 'Error desconocido'}
                </div>
            `);
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).html('Guardar Cliente');
                }
            });
        });

        // Al mostrar el modal, establece el documento y deshabilita el campo
        $('#addClientModal').on('show.bs.modal', function(e) {
            const idCard = $('#client_id_card').val().trim();
            $(this).find('input[name="id_card"]').val(idCard).prop('readonly', true);
            setTimeout(() => {
                $(this).find('input[name="name"]').focus();
            }, 500);
        });

        // Al cerrar el modal, limpia todo
        $('#addClientModal').on('hidden.bs.modal', function(e) {
            $(this).find('form')[0].reset();
            $(this).find('input[name="id_card"]').prop('readonly', false);
        });

        // Guardar nuevo cliente

    }); // Fin del document.ready
</script>

@endsection
