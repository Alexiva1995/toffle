@extends('layouts/contentLayoutMaster')

@section('title', 'Editar plato')

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
                    <form class="form form-vertical" action="{{ route('dishes.update', $dish->id) }}" id="form_edit_dish"
                        method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-4">
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

                            <div class="col-12 col-md-4">
                                <label class="form-label" for="ingredients">Categoria</label>
                                <select class="select2 form-control @error('category_id') is-invalid @enderror" name="category_id" data-toggle="select"
                                    class="form-control" id="category">
                                    @foreach ($category as $item)
                                    <option value="{{ $item->id }}" {{ $dish->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                    class="form-control" id="status">
                                    <option value="1" {{ $dish->status == 1 ? 'selected' : '' }} >Activo</option>
                                    <option value="2" {{ $dish->status == 2 ? 'selected' : '' }} >En Revisión</option>
                                    <option value="0" {{ $dish->status == 0 ? 'selected' : '' }} >Inactivo</option>
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
                                                <option value="" disabled selected> Selecciona un Ingrediente </option>
                                                @foreach ($ingredients as $item)
                                                <option data-gr="{{ $item->product->gr }}" data-cost="{{ $item->cost }}" value="ingredient_{{ $item->id }}" >{{ $item->product->name }}</option>
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
                                                <input type="hidden" id="calculate_cost">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3 mt-2">
                                            <a class="btn btn-primary" href="javascript:;"
                                                onclick="addRow('edit');">Añadir ingrediente</a>
                                        </div>

                                    </div>
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
                                            name="designated_price" required value="{{ $dish->designated_price }}" step="0.0001"/>
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
                                            <th>Costo</th>
                                            <th>Accion</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($dish->ingredients()->orderBy('dish_ingredient.id', 'ASC')->get() as $item)

                                            <tr id="edit_dish_to_order_{{ $item->pivot->id  }}">
                                                <td class="text-center">{{ $item->pivot->id }}</td>
                                                    <input type="hidden" name="ingredient_ids[]" class="form-control text-center dish_ids" id="dish_ids_{{ $item->pivot->id }}" value="ingredient_{{ $item->id }}" required> 
                                                <td>
                                                    <input type="text" name="ingredient[]" class="form-control text-center data_pivot_id" 
                                                    data-id="ingredient_{{ $item->id }}" id="selected_ingredient_{{ $item->pivot->id }}" value="{{ $item->product->name }}" readonly required>
                                                </td>
                                                <td>
                                                    <input type="text" name="portion[]" class="form-control text-center price" id="portion_{{ $item->pivot->id }}" value="{{ $item->pivot->portion }}" readonly required>
                                                </td>
                                                <td>
                                                    <input type="text" name="price[]" class="form-control text-center total data_pivot_cost" id="price_{{ $item->pivot->id }}" value="{{ $item->pivot->designated_cost }}" readonly>
                                                </td>
                                                <td class="text-center"> 
                                                    <a class="btn btn-sm btn-danger" id="delete_ingredient"
                                                        onclick="deleteIngredient( null, {{ $item->pivot->id }}, {{ $dish->id }} )"> 
                                                        <i data-feather="trash-2"></i> 
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2" id="edit_dish">
                                <span class="loading_edit_dish mr-2"></span> Editar plato
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
        submitForms('#edit_dish', '.loading_edit_dish', '#form_edit_dish');

        function deleteIngredient(numRows = null, id = null, dish_id = null) {
            $.confirm({
            title: 'Confirmar!',
            content: 'Estas seguro que quieres eliminar este Ingrediente ?',
            buttons: {
                confirm: {
                    text: 'Eliminar',
                    btnClass: 'btn-danger',
                    action: function () {
                        if (numRows != null) {
                            deleteRow(numRows);
                            toastr['success']('', 'Ingrediente Removido', {
                                closeButton: true,
                                tapToDismiss: false,
                            });
                        }else{
                            url = "{{ route('ingredients.remove', 'parameter') }}";
                            url = url.replace('parameter', id);
                            $.post(url, {
                                    dish_id: dish_id,
                                },
                                function (data, textStatus, jqXHR) {
                                    $('#selected_ingredient_'+id).removeClass('data_pivot_id');
                                    $('#price_'+id).removeClass('data_pivot_cost');
                                    $('#edit_dish_to_order_'+id).addClass('d-none');
                                    toastr['success']('', data, {
                                        closeButton: true,
                                        tapToDismiss: false,
                                    });
                                    for( var i = 0; i < ids.length; i++){ 
                                        if ( ids[i] === $("#dish_ids_"+id).val()) { 
                                          ids.splice(i, 1); 
                                        }
                                    }
                                    calculate();
                                },
                            );
                        }

                    }
                },
                cancelar: function () {
                },
            }
        });
        }

    </script>

@endsection

