
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Plato: {{ $dish->name }}</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body p-3">

    <div class="row justify-content-center">
        <div class="col-12 col-md-4 col-sm-6">
            <label class="form-label" for="ingredient">Ingrediente</label>
            <select class="select2 form-control" data-toggle="select"
                class="form-control" name="ingredient" id="ingredient">
                <option disabled selected value="">Selecciona un Ingrediente</option>
                @foreach ($ingredients as $item)
                    <option data-gr="{{ $item->product->gr }}" data-cost="{{ $item->cost }}" value="{{ $item->id }}">{{ $item->product->name }} {{ $item->flavor_name != null ? '('.ucwords($item->flavor_name).')' : '' }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-4 col-sm-6">
            <div class="mb-1">
                <label class="form-label" for="portion">Porcion en Gramos</label>
                <div class="input-group input-group-merge ">
                    <input type="number" id="portion"
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

        <div class="col-12 col-md-4 col-sm-6 mt-2">
            <button class="btn btn-primary" id="btn_add_ingredient"
                onclick="addIngredient({{ $order->id }}, {{ $code_operation }}, {{ $dish->id }});" id="add_ingredient_order">
                <span class="loading_add_ingredient_order mr-2"></span>
                Añadir ingrediente
            </button>
        </div>


    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-auto">
            <h5 class="text-center">Costo del Plato: {{ $order_dish->pivot->cost }} </h5>
        </div>
        <div class="col-auto">
            <h5 class="text-center">Precio del Plato: {{ $order_dish->pivot->price }} </h5>
        </div>
        <div class="col-auto">
            <h5 class="text-center">Porcentaje de Ganancia: {{ $dish->percentage_profit }} %</h5>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="table-responsive mt-3">
            <table class="table" id="table" >
                <thead>
                    <th class="text-center">Ingrediente</th>
                    <th class="text-center">Porción</th>
                    <th class="text-center">Costo</th>
                    <th class="text-center" colspan="2">Nombre del Sabor</th>
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

                            <td class="text-center" colspan="2">
                                @if ($order_ingredient->pivot->it_has_flavors == true)

                                    <select class="select2 form-control" data-toggle="select" class="form-control" id="flavor_name_{{ $order_ingredient->pivot->id }}" onchange="updateFlavorName( this, {{ $order->id }}, {{ $order_ingredient->pivot->id }})">                                     
                                        @foreach ($ingredients->where('product_id', $order_ingredient->product->id) as $item)
                                            <option value="{{ $item->flavor_name }}" {{ $item->flavor_name == $order_ingredient->pivot->flavor_name ? 'selected' : ''}}>{{ ucfirst($item->flavor_name) }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="text-info"> ----- </span> 
                                @endif
                            </td>
                            <td class="text-center"> 
                                <button class="btn btn-sm btn-danger"
                                onclick="deleteIngredient( {{ $order->id }}, {{ $code_operation }}, {{ $dish->id }}, {{ $order_ingredient->pivot->id }} )"> 
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

