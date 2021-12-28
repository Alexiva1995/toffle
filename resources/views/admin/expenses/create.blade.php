@extends('layouts/contentLayoutMaster')

@section('title', 'Añadir Gasto')

@section('vendor-style')
@endsection

@section('page-style')
@endsection

@section('content')
<!-- Vertical Wizard -->
<section class="vertical-wizard">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h4 class="card-title">Datos Requeridos</h4> --}}
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="{{ route('expenses.store') }}" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="mb-1">
                                            <label class="form-label" for="amount">Monto</label>
                                            <div class="input-group input-group-merge rounded border-primary">
                                                <span class="input-group-text"><i data-feather="briefcase"></i></span>
                                                <input type="number" id="amount" class="form-control @error('amount') is-invalid @enderror"
                                                    name="amount" placeholder="Monto" step="0.01"/>
                                                @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="mb-1">
                                            <label class="form-label" for="amount">Categoría</label>
                                            <select class="select2 form-control" data-toggle="select" name="category_id"
                                                id="category_id">
                                                <option value selected disabled>Seleccionar una Categoría</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror    
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-8 mb-1">
                                        <label class="label-required">
                                            Descripción
                                        </label>
                                        <textarea type="text" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="6" cols="50" value="{{ old('description') }}">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end mt-2">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary me-1">Añadir</button>
                                <a href="{{ route('expenses.list') }}"  class="btn btn-outline-secondary">Cancelar</a>
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
@endsection

@section('page-script')
  <!-- Page js files -->
@endsection

@section('custom-js')
@endsection

