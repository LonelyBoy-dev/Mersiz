<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{@$seo_content}}">
    <meta name="author" content="">
    <meta name="keywords" content="{{@$seo_title}}">
    <meta name="robots" content="all">
    <title>{{@$title}}</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{asset('marazzo/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('marazzo/css/bootstrap-rtl.min.css')}}">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="{{asset('marazzo/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('marazzo/css/blue.css')}}">
    <link rel="stylesheet" href="{{asset('marazzo/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('marazzo/css/owl.transitions.css')}}">
    <link rel="stylesheet" href="{{asset('marazzo/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('marazzo/css/rateit.css')}}">
    <link rel="stylesheet" href="{{asset('marazzo/css/bootstrap-select.min.css')}}">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{asset('marazzo/css/font-awesome.css')}}">
    @yield('style_link')
    @yield('style')
    <style>
        .search-area .control-group{
            border-radius: 0 50px 50px 0;
            overflow: hidden;
        }
        .result-search{
            width: 88%;
            height: 200px;
            background: #fff;
            /* margin-top: 43px; */
            overflow-y: scroll;
            z-index: 106;
            position: absolute;
            box-shadow: 1px 1px 3px 0px #ccc margin-right: 1px;
            display: none;
            overflow-x: hidden;
            margin-right: 25px;;
        }
    </style>
</head>

<body class="cnt-home">
<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">

    <!-- ============================================== TOP MENU ============================================== -->
    <div class="top-bar animate-dropdown">
        <div class="container">
            <div class="header-top-inner">
                <div class="cnt-account">
                    <ul class="list-unstyled">
                        @if(Auth::check())
                            <li class="myaccount"><a href="/panel"><span>حساب من</span></a></li>
                        @else
                            <li class="check"><a href="/login"><span> ورود</span></a></li>
                            <li class="login"><a href="/register"><span>ثبت نام</span></a></li>
                        @endif
                    </ul>
                </div>
                <!-- /.cnt-account -->


                <!-- /.cnt-cart -->
                <div class="clearfix"></div>
            </div>
            <!-- /.header-top-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.header-top -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <div class="logo"> <a href="/"> <img style="max-width: 222px" src="{{asset($setting['logo'])}}" alt="logo"> </a> </div>
                    <!-- /.logo -->
                </div>
                <!-- /.logo-holder -->

                <div class="col-lg-7 col-md-6 col-sm-8 col-xs-12 top-search-holder">
                    <!-- /.contact-row -->
                    <div class="search-area">
                        <div class="control-group">
                            <input name="search" onkeyup="search_header()" class="search-field" placeholder="جستجو در میان محصولات ..." />
                            <a onclick="search_header()" class="search-button"></a>
                        </div>
                        <div class="result-search">

                        </div>
                    </div>
                    <!-- /.search-area -->
                </div>
                <!-- /.top-search-holder -->

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 animate-dropdown top-cart-row">

                    <div class="dropdown dropdown-cart">
                        <a href="/cart" class="dropdown-toggle lnk-cart" >
                            <div class="items-cart-inner">
                                <div class="basket">
                                    <div class="basket-item-count"><span id="cart-total" class="count">{{$countcart}}</span></div>

                                </div>
                            </div>
                        </a>

                    </div>
                    <!-- /.dropdown-cart -->

                </div>
                <!-- /.top-cart-row -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

    </div>
    <!-- /.main-header -->

    <!-- ============================================== NAVBAR ============================================== -->
    <div class="header-nav animate-dropdown">
        <div class="container">
            <div class="yamm navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">تعویض ناوبری</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                </div>
                <div class="nav-bg-class">
                    <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav">
                                <li class=""> <a href="/">صفحه اصلی</a> </li>
                                @php
                                    $categories = App\Category::where('parent', '0')->get();
                                @endphp
                                @foreach($categories as $category)
                                    <li class="dropdown yamm mega-menu"> <a href="/search?cat={{$category->slug}}" data-hover="dropdown" class="dropdown-toggle" >{{$category->title}}</a>
                                        @php
                                            $categories2=App\Category::where('parent',$category->id)->get();
                                        @endphp
                                        @if(count($categories2))
                                            <ul class="dropdown-menu container">
                                                <li>
                                                    <div class="yamm-content ">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                                <?php
                                                                $i=1;
                                                                foreach($categories2 as $category2){
                                                                if ($i % 5 == 0) {

                                                                $categories3=App\Category::where('parent',$category2->id)->get();
                                                                ?>
                                                            </div>

                                                            <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                                <?php } ?>

                                                                <h2 class="title"><a href="/search?cat={{$category2->slug}}" style="padding: 0">{{$category2->title}}</a></h2>


                                                                <?php  $categories3=App\Category::where('parent',$category2->id)->get();

                                                                ?>
                                                                <ul class="links">
                                                                    <?php foreach($categories3 as $category3){?>
                                                                    <li><a href="/search?cat={{$category3->slug}}">{{$category3->title}}</a></li>
                                                                    <?php } ?>
                                                                    <?php $i++; } ?>
                                                                </ul>

                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                                <li><a href="/blog"> مقالات</a></li>
                                <li><a href="/about">درباره ما</a></li>
                                <li><a href="/contact">تماس با ما</a></li>
                            </ul>
                            <!-- /.navbar-nav -->
                            <div class="clearfix"></div>
                        </div>
                        <!-- /.nav-outer -->
                    </div>
                    <!-- /.navbar-collapse -->

                </div>
                <!-- /.nav-bg-class -->
            </div>
            <!-- /.navbar-default -->
        </div>
        <!-- /.container-class -->

    </div>
    <!-- /.header-nav -->
    <!-- ============================================== NAVBAR : END ============================================== -->

