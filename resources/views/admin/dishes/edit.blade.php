@extends('layouts/contentLayoutMaster')

@section('title', 'Editar plato')

@include('panels.datatable.styles')

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form form-vertical" action="{{ route('dishes.update', $dish->id) }}" id="form_add_dish"
                        method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="name">Nombre del plato</label>
                                <div class="input-group input-group-merge ">
                                    <input type="text" id="name"
                                        class="form-control requerid @error('name') is-invalid @enderror" name="name" value="{{ $dish->name }}"
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
                                    <option selected value="{{ $dish->category->id }}">{{ $dish->category->name }}</option>
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
                                                class="form-control" id="selected_dish">
                                                <option disabled selected value="">Selecciona un Ingrediente</option>
                                                @foreach ($ingredients as $item)
                                                <option value="ingredient_{{ $item->id }}" price="{{ $item->price }}">
                                                    {{ $item->product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="mb-1">
                                                <label class="form-label" for="portion">Porcion en Gramos</label>
                                                <div class="input-group input-group-merge ">
                                                    <input type="number" id="portion_dish"
                                                        class="form-control requerid @error('portion') is-invalid @enderror"
                                                        name="portion" />
                                                    @error('portion')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3 mt-2">
                                            <a class="btn btn-primary" href="javascript:;"
                                                onclick="addRow();">Añadir ingrediente</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h4 class="">Tipos de precios</h4>
                            </div>

                            <div class="col-12 col-md-3 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="percentage_profit">% ganancia</label>
                                    <div class="input-group input-group-merge " id="profit">
                                        <input type="number" id="percentage_profit"
                                            class="form-control requerid @error('percentage_profit') is-invalid @enderror"
                                            name="percentage_profit" id="percentage_profit" oninput="calculate()" value="{{ $dish->percentage_profit }}"
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
                                            name="cost_price" required readonly value="{{ $dish->cost_price }}" />
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
                                            name="suggested_price" required readonly value="{{ $dish->suggested_price }}" />
                                        @error('suggested_price')
                                        <span class="invalid-feedback" role="alert">}
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
                                            name="designated_price" required value="{{ $dish->designated_price }}" />
                                        @error('designated_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <section id="basic-datatable">
                                <div class="table-responsive">
                                    <table class="table rounded border-primary" id="items_table">
                                        <thead class="thead-light text-center">
                                            <th>N°</th>
                                            <th>Ingrediente</th>
                                            <th>Porcion</th>
                                            <th>Precio</th>
                                            <th>Accion</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($dish->ingredients()->get() as $item)
                                            <tr id="edit_dish_to_order_{{ $item->pivot->id  }}">
                                                    <td class="text-center">{{ $item->pivot->id }}</td>
                                                    <td><input type="text" name="ingredient" class="form-control units" id="selected_dish_{{ $item->pivot->id }}" value="{{ $item->product->name }}" readonly oninput="updateDish( {{ $item->pivot->id }}, this )" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="portion" class="form-control price" id="portion_{{ $item->pivot->id }}" value="{{ $item->pivot->portion }}" readonly oninput="updateDish( {{ $item->pivot->id }}, this )" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="price" class="form-control total" id="price_{{ $item->pivot->id }}" value="{{ $item->pivot->price }}" readonly>
                                                </td>
                                                <td class="text-center"> 
                                                    <button class="btn btn-sm btn-danger"
                                                    onclick="deleteElement()"> 
                                                        <i data-feather="trash-2"></i> 
                                                    </button>
                
                                                    <form id="delete_dish_{{ $item->pivot->id }}" action="{{ route('ingredients.remove', $item->pivot->inventory_id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="dish_id" value="{{ $dish->id }}">                                      
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary pr-2">Editar plato</button>
                            <a href="{{ route('dishes.index') }}" class="btn btn-outline-secondary ml-4">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

@include('admin.dishes.partials.script');

@endsection

