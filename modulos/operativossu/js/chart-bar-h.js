
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

var ctx = document.getElementById("BarChartTerritorio");
var BarChartTerritorio = new Chart(ctx, {
  type: 'horizontalBar',
  data: {
    labels: territorionombre,
    idterritorio: territorioid,
    datasets: [{
      backgroundColor: [//Color de relleno de cada barra respectivamente
        'rgba(163, 163, 163, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)'
    ],
      // backgroundColor: "rgba(163, 163, 163, 0.2)",
      hoverBackgroundColor: "rgba(0,94,162,0.3)",
      borderWidth: 2,
      borderColor: [ //Color del borde de cada barra
        'rgba(163, 163, 163, 1)',
        'rgba(255,99,132,1)',
        'rgba(255, 206, 86, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)'
    ],
     // borderColor: "rgba(163, 163, 163, 1)",
      data: territoriocant,
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        type: 'logarithmic',
        gridLines: {
          color: "rgb(234, 236, 250)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
          
        },
        ticks: {
          min: 0,
          maxTicksLimit: Math.max.apply(null,territoriocant),
          callback: function (value) {
            return value;
        }
        },
        
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: territoriocant.length      
        },
        gridLines: {
          display: false,
          drawBorder: false, 
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      displayColors: false
    },
    animation: {
        duration: 1,
        onComplete: function() {
            var chartInstance = this.chart,
                ctx = chartInstance.ctx;
            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
            ctx.textAlign = 'left';
            ctx.textBaseline = 'middle';

            this.data.datasets.forEach(function (dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i);
                meta.data.forEach(function (bar, index) {
                    var data = dataset.data[index];                            
                    ctx.fillText(data, bar._model.x + 5, bar._model.y);
                });
            });
        }
    }
  }
});
document.getElementById("BarChartTerritorio").onclick = function(evt){
  var activePoints = BarChartTerritorio.getElementsAtEvent(evt);
  var firstPoint = activePoints[0];
  var id = BarChartTerritorio.data.idterritorio[firstPoint._index];
  var value = BarChartTerritorio.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
  if (firstPoint !== undefined)
  var anio = $('#tAnio').val();
	var mes = $('#tMes').val();
	var subir = $('#subir').val();

	$('#forma').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
	$('#forma').load( 'modulos/operativossu/aplicacion.php?id='+id+'&mes='+mes+'&anio='+anio+'&subir='+subir);
};
