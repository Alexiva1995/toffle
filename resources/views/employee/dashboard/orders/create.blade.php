@extends('layouts/contentLayoutMaster')

@section('title', 'Agregar Pedido')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset('vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">

    @include('panels.datatable.styles')
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-wizard.css') }}">
@endsection

@section('content')
<!-- Vertical Wizard -->
<section class="vertical-wizard">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" id="content_order">
                <div class="card-header">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard-employee') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                Modificaciones Adicionales
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card-body">
                    <section class="horizontal-wizard">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="bs-stepper horizontal-wizard-example" style="box-shadow:none">
                                    <div class="bs-stepper-header" role="tablist">
                                        <div class="step active" data-target="#general-data" role="tab" id="general-data-trigger">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-box">1</span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">Agregar Pedido</span>
                                                    <span class="bs-stepper-subtitle">Se agregara el pedido con  los datos generales</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="line">
                                            <i data-feather="chevron-right" class="font-medium-2"></i>
                                        </div>
                                        <div class="step" data-target="#add-dishes" role="tab" id="add-dishes-trigger">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-box">2</span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">Platos</span>
                                                    <span class="bs-stepper-subtitle">Agregar platos de la órden y modificar sus ingredientes</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="line">
                                            <i data-feather="chevron-right" class="font-medium-2"></i>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <div id="general-data" class="content active" role="tabpanel" aria-labelledby="general-data-trigger">
                                            <div class="content-header">
                                                <h5 class="mb-0">Agregar Pedido</h5>
                                                <small class="text-muted">Se agregaran los datos generales.</small>
                                            </div>
                        
                                            <form id="form_add_order" class="form form-vertical" action="{{ route('orders.store') }}" method="POST">
                                                @csrf
                                                <div class="row justify-content-center align-items-center">
                                                    <div class="col-12 col-md-5 mb-1">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="customer_name">Nombre del Cliente</label>
                                                            <div class="input-group input-group-merge">
                                                                <span class="input-group-text"><i data-feather="user"></i></span>
                                                                <input type="text" id="customer_name" class="form-control requerid @error('customer_name') is-invalid @enderror" name="customer_name"
                                                                placeholder="Nombre" required/>
                                                                @error('customer_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-5 mb-1">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="table">Mesa</label>
                                                            <div class="input-group input-group-merge">
                                                                <span class="input-group-text"><i data-feather="tag"></i></span>
                                                                <input type="number" id="table" class="form-control requerid @error('table') is-invalid @enderror" name="table"
                                                                placeholder="Mesa" required/>
                                                                @error('table')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-primary me-1" id="btn_add_order">
                                                            <span class="loading_add_order mr-2"></span> Añadir
                                                        </button>
                                                        <a href="{{ route('dashboard-employee') }}" class="btn btn-outline-secondary">Cancelar</a>
                                                    </div>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>

<div
  class="modal fade text-start"
  id="modal_show_ingredients"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content ingredients_details">
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/pickadate/picker.time.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/pickadate/legacy.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset('js/scripts/forms/pickers/form-pickers.js') }}"></script>
  <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('custom-js')

@include('panels.datatable.scripts')

<script>
    submitForms('#btn_add_order', '.loading_add_order', '#form_add_order');
</script>

@endsection

