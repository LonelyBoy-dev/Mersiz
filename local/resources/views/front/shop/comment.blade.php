@extends('front.layout.master')
@section('style')
    <style>
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: 71%;
            color: #dc3545;
        }
        .invalid-feedback-star{
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: 71%;
            background: #dc3545a8;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 3px
        }
    </style>
@endsection
@section('content')
    <div class="container my-16">
        <div class="card">
            <div class="card-body">

                <div class="row align-items-center">

                    <!--product picture-->
                    <div class="col-xl-5 col-lg-6">
                        <div class="d-flex align-items-center justify-content-center">
                            <img data-src="{{asset($product->image)}}" width="550" height="550" class="w-83 h-83 img-fluid img-fit mx-auto lazy loaded" src="{{asset($product->image)}}" data-was-processed="true">
                        </div>
                    </div>
                    <!--product picture end-->
                    <!--product info & form -->
                    <div class="col-xl-7 col-lg-6 d-flex justify-content-center">

                        <div class="w-60-xxl w-75-xl w-100-lg">

                            <div class="w-100">
                                <div class="h4 line-height-sm font-weight-bold">{{$product->title}}</div>
                                <div class="subtitle2 text-muted">{{$product->title}}</div>
                            </div>

                            @if(@$comment->title=="")
                            <form id="frmAddComment" method="post" autocomplete="off" class="submit-form" action="/comment-store/{{$product->slug}}" novalidate="novalidate">
                                @csrf
                                @else
                                    <form id="frmAddComment" method="post" autocomplete="off" class="submit-form" action="/comment-edit/{{$product->slug}}/{{$comment->id}}" novalidate="novalidate">
                                        @csrf
                                       <input type="hidden" value=" {{csrf_token()}}">
                                    @endif
                                <input type="hidden" data-val="true" data-val-required="The ProductId field is required." id="ProductId" name="ProductId" value="1">
                                <input type="hidden" id="Image" name="Image" value="3">
                                <input type="hidden" id="ShortDescription" name="ShortDescription" value="4">
                                <input type="hidden" id="ProductName" name="ProductName" value="5">
                                <div class="d-flex align-items-center justify-content-between my-20">
                                    <div class="text-right">
                                        <div class="font-weight-bold">امتیاز شما</div>
                                        <div class="text-caption text-muted">(امتیاز خود به این کالا را مشخص کنید)</div>

                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <div class="star-rating" style="cursor: pointer;"><input type="hidden" name="score" value="5"></div>
                                    </div>
                                </div>
                                        @if ($errors->has('score'))
                                            <span class="invalid-feedback-star" role="alert">
                                        <strong>{{ $errors->first('score') }}</strong>
                                    </span>
                                        @endif
                                <div class="form-group">
                                    <span class="text-danger field-validation-valid" data-valmsg-for="Score" data-valmsg-replace="true"></span>
                                </div>
                                <div class="form-group">
                                    <label class="small text-secondary" for="Title">عنوان</label>
                                    <input class="form-control" placeholder="عنوان / موضوع" type="text" data-val="true" data-val-required="عنوان ضروری است" id="Title" name="title" value="@if(@$comment->title!=""){{$comment->title}}@else{{old('title')}}@endif">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                    <span class="text-danger field-validation-valid" data-valmsg-for="Title" data-valmsg-replace="true"></span>
                                </div>

                                <div class="form-group">
                                    <label class="small text-secondary" for="Comment">متن نظر</label>
                                    <textarea class="form-control" rows="5" placeholder="متن نظر" data-val="true" data-val-required="متن نظر ضروری است" id="Comment" name="comment">@if(@$comment->content!="")<?=$comment->content?>@else{{old('comment')}}@endif</textarea>
                                    @if ($errors->has('comment'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                    @endif
                                    <span class="text-danger field-validation-valid" data-valmsg-for="Comment" data-valmsg-replace="true"></span>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-gradient-primary btn-block" type="submit"><i class="ico ico-exit"></i>ثبت نظر <span id="msgbox"></span></button>
                                    <a href="/product/{{$product->slug}}" class="btn btn-block btn-flat-dark"><i class="ico ico-chevron-up ico-rotate-90"></i>بازگشت به صفحه قبل</a>
                                </div>
                        </div>

                    </div>
                    <!--product info & form end-->

                </div>

            </div>
        </div>
    </div>
@endsection
