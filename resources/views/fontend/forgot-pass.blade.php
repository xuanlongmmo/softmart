@extends('fontend.base')
@section('content')
    @if ($check==0)
        <div style="margin: 50px 450px">
            <form action="{{ route("resetpass") }}" method="POST">
                @csrf
                <h1 style="color: red">Vui lòng nhập email</h1>
                <input style="margin-top: 10px;margin-left: 10px;width: 300px" id="email" name ="email" type="text" placeholder="Email" autocomplete="off"/>
                <input style="width: 70px;margin-left: 20px" type="submit" name="sendmail" value="Gửi">
                <br><strong style="color: red">{{ $result }}</strong>
            </form>
        </div>
    @elseif($check==1)
        <div style="margin: 50px 450px">
            <form action="{{ route("postcode") }}" method="POST">
                @csrf
                <h6 style="color: red">Nhập code vừa gửi đến {{ $mail }} của bạn để reset mật khẩu</h6>
                <input style="display:none;" readonly name="mail" type="text" value="{{ $mail }}">
                <input style="margin-top: 10px;margin-left: 10px;width: 300px" id="code" name ="code" type="text" placeholder="Code" autocomplete="off"/>
                <input style="width: 70px;margin-left: 20px" type="submit" name="sendcode" value="Nhập">
                <br><strong style="color: red">{{ $result }}</strong>
            </form>
        </div>
    @elseif($check==2)
        <div style="margin: 50px 450px">
            <h1 style="color: red">Mời bạn nhập mật khẩu</h1>
            <form action="{{ route('postpass') }}" method="post">
				@csrf
				<div style="display: grid; width: 30%;margin-top: 30px">
                    <input style="display:none;" readonly name="mail" type="text" value="{{ $mail }}">
					<input style="width: 300px;margin-top: 10px;" id="confirm" type="password" name="password" placeholder="Mật khẩu">
					{{--  @if ($errors->has('newpassword'))
						<strong>{{$errors->first('newpassword')}}</strong>
					@endif  --}}
					<input style="width: 300px;margin-top: 10px;" id="repassword" type="password" name="repassword" placeholder="Nhập lại mật khẩu">
                    <br><strong style="color: red">{{ $result }}</strong>
                    <div style="width: fit-content;margin: auto;margin-top: 30px;justify-content: space-around" class="row">
						<button type="submit">Đổi mật khẩu</button>
                    </div>
				</div>
			</form>
        </div>    
    @endif
@endsection