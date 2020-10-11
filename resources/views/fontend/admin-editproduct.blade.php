@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <div style="margin-left: 20px;width: 800px;;background-color: white" class="add-product">
            <h1 style="margin-left: 50px;padding-top: 15px">Edit product</h1>
            <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 50px">* Required input</span>
            <form style="margin-left: 50px" action="" method="post">
                @csrf
                <div style="display: flex;margin-top: 20px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Name product :</label>
                    <input style="margin-left: 10px;width: 500px;" type="text" name="nameproduct" value="{{ $product->product_name }}"/>
                    <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px">*</span>
                </div>
                @if ($errors->has('nameproduct'))
                    <strong style="color: red">{{ $errors->first('nameproduct') }}</strong>
                @endif
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Link image :</label>
                    <input style="margin-left: 32px;width: 500px;" type="text" name="linkimage" value="{{ $product->link_image }}"/>
                </div>
                @if ($errors->has('linkimage'))
                    <strong style="color: red">{{ $errors->first('linkimage') }}</strong>
                @endif
                <div style="display: flex">
                    <div style="display: flex;margin-top: 15px" class="input-box">
                        <label style="margin-top: 5px;font-size: 14px" for="">Price :</label>
                        <input style="margin-left: 70px;width: 80px;" type="text" name="price" value="{{ $product->price }}"/>
                        <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px">*</span>
                    </div>
                    <div style="display: flex;margin-top: 15px;margin-left: 28px" class="input-box">
                        <label style="margin-top: 5px;font-size: 14px" for="">Sale :</label>
                        <input style="margin-left: 40px;width: 80px;"  type="number" name="sale" value="{{ $product->sale_percent }}" />
                    </div>
                    <div style="display: flex;margin-top: 15px;margin-left: 42px" class="input-box">
                        <label style="margin-top: 5px;font-size: 14px" for="">Quantity :</label>
                        <input style="margin-left: 10px;width: 80px;" type="number" name="quantity" value="{{ $product->quantity }}"/>
                    </div>
                </div>
                @if ($errors->has('price')||$errors->has('sale')||$errors->has('quantity'))
                    <strong style="color: red">{{ $errors->first('price') }}</strong> <br>
                    <strong style="color: red">{{ $errors->first('sale') }}</strong> <br>
                    <strong style="color: red">{{ $errors->first('quantity') }}</strong>
                @endif
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Category :</label>
                    <select name="id_category" style="margin-left: 44px;width: 515px;" class="form-control">
                        @foreach ($listcategory as $item)
                            @if ($product->id_category == $item->id)
                                <option selected="selected" value="{{ $item->id }}">{{ $item->id }} - {{ $item->category_name }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->category_name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px">*</span>
                </div>
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Description :</label>
                    <textarea style="margin-left: 28px;width: 500px;" name="description" id="" cols="30" rows="10">{{ $product->description }}</textarea>
                </div>
                <input style="background-color: blue;height: 30px;width: 70px;border-radius: 5px;margin-left: 550px;margin-bottom: 50px;margin-top: 15px" name="editproduct" type="submit" value="Edit" />
            </form>
        </div>
    </div>
@endsection