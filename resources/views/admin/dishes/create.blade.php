@extends('layouts/contentLayoutMaster')

@section('title', 'Crear plato')

@include('panels.datatable.styles')

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
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="name">Nombre del plato</label>
                                <div class="input-group input-group-merge ">
                                    <input type="text" id="name"
                                        class="form-control requerid @error('name') is-invalid @enderror" name="name"
                                        required />
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="ingredients">Categoria</label>
                                <select class="select2 form-control" name="category_id" data-toggle="select"
                                    class="form-control" id="category">
                                    <option disabled selected value="">Selecciona una categoria</option>
                                    @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
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
                                                <option data-gr="{{ $item->product->gr }}" data-cost="{{ $item->cost }}" value="ingredient_{{ $item->id }}">{{ $item->product->name }}</option>
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
                                <h4 class="">Tipos de precios</h4>
                            </div>

                            <div class="col-12 col-md-3 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="percentage_profit">% Ganancia</label>
                                    <div class="input-group input-group-merge " id="profit">
                                        <span class="input-group-text"> % </span>
                                        <input type="number" id="percentage_profit"
                                            class="form-control requerid @error('percentage_profit') is-invalid @enderror"
                                            name="percentage_profit" id="percentage_profit" oninput="calculate()"
                                            required />
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
                                            name="designated_price" required step="0.0001" />
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

    <script>
        submitForms('#create_dish', '.loading_create_dish', '#form_create_dish');
    </script>

@endsection

