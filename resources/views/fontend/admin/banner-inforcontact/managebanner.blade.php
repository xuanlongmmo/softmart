@extends('fontend.layout.admin');
@section('content')
    <div class="span9">
        <table>
            <thead>
                <tr>
                    <td>Image</td>
                    <td>Title</td>
                    <td>Content</td>
                    <td>Link</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @if (!empty($banners))
                    @foreach ($banners as $banner)
                        <tr>
                            <td><img style="max-width: 50px;" src="{{ asset($banner->link_image) }}" alt="error"></td>
                            <td>{{$banner->title}}</td>
                            <td>{{$banner->content}}</td>
                            <td>{{$banner->link}}</td>
                            <td>
                                <a href="{{ route('editbanner', ['id'=>$banner->id]) }}"><i class="fas fa-edit"></i></a>
                                <a href=""><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection