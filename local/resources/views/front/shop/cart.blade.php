@php

    $carts = Gloudemans\Shoppingcart\Facades\Cart::content();
    $countcart = Gloudemans\Shoppingcart\Facades\Cart::content()->count();
    $total_price = Gloudemans\Shoppingcart\Facades\Cart::subtotal(00);
    if(!isset($countcart)){
        $countcart = 0;
    }
    if(!isset($total_price)){
        $total_price = 0;
    }

    $total_discount[]=0;
     $price[]=0 ;
     $toral_old_price=[];
    if (count($carts)){
           foreach($carts as $cart){
 if ($cart->options->old_price!="" or $cart->options->old_price!=0){
      $total_discount[]=($cart->options->old_price*$cart->qty);
      $price[]=$cart->price*$cart->qty;
      $toral_old_price[]=$cart->options->old_price*$cart->qty;

}else{

}
    }
    }
@endphp


    <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>سبد خرید</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link rel="icon" type="image/png" sizes="32x32"
          href="{{asset(setting()['logo'])}}">
    <link rel="mask-icon" color="#5bbad5">
    <!--style must be included in all page-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
    @php $agent=new Jenssegers\Agent\Agent();@endphp
    @if ($agent->isMobile())
        <link class="style-link" href="{{asset('assets/css/style.mobile.min.css')}}" rel="stylesheet">
    @else
        <link class="style-link" href="{{asset('assets/css/style.min.css')}}" rel="stylesheet">
    @endif
