@php
    $options=App\Setting::all();
    $setting = array();
        foreach ($options as $option) {
            $name = $option['setting'];
            $value = $option['value'];
            $setting[$name] = $value;
        }



$carts = Gloudemans\Shoppingcart\Facades\Cart::content();
$countcart = Gloudemans\Shoppingcart\Facades\Cart::content()->count();
$total_price = Gloudemans\Shoppingcart\Facades\Cart::subtotal(00);
if(!isset($countcart)){
    $countcart = 0;
}
if(!isset($total_price)){
    $total_price = 0;
}
$total_discount=[];
$price=[];
foreach ($carts as $cart){
if ($cart->options->old_price!="" or $cart->options->old_price!=0){
    $total_discount[]=($cart->options->old_price*$cart->qty);
    $price[]=$cart->price*$cart->qty;
}
}

@endphp


    <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


    <title>{{@$title}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="">
    <meta name="description"
          content="{{@$seo_content}}">
    <meta name="keywords"
          content="{{@$seo_title}}">
    <link rel="apple-touch-icon" href="{{asset(setting()['logo'])}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset(setting()['logo'])}}">

    <link rel="icon" type="image/png" sizes="32x32"
          href="{{asset(setting()['logo'])}}">
    <!--style must be included in all page-->
    <link rel="stylesheet" href="{{asset('assets/css/alertify.rtl.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/default.rtl.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/materialdesignicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/materialdesignicons.css.map')}}">

    @yield('style_link')
    <link href="{{asset('assets/css/fontawesome.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/btncollapzion/collapzion.min.css')}}">
    <!--style must be included in all page end-->

    @php $agent=new Jenssegers\Agent\Agent();@endphp
    @if ($agent->isMobile())
        <link class="style-link" href="{{asset('assets/css/style.mobile.min.css')}}" rel="stylesheet">
    @else
        <link class="style-link" href="{{asset('assets/css/style.min.css')}}" rel="stylesheet">
    @endif




<!-- Google Tag Manager -->

    @yield('style')
</head>

<body data-device-type="desktop" data-controller="home">
    @shortcodes



<style>
    span,p,div,h1,h2,h3,h4,h5,h6{
        font-family: IRANSans, iranyekan, sans-serif !important;
    }
    .scroll-box {
        --scrollbarBG: #b1158f1f;
        --thumbBG: #35ccde6b;
    }

    .scroll-box::-webkit-scrollbar {
        width: 6px;
        display: none;
    }
    .scroll-box:hover::-webkit-scrollbar{
        display: block;
    }
    .scroll-box {
        scrollbar-width: thin;
        scrollbar-color: var(--thumbBG) var(--scrollbarBG);
    }
    .scroll-box::-webkit-scrollbar-track {
        background: var(--scrollbarBG);
    }
    .scroll-box::-webkit-scrollbar-thumb {
        background-color: var(--thumbBG) ;
        border-radius: 6px;
        border: 3px solid var(--scrollbarBG);
    }


    .scroll-box {
        max-height: 100%;
        overflow-y: auto;
        max-width: 100%;
        margin: 0 auto;
    }
    #fixedElement {
        position: sticky;
        top: 0;
        z-index: 1020;
    }

    @media screen and (max-width: 990px) {
        .navbar {
            display: none !important;
        }
    }

    footer .row{
        display:flex;
        padding: unset!important;
    }
    @if ($agent->isMobile())
        .c-adplacement__item {
        margin: 0;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-background-size: auto 100%;
        background-size: auto 100%;
        height: 35px;
        width: 100%;
        display: block;
        background-position: 50%;
        background-repeat: no-repeat;
    }
    

    @else
    .c-adplacement__item {
        margin: 0;
        height: 60px;
        border-radius: 0;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: 50%;
        width: 100%;
        display: block;
    }
    @endif
    .bell-icon-index{
            position: absolute;
            right: -43px;
            top: 0;
            width: 50px;
            display: block;
            height: 50px;
            cursor: pointer;

        }
    .call-icon{
        width: 54px!important;
        height: 54px!important;
        border-radius: 54px!important;
        display: block!important;
        border-radius: 60px!important;
        box-shadow: 0 4px 10px 0 rgba(0,0,0,.04)!important;
        transition: transform .15s ease-in-out!important;
        background-color: #B521CF !important;
        cursor: pointer!important;
        font-size: 23px!important;
        font-weight: 400!important;
        -webkit-font-smoothing: subpixel-antialiased!important;
        -moz-osx-font-smoothing: auto!important;
        margin: 0!important;
        padding: 0!important;
        user-select: none!important;
        left: 16px;
        bottom: 14px;
        position: fixed;
        text-align: center;
        line-height: 54px;
        color: #fff;
        z-index: 999;

    }
</style>

<div class="page-loading active" style="display: none;">
    <div class="page-loading-box">
        <img src="{{asset(setting()['logo'])}}"
             class="page-loading-logo" alt="site logo">
        <!--        <img src="assets/img/logo.svg"
                     class="page-loading-loader" alt="site logo">-->
    </div>
</div>

    <?php $banner=\App\Banner::where(['position'=>'top','status'=>'Show'])->first() ?>
    @if($banner)
        <a class="c-adplacement__item" href="{{$banner->link}}" style="background-image: url({{asset($banner->imgPath)}})">

        </a>
    @endif

<div id="fixedElement">
    <!--responsive header-->
    <header class="d-block d-lg-none sticky-top responsive">

        <!--navbar top-->
