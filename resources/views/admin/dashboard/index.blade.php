
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  @include('panels.datatable.styles')
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
@endsection

@section('content')
<section id="dashboard-ecommerce">
  <div class="row match-height">

    {{-- <div class="col-12">
      @include('admin.dashboard.reports.sales_vs_gain')
    </div> --}}

    <div class="col-12 col-md-6">
      @include('admin.dashboard.money_flow.list')
    </div>

    <div class="col-12 col-md-6">
      @include('admin.dashboard.inventory_reposition.list')
    </div>

    <div class="col-12">
      @include('admin.dashboard.dishes_under_review.list')
    </div>

    <div class="col-12 col-md-4">
      @include('admin.dashboard.reports.profit_by_category')
    </div>

    <div class="col-12 col-md-8">
      @include('admin.dashboard.reports.weekly_sales')
    </div>
  </div>

</section>
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/moment/moment.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/extensions/dist/plugins/weekSelect/weekSelect.js')) }}"></script>
  <script src="{{ asset('js/scripts/charts/dashboard/weekly_sales.js') }}"></script>
  <script src="{{ asset('js/scripts/charts/dashboard/profit_by_category.js') }}"></script>
  {{-- <script src="{{ asset('js/scripts/charts/dashboard/amount-vs-gain.js') }}"></script> --}}
@endsection

@section('custom-js')
  @include('panels.datatable.scripts')
  <script>
      dataTable('#money_flow_table');
      dataTable('#inventory_reposition_table');
      dataTable('#dishes_under_review_table');
      dataTable('#table');


      $(document).ready(function () {
        
          // Amount Vs Gain
          // --------------------------------------------------------------------
          // dateFilter('1day');
          // dataChartAmountVsGain();
          // flatpickrDateCalendar(initial_date, final_date)

          // $('.datetime').click(function() {

          //   $('#label-date-calendar').css("background-color", "transparent");
          //   $('#spiner-chart').removeClass('d-none');

          //   value = $(this).val();
          //   dateFilter(value);
          //   dataChartAmountVsGain();
          //   flatpickrDateCalendar(initial_date, final_date)

          //   setTimeout(() => {
          //       $('#spiner-chart').addClass('d-none');                     
          //   },1500)
          // });

          // Weekly Sales
          // --------------------------------------------------------------------
          dataChartWeeklySales();

          $('#week').change(function() {
            dataChartWeeklySales();
          });

          flatpickrWeek('#week');

      });

  </script>  
@endsection
