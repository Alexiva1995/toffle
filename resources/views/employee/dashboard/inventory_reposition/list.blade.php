<!-- Company Table Card -->
<div class="card card-company-table">
    <div class="card-header">
        <h3>
            <div class="avatar bg-light-warning">
                <div class="avatar-content">
                    <i data-feather="alert-triangle" class="avatar-icon"></i>
                </div>
            </div>
            Reposición de Inventario
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="inventory_reposition_table">
                <thead>
                    <tr>
                        <th class="text-center px-0">Producto</th>
                        <th class="text-center px-0"> Reposición de Unidades</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                    <tr>
                        <td class="text-center"> {{ $inventory->product->name }} </td>
                        <td class="text-center"> 
                            {{ $inventory->product->units_reposition_alert }} 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--/ Company Table Card -->