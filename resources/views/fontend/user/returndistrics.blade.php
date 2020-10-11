<select onchange="return choosendistric(this)" name="district" id="district" class="form-control">
    @foreach ($districs as $distric)
        <option value="{{$distric->id}}">{{$distric->name}}</option>
    @endforeach
</select>