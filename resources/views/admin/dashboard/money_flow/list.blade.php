<div class="card card-company-table">
    <div class="card-header">
        <h3>Flujo de Caja</h3>
        <h5> ( Flujo de Dinero Ingresado al Día ) </h5>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <h4 class="card-text text-center">
                Ingreso Total = <span class="text-success"> $ {{ number_format($orders_today->count('total_amount'), 2, '.', '') }} </span>
            </h4>   
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="money_flow_table">
                <thead>
                    <tr>
                        <th class="text-center px-0">Id del Pedido</th>
                        <th class="text-center px-0">Dinero Ingresado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders_today as $order)
                    <tr>
                        <td class="text-center"> {{ $order->id }} </td>
                        <td class="text-center"> 
                            <div class="fw-bolder text-success">+ {{ number_format($order->total_amount, 2, '.', '') }} 
                                <i data-feather="trending-up" class="text-success font-medium-1"></i> 
                            </div> 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
