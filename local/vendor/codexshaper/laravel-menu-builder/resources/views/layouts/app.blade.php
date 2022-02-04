<?php
if(Auth::user()->role != 0){

}else {
header("Location: " . URL::to('/panel'), true);
?>
<script>window.location = "/panel";</script>
<?php
}


$options=App\Setting::all();
$setting = array();
foreach ($options as $option) {
    $name = $option['setting'];
    $value = $option['value'];
    $setting[$name] = $value;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>پنل مدیریتی</title>
    <!-- Favicon-->
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('icons1/icon-96x96.png')}}" type="image/x-icon">


    <!-- Google Fonts -->

    <link rel="stylesheet" type="text/css" href="{{asset('js/timer/css/flipclock.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('js/timer/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('js/timer/css/styletimer.css')}}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('plugins/node-waves/waves.css')}}" rel="stylesheet"/>

    <!-- Animation Css -->
    <link href="{{asset('plugins/animate-css/animate.css')}}" rel="stylesheet"/>

    <!-- Sweet Alert Css -->
    <link href="{{asset('plugins/sweetalert/sweetalert.css')}}" rel="stylesheet"/>

    <link href="{{asset('plugins/waitme/waitMe.css')}}" rel="stylesheet"/>

    <link href="{{asset('plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet"/>
    <link href="{{asset('plugins/light-gallery/css/lightgallery.css')}}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{asset('css/newcss/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-rtl.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('css/themes/all-themes.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/element.style.css')}}" rel="stylesheet"/>

    <link href="{{asset('js/sweetAlert2/dark.css')}}" rel="stylesheet">

    <link rel="manifest" href="{{asset('manifest.json')}}">


    <link rel="manifest" href="{{asset('manifest.json')}}">
    <meta name="apple-mobile-web-app-status-bar" content="#3d7d38">
    <meta name="theme-color" content="#3d7d38">

    <!-- PersianDateTimePicker Css-->
    {{--    <link href="{{asset('js/plugins/jalali-date/jquery.Bootstrap-PersianDateTimePicker.css')}}" media="all" rel="stylesheet" type="text/css" />--}}


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{--    <script src="{{asset('js/plugins/jalali-date/jquery-1.12.js')}}"></script>--}}{{--  یادم باشه حذف کنم--}}


    <link href="{{asset('css/myStyle.css')}}" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.14.1/plugins/codesnippet/lib/highlight/styles/atelier-dune.light.min.css"
          integrity="sha256-kVA59VvsK3cgJIpBJMuglsRvdPwmX7unAp+OUuGNHVc=" crossorigin="anonymous"/>
    <link href="{{ menu_asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ menu_asset('css/menu.css') }}" rel="stylesheet">
    <link href="{{ menu_asset('css/style.css') }}" rel="stylesheet">
    @yield('style_link')
    <style>
        table th{
            text-align: center;
        }
        @media (max-width: 767px){
            .navbar .navbar-header {
                display: inline-block;
                margin-bottom: 1px;
            }
        }
        .waitMe_container .waitMe * {
            font-family: Vazir !important;
            font-size: 10px;
        }

        .ls-closed .bars:before {
            content: 'dashboard';
            z-index: 100;
        }


        .theme-red .sidebar .legal .copyright a {
            color: #fff !important;
        }

        .sidebar .legal {
            padding: 14px;
        }

        .theme-red .bars {
            color: #000;
        }

        .ls-closed .bars:before {
            content: 'menu' !important;
        }

        .theme-red .bars {
            color: #9a9a9a;
        }

        .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
            background-color: #61c579;
            border-color: #61c579;
        }


        /****** tiny editor ********/
        span.tox-statusbar__branding {
            display: none;
        }
        .tox .tox-menubar {
            background-color: #a181ef !important;
        }
        .tox .tox-mbtn {
            color: #ffffff !important;
        }
        .tox-toolbar__primary {
            background: #ececec !important;
            border-bottom: 1px solid #7c7c7c;
        }
        .tox .tox-edit-area__iframe {
            background-color: #dedede26 !important;
        }
        .tox-editor-header {
            border-bottom: 2px solid #cccccc !important;
        }
        /****** tiny editor ********/
        .sidebar{
            top: 60px;
            height: calc(200vh - 70px);
            background: #36404a;
        }

    </style>
    @yield('style')
