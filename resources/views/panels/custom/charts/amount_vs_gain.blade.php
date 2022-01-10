<script>
    function dataChartAmountVsGain() {
        $.ajax({
            type: "POST",
            url: "{{ route('data.chart.amount.vs.gain') }}",
            success: function (response) {
                // console.log(response);
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
</script>