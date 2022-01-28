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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_product">
                                <i data-feather="plus"></i> Añadir Nuevo Producto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="product_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Gr.</th>
                            <th class="text-center">Alerta de Reposición de Unidades</th>
                            <th class="text-center">Fecha de Creación</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->mark }}</td>
                            <td>{{ $product->gr }}</td>
                            <td class="text-center">{{ $product->units_reposition_alert }}</td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($product->created_at)) }}</td>
                            <td class="text-center"> 
                                <button class="btn btn-sm btn-info my-1"
                                    onclick="editProduct(
                                    {{ $product->id }}, 
                                    '{{ $product->name }}',
                                    '{{ $product->mark }}', 
                                    {{ $product->gr }},
                                    {{ $product->units_reposition_alert }},
                                    {{ $product->flavors }})"> 

                                    <i data-feather="edit"></i> 
                                </button> 

                                <button class="btn btn-sm btn-danger"
                                    onclick="deleteElement( {{ $product->id }}, 
                                    '#delete_product_', 
                                    'este Producto',
                                    'IMPORTANTE: Si esté Producto está añadido en el inventario, no podrá ser removido' )"> 
                                    <i data-feather="trash-2"></i> 
                                </button>
                                <form id="delete_product_{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')                                      
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.products.partials.modals')
