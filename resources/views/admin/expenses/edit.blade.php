<div class="row justify-content-center mt-2">
    <div class="col-12">
        <div class="mb-3">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                <form class="form form-vertical" id="form_edit_expense" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-md-4 mb-2">
                            <div class="mb-1">
                                <label class="form-label" for="amount">Monto</label>
                                <div class="input-group input-group-merge">
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

                        <div class="col-12 col-md-4 mb-2">
                            <div class="mb-1">
                                <label class="form-label" for="amount">Estado</label>
                                <select class="select2 form-control" data-toggle="select" name="status"
                                    id="status">
                                    <option value="0"> Por Pagar </option>
                                    <option value="1"> Pagado </option>                                 
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror    
                            </div>
                        </div>

                        <div class="col-12 col-md-8 mb-1">
                            <label class="label-required">
                                Descripción
                            </label>
                            <textarea type="text" id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="6" cols="50">  </textarea>
                        </div> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







