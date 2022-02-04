@extends('front.layout.master')
@section('style_link')

@endsection
@section('style')
    <style>
        .li-blog-sidebar .li-recent-post .li-recent-post-thumb{
            border: none;
        }
        .section, .main-wrapper {
            float: left;
            width: 100%;
        }
        .mb-30 {
            margin-bottom: 30px !important;
        }
        .blog .blog-inner .blog-media {
            margin-bottom: 15px;
        }
        .blog .blog-inner .blog-media .image img {
            width: 100%;
        }
        .product-box.product-box_hover{
            padding: 0;
        }
        .product-box_image{
            width: 100%;
        }
        .product-box_image img{
            width: 100%;
        }
        ul {
            list-style: outside none none;
            margin: 0;
            padding: 0;
        }
        .content .meta li {
            font-size: 15px;
            font-weight: 500;
            line-height: 30px;
            text-transform: capitalize;
            margin-bottom: 5px;
        }
         .content .meta {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-bottom: 5px;
        }
         .product-box.product-box_hover .content{
             padding: 15px;
             width: 100%;
         }
        .product-box.product-box_hover .title{
            font-size: 18px;
            font-weight: 600;
            line-height: 26px;
            margin-bottom: 10px;
            text-align: right;
            min-height: 52px;
        }

        .sidebar-blog .image img {
            width: 80px;
            height: 60px;
        }
        .sidebar-blog .content h5 {
            font-size: 14px;
            line-height: 1.5;
            font-weight: 500;
        }
        .sidebar-blog{
            float: right;
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e6e7;
        }
        .card-header.card-header-right-border:before{
            right: -12px;
        }
        .card-header .card-header_caption .card-header_caption-title .card-header_caption-text{
            font-size: 19px;
        }
         .product-box_title{
            width: 100%;
            margin: 0;
            height: auto;
            text-align: right;
            height: 126px;
             max-width: 100%;

        }
         .product-box_title h2{
            font-size: 0.85rem;text-align: right;width: 100%;font-weight: 600;
        }
    </style>
@endsection
@section('content')

    <div class="container my-16" style="margin-top: 60px">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 order-lg-2 order-2" style="background: #fff;height: max-content;DISPLAY: inline-table;">
                    <!-- Single Sidebar Start  -->
                    <div class="common-sidebar-widget">
                        <div class="card-header card-header-right-border" style="margin: 0 0 30px;padding-right: 0;">
                            <div class="card-header_caption">
                                <div class="card-header_caption-title">
                                    <div class="card-header_caption-text">جستجو</div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-search">
                            <form action="{{route('post_search')}}" method="get">
                                <div id="total-search-input" class="d-flex justify-content-between align-items-center input-group form-control" style="box-shadow: none; padding: 0px 0px 0px 2px; box-sizing: border-box; background: rgb(248, 248, 248); border: 1px solid rgb(241, 241, 241);">
                                    <div class="d-flex w-80 align-items-center" style="padding-right:20px">
                                        <button style="border: none;background: none;" type="submit">
                                            <img src="{{asset('assets/img/main_search_icon.svg')}}" alt="search_icon" style="width:18px;height:18px">
                                        </button>
                                        <input autocomplete="off" name="keyword" type="text" id="search-field" class="form-control shadow-none h-100" style="border:none;background:transparent" placeholder="جستجو">
                                    </div>
                                    <div @*class="input-group-append" *@="" style="display:none">
                                        <button id="search-button" class="btn d-flex justify-content-center align-content-center" style="width:101px; height:42px; font-size:14px; padding:unset 28px" type="submit">جستجو
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Single Sidebar End  -->
                    <!-- Single Sidebar Start  -->
                    <div class="common-sidebar-widget">
                    <div class="card-header card-header-right-border" style="margin: 30px 0 0;padding-right: 0;">
                        <div class="card-header_caption">
                            <div class="card-header_caption-title">
                                <div class="card-header_caption-text">دسته بندی </div>
                            </div>
                        </div>
                    </div>
                    <ul style="padding-right: 10px;">
                        <li><a href="/blog">همه</a></li>
                    @foreach($categories as $category)
                        <li><a href="/blog?cat={{$category->slug}}">{{$category->title}}</a></li>
                    @endforeach

                    </ul>
                </div>

                    <div class="common-sidebar-widget">
                        <div class="card-header card-header-right-border" style="margin: 30px 0;padding-right: 0;">
                            <div class="card-header_caption">
                                <div class="card-header_caption-title">
                                    <div class="card-header_caption-text">آخرین مطالب</div>
                                </div>
                            </div>
                        </div>
                        @foreach($last_posts as $post)
                        <div class="sidebar-blog">
                            <a href="/blog/{{$post->slug}}" style="float: right;padding: 3px 7px;" class="image"><img src="{{asset($post->imgPath)}}" alt=""></a>
                            <div class="content">
                                <h5 style="float: right;"><a href="/blog/{{$post->slug}}">{{Illuminate\Support\Str::limit($post->title,50)}}</a></h5>
                                <span style="padding: 3px 7px;width: 100%;float: right">{{Verta::instance($post->updated_at)->format(' %d %B %Y')}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-lg-9 order-lg-1 order-1">
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="swiper-slide col-md-4" style="padding: 10px">
                                <div class="product-box product-box_hover">

                                    <!--product image and badge-->
                                    <a href="/blog/{{$post->slug}}" class="product-box_image" data-click="showProductDetail" data-productid="33" data-storeid="33" data-supplier="False" title="">
                                        <img src="{{asset($post->imgPath)}}" alt="{{Illuminate\Support\Str::limit($post->title,70)}}" width="210" height="210" class="swiper-lazy swiper-lazy-loaded">
                                    </a>
                                    <div class="content">
                                        <ul class="meta">
                                            <li>{{$post->view}} بازدید </li>
                                            <li>{{' - '.Verta::instance($post->updated_at)->format(' %d %B %Y')}}</li>

                                        </ul>
                                        <div class="product-box_title text-dark">
                                        <h3 class="title"><a href="/blog/{{$post->slug}}">{{Illuminate\Support\Str::limit($post->title,70)}}</a></h3>
                                            <?= Illuminate\Support\Str::limit($post->shortContent,105) ?>
                                        </div>
                                            <a href="/blog/{{$post->slug}}" style="float: left;width: 130px;" class="btn btn-gradient-primary">ادامه مطلب</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                        <nav class="d-flex align-items-center justify-content-center py-8">
                            <ul data-v-82963a40="" class="pagination mb-0 mx-auto">
                                {{$posts->links()}}
                            </ul>
                        </nav>

                </div>
            </div>
        </div>
    </div>

    <!--about okala-->
    @if(setting()['about']!="")
        <section>
            <div class="container pb-20">

                <div class="card">

                    <div class="card-body">
                        <div class="h6 font-weight-light text-justify">
                            <?= setting()['about'] ?>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    @endif
@endsection

