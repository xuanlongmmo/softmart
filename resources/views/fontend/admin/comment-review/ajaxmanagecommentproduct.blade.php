@if (!empty($comments))
    @foreach ($comments as $comment)
        <tr>
            <td>{{$comment->id}}</td>
            <td>{{$comment->users->fullname}}</td>
            <td>{{$comment->users->email}}</td>
            <td>{{$comment->comment}}</td>
            <td><a href="{{ route('ctsp', ['id'=>$comment->product->id]) }}">{{$comment->product->product_name}}</a></td>
            <td>{{$comment->created_at}}</td>
            <td>
            <button style="background-color: white;border: none" value="{{$comment->id}}" onclick="var result = confirm('Bạn có thực sự muốn xóa review này?')
                if(result == true){
                    deletecomment(this)
                }else{}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>
    @endforeach
@endif