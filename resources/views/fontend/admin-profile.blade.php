@extends('fontend.layout.admin')
@section('content')
<style>
    table tr{
        background: none !important;
    }
</style>
	<div class="span9">
        <form action="{{ route('updateprofile', ['id'=>$data->id]) }}" method="post">
            @csrf
            <div style="display: flex; justify-content: space-around">
                <div>
                    @if ($errors->has('fullname'))
                        <strong>{{$errors->first('fullname')}}</strong>
                    @endif
                    <label for="fullname">Fullname</label>
                    <input type="text" name="fullname" id="fullname" value="{{$data->fullname}}" required>
                    <label for="username">Username</label>
                    <input type="text" readonly name="username" id="username" value="{{$data->username}}">
                    <label for="email">Email</label>
                    <input type="text" readonly name="email" id="email" value="{{$data->email}}">
                    @if ($errors->has('phone'))
                        <strong>{{$errors->first('phone')}}</strong>
                    @endif
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{$data->phone}}" required>
                </div>
                <div>
                    @if ($errors->has('address'))
                        <strong>{{$errors->first('address')}}</strong>
                    @endif
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="{{$data->address}}" required>
                    <label for="position">Position</label>
                    {{--  <select name="position" id="position">  --}}
                        @foreach ($group_user as $group)
                            @if ($group->id == $data->id_group)
                                <input readonly name="position" selected value="{{$group->group_name}}">
                            @endif
                        @endforeach
                    {{--  </select>  --}}
                    <label for="date">Date</label>
                    <input type="text" readonly name="date" id="date" value="{{$data->created_at}}">
                </div>
            </div>
            <?php
                $check = 0;
                $check = 1;
            ?>
            <table>
                <tbody>
                <?php
                    $count = sizeOf($permission);
                    $row = $count/4;
                    $temp = 4;
                ?>
                @for ($i = 0; $i < $row; $i++)
                    <tr>
                        @for ($j = $temp-4; $j < $temp; $j++)
                            <?php
                                $check = 0;
                            ?>
                            @foreach ($user_permission as $item)
                                @if ($item->id_permission == $permission[$j]->id)
                                    <?php
                                        $check = 1;
                                    ?>
                                @endif
                            @endforeach
                            @if ($check == 1)
                                <td><input checked="checked" style="width: 40px;"  type="checkbox" name="permission[]" value="{{ $permission[$j]->id }}">{{ $permission[$j]->permission }}</td>    
                            @else
                                <td><input style="width: 40px;"  type="checkbox"name="permission[]" value="{{ $permission[$j]->id }}">{{ $permission[$j]->permission }}</td>    
                            @endif
                        @if ($j == $count-1)
                            @break
                        @endif
                        @endfor
                    </tr>
                    <?php
                        $temp += 4;        
                    ?>
                @endfor
                <tbody>
            </table>
            </div>
            <div style="width: 100%;text-align: center;margin-top:20px">
                <button style="background: blue;width: 80px;" type="submit" style="">Update</button>
            </div>
            
        </form>
	</div>
	<!--/.span9-->
@endsection
