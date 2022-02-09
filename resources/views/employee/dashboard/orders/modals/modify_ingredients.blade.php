
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Plato: {{ $dish->name }}</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body p-3">

    <div class="row justify-content-center">
        <div class="col-12 col-md-4">
            <label class="form-label" for="ingredient">Ingrediente</label>
            <select class="select2 form-control" data-toggle="select"
                class="form-control" name="ingredient" id="ingredient">
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
            </div>
        </div>

        <div class="col-12 col-md-4 mt-2">
            <button class="btn btn-primary" id="btn_add_ingredient"
                onclick="addIngredient({{ $order->id }}, {{ $pivot_id }}, {{ $dish->id }});">Añadir ingrediente</button>
        </div>

    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-4">
            <label for="">Precio del Plato</label>
            <input type="text" name="flavor_name" class="form-control text-center" id="total_amount" value="{{ $dish->designated_price }}" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="">Porcentaje de Ganancia</label>
            <input type="text" name="flavor_name" class="form-control text-center" id="total_amount" value="{{ $dish->percentage_profit }}" required>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="table-responsive mt-3">
            <table class="table" id="table" >
                <thead>
                    <th class="text-center">Ingrediente</th>
                    <th class="text-center">Porción</th>
                    <th class="text-center">Costo Designado</th>
                    <th class="text-center">Sabor</th>
                    <th class="text-center">Acción</th>
                </thead>
                <tbody>
                    @foreach ($order_ingredients as $order_ingredient)
                        <tr>
                            <td class="text-center">
                                {{ $order_ingredient->product->name }}
                            </td>
                            <td class="text-center">
                                {{ $order_ingredient->pivot->portion }}
                            </td>
                            <td class="text-center">
                                {{ number_format( $order_ingredient->pivot->designated_cost, 2, '.', '' ) }}
                            </td>
                            <td class="text-center">
                                @if ($order_ingredient->pivot->it_has_flavors == true)
                                    <input type="text" name="flavor_name" class="form-control text-center" id="flavor_name_{{ $order_ingredient->pivot->id }}" value="" required placeholder="Nombre">
                                @else
                                    <span class="text-info"> ----- </span> 
                                @endif
                            </td>
                            <td class="text-center"> 
                                <button class="btn btn-sm btn-danger"
                                onclick="deleteElement( {{ $order_ingredient->pivot->id }}, 
                                '#delete_ingredient_', 
                                'este Ingrediente de este Plato' )"> 
                                    <i data-feather="trash-2"></i> 
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>  
        </div>  
    </div>
</div>

<div class="row justify-content-center mb-3">
    <div class="col-auto">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
    </div>
</div>