<!--        <div class="bg-gray-50 py-8">
            <div class="container">
                <div class="d-flex align-items-center">

                    &lt;!&ndash;logo&ndash;&gt;
                    <a href="/" class="ml-auto d-block">
                        <img src="{{asset(setting()['logo'])}}"
                             height="36" alt="{{@$title}} ">
                    </a>
                    &lt;!&ndash;logo end&ndash;&gt;

                </div>
            </div>
        </div>-->
        <!--navbar top end-->
        <!--navbar search-->
        <div class="bg-white py-8">
            <div class="container d-flex align-items-center ">

                <!--categories-->
                <div class="ml-auto">
                    <button class="btn btn-icon btn-icon-dark" type="button" id="offcanvas-trigger-menu"><i
                            class="ico ico-menu"></i></button>
                </div>
                <!--categories end-->
                <!--login - shopping cart-->
                <div class="mr-auto d-flex align-items-center">
                    <!--login dropdown-->
                    @if (Auth::user())
                        <div class="dropdown ml-16">
                              <a class="bell-icon-index" href="/profile/messages"  style="top:-6px;background: url({{asset('images/unnamed.gif')}});background-size: 150% 110%;background-position: center;"></a>
                            <button class="btn btn-flat-dark bg-white dropdown-toggle" type="button" id="dropdownLogin"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="ico ico-user ico-fw-0"></i><span
                                    class=" d-xl-inline mr-8">@if (Auth::user()->name!="" or Auth::user()->family!="") {{Auth::user()->name.' '.Auth::user()->family}} @else {{Auth::user()->mobile}} @endif</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLogin"
                                 x-placement="bottom-end"
                                 style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(165px, 48px, 0px);">
                                <a class="dropdown-item" href="/profile"><i class="ico ico-user ico-fw-left-lg "></i>حساب
                                    کاربری</a>
                                <a class="dropdown-item" href="/profile/orders"><i
                                        class="ico ico-bag ico-fw-left-lg "></i>تاریخچه خرید</a>
                                <a class="dropdown-item" href="/logout"><i style="font-size: 20px;color: #0000009c;"
                                                                           class="fas fa-sign-out-alt ico-fw-left-lg"></i>خروج</a>
                            </div>
                        </div>
                    @else
                        <div class="dropdown ml-16 login-dropdown">
                            
                            <button class="btn btn-flat-dark bg-white dropdown-toggle btn-flat-dark" type="button"
                                    id="dropdownLogin" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class=" d-xl-inline mr-8">ورود / عضویت</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLogin"
                                 x-placement="bottom-end"
                                 style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(165px, 48px, 0px);">
                                <a class="dropdown-item" href="/login"><i style="margin-right: 6px;"
                                                                          class="fas fa-user ico-fw-left-lg"></i>وارد
                                    شوید </a>
                                <a class="dropdown-item" href="/register"><i
                                        class="fas fa-user-plus ico-fw-left-lg"></i>ثبت نام کنید</a>
                            </div>
                        </div>
                @endif

                <!--login dropdown end-->
                    <!--shopping cart-->
                    <!--shopping cart-->
                    <a class="btn btn-outline-primary btn-shopping-bag px-24" href="/cart">
                        <div class="shopping-bag-item topCartCount">{{$countcart}}</div>
                        <i class="ico ico-bag filter-primary ico-24px ico-fw-0"></i><span
                            class="d-none d-xl-inline mr-8"></span>
                    </a>
                    <!--shopping cart end-->


                </div>
                <!--login - shopping cart end-->

            </div>
        </div>
        <!--navbar search end-->

        <div class="bg-white py-8">
            <!--search-->
            <div class="container">
<!--                <form action="" data-action="" id="frmSearch-2" autocomplete="off"
                      class="search-box">-->
                    <!--search box text input-->
                    <div class="input-group total-search-input">
                        <img src="{{asset('assets/img/main_search_icon.svg')}}"
                             alt="search_icon" style="width:18px;height:18px;position: absolute;top: 9px;right: 9px;z-index: 1;">
                        <input autocomplete="off" name="keyword" onkeyup="search(this)" style="padding-right: 33px;border-radius:5px;border:1px solid rgb(144 32 146)" type="text" id="search-field-2" class="form-control"
                               placeholder="برند، کالا و یا دسته بندی مورد نظر خود را جستجو کنید">

                        <input name="sort" type="hidden" value="7">

                    </div>
                    <!--search box text input end-->
                    <!--search box dropdown-->
                    <div class="search-result search-box-dropdown " style="font-size:14px;max-height: 200px;overflow-y: auto;">
                        <div class="scrolling scrollable os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-rtl os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition" style="max-height:220px; overflow-y:auto">


                            <div class="os-content-glue cate" style="width: 607px; margin: 0px; min-height: 100px;max-height: 300px;display: none">

                            </div>
                            <div class="os-padding">
                                <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll; padding-top: 9px; margin-top: -9px; padding-right: 9px; margin-right: -9px; bottom: 0px; left: 0px;">
                                    <div class="os-content search-result-category"  style="padding: 0px; height: auto; width: 100%;">

                                    </div>
                                    <div class="os-content search-result-brand" style="padding: 0px; height: auto; width: 100%;margin-top: 20px;">

                                    </div>
                                </div>
                            </div>
                            <div class=" os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable">
                                <div class="os-scrollbar-track os-scrollbar-track-off">
                                    <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0%, 0px);">
                                    </div>
                                </div>
                            </div>
                            <div class="os-scrollbar os-scrollbar-vertical">
                                <div class="os-scrollbar-track os-scrollbar-track-off">
                                    <div class="os-scrollbar-handle" style="height: 60.4396%; transform: translate(0px, 0%);"></div>
                                </div>
                            </div>
                            <div class="os-scrollbar-corner"></div>
                        </div>
                        <hr class="cate" style="display: none">
                        <div class="search-result-product">


                        </div>
                    </div>
                    <!--search box dropdown end-->

