<div class="row">
    <div class="col-12">
        <div class="card p-2">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h3>Lista de Inventario</h1>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row justify-content-end">
                        <div class="col-auto mb-2">
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modal_add_inventory">
                                <i data-feather="plus"></i> Añadir Productos
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Depósito</th>
                            <th class="text-center">Local</th>
                            <th class="text-center">Público</th>
                            <th class="text-right">Costo</th>
                            <th class="text-center">Fecha de Creación</th>
                            <th class="text-center px-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                        <tr>
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{ $inventory->id }}</td>
                            <td class="text-center">{{ $inventory->product->name }} {{ $inventory->flavor_name != null ? '('.ucwords($inventory->flavor_name).')' : '' }}</td>
                            <td class="text-center">{{ $inventory->total }}</td>
                            <td class="text-center px-3"> 
                                <div class="d-flex">
                                    <span class="badge bg-dark" role="button" 
                                    onclick="operation('deposit', 'subtract', {{ $inventory->id }}, {{ $inventory->deposit }})"> - </span> 
    
                                    <span class="mx-1">{{ $inventory->deposit }}</span>
    
                                    <span class="badge bg-primary" role="button" 
                                    onclick="operation('deposit', 'sum', {{ $inventory->id }}, {{ $inventory->local }})"> + </span> 
                                </div>
                            </td>
                            <td class="text-center px-3"> 
                                <div class="d-flex">
                                    <span class="badge bg-dark" role="button" 
                                    onclick="operation('local', 'subtract', {{ $inventory->id }}, {{ $inventory->local }})"> - </span>
    
                                    <span class="mx-1">{{ $inventory->local }}</span>
    
                                    <span class="badge bg-primary" role="button" 
                                    onclick="operation('local', 'sum', {{ $inventory->id }}, {{ $inventory->deposit }})"> + </span> 
                                </div>
                            </td>
                            <td class="text-center px-3">
                                <div class="d-flex">
                                    <span class="badge bg-dark" role="button" 
                                    onclick="operation('public', 'subtract', {{ $inventory->id }}, {{ $inventory->public }})"> - </span>
    
                                    <span class="mx-1">{{ $inventory->public }}</span>
    
                                    <span class="badge bg-primary" role="button" 
                                    onclick="operation('public', 'sum', {{ $inventory->id }}, {{ $inventory->local }})"> + </span> 
                                </div>
                            </td>
                            <td class="text-right">{{ number_format($inventory->cost, 2, ',', '.') }}</td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($inventory->created_at)) }}</td>
                            <td class="text-center px-3"> 
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-info me-1" 
                                        onclick="editInventory(
                                        {{ $inventory->id }}, 
                                        '{{ $inventory->product_id }}',
                                        {{ $inventory->qty_package }},
                                        {{ $inventory->unit_package }},
                                        {{ $inventory->price }},
                                        {{ $inventory->cost }},
                                        {{ $inventory->deposit }},
                                        {{ $inventory->local }},
                                        {{ $inventory->public }},
                                        {{ $inventory->total }} )"> 
                                        <i data-feather="edit"></i>                                   
                                    </button>    
                                    
                                    <span class="btn btn-sm btn-danger"
                                    onclick="deleteElement( {{ $inventory->id }}, 
                                    '#delete_inventory_', 
                                    'este Inventario',
                                    'IMPORTANTE: Si esté Producto del Inventario está añadido en uno de los platos, no podrá ser removido' )"> 
                                        <i data-feather="trash-2"></i> 
                                    </span> 
                        
                                    <form id="delete_inventory_{{ $inventory->id }}" action="{{ route('inventory.destroy', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')                                      
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.inventory.partials.modals')