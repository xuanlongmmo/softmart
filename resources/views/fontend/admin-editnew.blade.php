@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <div style="margin-left: 20px;width: 800px;;background-color: white" class="add-product">
            <h1 style="margin-left: 50px;padding-top: 15px">Edit news</h1>
            <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 50px">* Required input</span>
            <form style="margin-left: 50px" action="" method="post">
                @csrf
                <div style="display: flex;margin-top: 20px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Title :</label>
                    <input style="margin-left: 75px;width: 500px;" type="text" name="title" value="{{ $new->title }}"/>
                    <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px">*</span>
                </div>
                @if ($errors->has('title'))
                    <strong style="color: red">{{ $errors->first('title') }}</strong>
                @endif
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Link image :</label>
                    <input style="margin-left: 32px;width: 500px;" type="text" name="linkimage" value="{{ $new->link_image }}"/>
                    <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px">*</span>
                </div>
                @if ($errors->has('linkimage'))
                    <strong style="color: red">{{ $errors->first('linkimage') }}</strong>
                @endif
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Category :</label>
                    <select name="id_category" style="margin-left: 44px;width: 515px;" class="form-control">
                        @foreach ($listcategory as $item)
                            @if ($new->id_category == $item->id)
                                <option selected="selected" value="{{ $item->id }}">{{ $item->id }} - {{ $item->news_name }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->news_name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px">*</span>
                </div>
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Content :</label>
                    <textarea style="margin-left: 50px;width: 500px;" name="content" id="" cols="30" rows="10">{{ $new->content }}</textarea>
                    <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px">*</span>
                </div>
                @if ($errors->has('content'))
                    <strong style="color: red">{{ $errors->first('content') }}</strong>
                @endif
                <input style="background-color: blue;height: 30px;width: 100px;border-radius: 5px;margin-left: 523px;margin-bottom: 50px;margin-top: 15px" name="editnew" type="submit" value="Edit" />
            </form>
        </div>
    </div>
@endsection