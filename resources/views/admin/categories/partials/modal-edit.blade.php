<div class="modal fade text-start" id="modal_edit_category{{$category->id}}" tabindex="-1" aria-labelledby="modal_edit_category{{$category->id}}" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Editar Producto</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-center mt-2">
            <div class="col-12">
                <div class="mb-3">
                    <div class="card-header">
                        <h4 class="card-title">Datos Requeridos</h4>
                    </div>
                    <div class="card-body p-0 px-2">
                        <form class="form form-vertical" id="form_edit_category{{$category->id}}" action="{{route('categories.update', $category)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row justify-content-center align-items-center">
                                <div class="col-12 col-md-6 mb-1">
                                    <div class="mb-1">
                                      <label class="form-label" for="name">Nombre</label>
                                      <input type="hidden" name="id" value="{{$category->id}}">
                                      <div class="input-group input-group-merge ">
                                          <span class="input-group-text"><i data-feather="bookmark"></i></span>
                                          <input type="text" id="edit_name" class="form-control requerid @error('name') is-invalid @enderror" name="name" placeholder="Nombre" value="{{$category->name}}"/>
                                          @error('name')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                      </div>
                                      <br>
                                      <label class="form-label" for="type">Tipo</label>
                                      <select id="type" class="rounded form-control text-dark" name="type" required>
                                          <option disabled selected>Selecciona un tipo</option>
                                          <option value="0" {{$category->type == 0 ? 'selected' : '' }}>Gasto</option>
                                          <option value="1" {{$category->type == 1 ? 'selected' : '' }}>Ingreso</option>
                                      </select>
                                    </div>
                                </div>                   
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="submitEditForm({{$category->id}})" id="edit">
                <span class="loading_edit_c mr-2"></span> Editar
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>