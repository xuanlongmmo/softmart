@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <form action="{{ route('posteditbanner') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div style="display: flex;">
                <div>
                    <img style="max-width: 85%;" src="{{ asset($banner->link_image) }}" alt="">
                </div>
                <div>
                    <input readonly style="display: none" type="text" name="idbanner" value="{{$banner->id}}">
                    <div>
                        <label style="font-size: 25px;margin-bottom:10px" for="title">Title</label>
                        <input type="text" name="title" id="title" value="{{$banner->title}}">
                    </div>
                    <hr>
                    <div>
                        <label style="font-size: 25px;margin-bottom:10px" for="content">Content</label>
                        <input type="text" name="content" id="content" value="{{$banner->content}}">
                    </div>
                    <hr>
                    <div>
                        <label style="font-size: 25px;margin-bottom:10px" for="link">Link</label>
                        <input type="text" name="link" id="link" value="{{$banner->link}}">
                    </div>
                    <hr>
                    <div>
                        <label style="font-size: 25px;margin-bottom:10px" for="newimage">Upload new Image</label>
                        <input type="file" name="newimage" id="newimage">
                    </div>
                </div>
            </div>
            <button style="min-width: 100px; min-height: 40px" class="btn-danger" type="submit">Save</button>
        </form>
    </div>
@endsection