<!--                </form>-->
            </div>
            <!--search end-->
        </div>

    </header>

    <!--header-->
    <header class="d-none d-lg-block">


        <!--navbar search-->
        <div class="bg-white py-8">
            <div class="container d-flex align-items-center " style="margin: 15px 0;">

                <!--logo-->
                <a href="/" class="ml-auto">
                    <img src="{{asset($setting['logo'])}}"
                         width="110px" alt="{{{$setting['title']}}}">
                </a>
                <!--logo end-->
                <!--search-->
                <div class="mx-auto w-50-xl w-60-lg px-3">
                    <form action="" data-action="" id="frmSearch" autocomplete="off"
                          class="search-box">
                        <!--search box text input-->
                        <div
                             class="total-search-input d-flex justify-content-between align-items-center input-group form-control"
                             style="box-shadow: none; padding: 0px 0px 0px 2px; box-sizing: border-box; background: rgb(248, 248, 248);border:1px solid rgb(144 32 146);">
                            <div class="d-flex w-80 align-items-center" style="padding-right:40px">
                                <img src="{{asset('assets/img/main_search_icon.svg')}}"
                                     alt="search_icon" style="width:18px;height:18px">
                                <input autocomplete="off" name="keyword" onkeyup="search(this)" type="text" id="search-field"
                                       class="form-control shadow-none h-100" style="border:none;background:transparent"
                                       placeholder="برند، کالا و یا دسته بندی مورد نظر خود را جستجو کنید">
                                <input name="sort" type="hidden" value="7">
                            </div>
                            <div @*class="input-group-append" *@="" style="display:none">
                                <button id="search-button"
                                        class="btn d-flex justify-content-center align-content-center"
                                        style="width:101px; height:42px; font-size:14px; padding:unset 28px"
                                        type="submit">جستجو
                                </button>
                            </div>
                        </div>
                        <!--search box text input end-->
                        <!--search box dropdown-->
                        <div class="search-result search-box-dropdown " style="font-size:14px;max-height: 200px;overflow-y: auto;">
                            <div class="scrolling scrollable os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-rtl os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition" style="max-height:220px; overflow-y:auto">


                                <div class="os-content-glue cate" style="width: 607px; margin: 0px; min-height: 100px;max-height: 300px;display: none">

                                </div>
                                <div class="os-padding">
                                    <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll; padding-top: 9px; margin-top: -9px; padding-right: 9px; margin-right: -9px; bottom: 0px; left: 0px;">
                                        <div class="os-content search-result-category" style="padding: 0px; height: auto; width: 100%;">

                                        </div>
                                        <div class="os-content search-result-brand" style="padding: 0px; height: auto; width: 100%;margin-top: 20px;">

                                        </div>
                                    </div>
                                </div>
                                <div class=" os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable">
                                    <div class="os-scrollbar-track os-scrollbar-track-off">
                                        <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0%, 0px);">
                                        </div>
                                    </div>
                                </div>
                                <div class="os-scrollbar os-scrollbar-vertical">
                                    <div class="os-scrollbar-track os-scrollbar-track-off">
                                        <div class="os-scrollbar-handle" style="height: 60.4396%; transform: translate(0px, 0%);"></div>
                                    </div>
                                </div>
                                <div class="os-scrollbar-corner"></div>
                            </div>
                            <hr class="cate" style="display: none">
                            <div class="search-result-product">


                            </div>
                        </div>
                        <!--search box dropdown end-->
                    </form>
                </div>
                <!--search end-->
                <!--login - shopping cart-->
                <div class="mr-auto d-flex align-items-center">
                    <!--login dropdown-->
                    @if (Auth::user())
                        <div class="dropdown ml-16">
                            <a class="bell-icon-index" href="/profile/messages"  style="background: url({{asset('images/unnamed.gif')}});background-size: 200% 160%;background-position: center;"></a>
                            <button class="btn btn-flat-dark bg-white dropdown-toggle" type="button" id="dropdownLogin"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="ico ico-user ico-fw-0"></i><span
                                    class="d-none d-xl-inline mr-8">@if (Auth::user()->name!="" or Auth::user()->family!="") {{Auth::user()->name.' '.Auth::user()->family}} @else {{Auth::user()->mobile}} @endif</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLogin"
                                 x-placement="bottom-end"
                                 style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(165px, 48px, 0px);">
                                <a class="dropdown-item" href="/profile"><i class="ico ico-user ico-fw-left-lg "></i>حساب
                                    کاربری</a>
                                <a class="dropdown-item" href="/profile/orders"><i
                                        class="ico ico-bag ico-fw-left-lg "></i>تاریخچه خرید</a>
                                <a class="dropdown-item" href="/logout"><i style="font-size: 20px;color: #0000009c;"
                                                                           class="fas fa-sign-out-alt ico-fw-left-lg"></i>خروج</a>
                            </div>
                        </div>
                    @else
                        <div class="dropdown ml-16 login-dropdown">
                            <button class="btn btn-flat-dark bg-white dropdown-toggle btn-flat-dark" type="button"
                                    id="dropdownLogin" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="d-none d-xl-inline mr-8">ورود / عضویت</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLogin"
                                 x-placement="bottom-end"
                                 style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(165px, 48px, 0px);">
                                <a class="dropdown-item" href="/login"><i style="margin-right: 6px;"
                                                                          class="fas fa-user ico-fw-left-lg"></i>وارد
                                    شوید </a>
                                <a class="dropdown-item" href="/register"><i
                                        class="fas fa-user-plus ico-fw-left-lg"></i>ثبت نام کنید</a>
                            </div>
                        </div>

                @endif


                <!--login dropdown end-->

                    <!--shopping cart-->
                    <button class="btn btn-outline-primary btn-shopping-bag px-24" type="button"
                            id="offcanvas-trigger-cart">
                        <div class="shopping-bag-item topCartCount">{{$countcart}}</div>
                        <i class="ico ico-bag filter-primary ico-24px ico-fw-0"></i><span
                            class="d-none d-xl-inline mr-8">سبد خرید</span>
                    </button>
                    <!--shopping cart end-->

                </div>
                <!--login - shopping cart end-->

            </div>
        </div>
        <!--navbar search end-->
    </header>
    <!--header end-->
