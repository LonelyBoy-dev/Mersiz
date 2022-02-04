@extends('front.layout.master')

@section('style')
    <style>
        .h1.line-height-sm.font-weight-bold{
            font-size: 1.5rem;
        }
        .c-params__headline {
            color: #6f6f6f;
            font-size: 30px;
            font-size: 2.143rem;
            line-height: 1.467;
            font-weight: 500;
            margin-bottom: 35px;
            letter-spacing: -.6px;
        }
        .c-params__headline span {
            display: block;
            font-size: 16px;
            font-size: 1.143rem;
            line-height: 1.375;
            color: #a7a7a7;
            letter-spacing: -.3px;
        }

    </style>
@endsection
@section('content')
    <!--product wrap-->
    <!--product details and light-box-->
    @php $agent=new Jenssegers\Agent\Agent();@endphp
    @if ($agent->isMobile())
        <section data-controller="Product">
            <div class="bg-white py-20">
                <div style="display: none" id="productId" data-productid="143245" data-storeid="1966" data-supplier="False"></div>
                <!--product slider-->
                <div class="container pb-20">
                    <div class="card">
                        <div class="card-body">

                            <!--title and subtitle-->
                            <div class="text-truncate">
                                <div class="font-weight-bold mb-4">{{$product->title}}</div>
                                <div class="small text-muted">{{$product->title}}</div>
                            </div>
                            <!--title and subtitle end-->
                            <!--slider-->
                            <div class="d-flex justify-content-center my-16">
                                <div class="swiper-container swiper-product-details mx-auto swiper-container-horizontal swiper-container-free-mode swiper-container-rtl swiper-container-ios">
                                    <div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);">
                                        @if(count($images))
                                        <?php $i=1; ?>
                                        @foreach($images as $img)
                                        <div class="swiper-slide text-center swiper-slide-active" style="width: 347px;">
                                            @if(file_exists(public_path() . '/' . $img->path))
                                            <img class="swiper-lazy img-fluid swiper-lazy-loaded" src="{{asset($img->path)}}" alt="{{$product->title}}">
                                            @else
                                                <img class="swiper-lazy img-fluid swiper-lazy-loaded" src="{{asset('images/nopic.png')}}" alt="{{$product->title}}">
                                            @endif
                                            @if ($product->discount>0)
                                                <div class="product-box_discount"><span>%{{$product->discount}}<small>تخفیف</small></span></div>
                                            @endif
                                        </div>

                                                <?php $i++; ?>
                                            @endforeach
                                            @else
                                            <div class="swiper-slide text-center swiper-slide-active" style="width: 347px;">
                                                <img class="swiper-lazy img-fluid swiper-lazy-loaded" src="{{asset('images/nopic.png')}}" alt="{{$product->title}}">

                                                @if ($product->discount>0)
                                                    <div class="product-box_discount"><span>%{{$product->discount}}<small>تخفیف</small></span></div>
                                                @endif
                                            </div>
                                        @endif

                                    </div>
                                    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">

                                        <?php $i=1;$last_img=count($images) ?>
                                        @foreach($images as $img)
                                        <span class="swiper-pagination-bullet @if($last_img==$i)swiper-pagination-bullet-active @endif" tabindex="0" role="button" aria-label="Go to slide {{$i}}"></span>
                                                <?php $i++; ?>
                                            @endforeach

                                    </div>
                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                            </div>
                            <!--slider end-->
                            <!--add to card-->
                            <div>
                                <!--product price-->
                                <div class="overflow-hidden">
                                    <div class="d-flex align-items-center">

                                        <div>
                                            <del class="text-muted font-weight-bolder small">{{number_format($product->price)}}</del>
                                        </div>
                                        <div class="mr-auto">
                                            <ul class="nav nav-line mr-auto">

                                                <!--star rate-->
                                                <?php
                                                $rating=[];
                                                $sum_rating=0;
                                                foreach($comments as $comment){
                                                    @$rating[]=@$comment->rating;
                                                }
                                                if ($rating) {
                                                    $sum_rating=array_sum($rating)/count($comments);
                                                }

                                                ?>
                                                <li class="nav-line-item">
                                                    <div class="ico-star-rating ico-star-{{@$sum_rating}}">
                                                        <i class="ico ico-12px ico-star"></i>
                                                        <i class="ico ico-12px ico-star"></i>
                                                        <i class="ico ico-12px ico-star"></i>
                                                        <i class="ico ico-12px ico-star"></i>
                                                        <i class="ico ico-12px ico-star"></i>
                                                    </div>
                                                </li>
                                                <!--star rate end-->


                                                <li class="nav-line-item">
                                                    <div class="text-muted small">{{count($comments)}} رأی</div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    @if ($product->depot>0)
                                    <div class="d-flex align-items-center my-12">
                                        <div class="flex-grow-1">
                                            <small class="font-weight-normal">قیمت</small>&nbsp;
                                            <span class="text-primary">
                                                <span class="font-weight-bolder m-0 line-height-sm">{{number_format($product['price'] * (100-$product['discount']) / 100)}}</span>&nbsp;<small class="font-weight-normal">{{setting()['currency']}}</small>
                                            </span>
                                        </div>
                                        @if ($product->depot>0)
                                        <div class="product-box_action" style="min-width:unset;max-width:unset;">
                                            <button onclick="addcart(this,'{{$product->id}}')" class="btn btn-gradient-primary add-to-cart"  data-supplier="False" data-qty="1"><i class="ico ico-bag"></i>افزودن به سبد</button>
                                        </div>
                                        @else
                                            <div class="text-right">
                                                <button class="btn btn-gradient-secondary request-quantity" data-productid="{{$item->id}}" data-storeid="{{$item->id}}" data-supplier="False">موجود کن</button>
                                            </div>
                                        @endif
                                    </div>
                                        <div class="d-flex align-items-center">
                                            @if ($product->discount>0)
                                                <div>
                                                    <small class="font-weight-normal">تخفیف</small>&nbsp;
                                                    <span class="text-secondary">
                                                @php $price=($product->price)-($product['price'] * (100-$product['discount']) / 100) @endphp
                                                    <span class="font-weight-bolder m-0 line-height-sm">{{number_format($price)}}</span>&nbsp;<small class="font-weight-normal">{{setting()['currency']}}</small>
                                                </span>
                                                </div>
                                            @endif
                                            <div class="d-flex align-items-center mr-auto"></div>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center my-12" style="float: right">
                                            <span class="text-primary">
                                                <span class="font-weight-bolder m-0 line-height-sm">تمام شد!</span>&nbsp;<small class="font-weight-normal"></small>
                                            </span>

                                        </div>
                                        <div class="text-left">
                                            <button class="btn btn-gradient-secondary request-quantity" data-productid="{{$product->id}}" data-storeid="{{$product->id}}" data-supplier="False">موجود کن</button>
                                        </div>
                                    @endif

                                </div>
                                <!--product price end-->
                            </div>
                            <!--add to card end-->

                        </div>
                    </div>
                </div>
                <!--product slider end-->
                <!--product meta-->
                <div class="container pb-20">
                    <div class="card">
                        <div class="card-body">


                            <!--star-rate  and social link-->
                            <ul class="list-unstyled small m-0">

                                <li class="d-flex align-items-center my-12">
                                    <div class="text-muted w-20-sm w-25">برند</div>
                                    <div class="font-weight-bold">
                                        @if ($brand)
                                            @if (@$brand->imgPath!="")
                                        <a>
                                            <img data-src="{{asset($brand->imgPath)}}" width="45" alt="{{$brand->title}}" class="lazy no-error loaded" src="{{asset($brand->imgPath)}}" data-was-processed="true">
                                        </a>
                                            @else
                                                <dd class="text-secondary">
                                                    <span>{{$brand->title}}</span>
                                                </dd>
                                            @endif
                                        @else<dd class="text-secondary">
                                            <span>بدون برند</span>
                                        </dd>
                                        @endif
                                    </div>
                                </li>

                                <li class="d-flex align-items-center my-8">
                                    <div class="text-muted w-20-sm w-25">دسته بندی</div>
                                    <div class="font-weight-bold">
                                        <?php $c_count=count($product->categories);$i=1; ?>
                                        @foreach($product->categories as $category)
                                            @if ($i++==$c_count)
                                        <span class="text-secondary">{{$category->title}}</span>
                                                @endif

                                            @endforeach
                                    </div>

                                </li>
                                <li class="d-flex align-items-center my-8">
                                    <div class="text-muted w-20-sm w-25">تعداد موجود</div>
                                    <div class="font-weight-bold">
                                        @if ($product->depot<="0")
                                        <span>ناموجود</span>
                                        @else
                                            <span>{{$product->depot.' '.$product->unit}}</span>
                                        @endif
                                    </div>
                                </li>
                                @if ($product->buy_limited!="")
                                <li class="d-flex align-items-center my-8">
                                    <div class="text-muted w-20-sm w-25">محدودیت خرید</div>
                                    <div class="font-weight-bold">
                                            <span>{{$product->buy_limited.' '.$product->unit}}</span>
                                    </div>
                                </li>
                                @endif
                            </ul>
                            <!--star-rate  and social link end-->

                        </div>
                    </div>
                </div>
                <!--product meta end-->
                <!--product description-->
                @if ($product->content!="")
                <div class="container pb-20">
                    <div class="card">
                        <!--card header-->
                        <div class="card-header card-header-slim card-header-right-border">

                            <!--header caption-->
                            <div class="card-header_caption">
                                <div class="card-header_caption-title">
                                    <div class="card-header_caption-text">توضیحات محصول</div>
                                </div>
                            </div>
                            <!--header caption end-->

                        </div>
                        <!--card header end-->
                        <div class="card-body">
                            <div class="text-justify">
                                <p>
                                    <?= $product['content'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if (count($featurs))
                <div class="container pb-20">
                    <div class="card">
                        <!--card header-->
                        <div class="card-header card-header-slim card-header-right-border">

                            <!--header caption-->
                            <div class="card-header_caption">
                                <div class="card-header_caption-title">
                                    <div class="card-header_caption-text">مشخصات</div>
                                </div>
                            </div>
                            <!--header caption end-->

                        </div>
                        <!--card header end-->
                        <div class="card-body">
                            <div class="text-justify">
                                <p>
                                <div class="align-items-stretch">
                                    <h3 class="c-params__headline">
                                        مشخصات فنی
                                        <br>
                                        <span style="">{{$product->title}}</span>
                                    </h3>
                                    @foreach($featurs as $featur)
                                        <div class="row" style="margin-bottom: 30px">
                                            <div class="col-lg-3 col-xs-12">
                                                <div class="card" style="background: #f9f9f9;">
                                                    <div class="card-body">
                                                        {{$featur->title}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-xs-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        {{$featur->content}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!--product description end-->
                <!--product comments-->
                <div class="container pb-20">

                    <div class="card">

                        <!--card header-->
                        <div class="card-header card-header-slim card-header-right-border">

                            <!--header caption-->
                            <div class="card-header_caption">
                                <div class="card-header_caption-title">
                                    <div class="card-header_caption-text">نظرات کاربران</div>
                                </div>
                            </div>
                            <!--header caption end-->

                        </div>
                        <!--card header end-->

                        <div class="card-body">
                            <ul class="list-unstyled">
                                <!--comments item-->
                                @if (count($comments))
                                @foreach($comments as $comment)
                                <li class="py-8 mb-8">

                                    <!--comment header-->
                                    <div class="d-flex align-items-center small">

                                        <!--stars-->
                                        <div class="ico-star-rating ico-star-{{$comment->rating}}">
                                            <i class="ico ico-12px ico-star"></i>
                                            <i class="ico ico-12px ico-star"></i>
                                            <i class="ico ico-12px ico-star"></i>
                                            <i class="ico ico-12px ico-star"></i>
                                            <i class="ico ico-12px ico-star"></i>
                                        </div>
                                        <!--stars end-->

                                        <div class="text-primary font-weight-bold mx-8">
                                        </div>
                                        <div class="font-weight-light">{{Verta::instance($comment->creat_at)}}</div>

                                    </div>
                                    <!--comment header end-->
                                    <!--writer-->
                                    <div class="my-8">
                                        <small>توسط</small>&nbsp;
                                        <span class="subtitle2">@if ($comment->user->name=="" or $comment->user->family=="")
                                                کاربر سایت
                                            @else
                                                {{$comment->user->name.' '.$comment->user->family}}
                                            @endif </span>
                                    </div>
                                    <!--writer end-->
                                    <!--comment text-->
                                    <div class="text-justify font-weight-light">{{$comment->content}}</div>
                                    <!--comment text end-->

                                </li>
                                @endforeach
                                @else
                                    <li>شما اولین نفری باشید که نظر خود را ثبت میکنید.</li>
                                    <!--comments item end-->
                                @endif
                                <li><hr></li>



                            </ul>
                            <div class="d-flex justify-content-end align-items-center">
                                <a class="btn btn-outline-secondary mr-4" href="/comment/{{$product->slug}}" title="">ثبت نظر</a>
                            </div>
                        </div>

                    </div>

                </div>
                <!--product comments end-->
                @php $linkdownload=App\Linkdownload::where('product_id',$product->id)->first(); @endphp
                @if(!empty($linkdownload))
                    <div class="container pb-20">

                        <div class="card">

                            <!--card header-->
                            <div class="card-header card-header-slim card-header-right-border">

                                <!--header caption-->
                                <div class="card-header_caption">
                                    <div class="card-header_caption-title">
                                        <div class="card-header_caption-text">فایل دانلودی</div>
                                    </div>
                                </div>
                                <!--header caption end-->

                            </div>
                            <!--card header end-->

                            <div class="card-body">
                                <a target="_blank" href="{{asset($linkdownload->path)}}" class="btn btn-warning btn-block waves-effect">دانلود فایل</a>
                            </div>

                        </div>

                    </div>
                @endif

                @if($product->video!="")
                    <div class="container pb-20">
                        <div class="align-items-stretch">
                            <h2 class="c-params__headline">
                                ویدیو محصول
                                <br>
                                <span style=""> ویدیو {{$product->title}}</span>
                            </h2>
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($product->video)
                                        <video width="100%" controls>
                                            <source src="{{asset($product->video)}}" type="video/mp4">
                                        </video>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    @endif
            </div>
        </section>



    @else
    <section data-controller="Product">
        <div style="display: none" id="productId" data-productid="22056" data-storeid="1959"
             data-supplier="False"></div>
        <div class="container my-16">

            <div class="d-flex align-items-center mb-16">

                <!--breadcrumb-->
                <nav class="ml-auto d-none d-lg-block" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">خانه</a></li>

                        @foreach($product->categories as $category)
                        <li class="breadcrumb-item"><a href="/search/{{$category->slug}}">{{$category->title}}</a></li>
                        @endforeach
                    </ol>
                </nav>
                <!--breadcrumb end-->
            </div>

            <div class="bg-white p-24 rounded-lg">

                <div class="row align-items-start">

                    <!--product picture and thumbnails-->
                    <div class="col-xl-4 col-lg-5">

                        <!-- Swiper -->
                        <div class="swiper-container @if(count($images))gallery-top @endif swiper-container-fade swiper-container-horizontal swiper-container-rtl">
                            <a  @if (count($images))data-toggle="modal" href="#productLightBoxModal" @endif class="swiper-wrapper" title="" style="transition-duration: 0ms;">
                                @if (count($images))
                                    @foreach($images as $img)

                                        <div class="swiper-slide p-0" style="width: 402px; opacity: 1; transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                            @if(file_exists(public_path() . '/' . $img->path))
                                            <img class="swiper-lazy swiper-lazy-loaded elevatezoom" src="{{asset($img->path)}}" data-zoom-image="{{asset($img->path)}}" alt="{{$product->title}} " width="300" height="300">
                                            @else
                                                <img style="width: 100%;height: 100%" class="" src="{{asset('images/nopic.png')}}" data-zoom-image="{{asset('images/nopic.png')}}" alt="{{$product->title}}" width="300" height="300">
                                            @endif
                                            @if ($product->discount>0)
                                                <div class="product-box_discount"><span>%{{$product->discount}}<small>تخفیف</small></span></div>
                                            @endif
                                        </div>
                                    @endforeach

                                @else
                                    <div class="swiper-slide p-0" style="width: 402px; opacity: 1; transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                            <img style="width: 100%;height: 100%" class="" src="{{asset('images/nopic.png')}}" data-zoom-image="{{asset('images/nopic.png')}}" alt="{{$product->title}}" width="300" height="300">
                                        @if ($product->discount>0)
                                        <div class="product-box_discount"><span>%{{$product->discount}}<small>تخفیف</small></span></div>
                                            @endif
                                    </div>
                                @endif

                            </a>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>
                        @if (count($images))
                        <div class="swiper-container gallery-thumbs mt-8 swiper-container-horizontal swiper-container-rtl swiper-container-thumbs">
                            <div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);">


                                <?php $i=1; ?>
                                @foreach($images as $img)
                                <div class="swiper-slide" style="margin-left: 16px;">
                                    @if(file_exists(public_path() . '/' . $img->image))
                                        <img class="swiper-lazy swiper-lazy-loaded" src="{{asset($img->path)}}" data-zoom-image="{{asset($img->path)}}" alt="خرید اینترنتی {{$product->title}} " width="128" height="128">
                                    @else
                                        <img class="swiper-lazy swiper-lazy-loaded" src="{{asset('images/nopic.png')}}" data-zoom-image="{{asset('images/nopic.png')}}" alt="خرید اینترنتی {{$product->title}} " width="128" height="128">
                                    @endif
                                </div>
                                    <?php $i++; ?>
                                @endforeach
                            </div>

                            <div class="swiper-modal-button-next swiper-button-disabled" tabindex="0" role="button" aria-label="Next slide" aria-disabled="true"></div>
                            <div class="swiper-modal-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="false"></div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                        @endif

                    </div>
                    <!--product picture and thumbnails end-->
                    <!--product general info-->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow-16dp">

                            <!--product wrap header-->
                            <div class="px-20 pt-20">
                                <div class="d-flex align-items-center justify-content-between">

                                    <!--title and subtitle-->
                                    <div class="w-70-lg">
                                        <h1 class="h1 line-height-sm font-weight-bold">{{$product->title}} </h1>
                                        <div class="subtitle2 text-muted">{{$product->title}}</div>
                                    </div>
                                    <!--title and subtitle end-->
                                    <!--star-rate  and social link-->
                                    <?php
                                    $rating=[];
                                    $sum_rating=0;
                                    foreach($comments as $comment){
                                        @$rating[]=@$comment->rating;
                                    }
                                    if ($rating) {
                                        $sum_rating=array_sum($rating)/count($comments);
                                    }

                                    ?>
                                    <div class="w-30-lg pl-20">
                                        <ul class="nav nav-line mb-4 justify-content-end">
                                            <!--star rate-->
                                            <li class="nav-line-item">
                                                <div class="ico-star-rating ico-star-{{@$sum_rating}}">
                                                    <i class="ico ico-18px ico-star"></i>
                                                    <i class="ico ico-18px ico-star"></i>
                                                    <i class="ico ico-18px ico-star"></i>
                                                    <i class="ico ico-18px ico-star"></i>
                                                    <i class="ico ico-18px ico-star"></i>

                                                </div>
                                            </li>
                                            <!--star rate end-->

                                            <li class="nav-line-item">
                                                <div class="text-muted">{{count($comments)}} رأی</div>
                                            </li>

                                        </ul>

                                        <div class="d-flex justify-content-end align-items-center">

                                        </div>

                                    </div>
                                    <!--star-rate  and social link end-->

                                </div>
                            </div>
                            <!--product wrap header end-->
                            <!--divider-->
                            <div class="px-20">
                                <hr>
                            </div>
                            <!--divider end-->
                            <!--branding wrap-->
                            <div class="pb-16 px-20">
                                <div class="row">

                                    <div class="col-lg-7">

                                        <dl class="description-list description-list-horizontal subtitle1 mb-0">

                                            <dt class="text-muted">دسته بندی</dt>
                                            <dd class="font-weight-light">
                                                <?php $c_count=count($product->categories);$i=1; ?>
                                                @foreach($product->categories as $category)
                                                    @if ($i++==$c_count)
                                                            <span class="text-secondary">{{$category->title}}</span>
                                                    @endif

                                                    @endforeach
                                            </dd>

                                            <dt class="text-muted">برند</dt>
                                            <dd class="font-weight-light">
                                                @if ($brand)
                                                    @if (@$brand->imgPath!="")
                                                        <a>
                                                            <img data-src="{{asset($brand->imgPath)}}" width="45" alt="مصطفوی" class="lazy no-error loaded" src="{{asset($brand->imgPath)}}" data-was-processed="true">
                                                        </a>
                                            @else
                                                <dd class="font-weight-light">
                                                    <span>{{$brand->title}}</span>
                                                </dd>
                                            @endif

                                            @else<dd class="font-weight-light">
                                                <span>بدون برند</span>
                                            </dd>
                                                @endif



                                            </dd>

                                            <dt class="text-muted">تعداد موجود</dt>
                                            <dd class="font-weight-light">
                                                @if ($product->depot<="0")
                                                    ناموجود
                                                @else
                                                    {{$product->depot.' '.$product->unit}}
                                                @endif

                                            </dd>

                                        @if ($product->buy_limited!="")
                                                <dt class="text-muted">محدودیت خرید</dt>
                                                <dd class="font-weight-light">
                                                    {{$product->buy_limited.' '.$product->unit}}
                                                </dd>
                                        @endif


                                        </dl>

                                    </div>


                                </div>
                            </div>
                            <!--branding wrap end-->
                            <!--product description-->
                            <!--product description end-->
                            <div class="pt-16 pb-20 px-20" @if($product->depot<=0)style="margin-top: 77px;" @endif>
                                <div class="row align-items-center">
                                    <!--product price-->
                                    @if ($product->depot>0)
                                        <div class="col-lg-7">
                                            <!--product price-->
                                            <dl class="description-list description-list-horizontal description-list-horizontal-sm mb-0">
                                                @if ($product->discount>0)
                                                    <dt class="font-weight-normal">قیمت اولیه</dt>
                                                    <dd class="text-muted">
                                                        <del class="font-weight-bolder h5 m-0 line-height-sm">{{number_format($product->price)}} {{setting()['currency']}}</del>
                                                    </dd>
                                                    <dt class="font-weight-normal">قیمت تمام شده</dt>
                                                    <dd class="text-primary">
                                                        <span class="font-weight-bolder h4 m-0 line-height-sm">{{number_format($product['price'] * (100-$product['discount']) / 100)}}</span>&nbsp;<small class="font-weight-normal">{{setting()['currency']}}</small>
                                                    </dd>
                                                    <dt class="font-weight-normal">تخفیف</dt>
                                                    <dd class="text-secondary">
                                                        @php $price=($product->price)-($product['price'] * (100-$product['discount']) / 100) @endphp
                                                        <span class="font-weight-bolder h5 m-0 line-height-sm">{{number_format($price)}}</span>&nbsp;<small class="font-weight-normal">{{setting()['currency']}} ({{$product->discount}}%)</small>
                                                    </dd>

                                                @else
                                                    <dt class="font-weight-normal">قیمت تمام شده</dt>
                                                    <dd class="text-primary">
                                                        <span class="font-weight-bolder h4 m-0 line-height-sm">{{number_format($product['price'] * (100-$product['discount']) / 100)}}</span>&nbsp;<small class="font-weight-normal">{{setting()['currency']}}</small>
                                                    </dd>
                                                @endif


                                            </dl>
                                            <!--product price end-->

                                        </div>
                                    @else
                                        <div class="col-lg-7">
                                            <dl class="description-list description-list-horizontal description-list-horizontal-sm mb-0">
                                                <dt class="text-primary">
                                                    <span class="font-weight-bolder h4 m-0 line-height-sm">تمام شد!</span>
                                                </dt>

                                            </dl>

                                        </div>
                                    @endif

                                    <div class="col-lg-5">

                                        <div class="d-flex justify-content-end ml-20">
                                            @if ($product->depot>0)
                                                <div class="text-right">
                                                    <div class="product-box_action">
                                                        <button onclick="addcart(this,'{{$product->id}}')"  class="btn btn-gradient-primary add-to-cart"><i class="ico ico-bag"></i>افزودن به سبد</button>
                                                    </div>
                                                    <span class="text-caption text-muted d-block my-4"><i class="ico ico-18px ico-circle-info filter-gray"></i>افزودن به سبد خرید به معنای اتمام خرید نیست</span>

                                                </div>
                                            @else
                                                <div class="text-right">
                                                    <button class="btn btn-gradient-secondary request-quantity" data-storeid="1966" data-productid="10419" data-supplier="False"><i class="ico ico-check-circle"></i>موجود کن</button>
                                                </div>
                                            @endif

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--product price end-->
                        </div>
                    </div>
                    <!--product general info end-->

                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container mb-20">
            <div class="card">

                <div class="card-header card-header-right-border px-0">

                    <!--header tools-->
                    <div class="card-header_tools rounded-lg w-100">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-lg w-100" id="myTab" role="tablist">
                            @if ($product->content!="")
                                <li class="nav-item">
                                    <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true" title=""><i class="ico ico-circle-info"></i>توضیحات</a>
                                </li>
                            @endif
                            @if (count($featurs))
                                <li class="nav-item">
                                    <a class="nav-link @if($product->content=="")active @endif" id="feature-tab" data-toggle="tab" href="#feature" role="tab" aria-controls="feature" aria-selected="false" title=""><i class="ico ico-circle-info"></i>مشخصات</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link @if($product->content=="" and !count($featurs))active @endif" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false" title=""><i class="ico ico-comments"></i>نظرات کاربران</a>
                            </li>
                                @php $linkdownload=App\Linkdownload::where('product_id',$product->id)->first(); @endphp
                                @if(!empty(@$linkdownload))
                            <li class="nav-item">
                                <a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab" aria-controls="download" aria-selected="false" title=""><i class="ico fas fa-file-download"></i>لینک دانلود</a>
                            </li>
                                @endif
                                @if($product->video!="")
                                    <li class="nav-item">
                                        <a class="nav-link" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false" title=""><i class="ico fas fa-video"></i>ویدیو محصول</a>
                                    </li>
                                @endif
                        </ul>

                    </div>
                    <!--header tools end-->

                </div>

                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        @if ($product->content!="")
                            <div class="tab-pane active" id="description" role="tabpanel" aria-labelledby="description-tab">

                                <div class="d-flex align-items-stretch">

                                    <!--icon-->
                                    <div class="ml-24">
                                        <div class="bg-gray-100 rounded-circle p-36">
                                            <i class="ico ico-color_paper-pen ico-64px ico-fw-0"></i>
                                        </div>
                                    </div>
                                    <!--icon end-->
                                    <div class="text-justify">
                                        <p><?= $product->content ?></p>
                                    </div>
                                </div>

                            </div>
                        @endif



                    <!--comments-->
                        @if (count($featurs))
                            <div class="tab-pane @if($product->content=="")active @endif" id="feature" role="tabpanel" aria-labelledby="feature-tab">

                                <div class="align-items-stretch">
                                    <h2 class="c-params__headline">
                                        مشخصات فنی
                                        <br>
                                        <span style="">{{$product->title}}</span>
                                    </h2>
                                    @foreach($featurs as $featur)
                                        <div class="row" style="margin-bottom: 30px">
                                            <div class="col-lg-3 col-xs-12">
                                                <div class="card" style="background: #f9f9f9;">
                                                    <div class="card-body">
                                                        {{$featur->title}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-xs-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        {{$featur->content}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                    @endif
                    <!--comments end-->

                        <!--comments-->
                        <div class="tab-pane  @if($product->content=="" and !count($featurs))active @endif" id="comments" role="tabpanel" aria-labelledby="comments-tab">

                            <div class="d-flex align-items-stretch">

                                <!--star-->
                                <div class="w-50 d-flex align-items-center">
                                    <div class="w-50 p-24">

                                        <div class="text-center">
                                            <div>میانگین نظرات کاربران</div>
                                            <div class="d-flex align-items-center justify-content-center position-relative my-8">
                                                <i class="ico ico-star ico-128px ico-fw-0"></i>
                                                <span class="text-white position-absolute h2 font-weight-bolder m-0">{{ceil(@$sum_rating)}}</span>
                                            </div>
                                            <div class="text-caption">براساس {{count($comments)}} رأی</div>
                                        </div>

                                    </div>

                                    <div class="w-50">
                                        <!--progress items-->
                                        <div class="d-flex text-nowrap align-items-center mb-16">
                                            <div class="text-caption">{{ceil(@$sum_rating)}} ستاره</div>
                                            <div class="progress flex-fill flex-wrap mx-8">
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%" aria-valuenow="7" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="text-caption">({{count($comments)}})</div>
                                        </div>
                                        <!--progress items end-->
                                    </div>
                                </div>
                                <!--star end-->
                                <!--divider-->
                                <div class="d-flex align-items-center mx-24">
                                    <div class="divider-vertical divider-vertical-lg"></div>
                                </div>
                                <!--divider end-->
                                <!--write comment button-->
                                <div class="w-50 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <div class="mb-8">آیا از این محصول استفاده کرده اید؟</div>
                                        <a class="btn btn-outline-primary px-48" href="/comment/{{$product->slug}}" title="">ثبت نظر</a>
                                    </div>
                                </div>
                                <!--write comment button end-->

                            </div>

                            <hr>

                            <ul class="list-unstyled">
                                <!--comments item-->
                                @if (count($comments))

                                    @foreach($comments as $comment)
                                        <li class="py-20 mb-20">

                                            <!--comment header-->
                                            <div class="d-flex align-items-center">
                                                <!--stars-->
                                                <div class="ico-star-rating ico-star-{{$comment->rating}}">

                                                    <i class="ico ico-18px ico-star"></i>
                                                    <i class="ico ico-12px ico-star"></i>
                                                    <i class="ico ico-12px ico-star"></i>
                                                    <i class="ico ico-12px ico-star"></i>
                                                    <i class="ico ico-12px ico-star"></i>


                                                </div>
                                                <!--stars end-->
                                                <div class="text-primary font-weight-bold mx-8">
                                                </div>
                                                <div class="font-weight-light">{{Verta::instance($comment->creat_at)}}</div>
                                            </div>
                                            <!--comment header end-->
                                            <!--writer-->
                                            <div class="my-8">
                                                <small>توسط</small>&nbsp;
                                                <span class="font-weight-bold">@if ($comment->user->name=="" or $comment->user->family=="")
                                                        کاربر سایت
                                                    @else
                                                        {{$comment->user->name.' '.$comment->user->family}}
                                                    @endif</span>
                                            </div>
                                            <!--writer end-->
                                            <div class="text-justify font-weight-light" style="font-weight: 700 !important;font-size: 15px;">{{$comment->title}}</div>
                                            <!--comment text-->
                                            <div style="font-size: 15px;margin-right: 10px;" class="text-justify font-weight-light">{{$comment->content}}</div>
                                            <!--comment text end-->

                                        </li>
                                    @endforeach
                                @else
                                    <li>شما اولین نفری باشید که نظر خود را ثبت میکنید.</li>
                                    <!--comments item end-->
                                @endif
                            </ul>

                        </div>
                        <!--comments end-->

                            @php $linkdownload=App\Linkdownload::where('product_id',$product->id)->first(); @endphp
                            @if(!empty($linkdownload))
                                <div class="tab-pane" id="download" role="tabpanel" aria-labelledby="download-tab">

                                    <div class="d-flex align-items-stretch">

                                        <!--icon end-->
                                        <div class="text-justify">
                                            <a target="_blank" href="{{asset($linkdownload->path)}}" class="btn btn-warning btn-block waves-effect">دانلود</a>
                                        </div>
                                    </div>

                                </div>
                            @endif
                            @if ($product->video!="")
                                <div class="tab-pane" id="video" role="tabpanel" aria-labelledby="video-tab">

                                    <div class="align-items-stretch">
                                        <h2 class="c-params__headline">
                                            ویدیو محصول
                                            <br>
                                            <span style=""> ویدیو {{$product->title}}</span>
                                        </h2>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                @if($product->video)
                                                    <video width="100%" controls>
                                                        <source src="{{asset($product->video)}}" type="video/mp4">
                                                    </video>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif
    <!--product details and light-box end-->


    <!--product slider-->
    @if(count($like_products))
    <section>
        <div class="container mb-20">

            <div class="card">

                <!--card header-->
                <div class="card-header card-header-right-border">

                    <!--header caption-->
                    <div class="card-header_caption">
                        <div class="card-header_caption-title">
                            <div class="card-header_caption-text">کالاهای مشابه</div>
                        </div>
                    </div>
                    <!--header caption end-->

                </div>
                <!--card header end-->
                <!--slider and card body-->
                <div class="position-relative">
                    <!-- Swiper -->
                    <div
                        class="swiper-container swiper-container-products p-24 swiper-container-horizontal swiper-container-rtl">

                        <!-- Swiper Wrapper -->
                        <div class="swiper-wrapper">

                        @php $item_row=1; @endphp
                        @foreach($like_products as $item)
                            <!--product item-->
                                <div class="swiper-slide @if($item_row==1)swiper-slide-active @elseif($item_row==2)swiper-slide-next @endif" style="width: 260.2px;">
                                    <div class="product-box product-box_hover">

                                        <!--product image and badge-->
                                        <a href="/product/{{$item->slug}}" class="product-box_image"
                                           data-click="showProductDetail" data-productid="{{$item->id}}" data-storeid="{{$item->id}}"
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
                                                <div class="product-box_discount"><span>%{{$item->discount}}<small>تخفیف</small></span></div>
                                            @endif
                                        </a>
                                        <!--product image and badge end-->
                                        <!--product title-->
                                        <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                           data-productid="21867" class="product-box_title text-dark"><h2
                                                style="font-size: 0.85rem">{{$item->title}}</h2></a>
                                        <!--product title end-->
                                        <!--product content-->
                                        @if ($item->depot>0)
                                            <div class="product-box_content">

                                                <!--price-->
                                                <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                                   data-productid="{{$item->id}}" class="product-box_price">
                                                    @if ($item->discount>0)
                                                        <div class="product-box_price flex-row flex-nowrap h-auto mb-16">
                                                            <del class="ml-8">{{number_format($item->price)}}</del>
                                                            <div class="product-box_price-value">{{number_format($item['price'] * ($item['discount']) / 100)}}<span
                                                                    class="product-box_price-currency">{{setting()['currency']}}</span></div>
                                                        </div>
                                                    @else

                                                        <div class="product-box_price flex-row flex-nowrap h-auto mb-16">
                                                            <div class="product-box_price-value">{{number_format($item->price)}}<span
                                                                    class="product-box_price-currency">{{setting()['currency']}}</span></div>
                                                        </div>
                                                    @endif


                                                </a>

                                                <!--price end-->
                                                <!--action-->
                                                <div class="product-box_action">
                                                    <button onclick="addcart(this,{{$item->id}})" type="button" class="btn btn-gradient-primary add-to-cart pr-8 pl-8"
                                                            data-productid="21867" data-storeid="1966" data-supplier="False"
                                                            data-qty="1"><i class="ico ico-color_plus-circle filter-none"></i>افزودن
                                                        به سبد
                                                    </button>
                                                </div>
                                                <!--action btn-->

                                            </div>
                                        @else
                                            <div class="product-box_content">
                                                <a href="/product/{{$item->slug}}" data-click="showProductDetail" data-productid="{{$item->id}}" class="product-box_price">
                                                    <div class="product-box_price-value">تمام شد!</div>
                                                </a>
                                                <div class="product-box_action">
                                                    <button type="button" class="btn btn-gradient-secondary request-quantity" data-productid="{{@$item->id}}" data-storeid="{{@$item->id}}" data-supplier="False">موجود کن</button>
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
                        <div class="swiper-button-next swiper-button-custom" tabindex="0" role="button"
                             aria-label="Next slide" aria-disabled="false"></div>
                        <div class="swiper-button-prev swiper-button-custom swiper-button-disabled" tabindex="0"
                             role="button" aria-label="Previous slide" aria-disabled="true"></div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                </div>
                <!--slider and card body end-->

            </div>

        </div>
    </section>
    @endif
    <!--product slider end-->

    <!--product light-box modal-->
    <div class="modal fade" id="productLightBoxModal" tabindex="-1" role="dialog"
         aria-labelledby="productLightBoxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">

                <div class="product-modal-gallery_main">


                    <aside class="product-modal-gallery_aside">
                        <!-- Add Arrows -->
                        <div class="swiper-modal-vertival-btn-next"></div>
                        <div class="swiper-modal-vertival-btn-prev"></div>

                        <div class="swiper-container modal-lightbox-aside">
                            <div class="swiper-wrapper">
                                @if (count($images))
                                <?php $i=1; ?>
                                @foreach($images as $img)
                                <div class="swiper-slide">
                                    <img data-src="{{asset($img->path)}}"
                                         class="lazy"
                                         data-zoom-image="{{asset($img->path)}}"
                                         alt="{{$product->title}}" width="128" height="128"
                                         src="{{asset($img->path)}}">
                                </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <img data-src="{{asset($product->image)}}"
                                             class="lazy"
                                             data-zoom-image="{{asset($product->image)}}"
                                             alt="{{$product->title}}" width="128" height="128"
                                             src="{{asset($product->image)}}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </aside>

                    <div class="product-modal-gallery_content p-24">

                        <!--close icon-->
                        <div class="mb-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                    class="ico ico-close" aria-hidden="true"></i></button>
                        </div>
                        <!--close icon end-->

                        <div class="swiper-container modal-lightbox-content h-100">
                            <div class="swiper-wrapper">
                                @if (count($images))
                                <?php $i=1; ?>
                                @foreach($images as $img)
                                <div class="swiper-slide">
                                    <img data-src="{{asset($img->path)}}"
                                         class="lazy"
                                         data-zoom-image="{{asset($img->path)}}"
                                         alt="{{$product->title}}" width="550" height="550"
                                         src="{{asset($img->path)}}">
                                </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <img data-src="{{asset($product->image)}}"
                                             class="lazy"
                                             data-zoom-image="{{asset($product->image)}}"
                                             alt="{{$product->title}}" width="550" height="550"
                                             src="{{asset($product->image)}}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!--product light-box modal end-->
    <!--products comments and description end-->

    <!--product wrap end-->
@endsection
@section('script_link')
    <script src="{{asset('plugins/ElevateZoom/jquery.elevatezoom.js')}}"></script>
@endsection



@section('script')

    @if(session('save_comment'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('نظر شما با موفقیت ذخیره شده و بعد از تائید مدیر در سایت نمایش داده می شود');
        </script>
    @endif
    <script>
        view({{$product->id}})
        function view(id) {
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('view.set_view_product')}}';
            var data = {_token: CSRF_TOKEN,id:id};
            $.post(url, data, function (msg) {
            });
        }


    </script>
    <script>
        $(".elevatezoom").elevateZoom({
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 500,
            lensFadeIn: 500,
            lensFadeOut: 500,
            scrollZoom : true
        });
    </script>
@endsection

@php
    Session::forget('save_comment');
@endphp
