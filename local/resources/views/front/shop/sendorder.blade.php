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

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="icon" type="image/png" sizes="32x32"
          href="{{asset(setting()['logo'])}}">


    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
    <link href="{{asset('js/Mh1PersianDatePicker.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('map/css/mapp.min.css')}}">
    <link rel="stylesheet" href="{{asset('map/css/fa/style.css')}}">
    <link href="{{asset('assets/css/fontawesome.css')}}" rel="stylesheet">
    @php $agent=new Jenssegers\Agent\Agent();@endphp
    @if ($agent->isMobile())
        <link class="style-link" href="{{asset('assets/css/style.mobile.min.css')}}" rel="stylesheet">
    @else
        <link class="style-link" href="{{asset('assets/css/style.min.css')}}" rel="stylesheet">
    @endif

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-material-datetimepicker.css')}}" />
    <!--style must be included in all page end-->
    <style>
        .nav-item a{
            cursor: pointer;
        }
        .dtp > .dtp-content{
            right: 40%;
            left: auto;
        }
        .dtp .dtp-buttons{
            text-align: left;
        }
        #app {
            width: 100%;
            height: 400px;
        }
        .btn-outline-primary:hover {
            color: #fff!important;
            background-image: linear-gradient(to right, #ec028c 0%, #98364d 100%);
            border-color: #8d48a1;
        }
    </style>

</head>

<body>



<!--header-->
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
            <a class="payment-steps_item active">
                <div class="payment-steps_item-title">
                     <img width="48px" src="{{asset('assets/img/calendar.svg')}}">
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
    <!--header wrap end-->

</header>
<!--header end-->

<main>

    <!--login layout wrap-->
    <section data-controller="SendOrder">
        <div class="bg-white">
            <div class="container py-24">

                <form method="post" action="/store-confirmandsend">
                    @csrf
                    <!--address and shopping bag wrap-->
                    <div class="row">
                        <!--address wrap-->
                        <div class="col-lg-8">

                            <!--header-->
                            <!--header-->
                            <!--add new address-->
                            <!--add new address end-->
                            <!--header-->
                            <div class="mb-16">
                                <div class="h5 font-weight-bold">انتخاب آدرس تحویل سفارش</div>
                            </div>
                            <!--header-->
                            <!--add new address-->

                            <div class="card mb-16">
                                <div class="card-body card-header-right-border">
                                    @if ($address!="")


                                    <div class="current-address address-detail" data-id="{{$address->id}}">
                                        <div class="subtitle1">
                                            @if ($agent->isMobile())
                                            <div class="mb-12 d-flex">

                                                &nbsp;&nbsp;<a data-id="{{$address->id}}" data-toggle="modal" data-target="#newAddressModal" style="cursor: pointer" class="text-secondary border-bottom-dashed edit-address mr-auto EditAddress">اصلاح این آدرس</a>
                                                <span data-click="changeAddress" class="btn btn-outline-info btn-sm mr-16 rounded-sm">خرید برای دیگری</span>
                                            </div>
                                                <div class="mb-12 d-flex">
                                                    <span class="font-weight-bolder">تحویل گیرنده: </span>&nbsp;
                                                    <span class="transfree-name" id="transfree-name">{{$address->name}}</span>
                                                </div>

                                            @else
                                                <div class="mb-12 d-flex">
                                                    <span class="font-weight-bolder">تحویل گیرنده: </span>&nbsp;
                                                    <span class="transfree-name" id="transfree-name">{{$address->name}}</span>
                                                    &nbsp;&nbsp;<a data-id="{{$address->id}}" data-toggle="modal" data-target="#newAddressModal" style="cursor: pointer" class="text-secondary border-bottom-dashed edit-address mr-auto EditAddress">اصلاح این آدرس</a>
                                                    <span data-click="changeAddress" class="btn btn-outline-info btn-sm mr-16 rounded-sm">خرید برای دیگری</span>
                                                </div>
                                            @endif
                                            <div class="mb-12">
                                                <span>آدرس: </span>
                                                <span class="address-text">
                            <span class="address-string" id="address-string">{{$address->address}}</span>
                                <span class="address-plaque" id="address-plaque">پلاک {{$address->plaque}}</span>
                                                @if ($address->unit!="")
                                                        <span class="address-unit" id="address-unit">واحد{{$address->unit}}</span>
                                                    @endif
                                                    @if ($address->postal_code!="")
                                                        -<span class="address-postal_code" id="address-postal_code">کدپستی{{$address->postal_code}}</span>
                                                    @endif


                        </span>
                                            </div>
                                            <div class="mb-12">
                                                <span>شماره همراه:</span>
                                                <span class="address-mobile" id="address-mobile">{{$address->mobile}}</span>
                                            </div>




                                        </div>

                                    </div>
                                    <div class="address-list d-none">

                                        <div class="d-flex flex-column justify-content-center mb-16">
                                            <div class="d-flex">
                                                <span class="h6">آدرس تحویل سفارش خود را انتخاب نمایید</span>
                                                <span data-click="closeAddress" class="btn btn-outline-dark btn-sm mr-auto rounded-sm">انصراف</span>
                                            </div>

                                            <div class="d-flex flex-column justify-content-center mt-16">
                                                <button type="button" id="AddNewAddress" class="btn btn-block btn-outline-secondary rounded-sm" data-toggle="modal" data-target="#newAddressModal"><i class="ico ico-plus"></i>افزودن آدرس جدید</button>
                                            </div>
                                            <div class="address-list-data">
                                            @foreach($addresses as $address)
                                                <!--item-->
                                                    <a data-click="selectDeliveryAddress" data-id="{{$address->id}}" class="address-detail text-dark text-secondary d-block @if($address->selected=="YES") border-secondary @else border @endif  mt-16">
                                                        <div>
                                                            <div class="row no-gutters align-items-stretch ">
                                                                <div class="col-lg-12">
                                                                    <div class="pt-20 pr-20 pl-20">
                                                                        <div class="subtitle1">
                                                                            <div class="mb-12 d-flex">
                                                                                <span class="font-weight-bolder">تحویل گیرنده: </span>&nbsp;
                                                                                <span class="transfree-name">{{$address->name}}</span>
                                                                                <button data-id="{{$address->id}}" type="button" data-toggle="modal" data-target="#newAddressModal" class="btn btn-outline-secondary btn-sm mr-auto rounded-sm EditAddress">ویرایش</button>
                                                                                <button data-id="{{$address->id}}" type="button" class="btn btn-outline-primary btn-sm mr-4 rounded-sm deleteAdddress">حذف</button>
                                                                            </div>
                                                                            <div class="mb-12">
                                                                                <span>آدرس: </span>
                                                                                <span class="address-string">{{$address->address}}</span>
                                                                                <span class="address-plaque">پلاک {{$address->plaque}}</span>
                                                                                @if ($address->unit!="")
                                                                                    <span class="address-unit">واحد{{$address->unit}}</span>
                                                                                @endif
                                                                                @if ($address->postal_code!="")
                                                                                    -<span class="address-postal_code">کدپستی{{$address->postal_code}}</span>
                                                                                    @endif

                                                        </span>
                                                                            </div>
                                                                            <div class="mb-12">
                                                                                <span>شماره همراه:</span>
                                                                                <span class="address-mobile" id="address-mobile">{{$address->mobile}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="address-footer">
                                                                        <div class="border-top text-center @if($address->selected=="YES") bg-secondary @else bg-gray-100 @endif">
                                                                            <small class="text-white">سفارش به این آدرس ارسال می‌شود.</small>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!--item end-->
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <div class="d-flex flex-column justify-content-center mt-16">
                                            <button type="button" id="AddNewAddress" class="btn btn-block btn-outline-secondary rounded-sm" data-toggle="modal" data-target="#newAddressModal"><i class="ico ico-plus"></i>افزودن آدرس جدید</button>
                                        </div>
                                        @endif
                                </div>
                            </div>
                            <!--add new address end-->
                            <!--header-->
                            <div class="mb-16">
                                <div class="h5 font-weight-bold">انتخاب زمان ارسال</div>
                                <div class="text-caption text-muted">زمان ارسال کالا را با دقت تعیین نمایید تا هنگام دریافت به مشکل برنخورید</div>
                            </div>
                            <!--header-->
                            <!--select delivery time-->
                            <div class="card mb-16" data-storeid="3530">

                                <!--card-header-->
                                <!--card-header end-->
                                <!--product slider-->
                                <!--product slider end-->
                                <!--delivery type-->
                                <div class="card-body border-top">
                                    <div class="row small-gutters">

                                        <div class="col">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input shipping" id="shipping_4829" name="shipping_3530" data-type="2" data-storeid="3530" value="2" checked>
                                                <label class="custom-control-label w-100" for="shipping_4829">زمان حضور در محل<span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input shipping" id="shipping_4831_11" name="shipping_3530" data-cost="{{setting()['send_Special_price']}}" data-type="1"  value="1" >
                                                <label class="custom-control-label w-100" for="shipping_4831_11">پست ویژه<span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input shipping" id="shipping_4831_1" name="shipping_3530" data-type="3"  value="3" >
                                                <label class="custom-control-label w-100" for="shipping_4831_1">خرید برای آینده<span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="shippingDesc_2" class="text-danger h6 mt-12 shipping-desc" style="">لطفا زمان و تاریخی را که در آدرس تعیین شده حضور دارید را انتخاب کنید  </div>
                                    <div id="shippingDesc_1" class="text-danger h6 mt-12 shipping-desc" style="display: none;">ارسال 2 ساعته پس از سفارش </div>
                                    <div id="shippingDesc_3" class="text-danger h6 mt-12 shipping-desc" style="display: none;">لطفا تاریخ و زمان رزرو را انتخاب کنید
                                        <div class="form-group col-lg-12" style="display: flex">
                                            <div class="form-group col-lg-6">
                                                <label class="text-caption text-secondary" for="DOBString">تاریخ تحویل</label>
                                                <input type="" class="form-control" id="datetimepicker"
                                                       onclick="Mh1PersianDatePicker.Show(this,<?= "'" . Verta::now()->format('Y/n/j') . "'" ?>)"
                                                       name="datetimepicker" placeholder="تاریخ تحویل را انتخاب کنید" value="">
                                                <input type="hidden" id="DOBString" name="DOBString" value="">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <div class="form-control-wrapper">
                                                    <label class="text-caption text-secondary" for="DOBString">زمان تحویل</label>
                                                    <input type="text" id="datetimepicker_time" name="datetimepicker_time" class="form-control floating-label" placeholder="زمان تحویل را انتخاب کنید">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!--delivery type end-->
                                <!--select day and time-->
                                <div class="card-body border-top send-order" style="display: block;" id="deliveryTimes_3530">
                                    <div class="border">
                                        <ul class="nav nav-tabs nav-tabs-lg w-100">
                                            <?php $v=Verta();$ver=Verta();$time=1;$day=1; ?>

                                            @for ($i = 0; $i <= 5; $i++)
                                                <?php

                                                $time=$i-$i+1;
                                                $day=$i-$i+1;

                                                if($i==0){
                                                    $time=0;
                                                    $day=0;
                                                }
                                                    $day=$v->addDays($day)->formatWord('l');
                                                    $time=$ver->addDays($time)->formatDate();
                                                ?>
                                                <li class="nav-item">
                                                    <a class="nav-link @if($i==0)active @endif" style="line-height: 2rem;" href="#tab-3530-{{$i}}" data-day="{{$day.'-'.$time}}" data-toggle="tab">
                                                        {{$day}}<br>{{$time}}
                                                    </a>
                                                </li>
                                            @endfor

                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">

                                            @for($b=0;$b<6;$b++)
                                                @if ($b==0)
                                                    <div class="tab-pane container active" id="tab-3530-{{$b}}">
                                                        <?php
                                                        $time_v=Verta();
                                                        $time2_v=Verta();
                                                        ?>
                                                        @for ($i = 0; $i <= 5; $i++)
                                                            <?php
                                                            $time=$i-$i+3;
                                                            $time2=$i-$i+3;
                                                            if($i==0){
                                                                $time=1;
                                                                $time2=4;
                                                            }
                                                            $time=$time_v->addHour($time)->format('H');
                                                            $time2=$time2_v->addHour($time2)->format('H');
                                                            ?>
                                                            @if ($time<="24" and $time>="09")
                                                                @if ($time2<="24" and $time2>="09")
                                                                    <div class="custom-control custom-radio p-2 m-8">
                                                                        <input type="radio" value="{{$time.'-'.$time2}}" id="box-option-time-{{$i}}" name="deliveryTime" class="custom-control-input">
                                                                        <label class="custom-control-label d-block" for="box-option-time-{{$i}}">
                                                                            ساعت {{$time}} - {{$time2}}
                                                                        </label>
                                                                    </div>
                                                                @endif

                                                            @endif

                                                        @endfor

                                                    </div>
                                                @else
                                                    <div class="tab-pane container " id="tab-3530-{{$b}}">

                                                        <div class="custom-control custom-radio p-2 m-8">
                                                            <div class="d-flex flex-md-wrap justify-content-between">
                                                                <div>
                                                                    <input type="radio" class="custom-control-input" value="9-11" name="deliveryTime" id="box-option-time2-{{$b}}-1">
                                                                    <label class="custom-control-label d-block" for="box-option-time2-{{$b}}-1">
                                                                        <span class="w-16">ساعت  09 - 11</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="custom-control custom-radio p-2 m-8">
                                                            <div class="d-flex flex-md-wrap justify-content-between">
                                                                <div>
                                                                    <input type="radio" class="custom-control-input" value="11-13" name="deliveryTime" id="box-option-time2-{{$b}}-2">
                                                                    <label class="custom-control-label d-block" for="box-option-time2-{{$b}}-2">
                                                                        <span class="w-16">ساعت  11 - 13</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="custom-control custom-radio p-2 m-8">
                                                            <div class="d-flex flex-md-wrap justify-content-between">
                                                                <div>
                                                                    <input type="radio" class="custom-control-input " value="13-15" name="deliveryTime" id="box-option-time2-{{$b}}-3">
                                                                    <label class="custom-control-label d-block" for="box-option-time2-{{$b}}-3">
                                                                        <span class="w-16">ساعت  13 - 15</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="custom-control custom-radio p-2 m-8">
                                                            <div class="d-flex flex-md-wrap justify-content-between">
                                                                <div>
                                                                    <input type="radio" class="custom-control-input" value="15-17" name="deliveryTime" id="box-option-time2-{{$b}}-4">
                                                                    <label class="custom-control-label d-block" for="box-option-time2-{{$b}}-4">
                                                                        <span class="w-16">ساعت  15 - 17</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="custom-control custom-radio p-2 m-8">
                                                            <div class="d-flex flex-md-wrap justify-content-between">
                                                                <div>
                                                                    <input type="radio" class="custom-control-input" value="19-17" name="deliveryTime" id="box-option-time2-{{$b}}-5">
                                                                    <label class="custom-control-label d-block" for="box-option-time2-{{$b}}-5">
                                                                        <span class="w-16">ساعت  17 - 19</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="custom-control custom-radio p-2 m-8">
                                                            <div class="d-flex flex-md-wrap justify-content-between">
                                                                <div>
                                                                    <input type="radio" class="custom-control-input" value="19-21" name="deliveryTime" id="box-option-time2-{{$b}}-6">
                                                                    <label class="custom-control-label d-block" for="box-option-time2-{{$b}}-6">
                                                                        <span class="w-16">ساعت  19 - 21</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="custom-control custom-radio p-2 m-8">
                                                            <div class="d-flex flex-md-wrap justify-content-between">
                                                                <div>
                                                                    <input type="radio" class="custom-control-input" value="21-23" name="deliveryTime" id="box-option-time2-{{$b}}-7">
                                                                    <label class="custom-control-label d-block" for="box-option-time2-{{$b}}-7">
                                                                        <span class="w-16">ساعت  21 - 23</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif

                                            @endfor



                                        </div>
                                    </div>
                                    <input class="" type="hidden" name="day_send" value="">
                                    <input type="hidden" name="transfree-name">
                                    <input type="hidden" name="address-string">
                                    <input type="hidden" name="address-plaque">
                                    <input type="hidden" name="address-unit">
                                    <input type="hidden" name="address-postal_code">
                                    <input type="hidden" name="address-mobile">
                                </div>


                                <!--select day and time end-->

                            </div>
                            <!--select delivery time end-->

                            <a class="btn btn-sm btn-flat-dark rounded-sm" href="/cart"><i class="ico ico-chevron-up ico-rotate-90"></i>بازگشت به صفحه قبل</a>

                        </div>
                        <!--address wrap end-->
                        <!--shopping bag wrap-->
                        <aside id="sidebar" class="col-lg-4 mb-8">
                            <div data-sticky_column="" class="" style=""><div class="inner-wrapper-sticky" style="position: relative;">

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
                                                    <div class="font-weight-bolder"><span id="cartPriceTSide">{{number_format(array_sum(@$toral_old_price))}}</span><small class="mr-4">{{setting()['currency']}}</small></div>
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
                                                <!--item-->
                                                <li class="d-flex align-items-center justify-content-between my-4">
                                                    <div class="font-weight-bold">(+) هزینه حمل</div>
                                                    <div class="font-weight-bolder">
                                                        @if (array_sum($all_price)>=setting()['send_price_top'])
                                                            <span id="shippingCost" data-price="0">رایگان</span>
                                                        @else
                                                            <span id="shippingCost" data-price="{{setting()['send_price']}}">{{number_format(setting()['send_price'])}}</span><small class="mr-4">{{setting()['currency']}}</small>
                                                        @endif
                                                    </div>
                                                </li>
                                                <!--item end-->

                                            </ul>
                                            <!--product price details end-->

                                            <hr>

                                            <!--summery-->
                                            <div class="d-flex align-items-center justify-content-between mb-16 text-primary text-success">
                                                <div class="font-weight-bold">مبلغ قابل پرداخت</div>
                                                <div class="font-weight-bolder">
                                                    @if (array_sum($all_price)>=setting()['send_price_top'])
                                                        <span id="totalSpan" data-price="{{array_sum($price)}}">{{$total_price}}</span>
                                                        <span id="totalSpan2" style="display: none" data-price="{{array_sum($price)}}">{{$total_price}}</span>
                                                    @else
                                                        <span id="totalSpan" data-price="{{array_sum($price)+setting()['send_price']}}">{{number_format(array_sum($price)+setting()['send_price'])}}</span>
                                                        <span id="totalSpan2" style="display: none" data-price="{{array_sum($price)+setting()['send_price']}}">{{number_format(array_sum($price)+setting()['send_price'])}}</span>

                                                    @endif
                                                    <small class="mr-4 font-weight-normal">{{setting()['currency']}}</small></div>
                                            </div>
                                            <!--summery end-->

                                            <hr>
                                            <!--receiver info-->
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 mb-0">
                                                    <textarea name="description" id="desc" class="form-control" rows="3" placeholder="چنانچه توضیحات اضافه ای دارید در اینجا وارد کنید"></textarea>
                                                </div>
                                            </div>
                                            <!--receiver info end-->

                                            <hr>
                                            <div class="d-flex align-items-center">
                                                <button type="submit" id="" class="btn btn-gradient-primary w-100" data-click="saveAndProcced"><i class="ico ico-exit"></i>انتخاب نحوه پرداخت</button>
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
                    <!--address and shopping bag wrap end-->
                    <!--button controller-->
                </form>

            </div>
        </div>

        <div class="modal" id="newAddressModal" tabindex="-1" role="dialog" aria-labelledby="newAddressModalLabel"
             aria-modal="true" style="padding-right: 17px;">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">

                    <!--header-->
                    <div class="modal-header">
                        <h5 class="modal-title text-primary">ثبت آدرس جدید</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ico ico-close ico-fw-0"></i></span>
                        </button>
                    </div>
                    <!--header end-->


                    <div class="modal-body">
                        <form class="submit-form" method="post" id="frmAddAddress" action="/profile/saveaddresse"
                              novalidate="novalidate">
                            @csrf
                            <input type="hidden" value="0" data-val="true"
                                   data-val-required="The Id field is required." id="Id" name="Id">
                            <input type="hidden" value="0" data-val="true"
                                   data-val-required="The SectorId field is required." id="SectorId"
                                   name="SectorId">
                            <input type="hidden" data-val="true" data-val-number="The field Lat must be a number."
                                   id="Lat" name="Lat" value="">
                            <input type="hidden" data-val="true" data-val-number="The field Lng must be a number."
                                   id="Lng" name="Lng" value="">
                            <input type="hidden" value="1" data-val="true"
                                   data-val-required="The Type field is required." id="Type" name="Type">
                            <input type="hidden" data-val="true"
                                   data-val-required="The IsCheckout field is required." id="IsCheckout"
                                   name="IsCheckout" value="False">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group d-flex justify-content-between">
                                        <div class="w-50 ml-8">
                                            <label class="text-caption" for="Transferee">نام و نام خانوادگی تحویل
                                                گیرنده<em class="mr-4 text-danger">*</em></label>
                                            <input type="text" class="form-control " data-val="true"
                                                   data-val-length="نام و نام خانوادگی تحویل گیرنده نمی تواند بیشتر از 150 کاراکتر باشد"
                                                   data-val-length-max="100"
                                                   data-val-required="نام و نام خانوادگی تحویل گیرنده ضروری است"
                                                   id="Transferee" maxlength="100" name="name" value="">
                                            <span class="text-danger field-validation-valid" data-valmsg-for="name" data-valmsg-replace="true"></span>

                                        </div>

                                        <div class="w-50">
                                            <label class="text-caption" for="MobilePhone">شماره همراه<em class="mr-4 text-danger">*</em></label>
                                            <input type="text" class="form-control" data-val="true"
                                                   data-val-regex="فرمت شماره همراه نامعتبر است" data-val-required="شماره ضروری است"
                                                   data-val-regex-pattern="^[0|۰]{1}[9|۹]{1}[۰|0-۹|9]{9}"
                                                   id="mobile" name="mobile" value="">
                                            <span class="text-danger field-validation-valid"
                                                  data-valmsg-for="mobile" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-caption" for="Address">آدرس<em
                                                class="mr-4 text-danger">*</em></label>
                                        <input type="text" class="form-control" data-val="true"
                                               data-val-length="آدرس نمی تواند بیشتر از 500 کاراکتر باشد"
                                               data-val-length-max="500" data-val-required="آدرس ضروری است"
                                               id="Address" maxlength="500" name="address" value="">
                                        <span class="text-danger field-validation-valid" data-valmsg-for="address"
                                              data-valmsg-replace="true"></span>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <div class="w-20 ml-8">
                                            <label class="text-caption" for="Plaque">پلاک<em
                                                    class="mr-4 text-danger">*</em></label>
                                            <input type="text" class="form-control" dir="ltr" data-val="true"
                                                   data-val-length="پلاک نمی تواند بیشتر از 20 کاراکتر باشد"
                                                   data-val-length-max="20" data-val-required="پلاک ضروری است"
                                                   id="Plaque" maxlength="20" name="plaque" value="">
                                            <span class="text-danger field-validation-valid"
                                                  data-valmsg-for="plaque" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="w-20 ml-8">
                                            <label class="text-caption" for="Unit">واحد</label>
                                            <input type="text" class="form-control" dir="ltr" data-val="true"
                                                   data-val-length="واحد نمی تواند بیشتر از 20 کاراکتر باشد"
                                                   data-val-length-max="20" id="unit" maxlength="20" name="unit">
                                        </div>
                                        <div class="w-60">
                                            <label class="text-caption" for="PostalCode">کد پستی</label>
                                            <input type="text" class="form-control" dir="ltr" data-val="true" data-val-length="کد پستی نمی تواند کمتر از 10 کاراکتر باشد"
                                                    data-val-length-min="10"  id="postalcode" maxlength="10" minlength="10"
                                                   name="postalcode" value="">
                                            <span class="text-danger field-validation-valid"
                                                  data-valmsg-for="postalcode" data-valmsg-replace="true"></span>
                                            <input type="hidden" name="status" value="">
                                            <input type="hidden"  name="Map" value="">
                                        </div>
                                    </div>
                                    <!--confirm btn-->
                                    <button type="submit" data-click="saveAddress"
                                            class="btn btn-block btn-primary mt-8"><i
                                            class="ico ico-checkbox filter-white"></i>تایید آدرس
                                    </button>
                                </div>

                                <div class="col-lg-6">
                                    <!--find address input-->
                                    <span>برای ثبت آدرس خود، روی مکان مورد نظر روی نقشه کلیک کنید</span>
                                    <div id="app">

                                    </div>

                                </div>
                            </div>


                        </form>
                        <!--confirm btn end-->
                    </div>
                </div>
            </div>
        </div>



    </section>
    <div data-controller="ProfileAddress"></div>

    <!--login layout wrap end-->

</main>


<!--footer-->

@extends('front.layout.footer')
<!--footer end-->


<script src="{{asset('assets/js/bundle.js')}}"></script>

<script src="{{asset('assets/js/fontawesome.js')}}"></script>
<script src="{{asset('assets/js/profile-address.es5.min.js')}}"></script>
<script src="{{asset('assets/js/send-order.es5.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script src="{{asset('js/Mh1PersianDatePicker.js')}}"></script>

<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/bootstrap-material-datetimepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('map/js/mapp.env.js')}}"></script>
<script type="text/javascript" src="{{asset('map/js/mapp.min.js')}}"></script>
<script>
    function number_3_3(num, sep) {
        var number = typeof num === "number" ? num.toString() : num,
            separator = typeof sep === "undefined" ? ',' : sep;
        return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
    }


    $('#app').click(function () {

        setTimeout(function(){
            var contents=$('.mapp-modal > .contents').text();
            contents=contents.split('عرض');
            $('input[name=address]').val(contents[0]);
        }, 500);

    })


    $('input[name=shipping_3530]').click(function () {
        var send_Special_price=$(this).attr('data-cost');
        if (send_Special_price!=undefined){
            var data_price=$('#shippingCost').attr('data-price');
            var data_price_total=$('#totalSpan').attr('data-price');
            if (data_price==0){
                $('#shippingCost').text(number_3_3(parseInt(send_Special_price)+parseInt(data_price))+" تومان ");
            }else {
                $('#shippingCost').text(number_3_3(parseInt(send_Special_price)+parseInt(data_price)));
            }
            $('#totalSpan').hide();
            $('#totalSpan2').show();
            $('#totalSpan2').text(number_3_3(parseInt(send_Special_price)+parseInt(data_price_total)));

        }else {
            var data_price=$('#shippingCost').attr('data-price');
            if (data_price==0){
                data_price="رایگان"
            }
            $('#totalSpan').show();
            $('#totalSpan2').hide();
            $('#shippingCost').text(number_3_3(data_price));
        }
    })
