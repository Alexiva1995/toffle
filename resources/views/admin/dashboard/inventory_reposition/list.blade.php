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
            <table class="table rounded border-table" id="inventory_reposition_table">
                <thead>
                    <tr>
                        <th class="text-center px-0">Id del Inv</th>
                        <th class="text-center px-0">Producto</th>
                        <th class="text-center px-0">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                        @if ($inventory->local <= $inventory->product->units_reposition_alert )
                            <tr>
                                <td class="text-center text-dark"> 
                                    {{ $inventory->id }}
                                </td>  
                                <td class="text-center text-dark"> 
                                    {{ $inventory->product->name }}
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