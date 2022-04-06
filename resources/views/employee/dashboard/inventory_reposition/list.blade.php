<!-- Company Table Card -->
<div class="card card-company-table">
    <div class="card-header">
        <h3>
            <div class="avatar bg-light-warning">
                <div class="avatar-content">
                    <i data-feather="alert-circle" class="avatar-icon"></i>
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
                        <th class="px-2">Producto</th>
                        <th class="px-2 text-center">Cantidad</th>
                        <th class="px-2 text-center">Necesario</th>
                        <th class="text-center px-2">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                        @if ($inventory->local <= $inventory->product->units_reposition_alert )
                            <tr>
                                <td class="text-dark"> 
                                    {{ $inventory->product->name }} {{ $inventory->flavor_name != null ? '('.ucwords($inventory->flavor_name).')' : '' }}
                                </td>  
                                <td class="text-center text-dark"> 
                                    {{ $inventory->local }} 
                                </td>  
                                <td class="text-center text-dark"> 
                                    {{ $inventory->qtyProductsNeeded($inventory->id) }} 
                                </td> 
                                <td class="text-center"> 
                                    <span class="badge badge-light-info text white"> 
                                        <i data-feather="alert-circle"></i> Reponer Producto
                                    </span>  
                                </td>                       
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--/ Company Table Card -->

<script>
    dataTable('#inventory_reposition_table');
</script>

