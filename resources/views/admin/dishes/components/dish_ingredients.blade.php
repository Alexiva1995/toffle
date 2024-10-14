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
                            name="portion"/>
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
                <a class="btn btn-primary prueba" id="btn_add_ingredient" href="javascript:;"
                    onclick="addRow('create');">Añadir ingrediente</a>
            </div>

        </div>
    </div>
</div>