<div class="row justify-content-center">
    <div class="col-12">
        <div class="card m-0">
            <div class="card-header">
                <h4 class="card-title">Datos Requeridos</h4>
            </div>
            <div class="card-body p-0 px-2">
                @if(auth()->user()->role == 1)
                    <form class="form form-vertical" action="{{ route('add.product.to.inventory') }}"
                        id="form_add_inventory" method="POST">
                @else
                    <form class="form form-vertical" action="{{ route('add.product.to.inventory.employee') }}"
                        id="form_add_inventory" method="POST">
                @endif
                    @csrf
                    <div class="row justify-content-center">

                        @include('admin.inventory.components.create-form.select_product')

                        @include('admin.inventory.components.create-form.select_flavor')

                        {{-- <div class="col-12 col-md-6 mb-1">
                            <div class="mb-1">
                                <label class="form-label" for="qty_package">Cantidad de Bultos</label>
                                <div class="input-group input-group-merge ">
                                    <span class="input-group-text"><i data-feather="archive"></i></span>
                                    <input type="number" id="create_qty_package"
                                        class="form-control @error('qty_package') is-invalid @enderror"
                                        name="qty_package" placeholder="Cantidad" />
                                    @error('qty_package')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                        @include('admin.inventory.components.create-form.input_units')

                        @include('admin.inventory.components.create-form.inputs_radio')

                        @include('admin.inventory.components.create-form.input_price')

                        @include('admin.inventory.components.create-form.checkbox_iva')
                        <input type="hidden" id="unit_cost" name="unit_cost" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>