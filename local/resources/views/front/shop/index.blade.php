@extends('front.layout.master')
@section('style_link')
    <link href="{{asset('assets/css/shop.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/css/noUISlider.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
@endsection
@section('style')
    <style>
        .mt-5, .my-5 {
            margin-top: 3rem !important;
        }

        .mb-4, .my-4 {
            margin-bottom: 1.5rem !important;
        }
        .remember-me{
            cursor: pointer;
        }
        hr {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    @php $agent=new Jenssegers\Agent\Agent();@endphp
    <div class="container my-16">

        <div class="row small-gutters">

            <!--sidebar wrap-->
            <aside class="col-xl-3 d-none d-xl-block">
                <div class="sidebar-wrapper">
                    <div class="listing-sidebar mb-4">
                        <div class="box-header-product-feature mb-3">
                            <span class="title-product">فیلتر محصولات</span>
                        </div>

                            <?php $st=1; ?>
                            @foreach($attributes as $attribute)
                                <?php $st++ ?>
                            <div class="box">
                                <div class="box-header">
                                    <h2 class="mb-0">
                                        <button class="btn btn-block text-right" data-toggle="collapse"
                                                href="#collapseExample{{$attribute->id}}" role="button" aria-expanded="true"
                                                aria-controls="collapseExample{{$attribute->id}}">
                                            {{$attribute->title}}
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseExample{{$attribute->id}}" class="collapse show">
                                    <div class="card-main mb-3">
                                        <?php
                                        $row=1;
                                        $attrs=@$_GET['attribute'];
                                        @$attrs=explode(',',$attrs[0]);
                                        $i=0;
                                        ?>
                                        @foreach($attribute->attribute_values as $attribute_value)
                                            <?php $attr=array_search($attribute_value->id,$attrs,false);
                                            ?>
                                        <div class="form-auth-row">
                                            <label class="ui-checkbox ">
                                                <input id="attr{{$attribute_value->id}}" type="checkbox" @if($attr!="") checked @elseif($attrs[0]==$attribute_value->id)checked @endif class="filte_right" onclick="doSearch()" name="attribute[]" value="{{$attribute_value->id}}">
                                                <span class="ui-checkbox-check"></span>
                                            </label>
                                            <label for="attr{{$attribute_value->id}}" class="remember-me">{{$attribute_value->value}}</label>
                                        </div>
                                                <?php $row++;$i++ ?>
                                            @endforeach
                                    </div>
                                </div>
                            </div>
                                @endforeach



                        <div class="box">
                            <div class="box-header">
                                <h2 class="mb-0">
                                    <button class="btn btn-block text-right" data-toggle="collapse"
                                            href="#collapseExamplee5" role="button" aria-expanded="true"
                                            aria-controls="collapseExamplee5">
                                        محدوده قیمت
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseExamplee5" class="collapse show">
                                <div class="card-main mb-3">
                                    <div class="box-data">
                                        <div class="mt-5 mb-4">
                                            <div id="slider-non-linear-step"></div>
                                        </div>
                                        <div class="filter-range mt-2 mb-2">
                                            <input type="hidden" id="amountPriceFiltter" value="{{@$_GET['amount']}}">
                                            <span>قیمت: </span>
                                            <span class="example-val" id="slider-non-linear-step-value"></span> تومان
                                        </div>
                                        <div class="mt-5">
                                                <span onclick="doSearch()" class="btn btn-range btn-block" id="sabt-price">
                                                    اعمال محدوده قیمت
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="box">
                            <div class="statusswitcher">
                                <a href="#">
                                    <label for="switch1">
                                        <input onchange="doSearch()" type="checkbox" id="switch1" @if(@$_GET['exist']=="yes")checked @endif><span class="switch"><h1
                                                class="switch-title">فقط کالای موجود</h1></span>
                                        <span class="toggle"></span>
                                    </label>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </aside>
            <!--sidebar wrap end-->
            <!--product list wrap-->
            <div class="col-xl-9">

                <div class="d-flex align-items-center mb-16">

                    <!--breadcrumb-->
                    <nav class="ml-auto d-none d-lg-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">خانه</a></li>

                            @php @$category2=\App\Category::where('id',$category->parent)->first(); @endphp
                            @php @$category3=\App\Category::where('id',$category2->parent)->first(); @endphp
                            @php @$category4=\App\Category::where('id',$category3->parent)->first(); @endphp
                            @php @$category5=\App\Category::where('id',$category4->parent)->first(); @endphp
                            @php @$category6=\App\Category::where('id',$category5->parent)->first(); @endphp
                            @if($category6!="")<li class="breadcrumb-item"><a href="/search/{{$category6->slug}}">{{$category6->title}}</a></li>@endif
                            @if($category5!="")<li class="breadcrumb-item"><a href="/search/{{$category5->slug}}">{{$category5->title}}</a></li>@endif
                            @if($category4!="")<li class="breadcrumb-item"><a href="/search/{{$category4->slug}}">{{$category4->title}}</a></li>@endif
                            @if($category3!="")<li class="breadcrumb-item"><a href="/search/{{$category3->slug}}">{{$category3->title}}</a></li>@endif
                            @if($category2!="")<li class="breadcrumb-item"><a href="/search/{{$category2->slug}}">{{$category2->title}}</a></li>@endif
                            @if($category!="")<li class="breadcrumb-item"><a href="/search/{{$category->slug}}">{{$category->title}}</a></li>@endif


                        </ol>
                    </nav>
                    <!--breadcrumb end--><!--sort box-->

                </div>
                <div class="row">
                    @php $cats=\App\Category::where('parent',@$category->id)->get(); @endphp
                    @foreach($cats as $cat)
                    <div class="col-md-3">
                        <div class="card" id="search-box">
                            <div class="card-body" style="padding: 0">
                                <a href="/search/{{@$cat->slug}}" style="padding: 10px 0;display: block;color: #555">{{@$cat->title}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--product list action end-->
                <!--grid product wrap-->
                <div class="card" id="search-box">
                    <div class="card-body">
                        <!--product list action-->
                        <div class="d-flex align-items-center mb-16" style="justify-content: flex-end;">

                            <!--sort box-->
                            <div class="d-flex justify-content-lg-end align-items-center" style="margin-left: 20px">
                                @if (!$agent->isMobile())
                                    <span>تعداد نمایش:</span>
                                @endif
                                <?php
                                $limit=@$_GET['limit'];
                                ?>
                                <select id="limit" class="select-css" onchange="doSearch('')" style="width: 65px">
                                    <option @if($limit=="12") selected @endif value="12">12</option>
                                    <option @if($limit=="20") selected @endif value="20">20</option>
                                    <option @if($limit=="28") selected @endif value="28">28</option>
                                </select>


                            </div>

                            <div class="d-flex justify-content-lg-end align-items-center">

                                @if (!$agent->isMobile())
                                    <span>نمایش براساس:</span>
                                @endif
                                <?php
                                $sort=@$_GET['sort'];
                                ?>
                                <select id="sort" class="select-css" onchange="doSearch('')">
                                    <option @if($sort=="priceLow") selected @endif value="priceLow">ارزانترین ها</option>
                                    <option @if($sort=="priceHigh") selected @endif value="priceHigh">گرانترین ها</option>
                                    <option @if($sort=="discount") selected @endif value="discount">پرتخفیف ترین ها</option>
                                    <option @if($sort=="sale") selected @endif value="sale">پرفروش ترین ها</option>
                                    <option @if($sort=="view") selected @endif value="view">محبوب ترین ها</option>
                                    <option @if($sort=="new") selected @endif value="new">جدیدترین ها</option>
                                </select>


                            </div>
                            <!--sort box end-->
                        </div>
<hr>

                        <!--                        <h1 style="text-align: right">لبنیات</h1>-->
                        <div class="row small-gutters" id="products">


                            <!--product item-->
                            @if (count($productItems))
                            @foreach($productItems as $item)
                                @if ($agent->isMobile())
                                <div class="d-flex align-items-right py-8" id="product"  data-page="<?= $pageNum2+1?>" style="width: 100%;text-align: right">

                                    <!--product img-->
                                    <a href="/product/{{$item->slug}}" class="d-block ml-8 p-4 position-relative" title="Link: /product/{{$item->slug}}">
                                        @if($item->image)
                                            @if(file_exists(public_path() . '/' . $item->image))
                                                <img src="{{asset($item->image)}}" width="80" height="80" class="img-contain lazy loaded" data-src="{{asset($item->image)}}" alt="{{$item->title}}" data-was-processed="true">

                                            @else
                                                <img src="{{asset('images/nopic.png')}}" width="80" height="80" class="img-contain lazy loaded" data-src="{{asset($item->image)}}" alt="{{$item->title}}" data-was-processed="true">

                                            @endif

                                        @else
                                            <img src="{{asset('images/nopic.png')}}" width="80" height="80" class="img-contain lazy loaded" data-src="{{asset($item->image)}}" alt="{{$item->title}}" data-was-processed="true">

                                        @endif
                                        @if ($item->discount>0)
                                            <div class="product-box_discount"><span>%{{$item->discount}}<small>تخفیف</small></span></div>
                                        @endif
                                    </a>

                                    <div class="flex-grow-1">

                                        <!--product title-->
                                        <a href="/product/{{$item->slug}}" class="subtitle2 mb-16 d-block text-dark" title="Link: /product/{{$item->slug}}">{{$item->title}}</a>
                                        @if ($item->depot>0)
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div class="line-height-sm w-100 flex-grow-1 font-weight-bold">
                                                @if ($item->discount>0)
                                                <del class="text-muted text-caption">{{number_format($item->price)}}</del>
                                                <div class="text-primary">{{number_format($item['price'] * (100-$item['discount']) / 100)}}<small class="mr-4">{{setting()['currency']}}</small></div>
                                                @else
                                                    <div class="text-primary">{{number_format($item->price)}}<small class="mr-4">{{setting()['currency']}}</small></div>
                                                @endif
                                            </div>

                                            <div class="flex-grow-0 w-100">
                                                <div class="w-100 product-box_action product-sm-box_action">
                                                    <button onclick="addcart(this,'{{$item->id}}')" class="btn btn-gradient-primary btn-sm w-100 add-to-cart" data-supplier="False" data-qty="1"><i class="ico ico-bag d-none"></i>افزودن به سبد</button>
                                                </div>
                                            </div>

                                        </div>
                                        @else
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div class="line-height-sm w-100 flex-grow-1 font-weight-bold">
                                                <div class="text-primary">تمام شد!</div>
                                            </div>
                                            <div class="flex-grow-0 w-100">
                                                <div class="w-100 product-box_action product-sm-box_action">
                                                    <button class="btn btn-gradient-secondary btn-sm w-100 request-quantity"  data-productid="{{$item->id}}" data-storeid="{{$item->id}}"  data-supplier="False"><i class="ico ico-check-circle d-none"></i>موجود کن</button>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                                    <hr>
                                @else
                                <div class="col-lg-3 col-md-4 col-sm-6 p-1" id="product"  data-page="<?= $pageNum2+1?>" style="width: 260.2px;">
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
                                                        <div class="product-box_price-value">{{number_format($item['price'] * (100-$item['discount']) / 100)}} <span
                                                                class="product-box_price-currency">{{setting()['currency']}}</span></div>
                                                    @else
                                                        <div class="product-box_price-value">{{number_format($item->price)}} <span
                                                                class="product-box_price-currency">{{setting()['currency']}}</span></div>
                                                    @endif

                                                </a>

                                                <!--price end-->
                                                <!--action-->
                                                <div class="product-box_action">
                                                    <button onclick="addcart(this,'{{$item->id}}')" type="button" class="btn btn-gradient-primary add-to-cart pr-8 pl-8"><i class="ico ico-color_plus-circle filter-none"></i>افزودن
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
                                                    <button type="button" class="btn btn-gradient-secondary request-quantity" data-productid="{{$item->id}}" data-storeid="{{$item->id}}" data-supplier="False">موجود کن</button>
                                                </div>
                                            </div>
                                    @endif


                                    <!--product content end-->

                                    </div>
                                </div>
                            @endif


                        @endforeach
                        @else
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <h6 style="text-align: right;width: 100%">محصول مورد نظر یافت نشد!</h6>
                                </div>
                            @endif
                            <!--product item end-->

                        </div>
                    </div>
                    <div class="card-footer bg-white border-top">

                        <nav class="d-flex align-items-center justify-content-center py-8" v-if="products.last_page">
                            <ul data-v-82963a40="" class="pagination mb-0 mx-auto">
                                {{$productItems->links()}}
                            </ul>

                        </nav>

                    </div>
                </div>
                <div class="tab-pane fade show active" id="tab-body_0" role="tabpanel" aria-labelledby="icon-tab_0">

                </div>

                <!--grid product wrap end-->
            </div>
            <!--product list wrap end-->

        </div>
    </div>
@endsection

@section('script_link')

    <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/js/nouislider.min.js')}}"></script>
    <script src="{{asset('assets/js/wNumb.js')}}"></script>
@endsection

@section('script')
    <script>


        var nonLinearStepSlider = document.getElementById('slider-non-linear-step');
        var amountPriceFiltter = document.getElementById('amountPriceFiltter');

        if($('#slider-non-linear-step').length) {
            noUiSlider.create(nonLinearStepSlider, {
                start: [0, 5000000],
                connect: true,
                direction: 'ltr',
                format: wNumb({
                    decimals: 0,
                    thousand: ','
                }),
                range: {
                    'min': [0],
                    '10%': [500, 500],
                    '50%': [40000, 1000],
                    'max': [10000000]
                }
            });
            var nonLinearStepSliderValueElement = document.getElementById('slider-non-linear-step-value');

            nonLinearStepSlider.noUiSlider.on('update', function (values) {
                nonLinearStepSliderValueElement.innerHTML = values.join(' - ');
                amountPriceFiltter.value=values.join('|');
            });
        }
    </script>

    <script>
        function doSearch() {
            $('.page-loading').css('display','block');
            var href="{{$slug}}";

            $('#products').empty();
            $('.pagination').empty();
            var attribute=[];
            var attribute_url="";
            $('.filte_right').each(function () {
                if ($(this).is(':checked')){
                    attribute.push($(this).val());
                    attribute_url='&attribute[]='+attribute;
                }
            })

            var url_page=1;
            /*var url_page='{{@$_GET['page']}}';
            if (!url_page){
                url_page=1;
            }*/

            var exist="no";
            var exist_url="";
            if ($('#switch1').is(':checked')){
                 exist="yes";
                exist_url="&exist=yes";
            }

            var limit=$('#limit').val();

            var sort=$('#sort').val();


            var amount=$('#amountPriceFiltter').val();

            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('shop.doSearch')}}';
            var data = {_token: CSRF_TOKEN, attribute:attribute,limit:limit,sort:sort,exist:exist,amount:amount,slug:'{{$slug}}'};
            $.post(url, data, function (msg) {

                $('#products').append(msg)
                var pageName=$('#product').attr('data-page');


                if (pageName>1){
                    var i;
                    var Num;
                    var Num2;
                    var start = url_page - 7;
                    if (start <= 0) {
                        start = 0;
                    }

                    var end =  parseInt(url_page)+ 7;
                    if (end > pageName) {
                        end = url_page;
                    }

                    for (i = start; i <= end; i++) {
                        if (i<=start){Num="‹";Num2=parseInt(url_page)-1;}else {
                            if (i==end){Num="›";Num2=parseInt(url_page)+1;}else {Num=i;Num2=i;}
                        }
                        if(Num2<1){
                            Num2=1;
                        }

                        var active="";
                        if (url_page==i){
                            active="active";
                        }
                        href+="?page="+Num2+"&sort="+sort+"&limit="+limit+exist_url+attribute_url+"&amount="+amount;
                        $('.pagination').append('<li class="page-item '+active+'"><a class="page-link" href="{{$slug}}?page='+Num2+'&sort='+sort+'&limit='+limit+exist_url+attribute_url+'&amount='+amount+'">'+Num+'</a></li>')

                    }
                }
                $('.page-loading').css('display','none');
            });


            href+="?page=1"+"&sort="+sort+"&limit="+limit+exist_url+attribute_url+"&amount="+amount;
            ChangeUrl("",href);

        }
        function ChangeUrl(page, url) {
            if (typeof (history.pushState) != "undefined") {
                var obj = {Page: page, Url: url};
                history.pushState(obj, obj.Page, obj.Url);
            } else {
                alert("Browser does not support HTML5.");
            }
        }

        @if(@$_GET['sort'])
        paginate()
        @endif
        function paginate(){
            $('.pagination').empty();
            var limit=$('#limit').val();

            var sort=$('#sort').val();
            var pageName=$('#product').attr('data-page');

            var exist="no";
            var exist_url="";
            if ($('#switch1').is(':checked')){
                exist="yes";
                exist_url="&exist=yes";
            }

            var url_page='{{@$_GET['page']}}';
            if (!url_page){
                url_page=1;
            }

            var attribute=[];
            var attribute_url="";
            $('.filte_right').each(function () {
                if ($(this).is(':checked')){
                    attribute.push($(this).val());
                    attribute_url='&attribute[]='+attribute;
                }
            })
            var amount=$('#amountPriceFiltter').val();
            if (pageName>1) {
                var i;
                var Num;
                var Num2;
                var start = url_page - 7;
                if (start <= 0) {
                    start = 0;
                }

                var end =  parseInt(url_page)+ 7;
                if (end > pageName) {
                    end = url_page;
                }
                for (i =start; i <= end; i++) {
                    if (i<=start){Num="‹";Num2=parseInt(url_page)-1;}else {
                        if (i==end){Num="›";Num2=parseInt(url_page)+1;}else {Num=i;Num2=i;}
                    }
                    if(Num2<1){
                        Num2=1;
                    }
                    var active = "";
                    if (url_page == i) {
                        active = "active";
                    }

                    $('.pagination').append('<li class="page-item ' + active + '"><a class="page-link" href="{{$slug}}?page=' + Num2 + '&sort=' + sort + '&limit=' + limit + exist_url + attribute_url + '&amount=' + amount + '">' + Num + '</a></li>')

                }
            }
        }
    </script>

@endsection
