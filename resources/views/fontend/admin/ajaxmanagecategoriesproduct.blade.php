<?php
    $checkedit = 0;
    $checkdelete = 0;
    foreach(Auth::user()->permission as $permission){
        if($permission->slug_name == 'sua-danh-muc'){
            $checkedit = 1;
        }
        if($permission->slug_name == 'xoa-danh-muc'){
            $checkdelete = 1;
        }
    }
?>

@foreach ($categories as $category)
    <tr>
        <td >{{$category->category_name}}</td>
        <td >{{$category->products->count()}}</td>
        <td >
            @if ($checkedit  == 1)
                <a href="{{ route('editcategoryproduct', ['id'=>$category->id]) }}"><i style="font-size: 20px" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            @endif
            @if ($checkdelete == 1)
                <i style="font-size: 20px;margin-left: 5px;color: rgb(7, 28, 214)" onclick="var result = confirm('Bạn có thực sự muốn xóa danh mục này? Sau khi xóa tất cả sản phẩm thuộc danh mục đó cũng sẽ bị xóa')
                    if(result == true){
                        window.location.href = '{{URL::to('admin/deletecategoryproduct?id='.$category->id)}}'
                    }else{		
                }"class="fa fa-trash-o" aria-hidden="true">
                </i>
            @endif
        </td>
    </tr>
@endforeach