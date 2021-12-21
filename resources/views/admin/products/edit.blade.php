<div class="row justify-content-center mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body px-2">
                <form class="form form-vertical" id="form_edit_product" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="name">Nombre</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="package"></i></span>
                                    <input type="text" id="edit_name" class="form-control requerid @error('name') is-invalid @enderror" name="name"
                                        placeholder="Nombre"/>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="gr">Gr.</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="edit_gr" class="form-control requerid @error('gr') is-invalid @enderror" name="gr"
                                        placeholder="Gr." />
                                    @error('gr')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-1">
                                <label class="form-label" for="units_reposition_alert">Alerta de Unidades de Reposición</label>
                                <select class="form-select @error('units_reposition_alert') is-invalid @enderror" id="edit_units_reposition_alert" name="units_reposition_alert">
                                  <option value='1'>Activado</option>
                                  <option value='0'>Desactivado</option>
                                </select>
                                @error('units_reposition_alert')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>









