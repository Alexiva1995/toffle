@extends('layouts/contentLayoutMaster')

@section('title', 'Ganancia')

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
                                                <th class="text-center">N°</th>
                                                <th class="text-center">Ganancia</th>
                                                <th class="text-center">Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dishes as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    @if ($item->dishProfit( $item->id ) <= '0')
                                                    <td class="text-center fw-bolder text-danger">sin ganancia</td>
                                                    @else
                                                    <td class="text-center fw-bolder text-success">{{ $item->dishProfit( $item->id ) }}$</td>
                                                    @endif
                                                    <td class="text-center">{{ $loop->iteration }}</td>

                                                    {{-- <td class="text-center">{{ date('d-m-Y', strtotime($item->dishDate())) }}</td> --}}
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
    "order": [[ 1, 'asc' ]]
} );
</script>

@endsection