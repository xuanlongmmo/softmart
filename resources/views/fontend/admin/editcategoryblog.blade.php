@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <div>
            <form action="{{ route('savecategorynameblog') }}" method="post">
                @csrf
                <label for="categoryname">Category Name</label>
                <input type="text" id="categoryname" name="categoryname" value="{{$category[0]->news_name}}">
                <input style="display: none" readonly id="idcategory" type="text" name="idcategory" value="{{$category[0]->id}}">
                <button style="margin-bottom: 10px" type="submit">Save Category Name</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <td>ID Product</td>
                    <td>Title</td>
                    <td>Content</td>
                </tr>
            </thead>
            <tbody>
                @if (!empty($news))
                    <?php
                        $arrNews = [];
                        $i=0;
                        foreach ($news as $blog) {
                            $arrNews[$i] = $blog->id;
                            $i++;
                        }
                    ?>
                    @foreach ($news as $blog)
                        <tr>
                            <td>{{$blog->id}}</td>
                            <td>{{$blog->title}}</td>
                            <td>{{$blog->content}}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <button id="addproduct" data-toggle="modal" data-target="#modalcategoryproduct" style="background-color: white;width: 100%;text-align: center;min-height: 30px;align-content: center;border-radius: 10px">
            <i class="fas fa-plus"></i>
        </button>
        <!-- Modal -->
        <div style="" class="modal fade" id="modalcategoryproduct" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Danh sách sản phẩm</h4>
                </div>
                <div class="modal-body">
                @if (!empty($news))
                    @foreach ($listNews as $item)
                        @if (in_array($item->id,$arrNews))
                            <div style="display: flex">
                                <input onchange="return changelist(this)" checked value="{{$item->id}}" type="checkbox" name="{{$item->id}}" id="{{$item->id}}">
                                &nbsp;
                                <span>{{$item->id}} - </span>
                                &nbsp;
                                <span>{{$item->title}}</span>
                                &nbsp;
                                <span> ({{$item->category_news->news_name}})</span>
                            </div>
                        @else
                            <div style="display: flex">
                                <input onchange="return changelist(this)" value="{{$item->id}}" type="checkbox" id="{{$item->id}}">
                                &nbsp;
                                <span>{{$item->id}} - </span>
                                &nbsp;
                                <span>{{$item->title}}</span>
                                &nbsp;
                                <span> ({{$item->category_news->news_name}})</span>
                            </div>
                        @endif
                    @endforeach
                @else
                    @foreach ($listNews as $item)
                        <div style="display: flex">
                            <input type="checkbox" value="{{$item->id}}" id="{{$item->id}}">
                            &nbsp;
                            <span>{{$item->id}} - </span>
                            &nbsp;
                            <span>{{$item->title}}</span>
                        </div>
                    @endforeach
                @endif
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script>
		function changelist(e){
            idnews = e.value;
            idcategory = document.getElementById('idcategory').value;
            
            if(e.checked){
                $.ajax({
                    url:"{{route('editchangeidcategoryblog')}}",
                    method:'GET',
                    data:{
                        idnews:idnews,
                        idcategory:idcategory
                    },
                    success: function(data){
                        $("tbody").find("tr").remove();
					    $("tbody").append(data);
                    },
                    error: function(error){
                        alert('Something wrong!')
                    }
			    });
            }else{
                alert('Để cập nhật lại danh mục cho bài viết này hãy chỉnh sửa danh sách bài viết danh mục bạn muốn thêm vào')
            }
        }
	</script>
@endsection