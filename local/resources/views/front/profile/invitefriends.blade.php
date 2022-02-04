@extends('front.profile.layout')
@section('style')
    <style>
        #Marketing-link{
            cursor: pointer;
            border: unset;
            height: 100%;
            padding: 0;
            text-align: center;
        }
        .copy-shod{
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            background: #109f7ad9;
            height: 100%;
            line-height: 46px;
            color: #fff;
            display: none;
        }
    </style>
@endsection
@section('content_panel')
    <div class="card mb-16">

        <!--card header-->
        <div class="card-header card-header-right-border">
            <div class="card-header_caption">
                <div class="card-header_caption-title">
                    <div class="card-header_caption-text">لینک بازاریابی</div>
                </div>
            </div>
        </div>
        <!--card header end-->
        <!--card body-->
        <div class="card-body">
            <div class="row align-items-center">

                <!--content-->
                <div class="col-lg-7">

                    <div class="text-center">

                        <div class="h4 font-weight-bold">لینک بازاریابی خود را به دیگران پیشنهاد دهید و با هر بار خرید، {{setting()['Marketing_darsad']}} درصد از خرید او هدید بگیرید</div>
                        <div class="d-flex" style="margin-top: 10px">
                            <div class="input-group w-100-lg mx-auto">
                                <div type="text" class="form-control">لینک بازاریابی من</div>
                                <div type="text" class="form-control" style="padding: 0">
                                                <input id="Marketing-link" class="form-control" value="{{URL::to('/').'?Link='.$user->Marketing_link}}">
                                                <span class="copy-shod">کپی شد</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-16 text-caption text-center"></div>

                </div>
                <!--content end-->
                <!--image-->
                <div class="col-lg-5 justify-content-center">

                    <div class="text-center py-48">
                        <i class="ico ico-color_gift ico-256px ico-fw-0"></i>
                    </div>

                </div>
                <!--image  end-->

            </div>

        </div>
        <!--card body end-->
    </div>
@endsection
@section('script')
    <script>
        function copy() {
            var copyText = document.querySelector("#Marketing-link");
            copyText.select();
            document.execCommand("Copy");
            $('.copy-shod').show();
            setTimeout(function(){
                $('.copy-shod').fadeOut();
            }, 1000);

        }
        document.querySelector("#Marketing-link").addEventListener("click", copy);
    </script>
@endsection
