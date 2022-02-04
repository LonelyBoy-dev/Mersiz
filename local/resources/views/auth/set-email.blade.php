


<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title>رمز عبور | سوپر مارکت قزوین مرسیز</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link href="{{asset('assets/css/fontawesome.css')}}"
          rel="stylesheet">
    <link href="{{asset('assets/css/style.min.css')}}"
          rel="stylesheet">

    <!--style must be included in all page end-->



    <!-- End Alexa Certify Javascript -->
    <style>
        ::-webKit-input-placeholder { /* WebKit browsers */
            direction: rtl;
        }
        .form-mobile ::-webKit-input-placeholder { /* WebKit browsers */
            direction: rtl;
        }
        input{
            padding-right: 10px!important;
        }
        .custom-control-label{
            cursor: pointer;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            color: #dc3545;
            font-size: 12px;
            font-weight: 100;
        }
    </style>
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
    </style>
</head>

<body>



<main>
    <!--login layout wrap-->
    <div id="divEmp">
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
                                    <div class="card-header_caption-text">ادامه ثبت نام</div>
                                </div>
                            </div>
                            <!--header caption end-->

                        </div>
                        <!--card header end-->
                        <!--card body-->
                        <div class="card-body">
                            <div class="my-16 text-caption text-center">شماره موبایل شما تائید شد! برای تکمیل شدن حساب کاربری رمز عبور خود را وارد کنید.</div>


                            <form method="POST" class="form-account" action="{{route('register-new-user-set-email.store')}}">
                                @csrf

                                <div class="form-group  form-mobile">
                                    <label class="small text-secondary" for="Mobile">پسورد</label>
                                    <div class="form-icon">
                                        <input type="password" class="form-control" dir="ltr" placeholder="رمز عبور خود را وارد نمایید" data-val="true"   name="password" required autocomplete="current-password"/>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <span class="text-danger d-block text-center mt-8 field-validation-valid" data-valmsg-for="Mobile" data-valmsg-replace="true"></span>


                                </div>

                                <div class="form-group form-mobile text-center" style="margin-top: 40px">
                                    <input type="submit" id="btnLogin1" class="btn btn-primary w-100" value="ثبت نام " />
                                </div>

                        </div>
                        <!--card body end-->

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
    </div>


    <!--login layout wrap end-->

</main>





<script src="{{asset('assets/js/bundle.js')}}"></script>



</body>

</html>