</head>

<style>
    .sidebar .user-info {
        background-size: 100% 100%;
        background: unset !important;
        font-family: Vazir, sans-serif;
    }

    .ls-closed .bars:after, .ls-closed .bars:before {
        right: 20px;
        margin-left: 10px;
    }

    .ls-closed .bars:before {
        content: 'dashboard';
    }

    .btn-circle i {
        right: -1px;
        top: 3px;
    }

    .btnf {
        height: 54px;
        line-height: 2;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #777;
        border: none !important;
        box-shadow: unset !important;
    }

    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 54px;
        background: #f44336;
        z-index: 2;
    }

    footer section span {
        width: 70px;
        height: 70px;
        margin: 0 auto;
        background: #f44336;
        display: block;
        margin-top: -130px;
        border-radius: 100%;
        overflow: hidden;
    }

    footer section span a img {
        width: 79px;
        margin-right: -5px;
        margin-top: -3px;
    }

    .image-mobile {
        display: none;
        margin-left: 10px;
    }

    .content {
        margin-bottom: 80px !important;
    }

    .w-footer {
        padding-right: 300px;
    }

    @media (max-width: 767px) {
        .w-footer {
            padding-right: 0px;
        }

        .navbar-brand {
            display: none;
        }

        .image-mobile {
            float: left;
            border-radius: 100%;
            overflow: hidden;
            display: block;
        }

        .icon-780px {
            display: none;
        }

        body {
            min-height: 600px;
        }

    }

    .icon-780px {
        border-radius: 100%;
        overflow: hidden;
    }

    .menu {
        background: #36404adb;
    }


    .menu .list li a span {
        color: #fff !important;
    }
    .sidebar .menu .list a {
        color: #e91e63;
    }
    nav {
        box-shadow: 0 0 12px 1px #000;
    }

    .menu_footer_right {
        list-style: none;
        margin-top: -22px;
        padding: 0;
        margin-right: -14px;
    }

    .menu_footer_right li {
        float: right;

        padding: 0 6px;
    }

    .menu_footer_right img {
        width: 28px;
        border-radius: 100%;
        cursor: pointer;
    }

    .menu_footer_left {
        position: absolute;
        top: 1px;
        left: 2px;
        list-style: none;
        padding: 8px 0;
        height: 100%;
        line-height: 39px;
    }

    .menu_footer_left li {
        float: right;

        padding: 0 6px;
    }

    .menu_footer_left img {
        width: 28px;
        cursor: pointer;
    }


    .menu_footer_right a {
        width: 30px;
        height: 30px;
        display: inline-block;
        background-size: cover !important;
        margin-top: -7px;
        padding: 0;
    }

    .menu_footer_right a button {
        width: 100%;
        height: 100%;
        padding: 0;
        background: #d8d8d8 !important;
    }

    .menu_footer_right a button:hover, .menu_footer_right a button:focus {
        background-color: #6d9a77 !important;
    }

    .menu_footer_right a button i {
        width: 20px;
        height: 20px;
        display: inline-block;
        background-size: cover !important;

    }

    .menu_footer_left a {
        width: 30px;
        height: 30px;
        display: inline-block;
        background-size: cover !important;
        margin-top: -1px;
        padding: 0;
    }

    .menu_footer_left a button {
        width: 100%;
        height: 100%;
        padding: 0;
        background: #d8d8d8 !important;
    }

    .menu_footer_left a button:hover, .menu_footer_right a button:focus {
        background-color: #6d9a77 !important;
    }

    .menu_footer_left a button i {
        width: 20px;
        height: 20px;
        display: inline-block;
        background-size: cover !important;

    }

    .btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:focus {
        background-color: #38bcec !important;
    }

    .sidebar .user-info .info-container {
        cursor: default;
        display: block;
        position: relative;
        top: 10px;
        right: 8px;
    }


    .timer {
        width: 100%;
        position: absolute;
        direction: ltr;
        display: none;
    }

    .navbar-header {
        width: 100%;
        padding: 0 7px;
    }

    @media (max-width: 576px) {
        .respon1 {
            padding-top: 0;
        }
    }

    @media (max-width: 576px) {
        .flip-clock-wrapper {
            max-width: none;
            margin-right: auto;
        }
    }

    .efteta {
        width: 100%;
        text-align: center;
        float: right;
        margin-top: -15px;
        color: #fff;
        font-weight: 700;
    }

    .dropdown-menu ul.menu .menu-info {
        right: 5px;
        top: -6px;
    }

    .notification {
        font-family: Vazir;
    }

    .btn-circle-lg {
        border-radius: 20% !important;
    }


    .ls-closed .bars:after, .ls-closed .bars:before {
        width: 30px !important;
    }

    .sidebar .user-info .info-container .name {
        color: #ffffff;
        background: #e91e63;
        padding: 6px 12px 6px 6px;
        border-radius: 6px;
        margin-bottom: 2px;
    }

    .theme-red .sidebar .menu .list li.active > :first-child i {
        color: #fff;
    }
    .hasHoverChild::after, .hasClickChild::after{
        color: #e91e63;
    }


    .bff {
        color: #61c579;
    }
    .sidebar .user-info {
        background: url('{{asset('images/user-img-background1.jpg')}}') no-repeat no-repeat;
        background-size: cover;
    }


    body {
        background: #ececec !important;
    }

    .navbar-brand {
        padding: 0px 15px;
    }
    .sidebar .menu .list .ml-menu span {
        margin: 7px 6px 1px 0;
    }
    .navbar{
        height: 60px;
        position: fixed!important;
    }

    .sidebar .level_root > .menu_item > a:hover, .sidebar .level_root > .menu_item.active > a {
        background-color: rgb(25 107 191) !important;
    }


    .theme-red .sidebar .menu .list li.active > a {
        background-color: unset !important;
    }


    .onClick{
        background-color: #feffff;
    }
    .ml-menu .dashboard.active span{
        color: #fff!important;
    }
