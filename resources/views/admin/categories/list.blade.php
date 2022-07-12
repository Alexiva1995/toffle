@extends('layouts/contentLayoutMaster')

@section('title', 'Categorías')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('page-style')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row match-height">
        <!-- Centered Aligned Tabs starts -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-6">
                                        <h3>Lista de Categorías</h1>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row justify-content-end">
                                            <div class="col-auto mb-2">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_category">
                                                    <i data-feather="plus"></i> Añadir Nueva Categoría
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Nombre</th>
                                                <th class="text-center">Fecha de Creación</th>
                                                <th class="text-center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td class="text-center">{{ date('d-m-Y', strtotime($category->created_at)) }}</td>
                                                    <td class="text-center"> 
    
                                                        <button class="btn btn-sm btn-info my-1"
                                                            onclick="editCategory(
                                                            {{ $category->id }}, 
                                                            '{{ $category->name }}')"> 
                                                            <svg  width="14" height="14" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                            </svg> 
                                                        </button> 
                
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="deleteElement( {{ $category->id }}, 
                                                            '#delete_category_', 
                                                            'esta Categoría' )"> 
                                                            <svg  width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                            </svg>
                                                        </button>
                                                        <form id="delete_category_{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')                                      
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>             
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.categories.partials.modals')   

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{asset('js/scripts/components/components-navs.js')}}"></script>
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
    <script>
      // Product
      submitForms('#add_category', '.loading_btn_c', '#form_add_category');
      submitForms('#edit_category', '.loading_edit_c', '#form_edit_category');

      function editCategory(id, name) {
        var route = '{{route('categories.update', 'replace_this')}}'.replace('replace_this', id);
        $('#form_edit_category').attr('action', route);
        $('#edit_name').val(name);
        $('#modal_edit_category').modal('show');
      }

      dataTable('#table');
      
    </script>
@endsection