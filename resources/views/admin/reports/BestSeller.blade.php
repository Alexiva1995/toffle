@extends('layouts/contentLayoutMaster')

@section('title', 'Mas vendido')

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
                                                <th class="text-center">Producto</th>
                                                <th class="text-center">Categoria</th>
                                                <th class="text-center"># de Ventas</th>
                                                <th class="text-center">Ganancia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dishes as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->name }}</td>
                                                <td class="text-center">{{ $item->category->name }}</td>
                                                <td class="text-center">{{ $item->countDish( $item->id ) }}</td>
                                                @if ($item->dishProfit( $item->id ) <= '0')
                                                <td class="text-center fw-bolder text-danger">sin ganancia</td>
                                                @else
                                                <td class="text-center fw-bolder text-success">{{ $item->dishProfit( $item->id ) }}$</td>
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
    $('#table').dataTable( {
    "order": [[ 2, 'desc' ]]
} );
</script>

@endsection