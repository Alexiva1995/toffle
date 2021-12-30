@extends('layouts/contentLayoutMaster')

@section('title', 'Crear Ingrediente')

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
                        <form class="form form-vertical" action="{{ route('store.ingredients') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombre</label>
                                        <div class="input-group input-group-merge rounded border-primary">
                                            <span class="input-group-text"><i data-feather="clipboard"></i></span>
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
                               
                            </div>
                            <div class="row justify-content-end mt-2">
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary me-1">Crear</button>
                                    <a href="{{ route('index.dishes') }}"  class="btn btn-outline-secondary">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-js')
    <script>
        $("#ingredient").select2({
            tags: true,
            tokenSeparators: [',']
        })
    </script>
@endsection
