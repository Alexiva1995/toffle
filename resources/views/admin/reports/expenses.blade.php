@extends('layouts/contentLayoutMaster')

@section('title', 'Gastos')

@include('panels.datatable.styles')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table rounded border-table border-primary" id="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Descripcion</th>
                                                <th class="text-center">Monto</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Categoria</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenses as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item->id }}</td>
                                                    <td class="text-center">{{ $item->description }}</td>
                                                    <td class="text-center fw-bolder text-danger">{{ $item->amount }}$</td>
                                                    @if ($item->status == 0)
                                                        <td class="text-center">Por Pagar</td>
                                                    @else
                                                        <td class="text-center">Pagado</td>
                                                    @endif
                                                    <td class="text-center">{{ $item->category->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')

@include('panels.datatable.scripts')

<script>
    $('#table').dataTable();
</script>

@endsection