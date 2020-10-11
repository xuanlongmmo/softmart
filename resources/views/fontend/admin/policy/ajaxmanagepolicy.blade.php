@if (!empty($categories))
    @foreach ($categories as $category)
        <tr>
            <td >{{$category->category_name}}</td>
            <td >{{$category->policy->count()}}</td>
            <td >
                <a href="{{ route('editcategorypolicy', ['id'=>$category->id]) }}"><i style="font-size: 20px" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <i style="font-size: 20px;margin-left: 5px;color: rgb(7, 28, 214)" onclick="var result = confirm('Bạn có thực sự muốn xóa danh mục này? Sau khi xóa tất cả bài viết thuộc danh mục đó cũng sẽ bị xóa')
                    if(result == true){
                        window.location.href = '{{URL::to('admin/deletecategoryproduct?id='.$category->id)}}'
                    }else{		
                }"class="fa fa-trash-o" aria-hidden="true">
                </i>
            </td>
        </tr>
    @endforeach
@endif