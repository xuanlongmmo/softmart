<!-- topbar -->
<div class="container-fluid top__bar--box">
    <div class="container">
        <div class="row top__bar">
            <div class="col-md-4 top__bar-left">
                <p class="top__bar-left--phone">
                    <span class="top__bar-left--text">
                        Hotline: {{ $data_unique[0]->hotline }}
                    </span>
                    <span style="margin-left: 10px;"> Email: {{ $data_unique[0]->email }}</span>
                </p>
            </div>
            <div class="col-md-4 top__bar-middle">
            </div>
            <div  class="col-md-4 top__bar-right">
                <div class="top__bar-right--social">
                    <a href="{{ $data_unique[0]->facebook }}"><i class="fa fa-facebook"></i></a>
                    <a href="{{ $data_unique[0]->instagram }}"><i class="fa fa-instagram"></i></a>
                    <a href="{{ $data_unique[0]->twitter }}"><i class="fa fa-twitter"></i></a>
                </div>
                <div class="top__bar-right--language">

                    <span>
                        <img src="fontend/assets/img/en.png" class="img-fluid img__language" alt="USA" />
                        English
                        <i class="fa fa-angle-down"></i>
                    </span>
                </div>
                <div class="top__bar-right--language">

                    @if(Auth::check())
                        <a style="color: black" href="{{ route('account') }}"> {{strtoupper(Auth::user()->username)}} </a><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i></a>
                    @else
                        <a href="{{ route('login') }}"><i class="fas fa-user"></i></a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<!-- header-main -->
<div class="container header-main">
    <div class="row header-main">
        <!-- logo -->
        <div class="col-md-3 header__logo">
            <a href="./" class="header__logo--link">
                <img src="fontend/assets/img/90e338a0349acec4978b.jpg" class="img-fluid header__logo--img" alt="logo" />
            </a>
        </div>
        <!-- box search -->
        <div class="col-md-6 header__search">
            <div class="btn-group" style="max-height: 45px;">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Danh mục sản phẩm <span class="caret"></span></button>
                @if (!empty($categories_unique))
                    <ul class="dropdown-menu scrollable-menu" role="menu">
                        @foreach ($categories_unique as $category)
                            <li><a href="{{ route('getproductwithcategory', ['slug_name'=>$category->slug_name]) }}">{{$category->category_name}}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <form autocomplete="off" action="{{ route('search')}}" method="get">
                <div class="box__search">
                    <div>
                        <input class="autocomplete" style="width: 100%;height: 40px;" type="search" name="q" onkeyup="return search(this)" id="q" class="import__search" placeholder="Bạn muốn tìm gì ?" />
                        <div id="resultsearch" style="width: 29%;z-index: 1000;background-color: #f9f9f9;position: absolute; border-radius: 5px;"></div>
                    </div>
                    <button type="submit" class="submit__search" style="right: 160px">
                        <i class="fa fa-search submit__search--icon"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-3 header__right">
            <a href="{{ route('wishlist') }}" class="top-wishlist">
                <i class="fa fa-heart header__right--icon"></i>

                <span id="wishlist" class="header__right--number1">
                    @if(!empty(session('wishlist')))
                        {{ session('wishlist') }}
                    @else
                        0
                    @endif
                </span>
            </a>
            <a href="{{ route('getcart') }}" class="top-cart">
                <i class="fa fa-shopping-cart header__right--icon"></i>
                @if (!empty(session('countcart')))
                    <span id='countcart' class="header__right--number2">{{session('countcart')}}</span>
                @else
                    <span id="countcart" class="header__right--number2">0</span>
                @endif
                <p class="top-cart--info">
                </p>
            </a>
</div>
    </div>
</div>
<!-- menu -->
<div class="container-fluid main-menu">
    <!-- main menu -->
    <div class="container main-menu">
        <div class="row">
            <ul class="top__menu col-md-9">
                <li class="menu__item">
                    <a href="{{route('index')}}" class="menu__link menu__link--home"> Trang chủ</a>
                </li>
                <li class="menu__item">
                    <a href="{{route('shop')}}" class="menu__link"> Danh mục phần mềm </a>
                    <ul class="mega__menu">
                        <div class="row row__mega__menu">
                            @if (!empty($categories_unique))
                                <?php
                                    $totalCate = sizeOf($categories_unique);
                                    $column = $totalCate / 5;
                                    $temp = 5;
                                ?>
                                @for ($i = 0; $i < $column; $i++)
                                    <div class="col-md-4 column__mega__menu">
                                        @for ($j = $temp-5; $j < $temp; $j++)
                                            <li class="mega__menu--item">
                                                <a href="{{ route('getproductwithcategory', ['slug_name'=>$categories_unique[$j]->slug_name]) }}" class="mega__menu--link mega__menu--title">
                                                    {{$categories_unique[$j]->category_name}}
                                                </a>
                                            </li>
                                            @if ($j == $totalCate-1)
                                                @break
                                            @endif
                                        @endfor
                                    </div>
                                    <?php
                                        $temp += 5;
                                    ?>
                                @endfor
                            @endif
                        </div>
                    </ul>
                </li>
                <li class="menu__item">
                    <a href="{{route('blog')}}" class="menu__link"> Tin tức </a>
                </li>
                <li class="menu__item">
                    <a href="{{route('policy')}}" class="menu__link"> Chính sách </a>
                    <ul class="sub__menu ">
                        @foreach ($categorypolicy_unique as $item)
                            <li class="sub__menu--link">
                                <a href="{{ route('detailcategorypolicy', ['category'=>$item->slug_name]) }}" class="sub__menu--link">
                                    {{ $item->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="menu__item">
                    <a href="{{route('contact')}}" class="menu__link"> Liên hệ </a>
                </li>
            </ul>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</div>

<!-- responsive menu -->
<div class="menu-mobile clearfix">
    <button class="openbtn" onclick="openNav()">☰</button>
    <div class="menu-mobile-img">
        <img src="fontend/assets/img/90e338a0349acec4978b.jpg">
    </div>
    <div class="menu-mobile-input">
        <button><i class="fa fa-search"></i></button>

        <button><i class="fa fa-shopping-cart"></i></button>
        <span class="shop-span">10</span>
    </div>
</div>

<div id="mySidepanel" class="sidepanel">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <a href="#">Trang chủ</a>
    <button class="dropdown-btn">Danh mục
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="#">Phần mềm 1</a>
        <a href="#">Phần mềm 2</a>
        <a href="#">Phần mềm 3</a>
    </div>
    <a href="#">Tin tức</a>

    <button class="dropdown-btn">Chính sách
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="#">Bảo hành</a>
        <a href="#">Cài đặt</a>
        <a href="#">Nâng cấp</a>
        <a href="#">Gia hạn</a>
    </div>
    <a href="#">Liên hệ</a>
    <button class="dropdown-btn">Ngôn Ngữ
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
<a href="#">Vie</a>
        <a href="#">Eng</a>
    </div>
</div>