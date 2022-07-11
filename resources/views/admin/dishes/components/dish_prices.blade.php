<div class="card-header">
    <h4 class="">Tipos de precios</h4>
</div>

<div class="col-12 col-md-3 mb-1">
    <div class="mb-1">
        <label class="form-label" for="percentage_profit">Ganancia</label>
        <div class="input-group input-group-merge " id="profit">
            <span class="input-group-text"> % </span>
            <input type="number" id="percentage_profit"
                class="form-control requerid @error('percentage_profit') is-invalid @enderror"
                name="percentage_profit" id="percentage_profit" oninput="calculate()" value="{{ old('percentage_profit') }}"
                required step="0.01" />
            @error('percentage_profit')
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
        <div class="input-group input-group-merge " id="cost">

            <input type="text" id="cost_price"
                class="form-control requerid @error('cost_price') is-invalid @enderror"
                name="cost_price" required readonly />
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
        <div class="input-group input-group-merge " id="suggested">

            <input type="text" id="suggested_price"
                class="form-control requerid @error('suggested_price') is-invalid @enderror"
                name="suggested_price" required readonly />
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
        <div class="input-group input-group-merge ">

            <input type="number" id="designated_price"
                class="form-control requerid @error('designated_price') is-invalid @enderror"
                name="designated_price" value="{{ old('designated_price') }}" required step="0.0001" />
            @error('designated_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>