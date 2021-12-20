<div class="row justify-content-center">
    <div class="col-12">
        <div class="m-0">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                <form class="form form-vertical" id="form_edit_product" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label for="product_id">Producto</label>
                                <select class="select2 form-control" data-toggle="select" name="product_id"
                                    id="edit_product_id">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"> {{ $product->name }} - Gr: {{ $product->gr }} </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                          
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="qty_package">Cantidad de Bultos</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="edit_qty_package" class="form-control @error('qty_package') is-invalid @enderror" name="qty_package"
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
                                <label class="form-label" for="unit_package">Unidad de Bulto</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="package"></i></span>
                                    <input type="number" id="edit_unit_package" class="form-control @error('unit_package') is-invalid @enderror"
                                        name="unit_package" placeholder="Unidad" />
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
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                    <input type="number" id="edit_price" class="form-control @error('price') is-invalid @enderror" name="price"
                                        placeholder="Precio" step="0.01" />
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="inventory_id" id="inventory_id">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
