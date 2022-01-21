@extends('layouts/contentLayoutMaster')

@section('title', 'Flujo de caja')

@include('panels.datatable.styles')

@section('vendor-style')
<!-- vendor css files -->
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

@include('admin.reports.partials.income')

@include('admin.reports.partials.discharge')

@endsection