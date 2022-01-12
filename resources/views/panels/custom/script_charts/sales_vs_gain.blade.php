<script>

    var lineChartEl = document.querySelector('#line-chart'),
    lineChartConfig = {
      series: [],
      colors: [window.colors.solid.warning, window.colors.solid.success],
      chart: {
        height: 400,
        type: 'area',
        dropShadow: {
          enabled: true,
          color: '#000',
          top: 18,
          left: 7,
          blur: 10,
          opacity: 0.2
        },
        zoom: {
          enabled: true
          // autoScaleYaxis: true
        },
        // locales: [],
        // defaultLocale: "es"
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
          return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
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
      },
    };

    var lineChart = new ApexCharts(lineChartEl, lineChartConfig);
    lineChart.render();

    function dataChartAmountVsGain() {
        $.ajax({
            type: "POST",
            url: "{{ route('data.chart.amount.vs.gain') }}",
            success: function (response) {
                console.log(response);
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

                lineChart.localization.w.globals.locale: {
                  
                }

                lineChart.updateOptions({
                  locales: [response.es],
                  defaultLocale: "es",
                  xaxis: {
                    // type: 'datetime',
                    categories: labels
                  }
                })
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }
</script>