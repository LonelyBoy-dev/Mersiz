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
    if (count($carts)){
           foreach($carts as $cart){
 if ($cart->options->old_price!="" or $cart->options->old_price!=0){
      $total_discount[]=($cart->options->old_price*$cart->qty);
      $price[]=$cart->price*$cart->qty;
      $toral_old_price[]=$cart->options->old_price*$cart->qty;
      $all_price[]=$cart->options->price*$cart->qty;
}else{
     $total_discount[]=0;
     $price[]=0 ;
     $all_price[]=0;
}
    }
    }


@endphp
<!DOCTYPE html>
<html lang="fa" dir="rtl"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{@$title}}</title>
<link rel="icon" type="image/png" sizes="32x32"
          href="{{asset(setting()['logo'])}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>

    <link href="{{asset('assets/css/fontawesome.css')}}"
          rel="stylesheet">
    @php $agent=new Jenssegers\Agent\Agent();@endphp
    @if ($agent->isMobile())
        <link class="style-link" href="{{asset('assets/css/style.mobile.min.css')}}" rel="stylesheet">
    @else
        <link class="style-link" href="{{asset('assets/css/style.min.css')}}" rel="stylesheet">
    @endif


</head>

<body>

<header>

    <!--header wrap-->
    <div class="container d-flex flex-column justify-content-center py-24">

        <!--logo-->
        <div class="text-center mb-16">
            <a href="/">
                <img src="{{asset(setting()['logo'])}}" height="48" alt="{{setting()['title']}}ا">
                <div class="my-8 text-caption">{{setting()['title']}}</div>
            </a>
        </div>
        <!--logo end-->
        <!--payment steps-->
        <div class="payment-steps d-flex justify-content-center align-items-center">
            <!--item-->
            <a href="/cart" class="payment-steps_item checked">
                <div class="payment-steps_item-title">
                    <img width="48px" src="{{asset('assets/img/groceries.svg')}}">
                    <div class="text-caption">سبد خرید شما</div>
                </div>
                <div class="payment-steps_item-separator"></div>
            </a>
            <!--item end-->
            <!--item-->
            <a href="/sendorder" class="payment-steps_item checked">
                <div class="payment-steps_item-title">
                    <img width="48px"  src="{{asset('assets/img/calendar.svg')}}">
                    <div class="text-caption">کِی و کجا؟</div>
                </div>
                <div class="payment-steps_item-separator"></div>
            </a>
            <!--item end-->
            <!--item-->
            <a class="payment-steps_item active">
                <div class="payment-steps_item-title">
                    <img width="48px"  src="{{asset('assets/img/wallet.svg')}}">
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
    <!--header wrap end-->

</header>
<!--header end-->

