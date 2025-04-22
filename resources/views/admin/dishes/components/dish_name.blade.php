<div class="col-12 col-md-4">
    <label class="form-label" for="name">Nombre del plato</label>
    <div class="input-group input-group-merge ">
        <input type="text" id="name"
            class="form-control requerid @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
            required />
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>