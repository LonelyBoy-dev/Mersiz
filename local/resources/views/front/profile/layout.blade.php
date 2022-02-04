@extends('front.layout.master')
@section('style_link')

@endsection
@section('style')

@endsection


@section('content')
    @yield('style_link_profile')
    <style>
        .bell-icon{
            position: absolute;
            left: 10px;
            top: 10px;
            width: 50px;
            display: block;
            height: 50px;
            cursor: pointer;

        }
    </style>
    <div class="container my-16">

        <!--wrap main-->
        <div class="row">

            <!--sidebar wrap-->
            <aside class="col-xxl-2 col-lg-3">

                <!--header aside-->
                <aside style="margin-bottom: 20px" class="list-group list-group-secondary list-group-borderless">
                    <div class="card card-equal-height">

                        <div class="card-body my-auto text-center">
                            <a class="bell-icon" href="/profile/messages"  style="background: url({{asset('images/unnamed.gif')}});background-size: 200% 160%;background-position: center;"></a>
                            <div class="user-account-welcome">
                                <i style="font-size: 80px;color: #16b47c;" class="far fa-user-circle"></i>
                            </div>
                            <div class="h5 small">@if(Auth::user()->name!="" or Auth::user()->family!=""){{Auth::user()->name.' '.Auth::user()->family}} @else {{Auth::user()->mobile}} @endif</div>

<!--                            <div class="text-muted subtitle2 text-right">
                                <span>امتیاز من:</span>
                                <strong class="float-left">
        <span class="customer-credit">
            0
        </span>

                                </strong>
                            </div>-->

                            <div class="text-muted subtitle2 text-right">
                                <span>موجودی کیف پول:</span>
                                <strong class="float-left">
        <span class="customer-credit">
            <?php $user=App\User::with('orders')->where('id',Auth::id())->first(); ?>
            {{$user->Marketing_price}}
        </span>
                                    {{setting()['currency']}}
                                </strong>
                            </div>
                        </div>

                        <div class="mt-auto overflow-hidden">
                            <a class="btn btn-outline-primary btn-block rounded-0" href="/logout">خروج</a>
                        </div>

                    </div>
                </aside>
                <!--header aside end-->

                <!--aside-box-->
                <div class="card">
                    @php $url=url()->current();
                    $url=explode('/',url()->current());
                     @endphp
                    <div class="list-group list-group-secondary list-group-borderless">

                        <!--item active-->
                        <a class="list-group-item list-group-item-action @if(@$url[4]=="")active @endif" href="/profile">
                            <i class="ico ico-user ico-fw-left-lg"></i>
                            <span>حساب کاربری</span>
                        </a>
                        <!--item active end-->
                        <!--item-->
                        <a class="list-group-item list-group-item-action @if(@$url[4]=="comments")active @endif" href="/profile/comments">
                            <i style="font-size: 21px;" class="far fa-comment-alt ico-fw-left-lg"></i><span> نظر های من</span>
                        </a>
                        <!--item end-->
                        <!--item-->
                        <a class="list-group-item list-group-item-action  @if(@$url[4]=="address")active @endif" href="/profile/address">
                            <i style="font-size: 21px;" class="fas fa-map-signs ico-fw-left-lg"></i>
                            <span>آدرس های من</span>
                        </a>
                        <!--item end-->
                        <!--item-->
                        <a class="list-group-item list-group-item-action  @if(@$url[4]=="invitefriends")active @endif" href="/profile/invitefriends">
                            <i class="ico ico-contact-list ico-fw-left-lg"></i>
                            <span>لینک بازاریابی</span>
                        </a>
                        <!--item end-->
                        <!--item-->

                        <!--item end-->
                        <!--item-->
<!--                        <a class="list-group-item list-group-item-action  @if(@$url[4]=="bankcard")active @endif" href="/profile/bankcard">
                            <i class="ico ico-credit-card ico-fw-left-lg"></i>
                            <span>درخواست وجه نقد</span>
                        </a>-->
                        <a class="list-group-item list-group-item-action  @if(@$url[4]=="orders")active @endif" href="/profile/orders">
                            <i class="ico ico-refresh ico-fw-left-lg"></i>
                            <span>تاریخچه خرید</span>
                        </a>
                        <!--item end-->
                        <!--item-->
<!--                        <a class="list-group-item list-group-item-action " href="/profile/shoppinglist">
                            <i class="ico ico-bag ico-fw-left-lg"></i>
                            <span>لیست خرید</span>
                        </a>-->
                        <!--item end-->
                        <!--item-->
<!--                        <a class="list-group-item list-group-item-action @if(@$url[4]=="walletmanagement")active @endif" href="/profile/walletmanagement">
                            <i style="font-size: 21px;" class="fas fa-money-check-alt ico-fw-left-lg"></i>
                            <span>مدیریت کیف پول</span>
                        </a>-->
                        <!--item end-->
                        <!--item-->
                        <a class="list-group-item list-group-item-action @if(@$url[4]=="complain")active @endif" href="/profile/complain">
                            <i style="font-size: 21px;" class="far fa-comment-dots ico-fw-left-lg"></i>
                            <span>شکایات و پیشنهادات</span>
                        </a>
                        <!--item end-->
                        <!--item-->
{{--                        <a class="list-group-item list-group-item-action " href="/profile/smssetting">--}}
{{--                            <i class="ico ico-comment-text ico-fw-left-lg"></i>--}}
{{--                            <span>تنظیمات پیامک</span>--}}
{{--                        </a>--}}
                        <!--item end-->
                    </div>

                </div>
                <!--aside-box end-->

            </aside>
            <!--sidebar wrap end-->
            <!--content wrap-->
            <div id="profile-wrapper" class="col-xxl-10 col-lg-9">
                @yield('content_panel')
            </div>
            <!--content wrap end-->

        </div>
        <!--wrap main end-->

    </div>
@endsection


@section('script_link')

@endsection