<main>

    <!--login layout wrap-->

    <section data-controller="SendOrder">
        <div class="bg-white">
            <div class="container py-24">

                <!--method and shopping bag wrap-->
                <div class="row">
                    <!--method wrap-->
                    <div class="col-lg-8">

                        <!--header-->
                        <div class="mb-16">
                            <div class="h5 font-weight-bold">انتخاب نحوه‌ پرداخت</div>
                            <div class="text-caption text-muted">نحوه پرداخت خود را انتخاب نمایید (با پرداخت آنلاین به بهینه شدن پرداخت ها کمک نمایید)</div>
                        </div>
                        <!--header-->
                        <!--select payment type-->
                        <div class="card mb-16">
                            <form method="post" action="/order-verify" id="paymentForm">
                                @csrf
                                <div class="my-20" id="paymentCollapseParent">

                                    <!--online payment-->
                                    <div class="custom-control custom-radio option-custom-radio py-8">
                                        <input type="radio" class="custom-control-input" name="paymentType" checked id="onlinePayment" value="1" data-epay="True" data-status-code="1" data-toggle="collapse" data-target="#onlinePaymentCollapse" aria-expanded="true" aria-controls="onlinePaymentCollapse">
                                        <label class="custom-control-label w-100" for="onlinePayment">پرداخت آنلاین</label> <!-- [pt-4] is temporary soon it must be removed -->
                                    </div>
                                    <div class="collapse show" id="onlinePaymentCollapse" aria-labelledby="onlinePayment" data-parent="#paymentCollapseParent" style="">
                                        <div class="px-20">

                                            <div class="d-flex align-items-stretch justify-content-between">

                                                <!--text-->
                                                <!--text end-->
                                                <!--bank list-->
                                                <div>
                                                    <!--item-->
                                                    <div class="box-option d-inline-block m-4">
                                                        <input type="radio" class="box-option_control" id="posList2" value="2" name="posList" checked>
                                                        <label class="box-option_label" style="cursor:pointer;" for="posList2">
                                                            <div class="box-option_image">
                                                                <img src="{{asset('assets/img/zarinpal.png')}}" width="75" height="75" class="img-contain" alt="bank icon">
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <!--item end-->
                                                <input type="hidden" name="discount_code">
                                                </div>
                                                <!--bank list end-->

                                            </div>

                                        </div>
                                    </div>
                                    <!--online payment end-->
                                    <!--location payment-->
                                    <div class="custom-control custom-radio option-custom-radio py-8">
                                        <input type="radio" class="custom-control-input collapsed" name="paymentType" id="locationPayment" value="2" data-epay="False" data-status-code="2" data-toggle="collapse" data-target="#locationPaymentCollapse" aria-expanded="false" aria-controls="locationPaymentCollapse">
                                        <label class="custom-control-label w-100" for="locationPayment">پرداخت در محل</label> <!-- [pt-4] is temporary soon it must be removed -->
                                    </div>
                                    <div class="collapse" id="locationPaymentCollapse" aria-labelledby="locationPayment" data-parent="#paymentCollapseParent" style="">
                                        <div class="px-20">

                                            <div class="d-flex align-items-stretch justify-content-between">

                                                <!--text-->
                                                <div>
                                                    <div class="text-info text-caption">لطفا مبلغ سفارش را در محل تحویل،صرفااز طریق یکی از کارتهای بانکی عضو شتاب به سفیر پرداخت نمایید.</div>
                                                </div>
                                                <!--text end-->

                                            </div>

                                        </div>
                                    </div>
                                    <!--location payment end-->
                                    <!--Digital wallet payment-->
                                    @if (Auth::user())
                                        <div class="custom-control custom-radio option-custom-radio py-8">
                                            <input type="radio" class="custom-control-input collapsed" name="paymentType" id="digitalWalletPayment" value="3" data-epay="False" data-status-code="3" data-toggle="collapse" data-target="#digitalWalletCollapse" aria-expanded="false" aria-controls="digitalWalletCollapse">
                                            <label class="custom-control-label w-100" for="digitalWalletPayment">
                                                کیف پول
                                            </label> <!-- [pt-4] is temporary soon it must be removed -->
                                        </div>
                                        <div class="collapse" id="digitalWalletCollapse" aria-labelledby="digitalWalletPayment" data-parent="#paymentCollapseParent" style="">
                                            <div class="px-20">

                                                <div class="d-flex align-items-stretch justify-content-between">

                                                    <!--text-->
                                                    <div>
                                                        <div class="text-caption">
                                                            <p> موجودی حساب شما: <span class="text-danger h5 customer-credit">{{number_format($user->Marketing_price)}}</span> {{setting()['currency']}}</p>
                                                        </div>
                                                    </div>
                                                    <!--text end-->

                                                </div>

                                            </div>
                                        </div>
                                        <!--Digital wallet end-->

                                    @endif

                                </div>
                            </form>

                        </div>
                        <!--select payment type end-->

                        <!--header-->
                        <div class="mb-16">
                            <div class="h5 font-weight-bold">کد تخفیف</div>
                            <div class="text-caption text-muted">در صورت داشتن کد تخفیف آن را در این محل و قبل از اعمال دکمه تایید نهایی وارد نمایید</div>
                        </div>
                        <!--header-->
                        <!--discount code-->
                        <div class="card mb-16">
                            <div class="card-body">

                                <!--normal-->
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input id="discount_Code" type="text" class="form-control" placeholder="کد تخفیف خود را وارد نمایید ...">
                                        <div class="input-group-append">
                                            <button id="discount_CodeBtn" class="btn  btn-gradient-secondary" type="button">اعمال کد</button>
                                        </div>
                                    </div>
                                    <small id="discountName" class="form-text"></small>
                                </div>
                                <!--normal end-->


                            </div>
                        </div>
                        <!--discount code end-->
                        <a class="btn btn-sm btn-flat-dark rounded-sm ml-auto" href="/sendorder"><i class="ico ico-chevron-up ico-rotate-90"></i>بازگشت به صفحه قبل</a>

                    </div>
                    <!--method wrap end-->
                    <!--shopping bag wrap-->
                    <aside id="sidebar" class="col-lg-4 mb-8">
                        <div data-sticky_column="" class="is-affixed" style="height: 530px; position: relative;"><div class="inner-wrapper-sticky" style="position: fixed; top: 0px; left: 24px; width: 418px;">
                                <!--header-->
                                <div class="mb-16">
                                    <div class="h5 font-weight-bold">جزئیات خرید</div>
                                </div>
                                <!--header-->
                                <!--shopping bag info-->
                                <div class="card mb-16">
                                    <div class="card-body">

                                        <!--product list-->

                                        <!--product price details-->
                                        <ul class="list-unstyled m-0">

                                            <!--item-->
                                            <li class="d-flex align-items-center justify-content-between my-4">
                                                <div class="font-weight-bold">تعداد اقلام</div>
                                                <div class="font-weight-bolder">{{$countcart}}<small class="mr-4">عدد</small></div>
                                            </li>
                                            <!--item end-->
                                            <!--item-->
                                            <li class="d-flex align-items-center justify-content-between my-4">
                                                <div class="font-weight-bold">جمع کل قبل از تخفیف</div>
                                                <div class="font-weight-bolder">{{number_format(array_sum(@$toral_old_price))}}<small class="mr-4">{{setting()['currency']}}</small></div>
                                            </li>
                                            <!--item-->
                                            <li class="d-flex align-items-center justify-content-between my-4 text-blue">
                                                <div class="font-weight-bold">(-) سود شما از این خرید</div>
                                                <div class="font-weight-bolder">{{number_format(array_sum($total_discount)-array_sum($price))}}<small class="mr-4">{{setting()['currency']}}</small></div>
                                            </li>
                                            <!--item end-->
                                            <li class="d-flex align-items-center justify-content-between my-4">
                                                <div class="font-weight-bold">جمع کل بعد از تخفیف</div>
                                                <div class="font-weight-bolder"><span id="totalWithDiscount">{{$total_price}}</span><small class="mr-4">{{setting()['currency']}}</small></div>
                                            </li>
                                            <!--item end-->
                                            <!--item-->
                                            <li class="d-flex align-items-center justify-content-between my-4">
                                                <div class="font-weight-bold">(+) هزینه حمل</div>
                                                <div class="font-weight-bolder">
                                                    @if($address['time']=="پست ویژه" and $address['day']=="پست ویژه")
                                                    @if (array_sum($all_price)>=setting()['send_price_top'])
                                                        <span id="shippingCost">{{number_format(setting()['send_Special_price'])}}</span><small class="mr-4">{{setting()['currency']}}</small>
                                                    @else
                                                        <span id="shippingCost">{{number_format(setting()['send_price']+setting()['send_Special_price'])}}</span><small class="mr-4">{{setting()['currency']}}</small>
                                                    @endif
                                                    @else
                                                        @if (array_sum($all_price)>=setting()['send_price_top'])
                                                            <span id="shippingCost">رایگان</span>
                                                        @else
                                                            <span id="shippingCost">{{number_format(setting()['send_price'])}}</span><small class="mr-4">{{setting()['currency']}}</small>
                                                        @endif
                                                    @endif
                                                </div>
                                            </li>
                                            <!--item end-->
                                            <!--item-->
                                            <li class="d-flex align-items-center justify-content-between my-4 text-warning">
                                                <div class="font-weight-bold">(-) کد تخفیف</div>
                                                <div class="font-weight-bolder"><span id="discountTotal">0</span><small class="mr-4">{{setting()['currency']}}</small></div>
                                            </li>
                                            @if($order=="")
                                                <li class="d-flex align-items-center justify-content-between my-4 text-warning">
                                                    <div class="font-weight-bold">({{'%'.setting()['first_buy_mony']}}) تخفیف برای اولین خرید </div>
                                                    <div class="font-weight-bolder"><span id="discountTotal">{{number_format(array_sum($price)-(array_sum($price)*(100-setting()['first_buy_mony'])/100))}}</span><small class="mr-4">{{setting()['currency']}}</small></div>
                                                </li>
                                            @endif
                                            <!--item end-->
                                            <!--item-->
