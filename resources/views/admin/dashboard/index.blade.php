
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">

@endsection

@section('content')
<section id="dashboard-ecommerce">
  <div class="row match-height">

    <div class="col-12">
      @include('admin.dashboard.reports.sales_vs_profit')
    </div>

    <div class="col-lg-6 col-12">
      @include('admin.dashboard.money_flow.list')
    </div>

    <div class="col-lg-6 col-12">
      @include('admin.dashboard.inventory_reposition.list')
    </div>
  </div>

</section>
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
  {{-- <script src="{{ asset(mix('js/scripts/charts/reports.js')) }}"></script> --}}
@endsection

@section('custom-js')

  @include('panels.datatable.scripts')
  <script>
      dataTable('#money_flow_table');
      dataTable('#inventory_reposition_table');

      function dataChartAmountVsGain() {
        $.ajax({
            type: "POST",
            url: "{{ route('data-chart.amount.vs.gain') }}",
            success: function (response) {
                console.log(response);
                var labels = response.data.map(function (e) {
                    return e.created_at
                })
    
                var data_amount = response.data.map(function (e) {
                    return e.total_amount
                })
    
                isRtl = $('html').attr('data-textdirection') === 'rtl';

                var lineChartEl = document.querySelector('#line-chart'),
                lineChartConfig = {
                  chart: {
                    height: 400,
                    type: 'line',
                    zoom: {
                      zoom: {
                          wheel: {
                            enabled: true,
                          },
                          pinch: {
                            enabled: true
                          },
                          mode: 'xy',
                        }
                    },
                    parentHeightOffset: 0,
                    toolbar: {
                      show: false
                    }
                  },
                  series: [
                    {
                      name: 'Monto de Venta',
                      data: data_amount
                    },
                    {
                      name: 'Ganancia Real',
                      data: [60, 80, 70, 110, 80, 100, 90, 180, 160, 140, 200, 220, 275]
                    },
                  ],
                  markers: {
                    strokeWidth: 7,
                    strokeOpacity: 1,
                    strokeColors: [window.colors.solid.white],
                    colors: [window.colors.solid.warning]
                  },
                  dataLabels: {
                    enabled: false
                  },
                  stroke: {
                    curve: 'straight'
                  },
                  colors: [window.colors.solid.warning, window.colors.solid.success],
                  grid: {
                    xaxis: {
                      lines: {
                        show: true
                      }
                    },
                    padding: {
                      top: -20
                    }
                  },
                  xaxis: {
                      labels: {
                          labels,
                          datetimeFormatter: {
                            year: 'yyyy',
                            month: 'MMM \'yy',
                            day: 'dd MMM',
                            hour: 'HH:mm'
                          },
                          
                      },
                  },
                  tooltip: {
          y: [
            {
              title: {
                formatter: function (val) {
                  return val
                }
              }
            },
            {
              title: {
                formatter: function (val) {
                  return val
                }
              }
            },  
          ]
        },
                  yaxis: {
                    opposite: isRtl
                  }
                };
              if (typeof lineChartEl !== undefined && lineChartEl !== null) {
                var lineChart = new ApexCharts(lineChartEl, lineChartConfig);
                lineChart.render();
              }
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }
    // Line Chart
    // --------------------------------------------------------------------
    dataChartAmountVsGain();
    
  </script>
@endsection
