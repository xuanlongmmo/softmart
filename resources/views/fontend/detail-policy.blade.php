@extends('fontend.base')
@section('content')
<!-- content web -->
<div class="container-fluid">
    <div class="container">
        <div class="row mt-20">
            <!-- left layout -->
            <div class="col-md-4 sidebar left-layout">
                <h1 class="sidebar__headding headding__policy">
                    Chính sách của chúng tôi
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
                            <a href="" class="ct__blog--link">
                                {{ $item->category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- right layout -->
            <div class="col-md-8 article right-layout">
                    <div class="blog__box">
                        <img src="{{ $datapolicy->link_image }}" class="img-fluid blog__img" alt="">
                        <div class="entry-category">
                            <a href="" class="btn-entry">
                                {{ $datapolicy->category_policy->category_name }}
                            </a>
                        </div>
                        <h3 class="entry-title">
                            {{ $datapolicy->title }}
                        </h3>
                        <ul class="entry-meta-list">
                            <li class="entry-date">
                                <a href="" class="entry-icon">
                                    <img src="fontend/assets/img/icon-calender.png" class="entry-img" alt="">

                                </a>
                                {{ $datapolicy->created_at }}
                            </li>
                        </ul>
                    </div>
                        {!! html_entity_decode($datapolicy->content ) !!}
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection