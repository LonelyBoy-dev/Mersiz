@extends('front.layout.master')
@section('style_link')
    <script src="{{asset('assets/css/scroll/jquery.mCustomScrollbar.css')}}"></script>
@endsection
@section('style')
    <style>
        .meta li {
            font-size: 15px;
            font-weight: 500;
            line-height: 30px;
            text-transform: capitalize;
            margin-bottom: 0
        }

        .meta {
            padding-right: 0;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-bottom: 5px;
            list-style: none;
        }

        .post .product-box_title {
            width: 100%;
            margin: 0;
            height: auto;
            text-align: right;
            height: 110px;
        }

        .post .product-box_title h2 {
            font-size: 0.85rem;
            text-align: right;
            width: 100%;
            font-weight: 600;
        }

        .slider-min-top .swiper-button-prev.swiper-button-custom, .swiper-button-next.swiper-button-custom {
            width: 15px
        }


        .slider-min-top .product-box {
            padding: 0 5px;
        }

        .slider-min-top .product-box_discount {
            width: 45px;
            height: 45px;
            right: 12px;
        }

        .slider-min-top .product-box_discount small {
            font-size: 75%;
        }

        .slider-min-top .product-box_title {
            margin-top: 0;
        }

        .slider-min-top .product-box_price {
            margin-bottom: 5px;
        }

        .slider-min-top .product-box_action {
            margin-bottom: 5px;
        }



  


        .swiper-brand {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }


        #marquee-block-2 {
            width: 100%;
            margin: 0 auto;
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
            direction: rtl;
            padding: 10px;
        }

        #marquee-text-2 {
            display: inline-block;
            padding-right: 100%;
            animation: marquee-2 20s linear infinite;
        }

        #marquee-text-2:hover {
            animation-play-state: paused;
        }

        @keyframes marquee-2 {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(100%, 0);
            }
        }
          @php $agent=new Jenssegers\Agent\Agent();@endphp
        @if ($agent->isMobile())
           
         .slider-top .img-fluid {
            height: 200px;
        }
        @else
        .slider-top .img-fluid {
            height: 100%;
        }
        @endif
        .swiper-button-next.swiper-button-custom, .swiper-container-rtl .swiper-button-prev.swiper-button-custom{
            right: -11px;
            left: auto;
        }
    </style>
@endsection
@section('content')
    <!--section slide-show and day-offer-->
    @if(count($Announcements) or count($newss))
        <section>
            <div class="container" style="margin-top: 17px">
                <div class="card">
                    <div id="marquee-block-2">
                    <span id="marquee-text-2">
                        @if(count($newss))
                            @foreach($newss as $news)
                                <a style="color: #555;margin: 0 10px;">{{$news->title}}</a>@if(count($newss)>1) | @endif
                            @endforeach
                        @endif
                        @if(count($Announcements))
                        @foreach($Announcements as $Announcement)
                                    @if(count($newss)) | @endif
                            <a style="color: #555;margin: 0 10px;" href="/blog/{{$Announcement->slug}}">{{$Announcement->title}}</a>@if(count($Announcements)>1) | @endif
                        @endforeach
                        @endif

                    </span>
                    </div>
                </div>
            </div>
        </section>
    @endif

        <section>
            <div class="container py-24">
                <div class="row">

                    <div class="col-xl-9 order-0 mb-20 mb-xl-0 d-flex flex-column">
                        <div id="slider">    <!--slide-show-->
                            <div class="swiper-container swiper-container-slideshow card overflow-hidden swiper-container-fade swiper-container-horizontal swiper-container-rtl">
                                <div class="swiper-wrapper" style="transition-duration: 0ms;">
                                    <!--item-->
                                    @foreach($sliders as $slider)
                                        <div class="swiper-slide" style="width: 970px; opacity: 1; transform: translate3d(0px, 0px, 0px); transition-duration: 0ms">
                                            <a style="width: 100%" @if($slider->link)href="/{{$slider->link}}" @endif class="d-block">

                                                <img style="width: 100%" src="{{$slider->imgPath}}" alt="{{$slider->alt}}"
                                                     class="img-fluid img-fill swiper-lazy no-error swiper-lazy-loaded">

                                            </a>
                                        </div>
                                        <!--item end-->
                                    @endforeach
                                </div>
                                <!-- Add Pagination -->
                                <!-- Add Arrows -->
                                @if(count($sliders)>1)
                                    <div class="swiper-button-next swiper-button-white" tabindex="0" role="button"
                                         aria-label="Next slide" aria-disabled="false"></div>
                                    <div class="swiper-button-prev swiper-button-white" tabindex="0" role="button"
                                         aria-label="Previous slide" aria-disabled="false"></div>
                                @endif
                            </div>
                            <!--slide-show end-->
                        </div>
                        <!--grantee-->

                        <div class="card card-body mt-16 justify-content-center">
                            <div class="row no-gutters align-items-center">

                                <!--item-->
                                <div class="col-xl-3 col-md-6">
                                    <div class="d-flex align-items-center my-8">
                                        <div class="mx-16">
                                            <i class="ico ico-color_discount-tag ico-80px ico-fw-0"></i>
                                        </div>
                                        <div class="text-right">
                                            <span class="h6">تا ۵۰ درصد تخفیف</span>
                                            <!--<span class="d-block text-caption">تخفیف های ویژه تا 50 درصد</span>-->
                                        </div>
                                    </div>
                                </div>
                                <!--item end-->
                                <!--item-->
                                <div class="col-xl-3 col-md-6">
                                    <div class="d-flex align-items-center my-8">
                                        <div class="mx-16">
                                            <i class="ico ico-color_truck ico-80px ico-fw-0"></i>
                                        </div>
                                        <div class="text-right">
                                            <span class="h6">ارسال سریع</span>
                                            <!--<span class="d-block text-caption">تحویل سریع و به موقع سفارش ها</span>-->
                                        </div>
                                    </div>
                                </div>
                                <!--item end-->
                                <!--item-->
                                <div class="col-xl-3 col-md-6">
                                    <div class="d-flex align-items-center my-8">
                                        <div class="mx-16">
                                            <i class="ico ico-color_person ico-80px ico-fw-0"></i>
                                        </div>
                                        <div class="text-right">
                                            <span class="h6">تحویل رایگان</span>
                                            <!--<span class="d-block text-caption">ارسال رایگان سفارش های بالای 50 هزار تومان</span>-->
                                        </div>
                                    </div>
                                </div>
                                <!--item end-->
                                <!--item-->
                                <div class="col-xl-3 col-md-6">
                                    <div class="d-flex align-items-center my-8">
                                        <div class="mx-16">
                                            <i class="ico ico-color_grantee ico-80px ico-fw-0"></i>
                                        </div>
                                        <div class="text-right">
                                            <span class="h6">ضمانت بازگشت کالا</span>
                                            <!--<span class="d-block text-caption">امکان مرجوع کردن کالا تا 72 ساعت</span>-->
                                        </div>
                                    </div>
                                </div>
                                <!--item end-->

                            </div>
                        </div>


                        <!--grantee end-->
                    </div>

                    <!--today-offer-->
                    <div class="col-xl-3 order-xl-0 order-1" id="newProduct">
                        <!--today-offer-->
                        <div class="card card-equal-height">

                            <a class="card-header bg-gradient-primary card-header-slim text-white">

                                <div class="card-header_caption mx-auto">
                                    <div class="card-header_caption-title">
                                        <div class="card-header_caption-text">سبد روز</div>
                                    </div>
                                </div>

                            </a>

                            <!--slider and card body-->
                            <div class="p-0 d-flex h-100 align-items-center">
                                <!-- Swiper -->
                                <div
                                    class="swiper-container swiper-container-single-products swiper-container-horizontal swiper-container-rtl">
                                    <div class="swiper-wrapper">
                                        <!--product item-->
                                    @php $item_row=1; @endphp
                                    @foreach($day_baskets as $item)
                                        <!--product item-->
                                            <div
                                                class="swiper-slide @if($item_row==4)swiper-slide-prev @elseif($item_row==5) swiper-slide-active @elseif($item_row==6) swiper-slide-next @endif"
                                                style="width: 100%">
                                                <div class="product-box product-box_hover" style="width: 100%">

                                                    <!--product image and badge-->
                                                    <a href="/product/{{$item->slug}}" class="product-box_image" style="width: 210px;height: auto"
                                                       data-click="showProductDetail" data-productid="{{$item->id}}"
                                                       data-storeid="{{$item->id}}"
                                                       data-supplier="False">
                                                        @if($item->image)
                                                            @if(file_exists(public_path() . '/' . $item->image))
                                                                <img style="    object-fit: contain;" src="{{asset($item->image)}}"
                                                                     alt="{{$item->title}}" width="210" height="210"
                                                                     class="swiper-lazy swiper-lazy-loaded">
                                                            @else
                                                                <img src="{{asset('images/nopic.png')}}"
                                                                     alt="{{$item->title}}" width="210" height="210"
                                                                     class="swiper-lazy swiper-lazy-loaded">
                                                            @endif

                                                        @else
                                                            <img src="{{asset('images/nopic.png')}}"
                                                                 alt="{{$item->title}}" width="210" height="210"
                                                                 class="swiper-lazy swiper-lazy-loaded">
                                                        @endif

                                                        @if ($item->discount>0)
                                                            <div class="product-box_discount">
                                                                <span>%{{$item->discount}}<small>تخفیف</small></span></div>
                                                        @endif
                                                    </a>
                                                    <!--product image and badge end-->
                                                    <!--product title-->
                                                    <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                                       class="product-box_title text-dark"><h2
                                                            style="font-size: 0.85rem">{{$item->title}}</h2></a>
                                                    <!--product title end-->
                                                    <!--product content-->
                                                    @if ($item->depot>0)
                                                        <div class="product-box_content">

                                                            <!--price-->
                                                            <a href="/product/{{$item->slug}}"
                                                               data-click="showProductDetail"
                                                               data-productid="{{$item->id}}" class="product-box_price">
                                                                @if ($item->discount>0)
                                                                    <div
                                                                        class="product-box_price flex-row flex-nowrap h-auto mb-16">
                                                                        <del
                                                                            class="ml-8">{{number_format($item->price)}}</del>
                                                                        <div
                                                                            class="product-box_price-value">{{number_format($item['price'] * (100-$item['discount']) / 100)}}
                                                                            <span
                                                                                class="product-box_price-currency">{{setting()['currency']}}</span>
                                                                        </div>
                                                                    </div>
                                                                @else

                                                                    <div
                                                                        class="product-box_price flex-row flex-nowrap h-auto mb-16">
                                                                        <div
                                                                            class="product-box_price-value">{{number_format($item->price)}}
                                                                            <span
                                                                                class="product-box_price-currency">{{setting()['currency']}}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif


                                                            </a>

                                                            <!--price end-->
                                                            <!--action-->
                                                            <div class="product-box_action">
                                                                <button onclick="addcart(this,'{{$item->id}}')"
                                                                        type="button"
                                                                        class="btn btn-gradient-primary add-to-cart pr-8 pl-8">
                                                                    <i class="ico ico-color_plus-circle filter-none"></i>افزودن
                                                                    به سبد
                                                                </button>
                                                            </div>
                                                            <!--action btn-->

                                                        </div>
                                                    @else
                                                        <div class="product-box_content">
                                                            <a href="/product/{{$item->slug}}"
                                                               data-click="showProductDetail" data-productid="{{$item->id}}"
                                                               class="product-box_price">
                                                                <div class="product-box_price-value">تمام شد!</div>
                                                            </a>
                                                            <div class="product-box_action">
                                                                <button type="button"
                                                                        class="btn btn-gradient-secondary request-quantity"
                                                                        data-productid="{{$item->id}}"
                                                                        data-storeid="{{$item->id}}" data-supplier="False">
                                                                    موجود کن
                                                                </button>
                                                            </div>
                                                        </div>
                                                @endif


                                                <!--product content end-->

                                                </div>
                                            </div>
                                            <!--product item end-->
                                            @php $item_row++; @endphp
                                        @endforeach


                                    </div>

                                    <!-- Add Arrows -->
                                    <div
                                        class="swiper-button-next swiper-button-custom d-none d-lg-block swiper-button-disabled"
                                        tabindex="0" role="button" aria-label="Next slide" aria-disabled="true"></div>
                                    <div class="swiper-button-prev swiper-button-custom d-none d-lg-block" tabindex="0"
                                         role="button" aria-label="Previous slide" aria-disabled="false"></div>

                                </div>
                            </div>
                            <!--slider and card body end-->

                        </div>
                        <!--today-offer end-->

                    </div>
                    <!--today-offer end-->
                </div>
            </div>
        </section>
    <!--section slide-show and day-offer end-->
    <section id="homeBanner1">
        <section>
            <div class="container mb-20">
                <div class="row small-gutters">

                @foreach($categories_image as $item)
                    <!--col-1/4-->
                        @if ($item->showindex=="Up")
                            <div
                                class="@if($item->status=="big")col-lg-3 col-lg-6 my-8 @elseif($item->status=="small")col-lg-2 col-6 my-8 @endif">
                                <a href="/search/{{$item->slug}}" class="adplacement-item">
                                    <img data-src="{{asset($item->imgPath)}}" @if($item->status=="big") width="800"
                                         @elseif($item->status=="small") width="400" @endif height="300"
                                         class="no-error lazy loaded" alt="{{$item->title}}"
                                         src="{{asset($item->imgPath)}}"
                                         data-was-processed="true">
                                </a>
                            </div>
                        @endif

                    <!--col-1/4 end-->
                    @endforeach
                </div>
            </div>
        </section>
    </section>




    <section id="newProduct">
        <div class="container mb-20">

            <div class="card">

                <!--card header-->
                <div class="card-header card-header-right-border">

                    <!--header caption-->
                    <div class="card-header_caption">
                        <div class="card-header_caption-title">
                            <div class="card-header_caption-text">پر طرفدارترین ها
                            </div>
                        </div>
                    </div>
                    <div class="card-header_tools">
                        <a href="/search?page=1&sort=view&limit=12&amount=0|5,000,000">
                            مشاهده همه
                        </a>
                    </div>
                    <!--header caption end-->
                    <!--header tools-->
                    <!--header tools end-->

                </div>
                <!--card header end-->
                <!--slider and card body-->
                <div class="position-relative">
                    <!-- Swiper -->
                    <div
                        class="swiper-container swiper-container-products swiper-container-horizontal swiper-container-rtl">
                        <div class="swiper-wrapper"
                             style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);">

                        @php $item_row=1; @endphp
                        @foreach($products_view as $item)
                            <!--product item-->
                                <div
                                    class="swiper-slide @if($item_row==1)swiper-slide-active @elseif($item_row==2)swiper-slide-next @endif"
                                    style="width: 260.2px;">
                                    <div class="product-box product-box_hover">

                                        <!--product image and badge-->
                                        <a href="/product/{{$item->slug}}" class="product-box_image"
                                           data-click="showProductDetail" data-productid="{{$item->id}}"
                                           data-storeid="{{$item->id}}"
                                           data-supplier="False">
                                            @if($item->image)
                                                @if(file_exists(public_path() . '/' . $item->image))
                                                    <img src="{{asset($item->image)}}"
                                                         alt="{{$item->title}}" width="210" height="210"
                                                         class="swiper-lazy swiper-lazy-loaded">
                                                @else
                                                    <img src="{{asset('images/nopic.png')}}"
                                                         alt="{{$item->title}}" width="210" height="210"
                                                         class="swiper-lazy swiper-lazy-loaded">
                                                @endif

                                            @else
                                            <img src="{{asset('images/nopic.png')}}"
                                                 alt="{{$item->title}}" width="210" height="210"
                                                 class="swiper-lazy swiper-lazy-loaded">
                                            @endif
                                            @if ($item->discount>0)
                                                <div class="product-box_discount">
                                                    <span>%{{$item->discount}}<small>تخفیف</small></span></div>
                                            @endif
                                        </a>
                                        <!--product image and badge end-->
                                        <!--product title-->
                                        <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                           class="product-box_title text-dark"><h2
                                                style="font-size: 0.85rem">{{$item->title}}</h2></a>
                                        <!--product title end-->
                                        <!--product content-->
                                        @if ($item->depot>0)
                                            <div class="product-box_content">

                                                <!--price-->
                                                <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                                   data-productid="{{$item->id}}" class="product-box_price">
                                                    @if ($item->discount>0)
                                                        <del>{{number_format($item->price)}}</del>
                                                        <div
                                                            class="product-box_price-value">{{number_format($item['price'] * (100-$item['discount']) / 100)}}
                                                            <span
                                                                class="product-box_price-currency">{{setting()['currency']}}</span>
                                                        </div>
                                                    @else
                                                        <div
                                                            class="product-box_price-value">{{number_format($item->price)}}
                                                            <span
                                                                class="product-box_price-currency">{{setting()['currency']}}</span>
                                                        </div>
                                                    @endif

                                                </a>

                                                <!--price end-->
                                                <!--action-->
                                                <div class="product-box_action">
                                                    <button onclick="addcart(this,'{{$item->id}}')" type="button"
                                                            class="btn btn-gradient-primary add-to-cart pr-8 pl-8"><i
                                                            class="ico ico-color_plus-circle filter-none"></i>افزودن
                                                        به سبد
                                                    </button>
                                                </div>
                                                <!--action btn-->

                                            </div>
                                        @else
                                            <div class="product-box_content">
                                                <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                                   data-productid="{{$item->id}}" class="product-box_price">
                                                    <div class="product-box_price-value">تمام شد!</div>
                                                </a>
                                                <div class="product-box_action">
                                                    <button type="button"
                                                            class="btn btn-gradient-secondary request-quantity"
                                                            data-productid="{{$item->id}}" data-storeid="{{$item->id}}"
                                                            data-supplier="False">موجود کن
                                                    </button>
                                                </div>
                                            </div>
                                    @endif


                                    <!--product content end-->

                                    </div>
                                </div>
                                <!--product item end-->
                                @php $item_row++; @endphp
                            @endforeach
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-custom d-none d-lg-block" tabindex="0"
                             role="button" aria-label="Next slide" aria-disabled="false"></div>
                        <div class="swiper-button-prev swiper-button-custom d-none d-lg-block swiper-button-disabled"
                             tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                            class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                            class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                </div>
                <!--slider and card body end-->

            </div>

        </div>
    </section>


    <section id="newProduct">
        <div class="container mb-20">

            <div class="card">

                <!--card header-->
                <div class="card-header card-header-right-border">

                    <!--header caption-->
                    <div class="card-header_caption">
                        <div class="card-header_caption-title">
                            <div class="card-header_caption-text">جدید ترین ها</div>
                        </div>
                    </div>
                    <div class="card-header_tools">
                        <a href="/search?page=1&sort=new&limit=12&amount=0|5,000,000">
                            مشاهده همه
                        </a>
                    </div>
                    <!--header caption end-->
                    <!--header tools-->
                    <!--header tools end-->

                </div>
                <!--card header end-->
                <!--slider and card body-->
                <div class="position-relative">
                    <!-- Swiper -->
                    <div
                        class="swiper-container swiper-container-products swiper-container-horizontal swiper-container-rtl">
                        <div class="swiper-wrapper"
                             style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);">

                        @php $item_row=1; @endphp
                        @foreach($products_new as $item)
                            <!--product item-->
                                <div
                                    class="swiper-slide @if($item_row==1)swiper-slide-active @elseif($item_row==2)swiper-slide-next @endif"
                                    style="width: 260.2px;">
                                    <div class="product-box product-box_hover">

                                        <!--product image and badge-->
                                        <a href="/product/{{$item->slug}}" class="product-box_image"
                                           data-click="showProductDetail" data-productid="{{$item->id}}"
                                           data-storeid="{{$item->id}}"
                                           data-supplier="False">
                                            @if($item->image)
                                                @if(file_exists(public_path() . '/' . $item->image))
                                                    <img src="{{asset($item->image)}}"
                                                         alt="{{$item->title}}" width="210" height="210"
                                                         class="swiper-lazy swiper-lazy-loaded">
                                                @else
                                                    <img src="{{asset('images/nopic.png')}}"
                                                         alt="{{$item->title}}" width="210" height="210"
                                                         class="swiper-lazy swiper-lazy-loaded">
                                                @endif

                                            @else
                                                <img src="{{asset('images/nopic.png')}}"
                                                     alt="{{$item->title}}" width="210" height="210"
                                                     class="swiper-lazy swiper-lazy-loaded">
                                            @endif
                                            @if ($item->discount>0)
                                                <div class="product-box_discount">
                                                    <span>%{{$item->discount}}<small>تخفیف</small></span></div>
                                            @endif
                                        </a>
                                        <!--product image and badge end-->
                                        <!--product title-->
                                        <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                           class="product-box_title text-dark"><h2
                                                style="font-size: 0.85rem">{{$item->title}}</h2></a>
                                        <!--product title end-->
                                        <!--product content-->
                                        @if ($item->depot>0)
                                            <div class="product-box_content">

                                                <!--price-->
                                                <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                                   data-productid="{{$item->id}}" class="product-box_price">
                                                    @if ($item->discount>0)
                                                        <del>{{number_format($item->price)}}</del>
                                                        <div
                                                            class="product-box_price-value">{{number_format($item['price'] * (100-$item['discount']) / 100)}}
                                                            <span
                                                                class="product-box_price-currency">{{setting()['currency']}}</span>
                                                        </div>
                                                    @else
                                                        <div
                                                            class="product-box_price-value">{{number_format($item->price)}}
                                                            <span
                                                                class="product-box_price-currency">{{setting()['currency']}}</span>
                                                        </div>
                                                    @endif

                                                </a>

                                                <!--price end-->
                                                <!--action-->
                                                <div class="product-box_action">
                                                    <button onclick="addcart(this,'{{$item->id}}')" type="button"
                                                            class="btn btn-gradient-primary add-to-cart pr-8 pl-8"><i
                                                            class="ico ico-color_plus-circle filter-none"></i>افزودن
                                                        به سبد
                                                    </button>
                                                </div>
                                                <!--action btn-->

                                            </div>
                                        @else
                                            <div class="product-box_content">
                                                <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                                   data-productid="{{$item->id}}" class="product-box_price">
                                                    <div class="product-box_price-value">تمام شد!</div>
                                                </a>
                                                <div class="product-box_action">
                                                    <button type="button"
                                                            class="btn btn-gradient-secondary request-quantity"
                                                            data-productid="{{$item->id}}" data-storeid="{{$item->id}}"
                                                            data-supplier="False">موجود کن
                                                    </button>
                                                </div>
                                            </div>
                                    @endif


                                    <!--product content end-->

                                    </div>
                                </div>
                                <!--product item end-->
                                @php $item_row++; @endphp
                            @endforeach
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-custom d-none d-lg-block" tabindex="0"
                             role="button" aria-label="Next slide" aria-disabled="false"></div>
                        <div class="swiper-button-prev swiper-button-custom d-none d-lg-block swiper-button-disabled"
                             tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                            class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                            class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                </div>
                <!--slider and card body end-->

            </div>

        </div>
    </section>


    <section id="homeBanner2">
        <section>
            <div class="container mb-20">
                <div class="row small-gutters">
                    @foreach($categories_image as $item)

                        @if ($item->showindex=="Down")
                            <div
                                class="@if($item->status=="big")col-lg-3 col-lg-6 my-8 @elseif($item->status=="small")col-lg-3 col-6 my-8 @endif">
                                <a href="/search/{{$item->slug}}" class="adplacement-item">
                                    <img data-src="{{asset($item->imgPath)}}" @if($item->status=="big")width="800"
                                         @elseif($item->status=="small")width="400" @endif height="300"
                                         class="no-error lazy loaded" alt="{{$item->title}}"
                                         src="{{asset($item->imgPath)}}"
                                         data-was-processed="true">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    </section>




    <section id="homeBanner3"></section>




    <!--download app-->
    @if(count($Proposals))
    <section>
        <div class="swiper-container swiper-container-slideshow overflow-hidden swiper-container-fade swiper-container-horizontal swiper-container-rtl">

        <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach($Proposals as $Proposal)
                <div class="swiper-slide" style="background: #eee;">
                    <div class="cover-background mb-20"
                         style="background-image: url('{{asset($Proposal->image)}}'); background-position: 50% 50%; background-size: cover; background-repeat: no-repeat;width: 100%">

                        <div class="min-vh-50 py-48 d-flex align-items-center overlay-background">
                            <div class="container">
                                <div class="text-white w-50-lg w-50-md text-center">
                                    <div class="h2 font-weight-bold">{{$Proposal->title}}</div>
                                    <p class="font-weight-bold my-3"><?=$Proposal->content?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <!-- If we need pagination -->
            @if(count($Proposals)>1)
            <div class="swiper-pagination"></div>
        @endif
            <!-- If we need navigation buttons -->
            @if(count($Proposals)>1)
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        @endif
            <!-- If we need scrollbar -->

        </div>

    </section>
    @endif
    <!--download app end-->
    <!--blog-->
    @if(count($brands))
    <section id="brands">

        <div class="container mb-20">

            <div class="card">

                <!--card header-->
                <div class="card-header card-header-right-border">

                    <!--header caption-->
                    <div class="card-header_caption">
                        <div class="card-header_caption-title">
                            <div class="card-header_caption-text">برندهای ویژه</div>
                        </div>
                    </div>
                    <!--header caption end-->
                    <!--header tools-->
                    <!--header tools end-->

                </div>
                <!--card header end-->
                <!--slider and card body-->
                <div class="position-relative">
                    <!-- Swiper -->
                    <div class="swiper-container swiper-container-brands swiper-container-horizontal swiper-container-rtl">
                        <div class="swiper-wrapper">
                            @php $item_row=1; @endphp
                            @foreach($brands as $item)
                            <div class="swiper-slide @if($item_row==1)swiper-slide-active @elseif($item_row==2) swiper-slide-next @endif "  style="width: 260.2px;" >
                                <div class="product-box product-box_hover brand-box">
                                    <a href="/search/brand/{{$item->link}}" class="product-box_image">
                                        <img src="{{asset($item->imgPath)}}" alt="" class="swiper-lazy swiper-lazy-loaded">
                                    </a>
                                </div>
                            </div>
                                @php $item_row++; @endphp
                            @endforeach

                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-custom d-none d-lg-block" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></div>
                        <div class="swiper-button-prev swiper-button-custom d-none d-lg-block swiper-button-disabled" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                </div>
                <!--slider and card body end-->

            </div>

        </div>


    </section>
    @endif

    @if(count($posts))
    <section id="blog">
        <div class="container mb-20">

            <div class="card">

                <!--card header-->
                <div class="card-header card-header-right-border">

                    <!--header caption-->
                    <div class="card-header_caption">
                        <div class="card-header_caption-title">
                            <div class="card-header_caption-text">آخرین مقالات</div>
                        </div>
                    </div>

                    <!--header caption end-->
                    <!--header tools-->
                    <!--header tools end-->

                </div>
                <!--card header end-->
                <!--slider and card body-->
                <div class="position-relative">
                    <!-- Swiper -->
                    <div
                            class="swiper-container swiper-container-post swiper-container-horizontal swiper-container-rtl">
                        <div class="swiper-wrapper"
                             style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);">

                        @php $item_row=1; @endphp
                        @foreach($posts as $post)
                                <div
                                        class="swiper-slide @if($item_row==1)swiper-slide-active @elseif($item_row==2)swiper-slide-next @endif post"
                                        style="width: 260.2px;">
                                    <div class="product-box product-box_hover" style="width: 100%">

                                        <!--product image and badge-->
                                        <a href="/blog/{{$post->slug}}" style="width: 100%">
                                            <img src="{{asset($post->imgPath)}}" style="width: 100%;border-radius: 5px" height="200px"
                                                 alt="{{$post->title}}" class="swiper-lazy swiper-lazy-loaded">
                                        </a>
                                        <!--product image and badge end-->
                                        <!--product title-->
                                        <ul class="meta">
                                            <li>{{$post->view}} بازدید </li>
                                            <li>{{' - '.Verta::instance($post->updated_at)->format(' %d %B %Y')}}</li>

                                        </ul>
                                        <div class="product-box_title text-dark">
                                            <a href="/blog/{{$post->slug}}" data-click="showProductDetail"
                                               class="product-box_title text-dark">
                                                <h2>{{Illuminate\Support\Str::limit($post->title,70)}}</h2></a>
                                            <!--product title end-->
                                            <?= Illuminate\Support\Str::limit($post->shortContent, 50) ?>
                                        </div>
                                        <!--product content-->
                                        <div class="product-box_action" style="margin-top: 10px;">
                                            <a href="/blog/{{$post->slug}}"
                                               class="btn btn-gradient-primary pr-8 pl-8">
                                                ادامه مطلب
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @php $item_row++; @endphp
                            @endforeach
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-custom d-none d-lg-block" tabindex="0"
                             role="button" aria-label="Next slide" aria-disabled="false"></div>
                        <div class="swiper-button-prev swiper-button-custom d-none d-lg-block swiper-button-disabled"
                             tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                                class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                                class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                </div>
                <!--slider and card body end-->

            </div>

        </div>
    </section>
    @endif