</div>

<!--navbar-->
<nav class="navbar navbar-expand-lg navbar-light bg-white p-0">
    <div class="container">
        <!--menu-->
        @menu('site-menu-top')

        <!--menu end-->
        <!--special offer-->
        <ul class="nav nav-line bg-light invisible">

            <li class="nav-line-item">
                <a href="" class="btn btn-flat-dark rounded-0"><i
                        class="ico ico-color_festival ico-fw-0"></i><span
                        class="d-none d-xl-inline mr-8">جشنواره ها</span></a>
            </li>

            <li class="nav-line-item">
                <a href="" class="btn btn-flat-dark rounded-0"><i
                        class="ico ico-color_discount ico-fw-0"></i><span
                        class="d-none d-xl-inline mr-8">تخفیف ویژه </span></a>
            </li>

        </ul>
        <!--special offer end-->
    </div>
</nav>
<!--navbar end-->


<style>
    .alertify-notifier .ajs-message.ajs-success{
        background: #396891 !important;
        color: #fff;
        padding: 10px 15px;
    }
    .total-search-input {
        border-color: #f1f1f1;
    }

    .total-search-input:hover {
        border: 1px solid #d6d6d6;
    }

    #search-button {
        background-image: linear-gradient(90deg, rgba(217, 217, 217, 1) 0%, rgba(168, 168, 168, 1) 90%);
        border: none;
        color: #fff;
    }

    .search-result::after {
        content: '';
        position: absolute;
        top: -12px;
        right: 70px;
        width: 0;
        height: 0;
        border-left: 7.5px solid transparent;
        border-right: 7.5px solid transparent;
        border-bottom: 12px solid #fff;
    }

.menu .offcanvas-scrollable{
    height: 100%;
}
</style>

<main class="">


    @yield('content')



</main>
<div data-controller="CurrentLocation"></div>
<div data-controller="ModalDialog"><!--modals ads-->
</div>

<!--footer-->
@extends('front.layout.footer')
<!--footer end-->

<div id="menu">
    <nav id="offcanvasMenu" class="offcanvas offcanvas-menu">
        <div class="offcanvas-bar bg-white">

            <div class="d-flex justify-content-end p-8">
                <button class="btn btn-icon btn-icon-dark" type="button" id="offcanvas-dismiss-menu"><i
                        class="ico ico-close"></i></button>
            </div>

            <!--offcanvas body-->
            <div class="offcanvas-body" style="display: block;height: 100%;">
                <!--logo and divider-->
                <div class="d-flex flex-column justify-content-center mt-20">

                    <a href="/" class="mx-auto w-75 text-center">
                        <img style="width: 100%" src="{{asset(setting()['logo'])}}"
                             alt="{{setting()['title'].'لوگو موبایل'}}">
                    </a>

                    <hr class="w-75 my-20">

                </div>
                <!--logo and divider end-->

                <div
                    class="offcanvas-scrollable os-host os-theme-dark os-host-rtl os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden os-host-transition" style="height: 100%;">
                    <div class="os-resize-observer-host">
                        <div class="os-resize-observer observed" style="left: auto; right: 0px;"></div>
                    </div>
                    <div class="os-size-auto-observer" style="height: calc(100% + 1px); float: right;">
                        <div class="os-resize-observer observed"></div>
                    </div>
                    <div class="os-content-glue" style="width: 269px; margin: 0px; height: 432px;"></div>
                    <div class="os-padding">
                        <div class="os-viewport os-viewport-native-scrollbars-overlaid" style="bottom: 0px; left: 0px;">
                            <div class="os-content-arrange"></div>
                            <div class="os-content" style="padding: 0px; height: auto; width: 100%;max-height: 100%;overflow: auto;">
                                <ul class="offcanvas-menu" id="menuCollapseParent">
                                    <!--drop down item-->
                                    @menu('site-menu-top')
                                    <!--drop down item end-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable">
                        <div class="os-scrollbar-track os-scrollbar-track-off">
                            <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0%, 0px);"></div>
                        </div>
                    </div>
                    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable">
                        <div class="os-scrollbar-track os-scrollbar-track-off">
                            <div class="os-scrollbar-handle" style="height: 100%; transform: translate(0px, 0%);"></div>
                        </div>
                    </div>
                    <div class="os-scrollbar-corner"></div>
                </div>
            </div>
            <!--offcanvas body end-->

        </div>
    </nav>
    <div class="offcanvas-overlay "></div>
