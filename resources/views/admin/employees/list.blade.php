@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de Empleados')

@include('panels.datatable.styles')

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="row justify-content-end mb-2">
                    <div class="col-auto">
                        <a href="{{ route('create.employees') }}" class="btn btn-primary">
                            <i data-feather="plus"></i> Añadir Nuevo
                        </a>
                    </div>
                </div>
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Correo</th>
                            <th>Estatus</th>
                            <th class="text-center">Fecha de Creación</th>
                            <th class="text-center">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->last_name }}</td>
                            <td>{{ $employee->dni }}</td>
                            <td>{{ $employee->email }}</td>
                            <td> <span class="badge badge-light-{{ $employee->status == false ? 'danger' : 'success' }}"> {{ $employee->status == false ? 'Inactivo' : 'Activo' }} </span> </td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($employee->created_at)) }}</td>
                            <td class="text-center"> <a href="{{ route('edit.employees', $employee->id) }}" class="btn btn-sm btn-info"> <i data-feather="edit"></i> </a> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
    @include('panels.datatable.scripts')
@endsection
