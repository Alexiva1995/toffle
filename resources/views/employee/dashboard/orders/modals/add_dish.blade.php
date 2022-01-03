<!-- Modal Add Order -->
<div
  class="modal fade text-start"
  id="modal_add_dish"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Añadir Plato</h4>
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
                            <form class="form form-vertical" action="{{ route('dish.add', $order->id) }}" id="form_add_dish" method="POST">
                                @csrf
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 col-md-4 mb-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="dish_id">Plato</label>
                                            <select class="select2 form-control" data-toggle="select" name="dish_id" id="dish_id">
                                                <option disabled selected value="">Selecciona un Plato</option>
                                                <optgroup label="Postres"> 
                                                    <option value="1">Postre1</option>
                                                    <option value="2">Postre2</option> 
                                                </optgroup>
                                                <optgroup label="Bebidas"> 
                                                    <option value="3">Bebida1</option>
                                                    <option value="4">Bebida2</option> 
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-12 col-md-4 mb-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="unit">N° de Unidades</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i data-feather="box"></i></span>
                                                <input type="number" id="unit" class="form-control requerid @error('unit') is-invalid @enderror" name="unit"
                                                    placeholder="N° de Unidades" required/>
                                                @error('unit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mb-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="price">Precio Unitario</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i data-feather="tag"></i></span>
                                                <input type="number" id="price" class="form-control requerid @error('price') is-invalid @enderror" name="price" placeholder="Precio por Unidad" required/>
                                                @error('price')
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
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" id="add_dish">
                <span class="loading_add_dish mr-2"></span> Añadir
            </a>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>