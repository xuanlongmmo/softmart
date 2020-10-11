@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <table>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>User</td>
                    <td>Email</td>
                    <td>content</td>
                    <td>Product</td>
                    <td>Date</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        function deletecomment(e){
            var id = e.value;
            $.ajax({
                url:"{{route('deletecommentproduct')}}",
                method:'GET',
                data:{
                    id:id,
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
    </script>
@endsection