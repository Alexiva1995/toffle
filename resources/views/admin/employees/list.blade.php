@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de Empleados')

@include('panels.datatable.styles')

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="row mb-2">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="status">Filtrar Estatus</label>
                                <select class="form-control" data-toggle="select" name="status"
                                    id="status_filter">
                                    <option value="">Todas los Estatus</option>
                                    <option value="Activo">Activos</option>
                                    <option value="Inactivo">Inactivos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-end mt-1">
                            <div class="col-auto">
                                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                                    <i data-feather="plus"></i> Añadir Nuevo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table rounded border-primary" id="table" >
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Estatus</th>
                                <th class="text-center">Fecha de Creación</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->last_name }}</td>
                                <td>{{ $employee->dni }}</td>
                                <td>{{ $employee->email }}</td>
                                <td> <span class="badge badge-light-{{ $employee->status == 0 ? 'danger' : 'success' }}">{{ $employee->status == 0 ? 'Inactivo' : 'Activo' }}</span> </td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($employee->created_at)) }}</td>
                                <td class="text-center"> 
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-info my-1"> <i data-feather="edit"></i> </a> 

                                    <button class="btn btn-sm btn-danger"
                                    onclick="deleteElement( {{ $employee->id }}, 
                                    '#delete_employee_', 
                                    'este Empleado' )"> 
                                        <i data-feather="trash-2"></i> 
                                    </button>

                                    <form id="delete_employee_{{ $employee->id }}" action="{{ route('employees.destroy', $employee->id) }}" method="POST">
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
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var tdStatus = data[5];
                var filterStatus = $('#status_filter option').filter(':selected').val();
                if (filterStatus == '') {
                    return true;
                }
                return tdStatus == filterStatus;
            }
        );

        $(document).ready(function() {
            var table = $('.table').DataTable();
            $('#status_filter').change( function() {
                table.draw();
            });
        });

        dataTable('#table');
    </script>
@endsection