</style>


<body class="theme-red">
<!-- Page Loader -->
<!--<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">


        </div>

        <img style="padding-left: 60px;max-width: 200px" src="{{asset($setting['logo'])}}">
        <p>لطفا صبر کنید ...</p>
    </div>
</div>-->
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
{{--<div class="search-bar">--}}
{{--    <div class="search-icon">--}}
{{--        <i class="material-icons">search</i>--}}
{{--    </div>--}}
{{--    <input type="text" placeholder="START TYPING...">--}}
{{--    <div class="close-search">--}}
{{--        <i class="material-icons">close</i>--}}
{{--    </div>--}}
{{--</div>--}}
<!-- #END# Search Bar -->
<!-- Top Bar -->

<nav class="navbar" style="background: #36404a;">
    <div class="container-fluid">
        <div class="navbar-header">
            <!--            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>-->
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="/">
                <img width="86px" src="{{asset(Setting()['logo'])}}" alt="">
            </a>

            <div class="image-mobile">

                <img src="{{asset(Setting()['logo'])}}"
                     width="86px" alt="User"/>

            </div>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <a href="/logout" class=" waves-effect waves-block" style="position: absolute;left: 15px;color:#e91e63;display:flex" title="Link: https://mersiz.com/logout">
                <i class="material-icons">exit_to_app</i>
                <span style="margin: 3px;">خروج</span>
            </a>
            <a href="{{route('profile.index')}}">

                <div class="image">
                    @if(Auth::user()->avatar!="")
                        <label class="wimgpf"  style="cursor: pointer">
                            <img src="{{asset(Auth::user()->avatar)}}" alt="{{Auth::user()->name}}" style="width: 48px;height: 48px;border: 2px solid #61c579;" />
                        </label>
                    @else
                        <label class="wimgpf" style="cursor: pointer">
                            <img id="imgpf" style="width: 48px;height: 48px;border: 2px solid #61c579;" src="{{asset('images/profile.jpg')}}" alt="عکس پروفایل" />
                        </label>
                    @endif
                </div>

            </a>

            <div class="info-container" style="line-height: 1.7">

                <div class="name" data-toggle="dropdown"
                     aria-haspopup="true"
                     aria-expanded="false" style="font-size: 10px">{{Auth::user()->name.' '.Auth::user()->family}}</div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">

            <ul class="list scroll-box" style="height: 440px">



                <li class="education @if(@$Active=="dashboard")active @endif">
                    <a href="javascript:void(0);"
                       class="menu-toggle">
                        <i class="material-icons">av_timer</i>
                        <span>داشبورد</span>
                    </a>
                    <ul class="ml-menu">



                        <li class="dashboard @if(@$Active=="dashboard")active @endif">
                            <a href="{{route('dashboard.index')}}">
                                <i class="material-icons">av_timer</i>
                                <span>داشبورد</span>
                            </a>
                        </li>

                        @can('online_chat')
                            <li class="dashboard">
                                <a target="_blank" href="https://app.crisp.chat">
                                    <i class="material-icons">chat</i>
                                    <span>پنل چت آنلاین</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @can('users_index')
                    <li class="education @if(@$Active=="users")active @endif">
                        <a href="{{route('user-s.index')}}">
                            <i class="material-icons">people_outline</i>
                            <span>لیست کاربران</span>
                        </a>
                    </li>
                @endcan
                @can('Sending_agent')
                    <li class="education @if(@$Active=="Sending_agent")active @endif">
                        <a href="{{route('Sending-agent.index')}}">
                            <i class="material-icons">local_shipping</i>
                            <span>ثبت کد ارسال</span>
                        </a>
                    </li>
                @endcan

                @can('post_index')
                    <li class="education @if(@$Active_list=="blog")active @endif">
                        <a href="javascript:void(0);"
                           class="menu-toggle">
                            <i class="material-icons">textsms</i>
                            <span>مدیریت مطالب</span>
                        </a>
                        <ul class="ml-menu">


                            @can('post_index')
                                <li class="dashboard @if(@$Active=="posts")active @endif">
                                    <a href="{{route('posts.index')}}">
                                        <i class="material-icons">all_inclusive</i>
                                        <span>لیست مطالب</span>
                                    </a>
                                </li>
                            @endcan
                            @can('post_category_index')
                                <li class="dashboard @if(@$Active=="post_category")active @endif">
                                    <a href="{{route('PostCategory.index')}}">
                                        <i class="material-icons">list</i>
                                        <span>دسته بندی مطالب</span>
                                    </a>
                                </li>
                            @endcan
                            @can('comment_services_index')
                                <li class="dashboard @if(@$Active=="comment_services")active @endif">
                                    <a href="{{route('comment-post.index')}}">
                                        <i class="material-icons">chat_bubble</i>
                                        <span>مدیریت نظرات</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan



                @can('products')
                    <li class="education @if(@$Active_list=="products")active @endif">
                        <a href="javascript:void(0);"
                           class="menu-toggle">
                            <i class="material-icons">shopping_cart</i>
                            <span>مدیریت محصولات</span>
                        </a>
                        <ul class="ml-menu">
                            @can('products_index')
                                <li class="dashboard @if(@$Active=="products")active @endif">
                                    <a href="{{route('products.index')}}">
                                        <i class="material-icons">all_inclusive</i>
                                        <span>لیست محصولات</span>
                                    </a>
                                </li>
                            @endcan
                            @can('products_category')
                                <li class="dashboard @if(@$Active=="category")active @endif">
                                    <a href="{{route('categories.index')}}">
                                        <i class="material-icons">list</i>
                                        <span>دسته بندی محصولات</span>
                                    </a>
                                </li>
                            @endcan
                            @can('products_attr')
                                <li class="dashboard @if(@$Active=="attribute")active @endif">
                                    <a href="{{route('attribute.index')}}">
                                        <i class="material-icons">kitchen</i>
                                        <span>مدیریت ویژگی ها</span>
                                    </a>
                                </li>

                            @endcan
                            @can('add_excel_product')
                                <li class="dashboard @if(@$Active=="insert-excel")active @endif">
                                    <a href="{{route('product.add-excel')}}">
                                        <i class="material-icons">add_shopping_cart</i>
                                        <span>افزودن محصول از فایل</span>
                                    </a>
                                </li>

                            @endcan

                            @can('products_order')
                                <li class="dashboard @if(@$Active=="orders")active @endif">
                                    <a href="{{route('orders-product.index')}}">
                                        <i class="material-icons">payment</i>
                                        <span>مدیریت سفارشات</span>
                                    </a>
                                </li>
                            @endcan
                            @can('products_order')
                                <li class="dashboard @if(@$Active=="reservation")active @endif">
                                    <a href="{{route('orders-reservation.index')}}">
                                        <i class="material-icons">assignment_turned_in</i>
                                        <span>لیست محصولات رزرو شده</span>
                                    </a>
                                </li>
                            @endcan
                            @can('products_comment')
                                <li class="dashboard @if(@$Active=="comment")active @endif">
                                    <a href="{{route('comment-product.index')}}">
                                        <i class="material-icons">chat_bubble</i>
                                        <span>مدیریت نظرات</span>
                                    </a>
                                </li>
                            @endcan
                            @can('RequestQuantity')
                                <li class="dashboard @if(@$Active=="RequestQuantity")active @endif">
                                    <a href="{{route('RequestQuantity.index')}}">
                                        <i class="material-icons">unarchive</i>
                                        <span>درخواست های محصول</span>
                                    </a>
                                </li>
                            @endcan
                            @can('special')
                                <li class="dashboard @if(@$Active=="special")active @endif">
                                    <a href="{{route('special.index')}}">
                                        <i class="material-icons">developer_board</i>
                                        <span>مدیریت محصولات سبدروز</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan



                @can('tool')
                    <li class="education active ">
                        <a href="javascript:void(0);"
                           class="menu-toggle">
                            <i class="material-icons">build</i>
                            <span> ابزارها</span>
                        </a>
                        <ul class="ml-menu">
                            @can('menu')
                                <li class="dashboard active ">
                                    <a href="/admin/menu/builder/3">
                                        <i class="material-icons">list</i>
                                        <span>سازنده منو</span>
                                    </a>
                                </li>
                            @endcan
                            @can('news')
                                <li class="dashboard @if(@$Active=="news")active @endif">
                                    <a href="{{route('news.index')}}">
                                        <i class="material-icons">chrome_reader_mode</i>
                                        <span>لیست خبر ها</span>
                                    </a>
                                </li>
                            @endcan
                            @can('admins_index')

                                <li class="dashboard @if(@$Active=="admins")active @endif">
                                    <a href="{{route('admins.index')}}">
                                        <i class="material-icons">account_box</i>
                                        <span>لیست مدیران</span>
                                    </a>
                                </li>
                            @endcan
                            @can('clubs_index')

                                <li class="dashboard @if(@$Active=="clubs")active @endif">
                                    <a href="{{route('clubs.index')}}">
                                        <i class="material-icons">hot_tub</i>
                                        <span>باشگاه مشتریان</span>
                                    </a>
                                </li>
                            @endcan
                            @can('slider')
                                <li class="dashboard @if(@$Active=="sliders")active @endif">
                                    <a href="{{route('sliders.index')}}">
                                        <i class="material-icons">photo_size_select_actual</i>
                                        <span>اسلایدر</span>
                                    </a>
                                </li>
                            @endcan
                            @can('banner')
                                <li class="dashboard @if(@$Active=="banners")active @endif">
                                    <a href="{{route('banners.index')}}">
                                        <i class="material-icons">picture_in_picture</i>
                                        <span>مدیریت بنر سایت</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Proposal-image')
                                <li class="dashboard @if(@$Active=="Proposal-image")active @endif">
                                    <a href="{{route('Proposal-image.index')}}">
                                        <i class="material-icons">satellite</i>
                                        <span>مدیریت بنر پایین سایت</span>
                                    </a>
                                </li>
                            @endcan
                            @can('brands')
                                <li class="dashboard @if(@$Active=="brands")active @endif">
                                    <a href="{{route('brands.index')}}">
                                        <i class="material-icons">picture_in_picture</i>
                                        <span>برندها</span>
                                    </a>
                                </li>
                            @endcan

                            @can('alerts')
                                <li class="dashboard @if(@$Active=="alerts")active @endif">
                                    <a href="{{route('alerts.index')}}">
                                        <i class="material-icons">add_alert</i>
                                        <span>مدیریت اعلان</span>
                                    </a>
                                </li>
                            @endcan
                            @can('discountcodes')
                                <li class="dashboard @if(@$Active=="discountcodes")active @endif">
                                    <a href="{{route('discountcodes.index')}}">
                                        <i class="material-icons">confirmation_number</i>
                                        <span>کد تخفیف</span>
                                    </a>
                                </li>
                            @endcan
                            @can('messages')
                                <li class="dashboard @if(@$Active=="messages")active @endif">
                                    <a href="{{route('messages.index')}}">
                                        <i class="material-icons">add_alert</i>
                                        <span>پیغام ها</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('other_page')
                    <li class="education @if(@$Active_list=="other_page")active @endif">
                        <a href="javascript:void(0);"
                           class="menu-toggle">
                            <i class="material-icons">content_copy</i>
                            <span>صفحات</span>
                        </a>
                        <ul class="ml-menu">


                            @can('about_index')
                                <li class="dashboard @if(@$Active=="about")active @endif">
                                    <a href="{{route('about.index')}}">
                                        <i class="material-icons">camera_front</i>
                                        <span>درباره ما</span>
                                    </a>
                                </li>
                            @endcan
                            @can('privacy_index')
                                <li class="dashboard @if(@$Active=="privacy")active @endif">
                                    <a href="{{route('privacy.index')}}">
                                        <i class="material-icons">lock_outline</i>
                                        <span>قوانین و مقررات</span>
                                    </a>
                                </li>
                            @endcan
                            @can('returnpolicy')
                                <li class="dashboard @if(@$Active=="returnpolicy")active @endif">
                                    <a href="{{route('returnpolicy.index')}}">
                                        <i class="material-icons">rotate_90_degrees_ccw</i>
                                        <span>شرایط مرجوعی کالا</span>
                                    </a>
                                </li>
                            @endcan
                            @can('transferpolicy')
                                <li class="dashboard @if(@$Active=="transferpolicy")active @endif">
                                    <a href="{{route('transferpolicy.index')}}">
                                        <i class="material-icons">local_shipping</i>
                                        <span>شرایط حمل و نقل</span>
                                    </a>
                                </li>
                            @endcan
                            @can('guide_index')
                                <li class="dashboard @if(@$Active=="guide")active @endif">
                                    <a href="{{route('guide.index')}}">
                                        <i class="material-icons">help</i>
                                        <span>راهنمای سایت</span>
                                    </a>
                                </li>
                            @endcan
                            @can('contact_index')
                                <li class="dashboard @if(@$Active=="contact")active @endif">
                                    <a href="{{route('contact.index')}}">
                                        <i class="material-icons">perm_contact_calendar</i>
                                        <span>تماس باما</span>
                                    </a>
                                </li>
                            @endcan
                            @can('post_index')
                                <li class="dashboard @if(@$Active=="faq")active @endif">
                                    <a href="{{route('faq.index')}}">
                                        <i class="material-icons">question_answer</i>
                                        <span>سوالات متداول</span>
                                    </a>
                                </li>
                            @endcan
                            @can('complain_index')
                                <li class="dashboard @if(@$Active=="complain")active @endif">
                                    <a href="{{route('complain.index')}}">
                                        <i class="material-icons">sms</i>
                                        <span>شکایات و پیشنهادات</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan


                @can('setting')
                    <li class="education @if(@$Active_list=="settings")active @endif">
                        <a href="{{route('settings.index')}}">
                            <i class="material-icons">settings_applications</i>
                            <span>تنظیمات</span>
                        </a>
                    </li>
                @endcan
                <li style="display: block">
                    <a href="{{route('logout')}}">
                        <i class="material-icons">exit_to_app</i>
                        <span>خروج</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
    {{--<div class="legal" style="background: #61c579;">
        <div class="copyright" align="center">
            <a href="javascript:void(0);">وحدت رویاها | پنل کسب درآمد</a>
        </div>
        <div class="version">

        </div>
    </div>--}}
    <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#skins"
                                                      data-toggle="tab">SKINS</a>
            </li>
            <li role="presentation"><a href="#settings"
                                       data-toggle="tab">SETTINGS</a>
            </li>
        </ul>

    </aside>
    <!-- #END# Right Sidebar -->
