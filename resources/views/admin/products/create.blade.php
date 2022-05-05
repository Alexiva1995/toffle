<div class="row justify-content-center mt-2">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header">
                <h5 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body px-2">
                <form class="form form-vertical" action="{{ route('products.store') }}" id="form_add_product" method="POST">
                    @csrf
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="name">Nombre</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="package"></i></span>
                                    <input type="text" id="create_name_product" class="form-control requerid @error('name') is-invalid @enderror" name="name"
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
                                <label class="form-label" for="type">Tipo de Cantidad</label>
                                <select class="form-select rounded border-primary @error('type') is-invalid @enderror" id="type" name="type">
                                    <option selected disabled>Seleccione el tipo</option>
                                    <option value="gr">Gramos (g)</option>
                                    <option value="units">Unidades</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="quantity">Cantidad</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="create_gr_product" class="form-control requerid @error('gr') is-invalid @enderror" name="quantity"
                                        placeholder="Cantidad" />
                                    @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="units_reposition_alert">Alerta de Unidades de Reposición</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="alert-triangle"></i></span>
                                    <input type="number" id="create_units_reposition_alert" class="form-control requerid @error('units_reposition_alert') is-invalid @enderror" name="units_reposition_alert" placeholder="Alerta" />
                                    @error('units_reposition_alert')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>        --}}
                        <div class="col-12 mb-2">
                            <div class="d-flex justify-content-center @error('it_has_flavors') is-invalid @enderror">
                                <div class="form-check">
                                    <input type="hidden" name="it_has_flavors" value="0"/>
                                    <input class="form-check-input border border-primary @error('it_has_flavors') is-invalid @enderror" type="checkbox" name="it_has_flavors" id="checkbox_it_has_flavors" value="1" />
                                    <label class="form-check-label" for="checkbox_it_has_flavors">Sabores</label>
                                </div>
                            </div>
                            @error('it_has_flavors')
                                <span class="invalid-feedback text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>              
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







