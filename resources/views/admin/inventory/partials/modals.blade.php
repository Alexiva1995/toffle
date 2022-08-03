<!-- Modal Add Inventory-->
<div
  class="modal fade text-start"
  id="modal_add_inventory"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Añadir Inventario</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('admin.inventory.create')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="add_inventory">
                <span class="loading_inv mr-2"></span> Añadir
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button> 
        </div>
      </div>
    </div>
</div>

<!-- Modal Edit Inventory with Package-->
<div
  class="modal fade text-start"
  id="modal_edit_inventory"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Editar Inventario</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('admin.inventory.edit')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_inventory">
                <span class="loading_edit_inv mr-2"></span> Actualizar
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

{{-- Modal Edit Inventory --}}

<div class="modal fade text-start"
  id="modal_edit_inventory_2"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Editar Inventario</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('admin.inventory.edit_2')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_inventory_2">
                <span class="loading_edit_inv mr-2"></span> Actualizar
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

{{-- Modal Sum and Subtract Operations --}}
<div
  class="modal fade text-start"
  id="modal_operation"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="modal_title"></h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card m-0">
                          <div class="card-header">
                              {{-- <h4 class="card-title">Datos Requeridos</h4> --}}
                          </div>
                            <div class="card-body p-0 px-2">
                              <form class="form form-vertical" action="{{ route('operation.inventory', 'id') }}" id="form_operation" method="POST">
                                  @csrf
                                  @method('PATCH')
                                  <div class="row justify-content-center">
                                      <div class="col-12 col-md-6 mb-1">
                                          <div class="mb-1">
                                                <label class="form-label" for="qty">Cantidad</label>
                                                <div class="input-group input-group-merge ">
                                                    <input type="number" id="qty" class="form-control form-control-lg @error('qty') is-invalid @enderror" name="qty"
                                                            placeholder="Cant." />
                                                    <span class="input-group-text text-white btn-max" id="btn_max" style="cursor: pointer">
                                                        <i data-feather="plus"></i> MAX
                                                    </span>
                                                    @error('qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                          </div>
                                      </div>

                                        <input type="hidden" name="operation" id="operation" value="">
                                        <input type="hidden" name="department" id="department" value="">
                                        <input type="hidden" id="max_value">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" id="btn_operation">
                    <span class="loading_op mr-2"></span> <span id="btn_text"> </span>
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
