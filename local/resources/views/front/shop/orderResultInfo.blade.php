@php

 foreach ($orders as $order){
    $products=\App\Product::where('id',$order->product_id)->get();
    foreach ($products as $product){
        $real_price[]=$product->price*$order->count;
    }
}


@endphp
    <!DOCTYPE html>
<html lang="fa" dir="rtl"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>نحوه پرداخت</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


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
            <a  class="payment-steps_item checked">
                <div class="payment-steps_item-title">
                    <img width="48px" src="{{asset('assets/img/groceries.svg')}}">
                    <div class="text-caption">سبد خرید شما</div>
                </div>
                <div class="payment-steps_item-separator"></div>
            </a>
            <!--item end-->
            <!--item-->
            <a class="payment-steps_item checked">
                <div class="payment-steps_item-title">
                    <img width="48px" src="{{asset('assets/img/calendar.svg')}}">
                    <div class="text-caption">کِی و کجا؟</div>
                </div>
                <div class="payment-steps_item-separator"></div>
            </a>
            <!--item end-->
            <!--item-->
            <a class="payment-steps_item checked">
                <div class="payment-steps_item-title">
                    <img width="48px" src="{{asset('assets/img/wallet.svg')}}">
                    <div class="text-caption">نحوه پرداخت</div>
                </div>
                <div class="payment-steps_item-separator"></div>
            </a>
            <!--item end-->
            <!--item-->
            <!--item end-->
            <!--item-->
            <div class="payment-steps_item active">
                <div class="payment-steps_item-title">
                    <img width="48px" src="{{asset('assets/img/order.svg')}}">
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
    @php $url=url()->current();
                    $url=explode('/',url()->current());
    @endphp
    <section data-controller="SendOrder">
        <div class="bg-white">
            @if ($url[4]=="success=False")
                <div class="container py-24">

                    <!--check and shopping bag wrap-->
                    <div class="row">

                        <!--shopping bag wrap-->
                        <div class="col-12">

                            <!--shopping bag info-->
                            <div class="card mb-16">
                                <div class="card-body">

                                    <div class="text-center">

                                        <i class="ico ico-color_payment-failure ico-128px ico-fw-0"></i>

                                        <div class="h4 font-weight-bold my-12">ثبت سفارش شما با مشکل مواجه شد</div>

                                        <div class="font-weight-bold mb-12">تراكنش توسط خريدار كنسل شد,در صورت کسر وجه از حساب شما، حداکثر تا ۷۲ساعت وجه مورد نظر استرداد میشود
                                        </div>
                                        <div class="font-weight-bold mb-12"></div>

                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-primary mx-8" href="/sendorder"><i class="ico ico-payment"></i>پرداخت مجدد</a>


                                            <a href="/content" class="btn btn-outline-primary mx-8"><i class="ico ico-phone ico-flip-horizontal"></i>تماس با پشتیبان</a>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!--shopping bag info end-->

                        </div>
                        <!--shopping bag wrap end-->

                    </div>
                    <!--check and shopping bag wrap end-->

                </div>
            @elseif($url[4]=="success=True")
                <div class="container py-24">

                    <!--check and shopping bag wrap-->
                    <div class="row">

                        <!--shopping bag wrap-->
                        <div class="col-12">

                            <!--shopping bag info-->
                            <div class="card">
                                <div class="card-body">

                                    <div class="row align-items-center">

                                        <!--message-->
                                        <div class="col-lg-6">

                                            <div class="text-center">

                                                <i class="ico ico-color_payment-success ico-128px ico-fw-0"></i>

                                                <div class="h4 font-weight-bold my-12">با تشکر از خرید شما</div>

                                                <div class="font-weight-bold mb-12">سفارش شما در اسرع وقت به دست شما خواهد رسید. از صبر و شکیبایی شما متشکریم</div>


                                                <div class="d-flex justify-content-between w-100">

