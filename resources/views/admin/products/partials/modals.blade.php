<!-- Modal Add Product -->
<div
  class="modal fade text-start"
  id="modal_add_product"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Añadir Producto</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('admin.products.create')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="add_product">
                <span class="loading_btn_p mr-2"></span> Añadir
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>


<!-- Modal Edit Product -->
<div
  class="modal fade text-start"
  id="modal_edit_product"
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
          @include('admin.products.edit')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_product">
                <span class="loading_edit_p mr-2"></span> Editar
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>