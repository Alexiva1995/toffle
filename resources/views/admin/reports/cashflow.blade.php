@extends('layouts/contentLayoutMaster')

@section('title', 'Informes')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
@endsection

@section('page-style')
@endsection
@section('content')
<!-- Basic table -->
<div class="col-12">
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
<section id="basic-datatable">
    <div class="row match-height">
        <!-- Centered Aligned Tabs starts -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-12">
                            <div class="card p-2">
                                <h2>Ingresos</h2>
                                <div class="table-responsive">
                                    <table class="table myTable table-striped">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>ingresos</th>
                                                <th>Fecha</th>
                                        </thead>
                                        <tbody>
                                           @foreach ($order as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td class="fw-bolder text-success">+ {{ number_format($item->total_amount, 2, '.', '') }}
                                                        <i data-feather="trending-up" class="text-success font-medium-1"></i>
                                                    </td>
                                                    <td>{{ $item->created_at->format('Y-m-d')}}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <h2>Egresos</h2>
                                <div class="table-responsive">
                                    <table class="table myTable table-striped">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>egresos</th>
                                                <th>Fecha</th>
                                        </thead>
                                        <tbody>
                                            @foreach($expenses as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td class="fw-bolder text-danger">- {{ number_format($item->amount, 2, '.', '') }}
                                                    <i data-feather="trending-down" class="text-danger font-medium-1"></i>
                                                </td>
                                                <td>{{ $item->created_at->format('Y-m-d')}}</td>
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
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script>
         $('.myTable').DataTable({
            responsive: true,
            order: [
                [0, "desc"]
            ],
        })
    </script>
@endsection
