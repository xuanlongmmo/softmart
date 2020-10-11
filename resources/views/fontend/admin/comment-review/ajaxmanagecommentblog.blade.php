@if (!empty($comments))
    @foreach ($comments as $comment)
        <tr>
            <td>{{$comment->id}}</td>
            <td>{{$comment->user->fullname}}</td>
            <td>{{$comment->user->email}}</td>
            <td>{{$comment->content}}</td>
            <td><a href="{{ route('detailnew', ['id'=>$comment->news->id]) }}">{{$comment->news->title}}</a></td>
            <td>{{$comment->created_at}}</td>
            <td>
            <button style="background-color: white;border: none" value="{{$comment->id}}" onclick="var result = confirm('Bạn có thực sự muốn xóa comment này?')
                if(result == true){
                    deletecomment(this)
                }else{}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>
    @endforeach
@endif