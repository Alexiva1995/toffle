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
                                        <span class="input-group-text"><i data-feather="package"></i></span>
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
                                    <label class="form-label" for="gr">Gr.</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="archive"></i></span>
                                        <input type="number" id="gr" class="form-control @error('gr') is-invalid @enderror" name="gr"
                                            placeholder="Gr." />
                                        @error('gr')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="status">Alerta de Unidades de Reposición</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                      <option selected disabled>Selecciona un Estatus</option>
                                      <option value="1">Activado</option>
                                      <option value="0">Desactivado</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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

