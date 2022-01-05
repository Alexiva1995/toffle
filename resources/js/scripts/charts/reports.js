/*=========================================================================================
    File Name: chart-apex.js
    Description: Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
    'use strict';
  
    var flatPicker = $('.flat-picker'),
      isRtl = $('html').attr('data-textdirection') === 'rtl',
      chartColors = {
        column: {
          series1: '#826af9',
          series2: '#d2b0ff',
          bg: '#f8d3ff'
        },
        success: {
          shade_100: '#7eefc7',
          shade_200: '#06774f'
        },
        donut: {
          series1: '#ffe700',
          series2: '#00d4bd',
          series3: '#826bf8',
          series4: '#2b9bf4',
          series5: '#FFA1A1'
        },
        area: {
          series3: '#a4f8cd',
          series2: '#60f2ca',
          series1: '#2bdac7'
        }
      };
  
    // heat chart data generator
    function generateDataHeat(count, yrange) {
      var i = 0;
      var series = [];
      while (i < count) {
        var x = 'w' + (i + 1).toString();
        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
  
        series.push({
          x: x,
          y: y
        });
        i++;
      }
      return series;
    }
  
    // Area Chart
    // --------------------------------------------------------------------
    var areaChartEl = document.querySelector('#line-area-chart'),
      areaChartConfig = {
        chart: {
          height: 400,
          type: 'area',
          parentHeightOffset: 0,
          toolbar: {
            show: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: false,
          curve: 'straight'
        },
        legend: {
          show: true,
          position: 'top',
          horizontalAlign: 'start'
        },
        grid: {
          xaxis: {
            lines: {
              show: true
            }
          }
        },
        colors: [chartColors.area.series3, chartColors.area.series2, chartColors.area.series1],
        series: [
          {
            name: 'Visits',
            data: [100, 120, 90, 170, 130, 160, 140, 240, 220, 180, 270, 280, 375]
          },
          {
            name: 'Clicks',
            data: [60, 80, 70, 110, 80, 100, 90, 180, 160, 140, 200, 220, 275]
          },
          {
            name: 'Sales',
            data: [20, 40, 30, 70, 40, 60, 50, 140, 120, 100, 140, 180, 220]
          }
        ],
        xaxis: {
          categories: [
            '7/12',
            '8/12',
            '9/12',
            '10/12',
            '11/12',
            '12/12',
            '13/12',
            '14/12',
            '15/12',
            '16/12',
            '17/12',
            '18/12',
            '19/12',
            '20/12'
          ]
        },
        fill: {
          opacity: 1,
          type: 'solid'
        },
        tooltip: {
          shared: false
        },
        yaxis: {
          opposite: isRtl
        }
      };
    if (typeof areaChartEl !== undefined && areaChartEl !== null) {
      var areaChart = new ApexCharts(areaChartEl, areaChartConfig);
      areaChart.render();
    }

  });
  