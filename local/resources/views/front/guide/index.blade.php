@extends('front.layout.master')
@section('style')

@endsection
@section('content')
    <div class="container my-16">

        <div class="card">

            <!--card header-->
            <div class="card-header card-header-right-border">
                <div class="card-header_caption">
                    <div class="card-header_caption-title">
                        <div class="card-header_caption-text">راهنمای سایت</div>
                    </div>
                </div>
            </div>
            <!--card header end-->
            <!--card body-->
            <div class="card-body">
                <div class="text-justify">
                   <?= $guide->content ?>
                </div>
            </div>
            <!--card body end-->

        </div>

    </div>
@endsection
