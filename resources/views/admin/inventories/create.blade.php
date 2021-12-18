<div class="row justify-content-center">
    <div class="col-12">
        <div class="card m-0">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                <form class="form form-vertical" action="{{ route('store.inventory') }}" id="form_add_inventory" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="name">Nombre</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="database"></i></span>
                                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                        placeholder="Nombre" />
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="total">Cantidad Total</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="total" class="form-control @error('total') is-invalid @enderror" name="total"
                                        placeholder="Cant. Total" />
                                    @error('total')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="deposit">Depósito</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="download"></i></span>
                                    <input type="number" id="deposit" class="form-control @error('deposit') is-invalid @enderror"
                                        name="deposit" placeholder="Depósito" />
                                    @error('deposit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="local">Local</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="inbox"></i></span>
                                    <input type="number" id="local" class="form-control @error('local') is-invalid @enderror" name="local"
                                        placeholder="Local" />
                                    @error('local')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="public">Público</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="briefcase"></i></span>
                                    <input type="number" id="public" class="form-control @error('public') is-invalid @enderror" name="public"
                                        placeholder="Público" />
                                    @error('public')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="cost">Costo</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="credit-card"></i></span>
                                    <input type="number" id="cost" class="form-control @error('cost') is-invalid @enderror"
                                        name="cost" placeholder="Costo" step="0.01"/>
                                    @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
