<div class="col-12 col-md-4">
    <label class="form-label" for="category_id">Categoria</label>
    <select class="select2 form-control @error('category_id') is-invalid @enderror" name="category_id" data-toggle="select"
        class="form-control" id="category" value="{{ old('category_id') }}" required>
        <option disabled selected value="">Selecciona una categoria</option>
        @foreach ($category as $item)
        <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
        @endforeach
    </select>

    @error('category_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>