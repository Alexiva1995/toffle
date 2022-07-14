
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Plato: {{ $dish->name }}</h4>
    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
</div>

<div class="modal-body">

    <div class="row justify-content-center align-items-center">
        <div class="table-responsive mt-3">
            <table class="table" id="table" >
                <thead>
                    <th class="text-center">Ingrediente</th>
                    <th class="text-center">Porción</th>
                    <th class="text-center">Costo</th>
                    <th class="text-center" colspan="2">Nombre del Sabor</th>
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
                                    <select class="select2 form-control" data-toggle="select" class="form-control flavor" id="flavor_name_{{ $order_ingredient->pivot->id }}" onchange="updateFlavorName( this, {{ $order->id }}, {{ $order_ingredient->pivot->id }})">
                                        <option disabled selected value="none">--Selecione un sabor--</option>                                     
                                        @foreach ($ingredients->where('product_id', $order_ingredient->product->id) as $item)
                                            <option value="{{ $item->flavor_name }}" {{ $item->flavor_name == $order_ingredient->pivot->flavor_name ? 'selected' : ''}}>{{ ucfirst($item->flavor_name) }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="text-info"> ----- </span> 
                                @endif
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
        <button type="button" onclick="closeModal()" class="btn btn-outline-secondary">Cerrar</button>
    </div>
</div>

