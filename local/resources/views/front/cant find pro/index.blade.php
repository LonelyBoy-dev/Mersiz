@extends('front.layout.master')

@section('style')
    <style>
        .h1.line-height-sm.font-weight-bold{
            font-size: 1.5rem;
        }
    </style>
@endsection
@section('content')
    <div class="container my-16">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="card">
                <div class="card-body">
                    <img src="/assets/img/noresult.png" width="200" alt="no result">
                    <h5 class="text-muted my-16">کالایی برای نمایش وجود ندارد</h5>
                    <a href="/" title="">بازگشت به صفحه اصلی</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
