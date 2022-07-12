<div class="col-12 mb-2">
    <div class="d-flex justify-content-center @error('currency') is-invalid @enderror">
        <div class="form-radio">
            <input class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_COP" value="COP" checked/>
            <label class="form-radio-label" for="radio_currency">COP</label>
            <input class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_USD" value="USD"/>
            <label class="form-radio-label" for="radio_currency">USD</label>
            <input class="form-check-input border border-primary @error('currency') is-invalid @enderror" type="radio" name="currency" id="radio_BS" value="BS"/>
            <label class="form-radio-label" for="radio_currency">BS</label>
        </div>
    </div>
    @error('currency')
        <span class="invalid-feedback text-center" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror   
</div>