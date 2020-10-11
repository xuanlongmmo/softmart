@if (!empty($products))
    <?php
        $arrProducts = [];
        $i=0;
        foreach ($products as $product) {
            $arrProducts[$i] = $product->product->id;
            $i++;
        }
    ?>
    @foreach ($products as $product)
    <tr>
        <td>{{$product->product->id}}</td>
        <td>{{$product->product->product_name}}</td>
        <td><img style="max-width: 90px;" src="{{ asset($product->product->link_image) }}" alt=""></td>
    </tr>
    @endforeach
@endif