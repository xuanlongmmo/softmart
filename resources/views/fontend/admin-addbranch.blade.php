@extends('fontend.layout.admin')
@section('content')
<style>
    .span9 form input{
        width: 850px;
    }
    .span9 form input.add{
        display: block;
        width: 100px;
        margin-left: 350px !important;
        margin-top: 30px !important;
        background-color: blue;
    }
</style>
	<div class="span9">
        <form style="margin-left: 50px" action="" method="POST">
            @csrf
            <label for="">Name Branch</label>
            <input type="text" name="name" value="">
            @if ($errors->has('name'))
                <strong style="color: red">{{ $errors->first('name') }}</strong>
            @endif

            <label for="">Hotline</label>
            <input type="text" name="hotline" value="">
            @if ($errors->has('hotline'))
                <strong style="color: red">{{ $errors->first('hotline') }}</strong>
            @endif

            <label for="">Email</label>
            <input type="text" name="email" value="">
            @if ($errors->has('email'))
                <strong style="color: red">{{ $errors->first('email') }}</strong>
            @endif

            <label for="">Facebook</label>
            <input type="text" name="facebook" value="">
            @if ($errors->has('facebook'))
                <strong style="color: red">{{ $errors->first('facebook') }}</strong>
            @endif

            <label for="">Instagram</label>
            <input type="text" name="instagram" value="">
            @if ($errors->has('instagram'))
                <strong style="color: red">{{ $errors->first('instagram') }}</strong>
            @endif

            <label for="">Twitter</label>
            <input type="text" name="twitter" value=""><br>
            @if ($errors->has('twitter'))
                <strong style="color: red">{{ $errors->first('twitter') }}</strong>
            @endif

            <label for="">Address</label>
            <input type="text" name="address" value=""><br>
            @if ($errors->has('address'))
                <strong style="color: red">{{ $errors->first('address') }}</strong>
            @endif

            <label for="">Phone</label>
            <input type="text" name="phone" value=""><br>
            @if ($errors->has('phone'))
                <strong style="color: red">{{ $errors->first('phone') }}</strong>
            @endif


            <input class="add" style="margin-left:60px" type="submit" name="add" value="Add">
        </form>
    </div>
@endsection