</section>
{{--@if(auth()->user()->id == 118)--}}
<section class="content" id="app">


    @yield('Admin_content')



    {{--    <audio id="audio"--}}
    {{--           src="{{asset('sound/stardust_planetaryperc.mp3')}}"></audio>--}}
    {{--    <audio id="back_audio"--}}
    {{--           src="{{asset('sound/backsound.mp3')}}"></audio>--}}
    {{--    <audio id="menu_audio"--}}
    {{--           src="{{asset('sound/node43123.mp3')}}"></audio>--}}
</section>
{{--@else--}}
{{--    <section class="content">--}}
{{--        <div class="row clearfix">--}}
{{--            <div class="col-lg-12">--}}
{{--                <div class="alert bg-red">--}}
{{--                    سایت در حال بازسازی است لطفا ساعاتی دیگر مراجعه کنید.--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--@endif--}}
{{--<footer style="background: #ffffff">
    <div class="w-footer" style="display: flex;justify-content: space-between">
        <a style="margin-top: unset;" href="{{route('profile.index')}}" type="button" class="btn btn-default waves-effect waves-green btnf"><i
                class="material-icons bff">person</i><span>پروفایل</span></a>
        <a style="margin-top: unset;" href="" type="button" class="btn btn-default waves-effect waves-green btnf"><i
                class="material-icons bff">credit_card</i><span>کیف پول</span></a>
        <a style="margin-top: unset;" href="{{route('products.index')}}" type="button" class="btn btn-default waves-effect waves-green btnf"><i
                class="material-icons bff">shopping_cart</i><span>فروشگاه</span></a>
        <a style="margin-top: unset;" type="button" class="btn btn-default waves-effect waves-green btnf"><i
                class="material-icons bff">view_quilt</i><span>سرویس ها</span></a>

    </div>


</footer>--}}

