@extends('fontend.base')
@section('content')
<!-- content web -->
<div class="container-fluid">
    <div class="container">
        <div class="row mt-20">
            <!-- left layout -->
            <div class="col-md-4 sidebar left-layout">
                <h1 class="sidebar__headding">
                    Tin tức mới
                </h1>
                <form action="{{ route('searchnew2') }}" method="get">
                    <div class="search-blog--box">
                        <input type="search" name="q" id="" class="form__search" placeholder="Bạn muốn tìm gì ... ?">
                        <button type="submit" class="btn--blog">
                            <i class="fa fa-search btn--blog--icon"></i>
                        </button>
                    </div>
                </form>   
                    <h3 class="sidebar__title pt-20">
                        Danh mục tin tức
                    </h3>
                    <ul class="ct__blog--box">
                        @foreach ($datacategory as $item)
                            <li class="ct__blog--item">
                                <a href="{{ route('detailcategory', ['category'=>$item->slug_name]) }}" class="ct__blog--link">
                                    {{$item->news_name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- right layout -->
                    <div class="col-md-8 article right-layout" >
                        <div class="blog__box">
                            <img src="{{ $datanew->link_image }}" class="img-fluid blog__img" alt="">
                            <div class="entry-category">
                                <a href="{{ route('detailcategory', ['category'=>$datanew->category_news->slug_name]) }}" class="btn-entry">
                                    {{ $datanew->category_news->news_name }}
                                </a>
                            </div>
                            <h3 class="entry-title">
                                {{ $datanew->title }}
                            </h3>
                                <ul class="entry-meta-list">
                                    <li class="entry-date">
                                            <img src="fontend/assets/img/icon-calender.png" class="entry-img" alt="">
                                        {{ $datanew->created_at }}
                                    </li>
                                    <li class="entry-cmt">
                                        <a href="{{ url()->current() }}?id={{ $datanew->id }}#comment" class="entry-icon">
                                            <img src="fontend/assets/img/commetn-calender.png" class="entry-img" alt="">
                                        </a>
                                        {{ $datanew->comment->count() }}
                                    </li>
                                    {{--  <li style="margin-right: 10px;margin-top: 6px;border-radius: 10px">
                                        {{--  <a class="twitter-share-button"href="https://twitter.com/intent/tweet?url=https://tiki.vn/hop-ham-nong-arirang-life-el-als263-tim-p466737.html?spid=175952&src=home-deal-hot&text=Link+description+long">Tweet</a>  --}}
                                        
                                    </li>  
                                </ul>
                                <div>
                                    {!! html_entity_decode($datanew->content ) !!}
                                </div>
                                <div style="display: flex">
                                    {{--  Facebook  --}}
                                    <div id="fb-root"></div>
                                    <script>(function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) return;
                                    js = d.createElement(s); js.id = id;
                                    js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=241110544128";
                                    fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));</script>
                                    <div class="fb-share-button" data-href="http://localhost/softmart/ctsp?id=2" data-layout="button_count"></div>
                                    
                                    {{--  Twiter  --}}
                                    <div style="margin-top: 4px;margin-left: 10px">
                                        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="true">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                        {{--  <a href="http://twitter.com/home?status=C hiện tại đang đọc <?php the_permalink(); ?>" title =" Nhấp để chia sẻ bài đăng này trên Twitter " <img src = "ADD_IMAGE_URL_HERE" alt = "Chia sẻ trên Twitter"> </a>  --}}
                                    </div>
    
                                    {{--  Linkedin  --}}
                                    <div style="margin-bottom: 10px;margin-left: 10px">
                                        {{--  <a href="https://www.linkedin.com/shareArticle?mini=true&url=facebook.com">Link</a>  --}}
                                        <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
                                        <script type="IN/Share" data-url="https://facebook.com"></script>
                                    </div>
                                </div>
                        </div>
                        
                        <div id="comment" class="comment">
                            <b style="font-size: 30px">Bình luận</b>
                            <form action="{{ route('postcomment') }}" style="margin-top: 20px" method="POST">
                                @csrf
                                <input style="display: none" name='id' type="text" value="{{ $datanew->id }}"> 
                                <textarea name="input_comment" style="width: 500px;height: 100px;border-radius: 10px" required></textarea><br>
                                <input name="postcomment" style="background-color: rgb(30, 221, 94); margin-top: 10px;margin-left: 370px;width: 100px;height: 30px;border-radius: 10px" type="submit" value="Bình luận">
                            </form>
                            <hr>
                            @foreach ($datacomment as $item)
                                <div class="displaycomment">
                                    <b>{{ $item->user->fullname }}</b> 
                                    <span style="font-size: 12px;margin-left: 10px">{{Carbon\Carbon::parse($item->created_at)->format('H:i d-m-Y')}}</span><br>
                                    <span>{{ $item->content }}</span>
                                    @if (Auth::check())
                                        {{-- <button style="margin-bottom: 5px;background: none;border: none" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample{{ $item->id }}" aria-expanded="false" aria-controls="collapseExample{{ $item->id }}">
                                            <i style="color: red;font-size: 15px"  class="fa fa-reply" aria-hidden="true"></i>
                                        </button> --}}
                                        @if (Auth::user()->id == $item->user->id)
                                            <button style="margin-bottom: 5px;background: none;border: none" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample{{ $item->id }}" aria-expanded="false" aria-controls="collapseExample{{ $item->id }}">
                                                <i style="color: red;font-size: 15px"  class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </button>
                                            <i onclick="var result = confirm('Bạn có thực sự muốn xóa comment này?')
                                                if(result == true){
                                                    window.location.href = '{{URL::to('blog/deletecomment?id='.$item->id)}}'
                                                }else{
                                                    
                                                }" class="fa fa-trash"></i>
                                            <div class="collapse" id="collapseExample{{ $item->id }}">
                                                <form action="{{ route('postcomment')}}" method="POST">
                                                    @csrf
                                                    <input style="display: none" name='id' type="text" value="{{ $item->id }}"> 
                                                    <textarea name="input_comment" style="width: 500px;height: 100px;border-radius: 10px">{{ $item->content }}</textarea><br>
                                                    <input name="editcomment" style="background-color: rgb(30, 221, 94); margin-top: 10px;margin-left: 370px;width: 100px;height: 30px;border-radius: 10px" type="submit" value="Cập nhật">
                                                </form>
                                            </div>
                                        @endif
                                        {{-- <div class="collapse" id="collapseExample{{ $item->id }}">
                                            <form action="{{ route('postcomment')}}" method="POST">
                                                @csrf
                                                <input style="display: none" name='id' type="text" value="{{ $item->id }}"> 
                                                <input type="text" name="input_comment" style="width: 450px;height: auto;border-radius: 10px;margin-left: 50px" value="{{ $item->content }}"><br>
                                                <input name="repcomment" style="background-color: rgb(30, 221, 94); margin-top: 10px;margin-left: 370px;width: 100px;height: 30px;border-radius: 10px" type="submit" value="Trả lời">
                                            </form>
                                        </div> --}}
                                    @endif
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                    </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript">
            function openNav() {
              document.getElementById("mySidepanel").style.width = "250px";
            }

            function closeNav() {
              document.getElementById("mySidepanel").style.width = "0";
            }
        </script>
        <script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
          dropdown[i].addEventListener("click", function() {
          this.classList.toggle("active-1");
          var dropdownContent = this.nextElementSibling;
          if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
          } else {
          dropdownContent.style.display = "block";
          }
          });
        }
        </script>
        @endsection