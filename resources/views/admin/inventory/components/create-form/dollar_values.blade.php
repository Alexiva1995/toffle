<div class="col-12 col-md-4 mb-1" id="dollar_value_container">
    <div class="mb-1">
        <div id="dolar_cop">
            <label class="form-label" for="price">Valor Dolar en Pesos</label>
            <div class="input-group input-group-merge ">
                <span class="input-group-text"><i data-feather="credit-card"></i></span>
                <input type="number" id="dolar_cop_price" class="form-control @error('price') is-invalid @enderror"
                    name="dolar_cop_price" placeholder="Precio" step="0.01" />
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
                <input type="number" id="dolar_bs_price" class="form-control @error('price') is-invalid @enderror"
                    name="dolar_bs_price" placeholder="Precio" step="0.01" />
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>