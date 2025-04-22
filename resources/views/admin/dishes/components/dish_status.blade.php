<div class="col-12 col-md-4">
    <label class="form-label" for="status">Estado</label>
    <select class="select2 form-control @error('status') is-invalid @enderror" name="status" data-toggle="select"
        class="form-control" id="status" required>
        <option disabled selected value="">Selecciona un Estado</option>
        <option value="1" {{ old('status') == "1" ? 'selected' : '' }}>Activo</option>
        <option value="2" {{ old('status') == "2" ? 'selected' : '' }}>En Revisión</option>
        <option value="0" {{ old('status') == "0" ? 'selected' : '' }}>Inactivo</option>
    </select>

    @error('status')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>