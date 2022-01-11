
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
@endsection

@section('content')
<section id="dashboard-ecommerce">
  <div class="row match-height">

    <div class="col-12">
      @include('admin.dashboard.reports.sales_vs_gain')
    </div>

    <div class="col-lg-6 col-12">
      @include('admin.dashboard.money_flow.list')
    </div>

    <div class="col-lg-6 col-12">
      @include('admin.dashboard.inventory_reposition.list')
    </div>

    <div class="col-12">
      <div class="card card-congratulation-medal">
        <div class="card-body">
          <div class="row justify-content-center">
              <div class="col-auto">
                <a href="{{ route('inventory.index') }}" class="btn btn-info mx-1">
                  <i data-feather="archive"></i> Añadir al Inventario 
                </a>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary mx-1"> <i data-feather="trending-down"></i> Añadir Gasto</a>
              </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      @include('admin.dashboard.reports.weekly_sales')
    </div>
  </div>

</section>
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/extensions/dist/plugins/weekSelect/weekSelect.js')) }}"></script>
@endsection

@section('custom-js')
  @include('panels.datatable.scripts')
  @include('panels.custom.script_charts.weekly_sales')
  @include('panels.custom.script_charts.sales_vs_gain')
  <script>
      dataTable('#money_flow_table');
      dataTable('#inventory_reposition_table');

      // Amount Vs Gain
      // --------------------------------------------------------------------
      dataChartAmountVsGain();

      // Weekly Sales
      // --------------------------------------------------------------------
      dataChartWeeklySales();
    
      $(document).ready(function () {
          $('#week').change(function() {
            dataChartWeeklySales();
          });
      });

      flatpickrWeek('#week');

  </script>  
@endsection
