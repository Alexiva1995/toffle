<div class="row">
    <div class="col-12">
        <div class="card p-2">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h3>Lista de Ingredientes</h1>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row justify-content-end">
                        <div class="col-auto mb-2">
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modal_add_ingredient">
                                <i data-feather="plus"></i> Añadir Ingrediente
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
                        <th class="text-center">Fecha de Creación</th>
                        <th class="text-center">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ingredients as $ingredient)
                        <tr>
                            {{-- <td>{{ $inventory->id }}</td> --}}
                            <td>{{ $ingredient->name }}</td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($ingredient->created_at)) }}</td>
                            <td class="text-center"> <a href="{{ route('edit.ingredients', $ingredient->id) }}" class="btn btn-sm btn-info"> <i data-feather="edit"></i> </a> </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.inventories.partials.modals')
