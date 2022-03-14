<div class="row justify-content-center mt-2">
    <div class="col-12">
        <div class="mb-3">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body">
                <form class="form form-vertical" id="form_edit_expense" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-md-4 mb-2">
                            <div class="mb-1">
                                <label class="form-label" for="amount">Monto</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="briefcase"></i></span>
                                    <input type="number" id="amount" class="form-control @error('amount') is-invalid @enderror"
                                        name="amount" placeholder="Monto" step="0.01"/>
                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 mb-2">
                            <div class="mb-1">
                                <label class="form-label" for="amount">Categoría</label>
                                <select class="select2 form-control" data-toggle="select" name="category_id"
                                    id="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror    
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <h5 class="text-center">Estado</h5>
                            <div class="d-flex justify-content-center @error('status') is-invalid @enderror">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" name="status" id="to_pay" value="0" />
                                  <label class="form-check-label" for="to_pay">Por Pagar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" name="status" id="paid_out" value="1" />
                                  <label class="form-check-label" for="paid_out">Pagado</label>
                                </div>
                            </div>
                            @error('status')
                                <span class="invalid-feedback text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>

                        <div class="col-12 col-md-8 mb-1">
                            <label class="label-required">
                                Descripción
                            </label>
                            <textarea type="text" id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="6" cols="50">  </textarea>
                        </div> 

                        <input type="hidden" id="type" name="type">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







