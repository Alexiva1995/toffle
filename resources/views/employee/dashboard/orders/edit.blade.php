@extends('layouts/contentLayoutMaster')

@section('title', 'Editar Pedido')

@section('vendor-style')
@endsection

@section('page-style')

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
                                        <input type="text" id="customer_name" class="form-control requerid" name="customer_name" value="{{ $order->customer_name }}" placeholder="Nombre" oninput="editOrder(this)" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="table">Mesa</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="tag"></i></span>
                                        <input type="number" id="table" class="form-control requerid" name="table" value="{{ $order->table }}" placeholder="Mesa" oninput="editOrder(this)" required/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-4 mb-1">
                                <div class="mb-1"> 
                                    <label class="form-label text_status" for="status"> <i class="icon_status d-none" data-feather="check-circle"></i> Estado</label>                         
                                    <select class="select2-icons form-control status" data-toggle="select" name="status"
                                        id="status" onchange="editOrder(this)">
                                        <option data-icon="alert-circle" value="0" {{ $order->status == 0 ? 'selected' : '' }}> Pendiente </option>
                                        <option data-icon="clock" value="1" {{ $order->status == 1 ? 'selected' : '' }}> En Espera </option>
                                        <option data-icon="check-circle" value="2" {{ $order->status == 2 ? 'selected' : '' }}> Finalizado </option>
                                        <option data-icon="x-circle" value="3" {{ $order->status == 3 ? 'selected' : '' }}> Cancelado </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row justify-content-center mb-3">
                        <div class="col-auto">
                            <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal_add_dish">
                                <i class="" data-feather="plus-circle"></i> Añadir Plato 
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table" id="items_table">
                            <thead class="thead-light text-center">
                                <th class="col-5">Plato</th>
                                <th class="col-2">N°</th>
                                <th class="col-2">Precio Unitario</th>
                                <th class="col-2">Total</th>
                                <th class="col-2"></th>
                            </thead>
                            <tbody>
                                @foreach ($order->dishes()->get() as $item)
                                    <tr id="edit_dish_to_order_{{ $item->pivot->id  }}">
                                        <td>
                                            <input type="text" name="dish" class="form-control dish" id="dish_{{ $item->pivot->id }}" value="{{ $item->name }}" required disabled>
                                        </td>
                                        <td>
                                            <input type="number" name="unit" class="form-control units" id="unit_{{ $item->pivot->id }}" value="{{ $item->pivot->unit }}" oninput="updateDish( {{ $item->pivot->id }}, this )" required>
                                        </td>
                                        <td>
                                            <input type="number" name="price" class="form-control price" id="price_{{ $item->pivot->id }}" value="{{ number_format( $item->pivot->price, 2, '.', '' ) }}" oninput="updateDish( {{ $item->pivot->id }}, this )" required>
                                        </td>
                                        <td>
                                            <input type="number" name="total" class="form-control total" id="total_{{ $item->pivot->id }}" value="{{ number_format( $item->pivot->unit *  $item->pivot->price, 2, '.', '' ) }}" readonly>
                                        </td>
                                        <td class="text-center"> 
                                            <button class="btn btn-sm btn-danger"
                                            onclick="deleteElement( {{ $item->pivot->id }}, 
                                            '#delete_dish_', 
                                            'este Plato' )"> 
                                                <i data-feather="trash-2"></i> 
                                            </button>
        
                                            <form id="delete_dish_{{ $item->pivot->id }}" action="{{ route('dish.remove', $item->pivot->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">                                      
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="font-weight: bold; font-size: 14px;">
                                    <td style="border-top: none !important;"></td>
                                    <td colspan="2" class="text-right">TOTAL</td>
                                    <td colspan="2" class="text-right" style="padding-right: 20px;"><input type="text" class="form-control" name="total_amount" id="total_amount" value="{{ number_format($order->total_amount, 2, '.','') }}" style="border: none !important; font-size: 14px !important;" readonly></td>
                                </tr>
                            </tfoot>
                        </table>           
                    </div> 
                </div>
            </div>
        </div>
    </div> 
</section>

@include('employee.dashboard.orders.modals.add_dish')

@endsection

@section('vendor-script')

@endsection

@section('page-script')

@endsection

@section('custom-js')
    <script>

        submitForms('#add_dish', '.loading_add_dish', '#form_add_dish');

        var array_dish = {{ $array_dish }}; 

        function updateDish(id, element){
            let item = {}
            let input = element

            let unit = $("#unit_"+id).val();
            let price = $("#price_"+id).val();

            $("#total_"+id).val(parseInt(unit) * parseFloat(price));
            var total = 0;

            for (var i = 0; i < array_dish.length; i++){
                total += parseFloat($("#total_"+array_dish[i]).val());
            }

            $("#total_amount").val(total);

            item ['form'] = 'edit_order_dish';
            item ['id'] = id;
            item [element.attributes.name.value] = element.value;
            item ['total_amount'] = $('#total_amount').val();

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

        function editOrder(element) {
            console.log('probando');
            let item = {}
            let input = element

            item [element.attributes.name.value] = element.value;
            item ['form'] = 'edit_order';

            item ['_method'] = 'PATCH';
            $.post('{{ route('orders.update', $order->id) }}', item)
            .done(function(data){
                $(input).removeClass('is-invalid')
                $(input).addClass('is-valid')

                if ($(element).hasClass('status')) {
                    $('.icon_status').removeClass('d-none');
                    $('.text_status').addClass('text-success');
                }

                setTimeout(() => {
                    $(input).removeClass('is-valid')

                    if ($(element).hasClass('status')) {
                        $('.icon_status').addClass('d-none');
                        $('.text_status').removeClass('text-success');
                    }

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
    </script>
@endsection