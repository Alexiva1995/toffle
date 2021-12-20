<div class="row">
    <div class="col-12">
        <div class="card p-2">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h3>Lista de Inventarios</h1>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row justify-content-end">
                        <div class="col-auto mb-2">
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modal_add_inventory">
                                <i data-feather="plus"></i> Añadir Inventario
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Nombre</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Depósito</th>
                            <th class="text-center">Local</th>
                            <th class="text-center">Público</th>
                            {{-- <th class="text-center">Costo</th> --}}
                            <th class="text-center">Fecha de Creación</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                        <tr>
                            {{-- <td>{{ $inventory->id }}</td> --}}
                            <td>{{ $inventory->name }}</td>
                            <td class="text-center">{{ $inventory->total }}</td>
                            <td class="text-center px-3"> 
                                <span class="badge bg-dark" role="button" 
                                onclick="operation('deposit', 'subtract', {{ $inventory->id }})"> - </span> 

                                {{ $inventory->deposit }}

                                <span class="badge bg-primary" role="button" 
                                onclick="operation('deposit', 'sum', {{ $inventory->id }})"> + </span> 
                            </td>
                            <td class="text-center px-3"> 
                                <span class="badge bg-dark" role="button" 
                                onclick="operation('local', 'subtract', {{ $inventory->id }}, {{ $inventory->local }})"> - </span>

                                {{ $inventory->local }}

                                <span class="badge bg-primary" role="button" 
                                onclick="operation('local', 'sum', {{ $inventory->id }}, {{ $inventory->deposit }})"> + </span> 
                            </td>
                            <td class="text-center px-3"> 
                                <span class="badge bg-dark" role="button" 
                                onclick="operation('public', 'subtract', {{ $inventory->id }}, {{ $inventory->public }})"> - </span>

                                {{ $inventory->public }}

                                <span class="badge bg-primary" role="button" 
                                onclick="operation('public', 'sum', {{ $inventory->id }}, {{ $inventory->local }})"> + </span> 
                            </td>
                            {{-- <td class="text-center">{{ $inventory->cost }}</td> --}}
                            <td class="text-center">{{ date('d-m-Y', strtotime($inventory->created_at)) }}</td>
                            <td class="text-center"> 
                                <a href="{{ route('show.inventory', $inventory->id) }}" class="btn btn-sm btn-primary"> <i data-feather="log-in"></i> </a>
                                <a href="{{ route('edit.inventory', $inventory->id) }}" class="btn btn-sm btn-info"> <i data-feather="edit"></i> </a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.inventories.partials.modals')