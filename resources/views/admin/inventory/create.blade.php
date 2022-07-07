<div class="row justify-content-center">
    <div class="col-12">
        <div class="card m-0">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                <form class="form form-vertical" action="{{ route('add.product.to.inventory') }}" id="form_add_inventory" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label for="product_id">Producto</label>
                                <select class="select2 form-select" data-toggle="select" name="product_id" id="create_product_id" required>
                                    <option value selected disabled>Seleccionar un Producto</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-flavor="{{ $product->it_has_flavors }}"> {{ $product->name }} - Marca: {{ $product->mark }} </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                          
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-1 flavor-name d-none">
                            <div class="mb-1">
                                <label class="form-label" for="flavor_name">Nombre del Sabor</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="tag"></i></span>
                                    <input type="text" id="flavor_name" class="form-control @error('flavor_name') is-invalid @enderror" name="flavor_name"
                                        placeholder="Nombre del Sabor" />
                                    @error('flavor_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="it_has_flavors" name="it_has_flavors">

                        {{-- <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="qty_package">Cantidad de Bultos</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="create_qty_package" class="form-control @error('qty_package') is-invalid @enderror" name="qty_package"
                                        placeholder="Cantidad" />
                                    @error('qty_package')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="unit_package">Unidades</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="package"></i></span>
                                    <input type="number" id="create_unit_package" class="form-control @error('unit_package') is-invalid @enderror"
                                        name="unit_package" placeholder="Unidad" min="1" step="0" onkeydown="filter()" required />
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
                                <label class="form-label" for="price">Precio</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                    <input type="number" id="create_price" class="form-control @error('price') is-invalid @enderror" name="price"
                                        placeholder="Precio en COP" step="0.01" required/>
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="d-flex justify-content-center @error('iva') is-invalid @enderror">
                                <div class="form-check">
                                    <input type="hidden" name="iva" value="0"/>
                                    <input class="form-check-input border border-primary @error('iva') is-invalid @enderror" type="checkbox" name="iva" id="checkbox_iva" value="1" />
                                    <label class="form-check-label" for="checkbox_iva">Iva (19%)</label>
                                </div>
                            </div>
                            @error('iva')
                                <span class="invalid-feedback text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>  
                        <div class="col-12 mb-2">
                            <div class="d-flex justify-content-center @error('currency') is-invalid @enderror">
                                <div class="form-radio">
                                    <input class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_COP" value="COP" checked/>
                                    <label class="form-radio-label" for="radio_currency">COP</label>
                                    <input class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_USD" value="USD"/>
                                    <label class="form-radio-label" for="radio_currency">USD</label>
                                    <input class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_BS" value="BS"/>
                                    <label class="form-radio-label" for="radio_currency">BS</label>
                                </div>
                            </div>
                            @error('currency')
                                <span class="invalid-feedback text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>  

                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <div id="dolar_cop">
                                    <label class="form-label" for="price">Valor Dolar en Pesos</label>
                                    <div class="input-group input-group-merge ">
                                        <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                        <input type="number" id="dolar_cop_price" class="form-control @error('price') is-invalid @enderror" name="dolar_cop_price"
                                        placeholder="Precio" step="0.01" />
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div id="dolar_bs">
                                    <label class="form-label" for="price">Valor Dolar en BS</label>
                                    <div class="input-group input-group-merge ">
                                        <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                        <input type="number" id="dolar_bs_price" class="form-control @error('price') is-invalid @enderror" name="dolar_bs_price"
                                        placeholder="Precio" step="0.01" />
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="unit_cost" name="unit_cost"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
