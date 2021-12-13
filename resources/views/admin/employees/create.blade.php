@extends('layouts/contentLayoutMaster')

@section('title', 'Registrar Nuevo Empleado')

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
                    <form class="form form-vertical" action="{{ route('store.employees') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="name">Nombres</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                            placeholder="Nombres" />
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
                                    <label class="form-label" for="last_name">Apellidos</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="last_name" class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                            placeholder="Apellidos" />
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="dni">DNI</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                        <input type="text" id="dni" class="form-control @error('dni') is-invalid @enderror" name="dni"
                                            placeholder="DNI" />
                                        @error('dni')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="phone">Número de Teléfono</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="smartphone"></i></span>
                                        <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" placeholder="Teléfono" />
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="email">Correo</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="mail"></i></span>
                                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                            placeholder="Correo" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label for="register-password" class="form-label">Contraseña</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password"
                                            class="form-control form-control-merge @error('password') is-invalid @enderror"
                                            id="password" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="register-password" tabindex="3" />
                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-auto mt-1">
                                            <a class="btn btn-sm btn-primary" id="generate_password"> Generar Contraseña </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="salary">Sueldo</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="briefcase"></i></span>
                                        <input type="number" id="salary" class="form-control @error('salary') is-invalid @enderror"
                                            name="salary" placeholder="Sueldo" step="0.01"/>
                                        @error('salary')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-1">
                                <label class="form-label" for="date_birth">Fecha de Nacimiento</label>
                                <input type="text" id="date_birth" name="date_birth" class="form-control flatpickr-basic @error('date_birth') is-invalid @enderror" placeholder="YYYY-MM-DD"/>
                                @error('date_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="status">Estatus</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                      <option selected disabled>Selecciona un Estatus</option>
                                      <option value="1">Activo</option>
                                      <option value="0">Inactivo</option>
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

  <script>
    $(document).ready(function () {
        $('#generate_password').click(function (e) {
            $.post("{{ route('generate.password') }}", {},
                function (data, textStatus, jqXHR) {
                    $('#password').val(data);
                    toastr['success']('', 'Contraseña Generada', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                },
            );
        });
    });
  </script>
@endsection

