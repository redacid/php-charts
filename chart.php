<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/dtd/xhtml11.dtd">
<html>
<head>
<title>Chart</title>
<?php
echo "<meta http-equiv=\"refresh\" content=\"300\" />";
?>
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<meta name="author" content="(C)Redacid 2017 for GIVC UZ" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel=stylesheet href=css/style.css type=text/css media=screen>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>

<?php
//https://www.highcharts.com/samples/data/jsonp.php?filename=usdeur.json&callback=
//http://192.168.14.100/monitorfs/images/readfile.php?callback=qwerty

#$datasource="http://192.168.14.100/monitorfs/readfile.php";
$datasource="http://192.168.14.100/monitorfs/get-chart-data.php";
$spravka=$_GET['spravka'];
$period=$_GET['period'];
$from=$_GET['from'];
$to=$_GET['to'];

?>


<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/datepicker-ru.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
  $( function() {
    var dateFormat = "yy-mm-dd",
      from = $( "#from" )
        .datepicker(
	{
          defaultDate: "-1m",
          changeMonth: true,
          numberOfMonths: 3
        })
        .on( "change", function() { 
          to.datepicker( "option", "minDate", getDate( this ) );
	  to.datepicker( "option", "dateFormat", dateFormat );
        }),
      to = $( "#to" ).datepicker({
	defaultDate: "-1m",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
	from.datepicker( "option", "dateFormat", dateFormat );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
</script>

<div id="menu" style="min-width: 310px; height: 80px; margin: 0 auto">
<a class="menulink" href='/monitorfs/chart.php?spravka=<?php echo $spravka?>&period=1d'>1 День</a>
<a class="menulink" href='/monitorfs/chart.php?spravka=<?php echo $spravka?>&period=2d'>2 Дня</a>
<a class="menulink" href='/monitorfs/chart.php?spravka=<?php echo $spravka?>&period=1w'>1 Неделя</a>
<a class="menulink" href='/monitorfs/chart.php?spravka=<?php echo $spravka?>&period=1m'>1 Месяц</a>
<a class="menulink" href='/monitorfs/chart.php?spravka=<?php echo $spravka?>&period=1y'>1 Год</a>
<p><form action="" method=GET=>
<label for="from"> С </label>
<input type="text" id="from" name="from">
<label for="to"> По </label>
<input type="text" id="to" name="to">
<input name="spravka" type=hidden value=<?php echo $spravka?> >
<input type=submit value=Показать ></form>
</p>
</div>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">//<![CDATA[

$(function () {
    var seriesOptions = [],
        seriesCounter = 0,
        names = ['Timeout', 'Count'];

    /**
     * Create the chart when all data is loaded
     * @returns {undefined}
     */
    function createChart() {
		Highcharts.setOptions({
			lang: {
			contextButtonTitle: "Контекстное меню",
			decimalPoint: ".",
			downloadJPEG: "Загрузить JPEG рис.",
			downloadPDF: "Загрузить PDF док.",
			downloadPNG: "Загрузить PNG рис.",
			downloadSVG: "Загрузить SVG векторный рис.",
			drillUpText: "Назад к {series.name}",
			//invalidDate:
			loading: "Загрузка...",
			months: [ "January" , "February" , "March" , "April" , "May" , "June" , "July" , "August" , "September" , "October" , "November" , "December"],
			noData: "No data to display",
			numericSymbolMagnitude: 1000,
			numericSymbols: [ "k" , "M" , "G" , "T" , "P" , "E"],
			printChart: "Print chart",
			resetZoom: "Reset zoom",
			resetZoomTitle: "Reset zoom level 1:1",
			shortMonths: [ "Янв" , "Фев" , "Мар" , "Апр" , "Май" , "Июн" , "Июл" , "Авг" , "Сен" , "Окт" , "Ноя" , "Дек"],
			//shortWeekdays: undefined
			thousandsSep: " ",
			weekdays: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]
			}
		});
        Highcharts.chart('container', {

	<?php 
#		if ($period=="1d") {
			echo "            
			chart: {
                		zoomType: 'x'
            			},
			";
#		}
	?>

            //rangeSelector: {
            //    selected: 4
            //},

            //yAxis: {
            //    labels: {
            //        formatter: function () {
            //            return (this.value > 0 ? ' + ' : '') + this.value + '';
            //        }
            //    },
            //    plotLines: [{
            //        value: 0,
            //        width: 2,
            //        color: 'silver'
            //    }]
            //},

            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Количество запросов\\Таймаут'
                },
		min: 0
            },


            plotOptions: {
                series: {
                    //compare: 'percent',
                    //showInNavigator: true
                },
	        spline: {
        	        marker: {
                	    enabled: true
                	}	
            	},
		line: {
			lineWidth: 1
		}
            },

            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                valueDecimals: 0,
                split: true,
                dateTimeLabelFormats: {
                        millisecond:"%A, %b %e, %H:%M:%S.%L",
                        second:"%A, %b %e, %H:%M:%S",
                        minute:"%A, %b %e, %H:%M",
                        hour:"%A, %b %e, %H:%M",
                        day:"%A, %b %e, %H:%M",
                        week:"%A, %b %e, %H:%M",
                        month:"%A, %b %e, %H:%M",
                        year:"%A, %b %e, %H:%M"
                }
            },
	    title: {
                text: 'Справка <?php echo $spravka ?>'
            },

            series: seriesOptions
        });
    }

    $.each(names, function (i, name) {

        $.getJSON('<?php echo $datasource?>?spravka=<?php echo $spravka ?>&from=<?php echo $from ?>&to=<?php echo $to ?>&period=<?php echo $period ?>&dataline=' + name.toLowerCase() + '&callback=?',    function (data) {

            seriesOptions[i] = {
                name: name,
                data: data
            };

            // As we're loading the data asynchronously, we don't know what order it will arrive. So
            // we keep a counter and create the chart when all the data is loaded.
            seriesCounter += 1;

            if (seriesCounter === names.length) {
                createChart();
            }
        });
    });
});
//]]>
</script>

</body>
</html>