</script>

@if(session('save_address'))
    <script>
        alertify.set('notifier','position', 'top-right');
        alertify.success('آدرس جدید با موفقیت ثبت شد');
    </script>
@endif
@if(session('save_address_update'))
    <script>
        alertify.set('notifier','position', 'top-right');
        alertify.success('آدرس شما با موفقیت ویرایش شد');
    </script>
@endif

@if(session('error-sendorder-back'))
    <script>
        alertify
            .alert("<?= session('error-sendorder-back') ?>", function(){

            }).set('label', 'خب').setHeader('<em> پیغام </em> ');
    </script>
@endif
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
    $('.nav-link').click(function () {
        var day=$(this).attr('data-day');
        $('input[name=day_send]').val(day)
    })
    $(document).ready(function()
    {
        $('input[name=transfree-name]').val($('#transfree-name').text())
        $('input[name=address-string]').val($('#address-string').text())
        $('input[name=address-plaque]').val($('#address-plaque').text())
        $('input[name=address-unit]').val($('#address-unit').text())
        $('input[name=address-postal_code]').val($('#address-postal_code').text())
        $('input[name=address-mobile]').val($('#address-mobile').text())
        var day=$('.nav-link.active').attr('data-day');
        $('input[name=day_send]').val(day)
        $('input[name=shipping_3530]').click(function () {
            $('#datetimepicker').val('');
            $('#datetimepicker_time').val('');
        })

    $('#datetimepicker_time').bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: false,
        format: 'HH:mm'
    });
    });
