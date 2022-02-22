<div class="modal-header">
    <h4>Agregar Pedido</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <section class="horizontal-wizard">
        <div class="breadcrumb-wrapper mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard-employee') }}">
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    Agregar Pedido
                </li>
            </ol>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="bs-stepper horizontal-wizard-example" style="box-shadow:none">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step active" data-target="#general-data" role="tab" id="general-data-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">1</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Agregar Pedido</span>
                                    <span class="bs-stepper-subtitle">Se agregara el pedido con  los datos generales</span>
                                </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#add-dishes" role="tab" id="add-dishes-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Platos</span>
                                    <span class="bs-stepper-subtitle">Agregar platos de la órden y modificar sus ingredientes</span>
                                </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div id="general-data" class="content active" role="tabpanel" aria-labelledby="general-data-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Agregar Pedido</h5>
                                <small class="text-muted">Se agregaran los datos generales.</small>
                            </div>
        
                            <form class="form form-vertical">
                                @csrf
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 col-md-5 mb-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="customer_name">Nombre del Cliente</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i data-feather="user"></i></span>
                                                <input type="text" id="customer_name" class="form-control requerid @error('customer_name') is-invalid @enderror" name="customer_name"
                                                placeholder="Nombre"/>
                                                @error('customer_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5 mb-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="table">Mesa</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i data-feather="tag"></i></span>
                                                <input type="number" id="table" class="form-control requerid @error('table') is-invalid @enderror" name="table"
                                                placeholder="Mesa"/>
                                                @error('table')
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
        </div>
    </section>
</div>
<div class="modal-footer">
    <a class="btn btn-primary" id="add_order">
        <span class="loading_add_order mr-2"></span> Añadir
    </a>
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
</div>