</head>
<style>
    .quantity {
        position: relative;
    }

    .quantity input {
        width: 80px;
        height: 40px;
        /* line-height: 1.65; */
        float: right;
        display: block;
        padding: 0;
        margin: 0 35px 0 10px;
        padding-left: 15px;
        padding-right: 34px;
        border: 1px solid #eee;
        font-size: 1.071rem;
        color: #0fabc6;
        border-radius: 5px;
    }

    .quantity-nav {
        float: right;
        position: relative;
        height: 42px;
    }

    .quantity-button.quantity-up {
        position: absolute;
        height: 25px;
        top: 9px;
        width: 25px;
        right: -122px;
        font-size: 15px;
        padding-top: 0px;
        border-radius: 50%;
        background: #5bd7fc33;
        color: #0095ff;
        text-align: center;
        line-height: 25px;
        cursor: pointer;
    }

    .quantity-button.quantity-down {
        position: absolute;
        height: 25px;
        top: 9px;
        width: 25px;
        right: -4px;
        font-size: 15px;
        padding-top: 0px;
        border-radius: 50%;
        background: #fc5b5b33;
        color: #ff0000;
        cursor: pointer;
        text-align: center;
        line-height: 25px;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<body>


<div class="page-loading active" style="display:none">
    <div class="page-loading-box">
        <img src="{{asset($setting['logo'])}}" class="page-loading-logo" alt="{{{$setting['title']}}}">
        <img src="{{asset($setting['logo'])}}" class="page-loading-loader" alt="{{{$setting['title']}}}">
    </div>
</div>
<!--header-->
<header>


    <div class="container d-flex flex-column justify-content-center py-24">

        <!--logo-->
        <div class="text-center mb-16">
            <a href="/">
                <img src="{{asset($setting['logo'])}}" height="48" alt="{{{$setting['title']}}}ا">
                <div class="my-8 text-caption">{{{$setting['title']}}}</div>
            </a>
        </div>
        <!--logo end-->
        <!--payment steps-->
        <div class="payment-steps d-flex justify-content-center align-items-center">
            <!--item-->
            <a class="payment-steps_item active">
                <div class="payment-steps_item-title">
                    <img width="48px" src="{{asset('assets/img/groceries.svg')}}">
                    <div class="text-caption">سبد خرید شما</div>
                </div>
                <div class="payment-steps_item-separator"></div>
            </a>
            <!--item end-->
            <!--item-->
            <a class="payment-steps_item ">
                <div class="payment-steps_item-title">
                    <img width="48px" class="ico-color_payment-calendar" src="{{asset('assets/img/calendar.svg')}}">
                    <div class="text-caption">کِی و کجا؟</div>
                </div>
                <div class="payment-steps_item-separator"></div>
            </a>
            <!--item end-->
            <!--item-->
            <a class="payment-steps_item ">
                <div class="payment-steps_item-title">
                    <img width="48px" class="ico-color_payment-calendar" src="{{asset('assets/img/wallet.svg')}}">
                    <div class="text-caption">نحوه پرداخت</div>
                </div>
                <div class="payment-steps_item-separator"></div>
            </a>
            <!--item end-->
            <!--item-->
            <!--item end-->
            <!--item-->
            <div class="payment-steps_item ">
                <div class="payment-steps_item-title">
                    <img width="48px" class="ico-color_payment-calendar" src="{{asset('assets/img/order.svg')}}">
                    <div class="text-caption">تکمیل سفارش</div>
                </div>
                <!--<div class="payment-steps_item-separator"></div>-->
            </div>
            <!--item end-->

        </div>
        <!--payment steps end-->

    </div>
</header>
<!--header end-->

<main>

    <!--login layout wrap-->
    <section data-controller="Cart">
        <div class="bg-white">
            @php $agent=new Jenssegers\Agent\Agent();@endphp
            @if ($agent->isMobile())
            <div class="container py-24">
                <div>
                    <!--shopping bag wrap-->
                    <div>
                        <!--shopping bag info-->
                        <div class="card mb-16">
                            <div class="card-body">

                                <!--product list-->
                                <div>
                                    <div class="pl-20 cart-item-list">
                                        <!--item-->
                                        @if (count($carts))
                                            @foreach($carts as $cart)
                                                <?php $product=App\Product::find($cart->id) ?>
                                        <div class="d-block cart-item" id="{{$cart->id}}">

                                            <div class="d-flex align-items-center">

                                                <!--del btn-->
                                                <button onclick="removecart(this,'{{$cart->rowId}}')" class="btn btn-icon-danger btn-icon text-nowrap remove-from-cart" data-productid="{{$cart->rowId}}" data-supplier="False"><i class="ico ico-close filter-primary"></i></button>
                                                <!--image-->
                                                <div class="p-4 mx-auto">
                                                    @if($product->image)
                                                        @if(file_exists(public_path() . '/' . $product->image))
                                                            <img src="{{asset($product->image)}}" width="75" height="75" class="img-fit" alt="{{$cart->name}}ا">
                                                        @else
                                                            <img src="{{asset('images/nopic.png')}}" width="75" height="75" class="img-fit" alt="{{$cart->name}}ا">

                                                        @endif

                                                    @else
                                                        <img src="{{asset('images/nopic.png')}}" width="75" height="75" class="img-fit" alt="{{$cart->name}}ا">
                                                    @endif
                                                </div>
                                                <!--description-->
                                                <div class="d-flex flex-column flex-fill">
                                                    <div class="mb-8">
                                                        <div class="subtitle2 mb-4">{{$cart->name}}ا</div>
                                                        <div class="text-caption text-muted font-weight-light"></div>
                                                    </div>
                                                    <div class="align-items-center justify-content-between">

                                                        <div class="mb-8">
                                                            @if ($cart->options->old_price!="" or $cart->options->old_price!=0)
                                                                <div class="text-muted text-caption line-height-sm">
                                                                    <del>{{number_format($cart->options->old_price)}} </del>
                                                                    <small
                                                                        class="mr-4">{{setting()['currency']}}</small>
                                                                </div>
                                                            @endif
                                                            <div class="text-success font-weight-bold">
                                                                <span>{{number_format($cart->price)}}</span>
                                                                <small class="mr-4">{{setting()['currency']}}</small>
                                                            </div>
                                                        </div>

                                                        <div class="w-100">
                                                            <div class="text-right">
                                                                <div
                                                                    class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                                <span
                                                                    class="input-group-btn input-group-prepend"></span><input
                                                                        type="text" value="{{$cart->qty}}"
                                                                        class="numberpicker form-control"
                                                                        data-stop="1" data-product-id="{{$cart->id}}" data-max="{{$product->depot}}"><span
                                                                        class="input-group-btn input-group-append"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-danger">
                                                <i class="ico ico-color_bag"></i>
                                                سبد خرید شما خالی است
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!--product list end-->

                                <hr>

                                <!--product price details-->
                                <ul class="list-unstyled m-0">

                                    <!--item-->
                                    <li class="d-flex align-items-center justify-content-between my-4">
                                        <div class="subtitle2">تعداد اقلام</div>
                                        <div><span id="cartCountSide">{{$countcart}}</span><small class="mr-4">عدد</small></div>
                                    </li>
                                    <!--item end-->
                                    <!--item-->
                                    <li class="d-flex align-items-center justify-content-between my-4">
                                        <div class="subtitle2">جمع کل قبل از تخفیف</div>
                                        <div><span id="cartPriceTSide">{{number_format(array_sum(@$toral_old_price))}}</span><small class="mr-4">{{setting()['currency']}}</small></div>
                                    </li>
                                    <!--item end-->
                                    <!--item-->
                                    <li class="d-flex align-items-center justify-content-between my-4 text-blue">
                                        <div class="font-weight-bold">(-) سود شما از این خرید</div>
                                        <div class="font-weight-bolder"><span id="cartDiscountTSide">{{number_format(array_sum($total_discount)-array_sum($price))}}</span><small class="mr-4">{{setting()['currency']}}</small></div>
                                    </li>
                                    <!--item end-->
                                    <!--item end-->
                                    <li class="d-flex align-items-center justify-content-between my-4">
                                        <div class="font-weight-bold">جمع کل بعد از تخفیف</div>
                                        <div class="font-weight-bolder"><span id="totalWithDiscount">{{$total_price}}</span><small class="mr-4">{{setting()['currency']}}</small></div>
                                    </li>
                                    <!--item end-->
                                </ul>
                                <!--product price details end-->

                                <hr>

                                <!--summery-->
                                <div class="d-flex align-items-center justify-content-between mb-16 text-primary text-success">
                                    <div class="font-weight-bold">مبلغ قابل پرداخت</div>
                                    <div class="font-weight-bolder"><span id="cartOkPriceTSide">{{$total_price}}</span><small class="mr-4 font-weight-normal">{{setting()['currency']}}</small></div>
                                </div>
                                <!--summery end-->

                            </div>
                        </div>
                        <!--shopping bag info end-->
                        <!--button controller-->
                        <div>
                            <!--continue-->
                            <a class="btn btn-gradient-primary btn-block" href="/sendorder" title=""><i class="ico ico-exit"></i>انتخاب آدرس</a>
                            <!--continue-->
                            <!--back-->
                            <a href="/" class="btn btn-flat-dark  btn-block" title="/"><i class="ico ico-chevron-up ico-rotate-90"></i>بازگشت به سایت و خرید بیشتر</a>
                        </div>
                        <!--button controller end-->

                    </div>
                    <!--shopping bag wrap end-->
                </div>
            </div>
            @else
            <div class="container py-24">
                <div class="row">
                    <!--shopping bag wrap-->
                    <div class="col-lg-8">
                        <div class="mb-16">
                            <div class="h5 font-weight-bold">سبد خرید</div>
                        </div>
                        <!--shopping bag info-->
                        <div class="card mb-16">
                            <div class="card-body">

                                <!--product list-->
                                <div>
                                    <div class="pl-20 cart-item-list">
                                        <!--item-->
                                        @if (count($carts))
                                            @foreach($carts as $cart)
                                                <?php $product=App\Product::find($cart->id) ?>
                                                <div id="{{$cart->id}}" class="d-flex align-items-center flex-wrap mb-12 cart-item"
                                                     data-productid="">

                                                    <div class="w-60 d-flex align-items-center">
                                                        <button onclick="removecart(this,'{{$cart->rowId}}')"
                                                                class="btn-icon-dark ml-12 "
                                                                data-productid="{{$cart->rowId}}" data-storeid="3530"
                                                                data-supplier="False"><i
                                                                class="ico ico-close filter-primary"></i></button>

                                                        <div class="border p-4 rounded">

                                                            @if($product->image)

                                                                @if(file_exists(public_path() . '/' . $product->image))

                                                                    <img data-src="{{asset($product->image)}}" width="85"
                                                                         height="85" class="img-fit lazy loaded"
                                                                         alt="{{$cart->name}}"
                                                                         src="{{asset($product->image)}}"
                                                                         data-was-processed="true">
                                                                @else
                                                                    <img data-src="{{asset('images/nopic.png')}}" width="85"
                                                                         height="85" class="img-fit lazy loaded"
                                                                         alt="{{$cart->name}}"
                                                                         src="{{asset('images/nopic.png')}}"
                                                                         data-was-processed="true">
                                                                @endif

                                                            @else
                                                                <img data-src="{{asset('images/nopic.png')}}" width="85"
                                                                     height="85" class="img-fit lazy loaded"
                                                                     alt="{{$cart->name}}"
                                                                     src="{{asset('images/nopic.png')}}"
                                                                     data-was-processed="true">
                                                            @endif

                                                        </div>

                                                        <div class="px-12 flex-fill">
                                                            <div class="subtitle1 product-name">{{$cart->name}}</div>
                                                            <div
                                                                class="text-caption text-muted font-weight-light"></div>
                                                        </div>

                                                    </div>

                                                    <div class="w-40 d-flex justify-content-between">

                                                        <div class="text-right">
                                                            <div
                                                                class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                                <span
                                                                    class="input-group-btn input-group-prepend"></span><input
                                                                    type="text" value="{{$cart->qty}}"
                                                                    class="numberpicker form-control"
                                                                    data-stop="1" data-product-id="{{$cart->id}}" data-max="{{$product->depot}}"><span
                                                                    class="input-group-btn input-group-append"></span>
                                                            </div>
                                                        </div>
                                                        <div class="text-left">
                                                            @if ($cart->options->old_price!="" or $cart->options->old_price!=0)
                                                                <div class="text-muted text-caption line-height-sm">
                                                                    <del>{{number_format($cart->options->old_price)}} </del>
                                                                    <small
                                                                        class="mr-4">{{setting()['currency']}}</small>
                                                                </div>
                                                            @endif

                                                            <div class="text-success font-weight-bold">
                                                                <span>{{number_format($cart->price)}}</span><small
                                                                    class="mr-4">{{setting()['currency']}}</small></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-danger">
                                                <i class="ico ico-color_bag"></i>
                                                سبد خرید شما خالی است
                                            </div>
                                    @endif

                                    <!--item-->
                                    </div>
                                </div>
                                <!--product list end-->

                            </div>
                        </div>
                        <!--shopping bag info end-->

                            <div class="card mb-16 remove-product" style="@if (session('check_count_product'))display:bloke;@else display:none @endif">
                                <div class="card-body">

                                    <!--product list-->
                                    <div>
                                        <div class="pl-20 cart-item-list">
                                            <!--item-->

                                                <div class="text-center text-danger">
                                                    <i class="ico ico-color_bag"></i>
                                                    به دلیل تمام شدن محصول، به طور خودکار از سبد خرید حذف شد
                                                </div>


                                        <!--item-->
                                        </div>
                                    </div>
                                    <!--product list end-->

                                </div>
                            </div>

                        <!--button controller-->
                        <!--back-->
                        <a href="/" class="btn btn-sm btn-flat-dark rounded-sm"><i
                                class="ico ico-chevron-up ico-rotate-90"></i>بازگشت به سایت و خرید بیشتر</a>
                        <!--button controller end-->

                    </div>

                    <!--shopping bag wrap-->
                    <aside id="sidebar" class="col-lg-4 mb-8">
                        <div data-sticky_column="" class="is-affixed" style="height: 386px; position: relative;">
                            <div class="inner-wrapper-sticky"
                                 style="position: relative; transform: translate3d(0px, 182px, 0px);">

                                <!--header-->
                                <div class="mb-16">
                                    <div class="h5 font-weight-bold">جزئیات خرید</div>
                                </div>
                                <!--header-->
                                <!--shopping bag info-->
                                <div class="card mb-16">
                                    <div class="card-body">
                                        <!--product price details-->
                                        <ul class="list-unstyled m-0">

                                            <!--item-->
                                            <li class="d-flex align-items-center justify-content-between my-4">
                                                <div class="font-weight-bold">تعداد اقلام</div>
                                                <div class="font-weight-bolder"><span
                                                        id="cartCount">{{$countcart}}</span><small
                                                        class="mr-4">عدد</small></div>
                                            </li>
                                            <!--item end-->
                                            <!--item-->
                                            <li class="d-flex align-items-center justify-content-between my-4">
                                                <div class="font-weight-bold">جمع کل قبل از تخفیف</div>
                                                <div class="font-weight-bolder"><span
                                                        id="cartPriceTSide">{{number_format(array_sum(@$toral_old_price))}}</span><small
                                                        class="mr-4">{{setting()['currency']}}</small></div>
                                            </li>
                                            <!--item end-->
                                            <!--item-->
                                            <li class="d-flex align-items-center justify-content-between my-4 text-blue">
                                                <div class="font-weight-bold">(-) سود شما از این خرید</div>
                                                <div class="font-weight-bolder"><span
                                                        id="cartDiscountTSide">{{number_format(array_sum($total_discount)-array_sum($price))}}</span><small
                                                        class="mr-4">{{setting()['currency']}}</small></div>
                                            </li>
                                            <!--item end-->
                                            <!--item end-->
                                            <li class="d-flex align-items-center justify-content-between my-4 ">
                                                <div class="font-weight-bold">جمع کل بعد از تخفیف</div>
                                                <div class="font-weight-bolder"><span
                                                        id="totalWithDiscount">{{$total_price}}</span><small
                                                        class="mr-4">{{setting()['currency']}}</small></div>
                                            </li>
                                            <!--item end-->

                                        </ul>
                                        <!--product price details end-->

                                        <hr>

                                        <!--summery-->
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-16 text-primary text-success">
                                            <div class="font-weight-bold">مبلغ قابل پرداخت</div>
                                            <div class="font-weight-bolder"><span
                                                    id="cartOkPriceTSide">{{$total_price}}</span><small
                                                    class="mr-4 font-weight-normal">{{setting()['currency']}}</small>
                                            </div>
                                        </div>
                                        <!--summery end-->
                                        <hr>
                                        <div class="d-flex align-items-center">
                                            <!--continue-->
                                            <a class="btn btn-gradient-primary w-100" href="/sendorder"><i
                                                    class="ico ico-exit"></i>انتخاب آدرس</a>
                                        </div>
                                    </div>
                                </div>
                                <!--shopping bag info end-->
                                <!--info wrap-->
                                <!--info wrap end-->

                            </div>
                        </div>
                    </aside>
                    <!--shopping bag wrap end-->
                </div>
            </div>
            @endif
        </div>
    </section>


    <!--login layout wrap end-->

</main>
<!--footer-->
@extends('front.layout.footer')
<!--footer end-->


<script src="{{asset('assets/js/bundle.js')}}"></script>
<script src="{{asset('assets/js/fontawesome.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

@foreach($carts as $cart)
    <script>
        check_count_product()
        function check_count_product(){
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('cart.check_count_product')}}';
            var data = {_token: CSRF_TOKEN, id: '{{$cart->rowId}}', id_product: '{{$cart->id}}'};
            $.post(url, data, function (msg) {
                if (msg.remove=="yes"){
                    $('#'+msg.id_remove).remove();
                    $('.remove-product').show();
                }
            })
        }

    </script>
