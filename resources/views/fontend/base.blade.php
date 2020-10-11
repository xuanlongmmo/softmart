<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
        //lay ra path tren url
        $path = Request::path();
        //cat chuoi theo ki tu '/'
        $arr = explode('/',$path);
        //lay ra so phan tu cua mang de tim ra chi so cua phan tu cuoi cung
        $lastIndex = sizeOf($arr);
    ?>
    @if (Request::path()=='/')
        <title>Home</title>
    @else
        {{-- title se duoc viet hoa chu cai dau --}}
        <title>{{ucwords($arr[$lastIndex-1])}}</title>
    @endif
    <base href="{{asset('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('fontend.layout.css')
    @yield('css')
    
</head>

<body>
    @include('fontend.layout.header')
    @yield('content')
    @include('fontend.layout.footer')
    @include('fontend.layout.js')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        function search(e){
            var q = e.value;
            if(q == ''){
                document.getElementById("resultsearch").style.display = "none";
            }else{
                document.getElementById("resultsearch").style.display = "block";
                $.ajax({
                url: "{{route('search2')}}",
                method:'GET',
                data:{
                    q:q
                },
                success: function(data){
                    document.getElementById('resultsearch').innerHTML = '';
                    data.forEach(myFunction);
                    function myFunction(item, index) {
                        document.getElementById("resultsearch").innerHTML += "<center><a href='{{ URL::to('ctsp') }}?id=" + item['id'] + "'>" + item['product_name'] + "</a></center><br>"; 
                    }
                },
                error: function(error){

                }
            }
            );
            }
        }
    </script>
    @yield('js')
</body>
</html>