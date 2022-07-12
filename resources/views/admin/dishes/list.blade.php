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
                                        @include('partials.edit_icon_svg')
                                    </a> 

                                    <button class="btn btn-sm btn-danger"
                                    onclick="deleteElement( {{ $item->id }}, 
                                    '#delete_dish_', 
                                    'este Plato',
                                    'IMPORTANTE: Si esté plato está registrado en un pedido, no podrá ser removido' )"> 
                                        @include('partials.trash_icon_svg')
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
