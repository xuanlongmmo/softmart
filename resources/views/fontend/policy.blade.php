@extends('fontend.base')
@section('content')
<!-- content web -->
<div class="container-fluid">
    <div class="container">
        <div class="row mt-20">
            <!-- left layout -->
            <div class="col-md-4 sidebar left-layout">
                <h1 class="sidebar__headding">
                    Chính sách
                </h1>
                <form action="{{ route('searchpolicy') }}" method="get">
                    <div class="search-blog--box">
                        <input type="search" name="q" id="" class="form__search" placeholder="Bạn muốn tìm gì ... ?">
                        <button type="submit" class="btn--blog">
                            <i class="fa fa-search btn--blog--icon"></i>
                        </button>
                    </div>
                </form> 
                <h3 class="sidebar__title pt-20">
                    Danh mục chính sách
                </h3>
                <ul class="ct__blog--box">
                    @foreach ($datacategory as $item)
                        <li class="ct__blog--item">
                            <a href="{{ route('detailcategorypolicy', ['category'=>$item->slug_name]) }}" class="ct__blog--link">
                                {{ $item->category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- right layout -->
            <div class="col-md-8 article right-layout">
                @foreach ($datapolicy as $item)
                    <div class="blog__box">
                        <img src="{{ $item->link_image }}" class="img-fluid blog__img" alt="">
                        <div class="entry-category">
                            <a href="" class="btn-entry">
                                {{ $item->category_policy->category_name }}
                            </a>
                        </div>
                        <h3 class="entry-title">
                            {{ $item->title }}
                        </h3>
                        <ul class="entry-meta-list">
                            <li class="entry-date">
                                <a href="" class="entry-icon">
                                    <img src="fontend/assets/img/icon-calender.png" class="entry-img" alt="">

                                </a>
                                {{ $item->created_at }}
                            </li>
                        </ul>
                        <a href="{{ route('detailpolicy', ['id'=>$item->id]) }}" class="btn entry-readmore">
                            Đọc tiếp
                        </a>
                    </div>
                    <div style="margin-top: 20px;margin-left: 250px">
                        @if($datapolicy != null)
                            <nav aria-label="Page navigation" style="text-align: center">
                                <b>{{$datapolicy->links() }}</b>
                            </nav>
                        @endif
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection