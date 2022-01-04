<!-- Company Table Card -->
<div class="card card-company-table">
    <div class="card-header">
        <h3>Flujo de Caja</h3>
        <h5> ( Flujo de Dinero Ingresado al Día ) </h5>
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
                    @foreach ($orders->where('status', '2') as $order)
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
<!--/ Company Table Card -->