<select name="ward" id="ward" class="form-control">
    @foreach ($wards as $ward)
        <option value="{{$ward->id}}">{{$ward->name}}</option>
    @endforeach
</select>