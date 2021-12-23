
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
  <div class="row match-height">
    <!-- Medal Card -->
    <div class="col-xl-3 col-md-6 col-12">
      <div class="card card-congratulation-medal">
        <div class="card-body">
          <div class="row">
              <div class="col-auto">
                <h3 class="mb-5"> 
                    <span class="icon-wrapper">
                      <i data-feather="edit"></i>
                    </span> Pedidos
                </h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_order">Agregar Pedido</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Medal Card -->

    {{-- Modals --}}
    @include('employee.dashboard.orders.modals.create')

    {{-- Order-Statistics --}}
    <div class="col-xl-9 col-md-6 col-12">
      @include('employee.dashboard.orders.order_statistics')
    </div>
    {{--/ Order-Statistics --}}
 
    <div class="col-lg-6 col-12">
      @include('employee.dashboard.orders.pending')
    </div>

    <div class="col-lg-6 col-12">
      @include('employee.dashboard.orders.history')
    </div>
  </div>

</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
  <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  {{-- <script src="{{ asset(mix('js/scripts/pages/dashboard-ecommerce.js')) }}"></script> --}}
@endsection

@section('custom-js')

  @include('panels.datatable.scripts')
  <script>
      dataTable('#order_history_table');
      dataTable('#pending_order_table');
  </script>
@endsection
