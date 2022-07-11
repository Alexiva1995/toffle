@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de Platos')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="row mb-2">
                    {{-- <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="status">Filtrar Estatus</label>
                                <select class="form-select" data-toggle="select" name="status"
                                    id="status_filter">
                                    <option value="">Todas los Estatus</option>
                                    <option value="Activo">Activos</option>
                                    <option value="Inactivo">Inactivos</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-12 col-md-12">
                        <div class="row justify-content-end mt-1">
                            <div class="col-auto">
                                <a href="{{ route('dishes.create') }}" class="btn btn-primary mt-2">
                                    <i data-feather="plus"></i> Añadir Plato
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table rounded border-table border-primary" id="table" >
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Costo</th>
                                <th class="text-center">Precio sugerido</th>
                                <th class="text-center">Precio designado</th>
                                <th class="text-center">Categoria</th>
                                {{-- <th>Estatus</th> --}}
                                {{-- <th class="text-center">Fecha de Creación</th> --}}
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dishes as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center"> <span class="badge badge-light-{{ $item->statusColor() }}">{{ $item->status() }}</span> </td>
                                <td class="text-center">{{ $item->cost_price }}</td>
                                <td class="text-center">{{ $item->suggested_price }}</td>
                                <td class="text-center">{{ $item->designated_price }}</td>
                                <td class="text-center">{{ $item->category->name }}</td>
                                {{-- <td> <span class="badge badge-light-{{ $item->status == 0 ? 'danger' : 'success' }}">{{ $item->status == 0 ? 'Inactivo' : 'Activo' }}</span> </td> --}}
                                {{-- <td class="text-center">{{ date('d-m-Y', strtotime($item->created_at)) }}</td> --}}
                                <td class="text-center"> 
                                    <a href="{{  route('dishes.edit', $item->id) }}" class="btn btn-sm btn-info my-1"> 
                                        <svg  width="14" height="14" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                          </svg> 
                                    </a> 

                                    <button class="btn btn-sm btn-danger"
                                    onclick="deleteElement( {{ $item->id }}, 
                                    '#delete_dish_', 
                                    'este Plato',
                                    'IMPORTANTE: Si esté plato está registrado en un pedido, no podrá ser removido' )"> 
                                        <svg  width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>

                                    <form id="delete_dish_{{ $item->id }}" action="{{ route('dishes.destroy', $item->id) }}" method="POST">
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
</section>

{{-- @include('admin.dishes.partials.script') --}}

@endsection

@section('vendor-script')
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection


@section('page-script')
    <!-- Page js files -->
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
    <script>
        dataTable('#table');
    </script>
@endsection
