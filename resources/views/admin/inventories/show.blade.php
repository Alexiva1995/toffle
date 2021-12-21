@extends('layouts/contentLayoutMaster')

@section('title', 'Detalles del Inventario')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
@endsection

@section('page-style')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
              
                            <li class="breadcrumb-item">
                                <a href="{{ route('index.inventory') }}">
                                    Inventario
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                Detalles del Iventario
                            </li>
                        </ol>
                  </div>
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="row my-3">
                            <div class="col-auto">
                                <h5>Nombre: <span class="h6"> {{ $inventory->name }} </span> </h5> 
                            </div>
                            <div class="col-auto">
                                <h5>Cant. Total: <span class="h6"> {{ $inventory->total }} </span> </h5>
                            </div>
                            <div class="col-auto">
                                <h5>Depósito: <span class="h6"> {{ $inventory->deposit }} </span> </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row justify-content-end">
                            <div class="col-auto mb-2">
                                <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modal_aggregate_product">
                                    <i data-feather="plus"></i> Agregar Productos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th class="text-center">Cant. Bultos</th>
                                <th class="text-center">Unid. Bulto</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Fecha de Creación</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory->products()->get() as $item)
                            <tr>
                                <td>{{ $item->name}}</td>
                                <td class="text-center">{{ $item->pivot->qty_package }}</td>
                                <td class="text-center px-3"> 
                                    {{ $item->pivot->unit_package }}
                                </td>
                                <td class="text-center px-3"> 
                                    {{ $item->pivot->price }}
                                </td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($item->pivot->pricecreated_at)) }}</td>
                                <td class="text-center"> 
                                    <button class="btn btn-sm btn-info" 
                                        onclick="editProductToInventory( 
                                        {{ $item->pivot->inventory_id }},
                                        {{ $item->pivot->id }}, 
                                        {{ $item->pivot->product_id }}, 
                                        {{ $item->pivot->qty_package }},
                                        {{ $item->pivot->unit_package }},
                                        {{ $item->pivot->price }} 
                                    )">
                                        <i data-feather="edit"></i> 
                                    </button> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Add Products to Inventory-->
<div
  class="modal fade text-start"
  id="modal_aggregate_product"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Agregar Productos al Inventario</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('admin.inventories.details.add_products')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="aggregate_product">
                <span class="loading_aggr_p mr-2"></span> Agregar
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

<!-- Modal Edit Products to Inventory-->
<div
  class="modal fade text-start"
  id="modal_edit_product_to_inventory"
  tabindex="-1"
  aria-labelledby="myModalLabel1"
  aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel1">Editar Productos del Inventario</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('admin.inventories.details.edit_products')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_product">
                <span class="loading_edi_p mr-2"></span> Editar
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
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
        // Aggregate Product
        submitForms('#aggregate_product', '.loading_aggr_p', '#form_aggregate_product');
        submitForms('#edit_product', '.loading_edi_p', '#form_edit_product');

        function editProductToInventory(inventory_id, inventory_product_id, product_id, qty_package, unit_package, price) {
            var route = '{{route('update.product.to.inventory', 'replace_this')}}'.replace('replace_this', inventory_id);
            $('#form_edit_product').attr('action', route);
            $("#edit_product_id option[value="+ product_id +"]").attr("selected", 'selected').trigger('change');
            $('#edit_qty_package').val(qty_package);
            $('#edit_unit_package').val(unit_package);
            $('#edit_price').val(price);
            $('#inventory_product_id').val(inventory_product_id);
            $('#modal_edit_product_to_inventory').modal('show');
        }
    </script>


@endsection