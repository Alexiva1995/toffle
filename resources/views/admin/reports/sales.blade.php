@extends('layouts/contentLayoutMaster')

@section('title', 'Ventas')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

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
                                                <th class="text-center">N°</th>
                                                <th class="text-center">Monto</th>
                                                <th class="text-center">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item->id }}</td>
                                                    <td class="text-center fw-bolder text-success">{{ $item->total_amount }}$</td>
                                                    @if ($item->status == 0)
                                                        <td class="text-center">Pendiente</td>
                                                    @elseif ($item->status == 1)
                                                        <td class="text-center">En espera</td>
                                                    @elseif ($item->status == 2)
                                                        <td class="text-center">Finalizado</td>
                                                    @elseif ($item->status == 3)
                                                        <td class="text-center">Cancelado</td>
                                                    @endif
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