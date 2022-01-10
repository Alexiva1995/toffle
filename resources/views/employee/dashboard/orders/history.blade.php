<div class="card card-company-table">
    <div class="card-header">
        <h3>Historial de Pedidos</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="order_history_table">
                <thead>
                    <tr>
                        <th class="text-center px-0">N°</th>
                        <th class="text-center px-0">Id</th>
                        <th class="text-center px-0">Cliente</th>
                        <th class="text-center px-0">Mesa</th>
                        <th class="text-center px-0">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration }} </td>
                        <td class="text-center"> {{ $order->id }} </td>
                        <td class="text-center"> {{ $order->customer_name }} </td>
                        <td class="text-center"> {{ $order->table }} </td>
                        <td class="text-center">  
                            <div class="d-flex align-items-center justify-content-center">

                                @switch($order->status)
                                    @case(0)
                                        <div class="avatar bg-light-warning me-1">
                                            <div class="avatar-content">
                                                <i data-feather="alert-circle" class="font-medium-3"></i>
                                            </div>
                                        </div>
                                        @break
                                    @case(1)
                                        <div class="avatar bg-light-info me-1">
                                            <div class="avatar-content">
                                                <i data-feather="clock" class="font-medium-3"></i>
                                            </div>
                                        </div>
                                        @break
                                    @case(2)
                                        <div class="avatar bg-light-success me-1">
                                            <div class="avatar-content">
                                                <i data-feather="dollar-sign" class="font-medium-3"></i>
                                            </div>
                                        </div>
                                        @break
                                    @case(3)
                                        <div class="avatar bg-light-danger me-1">
                                            <div class="avatar-content">
                                                <i data-feather="x-circle" class="font-medium-3"></i>
                                            </div>
                                        </div>
                                        @break
                                    @default                                           
                                @endswitch

                                <span>
                                    {{ $order->estado() }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
