<div class="row">
    <div class="col-12">
        <div class="card p-2">
            <h3>Egresos</h3>
            <div class="row mb-2">
                <div class="col-12">
                    <div class="row justify-content-init mt-1">
                        <div class="col-12 col-md-4">
                            <label for="expenses_timestamp">Rango de Fecha</label>
                              <input type="text" class="form-control" placeholder="Rango de Fecha" id="expenses_timestamp">
                              <input type="hidden" id="expenses_from">
                              <input type="hidden" id="expenses_to">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="expenses_category_id">Categorías</label>
                            <select class="select2 form-control" name="category_id" id="expenses_category_id" data-toggle="select"
                                class="form-control" id="category">
                                <option value="" selected>Seleccionar Todas</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="expenses_table"> </table>
            </div>
        </div>
    </div>
</div>