@extends('front.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="{{asset('front/blog/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front/blog/rtl_style.css')}}" />
@endsection
@section('style')
    <style>
        .blog.spad{
            padding-top: 0;
        }
        .blog__item__pic img{
            height: 240px;
        }
        .blog__sidebar{
            text-align: right;
        }
        .blog__sidebar__search form button{
            left: 0;
            top: 4px;
            right: auto;
        }
        .blog__sidebar__search form input{
            padding-right: 15px;
            padding-left: 0;
        }
        .blog__sidebar__item ul{
            padding-right: 15px;
        }
        .blog__sidebar__recent{
            padding-right: 15px;
        }
        .blog__sidebar__recent__item__pic{
            width: 70px;
            height: 70px;
            float: right;
            margin-right:0;
            margin-left:20px;
        }
        .blog__sidebar__recent__item__pic img{
            width: 70px!important;
            height: 75px;
        }
    </style>
@endsection
@section('content')


    {{--    <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>Blog</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.html">Home</a>
                                <span>Blog</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->--}}

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="جستجو...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>دسته بندی</h4>
                            <ul>
                                @foreach($categories as $category)
                                    <li><a href="/blog?cat={{$category->slug}}">{{$category->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>مقالات اخیر</h4>
                            <div class="blog__sidebar__recent">
                                @foreach($posts_rand as $post)
                                    <a href="/blog/{{$post->slug}}" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="{{asset($post->imgPath)}}" alt="">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6>{{Illuminate\Support\Str::limit($post->title,50)}}</h6>
                                            <span>{{Verta::instance($post->updated_at)->format(' %d %B %Y')}}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Search By</h4>
                            <div class="blog__sidebar__item__tags">
                                <a href="#">Apple</a>
                                <a href="#">Beauty</a>
                                <a href="#">Vegetables</a>
                                <a href="#">Fruit</a>
                                <a href="#">Healthy Food</a>
                                <a href="#">Lifestyle</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                        @foreach($posts as $post)
                            <?php $i=count($post->postcategories); ?>
                            @if(@$_GET['cat'])
                                @if(@$post->postcategories[$i-1]->slug==$_GET['cat'])
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="blog__item">
                                            <div class="blog__item__pic">
                                                <img src="{{asset($post->imgPath)}}" alt="">
                                            </div>
                                            <div class="blog__item__text">
                                                <ul>
                                                    <li><i class="fa fa-calendar-o"></i>{{Verta::instance($post->updated_at)->format(' %d %B %Y')}}</li>
                                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                                </ul>
                                                <h5><a href="/blog/{{$post->slug}}">{{Illuminate\Support\Str::limit($post->title,100)}}</a></h5>
                                                <p>{{Illuminate\Support\Str::limit($post->shortContent,100)}}</p>
                                                <a href="/blog/{{$post->slug}}" class="blog__btn">بیشتر<span class="arrow_right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="blog__item">
                                        <div class="blog__item__pic">
                                            <img src="{{asset($post->imgPath)}}" alt="">
                                        </div>
                                        <div class="blog__item__text">
                                            <ul>
                                                <li><i class="fa fa-calendar-o"></i>{{Verta::instance($post->updated_at)->format(' %d %B %Y')}}</li>
                                                <li><i class="fa fa-comment-o"></i> 5</li>
                                            </ul>
                                            <h5><a href="/blog/{{$post->slug}}">{{Illuminate\Support\Str::limit($post->title,100)}}</a></h5>
                                            <p>{{Illuminate\Support\Str::limit($post->shortContent,100)}}</p>
                                            <a href="/blog/{{$post->slug}}" class="blog__btn">بیشتر<span class="arrow_right"></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="col-lg-12" style="display: flex;justify-content: center">
                            {{$posts->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
