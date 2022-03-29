<div class="row justify-content-center">
    <div class="col-12">
        <div class="card m-0">
            <div class="card-header">
                <h3 class="text-center product_name"></h3>
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                <form class="form form-vertical" action="{{ route('inventory.update') }}" id="form_edit_inventory" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row justify-content-center">

                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_qty_package">Cantidad de Bultos</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="edit_qty_package " class="form-control @error('qty_package') is-invalid @enderror" name="qty_package"
                                        placeholder="Cantidad" />
                                    @error('qty_package')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_unit_package">Unidades por Bulto</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="edit_unit_package" class="form-control @error('unit_package') is-invalid @enderror" name="unit_package"
                                        placeholder="Cantidad" />
                                    @error('unit_package')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_cost">Costo</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                    <input type="number" id="edit_cost" class="form-control @error('cost') is-invalid @enderror" name="cost"
                                        placeholder="Precio" step="0.01" />
                                    @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_deposit">Depósito</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="edit_deposit" class="form-control @error('deposit') is-invalid @enderror" name="deposit"
                                        placeholder="Cantidad" />
                                    @error('deposit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_local">Local</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="package"></i></span>
                                    <input type="number" id="edit_local" class="form-control @error('local') is-invalid @enderror"
                                        name="local" placeholder="Unidad" />
                                    @error('local')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_public">Público</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                    <input type="number" id="edit_public" class="form-control @error('public') is-invalid @enderror" name="public"
                                        placeholder="Precio" step="0.01" />
                                    @error('public')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_total">Total</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                    <input type="number" id="edit_total" class="form-control @error('price') is-invalid @enderror" name="total"
                                        placeholder="Precio" step="0.01" />
                                    @error('total')
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

