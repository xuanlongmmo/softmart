<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
        <link type="text/css" href="{{ asset('fontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('fontend/assets/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('fontend/assets/css/theme.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('fontend/assets/css/chart.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('fontend/assets/css/font-awesome.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('fontend/assets/font-awesome/css/font-awesome.min.css') }}">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
        <!-- Include Editor style. -->
        <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="{{ route('index') }}">Home</a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav nav-icons">
                            <li><a href="{{ route('admin-contact', ['id'=>1]) }}"><i class="icon-envelope"></i></a></li>
                            <li><a href="{{ route('admin') }}"><i class="icon-eye-open"></i></a></li>
                            <li><a href="{{ route('chartweekly') }}"><i class="icon-bar-chart"></i></a></li>
                        </ul>
                        <ul class="nav pull-right">
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="https://thuthuatnhanh.com/wp-content/uploads/2020/01/hinh-anh-chat-ngau-dep.jpg" class="nav-avatar" />
                                <b class="caret"></b></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a href="{{ route('admin') }}"><i class="menu-icon icon-dashboard"></i>Dashboard</a></li>
                                <li><a href="{{ route('manageorder') }}"><i class="menu-icon icon-tasks"></i>Manager Order<b class="label orange pull-right">@if (isset($order_unique))
                                    {{number_format($order_unique)}}
                                @endif</b></a></li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#bieudo"><i class="menu-icon icon-cog"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Chart</a>
                                        <ul id="bieudo" class="collapse unstyled">
                                            <li><a href="{{ route('chartweekly') }}"><i class="menu-icon icon-bar-chart"></i>Weekly</a></li>
                                            <li><a href="{{ route('chartmonthly') }}"><i class="menu-icon icon-bar-chart"></i>Monthly</a></li>
                                            <li><a href="{{ route('chartcategories') }}"><i class="menu-icon icon-bar-chart"></i>Categories</a></li>
                                            <li><a href="{{ route('admin-chart') }}"><i class="menu-icon icon-bar-chart"></i>2 Current Years</a></li>
                                        </ul>
                                </li>
                                <li class="active"><a href="{{ route('managesection') }}"><i class="menu-icon fas fa-puzzle-piece"></i>Section</a></li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#categories"><i class="menu-icon icon-cog"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Manage Categories</a>
                                        <ul id="categories" class="collapse unstyled">
                                            <li><a href="{{ route('manageCategoriesProduct') }}"><i class="menu-icon icon-bar-chart"></i>Product</a></li>
                                            <li><a href="{{ route('managecategoriesblog') }}"><i class="menu-icon icon-bar-chart"></i>Blog</a></li>
                                        </ul>
                                </li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#banner"><i class="menu-icon fas fa-images"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Banner & Info</a>
                                        <ul id="banner" class="collapse unstyled">
                                            <li><a href="{{ route('managebanner') }}"><i class="menu-icon icon-bar-chart"></i>Image Banner</a></li>
                                            <li><a href="{{ route('listbranch') }}"><i style="margin-right:20px;margin-left:4px" class="fa fa-info" aria-hidden="true"></i>List Branch</a></li>
                                        </ul>
                                </li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#comment"><i class="menu-icon fas fa-comments"></i></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Comment & Review</a>
                                        <ul id="comment" class="collapse unstyled">
                                            <li><a href="{{ route('managereviewproduct') }}"><i class="fas fa-comments"></i> Reviews Product</a></li>
                                            <li><a href="{{ route('managecommentproduct') }}"><i class="fas fa-comments"></i></i> Comments Product</a></li>
                                            <li><a href="{{ route('managecommentblog') }}"><i class="fas fa-comments"></i> Comments Blog</a></li>
                                        </ul>
                                </li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#policy"><i class="menu-icon fas fa-comments"></i></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Policy</a>
                                        <ul id="policy" class="collapse unstyled">
                                            <li><a href="{{ route('managepolicy') }}"><i class="fas fa-comments"></i> List Posts</a></li>
                                            <li><a href="{{ route('addnewpolicy') }}"><i class="fas fa-comments"></i></i> Add new</a></li>
                                        </ul>
                                </li>
                            </ul>
                            <!--/.widget-nav-->
                            <ul class="widget widget-menu unstyled">
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#censor"><i class="menu-icon icon-cog"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Task Censor<b class="label orange pull-right">@if (isset($notifyforcensorproduct_unique))
                                        {{number_format($notifyforcensorproduct_unique + $notifyforcensornews_unique)}}
                                    @endif</b></a>
                                    <ul id="censor" class="collapse unstyled">
                                        <li><a href="{{ route('listnotacceptyetproduct') }}"><i style="margin-right: 12px" class="fa fa-check" aria-hidden="true"></i>Accept Product<b class="label orange pull-right">@if (isset($notifyforcensorproduct_unique))
                                            {{number_format($notifyforcensorproduct_unique)}}
                                        @endif</b></a></li>
                                        <li><a href="{{ route('listnotacceptyetnew') }}"><i style="margin-right: 12px" class="fa fa-check" aria-hidden="true"></i>Accept News <b class="label orange pull-right">@if (isset($notifyforcensornews_unique))
                                            {{number_format($notifyforcensornews_unique)}}
                                        @endif</b></a></li>
                                        <li><a href="{{ route('product') }}"><i style="margin-right: 12px"  class="fa fa-list" aria-hidden="true"></i>List Product </a></li>
                                        <li><a href="{{ route('listnew') }}"><i style="margin-right: 12px"  class="fa fa-list" aria-hidden="true"></i>List News </a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#ctvproduct"><i class="menu-icon icon-cog"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Task Product</a>
                                    <ul id="ctvproduct" class="collapse unstyled">
                                        <li><a href="{{ route('product') }}"><i class="menu-icon icon-edit"></i>List Product</a></li>
                                        <li><a href="{{ route('addproduct') }}"><i class="menu-icon icon-plus"></i>Add Product </a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#ctvblog"><i class="menu-icon icon-cog"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Task Blog</a>
                                    <ul id="ctvblog" class="collapse unstyled">
                                        <li><a href="{{ route('listnew') }}"><i class="menu-icon icon-edit"></i>List News</a></li>
                                        <li><a href="{{ route('addnew') }}"><i class="menu-icon icon-plus"></i>Add News</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#salemanager"><i class="menu-icon icon-cog"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Task Sale<b class="label orange pull-right">@if (isset($message_unique))
                                        {{number_format($message_unique + $notifyforsaler_unique)}}
                                    @endif</b></a>
                                    <ul id="salemanager" class="collapse unstyled">
                                        <li><a href="{{ route('admin-contact') }}"><i class="menu-icon icon-bold"></i> Message <b class="label orange pull-right">@if (isset($message_unique))
                                            {{number_format($message_unique)}}
                                        @endif</b></a></li>
                                        <li><a href="{{ route('notcontactyet') }}"><i class="menu-icon icon-tasks"></i>Contact Customer <b class="label orange pull-right">@if (isset($notifyforsaler_unique))
                                            {{number_format($notifyforsaler_unique)}}
                                        @endif</b></a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="collapsed" data-toggle="collapse" href="#accountant"><i class="menu-icon icon-cog"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Task Accountant</a>
                                    <ul id="accountant" class="collapse unstyled">
                                        <li><a href="{{ route('listctv') }}"><i class="menu-icon icon-plus"></i>List Collaborator</a></li>
                                        <li><a href="{{ route('listordercomplete') }}"><i class="menu-icon icon-edit"></i>List Order Complete</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <!--/.widget-nav-->
                            <ul class="widget widget-menu unstyled">
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages"><i class="menu-icon icon-cog">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>Users </a>
                                    <ul id="togglePages" class="collapse unstyled">
                                        <li><a href="{{ route('createsubadmin') }}"><i class="fa fa-user-plus" aria-hidden="true"></i>  Create subadmin </a></li>
                                        <li><a href="{{ route('showlistuser') }}"><i class="icon-inbox"></i>   All Users </a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('logout') }}"><i class="menu-icon icon-signout"></i>Logout </a></li>
                            </ul>
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    @yield('content')
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
                <b class="copyright">&copy; 2014 Edmin - EGrappler.com </b>All rights reserved.
            </div>
        </div>
        <script src="https://kit.fontawesome.com/9160225bd1.js" crossorigin="anonymous"></script>
        <script src="{{ asset('fontend/assets/js/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('fontend/assets/js/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('fontend/assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('fontend/assets/js/jquery.dataTables.js') }}" type="text/javascript"></script>
        <script>
            $(document).ready( function () {
                $('table').DataTable();
            } );
        </script>
        {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script> --}}
    </body>
