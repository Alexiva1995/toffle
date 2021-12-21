@extends('layouts/contentLayoutMaster')

@section('title', 'Platos')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
@endsection

@section('page-style')
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card m-0">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                <form class="form form-vertical" action="{{ route('update.dishes', $dish->id) }}" id="form_update_dish" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 mb-1">
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
                            <div class="mb-1">
                                <label class="form-label" for="ingredient">Ingrediente</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="database"></i></span>
                                    <input type="text" id="ingredient" class="form-control @error('ingredient') is-invalid @enderror" name="ingredient"
                                           placeholder="Ingrediente" />
                                    @error('ingredient')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="portion">Porción</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="database"></i></span>
                                    <input type="text" id="portion" class="form-control @error('portion') is-invalid @enderror" name="ingredient"
                                           placeholder="Porción" />
                                    @error('portion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{asset('js/scripts/components/components-navs.js')}}"></script>
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
@endsection
