@extends('layouts/contentLayoutMaster')

@section('title', 'Inventarios')

@include('panels.datatable.styles')

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="row justify-content-end">
                    <div class="col-auto mb-2">
                        <a href="{{ route('create.employees') }}" class="btn btn-primary me-1 mt-2">
                            <i data-feather="plus"></i> Añadir Nuevo Producto
                        </a>

                        <a href="{{ route('create.inventory') }}" class="btn btn-primary mt-2">
                            <i data-feather="plus"></i> Añadir Inventario
                        </a>
                    </div>
                </div>
                <table class="datatables-ajax table table-responsive" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Total</th>
                            <th>Depósito</th>
                            <th>Local</th>
                            <th>Público</th>
                            <th>Costo</th>
                            <th class="text-center">Fecha de Creación</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                        <tr>
                            <td>{{ $inventory->id }}</td>
                            <td>{{ $inventory->name }}</td>
                            <td>{{ $inventory->total }}</td>
                            <td>{{ $inventory->deposit }}</td>
                            <td>{{ $inventory->local }}</td>
                            <td>{{ $inventory->public }}</td>
                            <td>{{ $inventory->cost }}</td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($inventory->created_at)) }}</td>
                            <td class="text-center"> <a href="{{ route('edit.inventory', $inventory->id) }}" class="btn btn-sm btn-info"> <i data-feather="edit"></i> </a> </td>
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
