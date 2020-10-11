@if (!empty($products))
    <?php
        $arrProducts = [];
        $i=0;
        foreach ($products as $product) {
            $arrProducts[$i] = $product->id;
            $i++;
        }
    ?>
    @foreach ($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->product_name}}</td>
            <td><img style="max-width: 90px;" src="{{ asset($product->link_image) }}" alt=""></td>
        </tr>
    @endforeach
@endif
