@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <div style="margin-left: 20px;width: 800px;;background-color: white" class="add-product">
            <h1 style="margin-left: 50px;padding-top: 15px">Accept product</h1>
            <form style="margin-left: 50px" action="" method="post">
                @csrf
                <div style="display: flex;margin-top: 20px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Name product :</label>
                    <input readonly style="margin-left: 10px;width: 500px;" type="text" name="nameproduct" value="{{ $product->product_name }}"/>
                    <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px"></span>
                </div>
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Image :</label>
                    <img src="{{ asset($product->link_image) }}" alt="">
                </div>
                <div style="display: flex">
                    <div style="display: flex;margin-top: 15px" class="input-box">
                        <label style="margin-top: 5px;font-size: 14px" for="">Price :</label>
                        <input readonly style="margin-left: 70px;width: 80px;" type="text" name="price" value="{{ $product->price }}"/>
                        <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px"></span>
                    </div>
                    <div style="display: flex;margin-top: 15px;margin-left: 28px" class="input-box">
                        <label style="margin-top: 5px;font-size: 14px" for="">Sale :</label>
                        <input readonly style="margin-left: 40px;width: 80px;"  type="number" name="sale" value="{{ $product->sale_percent }}" />
                    </div>
                    <div style="display: flex;margin-top: 15px;margin-left: 42px" class="input-box">
                        <label style="margin-top: 5px;font-size: 14px" for="">Quantity :</label>
                        <input readonly style="margin-left: 10px;width: 80px;" type="number" name="quantity" value="{{ $product->quantity }}"/>
                    </div>
                </div>
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Category :</label>
                    @foreach ($listcategory as $category)
                        @if ($category->id == $product->id_category)
                            <input readonly style="margin-left: 45px;width: 80px;" type="text" name="quantity" value="{{ $category->category_name }}"/>
                        @endif
                    @endforeach
                </div>
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Description :</label>
                    <textarea readonly style="margin-left: 28px;width: 500px;" name="description" id="" cols="30" rows="10">{{ $product->description }}</textarea>
                </div>
                <input style="background-color:slategray;height: 30px;width: 70px;border-radius: 5px;margin-left: 550px;margin-bottom: 50px;margin-top: 15px" name="editproduct" type="submit" value="Accept" />
            </form>
        </div>
    </div>
@endsection