</script>
<script>
    /*$("#datetimepicker").persianDatepicker({
        startDate: "<?=  Verta::now()->format('Y/n/j') ?>",
        endDate:"today"
    });*/
    $('.address-detail').click(function () {
        var item=this;
        var data_id=$(item).attr('data-id');
        var CSRF_TOKEN = '{{ csrf_token() }}';
        var url = '{{route('address.selectDefaultAddress')}}';
        var data = {_token: CSRF_TOKEN,data_id:data_id};
        $.post(url, data, function (msg) {

        });
        $('input[name=transfree-name]').val('')
        $('input[name=address-string]').val('')
        $('input[name=address-plaque]').val('')
        $('input[name=address-unit]').val('')
        $('input[name=address-postal_code]').val('')
        $('input[name=address-mobile]').val('')

        $('input[name=transfree-name]').val($(item).find('.transfree-name').text())
        $('input[name=address-string]').val($(item).find('.address-string').text())
        $('input[name=address-plaque]').val($(item).find('.address-plaque').text())
        $('input[name=address-unit]').val($(item).find('.address-unit').text())
        $('input[name=address-postal_code]').val($(item).find('.address-postal_code').text())
        $('input[name=address-mobile]').val($(item).find('.address-mobile').text())
        $('.modal-title ').text('افزودن آدرس جدید')
    })
    $('.deleteAdddress').click(function () {
        var item=this;
        var data_id=$(this).attr('data-id');
        alertify.confirm("آیا از حذف مطمئن هستید؟",
            function () {
                $.ajax({
                    type: "post",
                    url: "{{route('address.removeAddress')}}",
                    data: {
                        id: data_id,
                        _token: '{{csrf_token()}}',
                    },
                    dataType: 'json',
                    success: function () {
                        $(item).parents('.address-detail').remove();
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
    })

    $('.EditAddress').click(function () {
        $('#app').empty();
        var data_id=$(this).attr('data-id');

        var CSRF_TOKEN = '{{ csrf_token() }}';
        var url = '{{route('address.get_info_address')}}';
        var data = {_token: CSRF_TOKEN,data_id:data_id};
        $.post(url, data, function (msg) {
            $('#frmAddAddress').append(' <input type="hidden" name="data_id" value="'+data_id+'">');
            $('#frmAddAddress').append(' <input type="hidden" name="back_url" value="/sendorder">');
            $('#frmAddAddress input[name=status]').val('update');
            $('#frmAddAddress input[name=name]').val(msg.name);
            $('#frmAddAddress input[name=mobile]').val(msg.mobile);
            $('#frmAddAddress input[name=address]').val(msg.address);
            $('#frmAddAddress input[name=plaque]').val(msg.plaque);
            $('#frmAddAddress input[name=unit]').val(msg.unit);
            $('#frmAddAddress input[name=postalcode]').val(msg.postal_code);
            $('#frmAddAddress input[name=Map]').val(msg.Map);
            $('.modal-title ').text('ویرایش آدرس');
            $(document).ready(function () {
                var app = new Mapp({
                    element: '#app',
                    presets: {
                        latlng: {
                            lat: msg.lat,
                            lng: msg.lng,
                        },
                        zoom: 13
                    },
                    apiKey: '{{setting()['Api_map']}}'
                });
                app.addLayers();
                app.map.on('click', function (e) {
                    var crosshairIcon = {
                        iconUrl: '{{asset('map/assets/images/marker-icon.png')}}',
                        iconSize: [20, 20], // size of the icon
                        iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
                    }

                    var marker = app.addMarker({
                        name: 'advanced-marker',
                        latlng: {
                            lat: e.latlng.lat,
                            lng: e.latlng.lng,
                        },
                        icon: crosshairIcon,
                        popup:false,
                        pan: false,
                        draggable: true,
                        history: false,
                    });
                    $('input[name=Map]').val(marker._latlng);

                    app.showReverseGeocode({
                        state: {
                            latlng: {
                                lat: e.latlng.lat,
                                lng: e.latlng.lng,
                            },
                            zoom: 16,
                        },
                    });

                })
            });
        });
    })

    $('#AddNewAddress').click(function () {
        $('#app').empty();
        $('#frmAddAddress').append(' <input type="hidden" name="back_url" value="/sendorder">');
        $('#frmAddAddress input[name=status]').val('insert');
        $('#frmAddAddress input[name=name]').val("");
        $('#frmAddAddress input[name=mobile]').val("");
        $('#frmAddAddress input[name=address]').val("");
        $('#frmAddAddress input[name=plaque]').val("");
        $('#frmAddAddress input[name=unit]').val("");
        $('#frmAddAddress input[name=postalcode]').val("");
        $('#frmAddAddress input[name=data_id]').remove();
        $('.modal-title ').text('افزودن آدرس جدید');
        $(document).ready(function () {
            var app = new Mapp({
                element: '#app',
                presets: {
                    latlng: {
                        lat: 36.29991,
                        lng: 50.01080,
                    },
                    zoom: 13
                },
                apiKey: '{{setting()['Api_map']}}'
            });
            app.addLayers();
            app.map.on('click', function (e) {
                var crosshairIcon = {
                    iconUrl: '{{asset('map/assets/images/marker-icon.png')}}',
                    iconSize: [20, 20], // size of the icon
                    iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
                }

                var marker = app.addMarker({
                    name: 'advanced-marker',
                    latlng: {
                        lat: e.latlng.lat,
                        lng: e.latlng.lng,
                    },
                    icon: crosshairIcon,
                    popup:false,
                    pan: false,
                    draggable: true,
                    history: false,
                });
                $('input[name=Map]').val(marker._latlng);

                app.showReverseGeocode({
                    state: {
                        latlng: {
                            lat: e.latlng.lat,
                            lng: e.latlng.lng,
                        },
                        zoom: 16,
                    },
                });

            })
        });
    })
</script>
@php
    Session::forget('save_address');
    Session::forget('save_address_update');
    Session::forget('error-sendorder-back');
@endphp
