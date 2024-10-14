var columnChartWs = document.querySelector('#column-chart-ws'),
columnChartWsConfig = {
  chart: {
    height: 400,
    type: 'bar',
    stacked: true,
    parentHeightOffset: 0,
    toolbar: {
      show: false
    }
  },
  plotOptions: {
    bar: {
      borderRadius: 10,
      columnWidth: '25%',
      distributed: true,
      dataLabels: {
        position: 'top',
      },
    }
  },
  dataLabels: {
    enabled: true,
    offsetY: -20,
    style: {
      fontSize: '12px',
      colors: ["#fff"]
    }
  },
  legend: {
    show: false,
    formatter: function (val, context) {
      console.log(context.w.globals.series[0][context.seriesIndex] );
      return val+': '+context.w.globals.series[0][context.seriesIndex] ;
    },
  },
  stroke: {
    show: true,
    colors: ['transparent']
  },
  grid: {
    xaxis: {
      lines: {
        show: true
      }
    }
  },
  series: [],
  noData: {
    text: 'Cargando...'
  },
  fill: {
    opacity: 1
  },
};

var columnChart = new ApexCharts(columnChartWs, columnChartWsConfig);
columnChart.render();

function dataChartWeeklySales() {
    var parametros = { 
       "week" : $('#week').data('week')
    }

    var weekly_sales_route = $('#weekly_sales_route').val();
    $.ajax({
        type: "POST",
        data:  parametros,
        url: weekly_sales_route,
        success: function (response) {

            var dates = response.dates;

            var labels = dates.map(function (e) {
                return e.date
            })

            var data_amount = dates.map(function (e) {
                return e.total_amount.toFixed(2);
            })

            columnChart.updateSeries([{
              name: 'Monto de Venta',
              data: data_amount
            }])
            columnChart.updateOptions({
              xaxis: {
                categories: labels
              }
            })
        },
        error: function(xhr) {
            console.log(xhr.responseJSON);
        }
    });
}
