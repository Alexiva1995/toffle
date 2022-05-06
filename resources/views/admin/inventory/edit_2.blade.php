<div class="row justify-content-center">
    <div class="col-12">
        <div class="card m-0">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                <form class="form form-vertical" id="form_edit_inventory_2" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_unit_package_2">Unidades</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="package"></i></span>
                                    <input type="number" id="edit_unit_package_2" class="form-control @error('unit_package') is-invalid @enderror" name="unit_package"
                                        placeholder="Cantidad" onkeyup="calculateCost2()"/>
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
                                <label class="form-label" for="edit_price_2">Precio</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                    <input type="number" id="edit_price_2" class="form-control @error('price') is-invalid @enderror" name="price"
                                        placeholder="Precio por Bulto" step="0.01" onkeyup="calculateCost2()"/>
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="edit_cost_2">Costo</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="dollar-sign"></i></span>
                                    <input type="number" id="edit_cost_2" class="form-control @error('cost') is-invalid @enderror" name="cost"
                                        placeholder="Costo" step="0.01"/>
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
                                <label class="form-label" for="edit_deposit_2">Depósito</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="inbox"></i></span>
                                    <input type="number" id="edit_deposit_2" class="form-control @error('deposit') is-invalid @enderror" name="deposit"
                                        placeholder="Depósito" step="0.01" onkeyup="calculateTotal2()"/>
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
                                <label class="form-label" for="edit_local_2">Local</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="package"></i></span>
                                    <input type="number" id="edit_local_2" class="form-control @error('local') is-invalid @enderror"
                                        name="local" placeholder="Local" onkeyup="calculateTotal2()"/>
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
                                <label class="form-label" for="edit_public_2">Público</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="home"></i></span>
                                    <input type="number" id="edit_public_2" class="form-control @error('public') is-invalid @enderror" name="public"
                                        placeholder="Público" step="0.01" onkeyup="calculateTotal2()" />
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
                                <label class="form-label" for="edit_total_2">Total</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="hard-drive"></i></span>
                                    <input type="number" id="edit_total_2" class="form-control @error('price') is-invalid @enderror" name="total"
                                        placeholder="Total" step="0.01" readonly/>
                                    @error('total')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="update_type" value="1">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

