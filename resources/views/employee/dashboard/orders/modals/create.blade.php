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
                        <div class="card-body py-0 px-2">
                            <form class="form form-vertical" action="{{ route('products.store') }}" id="form_add_product" method="POST">
                                @csrf
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 col-md-6 mb-1">
                                        <label class="form-label" for="select2-multiple">Multiple</label>
                                        <select class="select2 form-select" id="select2-multiple" multiple>
                                          <optgroup label="Alaskan/Hawaiian Time Zone">
                                            <option value="AK">Alaska</option>
                                            <option value="HI">Hawaii</option>
                                          </optgroup>
                                          <optgroup label="Pacific Time Zone">
                                            <option value="CA">California</option>
                                            <option value="NV">Nevada</option>
                                            <option value="OR">Oregon</option>
                                            <option value="WA">Washington</option>
                                          </optgroup>
                                          <optgroup label="Mountain Time Zone">
                                            <option value="AZ">Arizona</option>
                                            <option value="CO" selected>Colorado</option>
                                            <option value="ID">Idaho</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="UT">Utah</option>
                                            <option value="WY">Wyoming</option>
                                          </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mb-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="customer_name">Nombre del Cliente</label>
                                            <div class="input-group input-group-merge rounded border-primary">
                                                <span class="input-group-text"><i data-feather="user"></i></span>
                                                <input type="text" id="customer_name" class="form-control requerid @error('customer_name') is-invalid @enderror" name="customer_name"
                                                    placeholder="Nombre"/>
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
                                            <div class="input-group input-group-merge rounded border-primary">
                                                <span class="input-group-text"><i data-feather="tag"></i></span>
                                                <input type="text" id="table" class="form-control requerid @error('table') is-invalid @enderror" name="table"
                                                    placeholder="Mesa" />
                                                @error('table')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="total_amount">Monto de lo Pedido</label>
                                            <div class="input-group input-group-merge rounded border-primary">
                                                <span class="input-group-text"><i data-feather="archive"></i></span>
                                                <input type="number" id="total_amount" class="form-control requerid @error('total_amount') is-invalid @enderror" name="total_amount"
                                                    placeholder="Monto Total" />
                                                @error('total_amount')
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
            <button type="button" class="btn btn-primary" id="add_product">
                <span class="loading_btn_p mr-2"></span> Añadir
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>