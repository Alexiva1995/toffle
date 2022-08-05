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