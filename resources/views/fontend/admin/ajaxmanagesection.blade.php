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

@foreach ($sections as $section)
    <tr>
        <td >{{$section->title}}</td>
        <td >{{$section->section_content->count()}}</td>
        <td >
            @if ($checkedit  == 1)
                <a href="{{ route('editsection', ['id'=>$section->id]) }}"><i style="font-size: 20px" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            @endif
            @if ($checkdelete == 1)
                <i style="font-size: 20px;margin-left: 5px;color: rgb(7, 28, 214)" onclick="var result = confirm('Bạn có thực sự muốn xóa danh sách này?')
                    if(result == true){
                        window.location.href = '{{URL::to('admin/deletelistsection?id='.$section->id)}}'
                    }else{		
                }"class="fa fa-trash-o" aria-hidden="true">
                </i>
            @endif
        </td>
    </tr>
@endforeach