</div>
<div id="shoppingCart">

    <!--off-canvas sidebar[responsive mode]-->
    <nav id="offcanvasCart" class="offcanvas offcanvas-cart">
        <div class="offcanvas-bar">

            <!--offcanvas header-->
            <div class="offcanvas-header offcanvas-header_shadow">

                <!--login - shopping cart-->
                <div class="d-flex align-items-center justify-content-between mb-12">
                    <!--login dropdown-->

                    @if (Auth::user())
                        <div class="dropdown ml-16">
                            <button class="btn btn-flat-dark bg-white dropdown-toggle" type="button" id="dropdownLogin"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="ico ico-user ico-fw-0"></i><span
                                    class="d-none d-xl-inline mr-8">@if (Auth::user()->name!="" or Auth::user()->family!="") {{Auth::user()->name.' '.Auth::user()->family}} @else {{Auth::user()->mobile}} @endif</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLogin"
                                 x-placement="bottom-end"
                                 style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(165px, 48px, 0px);">
                                <a class="dropdown-item" href="/profile"><i class="ico ico-user ico-fw-left-lg "></i>حساب
                                    کاربری</a>
                                <a class="dropdown-item" href="/profile/orders"><i
                                        class="ico ico-bag ico-fw-left-lg "></i>تاریخچه خرید</a>
                                <a class="dropdown-item" href="/logout"><i style="font-size: 20px;color: #0000009c;"
                                                                           class="fas fa-sign-out-alt ico-fw-left-lg"></i>خروج</a>
                            </div>
                        </div>
                    @else
                        <div class="dropdown ml-16 login-dropdown">
                            <button class="btn btn-flat-dark bg-white dropdown-toggle btn-flat-dark" type="button"
                                    id="dropdownLogin" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="d-none d-xl-inline mr-8">لطفا وارد شوید</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLogin"
                                 x-placement="bottom-end"
                                 style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(165px, 48px, 0px);">
                                <a class="dropdown-item" href="/login"><i style="margin-right: 6px;"
                                                                          class="fas fa-user ico-fw-left-lg"></i>وارد
                                    شوید </a>
                                <a class="dropdown-item" href="/register"><i
                                        class="fas fa-user-plus ico-fw-left-lg"></i>ثبت نام کنید</a>
                            </div>
                        </div>

                @endif
                <!--login dropdown end-->

                    <!--close shopping cart-->
                    <button class="btn btn-outline-primary" type="button" id="offcanvas-dismiss-cart"><i
                            class="ico ico-close"></i>بستن سبد خرید
                    </button>
                    <!--close shopping cart end-->

                </div>
                <!--login - shopping cart end-->
                <!--total price-->
                <div class="d-flex align-items-center">

                    <div class="offcanvas-header_title ml-auto">مجموع خرید</div>
                    <div class="offcanvas-header_price mr-auto">
                        <div class="offcanvas-header_price-value text-success" style="color: #662e95 !important"><span
                                id="cartOkPriceT">{{$total_price}}</span> <span
                                class="offcanvas-header_price-currency">{{setting()['currency']}}</span></div>
                    </div>
                </div>
                <!--total price end-->

            </div>
            <!--offcanvas header end-->
            <!--offcanvas body-->
            <div class="offcanvas-body">

                <div
                    class="scrollable offcanvas-scrollable os-host os-theme-dark os-host-rtl os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden os-host-transition">
                    <div class="os-resize-observer-host">
                        <div class="os-resize-observer observed" style="left: auto; right: 0px;"></div>
                    </div>
                    <div class="os-size-auto-observer" style="height: calc(100% + 1px); float: right;">
                        <div class="os-resize-observer observed"></div>
                    </div>
                    <div class="os-content-glue" style="width: 449px; margin: -16px; height: 269px;"></div>
                    <div class="os-padding">
                        <div class="os-viewport os-viewport-native-scrollbars-invisible"
                             style="bottom: 0px; left: 0px;">
                            <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
                                <div id="cartItemList">

                                    @foreach($carts as $cart)

                                        <?php $product=App\Product::find($cart->id); ?>
                                        <div class="offcanvas-product-box cart-item" id="cartItem13105">

                                            <!--del btn-->
                                            <button onclick="removecart(this,'{{$cart->rowId}}')" type="button"
                                                    class="offcanvas-product-box_delete remove-from-cart"
                                                    data-productid="13105" data-storeid="1959" data-supplier="False"><i
                                                    class="ico ico-close"></i></button>

                                            <!--product img-->
                                            <div class="offcanvas-product-box_image">
                                                @if($product->image)
                                                    @if(file_exists(public_path() . '/' . $product->image))
                                                        <img src="{{asset($product->image)}}"
                                                             data-src="{{asset($product->image)}}" class="lazy loaded"
                                                             alt="{{$cart->name}}" data-was-processed="true">
                                                    @else
                                                        <img src="{{asset('images/nopic.png')}}"
                                                             data-src="{{asset('images/nopic.png')}}" class="lazy loaded"
                                                             alt="{{$cart->name}}" data-was-processed="true">
                                                    @endif

                                                @else
                                                    <img src="{{asset('images/nopic.png')}}"
                                                         data-src="{{asset('images/nopic.png')}}" class="lazy loaded"
                                                         alt="{{$cart->name}}" data-was-processed="true">
                                                @endif

                                            </div>

                                            <div class="offcanvas-product-box_content">

                                                <!--product title-->
                                                <div
                                                    class="offcanvas-product-box_title text-truncate mb-16">{{$cart->name}}</div>

                                                <div class="d-flex align-items-end justify-content-between">

                                                    <div class="offcanvas-product-box_price">
                                                        @if ($cart->options->old_price!=0)
                                                            <del>{{number_format($cart->options->old_price)}} </del>
                                                        @endif

                                                        <div
                                                            class="offcanvas-product-box_price-value">{{number_format($cart->price)}}
                                                            <span
                                                                class="offcanvas-product-box_price-currency">{{setting()['currency']}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="d-block">
                                                        <div
                                                            class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                            <span
                                                                class="input-group-btn input-group-prepend"></span><input
                                                                type="number" value="{{$cart->qty}}" min="1"
                                                                minlength="1" readonly="readonly"
                                                                data-product-id="{{$cart->id}}"
                                                                class="numberpicker form-control" data-max="15"
                                                                data-stop="1" data-productid="13105" data-storeid="1959"
                                                                data-supplier="False"><span
                                                                class="input-group-btn input-group-append"></span></div>
                                                    </div>

                                                </div>


                                            </div>


                                        </div>
                                    @endforeach
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable">
                        <div class="os-scrollbar-track os-scrollbar-track-off">
                            <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0%, 0px);"></div>
                        </div>
                    </div>
                    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable">
                        <div class="os-scrollbar-track os-scrollbar-track-off">
                            <div class="os-scrollbar-handle" style="height: 100%; transform: translate(0px, 0%);"></div>
                        </div>
                    </div>
                    <div class="os-scrollbar-corner"></div>
                </div>

            </div>
            <!--offcanvas body end-->
            <!--offcanvas footer-->
            <div class="offcanvas-footer">
                <div class="offcanvas-cart_summery">
                    <div class="d-flex align-items-stretch justify-content-around">

                        <div class="text-center">
                            <span class="d-block mb-2">مجموع اقلام</span>
                            <div class="offcanvas-header_price">
                                <div class="offcanvas-header_price-value text-primary text-center"><span
                                        id="cartCount">{{$countcart}}</span>
                                    <span class="offcanvas-header_price-currency">مورد</span></div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <hr class="divider-vertical divider-vertical-lg">
                        </div>

                        <div class="text-center">
                            <span class="d-block mb-2">مجموع تخفیف‌ها</span>
                            <div class="offcanvas-header_price">
                                <div class="offcanvas-header_price-value text-secondary text-center"><span
                                        id="cartDiscountT">{{number_format(array_sum($total_discount)-array_sum($price))}}</span><span
                                        class="offcanvas-header_price-currency"> {{setting()['currency']}}</span></div>
                            </div>
                        </div>
                    </div>


                </div>
                @if($total_price<setting()['Atleast_buy'])
               <div id="MinimumOrderPriceId"  class="ml-16 mr-16 pl-16 pr-16 mb-8 border border-danger">
                    <div class="">
                        <small class="text-danger subtitle2">
                            حداقل مبلغ سفارش باید <strong>{{number_format(setting()['Atleast_buy'])}}</strong> تومان باشد.
                        </small>
                    </div>
                </div>
            @endif
                <a class="btn btn-primary btn-lg btn-block rounded-0"
                   href="/cart">
                    <i class="ico ico-exit ico-36px filter-white"></i>ثبت سفارش
                    &nbsp;<span>(<span
                            id="cartOkPriceT2">{{$total_price}}</span> <small>{{setting()['currency']}}</small>)</span>
                </a>
            </div>
            <!--offcanvas footer end-->

        </div>
    </nav>
    <div class="offcanvas-overlay"></div>
