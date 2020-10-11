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
            <input style="display:none" type="text" name="id" value="{{ $data[0]->id }}">
            <label for="">Name Branch</label>
            <input type="text" name="name" value="{{ $data[0]->name_branch }}">
            @if ($errors->has('name'))
                <strong style="color: red">{{ $errors->first('name') }}</strong>
            @endif

            <label for="">Hotline</label>
            <input type="text" name="hotline" value="{{ $data[0]->hotline }}">
            @if ($errors->has('hotline'))
                <strong style="color: red">{{ $errors->first('hotline') }}</strong>
            @endif

            <label for="">Email</label>
            <input type="text" name="email" value="{{ $data[0]->email }}">
            @if ($errors->has('email'))
                <strong style="color: red">{{ $errors->first('email') }}</strong>
            @endif

            <label for="">Facebook</label>
            <input type="text" name="facebook" value="{{ $data[0]->facebook }}">
            @if ($errors->has('facebook'))
                <strong style="color: red">{{ $errors->first('facebook') }}</strong>
            @endif

            <label for="">Instagram</label>
            <input type="text" name="instagram" value="{{ $data[0]->instagram }}">
            @if ($errors->has('instagram'))
                <strong style="color: red">{{ $errors->first('instagram') }}</strong>
            @endif

            <label for="">Twitter</label>
            <input type="text" name="twitter" value="{{ $data[0]->twitter }}"><br>
            @if ($errors->has('twitter'))
                <strong style="color: red">{{ $errors->first('twitter') }}</strong>
            @endif

            <label for="">Address</label>
            <input type="text" name="address" value="{{ $data[0]->address }}"><br>
            @if ($errors->has('address'))
                <strong style="color: red">{{ $errors->first('address') }}</strong>
            @endif

            <label for="">Phone</label>
            <input type="text" name="phone" value="{{ $data[0]->phone }}"><br>
            @if ($errors->has('phone'))
                <strong style="color: red">{{ $errors->first('phone') }}</strong>
            @endif

            @if ($data[0]->id == 1)
                <label for="">About</label>
                <input type="text" name="about" value="{{ $data[0]->about }}"><br>
                @if ($errors->has('about'))
                    <strong style="color: red">{{ $errors->first('about') }}</strong>
                @endif

                <label for="">Account number</label>
                <input type="text" name="account_number" value="{{ $data[0]->account_number }}"><br>
                @if ($errors->has('account_number'))
                    <strong style="color: red">{{ $errors->first('account_number') }}</strong>
                @endif

                <label for="">Bank name</label>
                <input type="text" name="bank_name" value="{{ $data[0]->bank_name }}"><br>
                @if ($errors->has('bank_name'))
                    <strong style="color: red">{{ $errors->first('bank_name') }}</strong>
                @endif

                <label for="">Company name</label>
                <input type="text" name="company_name" value="{{ $data[0]->company_name }}"><br>
                @if ($errors->has('company_name'))
                    <strong style="color: red">{{ $errors->first('company_name') }}</strong>
                @endif
            @endif

            <input class="add" style="margin-left:60px" type="submit" name="update" value="Update">
        </form>
    </div>
@endsection