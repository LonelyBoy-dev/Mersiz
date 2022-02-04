@extends('front.layout.master')

@section('style')
<style>
    #app {
        width: 100%;
        height: 400px;
    }
    .leaflet-popup.leaflet-zoom-animated{
        display: none!important;
    }
</style>
@endsection
@section('content')
    <link rel="stylesheet" href="{{asset('map/css/mapp.min.css')}}">
    <link rel="stylesheet" href="{{asset('map/css/fa/style.css')}}" data-locale="true">
    <div class="container my-16">
        <div class="row">
            <div class="col-lg-6">

                <!--contact info-->
                <div class="card mb-16">

                    <!--card header-->
                    <div class="card-header card-header-right-border">
                        <div class="card-header_caption">
                            <div class="card-header_caption-title">
                                <div class="card-header_caption-text">اطلاعات تماس</div>
                            </div>
                        </div>
                    </div>
                    <!--card header end-->
                    <!--card body-->
                    <div class="card-body">

                        <ul class="list-unstyled m-0">
                            <li class="my-4">
                                <i class="ico ico-phone ico-flip-horizontal filter-secondary"></i>
                                <span class="font-weight-light">تلفن تماس:</span>
                                <span dir="ltr"><a class="text-dark" href="tel:{{setting()['mobile']}}">{{setting()['mobile']}}</a></span>
                            </li>
                            <li class="my-4">
                                <i class="ico ico-location-pin filter-secondary"></i>
                                <span class="font-weight-light">آدرس:</span>
                                <span>{{setting()['address']}}</span>
                            </li>
                            <li class="my-4">
                                <i class="ico ico-email  filter-secondary"></i>
                                <span class="font-weight-light">ایمیل:</span>
                                <span dir="ltr"><a class="text-dark" href="">{{setting()['email']}}</a></span>
                            </li>
                        </ul>

                    </div>
                    <!--card body end-->

                </div>
                <div class="card mb-16">

                    <!--card header-->
                    <div class="card-header card-header-right-border">
                        <div class="card-header_caption">
                            <div class="card-header_caption-title">
                                <div class="card-header_caption-text">آدرس از روی نقشه</div>
                            </div>
                        </div>
                    </div>
                    <!--card header end-->
                    <!--card body-->
                    <div class="card-body">
                        <div id="app"></div>
                    </div>
                    <!--card body end-->

                </div>
                <!--contact info-->

            </div>


            <div class="col-lg-6">

                <!--contact form-->
                <div class="card">

                    <!--card header-->
                    <div class="card-header card-header-right-border">
                        <div class="card-header_caption">
                            <div class="card-header_caption-title">
                                <div class="card-header_caption-text">با ما در ارتباط باشید</div>
                            </div>
                        </div>
                    </div>
                    <!--card header end-->
                    <!--card body-->
                    <div class="card-body">
                        <form class="form-row" method="post" enctype="multipart/form-data" action="{{route('contact_store')}}">
                                @csrf
                            <div class="form-group col-lg-12">
                                <label class="small text-secondary" for="CustomerName">نام و نام خانوادگی</label>
                                <div class="form-icon">
                                    <i class="ico ico-user"></i>
                                    <input type="text" class="form-control" placeholder="نام و نام خانوادگی خود را وارد نمایید" data-val="true" data-val-length="نام و نام خانوادگی نمی تواند بیشتر از 100 کاراکتر باشد" data-val-length-max="150" data-val-required="نام و نام خانوادگی ضروری است" id="name" maxlength="150" name="name" value="">
                                </div>
                                <span class="text-danger field-validation-valid" data-valmsg-for="name" data-valmsg-replace="true"></span>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="small text-secondary" for="Email">ایمیل</label>
                                <div class="form-icon">
                                    <i class="ico ico-email"></i>
                                    <input type="text" class="form-control" placeholder="example@address.com" data-val="true" data-val-email="فرمت ایمیل نامعتبر است" data-val-required="ایمیل ضروری است" id="Email" name="email" value="">
                                </div>
                                <span class="text-danger field-validation-valid" data-valmsg-for="email" data-valmsg-replace="true"></span>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="small text-secondary" for="Mobile">تلفن همراه</label>
                                <div class="form-icon">
                                    <i class="ico ico-mobile"></i>
                                    <input type="text" class="form-control" placeholder="09xxxxxxxxx" data-val="true" data-val-regex="شماره موبایل باید با 09 شروع شود و کمتر از 11 رقم نباشد" data-val-regex-pattern="^[0]{1}[9]{1}[0-9]{9}" data-val-required="تلفن همراه ضروری است" id="Mobile" name="mobile" value="">
                                </div>
                                <span class="text-danger field-validation-valid" data-valmsg-for="mobile" data-valmsg-replace="true"></span>
                            </div>

                            <div class="form-group col-lg-12">
                                <label class="small text-secondary" for="Message">پیام</label>
                                <textarea class="form-control" rows="5" placeholder="" data-val="true" data-val-length="پیام نمی تواند بیشتر از 150 کاراکتر باشد" data-val-length-max="150" data-val-required="پیام ضروری است" id="Message" maxlength="150" name="message">
</textarea>
                                <span class="text-danger field-validation-valid" data-valmsg-for="message" data-valmsg-replace="true"></span>
                            </div>

                            <div class="d-flex align-items-center col-12">

                                <span id="fileName" class="text-muted mr-8" style="display: none"></span>
                                <button type="submit" class="btn btn-gradient-primary mr-auto">تایید و ارسال</button>

                            </div>

                        </form>
                    </div>
                    <!--card body end-->

                </div>
                <!--contact form-->

            </div>




        </div>
    </div>
    @php
        $mapss=explode('(',setting()['map']);
        $maps=str_replace(array( '(', ')' ), '', $mapss[1]);
        $map=explode(',',$maps);
        if (setting()['map']==""){
            $lat="35.73249";
            $lng="51.42268";
        }else{
            $lat=$map[0];
            $lng=$map[1];
        }
        @endphp
@endsection
@section('script_link')
<!--    <script type="text/javascript" src="{{asset('map/js/jquery-3.2.1.min.js')}}"></script>-->
    <script type="text/javascript" src="{{asset('map/js/mapp.env.js')}}"></script>
    <script type="text/javascript" src="{{asset('map/js/mapp.min.js')}}"></script>
@endsection
@section('script')
    @if(session('save_comment'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('پیام شما با موفقیت ارسال شد!');
        </script>
    @endif
    <script>

        $(document).ready(function() {
            var app = new Mapp({
                element: '#app',
                presets: {
                    latlng: {
                        lat: {{$lat}},
                        lng: {{$lng}},
                    },
                    zoom: 10
                },
                apiKey: '{{setting()['Api_map']}}'
            });
            app.addLayers();
            app.markReverseGeocode({
                state: {
                    latlng: {
                        lat: 35.73249,
                        lng: 51.42268,
                    },
                    zoom: 16,
                },
            });
        });
    </script>
@endsection
@php
    Session::forget('save_comment');
@endphp