</div>


<script src="{{asset('assets/js/bundle.js')}}"></script>

<script src="{{asset('assets/js/fontawesome.js')}}"></script>
<script src="{{asset('assets/btncollapzion/collapzion.min.js')}}"></script>
<script src="{{asset('assets/js/alertify.min.js')}}"></script>
@yield('script_map')
@yield('script_link')

@yield('script')
    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="7da5d151-56ed-4ca8-a6c5-1aa306a42f5d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
  <script>
    function search(item){
        var value=$(item).parents('.total-search-input').find('input').val();
        if (value.length>2){
            $('.search-result').addClass('show');
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('search.input')}}';
            var data = {_token: CSRF_TOKEN, value: value};
            $.post(url, data, function (msg) {
                $('.cate').hide();
                $('.search-result-category').empty();
                $('.search-result-brand').empty();
                $('.search-result-product').empty();
                $.each(msg.products, function (index, value) {
                    $('.search-result-product').append('<li style="list-style-type:none"><a style="color:#323232" href="/product/'+value.slug+'"><span style="margin-right:18px"></span><span class="mr-12"></span><span> </span><span style="color:#323232">'+value.title+'</span></a></li>')
                });
                $.each(msg.categories, function (index, value) {
                    $('.cate').show();
                    $('.search-result-category').append('<li style="list-style-type:none">\n' +
                        '                                                <a style="color:#323232" href="/search/'+value.slug+'">\n' +
                        '                                                    <img src="{{asset('images/18.png')}}">\n' +
                        '                                                    <span class="mr-12">همه کالاهای دسته‌بندی</span>\n' +
                        '                                                    <span>\n' +
                        '                                                    </span>\n' +
                        '                                                    <span style="color:var(--secondary)">'+value.title+'</span>\n' +
                        '                                                </a>\n' +
                        '                                            </li>\n')
                });
                $.each(msg.brands, function (index, value) {
                    $('.cate').show();
                    $('.search-result-brand').append('<li style="list-style-type:none">\n' +
                        '                                                <a style="color:#323232" href="/search/brand/'+value.link+'">\n' +
                        '                                                    <img src="{{asset('images/18.png')}}">\n' +
                        '                                                    <span class="mr-12">همه کالاهای برند</span>\n' +
                        '                                                    <span>\n' +
                        '                                                    </span>\n' +
                        '                                                    <span style="color:var(--secondary)">'+value.title+'</span>\n' +
                        '                                                </a>\n' +
                        '                                            </li>\n')
                });
            });
        }else {
            $('.cate').hide();
            $('.search-result-category').empty();
            $('.search-result-product').empty();
            $('.search-result-brand').empty();
            $('.search-result').removeClass('show');
        }
    }
