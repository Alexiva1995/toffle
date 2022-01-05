@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de Platos')

@include('panels.datatable.styles')

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
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Precio costo</th>
                                <th>Precio sugerido</th>
                                <th>Precio designado</th>
                                <th>Categoria</th>
                                {{-- <th>Estatus</th> --}}
                                {{-- <th class="text-center">Fecha de Creación</th> --}}
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dishes as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->cost_price }}</td>
                                <td>{{ $item->suggested_price }}</td>
                                <td>{{ $item->designated_price }}</td>
                                <td>{{ $item->category->name }}</td>
                                {{-- <td> <span class="badge badge-light-{{ $item->status == 0 ? 'danger' : 'success' }}">{{ $item->status == 0 ? 'Inactivo' : 'Activo' }}</span> </td> --}}
                                {{-- <td class="text-center">{{ date('d-m-Y', strtotime($item->created_at)) }}</td> --}}
                                <td class="text-center"> 
                                    <a href="{{  route('dishes.edit', $item->id) }}" class="btn btn-sm btn-info my-1"> <i data-feather="edit"></i> </a> 

                                    <button class="btn btn-sm btn-danger"
                                    onclick="deleteElement( {{ $item->id }}, 
                                    '#delete_dish_', 
                                    'este Plato' )"> 
                                        <i data-feather="trash-2"></i> 
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

@include('admin.dishes.partials.script')

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
        // $.fn.dataTable.ext.search.push(
        //     function( settings, data, dataIndex ) {
        //         var tdStatus = data[5];
        //         var filterStatus = $('#status_filter option').filter(':selected').val();
        //         if (filterStatus == '') {
        //             return true;
        //         }
        //         return tdStatus == filterStatus;
        //     }
        // );

        // $(document).ready(function() {
        //     var table = $('.table').DataTable();
        //     $('#status_filter').change( function() {
        //         table.draw();
        //     });
        // });

        dataTable('#table');
    </script>
@endsection