@endsection
@section('script_link')
    <script src="{{asset('assets/css/scroll/jquery.mCustomScrollbar.js')}}"></script>
@endsection
@section('script')
    <script>
        $('.brands').mCustomScrollbar({
            setWidth: false,
            setHeight: false,
            setTop: 0,
            setLeft: 0,
            axis: "y",
            scrollbarPosition: "inside",
            scrollInertia: 950,
            autoDraggerLength: true,
            autoHideScrollbar: false,
            autoExpandScrollbar: false,
            alwaysShowScrollbar: 0,
            snapAmount: null,
            snapOffset: 0,
            mouseWheel: {
                enable: true,
                scrollAmount: "auto",
                axis: "y",
                preventDefault: false,
                deltaFactor: "auto",
                normalizeDelta: false,
                invert: false,
                disableOver: ["select", "option", "keygen", "datalist", "textarea"]
            },
            scrollButtons: {
                enable: true,
                scrollType: "stepless",
                scrollAmount: "auto"
            },
            keyboard: {
                enable: true,
                scrollType: "stepless",
                scrollAmount: "auto"
            },
            contentTouchScroll: 25,
            advanced: {
                autoExpandHorizontalScroll: false,
                autoScrollOnFocus: "input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",
                updateOnContentResize: true,
                updateOnImageLoad: true,
                updateOnSelectorChange: false,
                releaseDraggableSelectors: false
            },
            theme: "3d-dark",

            callbacks: {
                onInit: false,
                onScrollStart: false,
                onScroll: false,
                onTotalScroll: false,
                onTotalScrollBack: false,
                whileScrolling: false,
                onTotalScrollOffset: 0,
                onTotalScrollBackOffset: 0,
                alwaysTriggerOffsets: true,
                onOverflowY: false,
                onOverflowX: false,
                onOverflowYNone: false,
                onOverflowXNone: false
            },
            live: false,
            liveSelector: null

        });
    </script>
@endsection