</script>
<script>


        $('.request-quantity').click(function () {
            var id=$(this).attr('data-productid');
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('product.request-quantity')}}';
            var data = {_token: CSRF_TOKEN, id: id};
            $.post(url, data, function (msg) {
                if (msg.msg=="ok"){
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success('درخواست شما ثبت شد');
                }else if(msg.msg=="notOk"){
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('شما قبلا درخواست خود را ثبت کرده اید');
                }
            });
        })

    setTimeout(function () {
        okala.scrollToTop();
        let b = document.getElementsByTagName('body')[0];
        let s = document.createElement("script");
        s.async = true;
        let v = !("IntersectionObserver" in window) ? "8.6.0" : "10.4.1";

        window.lazyLoadOptions = {
           elements_selector: ".lazy"
        }; // Your options here. See "recipes" for more information about async.
        b.appendChild(s);

        $("img.lazy").on("load", function () {
           $(this).nextAll('.swiper-lazy-preloader:first').remove();
        });
    }, 1000);
    function addcart(item, id) {


        $.ajax({
            type: "post",
            url: "/addcart",
            data: {
                id: id,
                _token: '{{csrf_token()}}',
            },
            dataType: 'json',
            success: function (data) {
                if (data.msg2!="notproduct") {

                    if (data.buy_limited != "yes") {
                        $('#cartItemList').html('');
                        $('.topCartCount').html(data.countcart);
                        $('#cartCount').html(data.countcart);
                        $('.minicart-total span').html(data.total);
                        $('#cartOkPriceT').html(data.total);
                        $('#cartOkPriceT2').html(data.total);
                        $('#cartDiscountT').html(data.total_discount);
                        $.each(data.msg, function (index, value) {
                            var rowId = "'" + value['rowId'].toString() + "'";
                            var url_image = value['options']['image'];
                            var img = new Image();
                            img.src = url_image;
                            if (value['options']['image']){
                                if (img.height!=0){
                                    var image_cart='<img src="' + value['options']['image'] + '" data-src="' + value['options']['image'] + '" class="lazy loaded" alt="' + value['name'] + '" data-was-processed="true">';
                                }else{
                                    var image_cart='<img src="{{asset('images/nopic.png')}}" data-src="{{asset('images/nopic.png')}}" class="lazy loaded" alt="' + value['name'] + '" data-was-processed="true">';
                                }

                            }else{
                                var image_cart='<img src="{{asset('images/nopic.png')}}" data-src="{{asset('images/nopic.png')}}" class="lazy loaded" alt="' + value['name'] + '" data-was-processed="true">';

                            }
                            $('#cartItemList').append('<div class="offcanvas-product-box cart-item" id="cartItem110" data-productid="' + value['options']['id'] + '">\n' +
                                '\n' +
                                '                            <!--del btn-->\n' +
                                '                            <button type="button" onclick="removecart(this,' + rowId + ')" class="offcanvas-product-box_delete" ><i class="ico ico-close"></i></button>\n' +
                                '\n' +
                                '                            <!--product img-->\n' +
                                '                            <div class="offcanvas-product-box_image">'+image_cart+'</div>\n' +
                                '\n' +
                                '                            <div class="offcanvas-product-box_content">\n' +
                                '\n' +
                                '                                <!--product title-->\n' +
                                '                                <div class="offcanvas-product-box_title text-truncate mb-16">' + value['name'] + '</div>\n' +
                                '\n' +
                                '                                <div class="d-flex align-items-end justify-content-between">\n' +
                                '\n' +
                                '                                    <div class="offcanvas-product-box_price">\n' +
                                '                                            <del>' + number_3_3(value['options']['old_price']) + '</del>\n' +
                                '                                        <div class="offcanvas-product-box_price-value">' + number_3_3(value['options']['price']) + '<span class="offcanvas-product-box_price-currency">{{setting()['currency']}}</span></div>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                                    <div class="d-block">\n' +
                                '                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"></span><input type="text" readonly="" value="' + value['qty'] + '" class="numberpicker form-control" data-max="10" data-stop="1" data-product-id="' + value['options']['product_id'] + '"  data-supplier="False"><span class="input-group-btn input-group-append"></span></div>\n' +
                                '                                    </div>\n' +
                                '\n' +
                                '                                </div>\n' +
                                '\n' +
                                '\n' +
                                '                            </div>\n' +
                                '\n' +
                                '\n' +
                                '                        </div>')

                        });

                        /*   $("input[name='demo3']").TouchSpin({
                               min: 1,
                           });*/


                        $('.input-group-btn button').on("click touchstart", function (event) {

                            var el = $(this).parents('.bootstrap-touchspin').find('.form-control');

                            var qyt = el.val();
                            var id = $(el).attr('data-product-id');

                            $.ajax({
                                type: "post",
                                url: "/updatecart",
                                data: {
                                    qyt: qyt,
                                    id: id,
                                    _token: '{{csrf_token()}}',
                                },
                                dataType: 'json',
                                success: function (data) {
                                    $('#cartCount').html(data.countcart);
                                    $('#cartOkPriceT2').html(data.total);

                                    alertify.set('notifier', 'position', 'bottom-left');
                                    alertify.success('سبد خرید بروزرسانی شد');
                                },
                                error: function (err) {
                                    if (err.status == 422) {
                                        $('#error_user').slideDown(100);
                                        $.each(err.responseJSON.errors, function (i, error) {
                                            $('#error_item').append($('<span style="color: white;">' + error[
                                                    0] +
                                                '</span><br>'));
                                        });
                                    }
                                }
                            });
                        });
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success('به سبد خرید اضافه شد');
                        $('.numberpicker').TouchSpin({
                            min: 1,
                            max: $(this).data('max')
                        });
                        $('.input-group-btn button').click(function () {
                            updateCart(this)
                        });
                    } else {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('کالای مورد نظر محدودیت خرید دارد');
                    }
                }else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('موجودی کالا روبه اتمام است');
                }
            },
            error: function (err) {
                if (err.status == 422) {
                    $('#error_user').slideDown(100);
                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#error_item').append($('<span style="color: white;">' + error[
                                0] +
                            '</span><br>'));
                    });
                }
            }
        });

    }
