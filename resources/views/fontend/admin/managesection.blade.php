@extends('fontend.layout.admin')
@section('content')
<?php
    $checkedit = 0;
    $checkdelete = 0;
    foreach(Auth::user()->permission as $permission){
        if($permission->slug_name == 'sua-danh-muc-dac-biet'){
            $checkedit = 1;
        }
        if($permission->slug_name == 'xoa-danh-muc-dac-biet'){
            $checkdelete = 1;
        }
    }
?>
    <div class="span9">
        <center>
            <b>Manage Section Content</b>
        </center>
        <table>
            <thead>
                <tr>
                    <td>
                        Title
                    </td>
                    <td>
                        Quantity Product
                    </td>
                    <td>
                        Action
                    </td>
                </tr>
            </thead>
            <tbody>
                @if (!empty($sections))
                    @foreach ($sections as $section)
                        <tr>
                            <td >{{$section->title}}</td>
                            <td >{{$section->section_content->count()}}</td>
                            <td >
                                @if ($checkedit  == 1)
                                    <a href="{{ route('editsection', ['id'=>$section->id]) }}"><i style="font-size: 20px" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                @endif
                                @if ($checkdelete == 1)
                                    <i style="font-size: 20px;margin-left: 5px;color: rgb(7, 28, 214)" onclick="var result = confirm('Bạn có thực sự muốn xóa sản phẩm này?')
                                        if(result == true){
                                            window.location.href = '{{URL::to('admin/deletelistsection?id='.$section->id)}}'
                                        }else{		
                                    }"class="fa fa-trash-o" aria-hidden="true">
                                    </i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <button id="addnewsection" data-toggle="modal" data-target="#myModal" style="background-color: white;width: 100%;text-align: center;min-height: 30px;align-content: center;border-radius: 10px">
            <i class="fas fa-plus"></i>
        </button>
        <div id="insideareamodal">
            <!-- Modal -->
            <div style="" class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách sản phẩm</h4>
                    </div>
                    <input style="margin-left:10px" type="text" name="" id="titlenewsection" value="newsection">
                    <button onclick="return addsection(this)" style="margin-bottom:10px">Create and save</button>
                    <div class="modal-body" id="modal-body">
                        <input style="display: none" readonly type="text" name="" id="idnewsection" value="0">
                        @foreach ($listProduct as $item)
                        <div style="display: flex">
                            <input onchange="return changelist(this)" type="checkbox" value="{{$item->id}}" id="{{$item->id}}">
                            &nbsp;
                            <span>{{$item->id}} - </span>
                            &nbsp;
                            <span>{{$item->product_name}}</span>
                        </div>
                    @endforeach
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        function addsection(e){
            title = document.getElementById('titlenewsection').value;
            $.ajax({
                    url:"{{route('addsection')}}",
                    method:'GET',
                    data:{
                        title:title
                    },
                    success: function(data){
                        document.getElementById('idnewsection').value = data;
                    },
                    error: function(error){
                        console.log(error);
                        alert('Something wrong!')
                    }
			    });
        }

        function changelist(e){
            id = e.value;
            idsection = document.getElementById('idnewsection').value;
            if(e.checked){
                $.ajax({
                    url:"{{route('addtosection')}}",
                    method:'GET',
                    data:{
                        id:id,
                        idsection:idsection
                    },
                    success: function(data){
                        $("tbody").find("tr").remove();
					    $("tbody").append(data);
                    },
                    error: function(error){
                        alert('Hãy tạo tên của Section này trước!')
                    }
			    });
            }else{
                $.ajax({
                    url:"{{route('deletetosection')}}",
                    method:'GET',
                    data:{
                        id:id,
                        idsection:idsection
                    },
                    success: function(data){
                        $("tbody").find("tr").remove();
					    $("tbody").append(data);
                    },
                    error: function(error){
                        alert('Something wrong!')
                    }
			    });
            }
        }
    </script>
@endsection