<!--                                            <li class="d-flex align-items-center justify-content-between my-4 text-warning">
                                                <div class="font-weight-bold">(-) استفاده از کیف پول</div>
                                                <div class="font-weight-bolder"><span id="customerCredit">0</span><small class="mr-4">{{setting()['currency']}}</small></div>
                                            </li>-->
                                            <!--item end-->
                                        </ul>
                                        <!--product price details end-->

                                        <hr>

                                        <!--summery-->
                                        <div class="d-flex align-items-center justify-content-between mb-16 text-primary text-success">
                                            <div class="font-weight-bold">مبلغ قابل پرداخت</div>
                                            <div class="font-weight-bolder">
                                                @php $first_buy_mony=0;
                                                if ($order==""){
                                                    $first_buy_mony=array_sum($price)-(array_sum($price)*(100-setting()['first_buy_mony'])/100);
                                                }
                                                 @endphp
                                                @if($address['time']=="پست ویژه" and $address['day']=="پست ویژه")


                                                @if (array_sum($all_price)>=setting()['send_price_top'])
                                                    <span id="totalSpan" data-price="{{(array_sum($price)-$first_buy_mony)+setting()['send_Special_price']}}">{{number_format((array_sum($price)-$first_buy_mony)+setting()['send_Special_price'])}}</span>
                                                @else
                                                    <span id="totalSpan" data-price="{{(array_sum($price)+setting()['send_price']-$first_buy_mony)+setting()['send_Special_price']}}">{{number_format((array_sum($price)+setting()['send_price']-$first_buy_mony)+setting()['send_Special_price'])}}</span>
                                                @endif



                                                @else
                                                    @if (array_sum($all_price)>=setting()['send_price_top'])
                                                        <span id="totalSpan" data-price="{{array_sum($price)-$first_buy_mony}}">{{number_format(array_sum($price)-$first_buy_mony)}}</span>
                                                    @else
                                                        <span id="totalSpan" data-price="{{array_sum($price)+setting()['send_price']-$first_buy_mony}}">{{number_format(array_sum($price)+setting()['send_price']-$first_buy_mony)}}</span>
                                                    @endif
                                                @endif
                                                    <small class="mr-4 font-weight-normal">{{setting()['currency']}}</small>
                                            </div>
                                        </div>
                                        <!--summery end-->
                                        <!--receiver info-->
                                        <!--receiver info end-->
                                        <hr>
                                        <div class="d-flex align-items-center">
                                            <button type="button" id="procced_Btn" data-click="checkCartAjax" class="btn btn-gradient-primary w-100 sbmBtn"><i class="ico ico-exit"></i>نهایی کردن سفارش</button>
                                        </div>
                                    </div>
                                </div>
                                <!--shopping bag info end-->
                                <!--info wrap-->
                                <!--info wrap end-->
                            </div></div>

                    </aside>
                    <!--shopping bag wrap end-->


                </div>
                <!--method and shopping bag wrap end-->
            </div>
        </div>



    </section>


    <!--login layout wrap end-->

