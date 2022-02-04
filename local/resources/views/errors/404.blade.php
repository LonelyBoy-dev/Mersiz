
@extends('front.layout.master')
@section('style')
<style>
    .c-404 {
        padding: 68px 0;
        text-align: center;
        line-height: 22px;
    }
    .c-404__title {
        text-align: center;
    }
    .c-404__image {
        width: 90%;
        max-width: 677px;
        margin: auto;
    }
    .c-404__image img {
        width: 100%;
    }
    img, img[alt] {
        line-height: 22px;
    }
</style>
@endsection
@section('content')
    <div class="c-404">
        <div class="c-404__title"><h1>صفحه‌ای که دنبال آن بودید پیدا نشد!</h1></div>
        <div class="c-404__actions"><a href="/" class="c-404__action c-404__action--primary"
                                       title="">صفحه اصلی</a></div>
        <div class="c-404__image"><img data-src="{{asset('images/644d3f75.png')}}"
                                       src="{{asset('images/644d3f75.png')}}" loading="lazy"></div>
    </div>
@endsection