<!--                                                    <div class="w-50 text-center mx-4">
                                                        <span class="font-weight-bold">کد تحویل</span>
                                                        <div class="bg-white h5 font-weight-bold w-100 py-8 rounded-xl shadow-3dp text-dark my-4">6233</div>
                                                    </div>-->

                                                    <div class="w-50 text-center mx-6" style="margin: 0 auto">
                                                        <span class="font-weight-bold">شماره فاکتور</span>
                                                        <div class="bg-white h5 font-weight-bold w-100 py-8 rounded-xl shadow-3dp text-dark my-4">{{$orders[0]->factor_number}}</div>
                                                    </div>


                                                </div>
                                                <div class="w-100 text-center mt-24">
                                                    <!--back-->
                                                    <a href="/" class="btn btn-flat-dark btn-block" title=""><i class="ico ico-chevron-up ico-rotate-90"></i>بازگشت به سایت و خرید بیشتر</a>
                                                </div>
                                            </div>

                                        </div>

                                        <!--message end-->
                                        <!--bill panel-->
                                        <div class="col-lg-4 mx-auto">
                                            <div class="bill-panel">

                                                <div class="d-flex align-items-stretch">

                                                    <div class="w-60">
                                                        <div class="text-caption text-muted">جمع کل</div>
                                                        <div class="h3 font-weight-bolder">{{number_format($orders[0]->total)}}<small class="mr-4 font-weight-bold">{{setting()['currency']}}</small></div>
                                                    </div>

                                                    <div class="w-40">
                                                        <div class="text-caption text-muted">نحوه پرداخت</div>
                                                        @if ($orders[0]->pay_method=="home")
                                                            <div class="h6">پرداخت در محل</div>
                                                        @elseif($orders[0]->pay_method=="online")
                                                            <div class="h6">پرداخت آنلاین</div>
                                                        @elseif($orders[0]->pay_method=="wallet")
                                                            <div class="h6">پرداخت از کیف پول</div>
                                                        @endif

                                                    </div>

                                                </div>

                                                <hr class="divider-dashed">

                                                <div class="text-caption text-muted mb-4">جزئیات خرید</div>

                                                <!--product price details-->
                                                <ul class="list-unstyled m-0 pr-16">

                                                    <!--item-->
                                                    <li class="d-flex align-items-center justify-content-between my-4">
                                                        <div class="font-weight-bold">جمع اقلام</div>
                                                        <div class="font-weight-bolder">{{count($orders)}}<small class="mr-4">عدد</small></div>
                                                    </li>
                                                    <!--item end-->
                                                    <!--item-->
                                                    <li class="d-flex align-items-center justify-content-between my-4">
                                                        <div class="font-weight-bold">جمع کل قبل از تخفیف</div>
                                                        <div class="font-weight-bolder">{{number_format(array_sum($real_price))}}<small class="mr-4">{{setting()['currency']}}</small></div>
                                                    </li>
                                                    @if($orders[0]->first_buy_mony!=0)
                                                        <li class="d-flex align-items-center justify-content-between my-4">
                                                            <div class="font-weight-bold">میزان تخفیف برای اولین خرید</div>
                                                            <div class="font-weight-bolder">{{number_format($orders[0]->first_buy_mony)}}<small class="mr-4">{{setting()['currency']}}</small></div>
                                                        </li>
                                                    @endif
                                                    <!--item end-->
                                                    <!--item-->
                                                    <li class="d-flex align-items-center justify-content-between my-4 text-info">
                                                        <div class="font-weight-bold">سود شما از این خرید</div>
                                                        <div class="font-weight-bolder">{{number_format((array_sum($real_price)-$orders[0]->total)+$orders[0]->first_buy_mony)}}<small class="mr-4">{{setting()['currency']}}</small></div>
                                                    </li>
                                                    <!--item end-->

                                                </ul>
                                                <!--product price details end-->

                                                <hr class="divider-dashed">

                                                <!--summery-->
                                                <div class="d-flex align-items-center justify-content-between text-primary">
                                                    <div class="font-weight-bolder">جمع نهایی</div>
                                                    <div class="font-weight-bolder">{{number_format($orders[0]->total)}}<small class="mr-4 font-weight-bolder">{{setting()['currency']}}</small></div>
                                                </div>
                                                <!--summery end-->

                                            </div>
                                        </div>
                                        <!--bill panel end-->



                                    </div>

                                </div>
                            </div>
                            <!--shopping bag info end-->

                        </div>
                        <!--shopping bag wrap end-->

                    </div>
                    <!--check and shopping bag wrap end-->

                </div>
            @endif



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

</body>
</html>
