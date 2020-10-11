<div class="footer-v1 bg-img footer__wrap">
            <div class="footer no-margin">
                <div class="container">
                    <div class="row pt-40 pt-20 pl-3">
                        <div class="col-md-5 footer__column">
                            <div class="headline">
                                <h3 class="headline--title">
                                    About Us:
                                </h3>
                                <p class="headline--detail">
                                    {{ $data_unique[0]->about }}
                                </p>
                            </div>
                            <ul class="list-unstyled link-list">
                                <li>
                                    <a href="#">Địa chỉ: {{ $data_unique[0]->address }}</a>
                                </li>
                                <li style="color: #888">Số điện thoại: {{ $data_unique[0]->phone }}</li>
                                <li>
                                    <a href="{{ $data_unique[0]->facebook }}" class="footer__social"><i class="fa fa-facebook footer__social--icon"></i></a>
                                    <a href="{{ $data_unique[0]->instagram }}" class="footer__social"><i class="fa fa-instagram footer__social--icon"></i></a>
                                    <a href="{{ $data_unique[0]->twitter }}" class="footer__social"><i class="fa fa-twitter-square footer__social--icon"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-6 footer__column">
                            <div class="headline">
                                <h3 class="headline--title">
                                    Chính sách
                                </h3>
                            </div>
                            <ul class="list-unstyled link-list">
                            <?php $temp = 1; ?>
                                @foreach ($categorypolicy_unique as $item)
                                    <li><a href="{{ route('detailcategorypolicy', ['category'=>$item->slug_name]) }}">{{ $item->category_name }}</a></li>
                                    <?php $temp += 1; ?>
                                    @if ($temp==5)
                                        @break
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-4 col-6 footer__column">
                            <div class="headline">
                                <h3 class="headline--title">
                                    Danh mục phần mềm
                                </h3>
                            </div>
                            <ul class="list-unstyled link-list">
                                @if (!empty($categories_unique))
                                    @for ($i = 0; $i < 4; $i++)
                                    <li><a href="{{ route('getproductwithcategory', ['slug_name'=>$categories_unique[$i]->slug_name]) }}"> {{$categories_unique[$i]->category_name}} </a></li>
                                    @endfor
                                @endif
                                <a href="{{ route('shop') }}" class="footer__readmore--category"> Xem tất cả <i class="fa fa-chevron-right"></i></a>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer bottom -->
            <div class="container-fluid footer__bottom-hr">
                <div class="container">
                    <div class="row footer__bottom">
                        <div class="col-md-6 pt-20">
                            <p class="footer__coppyright">
                                Copyright © 2020 .
                            </p>
                        </div>
                        <div class="col-md-6 footer__flow pt-20">
                            <div class="footer__flow--bell">
                                <p class="footer__flow--text">
                                    Đăng ký để nhận thông tin.
                                </p>
                            </div>
                            <div class="footer__flow--box">
                                <input type="text" class="footer__flow--form" placeholder="Nhập Email của bạn ..." />
                                <button type="submit" class="footer__flow--btn">
                                    <i class="fa fa-envelope footer__flow--icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/9160225bd1.js" crossorigin="anonymous"></script>