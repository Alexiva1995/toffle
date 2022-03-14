var translate_es = $('#translate').data('es');

var initial_date;
var final_date;
var date_filter;

function dateFilter(date = null, from = null, to = null) {
    var date_now = new Date();
    var formatted_date = moment(date_now).format('YYYY-MM-DD');
    date_filter = date;

    switch (date) {
      case 'date_calendar':
        initial_date = from+' 00:00:00';
        final_date = to+' 23:59:59';
        break;
      case '1day':
        var date1Day = moment(date_now).subtract(1, 'days').format('YYYY-MM-DD');
        initial_date = date1Day+' 00:00:00';
        final_date = formatted_date+' 23:59:59';
        break;
      case '7day':
        var date7Days = moment(date_now).subtract(7, 'days').format('YYYY-MM-DD');
        initial_date = date7Days+' 00:00:00';
        final_date = formatted_date+' 23:59:59';
        break;
      case '1month':
        var date1Month = moment(date_now).subtract(1, 'months').format('YYYY-MM-DD');
        initial_date = date1Month+' 00:00:00';
        final_date = formatted_date+' 23:59:59';
        break;
      case '6month':
        var date6Month = moment(date_now).subtract(6, 'months').format('YYYY-MM-DD');
        initial_date = date6Month+' 00:00:00';
        final_date = formatted_date+' 23:59:59';
        break;
      case '1year':
        var date1Year = moment(date_now).subtract(1, 'years').format('YYYY-MM-DD');
        initial_date = date1Year+' 00:00:00';
        final_date = formatted_date+' 23:59:59';
        break;
      case 'ytd':
        var dateYTD = moment().startOf('year').format('YYYY-MM-DD');
        initial_date = dateYTD+' 00:00:00';
        final_date = formatted_date+' 23:59:59';
        break;
      default:
        break;
    }

    return [initial_date, final_date]
}

function flatpickrDateCalendar(initial_date, final_date) {
    var flatpickr_translate_es = $('#flatpickr_translate').data('es');
    $('#date_calendar').flatpickr({
        mode:'range',
        ariaDateFormat:'Y-m-d',
        dateFormat:'Y-m-d',
        defaultDate: [initial_date, final_date],
        locale: flatpickr_translate_es,
        onChange:function(selectedDates){
            var _this=this;
            var dateArr=selectedDates.map(function(date){return _this.formatDate(date,'Y-m-d');});
            $('input[type=radio]').prop('checked',false);
            $('#label-date-calendar').css("background-color", "rgba(255, 89, 51, 0.2)");
            $('#spiner-chart').removeClass('d-none');
            if (dateArr[0] != null && dateArr[1] != null) {
              dateFilter('date_calendar', dateArr[0], dateArr[1]);
              dataChartAmountVsGain();
            }
            setTimeout(() => {
                $('#spiner-chart').addClass('d-none');                     
            },1500)
        },
    });
}

var lineTopChartId = document.querySelector('#line-top-chart'),
lineTopChartConfig = {
  series: [],
  colors: [window.colors.solid.warning, window.colors.solid.success],
  chart: {
    id: 'chart1',
    height: 325,
    type: 'line',
    dropShadow: {
      enabled: true,
      color: '#000',
      top: 18,
      left: 7,
      blur: 10,
      opacity: 0.2
    },
    zoom: {
      enabled: true,
      type: "xy",
      autoScaleYaxis: true
    },
    toolbar: {
      autoSelected: 'pan',
      show: true
    },
    locales: [translate_es],
    defaultLocale: "es",
    events: {
      beforeResetZoom: function(chartContext, opts) {
        if (date_filter != 'all') {
          return {
            xaxis: {
              min: new Date(initial_date).getTime(),
              max: new Date(final_date).getTime()
            }
          } 
        }
      }
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth',
  },
  title: {
    text: 'Monto de Ventas vs Ganacia Real',
    align: 'left'
  },
  legend: {
    tooltipHoverFormatter: function(val, opts) {
      return val + ': ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
    }
  },
  markers: {
    size: 0,
    hover: {
      sizeOffset: 6
    }
  },
  noData: {
    text: 'Cargando...'
  },
  xaxis: {
    type: 'datetime',
  },
  tooltip: {
    x: {
      format: 'dd MMMM yyyy - HH:mm:ss'
    },
    y: [
      {
        title: {
          formatter: function (val) {
            return val;
          }
        }
      },
      {
        title: {
          formatter: function (val) {
            return val;
          }
        }
      }
    ]
  },
  grid: {
    borderColor: '#f1f1f1',
  }
};

var lineTopChart = new ApexCharts(lineTopChartId, lineTopChartConfig);
lineTopChart.render();

var lineBottomChartConfig = {
  series: [],
  chart: {
    id: 'chart2',
    height: 130,
    type: 'area',
    brush:{
      target: 'chart1',
      enabled: true
    },
    locales: [translate_es],
    defaultLocale: "es",
  },
  colors: ['#008FFB', '#2f376f'],
  fill: {
    type: 'gradient',
    gradient: {
      opacityFrom: 0.91,
      opacityTo: 0.1,
    }
  },
  legend: {
    show: false,
  },
  xaxis: {
    type: 'datetime',
    tooltip: {
      enabled: false
    }
  },
  yaxis: {
    tickAmount: 2
  }
};

var lineBottomChart = new ApexCharts(document.querySelector("#line-bottom-chart"), lineBottomChartConfig);
lineBottomChart.render();

var amount_vs_gain_route = $('#amount_vs_gain_route').val();

function dataChartAmountVsGain() {

    $.ajax({
        type: "POST",
        url: amount_vs_gain_route,
        success: function (response) {

            var labels = response.data.map(function (e) {
                return e.date;
            })

            var sale_amount = response.data.map(function (e) {
                return e.total_amount
            })

            var gain = response.data.map(function (e) {
                return e.gain
            })

            lineTopChart.updateSeries([
              {
                name: "Monto de Venta",
                data: sale_amount
              },
              {
                name: 'Ganancia Real',
                data: gain
              }
            ])

            lineTopChart.updateOptions({
              xaxis: {
                categories: labels
              }
            })

            lineBottomChart.updateSeries([
                {
                  name: "Monto de Venta",
                  data: sale_amount
                },
                {
                  name: 'Ganancia Real',
                  data: gain
                }
            ])

            var min_date;
            var max_date;

            if (date_filter == 'all') {
              min_date = labels[0];
              max_date = labels[labels.length - 1];
            }else{
              min_date = initial_date
              max_date = final_date;
            }

            lineBottomChart.updateOptions({
              chart: {
                selection: {
                  enabled: true,
                  xaxis: {
                    min: new Date(min_date).getTime(),
                    max: new Date(max_date).getTime()
                  }
                },
              },
              xaxis: {
                categories: labels
              }
            })

            if (date_filter != 'all') {
                lineBottomChart.zoomX(
                    new Date(initial_date).getTime(),
                    new Date(final_date).getTime()
                )
            }

        },
        error: function(xhr) {
            console.log(xhr.responseJSON);
        }
    });

}