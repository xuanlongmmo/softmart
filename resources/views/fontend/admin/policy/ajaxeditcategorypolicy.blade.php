@if (!empty($posts))
    <?php
        $arrNews = [];
        $i=0;
        foreach ($posts as $blog) {
            $arrNews[$i] = $blog->id;
            $i++;
        }
    ?>
    @foreach ($posts as $blog)
        <tr>
            <td>{{$blog->id}}</td>
            <td><a href="{{ route('detailpolicy', ['id'=>$blog->id]) }}">{{$blog->title}}</a></td>
        </tr>
    @endforeach
@endif