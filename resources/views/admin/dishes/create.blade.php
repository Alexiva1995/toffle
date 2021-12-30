<div class="row justify-content-center">
    <div class="col-12">
        <div class="card-body">
            <form class="form form-vertical" action="{{ route('orders.store') }}" id="form_add_order" method="POST">
                @csrf
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-12 mb-1">
                        <div class="mb-1">
                            <label class="form-label" for="name">Nombre del plato</label>
                            <div class="input-group input-group-merge rounded border-primary">
                                <span class="input-group-text"><i data-feather="user"></i></span>
                                <input type="text" id="name"
                                    class="form-control requerid @error('name') is-invalid @enderror"
                                    name="name" placeholder="Nombre" required />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-header">
                        <h4 class="">Tipos de precios</h4>
                    </div>

                    <div class="col-12 col-md-3 mb-1">
                        <div class="mb-1">
                            <label class="form-label" for="cost_price">% ganancia</label>
                            <div class="input-group input-group-merge rounded border-primary">
                                
                                <input type="number" id="cost_price"
                                    class="form-control requerid @error('cost_price') is-invalid @enderror" name="cost_price"
                                     required />
                                @error('cost_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 mb-1">
                        <div class="mb-1">
                            <label class="form-label" for="cost_price">Costo</label>
                            <div class="input-group input-group-merge rounded border-primary">
                                
                                <input type="number" id="cost_price"
                                    class="form-control requerid @error('cost_price') is-invalid @enderror" name="cost_price"
                                     required />
                                @error('cost_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 mb-1">
                        <div class="mb-1">
                            <label class="form-label" for="suggested_price">Sugerido</label>
                            <div class="input-group input-group-merge rounded border-primary">
                                
                                <input type="number" id="suggested_price"
                                    class="form-control requerid @error('suggested_price') is-invalid @enderror" name="suggested_price"
                                     required readonly />
                                @error('suggested_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 mb-1">
                        <div class="mb-1">
                            <label class="form-label" for="designated_price">Designado</label>
                            <div class="input-group input-group-merge rounded border-primary">
                                
                                <input type="number" id="designated_price"
                                    class="form-control requerid @error('designated_price') is-invalid @enderror" name="designated_price"
                                     required />
                                @error('designated_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

       
                    
                    <div class="col-12 mb-1">
                        <div class="mb-1">
                            <div class="row justify-content-center">

                                
                                <div class="col-12 col-md-5">
                                    <label class="form-label" for="designated_price">Ingrediente</label>
                                    <select class="select2 form-control" data-toggle="select" class="form-control"
                                        id="selected_dish">
                                        <option disabled selected value="">Selecciona un Plato
                                        </option>
                                        <optgroup label="Postres">
                                            <option value="plate1">Postre1</option>
                                            <option value="plate2">Postre2</option>
                                        </optgroup>
                                        <optgroup label="Bebidas">
                                            <option value="plate3">Bebida1</option>
                                            <option value="plate4">Bebida2</option>
                                        </optgroup>
                                    </select>
                                </div>

                                
                                <div class="col-12 col-md-4">
                                    <div class="mb-1">
                                        <label class="form-label" for="designated_price">Porcion en Gramos</label>
                                        <div class="input-group input-group-merge rounded border-primary">
                                            
                                            <input type="number" id="designated_price"
                                                class="form-control requerid @error('designated_price') is-invalid @enderror" name="designated_price"
                                                 required />
                                            @error('designated_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 mt-2">
                                    <a class="btn btn-primary" href="javascript:;" onclick="addRow();">
                                        <i class="" data-feather="plus-circle"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="items_table">
                            <thead class="thead-light text-center">
                                <th>N°</th>
                                <th>Ingrediente</th>
                                <th>Porcion</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
