<script>
    function dataChartAmountVsGain() {
        $.ajax({
            type: "POST",
            url: "{{ route('data.chart.amount.vs.gain') }}",
            success: function (response) {
                console.log(response);
                var labels = response.data.map(function (e) {
                    return e.date
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
    
                isRtl = $('html').attr('data-textdirection') === 'rtl';

                var lineChartEl = document.querySelector('#line-chart'),
                lineChartConfig = {
                  series: [
                    {
                      name: 'Ganancia Real',
                      data: gain
                    },
                    {
                      name: "Monto de Venta",
                      data: sale_amount
                    }
                  ],
                  colors: [window.colors.solid.success, window.colors.solid.warning],
                  chart: {
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
                      autoScaleYaxis: true
                    },
                    locales: [response.es],
                    defaultLocale: "es"
                  },
                  dataLabels: {
                    enabled: true
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
                  xaxis: {
                    type: 'datetime',
                    categories: labels,
                  },
                  tooltip: {
                    x: {
                      format: 'dd MMMM yyyy'
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