<!-- Modal Add Product -->
<div
  class="modal fade text-start"
  id="modal_add_category"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Crear Categoría</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('admin.categories.create')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="add_category">
                <span class="loading_btn_c mr-2"></span> Crear
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>


<!-- Modal Edit Product -->
<div
  class="modal fade text-start"
  id="modal_edit_category"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Editar Producto</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @include('admin.categories.edit')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_category">
                <span class="loading_edit_c mr-2"></span> Editar
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>