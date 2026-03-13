
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
  @include('panels.datatable.styles')
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/charts/chart-apex.css') }}">
@endsection

@section('content')
<section id="dashboard-ecommerce">
  <div class="row match-height">

    {{-- <div class="col-12">
      @include('admin.dashboard.reports.sales_vs_gain')
    </div> --}}
    <div class="col-12 col-md-4">
      @include('admin.dashboard.reports.profit_by_category')
    </div>

    <div class="col-12 col-md-8">
      @include('admin.dashboard.reports.weekly_sales')
    </div>
    <div class="col-12 col-md-6">
      @include('admin.dashboard.money_flow.list')
    </div>

    <div class="col-12 col-md-6">
      @include('admin.dashboard.products_sold.list')
    </div>

    <div class="col-12">
      @include('admin.dashboard.dishes_under_review.list')
    </div>

    
  </div>

</section>
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/moment/moment.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/flatpickr/extensions/dist/plugins/weekSelect/weekSelect.js') }}"></script>
  <script src="{{ asset('js/scripts/charts/dashboard/profit_by_category.js') }}"></script>
  <script src="{{ asset('js/scripts/charts/dashboard/weekly_sales.js') }}"></script>
  {{-- <script src="{{ asset('js/scripts/charts/dashboard/amount-vs-gain.js') }}"></script> --}}
@endsection

@section('custom-js')
  @include('panels.datatable.scripts')
  <script>
      dataTable('#money_flow_table');
      // dataTable('#products_sold_table');
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

          $('#start_date, #end_date').change(function() {
            dataChartWeeklySales();
          });

          //Donuts chart for categories
          dataChartCategorySales();
          
          $('#start_date_cat, #end_date_cat').change( () => {
            dataChartCategorySales();
          });
          
          $('.flatpickr-basic').flatpickr({
              dateFormat: "Y-m-d",
              locale: {
                firstDayOfWeek: 1, // Lunes
                weekdays: {
                  shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                  longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
                }, 
                months: {
                  shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                  longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                },
              }
          });
          

      });

  </script>  

  <script>

    $('#showSoldProducts').click(function () {
        $('#products_sold_table').DataTable({
          "serverSide": true,
          "ajax": '{!! route('show.sold.products') !!}',
          "columns": [
            {data: 'name'},
            {data: 'portions'},
            {data: 'local'},
          ]
        });
    });
  </script>

@endsection