</header>

@yield('content')

<!-- ============================================================= FOOTER ============================================================= -->
<footer id="footer" class="footer color-bg">
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="address-block">

                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class="toggle-footer" style="">
                                <li class="media">
                                    <div class="pull-right"> <span class="icon fa-stack fa-lg"> <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body">
                                        <p>{{$setting['address']}}</p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="pull-right"> <span class="icon fa-stack fa-lg"> <i class="fa fa-mobile fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body">
                                        <p>{{$setting['tell']}}<br> {{$setting['mobile']}}</p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="pull-right"> <span class="icon fa-stack fa-lg"> <i class="fa fa-envelope fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body"> <span><a>{{$setting['email']}}</a></span> </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">خدمات مشتریان</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a href="/panel" title="">حساب من</a></li>
                            <li><a href="/panel/orders" title="">تاریخچه سفارشات</a></li>
                            <li><a href="/panel/favorites" title="">علاقه مندیها</a></li>
                            <li><a href="/panel/profile" title="">اطلاعات حساب</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">دسترسی سریع</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a title="Your Account" href="/">صفحه اصلی</a></li>
                            <li><a title="Information" href="/search">فروشگاه</a></li>
                            <li><a title="Addresses" href="/blog">مقالات</a></li>
                            <li><a title="Addresses" href="/about">درباره ما</a></li>
                            <li class="last"><a title="Orders History" href="/contact">تماس با ما</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">امروز به ما بپیوندید</h4>
                    </div>
                    <!-- /.module-heading -->
                    <div class="col-xs-12 col-sm-4 no-padding social">
                        <ul class="link" style="display: flex">
                            @if($setting['facebook']!="")
                                <li class="fb pull-right"><a target="_blank" rel="nofollow" href="{{$setting['facebook']}}" title="Facebook"></a></li>
                            @endif
                            @if($setting['twitter']!="")
                                <li class="tw pull-right"><a target="_blank" rel="nofollow" href="{{$setting['twitter']}}" title="Twitter"></a></li>
                            @endif
                            @if($setting['instagram']!="")
                                <li class="insta pull-right"><a target="_blank" rel="nofollow" href="{{$setting['instagram']}}" title="instagram"></a></li>
                            @endif
                            @if($setting['telegram']!="")
                                <li class="tel pull-right"><a target="_blank" rel="nofollow" href="{{$setting['telegram']}}" title="telegram"></a></li>
                            @endif
                        </ul>
                    </div>

                    <!-- /.module-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-bar">
        <div class="container">

            <div class="col-xs-12 col-sm-4 no-padding copyright" style="width: 100%;text-align: center">طراحی و توسعه توسط شرکت <a target="_blank" href="https://imtit.com">فناوری ریزپردازنده فراهوش</a></div>

        </div>
    </div>
</footer>
<!-- ============================================================= FOOTER : END============================================================= -->

<!-- For demo purposes – can be removed on production -->

<!-- For demo purposes – can be removed on production : End -->

