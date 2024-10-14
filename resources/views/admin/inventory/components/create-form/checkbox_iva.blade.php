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