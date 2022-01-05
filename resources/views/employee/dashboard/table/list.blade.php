<!-- Company Table Card -->
<div class="card card-company-table">
    <div class="card-header">
        <h3>Mesas</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="table_list">
                <thead>
                    <tr>
                        <th class="text-center px-0">Mesa</th>
                        <th class="text-center px-0">Id del Pedido</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tables as $table)
                    <tr>
                        <td class="text-center"> {{ $table->table }} </td>
                        <td class="text-center"> 
                            @foreach ($table->getOrderIds($table->table) as $item)
                                <a href="{{ route('orders.edit', $item->id) }}" class="btn btn-sm btn-info my-1"> {{ $item->id }} 
                                    <i data-feather="edit"></i> 
                                </a>
                            @endforeach 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--/ Company Table Card -->