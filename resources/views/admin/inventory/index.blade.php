@extends('layouts/contentLayoutMaster')

@section('title', 'Inventario')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('page-style')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <section id="nav-tabs-aligned">
        <div class="row match-height">
          <!-- Centered Aligned Tabs starts -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a
                      class="nav-link {{ Session::has('products') == true ? '' : 'active' }}"
                      id="inventories-tab-center"
                      data-bs-toggle="tab"
                      href="#inventories-center"
                      aria-controls="inventories-center"
                      role="tab"
                      aria-selected="false"
                      >Inventario</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link {{ Session::has('products') == true ? 'active' : '' }}"
                      id="products-tab-center"
                      data-bs-toggle="tab"
                      href="#products-center"
                      aria-controls="products-center"
                      role="tab"
                      aria-selected="false"
                      >Productos</a
                    >
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane {{ Session::has('products') == true ? '' : 'active' }}" id="inventories-center" aria-labelledby="inventories-tab-center" role="tabpanel">
                    @include('admin.inventory.list')
                  </div>
                  <div class="tab-pane {{ Session::has('products') == true ? 'active' : '' }}" id="products-center" aria-labelledby="products-tab-center" role="tabpanel">
                    @include('admin.products.list')
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</section>
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
      // Inventory
      submitForms('#add_inventory', '.loading_inv', '#form_add_inventory');
      submitForms('#aggregate_product', '.loading_aggr_p', '#form_aggregate_product');
      submitForms('#edit_inventory', '.loading_edit_inv', '#form_edit_inventory');

      // Sum an Subtract
      submitForms('#btn_operation', '.loading_op', '#form_operation');

      // Product
      submitForms('#add_product', '.loading_btn_p', '#form_add_product');
      submitForms('#edit_product', '.loading_edit_p', '#form_edit_product');

      function editProduct(id, name, mark, gr, alert) {
        var route = '{{route('products.update', 'replace_this')}}'.replace('replace_this', id);
        $('#form_edit_product').attr('action', route);
        $('#edit_mark').val(mark);
        $('#edit_name').val(name);
        $('#edit_gr').val(gr);
        $("#edit_units_reposition_alert").val(alert);
        
        $('#modal_edit_product').modal('show');
      }

      function editInventory(id, product_id, qty_package, unit_package, price) {

          var route = '{{route('inventory.update', 'replace_this')}}'.replace('replace_this', id);
          $('#form_edit_inventory').attr('action', route);
          $("#edit_product_id option[value="+ product_id +"]").attr("selected", 'selected').trigger('change');
          $('#edit_qty_package').val(qty_package);
          $('#edit_unit_package').val(unit_package);
          $('#edit_price').val(price);
          $('#modal_edit_inventory').modal('show');

      }

      function operation(department, operator, id, max_value = 0) {
          var title = '';
          var btn_text = '';

          var route = "{{ route('operation.inventory', 'id') }}";
          route = route.replace('id', id);
          $('#form_operation').attr('action', route);

          if (operator == 'subtract') {
            btn_text = "Restar" ;
          }

          if (operator == 'sum') {
            btn_text = "Sumar" ;
          }

          switch (department) {
            case 'deposit':
              title = btn_text+" Depósito" ;
              break;
            case 'local':
              title = btn_text+" Local" ;
              break;
            case 'public':
              title = btn_text+" Público" ;
              break;
          
            default:
              break;
          }       

          $('#modal_title').text(title);
          $('#btn_text').text(btn_text);
          $('#department').val(department); 
          $('#operation').val(operator);   
          $('#qty').val('');
          $('#max_value').val(max_value);   
          $("#modal_operation").modal("show");
      }

      $(document).ready(function() {
        
          dataTable('#table');
          dataTable('#product_table');

          $('#btn_max').click( function() {
              $('#qty').val( $('#max_value').val() );
              toastr['success']('', 'Cantidad Máxima Agregada', {
                  closeButton: true,
                  tapToDismiss: false,
              });
          });
      });
    </script>
@endsection