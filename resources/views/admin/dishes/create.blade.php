@extends('layouts/contentLayoutMaster')

@section('title', 'Crear Plato')

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
                        <form class="form form-vertical" action="{{ route('store.dishes') }}" method="POST">
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
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label class="form-label" for="ingredients">Ingredientes</label>--}}
{{--                                        <div class="input-group input-group-merge rounded border-primary">--}}
{{--                                            <span class="input-group-text"><i data-feather="book-open"></i></span>--}}
{{--                                            <input type="text" id="ingredients" class="form-control @error('ingredients') is-invalid @enderror" name="ingredients"--}}
{{--                                                   placeholder="Ingredientes" />--}}
{{--                                            @error('ingredients')--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                            <strong>{{ $message }}</strong>--}}
{{--                                        </span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-12 col-md-7 mb-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="ingredient">Ingredientes</label>
                                        <select class="select2 form-select @error('ingredient') is-invalid @enderror" id="ingredient" name="ingredient[]" multiple="multiple">
                                            <option disabled>Selecciona un Ingrediente</option>
                                            @foreach ($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}"> {{ $ingredient->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('ingredient')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-1">
                                        <label class="form-label" for="portion">Porción</label>
                                        <div class="input-group input-group-merge rounded border-primary">
                                            <span class="input-group-text"><i data-feather="pie-chart"></i></span>
                                            <input type="text" id="portion" class="form-control @error('portion') is-invalid @enderror" name="portion"
                                                   placeholder="Porción" />
                                            @error('portion')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-1">
                                        <label class="form-label" for="percentage">Porcentaje de Ganancia (%)</label>
                                        <div class="input-group input-group-merge rounded border-primary">
                                            <span class="input-group-text"><i data-feather="percent"></i></span>
                                            <input type="text" id="percentage" class="form-control @error('percentage') is-invalid @enderror"
                                                   name="percentage" placeholder="Porcentaje de Ganancia" />
                                            @error('percentage')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-1">
                                        <label class="form-label" for="category">Categoría</label>
                                        <div class="input-group input-group-merge rounded border-primary">
                                            <span class="input-group-text"><i data-feather="bookmark"></i></span>
                                            <input type="text" id="category" class="form-control @error('category') is-invalid @enderror" name="category"
                                                   placeholder="Categoría" />
                                            @error('category')
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
