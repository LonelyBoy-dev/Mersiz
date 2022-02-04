


<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title> برسی شماره موبایل | سوپر مارکت قزوین مرسیز</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link href="{{asset('assets/css/style.min.css')}}" rel="stylesheet" />

    <!--style must be included in all page end-->


    <style>
        #g-recaptcha-response {
            display: block !important;
            position: absolute;
            margin: -78px 0 0 0 !important;
            width: 302px !important;
            height: 76px !important;
            z-index: -999999;
            opacity: 0;
        }
        .invalid-feedback{
            display: block;
        }
    </style>
</head>

<body>


<main>
    <!--login layout wrap-->


    <div class="login-page d-flex flex-column justify-content-center">
        <!--panel-->
        <div class="container d-flex align-items-center justify-content-center my-auto">
            <div class="w-25-xxl w-30-xl w-33-lg">

                <!--logo-->
                <a href="/" class="text-center mb-16 d-block">
                    <img src="{{setting()['logo']}}" height="48" alt="{{setting()['title']}}ا">
                    <div class="my-8 text-caption">{{setting()['title']}}</div>
                </a>
                <!--logo end-->

                <div class="card">

                    <!--card header-->
                    <div class="card-header card-header-slim card-header-right-border">

                        <!--header caption-->
                        <div class="card-header_caption">
                            <div class="card-header_caption-title">
                                <div class="card-header_caption-text">کد تأیید</div>
                            </div>
                        </div>
                        <!--header caption end-->

                    </div>
                    <!--card header end-->
                    <!--card body-->
                    <div class="card-body">

                        <form action="{{route('MobileVerifiedt.verify_phone_number')}}" method="POST">
                            @csrf
                            <div class="my-16 text-caption text-center">لطفا برای تایید حساب خود کد ارسال شده به شماره همراه‌تان را وارد نمایید</div>

                            <div class="text-center mb-16">
                                <span class="bg-light font-weight-bold h5 py-12 px-36 rounded-lg">{{session('user-verify-phone-number')}}</span>
                            </div>
                            <input name="mobile" value="{{session('user-verify-phone-number')}}" type="hidden">
                            <div class="form-group d-flex justify-content-center mb-5" dir="ltr">
                                <input  autofocus tabindex="1" , maxlength="1" class="form-control form-control-lg input-digit w-10 d-inline-block mx-4" placeholder="*" type="text" data-val="true" data-val-regex=" " data-val-regex-pattern="^[0-9]{1}$" data-val-required=" " id="OtpCode1" name="OtpCode1" value="" />
                                <input tabindex="2" , maxlength="1"  class="form-control form-control-lg input-digit w-10 d-inline-block mx-4" placeholder="*" type="text" data-val="true" data-val-regex=" " data-val-regex-pattern="^[0-9]{1}$" data-val-required=" " id="OtpCode2" name="OtpCode2" value="" />
                                <input tabindex="3" , maxlength="1" class="form-control form-control-lg input-digit w-10 d-inline-block mx-4" placeholder="*" type="text" data-val="true" data-val-regex=" " data-val-regex-pattern="^[0-9]{1}$" data-val-required=" " id="OtpCode3" name="OtpCode3" value="" />
                                <input tabindex="4" , maxlength="1" class="form-control form-control-lg input-digit w-10 d-inline-block mx-4" placeholder="*" type="text" data-val="true" data-val-regex=" " data-val-regex-pattern="^[0-9]{1}$" data-val-required=" " id="OtpCode4" name="OtpCode4" value="" />
                                <input tabindex="5" , maxlength="1" class="form-control form-control-lg input-digit w-10 d-inline-block mx-4" placeholder="*" type="text" data-val="true" data-val-regex=" " data-val-regex-pattern="^[0-9]{1}$" data-val-required=" " id="OtpCode5" name="OtpCode5" value="" />
                            </div>
                            @if (session('verify-phone-number_alert'))
                                <span style="text-align: center;padding-top: 20px;" class="invalid-feedback" role="alert">
                                                              <strong>{{session('verify-phone-number_alert')}}</strong>
                                                          </span>
                            @endif

                            <div class="form-group d-flex align-items-center justify-content-around text-center">
                                <div id="countdown" class="font-weight-bold" data-countdown="1/11/2021 4:42:48 PM"></div>
                                <a id="reCode" class="btn btn-sm btn-flat-primary rounded-sm d-none " href="/account/login?mobile=09526666666">دریافت مجدد کد تأیید</a>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-75">برسی کد تائید</button>
                            </div>
                        </form>
                    </div>
                    <!--card body end-->

                    <div class="card-footer  d-flex align-items-center justify-content-around text-center">

                        <a class="btn btn-sm btn-flat-primary rounded-sm " href="/register">آیا می‌خواهید شماره همراه خود را تغییر دهید؟</a>


                    </div>

                </div>
            </div>
        </div>
        <!--panel end-->
        <!--footer wrap-->
        <div class="mt-auto border-top py-24">
            <div class="container">

                <ul class="nav justify-content-center mb-16">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="privacyterm">حریم خصوصی</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/faq">سوالات متداول</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/transferpolicy">شرایط حمل و نقل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/contact">تماس با ما</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="about">درباره </a>
                    </li>
                </ul>

                <div class="text-center text-caption font-weight-light mb-16">
                  <span class="text-caption">
                     کلیه حقوق مادی و معنوی این سایت محفوظ و متعلق به مرسیز است. 1399 ©
