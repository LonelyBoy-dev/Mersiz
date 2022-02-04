@extends('front.layout.master')
@section('style_link')
@endsection
@section('style')
    <style>
        .li-blog-sidebar .li-recent-post .li-recent-post-thumb {
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

        .product-box.product-box_hover {
            padding: 0;
        }

        .product-box_image {
            width: 100%;
        }

        .product-box_image img {
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

        .product-box.product-box_hover .content {
            padding: 15px;
            width: 100%;
        }

        .product-box.product-box_hover .title {
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

        .sidebar-blog {
            float: right;
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e6e7;
        }

        .card-header.card-header-right-border:before {
            right: -12px;
        }

        .card-header .card-header_caption .card-header_caption-title .card-header_caption-text {
            font-size: 19px;
        }

        .blog-post h1 {
            font-size: 30px;
            font-weight: 500;
            margin-top: 15px;
        }

        .blog-write-comment {
            background: #fff;
            margin-top: 10px;
            padding: 0 20px 10px;
        }

        .cmnt_reply_form {
            width: 100%;
        }

        p, span, div, h1, h2, h3, h4, h5, h6, a {
            font-family: IRANSans, Tahoma !important;
        }
    </style>
@endsection
@section('content')
    @php $agent=new Jenssegers\Agent\Agent();@endphp
    <div class="container my-16" style="margin-top: 60px">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 order-lg-2 order-2"
                     style="background: #fff;height: max-content;    DISPLAY: inline-table;@if ($agent->isMobile())margin: 15px 10px; @endif">
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
                                <div id="total-search-input"
                                     class="d-flex justify-content-between align-items-center input-group form-control"
                                     style="box-shadow: none; padding: 0px 0px 0px 2px; box-sizing: border-box; background: rgb(248, 248, 248); border: 1px solid rgb(241, 241, 241);">
                                    <div class="d-flex w-80 align-items-center" style="padding-right:20px">
                                        <button style="border: none;background: none;" type="submit">
                                            <img src="{{asset('assets/img/main_search_icon.svg')}}" alt="search_icon"
                                                 style="width:18px;height:18px">
                                        </button>
                                        <input autocomplete="off" name="keyword" type="text" id="search-field"
                                               class="form-control shadow-none h-100"
                                               style="border:none;background:transparent" placeholder="جستجو">
                                    </div>
                                    <div @*class="input-group-append" *@="" style="display:none">
                                        <button id="search-button"
                                                class="btn d-flex justify-content-center align-content-center"
                                                style="width:101px; height:42px; font-size:14px; padding:unset 28px"
                                                type="submit">جستجو
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
                                    <div class="card-header_caption-text">دسته بندی</div>
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
                        @foreach($last_posts as $last_post)
                            <div class="sidebar-blog">
                                <a href="/blog/{{$post->slug}}" style="float: right;padding: 3px 7px;"
                                   class="image"><img src="{{asset($last_post->imgPath)}}" alt=""></a>
                                <div class="content">
                                    <h5 style="float: right;"><a
                                                href="/blog/{{$last_post->slug}}">{{Illuminate\Support\Str::limit($last_post->title,50)}}</a>
                                    </h5>
                                    <span style="padding: 3px 7px;width: 100%;float: right">{{Verta::instance($last_post->updated_at)->format(' %d %B %Y')}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-lg-9 order-lg-1 order-1">
                    <div class="row">

                        <div class="blog-page" style="width: 100%;;overflow: hidden">
                            <div class="col-xs-12 col-sm-12 col-md-12 rht-col">
                                <div class="blog-post wow fadeInUp" style="background: #fff">
                                    <img style="width: 100%" class="img-responsive" src="{{asset($post->imgPath)}}"
                                         alt="{{$post->title}}">
                                    <h1>{{$post->title}}</h1>

                                    <span class="review">{{$post->view+1}} بازدید </span>
                                    <span class="date-time">{{' - '.Verta::instance($post->updated_at)->format(' %d %B %Y')}}</span>
                                    <div> <?= $post->content ?></div>

                                </div>


                                <div class="blog-write-comment outer-bottom-xs outer-top-xs">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>ارسال دیدگاه</h4>
                                        </div>
                                        <form class="cmnt_reply_form" action="{{route('comment_post_store')}}"
                                              method="post">
                                            @csrf
                                            <div class="row" style="padding: 15px 25px;">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="info-title" for="exampleInputName">نام شما
                                                            <span>*</span></label>
                                                        <input type="text" name="name"
                                                               class="form-control unicase-form-control text-input"
                                                               id="exampleInputName" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="info-title" for="exampleInputEmail1">آدرس ایمیل
                                                            <span>*</span></label>
                                                        <input type="email" name="email"
                                                               class="form-control unicase-form-control text-input"
                                                               id="exampleInputEmail1" placeholder="">
                                                        <input type="hidden" name="post" value="{{$post->id}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="info-title" for="exampleInputComments">دیدگاه تان
                                                            <span>*</span></label>
                                                        <textarea name="content"
                                                                  class="form-control unicase-form-control"
                                                                  id="exampleInputComments"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 outer-bottom-small m-t-20">
                                                    <button type="submit"
                                                            class="btn-upper btn btn-primary checkout-page-button">ثبت
                                                        دیدگاه
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <ul class="list-unstyled">
                                        <!--comments item-->
                                        @foreach($comments as $comment)
                                            <hr>
                                            <li class="py-20 mb-20" style="    padding-right: 20px;">

                                                <!--comment header-->
                                                <div class="d-flex align-items-center">
                                                    <!--stars-->
                                                    <!--stars end-->
                                                    <div class="text-primary font-weight-bold mx-8">
                                                    </div>
                                                    <div class="font-weight-light">{{Verta::instance($comment->created_at)}}</div>
                                                </div>
                                                <!--comment header end-->
                                                <!--writer-->
                                                <div class="my-8" style="padding: 0 14px;">
                                                    <small>توسط</small>&nbsp;
                                                    <span class="font-weight-bold">{{$comment->name}}</span>
                                                </div>
                                                <!--writer end-->
                                                <!--comment text-->
                                                <div style="font-size: 15px;margin-right: 20px;"
                                                     class="text-justify font-weight-light">{{$comment->content}}</div>
                                                <!--comment text end-->

                                            </li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================= FOOTER ============================================================= -->


@endsection

@section('script')
    @if(session('save_comment'))
        <script>
            alertify.set('notifier', 'position', 'bottom-left');
            alertify.success('نظر شما با موفقیت دخیره شده و بعد از تائید مدیر در سایت نمایش داده می شود');
        </script>
    @endif
    <script>
        view({{$post->id}})

        function view(id) {
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('view.set_view_post')}}';
            var data = {_token: CSRF_TOKEN, id: id};
            $.post(url, data, function (msg) {
            });
        }
    </script>
@endsection
@php
    Session::forget('save_comment');
@endphp
