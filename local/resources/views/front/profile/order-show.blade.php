@extends('front.profile.layout')
@section('style')
    <style>
        .item .box-option_label{
            display: flex;
            border: unset;
            border-bottom: 1px solid #ccc !important;
            border-radius: unset !important;
        }
        .c-profile-comments__status--approved {
            border-color: #4caf50;
            background-color: rgba(76,175,80,.1);
            color: #2e7b32;

        }
        .c-profile-comments__status--Waiting {
            border-color: #f9a825;
            background-color: rgba(249,168,37,.1);
            color: #f57f17;

        }
        .c-profile-comments__status {
            width: 86px;
            font-size: 12px;
            font-size: .857rem;
            line-height: 22px;
            padding: 0 12px;
            border: 1px solid #fff;
            border-radius: 8px;
            left: 0;
        }
        .c-profile-comments__status--rejected {
            border-color: #d32f2f;
            background-color: rgba(211,47,47,.1);
            color: #b2001a;
        }
        .table th, .table td{
            border-top: unset;
        }
        .o-link {
            display: inline-block;
            color: #00bfd6!important;
            font-size: 14px;
            line-height: 28px;
            font-weight: 700;
            cursor: pointer;
            background: transparent;
        }
        .c-profile-order__list-item-detail {
            font-size: 14px;
            line-height: 1.571;
            color: #232933;
            font-weight: 500;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .c-profile-order__list-item-detail2 {
            font-size: 14px;
            line-height: 1.571;
            color: #232933;
            font-weight: 500;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .c-profile-order__list-item-detail:last-child:before {
            content: "";
            background: #dfdfdf;
            width: 4px;
            height: 4px;
            margin: auto 12px;
            display: inline-block;
            border-radius: 50%;
        }
        .c-profile-order__list-item-details-row{
            display: flex;
        }
        .c-profile-order__list-item-details{
            padding: 16px;
        }
        .c-profile-order__list-item-details-row2{
            margin-top: 8px;
        }
        .card-header.card-header-right-border>div{
            border-bottom: 1px solid #dfdfdf;
            border-bottom-width: 1px;
            border-bottom-style: solid;
            border-bottom-color: rgb(223, 223, 223);
        }
        .o-box__separator {
            height: 1px;
            background-color: #dfdfdf;
            margin-right: -24px;
            margin-left: -24px;
        }
        .c-profile-order__list-item {
            border: 1px solid #dfdfdf;
            border-radius: 8px;
            margin-top: 16px;
        }
        .c-profile-order__list-item-details-top {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            margin-bottom: 16px;
        }
        .c-profile-order__list-item-details-row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .c-profile-order__list-item-product {
            padding: 16px 24px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            border-top: 1px solid #dfdfdf;
        }
        .c-profile-order__list-item-product-content {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
        }
        .c-profile-order__list-item-product-top-bar {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .c-profile-order__list-item-product-title {
            color: #232933;
            font-size: 12px;
            line-height: 1.833;
            font-weight: 700;
        }
        .o-btn--icon-gray-md {
            padding: 9px 16px;
            direction: rtl;
            font-size: 14px;
            line-height: 1.571;
            font-weight: 700;
            padding: 12px!important;
        }
        .c-profile-order__list-item-detail-title {
            color: #81858b;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            margin-left: 4px;
        }
        .c-profile-order__list-item-product-img img {
            width: 100%;
            max-height: 100%;
            -o-object-fit: contain;
            object-fit: contain;
        }
        .c-profile-order__list-item-product-img {
            width: 140px;
            height: 140px;
            margin-left: 24px;
            position: relative;
        }
        .c-profile-order__list-item-details .c-order-status-bar {
            width: 320px;
        }
        .c-order-status-bar__progress {
            position: relative;
            height: 6px;
            border-radius: 6px;
            background-color: rgba(3,10,22,.1);
            margin-top: 10px;
        }
        .c-order-status-bar__progress-bar {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            border-radius: 6px;
        }
    </style>
@endsection
@section('content_panel')
    <?php
    foreach($orders as $order){
        $total_discount[]=$order->disprice*$order->count;
    }

    ?>
    <div class="card mb-16" data-controller="ProfileShoppingHistory">

        <!--card header-->
        <div class="card-header card-header-right-border">
            <div class="w-100-lg">
                <div class="card-header_caption" style="    justify-content: space-between;">
                    <div class="card-header_caption-title">
                        <div class="card-header_caption-text" STYLE="font-size: 20px;margin-left: 16px;">جزئیات سفارش</div>
                        <div class="c-profile-order__list-item-detail">{{Verta::instance($orders[0]->created_at)->format('%d %B %Y')}}</div>
                        <div class="c-profile-order__list-item-detail">{{$orders[0]->factor_number}}</div>
                    </div>
                  <div>
                      <a href="/profile/orders/{{$orders[0]->factor_number}}/invoice">مشاهده فاکتور</a>
                  </div>
                </div>
            </div>


        </div>
        <div class="w-100-lg" style="padding: 0 19px;">
        <div class="c-profile-order__list-item-details"><div class="c-profile-order__list-item-details-row"><div class="c-profile-order__list-item-detail"><span class="c-profile-order__list-item-detail-title">تحویل گیرنده:</span>
                    {{$orders[0]->name}}</div><div class="c-profile-order__list-item-detail"><span class="c-profile-order__list-item-detail-title">شماره تماس:</span>
            {{$orders[0]->mobile}}</div></div><div class="c-profile-order__list-item-details-row2"><div class="c-profile-order__list-item-detail2"><span class="c-profile-order__list-item-detail-title">ارسال به:</span>
                    {{$orders[0]->address}}</div></div></div>

        <div style="border-top: 1px solid #dfdfdf;" class="c-profile-order__list-item-details c-profile-order__list-item-details--between"><div class="c-profile-order__list-item-details-row"><div class="c-profile-order__list-item-detail c-profile-order__list-item-detail--currency"><span class="c-profile-order__list-item-detail-title">مبلغ کل:</span>
            {{number_format($orders[0]->total).' '.setting()['currency']}}</div><div class="c-profile-order__list-item-detail c-profile-order__list-item-detail--currency"><span class="c-profile-order__list-item-detail-title">تخفیف:</span>
                    {{number_format(array_sum($total_discount)).' '.setting()['currency']}}</div></div><div class="o-btn o-btn--link-gray-md o-btn--black o-btn--l-expand-more js-payment-records-btn">
            </div></div>


            <div class="o-box__separator"></div>
            <div class="c-profile-order__list-item">
                <div class="c-profile-order__list-item-details">
                    <div class="c-profile-order__list-item-details-top">
                            <div class="c-profile-order__list-item-details-row"><div class="c-profile-order__list-item-details-row"><div class="c-profile-order__list-item-detail"><span class="c-profile-order__list-item-detail-title">تحویل:</span>
                                      @if($orders[0]->send_day=="پست ویژه")
                                {{$orders[0]->send_day}}
                                        @else
                                            {{$orders[0]->send_day.' بازه '.$orders[0]->send_time}}
                                        @endif


                                </div>
                                </div>
                            </div>
                        @if ($orders[0]->day_status!="")
                            <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 255px;">
                                تحویل: {{$orders[0]->day_status}} بدلیل مشکل پیش آمده
                            </div>
                        @endif

                        <div class="c-order-status-bar"><div class="c-order-status-bar__status"><div class="c-order-status-bar__current-status" style="color: #2e7b32;">
                                    @if ($orders[0]->send_status=="در حال برسی")
                                        <?php $darsad=0; ?>
                                        <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 110px;">
                                            در انتظار بررسی
                                        </div>
                                    @elseif ($orders[0]->send_status=="در حال پیگیری سفارش")
                                        <?php $darsad=25; ?>
                                        <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 151px;background-color: rgb(237 255 56 / 37%);color: #959e0b;">
                                            در حال پیگیری سفارش
                                        </div>
                                    @elseif ($orders[0]->send_status=="در حال بسته بندی")
                                        <?php $darsad=50; ?>
                                        <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 126px;background-color: rgb(134 92 25 / 10%);color: #8e613a;">
                                            در حال بسته بندی
                                        </div>
                                    @elseif ($orders[0]->send_status=="ارسال شده")
                                        <?php $darsad=75; ?>
                                        <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 84px;background-color: rgb(207 218 44 / 14%);color: #c3da05;">
                                            ارسال شده
                                        </div>
                                    @elseif ($orders[0]->send_status=="تحویل داده شده")
                                        <?php $darsad=100; ?>
                                        <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 116px;background-color: rgb(61 185 30 / 10%);color: #269c18;">
                                            تحویل داده شده
                                        </div>
                                    @endif
                                </div></div><div class="c-order-status-bar__progress"><div class="c-order-status-bar__progress-bar" style="background-color: #4caf50; width: {{$darsad}}%;"></div></div></div></div><div class="c-profile-order__list-item-details-row "><div class="c-profile-order__list-item-detail c-profile-order__list-item-detail--currency"><span class="c-profile-order__list-item-detail-title">جمع قیمت کالاهای مرسوله:</span>
                    {{number_format($orders[0]->total).' '.setting()['currency']}}
                        </div><div class="c-profile-order__list-item-detail "><span class="c-profile-order__list-item-detail-title">هزینه ارسال:</span>
                            @if($orders[0]->send_price!="رایگان")
                                {{number_format($orders[0]->send_price)}}
                            @else
                                {{$orders[0]->send_price}}
                                @endif

                        </div>

                    </div>
                </div>
                <div class="c-profile-order__list-item-products">
                    @foreach($orders as $order)
                        <?php $product=App\Product::find($order->product_id); ?>
                    <div class="c-profile-order__list-item-product">
                        <a href="/product/{{$product->slug}}" class="c-profile-order__list-item-product-img">
                            @if($product->image)
                                @if(file_exists(public_path() . '/' . $product->image))
                                    <img src="{{asset($product->image)}}" alt="{{$product->title}}">
                                @else
                                    <img src="{{asset('images/nopic.png')}}" alt="{{$product->title}}">
                                @endif

                            @else
                                <img src="{{asset('images/nopic.png')}}" alt="{{$product->title}}">
                            @endif

                        </a>
                        <div class="c-profile-order__list-item-product-content">
                            <div class="c-profile-order__list-item-product-top-bar">
                                <div class="c-profile-order__list-item-product-title">{{$product->title}}</div>
                            </div>
                            <div style="margin: 10px 0;" class="c-profile-order__list-item-detail c-profile-order__list-item-detail--currency"><span class="c-profile-order__list-item-detail-title">تعداد:</span>
                                {{$order->count}}
                            </div>
                            <div class="c-profile-order__list-item-product-detail"><span class="c-profile-order__list-item-product-detail-color" style="background-color: #212121"></span>
                                </div><div class="c-profile-order__list-item-product-detail c-profile-order__list-item-product-detail--guarantee"></div><div class="c-profile-order__list-item-product-detail c-profile-order__list-item-product-detail--seller"></div>
                            <div class="c-profile-order__list-item-details-row">
                                <div class="c-profile-order__list-item-detail c-profile-order__list-item-detail--currency"><span class="c-profile-order__list-item-detail-title">قیمت واحد:</span>
                                {{number_format($order->price).' '.setting()['currency']}}
                                </div>
                                <div class="c-profile-order__list-item-detail item-detail c-profile-order__list-item-detail--currency"><span class="c-profile-order__list-item-detail-title">تخفیف:</span>
                                    {{number_format($order->disprice).' '.setting()['currency']}}
                                </div>

                            </div>
                            <div style="margin-top: 10px" class="c-profile-order__list-item-details-row">
                                <div class="c-profile-order__list-item-detail2 c-profile-order__list-item-detail--currency"><span class="c-profile-order__list-item-detail-title">قیمت با تخفیف:</span>
                                    {{number_format($order->payprice).' '.setting()['currency']}}
                                </div>
                            </div>

                        </div></div>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="card-body">


        </div>
        <!--card body end-->


    </div>

@endsection
