@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- Login v1 -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="#" class="brand-logo">
          <img class="img-fluid" src="{{ asset('images/logo/logo-toffle.png') }}" alt="">
        </a>

        <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-1">
            <label for="login-email" class="form-label">Correo Electrónico</label>
            <input
              type="text"
              class="form-control @error('email') is-invalid @enderror"
              id="email"
              name="email"
              value="{{ session('email') }}"
              placeholder="john@example.com"
              aria-describedby="login-email"
              tabindex="1"
              autofocus
              value="{{ old('email') }}"
            />
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="login-password">Contraseña</label>
              {{-- @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}">
                <small>Forgot Password?</small>
              </a>
              @endif --}}
            </div>
            <div class="input-group input-group-merge  form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge @error('password') is-invalid @enderror"
                id="password"
                name="password"
                value="{{ session('password') }}"
                tabindex="2"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="login-password"
              />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="mb-1">
            <div class="form-check">
              <input type="hidden" name="remember" value="0">
              <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1" tabindex="3" {{ old('remember') ? 'checked' : '' }} 
              {{  session('remember') == 1 ? 'checked' : '' }} />
              <label class="form-check-label" for="remember"> Recordarme </label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100" tabindex="4">Iniciar Sesión</button>
        </form>

        {{-- <p class="text-center mt-2">
          <span>New on our platform?</span>
          @if (Route::has('register'))
          <a href="{{ route('register') }}">
            <span>Create an account</span>
          </a>
          @endif
        </p> --}}

        {{-- <div class="divider my-2">
          <div class="divider-text">or</div>
        </div>

        <div class="auth-footer-btn d-flex justify-content-center">
          <a href="#" class="btn btn-facebook">
            <i data-feather="facebook"></i>
          </a>
          <a href="#" class="btn btn-twitter white">
            <i data-feather="twitter"></i>
          </a>
          <a href="#" class="btn btn-google">
            <i data-feather="mail"></i>
          </a>
          <a href="#" class="btn btn-github">
            <i data-feather="github"></i>
          </a>
        </div> --}}
      </div>
    </div>
    <!-- /Login v1 -->
  </div>
</div>

@endsection
