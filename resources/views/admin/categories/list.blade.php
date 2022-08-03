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
                                                <th>Tipo</th>
                                                <th class="text-center">Fecha de Creación</th>
                                                <th class="text-center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->type == 0 ? 'Gasto' : 'Ingreso' }}</td>
                                                <td class="text-center">{{ date('d-m-Y', strtotime($category->created_at)) }}</td>
                                                <td class="text-center"> 
                                                    
                                                        <button class="btn btn-sm btn-info my-1" onclick="showModal({{$category->id}})">
                                                            @include('partials.edit_icon_svg')
                                                        </button> 
                
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="deleteElement( {{ $category->id }}, 
                                                            '#delete_category_', 
                                                            'esta Categoría' )"> 
                                                            @include('partials.trash_icon_svg')
                                                        </button>
                                                        <form id="delete_category_{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')                                      
                                                        </form>
                                                    </td>
                                                </tr>
                                                @include('admin.categories.partials.modal-edit',[
                                                    'category' => $category 
                                                ])
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

      const showModal = id =>  $(`#modal_edit_category${id}`).modal('show');
      const submitEditForm = id => $(`#form_edit_category${id}`).submit();

      dataTable('#table');
      
    </script>
@endsection