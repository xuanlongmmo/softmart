@if (!empty($reviews))
    @foreach ($reviews as $review)
        <tr>
            <td>{{$review->id}}</td>
            <td>{{$review->users->fullname}}</td>
            <td>{{$review->users->email}}</td>
            <td>{{$review->star}}</td>
            <td>{{$review->content}}</td>
            <td><a href="{{ route('ctsp', ['id'=>$review->product->id]) }}">{{$review->product->product_name}}</a></td>
            <td>{{$review->created_at}}</td>
            <td>
            <button style="background-color: white;border: none" value="{{$review->id}}" onclick="var result = confirm('Bạn có thực sự muốn xóa review này?')
                if(result == true){
                    deletereview(this)
                }else{}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>
    @endforeach
@endif