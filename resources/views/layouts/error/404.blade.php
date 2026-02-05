@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

<meta http-equiv="refresh" content="2; url={{ route('login')}}" />

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('css/base/pages/page-auth.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner">
      <h1 class="text-center">Página no Encontrada. Serás redireccionado al Inicio de Sesión
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only"></span>
          </div>
      </h1>
  </div>
</div>
@endsection
 