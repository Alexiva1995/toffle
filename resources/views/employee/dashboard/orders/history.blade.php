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
                        {{-- <th class="text-center px-0">Id</th> --}}
                        <th class="text-center px-0">Cliente</th>
                        <th class="text-center px-0">Mesa</th>
                        <th class="text-center px-0">Monto</th>
                        <th class="text-center px-0">Estado</th>
                        <th class="text-center px-0">Ver</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration }} </td>
                        {{-- <td class="text-center"> {{ $order->id }} </td> --}}
                        <td class="text-center"> {{ $order->customer_name }} </td>
                        <td class="text-center"> {{ $order->table }} </td>
                        <td class="text-center"> {{ $order->total_amount }} </td>
                        <td class="text-center">
                            <span class="badge badge-light-{{ $order->status_color }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button type='button' class='btn btn-sm btn-primary' onclick='showOrderDetails({{ $order->id }})'> <i data-feather='eye'></i>
                            </button>
                            @if($order->status != 3)
                            <button type='button' class='btn btn-sm btn-danger' onclick='cancelOrder({{ $order->id }})'> <i data-feather='x'></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    dataTable('#order_history_table');
</script>
