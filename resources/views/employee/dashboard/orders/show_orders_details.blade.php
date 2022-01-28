
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Detalles del Pedido - ID: {{ $order->id }}</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body p-3">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-4 mb-2">
            <label class="form-label" for="customer_name">Nombre del Cliente</label>
            <input type="text" id="customer_name" class="form-control requerid" name="customer_name" value="{{ $order->customer_name }}" required/>
        </div>
        <div class="col-12 col-md-4 mb-2">
            <label class="form-label" for="table">Mesa</label>
            <input type="number" id="table" class="form-control requerid" name="table" value="{{ $order->table }}" readonly/>
        </div>
            
        <div class="col-12 col-md-4 mb-2">
            <label class="form-label" for="status">Estado</label>
            <input type="text" id="table" class="form-control requerid" name="table" value="{{ $order->estado() }}" readonly/>
        </div>
        <div class="table-responsive">
            <table class="table" id="table" >
                <thead>
                    <th class="text-center">Plato</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Precio Unitario</th>
                    <th class="text-center">Total</th>
                </thead>
                <tbody>
                    @foreach ($order->dishes as $item)
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
                        </tr>
                    @endforeach
                </tbody>
            </table>  
        </div>  
            
        <div class="col-auto">
            <strong class="pe-1" >TOTAL:</strong>  {{ number_format($order->total_amount, 2, '.','') }}
        </div>
    </div>
</div>

<div class="row justify-content-center mb-3">
    <div class="col-auto">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
    </div>
</div>