<!-- JavaScripts placed at the end of the document so the pages load faster -->
<script src="{{asset('marazzo/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('marazzo/js/bootstrap.min.js')}}"></script>
<script src="{{asset('marazzo/js/bootstrap-hover-dropdown.min.js')}}"></script>
<script src="{{asset('marazzo/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('marazzo/js/echo.min.js')}}"></script>
<script src="{{asset('marazzo/js/jquery.easing-1.3.min.js')}}"></script>
<script src="{{asset('marazzo/js/bootstrap-slider.min.js')}}"></script>
<script src="{{asset('marazzo/js/jquery.rateit.min.js')}}"></script>
<script src="{{asset('marazzo/js/lightbox.min.js')}}"></script>
<script src="{{asset('marazzo/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('marazzo/js/wow.min.js')}}"></script>
<script src="{{asset('marazzo/js/scripts.js')}}"></script>

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>


@yield('script_link')
@yield('script')
<script>
    function number_3_3(num, sep) {
        var number = typeof num === "number" ? num.toString() : num,
            separator = typeof sep === "undefined" ? ',' : sep;
        return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
    }

    function search_header() {
        var search=$('input[name=search]').val();
        $('.result-search').empty();
        if (search.length>=3){
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('search.search')}}';
            var data = {_token: CSRF_TOKEN,search:search};
            $.post(url, data, function (msg) {
                $('.result-search').show();
                $('.result-search').append(msg)
            });
        }else{
            $('.result-search').hide();
        }
    }
    $('main').click(function () {
        $('.result-search').empty();
        $('.result-search').hide();
    })
    $('.header').click(function () {
        $('.result-search').empty();
        $('.result-search').hide();
    })

    function header(header) {
        window.location.replace(header);
    }
</script>
<script>

    function openNav() {
        document.getElementById("mySidenav").style.width = "320px";
        $('.humberger__menu__overlay').addClass('active');
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        $('.humberger__menu__overlay').removeClass('active')
    }

    $('.humberger__menu__overlay').click(function () {
        document.getElementById("mySidenav").style.width = "0";
    })
    /*   $("input[name='demo3']").TouchSpin({
           min: 1,
       });*/

</script>
<script>

    function addcart(item, id) {

        $('.carts_table').html('');
        $.ajax({
            type: "post",
            url: "/addcart",
            data: {
                id: id,
                _token: '{{csrf_token()}}',
            },
            dataType: 'json',
            success: function (data) {
                $('#cart-total').html(data.countcart);
                $('#cartCount').html(data.msg);
                $('.minicart-total span').html(data.total);
                $('#p-t').html(data.total+' ت ');
                $.each(data.msg, function (index, value) {
                    var rowId = "'" + value['rowId'].toString() + "'";
                    $('.carts_table').append(' <li>\n' +
                        '                                                <a href="/product/'+value['options']['product_slug']+'" class="minicart-product-image">\n' +
                        '                                                    <img src="' + value['options']['image'] + '" alt="cart products">\n' +
                        '                                                </a>\n' +
                        '                                                <div class="minicart-product-details">\n' +
                        '                                                    <h6><a href="/product/'+value['options']['product_slug']+'">' + value['name'] + ' </a></h6>\n' +
                        '                                                    <span>' + number_3_3(value['price']) + '  تومان x ' + value['qty'] + '</span>\n' +
                        '                                                </div>\n' +
                        '                                                <button onclick="removecart(this, ' + rowId + ')" class="close" title="Remove">\n' +
                        '                                                    <i class="fa fa-close"></i>\n' +
                        '                                                </button>\n' +
                        '                                            </li> ');
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
                            console.log(data.msg);
                            $('#cartCount').html(data.countcart);
                            $('#cartDiscountT').html(data.total);
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
                alertify.set('notifier', 'position', 'bottom-left');
                alertify.success('به سبد خرید اضافه شد');
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
    function removecart(item, id) {
        console.log(id);
        $.ajax({
            type: "post",
            url: "/removecart",
            data: {
                id: id,
                _token: '{{csrf_token()}}',
            },
            dataType: 'json',
            success: function (data) {
                $(item).parents('.minicart-product-list li').remove();
                $('#cart-total').html(data.countcart);
                $('#cartCount').html(data.countcart);
                $('.minicart-total span').html(data.total);
                $('#p-t').html(data.total+' ت ');
                alertify.set('notifier', 'position', 'bottom-left');
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
                console.log(data.msg);
                $('#cartCount').html(data.countcart);
                $('#cartDiscountT').html(data.total);
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
                count=parseInt(count)+1;
                $('.openfavorites span').html(count);
                alertify.success('با موفقیت به لیست علاقه مندی اضافه شد');
            } else if (msg == "deleted") {
                $(tag).css('color', '#000000');
                count=parseInt(count)-1;
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
</body>

</html>
