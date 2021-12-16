@extends('layouts/contentLayoutMaster')

@section('title', 'Inventarios')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
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
                      >Inventarios</a
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
                    @include('admin.inventories.list')
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
      $(document).ready(function() {

          $('#add_product').click( function() {
              var this_button = $(this);
              this_button.attr('disabled', 'disabled').addClass('disabled');
              $('.loading_btn').addClass('spinner-border spinner-border-sm');

              $('#form_add_product').submit();
          });
      });
  </script>
@endsection