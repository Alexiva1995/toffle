<script>
    var translate_es = $('#translate').data('es');

    var initial_date;
    var final_date;
    var min_date;
    var max_date;
    var date_filter;

    function dateFilter(date = null) {
        var date_now = new Date();
        var formatted_date = moment(date_now).format('YYYY-MM-DD');
        date_filter = date;
        // console.log(date);

        switch (date) {
          case '1day':
            var date1Day = moment(date_now).subtract(1, 'days').format('YYYY-MM-DD');
            initial_date = date1Day+' 00:00:00';
            final_date = formatted_date+' 23:59:59';
            min_date = date1Day;
            max_date = formatted_date;
            break;
          case '7day':
            var date7Days = moment(date_now).subtract(7, 'days').format('YYYY-MM-DD');
            initial_date = date7Days+' 00:00:00';
            final_date = formatted_date+' 23:59:59';
            min_date = date7Days;
            max_date = formatted_date;
            break;
          case '1month':
            var date1Month = moment(date_now).subtract(1, 'months').format('YYYY-MM-DD');
            initial_date = date1Month+' 00:00:00';
            final_date = formatted_date+' 23:59:59';
            min_date = date1Month;
            max_date = formatted_date;
            break;
          case '6month':
            var date6Month = moment(date_now).subtract(6, 'months').format('YYYY-MM-DD');
            initial_date = date6Month+' 00:00:00';
            final_date = formatted_date+' 23:59:59';
            min_date = date6Month;
            max_date = formatted_date;
            break;
          case '1year':
            var date1Year = moment(date_now).subtract(1, 'years').format('YYYY-MM-DD');
            initial_date = date1Year+' 00:00:00';
            final_date = formatted_date+' 23:59:59';
            min_date = date1Year;
            max_date = formatted_date;
            break;
          case 'ytd':
            var dateYTD = moment().startOf('year').format('YYYY-MM-DD');
            initial_date = dateYTD+' 00:00:00';
            final_date = formatted_date+' 23:59:59';
            min_date = dateYTD;
            max_date = formatted_date;
            break;
          default:
            break;
        }

        return [initial_date, final_date, min_date, max_date]
    }

    var lineChartEl = document.querySelector('#line-chart'),
    lineChartConfig = {
      series: [],
      colors: [window.colors.solid.warning, window.colors.solid.success],
      chart: {
        id: 'chart1',
        height: 400,
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
        text: 'No hay Data'
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

    var lineChart = new ApexCharts(lineChartEl, lineChartConfig);
    lineChart.render();

    console.log(initial_date);
    console.log(min_date);
    console.log(max_date);
    var optionsLine = {
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

    var chartLine = new ApexCharts(document.querySelector("#line-chart-2"), optionsLine);
    chartLine.render();

    function dataChartAmountVsGain(date = null) {
        $.ajax({
            type: "POST",
            url: "{{ route('data.chart.amount.vs.gain') }}",
            success: function (response) {
                // console.log(response);
                var labels = response.data.map(function (e) {
                    return e.date;
                })
                console.log(labels);
    
                var sale_amount = response.data.map(function (e) {
                    return e.total_amount
                })
                console.log(sale_amount);

                var gain = response.data.map(function (e) {
                    return e.gain
                })

                console.log(gain);
    
                lineChart.updateSeries([
                  {
                    name: "Monto de Venta",
                    data: sale_amount
                  },
                  {
                    name: 'Ganancia Real',
                    data: gain
                  }
                ])

                lineChart.updateOptions({
                  xaxis: {
                    categories: labels
                  }
                })

                chartLine.updateSeries([
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
                  min_date = new Date(labels[0]).getTime();
                  max_date = new Date(labels[labels.length - 1]).getTime();
                }else{
                  min_date = new Date(initial_date).getTime();
                  max_date = new Date(final_date).getTime();
                }

                chartLine.updateOptions({
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
                  chartLine.zoomX(
                    new Date(initial_date).getTime(),
                    new Date(final_date).getTime()
                  )
                }
                setTimeout(() => {
                  $('#spiner-chart').addClass('d-none');
                  $('#line-chart').removeClass('d-none');
                  $('#line-chart-2').removeClass('d-none');                         
                },1000)

            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }
</script>