</main>
<script type="text/javascript" id="">(function(a,e,f,g,b,c,d){a.GoogleAnalyticsObject=b;a[b]=a[b]||function(){(a[b].q=a[b].q||[]).push(arguments)};a[b].l=1*new Date;c=e.createElement(f);d=e.getElementsByTagName(f)[0];c.async=1;c.src=g;d.parentNode.insertBefore(c,d)})(window,document,"script","https://www.google-analytics.com/analytics.js","ga");ga("create","UA-107949712-1","auto");ga("send","pageview");</script>


<!--footer-->

@extends('front.layout.footer')
<!--footer end-->


<script src="{{asset('assets/js/bundle.js')}}"></script>
<script src="{{asset('assets/js/fontawesome.js')}}"></script>
<script src="{{asset('assets/js/profile-address.es5.min.js')}}"></script>
<script src="{{asset('assets/js/send-order.es5.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
@if(session('Marketing_price_noFee'))
    <script>
        alertify
            .alert("<?= session('Marketing_price_noFee') ?>", function(){

            }).set('label', 'خب').setHeader('<em> پیغام </em> ');
    </script>
@endif
<script>

    $('#procced_Btn').click(function () {

        alertify.confirm("آیا میخواهید خرید خود را نهایی کنید؟",
            function () {
                $('#paymentForm').submit();
            },
            function () {

            }).set('labels', {ok: 'بله', cancel: 'خیر!'}).setHeader('<em> پیغام </em> ');

    })
    $('#discount_CodeBtn').click(function () {
        var code=$('#discount_Code').val();
        if (code.length>3){

                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('code.checkdiscountcode')}}';
                var data = {_token: CSRF_TOKEN,code:code};
                $.post(url, data, function (msg) {
                    console.log(msg)
                    $('#discountName').html(msg.msg);
                    $('#totalSpan').html(msg.price);
                    $('#discountTotal').html(msg.dis_price);
                    $('#discountName').css('color',msg.color)
                    $('input[name=discount_code]').val(msg.code)
                });
        }
    })

</script>
</body>
</html>
@php
    Session::forget('Marketing_price_noFee');
@endphp