@endforeach

<script>

    function removecart(item, id) {

        alertify.confirm("آیا مایل به حذف کالای فوق از سبد خرید هستید؟",
            function () {
                $.ajax({
                    type: "post",
                    url: "/removecart",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        $(item).parents('.align-items-center').remove();
                        $('#cart-total').html(data.countcar);
                        $('#cartCount').html(data.countcart);
                        $('#cartOkPriceTSide').html(data.total);
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
            },
            function () {

            }).set('labels', {ok: 'بله', cancel: 'خیر!'}).setHeader('<em> پیغام </em> ');

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
                if (data.buy_limited != "yes") {
                    $('#cartCount').html(data.countcart);
                    $('#cartPriceTSide').html(data.toral_old_price);
                    $('#cartDiscountTSide').html(data.total_didcount);
                    $('#totalWithDiscount').html(data.total);
                    /*$('#cartDiscountT').html(data.total);*/
                    $('#cartOkPriceT').html(data.total);
                    $('#cartOkPriceTSide').html(data.total);
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success('سبد خرید بروزرسانی شد');
                }else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('کالای مورد نظر محدودیت خرید دارد');
                }
                }else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('موجودی کالا روبه اتمام است');
                }
            },
            error: function (err) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('سبد خرید بروزرسانی نشد');
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

    //    quantity-selector---------------------------
    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function () {

        var spinner = jQuery(this),
            input = spinner.find('input[type="number"]'),
            btnUp = spinner.find('.quantity-up'),
            btnDown = spinner.find('.quantity-down'),
            min = input.attr('min'),
            max = input.attr('max');

        btnUp.click(function () {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        btnDown.click(function () {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

    });
    //    quantity-selector---------------------------

</script>


@section('content')
    {{--    <!-- ============================================== HEADER : END ============================================== -->
        <div class="breadcrumb">
            <div class="container">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="/">خانه</a></li>
                        <li class='active'>سبد خرید</li>
                    </ul>
                </div>
                <!-- /.breadcrumb-inner -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.breadcrumb -->

        <div class="body-content outer-top-xs">
            <div class="container">
                <div class="row ">
                    <div class="shopping-cart">
                        <div class="shopping-cart-table ">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="cart-romove item">حذف</th>
                                        <th class="cart-description item">تصویر</th>
                                        <th class="cart-product-name item">نام محصول</th>
                                        <th class="cart-qty item">تعداد</th>
                                        <th class="cart-sub-total item">زیرمجموع</th>
                                        <th class="cart-total last-item">جمع کل</th>
                                    </tr>
                                    </thead>
                                    <!-- /thead -->

                                    <tbody>
                                    @foreach($carts as $cart)
                                    <tr>
                                        <td class="romove-item"><a  onclick="deletecart(this, '{{$cart->rowId}}')" title="cancel" class="icon"><i class="fa fa-trash-o"></i></a></td>
                                        <td class="cart-image">
                                            <a class="entry-thumbnail" href="/product/{{$cart->options->product_slug}}">
                                                <img src="{{asset($cart->options->image)}}" alt="{{$cart->name}}">
                                            </a>
                                        </td>
                                        <td class="cart-product-name-info">
                                            <h4 class='cart-product-description'><a href="/product/{{$cart->options->product_slug}}">{{$cart->name}}</a></h4>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="rating rateit-small"></div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="reviews">
                                                        ({{$cart->options->product_view}} دیدگاه)
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.row -->
                                           --}}{{-- <div class="cart-product-info">
                                                <span class="product-color">رنگ:<span>آبی</span></span>
                                            </div>--}}{{--
                                        </td>
                                        <td class="cart-product-quantity">
                                            <div class="quant-input">
                                                <div class="arrows">
                                                    <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                                    <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                                </div>
                                                <input type="text" value="{{$cart->qty}}">
                                            </div>
                                        </td>
                                        <td class="cart-product-sub-total"><span class="cart-sub-total-price">{{number_format($cart->price)}} تومان</span></td>
                                        <td class="cart-product-grand-total"><span class="cart-grand-total-price">{{number_format($cart->price*$cart->qty)}} تومان</span></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <!-- /tbody -->

                                    <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <div class="shopping-cart-btn">
                                                    <span class="">
                                    <a href="/checkout" class="btn btn-upper btn-primary pull-left  outer-left-xs">ادامه خرید</a>
                                </span>
                                            </div>
                                            <!-- /.shopping-cart-btn -->
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <!-- /table -->
                            </div>
                        </div>

                    </div>
                    <!-- /.shopping-cart -->
                </div>
            </div>
            <!-- /.container -->
        </div>
        <!-- /.body-content -->--}}
@endsection
@section('script')

    <script>
        function deletecart(item, id) {
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
                    $(item).parents('.table tr').remove();
                    $('#cart-total').html(data.countcart);
                    $('#cartCount').html(data.countcart);
                    $('.minicart-total span').html(data.total);
                    $('#p-t').html(data.total + ' ت ');
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
    </script>
@endsection
@php
    Session::forget('check_count_product');
@endphp
