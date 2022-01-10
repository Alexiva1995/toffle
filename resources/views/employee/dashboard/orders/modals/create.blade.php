<!-- Modal Add Order -->
<div
  class="modal fade text-start"
  id="modal_add_order"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Añadir Producto</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center mt-2">
                    <div class="col-12">
                        <div class="mb-0">
                            <div class="card-header">
                                <h4 class="">Datos Requeridos</h4>
                            </div>
                            <div class="card-body px-2">
                                <form class="form form-vertical" action="{{ route('orders.store') }}" id="form_add_order" method="POST">
                                    @csrf
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-12 col-md-6 mb-1">
                                            <div class="mb-1">
                                                <label class="form-label" for="customer_name">Nombre del Cliente</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i data-feather="user"></i></span>
                                                    <input type="text" id="customer_name" class="form-control requerid @error('customer_name') is-invalid @enderror" name="customer_name"
                                                    placeholder="Nombre" required/>
                                                    @error('customer_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 mb-1">
                                            <div class="mb-1">
                                                <label class="form-label" for="table">Mesa</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i data-feather="tag"></i></span>
                                                    <input type="number" id="table" class="form-control requerid @error('table') is-invalid @enderror" name="table"
                                                    placeholder="Mesa" required/>
                                                    @error('table')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-12 mb-1">
                                            <div class="mb-1">
                                                <div class="row justify-content-center">
                                                    <h5 class="text-center mb-2">Añadir Platos</h5>
                                                    <div class="col-12 col-md-6">
                                                        <select class="select2 form-control" data-toggle="select" class="form-control" id="selected_dish">
                                                            <option disabled selected value=''>Selecciona un Plato</option>
                                                            @foreach ($dish_category as $item)
                                                                <optgroup label="{{ $item->category->name }}"> 
                                                                    @foreach ($item->collectionDishes($item->category_id) as $dish)
                                                                        <option data-price = {{ $dish->designated_price }} value="dish_{{ $dish->id }}">{{ $dish->name }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>
    
                                                    <div class="col-auto">
                                                        <a class="btn btn-info" href="javascript:;" onclick="addRow();">
                                                            <i class="" data-feather="plus-circle"></i> Añadir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    

                                        <div class="table-responsive">
                                            <table class="table" id="items_table">
                                                <thead class="thead-light text-center">
                                                    <th class="col-4">Plato</th>
                                                    <th class="col-2">N°</th>
                                                    <th class="col-3">Precio Unitario</th>
                                                    <th class="col-3">Total</th>
                                                    <th class="col-2"></th>
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
                                                <tfoot>
                                                    <tr style="font-weight: bold; font-size: 14px;">
                                                        <td style="border-top: none !important;"></td>
                                                        <td colspan="2" class="text-right">TOTAL</td>
                                                        <td colspan="2" class="text-right" style="padding-right: 20px;"><input type="text" class="form-control" name="total_amount" id="total_amount" value="0.00" style="border: none !important; font-size: 14px !important;" readonly></td>
                                                    </tr>
                                                </tfoot>
                                            </table>           
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add_order">
                    <span class="loading_add_order mr-2"></span> Agregar
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>