</script>
<script>
    function number_3_3(num, sep) {
        var number = typeof num === "number" ? num.toString() : num,
            separator = typeof sep === "undefined" ? ',' : sep;
        return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
    }

    function search_header() {
        var search = $('input[name=search]').val();
        $('.result-search').empty();
        if (search.length >= 3) {
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('search.search')}}';
            var data = {_token: CSRF_TOKEN, search: search};
            $.post(url, data, function (msg) {
                $('.result-search').show();
                $('.result-search').append(msg)
            });
        } else {
            $('.result-search').hide();
        }
    }
</script>
<script>
    function removecart(item, id) {
        $.ajax({
            type: "post",
            url: "/removecart",
            data: {
                id: id,
                _token: '{{csrf_token()}}',
            },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                $(item).parents('.offcanvas-product-box').remove();
                $('.topCartCount').html(data.countcart);
                $('#cartCount').html(data.countcart);
                $('#cartCount').html(data.countcart);
                $('#cartDiscountT').html(data.total_discount);
                $('#cartOkPriceT').html(data.total);
                $('#cartOkPriceT2').html(data.total);
                $('#p-t').html(data.total + ' ت ');
                alertify.set('notifier', 'position', 'top-right');
                alertify.success('محصول از سبد خرید حذف شد');
            },
            error: function (err) {
                if (err.status == 422) {
                    $('#error_user').slideDown(100);
                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#error_item').append($('<span style="color: white;">' + error[
                                0] +
                            '</span><br>'));
                    });
                }
            }
        });
    }

    $('.input-group-btn button').click(function () {
        updateCart(this)
    });

    function updateCart(item) {

        var el = $(item).parents('.bootstrap-touchspin').find('.numberpicker');
        var qyt = el.val();
        var id = $(el).attr('data-product-id');
        $.ajax({
            type: "post",
            url: "/updatecart",
            data: {
                qyt: qyt,
                id: id,
                _token: '{{csrf_token()}}',
            },
            dataType: 'json',
            success: function (data) {
                if (data.msg2!="notproduct") {
                if (data.buy_limited != "yes"){
                    $('#cartCount').html(data.countcart);
                $('#cartDiscountT').html(data.total_didcount);
                $('#cartOkPriceT').html(data.total);
                $('#cartOkPriceT2').html(data.total);
                alertify.set('notifier', 'position', 'top-right');
                alertify.success('سبد خرید بروزرسانی شد');
            }else{
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('کالای مورد نظر محدودیت خرید دارد');
                }
                }else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('موجودی کالا روبه اتمام است');
                }
            },
            error: function (err) {

                if (err.status == 422) {
                    $('#error_user').slideDown(100);
                    $.each(err.responseJSON.errors, function (i, error) {

                        $('#error_item').append($('<span style="color: white;">' + error[
                                0] +
                            '</span><br>'));
                    });
                }
            }
        });

    }
</script>
<script>


    function favorite(tag, id) {
        @if(Auth::check())
        var count = $('.openfavorites span').html();
        var CSRF_TOKEN = '{{ csrf_token() }}';
        var url = '{{route('panel.add_remove_favorite')}}';
        var data = {_token: CSRF_TOKEN, id: id};
        $.post(url, data, function (msg) {
            if (msg == "add") {
                $(tag).css('color', 'red');
                alertify.set('notifier', 'position', 'bottom-left');
                count = parseInt(count) + 1;
                $('.openfavorites span').html(count);
                alertify.success('با موفقیت به لیست علاقه مندی اضافه شد');
            } else if (msg == "deleted") {
                $(tag).css('color', '#000000');
                count = parseInt(count) - 1;
                $('.openfavorites span').html(count);
                alertify.set('notifier', 'position', 'bottom-left');
                alertify.success('با موفقیت از لیست علاقه مندی حذف شد');
            }
        });
        @else
            window.location = "/login";

        @endif
    }


</script>
<script>
     $('.offcanvas-menu .level_root > li > div > a').click(function () {
         
        var item=this;
        $('.menu-parent').attr('aria-expanded','false');
        setTimeout(function(){
             $(item).parents('.menu-li').find(' > ul.collapse').addClass('show');
            }, 100);
       
        //$(item)
    })
    
</script>

    <div id="btncollapzion" class="btncollapzion"><i class="fas fa-phone-alt btncollapzion btncollapzionicon"></i></div>
    <script>
        $('#btncollapzion').Collapzion({
            _child_attribute:[
                {
                    'label':'{{setting()['mobile']}}',
                    'url':'tel:{{setting()['mobile']}}',
                    'icon':'<i class="fas fa-phone-alt"></i>'
                }@if(setting()['mobile2']!=""),
                {
                    'label':'{{setting()['mobile2']}}',
                    'url':'tel:{{setting()['mobile2']}}',
                    'icon':'<i class="fas fa-phone-alt"></i>'
                }@endif
                @if(setting()['mobile3']!=""),
                {
                    'label':'{{setting()['mobile3']}}',
                    'url':'tel:{{setting()['mobile3']}}',
                    'icon':'<i class="fas fa-phone-alt"></i>'
                }@endif
            ],
            _main_btn_color:'#4285f4;',
            _child_btn_color:'#f4645f;',

        });
    </script>
{{-- <a href="tel:{{setting()['mobile']}}" class="call-icon"><i class="fas fa-phone-alt"></i></a>--}}

</body>
</html>



