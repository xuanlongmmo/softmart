@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <center>
            <b>Manage Categories</b>
        </center>
        <table>
            <thead>
                <tr>
                    <td>
                        Category Name
                    </td>
                    <td>
                        Quantity Post
                    </td>
                    <td>
                        Action
                    </td>
                </tr>
            </thead>
            <tbody>
                @if (!empty($categories))
                    @foreach ($categories as $category)
                        <tr>
                            <td >{{$category->category_name}}</td>
                            <td >{{$category->policy->count()}}</td>
                            <td >
                                <a href="{{ route('editcategorypolicy', ['id'=>$category->id]) }}"><i style="font-size: 20px" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <i style="font-size: 20px;margin-left: 5px;color: rgb(7, 28, 214)" onclick="var result = confirm('Bạn có thực sự muốn xóa danh mục này? Sau khi xóa tất cả sản phẩm thuộc danh mục đó cũng sẽ bị xóa')
                                    if(result == true){
                                        window.location.href = '{{URL::to('admin/deletecategorypolicy?id='.$category->id)}}'
                                    }else{		
                                }"class="fa fa-trash-o" aria-hidden="true">
                                </i>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <button id="addnewsection" data-toggle="modal" data-target="#myModalProduct" style="background-color: white;width: 100%;text-align: center;min-height: 30px;align-content: center;border-radius: 10px">
            <i class="fas fa-plus"></i>
        </button>
        <div id="insideareamodal">
            <!-- Modal -->
            <div style="" class="modal fade" id="myModalProduct" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách bài viết</h4>
                    </div>
                    <input style="margin-left:10px" type="text" name="" id="titlenewcategoryproduct" value="newcategorypolicy">
                    <button onclick="return addcategorypolicy(this)" style="margin-bottom:10px">Create and save</button>
                    <div class="modal-body" id="modal-body">
                        @foreach ($listPostPolicy as $item)
                        <div style="display: flex">
                            <input onchange="return changelist(this)" type="checkbox" value="{{$item->id}}" id="{{$item->id}}">
                            &nbsp;
                            <span>{{$item->id}} - </span>
                            &nbsp;
                            <span>{{$item->title}}</span>
                            &nbsp;
                            <span>({{$item->category_policy->category_name}})</span>
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
        var arrID = [];
        var i = 0;
        var strid;

        function changelist(e){
            idpost = Number(e.value);
            if(e.checked){
                if(arrID.includes(idpost) == false){
                    arrID.push(idpost);
                }
            }else{
                if(arrID.includes(idpost) == true){
                    arrID.pop(idpost);
                }
            }
        }

        function addcategorypolicy(e){
            if(Number(arrID.length) > 0){
                category_name = document.getElementById('titlenewcategoryproduct').value;
                strid = arrID.toString();
                $.ajax({
                    url:"{{route('addnewcategorypolicy')}}",
                    method:'GET',
                    data:{
                        category_name:category_name,
                        strid:strid
                    },
                    success: function(data){
                        $("tbody").find("tr").remove();
					    $("tbody").append(data);
                        alert('Tạo danh mục thành công!');
                    },
                    error: function(error){
                        console.log(error);
                        alert('Something wrong!')
                    }
			    });
            }else{
                category_name = document.getElementById('titlenewcategoryproduct').value;
                $.ajax({
                    url:"{{route('addnewcategorypolicy')}}",
                    method:'GET',
                    data:{
                        category_name:category_name,
                    },
                    success: function(data){
                        $("tbody").find("tr").remove();
					    $("tbody").append(data);
                        alert('Tạo danh mục thành công!');
                    },
                    error: function(error){
                        console.log(error);
                        alert('Something wrong!');
                    }
                });
            }    
        }
    </script>
@endsection