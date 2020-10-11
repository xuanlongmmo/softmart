@if (!empty($news))
    <?php
        $arrNews = [];
        $i=0;
        foreach ($news as $blog) {
            $arrNews[$i] = $blog->id;
            $i++;
        }
    ?>
    @foreach ($news as $blog)
        <tr>
            <td>{{$blog->id}}</td>
            <td>{{$blog->title}}</td>
            <td>{{$blog->content}}</td>
        </tr>
    @endforeach
@endif
