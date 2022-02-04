@extends('front.layout.master')

@section('style')
        <style>
            .container div,.container span,.container p,.container h3,.container h1,.container h4,.container h5,.container h6,.container h2{
                font-family: 'Yekan', sans-serif!important;
            }

        </style>
@endsection

@section('content')
    <div class="container my-16">

        <div class="card">

            <!--card header-->
            <div class="card-header card-header-right-border">
                <div class="card-header_caption">
                    <div class="card-header_caption-title">
                        <div class="card-header_caption-text">شرایط حمل و نقل</div>
                    </div>
                </div>
            </div>
            <!--card header end-->
            <!--card body-->
            <div class="card-body">

                <?= $transferpolicy['content'] ?>

            </div>
            <!--card body end-->

        </div>

    </div>
@endsection

