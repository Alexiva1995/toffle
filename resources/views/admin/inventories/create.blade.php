@extends('layouts/contentLayoutMaster')

@section('title', 'Crear Inventario')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
<!-- Vertical Wizard -->
<section class="vertical-wizard">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Datos Requeridos</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="{{ route('store.inventory') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="name">Nombre</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="database"></i></span>
                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                            placeholder="Nombre" />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="total">Cantidad Total</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="archive"></i></span>
                                        <input type="number" id="total" class="form-control @error('total') is-invalid @enderror" name="total"
                                            placeholder="Cant. Total" />
                                        @error('total')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="deposit">Depósito</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="download"></i></span>
                                        <input type="number" id="deposit" class="form-control @error('deposit') is-invalid @enderror"
                                            name="deposit" placeholder="Depósito" />
                                        @error('deposit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="local">Local</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="inbox"></i></span>
                                        <input type="number" id="local" class="form-control @error('local') is-invalid @enderror" name="local"
                                            placeholder="Local" />
                                        @error('local')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="public">Público</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="briefcase"></i></span>
                                        <input type="number" id="public" class="form-control @error('public') is-invalid @enderror" name="public"
                                            placeholder="Correo" />
                                        @error('public')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="cost">Costo</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                        <input type="number" id="cost" class="form-control @error('cost') is-invalid @enderror"
                                            name="cost" placeholder="Costo" step="0.01"/>
                                        @error('cost')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end mt-2">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary me-1">Crear</button>
                                <a href="{{ route('list.employees') }}"  class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection

