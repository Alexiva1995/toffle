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
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="name">Nombre del plato</label>
                                <div class="input-group input-group-merge ">
                                    <input type="text" id="name"
                                        class="form-control requerid @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
                                        required />
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label" for="category_id">Categoria</label>
                                <select class="select2 form-control @error('category_id') is-invalid @enderror" name="category_id" data-toggle="select"
                                    class="form-control" id="category" value="{{ old('category_id') }}" required>
                                    <option disabled selected value="">Selecciona una categoria</option>
                                    @foreach ($category as $item)
                                    <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label" for="status">Estado</label>
                                <select class="select2 form-control @error('status') is-invalid @enderror" name="status" data-toggle="select"
                                    class="form-control" id="status" required>
                                    <option disabled selected value="">Selecciona un Estado</option>
                                    <option value="1" {{ old('status') == "1" ? 'selected' : '' }}>Activo</option>
                                    <option value="2" {{ old('status') == "2" ? 'selected' : '' }}>En Revisión</option>
                                    <option value="0" {{ old('status') == "0" ? 'selected' : '' }}>Inactivo</option>
                                </select>

                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="card-header">
                                <h4 class="">Ingredientes del plato</h4>
                            </div>

                            <div class="col-12 mb-1">
                                <div class="mb-1">
                                    <div class="row justify-content-center">

                                        <div class="col-12 col-md-5">
                                            <label class="form-label" for="ingredients">Ingrediente</label>
                                            <select class="select2 form-control" data-toggle="select"
                                                class="form-control" name="ingredient" id="selected_ingredient">
                                                <option disabled selected value="">Selecciona un Ingrediente</option>
                                                @foreach ($ingredients as $item)
                                                <option data-gr="{{ $item->product->gr != null ? $item->product->gr : $item->product->quantity }}" data-cost="{{ $item->cost }}" value="ingredient_{{ $item->id }}">{{ $item->product->name }} {{ $item->flavor_name != null ? '('.ucwords($item->flavor_name).')' : '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="mb-1">
                                                <label class="form-label" for="portion">Porcion en Gramos</label>
                                                <div class="input-group input-group-merge ">
                                                    <input type="number" id="portion_dish"
                                                        class="form-control requerid @error('portion') is-invalid @enderror"
                                                        name="portion" required />
                                                    @error('portion')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <input type="hidden" id="calculate_cost">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3 mt-2">
                                            <a class="btn btn-primary" id="btn_add_ingredient" href="javascript:;"
                                                onclick="addRow('create');">Añadir ingrediente</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h4 class="">Base</h4>
                            </div>
                            <div class=" @error('base') is-invalid @enderror">
                                <div class="form-radio">
                                    <input class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="waffle_radio" onclick="dishBase({{ $dish->getDishIngredients('waffle') }})"/>
                                    <label class="form-radio-label" for="radio_currency">Waffle</label>

                                    <input class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="half_waffle_radio" onclick="dishBase({{ $dish->getDishIngredients('half_waffle') }})"/>
                                    <label class="form-radio-label" for="radio_base">1/2 Waffle</label>

                                    <input class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="quarter_waffle_radio" onclick="dishBase({{ $dish->getDishIngredients('quarter_waffle') }})"/>
                                    <label class="form-radio-label" for="radio_base">1/4 Waffle</label>

                                    <input class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="bubble_radio" onclick="dishBase({{ $dish->getDishIngredients('bubble') }})"/>
                                    <label class="form-radio-label" for="radio_base">Bubble</label>
                                </div>
                            </div>

                            <div class="card-header">
                                <h4 class="">Tipos de precios</h4>
                            </div>

                            <div class="col-12 col-md-3 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="percentage_profit">Ganancia</label>
                                    <div class="input-group input-group-merge " id="profit">
                                        <span class="input-group-text"> % </span>
                                        <input type="number" id="percentage_profit"
                                            class="form-control requerid @error('percentage_profit') is-invalid @enderror"
                                            name="percentage_profit" id="percentage_profit" oninput="calculate()" value="{{ old('percentage_profit') }}"
                                            required step="0.01" />
                                        @error('percentage_profit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="cost_price">Costo</label>
                                    <div class="input-group input-group-merge " id="cost">

                                        <input type="text" id="cost_price"
                                            class="form-control requerid @error('cost_price') is-invalid @enderror"
                                            name="cost_price" required readonly />
                                        @error('cost_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="suggested_price">Sugerido</label>
                                    <div class="input-group input-group-merge " id="suggested">

                                        <input type="text" id="suggested_price"
                                            class="form-control requerid @error('suggested_price') is-invalid @enderror"
                                            name="suggested_price" required readonly />
                                        @error('suggested_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="designated_price">Designado</label>
                                    <div class="input-group input-group-merge ">

                                        <input type="number" id="designated_price"
                                            class="form-control requerid @error('designated_price') is-invalid @enderror"
                                            name="designated_price" value="{{ old('designated_price') }}" required step="0.0001" />
                                        @error('designated_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h4 class="">Lista de ingredientes</h4>
                            </div>

                            <section id="basic-datatable">
                                <div class="table-responsive">
                                    <table class="table rounded border-primary" id="items_table">
                                        <thead class="thead-light text-center">
                                            <th>N°</th>
                                            <th>Ingrediente</th>
                                            <th>Porcion</th>
                                            <th>Costo</th>
                                            <th>Accion</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </section>

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

