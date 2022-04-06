var profit_by_category_route = $('#profit_by_category_route').val();

$.ajax({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
  type: "POST",
  url: profit_by_category_route,
  success: function (response) {

      var orders = response.orders;

      var labels = orders.map(function (e) {
          if (e.category_name != null) {
            return e.category_name;
          }
      })

      var data_gain = orders.map(function (e) {
          if (e.gain != null) {
            return Number(e.gain.toFixed(2));
          }
      });

      var labels = labels.filter(element => {
        return element !== undefined;
      });

      var data_gain = data_gain.filter(element => {
        return element !== undefined;
      });

      var donutChartEl = document.querySelector('#donut-chart-profit-by-category'),
      donutChartConfig = {
        chart: {
          height: 450,
          type: 'donut'
        },
        legend: {
          show: true,
          position: 'bottom'
        },
        labels: labels,
        series: data_gain,
        dataLabels: {
          enabled: true,
          formatter: function (val, opt) {
            return parseInt(val) + '%';
          }
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                name: {
                  fontSize: '2rem',
                  fontFamily: 'Montserrat',
                },
                value: {
                  fontSize: '1rem',
                  fontFamily: 'Montserrat',
                  formatter: function (val) {
                    var gain = parseFloat(val).toFixed(2);
                    return new Intl.NumberFormat().format(gain);
                  }
                },
                total: {
                  show: true,
                  fontSize: '1.5rem',
                  label: 'Ganancia por',
                  formatter: function (w) {
                    return 'Categorías';
                  }
                }
              }
            }
          }
        },
        responsive: [
          {
            breakpoint: 992,
            options: {
              chart: {
                height: 380
              }
            }
          },
          {
            breakpoint: 576,
            options: {
              chart: {
                height: 320
              },
              plotOptions: {
                pie: {
                  donut: {
                    labels: {
                      show: true,
                      name: {
                        fontSize: '1.5rem'
                      },
                      value: {
                        fontSize: '1rem'
                      },
                      total: {
                        fontSize: '1.5rem'
                      }
                    }
                  }
                }
              }
            }
          }
        ]
      };
      if (typeof donutChartEl !== undefined && donutChartEl !== null) {
        var donutChart = new ApexCharts(donutChartEl, donutChartConfig);
        donutChart.render();
      }
  },
  error: function(xhr) {
      console.log(xhr.responseJSON);
  }
});

