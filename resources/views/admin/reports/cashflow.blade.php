@extends('layouts/contentLayoutMaster')

@section('title', 'Flujo de caja')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('page-style')
@endsection

@section('content')
<!-- Basic table -->
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="d-flex flex-row">
                            <div class="avatar bg-light-success me-2">
                                <div class="avatar-content">
                                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                                </div>
                            </div>
                            <div class="my-auto">
                                <h4 class="fw-bolder mb-0">$
                                    @if(isset($capitalDisponible))
                                    {{$capitalDisponible}}
                                    @else
                                    0
                                    @endif
                                </h4>
                                <p class="card-text font-small-3 mb-0">Capital a Favor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="d-flex flex-row">
                            <div class="avatar bg-light-danger me-2">
                                <div class="avatar-content">
                                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                                </div>
                            </div>
                            <div class="my-auto">
                                <h4 class="fw-bolder mb-0">$
                                    @if(isset($capitalDisponible))
                                    {{$capitalDisponible}}
                                    @else
                                    0
                                    @endif
                                </h4>
                                <p class="card-text font-small-3 mb-0">Capital en contra</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="basic-datatable">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2">
                                <h2>Ingresos <i data-feather="trending-up"
                                    class="text-success font-medium-1"></i></h2>
                                <div class="table-responsive">
                                    <table class="table rounded border-table border-primary" id="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">ingresos</th>
                                                <th class="text-center">Fecha</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($income as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="fw-bolder text-success text-center">+{{ $item->gain }}$</td>
                                                <td class="text-center">{{ date('d-m-Y', strtotime($item->date)) }}</td>
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
</section>


<section id="basic-datatable">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2">
                                <h2>Egresos <i data-feather="trending-down"
                                class="text-danger font-medium-1"></i></h2>
                                <div class="table-responsive">
                                    <table class="table rounded border-table border-primary" id="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">ingresos</th>
                                                <th class="text-center">Fecha</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($discharge as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="fw-bolder text-danger text-center">-{{ $item->expense }}$</td>
                                                <td class="text-center">{{ date('d-m-Y', strtotime($item->date)) }}</td>

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
</section>

@endsection

@section('custom-js')

@include('panels.datatable.scripts')

<script>
    $('#table').dataTable( {
    "order": [[ 3, 'asc' ]]
} );
</script>

@endsection
