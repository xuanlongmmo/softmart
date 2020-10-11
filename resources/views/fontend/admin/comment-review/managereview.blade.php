@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <table>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>User</td>
                    <td>Email</td>
                    <td>Star</td>
                    <td>content</td>
                    <td>Product</td>
                    <td>Date</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        function deletereview(e){
            var id = e.value;
            $.ajax({
                url:"{{route('deletereview')}}",
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