<div class="card-header">
    <h4 class="">Base</h4>
</div>
<div class=" @error('base') is-invalid @enderror">
    <div class="form-radio">
        <input style="cursor:pointer;" class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="waffle_radio" onclick="dishBase({{ $dish->getDishIngredients('waffle') }})"/>
        <label style="cursor:pointer;" class="form-radio-label" for="waffle_radio">Waffle</label>
    
        <input style="cursor:pointer;" class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="half_waffle_radio" onclick="dishBase({{ $dish->getDishIngredients('half_waffle') }})"/>
        <label style="cursor:pointer;" class="form-radio-label" for="half_waffle_radio">1/2 Waffle</label>
    
        <input style="cursor:pointer;" class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="quarter_waffle_radio" onclick="dishBase({{ $dish->getDishIngredients('quarter_waffle') }})"/>
        <label style="cursor:pointer;" class="form-radio-label" for="quarter_waffle_radio">1/4 Waffle</label>
    
        <input style="cursor:pointer;" class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="bubble_radio" onclick="dishBase({{ $dish->getDishIngredients('bubble') }})"/>
        <label style="cursor:pointer;" class="form-radio-label" for="bubble_radio">Bubble</label>
    
        <input style="cursor:pointer;" class="form-check-input border border-primary @error('base') is-invalid @enderror" type="radio" name="base" id="toffle_palito_radio" onclick="dishBase({{ $dish->getDishIngredients('palito') }})"/>
        <label style="cursor:pointer;" class="form-radio-label" for="toffle_palito_radio">Palito</label>
    </div>    
</div>