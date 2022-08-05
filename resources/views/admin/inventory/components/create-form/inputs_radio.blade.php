<div class="col-12 mb-2">
    <div class="d-flex justify-content-center @error('currency') is-invalid @enderror">
        <div class="form-radio">
            <input style="cursor: pointer" class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_COP" value="COP" checked/>
            <label class="form-radio-label" for="radio_COP" style="cursor: pointer">COP</label>
            <input class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_USD" value="USD" style="cursor: pointer"/>
            <label class="form-radio-label" for="radio_USD" style="cursor: pointer">USD</label>
            <input class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_BS" value="BS" style="cursor: pointer"/>
            <label class="form-radio-label" for="radio_BS" style="cursor: pointer">BS</label>
        </div>
    </div>
    @error('currency')
        <span class="invalid-feedback text-center" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror   
</div>