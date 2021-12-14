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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#default">
                                <i data-feather="plus"></i> Añadir Nuevo Producto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="datatables-ajax table table-responsive" id="table_products">
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

<!-- Modal -->
<div
  class="modal fade text-start"
  id="default"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Añadir Producto</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('admin.products.create')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary"><i data-feather="plus"></i> Añadir</button>
        </div>
      </div>
    </div>
</div>
