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
                                <label class="form-label" for="edit_total_2">Cantidad</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="hard-drive"></i></span>
                                    <input type="number" id="edit_total_2" class="form-control @error('price') is-invalid @enderror" name="total"
                                        placeholder="Cantidad" step="0.01"/>
                                    @error('total')
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

                        <input type="hidden" name="update_type" value="1">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

