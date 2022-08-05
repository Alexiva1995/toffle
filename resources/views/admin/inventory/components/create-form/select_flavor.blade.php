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