طراحی و توسعه با
<a href="https://plussweb.ir"> پلاس وب</a>
                </span>
                </div>


            </div>
        </div>
        <!--footer wrap end-->

    </div>
    <!--login layout wrap end-->

</main>





<script src="{{asset('assets/js/bundle.js')}}"></script>
<script>

    function line_number()
    {
        $('.invalid-feedback').remove();
        var line_number1=$('#OtpCode1').val();
        var line_number2=$('#OtpCode2').val();
        var line_number3=$('#OtpCode3').val();
        var line_number4=$('#OtpCode4').val();
        var line_number5=$('#OtpCode5').val();
        var empty=false;
        if (line_number1==""){
            empty=true
        }
        if (line_number2==""){
            empty=true
        }
        if (line_number3==""){
            empty=true
        }
        if (line_number4==""){
            empty=true
        }
        if (line_number5==""){
            empty=true
        }

        if (empty==false){
            var mobile=$('input[name=mobile]').val();
            var line_number=line_number1+line_number2+line_number3+line_number4+line_number5;
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('MobileVerifiedt.verify_phone_number_code')}}';
            var data = {_token: CSRF_TOKEN,mobile:mobile,line_number:line_number};
            $.post(url, data, function (msg) {
                if (msg=="isFalse"){
                    $('.alert').append('<span style="text-align: center;padding-top: 20px;" class="invalid-feedback" role="alert">\n' +
                        '                                        <strong>کد وارد شده صحیح نیست</strong>\n' +
                        '                                    </span>')
                }else if(msg=="isTrue"){
                    $('form').submit();
                }
            });
        }
    }
</script>

</body>


</html>
@php
    Session::forget('verify-phone-number_alert');
@endphp

{{--

























<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <title>register</title>
    <!--    font------------------------------------>
    <link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/materialdesignicons.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/materialdesignicons.css.map')}}">
    <!--    bootstrap------------------------------->
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.css')}}">
    <!--    owl.carousel---------------------------->
    <link rel="stylesheet" href="{{asset('front/css/owl.carousel.min.css')}}">
    <!--    responsive------------------------------>
    <link rel="stylesheet" href="{{asset('front/css/responsive.css')}}">
    <!--    main style------------------------------>
    <link rel="stylesheet" href="{{asset('front/css/main.css')}}">
</head>
<style>
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%!important;
        color: #dc3545!important;
    }
</style>
<body>
<!--page-login-------------------------->

<!--page-login-------------------------->
</body>
<!--jquery--------------------------------------->
<script src="{{asset('front/js/jquery-3.2.1.min.js')}}"></script>
<!--    bootstrap-------------------------------->
<script src="{{asset('front/js/bootstrap.js')}}"></script>
<!--    owl.carousel----------------------------->
<script src="{{asset('front/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('front/js/countdown.min.js')}}"></script>
<!--main----------------------------------------->
<script src="{{asset('front/js/main.js')}}"></script>
<script>

    function line_number()
    {
        $('.invalid-feedback').remove();
        var line_number1=$('#line_number1').val();
        var line_number2=$('#line_number2').val();
        var line_number3=$('#line_number3').val();
        var line_number4=$('#line_number4').val();
        var line_number5=$('#line_number5').val();
        var empty=false;
        if (line_number1==""){
            empty=true
        }
        if (line_number2==""){
            empty=true
        }
        if (line_number3==""){
            empty=true
        }
        if (line_number4==""){
            empty=true
        }
        if (line_number5==""){
            empty=true
        }

        if (empty==false){
            var mobile=$('input[name=mobile]').val();
            var line_number=line_number1+line_number2+line_number3+line_number4+line_number5;
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('MobileVerifiedt.verify_phone_number_code')}}';
            var data = {_token: CSRF_TOKEN,mobile:mobile,line_number:line_number};
            $.post(url, data, function (msg) {
                if (msg=="isFalse"){
                    $('.alert').append('<span style="text-align: center;padding-top: 20px;" class="invalid-feedback" role="alert">\n' +
                        '                                        <strong>کد وارد شده صحیح نیست</strong>\n' +
                        '                                    </span>')
                }else if(msg=="isTrue"){
                    $('form').submit();
                }
            });
        }
    }
</script>
</html>
@php
    Session::forget('verify-phone-number_alert');
@endphp
--}}
