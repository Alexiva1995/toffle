<div class="row">
    <div class="col-12">
        <div class="card p-2">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h3>Lista de Productos</h1>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row justify-content-end">
                        <div class="col-auto mb-2">
                            <a href="{{ route('create.products') }}" class="btn btn-primary mt-2">
                                <i data-feather="plus"></i> Añadir Nuevo Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="datatables-ajax table table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Gr.</th>
                        <th class="text-center">Alerta de Reposición de Unidades</th>
                        <th class="text-center">Fecha de Creación</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->gr }}</td>
                        <td class="text-center">{{ $product->units_reposition_alert == 1 ? 'Activado' : 'Desactivado' }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($product->created_at)) }}</td>
                        <td class="text-center"> <a href="{{ route('edit.product', $product->id) }}" class="btn btn-sm btn-info"> <i data-feather="edit"></i> </a> </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>