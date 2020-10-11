@foreach ($data as $item)
    <tr>
        <td class='cart_product'>
            <a href='{{ route('ctsp', ['id'=>$item->id]) }}'><img width='100px' src='{{ $item->link_image }}' alt=''></a>
        </td>
        <td class='cart_description' style="padding-top: 30px">
            <h4><a href='{{ route('ctsp', ['id'=>$item->id]) }}'>{{ $item->product_name }}</a></h4>
            <p>Web ID: {{ $item->id }}</p>
        </td>
        <td class='cart_price' style="padding-top: 30px">
            <p>{{ number_format($item->price) }} đ</p>
        </td>
        <td class='cart_delete' style="padding-top: 30px">
            <button style="background-color: transparent;border: none" onclick="return deletewishlist(this)" id="dwl{{$item->id}}" value="{{$item->id}}">
                <i class='fa fa-times'></i>
            </button>
        </td>
    </tr>
@endforeach