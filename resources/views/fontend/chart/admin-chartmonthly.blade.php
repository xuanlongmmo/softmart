@extends('fontend.layout.admin')
@section('content')
<div class="span9">
    {{-- nhung the nay chi de DOM lay gia tri cho js ve bieu do, khong hien thi len trang --}}
    @for ($i = 1; $i <= sizeOf($revenue); $i++)
        <input readonly style="display: none" id="revenue{{$i}}" type="text" value="{{$revenue[$i]}}">
    @endfor
    <input type="text" readonly style="display: none" id='quantityday' value="{{sizeOf($revenue)}}">
    <input type="text" readonly style="display: none" id='totalrevenue' value="{{$totalRevenue}}">

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
<script src="{{ asset('fontend/assets/js/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ asset('fontend/assets/js/exporting.js') }}" type="text/javascript"></script>
<script src="{{ asset('fontend/assets/js/export-data.js') }}" type="text/javascript"></script>
<script src="{{ asset('fontend/assets/js/accessibility.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    //tong doanh thu trong thang
    var totalRevenueThisMonth = document.getElementById("totalrevenue").value;
    totalRevenueThisMonth = totalRevenueThisMonth.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    var i = 1;
    //lay ra so ngay trong thang
    var quantityDayOfThisMonth = document.getElementById('quantityday').value;
    var revenue = [];
    for(i;i<=quantityDayOfThisMonth;i++){
        var temp = 'revenue' + i;
        revenue[i] = Number(document.getElementById(temp).value/1000000);
    }
    //loai bo phan tu dau tien trong mang
    revenue.shift();

    Highcharts.chart('chart', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Revenue This Month: ' + totalRevenueThisMonth + 'đ'
        },
        subtitle: {
            text: 'Source: SoftMart'
        },
        xAxis: {
            categories: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
        },
        yAxis: {
            title: {
                text: 'Revenue (million vnd)'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'ThisMonth',
            data: revenue
        }]
    });
</script>
@endsection
