@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <div style="margin-left: 20px;width: 800px;;background-color: white" class="add-product">
            <h1 style="margin-left: 50px;padding-top: 15px">Accept news</h1>
            <form style="margin-left: 50px" action="" method="post">
                @csrf
                <div style="display: flex;margin-top: 20px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Title :</label>
                    <input readonly style="margin-left: 75px;width: 500px;" type="text" name="title" value="{{ $new->title }}"/>
                </div>
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Link image :</label>
                    <input readonly style="margin-left: 32px;width: 500px;" type="text" name="linkimage" value="{{ $new->link_image }}"/>
                </div>
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <label style="margin-top: 5px;font-size: 14px" for="">Category :</label>
                    <select readonly name="id_category" style="margin-left: 44px;width: 515px;" class="form-control">
                        @foreach ($listcategory as $item)
                            @if ($new->id_category == $item->id)
                                <option selected="selected" value="{{ $item->id }}">{{ $item->id }} - {{ $item->news_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <label style="margin-top: 5px;font-size: 14px" for="">Content :</label>
                <div>
                    <hr>
                        {!! html_entity_decode($new->content ) !!}
                    <hr>
                </div>
                <input style="background-color: blue;height: 30px;width: 100px;border-radius: 5px;margin-left: 523px;margin-bottom: 50px;margin-top: 15px" name="accept" type="submit" value="Accept" />
            </form>
        </div>
    </div>
@endsection