<div class="sound_all">

</div>
<!-- Jquery Core Js -->
@if(@$jquery_min)
    <?= $jquery_min ?>
@else
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
@endif

<!-- Autosize Plugin Js -->
<script src="{{asset('js/plugins/autosize/autosize.js')}}"></script>

<script type="text/javascript" src="{{asset('js/plugins/jalali-date/jalaali.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/jalali-date/jquery.Bootstrap-PersianDateTimePicker.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{asset('js/pages/ui/notifications.js')}}"></script>

<script src="{{asset('plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
<script
        src="{{asset('plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Select Plugin Js -->
<script
        src="{{asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

<!-- Slimscroll Plugin Js -->
<script
        src="{{asset('plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- JQuery Steps Plugin Js -->
<script
        src="{{asset('plugins/jquery-steps/jquery.steps.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{asset('plugins/node-waves/waves.js')}}"></script>

<script
        src="{{asset('plugins/light-gallery/js/lightgallery-all.js')}}"></script>

<script src="{{asset('js/sweetAlert2/cdn.jsdelivr.js')}}"></script>

<!-- Custom Js -->
<script
        src="{{asset('js/pages/medias/image-gallery.js')}}"></script>

<!-- Custom Js -->


<!-- form-wizard -->
<script
        src="{{asset('js/pages/forms/basic-form-elements.js')}}"></script>

<script src="{{asset('js/pages/index.js')}}"></script>


<!-- Demo Js -->
<script src="{{asset('js/demo.js')}}"></script>

<script src="{{asset('plugins/waitme/waitMe.js')}}"></script>


<script src="{{ menu_asset('js/app.js') }}" ></script>
<script src="{{ menu_asset('js/bootstrap-material-design.min.js') }}" ></script>


<script src="{{ menu_asset('js/menu.js') }}" ></script>
<script src="{{asset('js/admin.js')}}"></script>
@yield('script_link')

<script src="https://cdn.tiny.cloud/1/inonp8t254w8sel7wlmm5ao97wm5lgdlwy5d6hdpx4eftxew/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor1',
        plugins: 'autolink lists media table',
        toolbar: 'addcomment showcomments code table',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        language:'fa',
        height:400
        // skin: 'oxide-dark',
        // content_css: 'dark'
    });
</script>

<script>

</script>
@yield('script')



</body>

</html>











