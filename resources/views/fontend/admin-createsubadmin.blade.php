@extends('fontend.layout.admin')
<style>
    table tr{
        background: none !important;
    }
    input.in{
        height: 30px !important;
    }
    select{
        width: 206px !important;
    }
</style>
@section('content')
	<div class="span9">
        <form action="{{ route('createsubadmin') }}" method="post">
            @csrf
            <div style="display: flex; justify-content: space-around">
                <div>
                    <label for="fullname">Fullname</label>
                    <input class="in" type="text" name="fullname" id="fullname" value=""><br>
                    @if($errors->has('fullname'))
                        <strong style="color:red">{{$errors->first('fullname')}}</strong>
                    @endif
                    <label for="username">Username</label>
                    <input class="in" type="text"  name="username" id="username" value=""><br>
                    @if($errors->has('username'))
                        <strong style="color:red">{{$errors->first('username')}}</strong>
                    @endif
                    <label for="email">Email</label>
                    <input class="in" type="text" name="email" id="email" value=""><br>
                    @if($errors->has('email'))
                        <strong style="color:red">{{$errors->first('email')}}</strong>
                    @endif
                    <label for="email">Password</label>
                    <input class="in" type="password" name="password" id="password" value=""><br>
                    @if($errors->has('password'))
                        <strong style="color:red">{{$errors->first('password')}}</strong>
                    @endif
                </div>
                <div>
                    <label for="address">Address</label>
                    <input class="in" type="text" name="address" id="address" value=""><br>
                    @if ($errors->has('address'))
                        <strong style="color:red">{{$errors->first('address')}}</strong>
                    @endif
                    <label for="position">Position</label>
                    <select name="position" id="position">
                        @foreach ($group_user as $group)
                                <option  name="position" value="{{$group->id}}">{{$group->group_name}}</option>
                        @endforeach
                    </select><br>
                    <label for="phone">Phone</label>
                    <input class="in" type="text" name="phone" id="phone" value=""><br>
                    @if ($errors->has('phone'))
                        <strong style="color:red">{{$errors->first('phone')}}</strong>
                    @endif
                    <label for="email">RePassword</label>
                    <input class="in" type="password" name="repassword" id="repassword" value=""><br>
                    @if ($errors->has('repassword'))
                        <strong style="color:red">{{$errors->first('repassword')}}</strong>
                    @endif
                </div>
            </div>
            <div style="margin-left: 80px">
                <table>
                    <?php
                        $count = sizeOf($permission);
                        $row = $count/4;
                        $temp = 4;
                    ?>
                    @for ($i = 0; $i < $row; $i++)
                        <tr>
                            @for ($j = $temp-4; $j < $temp; $j++)
                                <td><input style="width: 40px;"  type="checkbox"name="permission[]" value="{{ $permission[$j]->id }}">{{ $permission[$j]->permission }}</td>    
                            @if ($j == $count-1)
                                @break
                            @endif
                            @endfor
                        </tr>
                        <?php
                            $temp += 4;        
                        ?>
                    @endfor
                </table>
            </div>
            <div style="width: 100%;text-align: center;margin-top:20px">
                <button style="background: blue;width: 80px;" type="submit" style="">Create</button>
            </div>
            
        </form>
	</div>
	<!--/.span9-->
@endsection

