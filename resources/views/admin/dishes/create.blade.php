@extends('layouts/contentLayoutMaster')

@section('title', 'Crear plato')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form form-vertical" action="{{ route('dishes.store') }}" id="form_create_dish"
                        method="POST">
                        @csrf
                        <div class="row justify-content-center align-items-center">
                            @include('admin.dishes.components.dish_name')

                            @include('admin.dishes.components.dish_category')

                            @include('admin.dishes.components.dish_status')

                            @include('admin.dishes.components.dish_ingredients')

                            @include('admin.dishes.components.base_radios')

                            @include('admin.dishes.components.dish_prices')

                            <div class="card-header">
                                <h4 class="">Lista de ingredientes</h4>
                            </div>

                            @include('admin.dishes.components.table')
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2" id="create_dish">
                                <span class="loading_create_dish mr-2"></span> Crear Plato
                            </button>
                            <a href="{{ route('dishes.index') }}" class="btn btn-outline-secondary ml-4">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
  {{-- vendor files --}}
@endsection

@section('page-script')
  {{-- Page js files --}}
@endsection

@section('custom-js')
    @include('admin.dishes.partials.script');
@endsection

