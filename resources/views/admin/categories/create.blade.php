<div class="row justify-content-center mt-2">
    <div class="col-12">
        <div class="mb-3">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                <form class="form form-vertical" action="{{ route('categories.store') }}" id="form_add_category" method="POST">
                    @csrf
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="name">Nombre</label>
                                <div class="input-group input-group-merge rounded border-primary">
                                    <span class="input-group-text"><i data-feather="bookmark"></i></span>
                                    <input type="text" id="create_name" class="form-control requerid @error('name') is-invalid @enderror" name="name"
                                        placeholder="Nombre"/>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>                   
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







