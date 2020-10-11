@extends('fontend.layout.admin')
@section('content')
<div class="span9">
    @foreach ($revenue as $key=>$value)
      <input readonly style="display: none" id="revenue{{$key}}" type="text" value="{{$value}}">
    @endforeach
    @foreach ($arrValues as $key=>$value)
      <input readonly style="display: none" id="lable{{$key}}" type="text" value="{{$value}}">
    @endforeach
    <input readonly style="display: none" id="totalrevenue" type="text" value="{{$totalRevenue}}">
    <input readonly style="display: none" id="hightestkey" type="text" value="{{$hightestKey}}">

    {{-- het --}}

    <div class="content">
        <figure class="highcharts-figure">
            <div id="chart"></div>
            <p class="highcharts-description">
              This pie chart shows how the chart legend can be used to provide
              information about the individual slices.
            </p>
        </figure>
    </div>
    <!--/.content-->
</div>
<!--/.span9-->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
    // Build the chart
  var i = 1;
  //tong doanh thu
  var totalrevenue = document.getElementById('totalrevenue').value;
  var hightestKey = document.getElementById('hightestkey').value;
  hightestKey = Number(hightestKey);
  totalrevenue = Number(totalrevenue);
  var arrRevenue = [];
  var arrValues = [];
  for(i;i<=hightestKey;i++){
    arrRevenue[i] = Number(document.getElementById('revenue'+i).value);
    arrValues[i] = document.getElementById('lable'+i).value;
  }
  arrRevenue.shift();
  arrValues.shift();
  //dinh dang lai arrRevenue theo dang %
  var j = 0;
  //mang mydata de truyen vao cho bieu do
  var mydata = [];
  for(j;j<hightestKey;j++){
    arrRevenue[j] = Number((arrRevenue[j]/totalrevenue)*100);
    mydata.push({							
      name:arrValues[j], 
      y:arrRevenue[j],
	});
  }
  var currentTime = new Date();
  var currentYear = currentTime.getFullYear();
  Highcharts.chart('chart', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Chart of revenue statistics by product category, ' + currentYear
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: false
        },
        showInLegend: true
      }
    },
    series: [{
      name: 'Revenue',
      colorByPoint: true,
      data: mydata
    }]
  });
</script>
@endsection
