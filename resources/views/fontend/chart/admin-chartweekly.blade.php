@extends('fontend.layout.admin')
@section('content')
<div class="span9">
    {{-- nhung the nay chi de DOM lay gia tri cho js ve bieu do, khong hien thi len trang --}}
    {{-- tong doanh thu trong tuan --}}
    <input readonly style="display: none" id="totalrevenuethisweek" type="text" value="{{$total}}">
    {{-- cac thu trong tuan --}}
    <input readonly style="display: none" id="revenue1" type="text" value="{{$revenue[0]}}">
    <input readonly style="display: none" id="revenue2" type="text" value="{{$revenue[1]}}">
    <input readonly style="display: none" id="revenue3" type="text" value="{{$revenue[2]}}">
    <input readonly style="display: none" id="revenue4" type="text" value="{{$revenue[3]}}">
    <input readonly style="display: none" id="revenue5" type="text" value="{{$revenue[4]}}">
    <input readonly style="display: none" id="revenue6" type="text" value="{{$revenue[5]}}">
    <input readonly style="display: none" id="revenue7" type="text" value="{{$revenue[6]}}">

    {{-- het --}}

    <div class="content">
        <!--/.module-->
        <figure class="highcharts-figure">
        <div id="chart"></div>
        <p class="highcharts-description">
            This chart shows how data labels can be added to the data series. This
            can increase readability and comprehension for small datasets.
        </p>
        </figure>
    </div>
    <!--/.content-->
</div>
<!--/.span9-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="text/javascript">
    var revenue1 = document.getElementById("revenue1").value/1000000;
    var revenue2 = document.getElementById("revenue2").value/1000000;
    var revenue3 = document.getElementById("revenue3").value/1000000;
    var revenue4 = document.getElementById("revenue4").value/1000000;
    var revenue5 = document.getElementById("revenue5").value/1000000;
    var revenue6 = document.getElementById("revenue6").value/1000000;
    var revenue7 = document.getElementById("revenue7").value/1000000;

    var totalRevenueThisWeek = document.getElementById("totalrevenuethisweek").value;
    totalRevenueThisWeek = totalRevenueThisWeek.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    
    Highcharts.chart('chart', {
    chart: {
        type: 'cylinder',
        options3d: {
        enabled: true,
        alpha: 15,
        beta: 15,
        depth: 50,
        viewDistance: 25
        },
    },
    xAxis: {
            categories: ['Monday', 'Tuesday', 'Wesnesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
        },
    yAxis: {
        title: {
            text: 'Revenue (million vnd)'
        }
    },
    title: {
        text: 'Revenue of this Week: ' + totalRevenueThisWeek + 'đ'
    },
    plotOptions: {
        series: {
        depth: 25,
        colorByPoint: true
        }
    },
    series: [{
        data: [revenue1, revenue2, revenue3, revenue4, revenue5, revenue6, revenue7],
        name: ['Monday','Tuesday','Wesnesday','Thursday','Friday','Saturday','Sunday'],
        showInLegend: false
    }]
    });
</script>
@endsection
