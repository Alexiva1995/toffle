@extends('layouts/contentLayoutMaster')

@section('title', 'Platos')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
@endsection

@section('page-style')
@endsection

@section('content')
@foreach ($dish->ingredients as $ingredient)
    @php $valor[] = $ingredient->id @endphp
@endforeach
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
                                           placeholder="Nombre" value="{{$dish->name}}"/>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-1">
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
                            <div class="mb-1">
                                <label class="form-label" for="portion">Porción</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="database"></i></span>
                                    <input type="text" id="portion" class="form-control @error('portion') is-invalid @enderror" name="ingredient"
                                           placeholder="Porción" value="{{$dish->portion}}"/>
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

            {{-- {{dd($valor)}} --}}
@section('custom-js')
    @include('panels.datatable.scripts')
    <script>
        console.log();
        $("#ingredient").select2({
            tags: true,
            tokenSeparators: [',']
        })
        $('#ingredient').val(@json($valor));
        $('#ingredient').trigger('change');
    </script>
@endsection
