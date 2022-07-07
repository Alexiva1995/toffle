var profit_by_category_route = $('#profit_by_category_route').val();
var parametros = { 
  "week" : $('#weekCategory').data('week-category')
}
//Variable global para el grafico
 var donutChart;
 //Llamado a Ajax y primer renderizado
$.ajax({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
  type: "POST",
  data:  parametros,
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
          type: 'donut',
        },
        colors:['#573666', '#CB231A', '#277256', '#1b6c98', '#e1aa05', '#00cfe8', '#f37705', '#27fe56', '#ff978b', '#0832bc', '#7e9ee5', '#ff3708', '#f70094','#7a7672'],
        legend: {
          show: true,
          position: 'bottom'
        },
        labels: labels,
        series: data_gain,
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return parseInt(val) + '%';
          }
        },
        plotOptions: {
          pie: {
            donut: {
              colors:['#573666', '#CB231A', '#277256', '#1b6c98', '#e1aa05', '#00cfe8', '#f37705', '#27fe56', '#ff978b', '#0832bc', '#7e9ee5', '#ff3708', '#f70094','#7a7672'],
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
              },
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
        donutChart = new ApexCharts(donutChartEl, donutChartConfig);
        donutChart.render();
      }
  },
  error: function(xhr) {
      // console.log(xhr.responseJSON);
  }
});
//Funcion actualizar DonutChart
function dataChartCategorySales(){
  parametros = { 
    "week" : $('#weekCategory').data('week-category')
  }
  
  // console.log(parametros)
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    type: "POST",
    data:  parametros,
    url: profit_by_category_route,
    success: function (response) {
        var orders = response.orders;
        var labels = orders.map(function (e) {
            if (e.category_name != null) {
              return e.category_name;
            }
            
        });
    
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

        donutChart.updateOptions({
          labels: labels
        })
        donutChart.updateSeries(removeData());
        
        donutChart.updateSeries(data_gain);
        //mostrar labels existentens en el donutchart
        // console.log(donutChart.w.globals.labels)
  
    },
    error: function(xhr) {
        // console.log(xhr.responseJSON);
    }
  });

}

function random() {
  return Math.floor(Math.random() * (100 - 1 + 1)) + 1;
}

function removeData() {
  var arr = donutChart.w.globals.series.map(() => {
    return random()
  });
  arr = [];
  return arr;
}

