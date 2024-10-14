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