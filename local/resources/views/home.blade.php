<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <title>خوش آمدید | سوپر مارکت قزوین مرسیز</title>
    <!--    font------------------------------------>
    <!--    main style------------------------------>
    <link href="{{asset('assets/css/fontawesome.css')}}"
          rel="stylesheet">
    <link href="{{asset('assets/css/style.min.css')}}"
          rel="stylesheet">
    <link rel="stylesheet" href="{{asset('home/main.css')}}">
</head>
<style>
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%!important;
        color: #dc3545!important;
    }
    .account-headline-title{
        font-family: IRANSans, iranyekan, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    .made-account > h2,.made-account > p{

        font-weight: 500;

        font-family: IRANSans, iranyekan, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    .dk-btn{
        font-family: IRANSans, iranyekan, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    .account-box-logo img{
        display: block;
    }
    .parent-btn a{
        width: 100%;
        font-family: IRANSans, iranyekan, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    .account-box-content {
        margin-bottom: 40px;
    }
</style>
<body>
<!--page-login-------------------------->
<div class="container-main">
    <div class="col-12">
        <div class="semi-modal-layout">
            <section class="page-account-box">
                <div class="col-lg-7 col-md-7 col-xs-12 mx-auto">
                    <div class="account-box">
                        <a href="/" class="account-box-logo"><img src="{{asset(setting()['logo'])}}" height="48" alt="{{setting()['title']}}"></a>
                        <div class="account-box-headline welcome-headline">
                            <span class="account-headline-title">به مرسیز خوش آمدید</span>
                        </div>
                        <div class="account-box-content">
                            <form class="form-account">
                                <div class="user-account-welcome">
                                    <i class="far fa-user-circle"></i>
                                </div>
                                <div class="made-account">
                                    <h2>حساب کاربری شما در مرسیز ساخته شد</h2>
                                    <p>اکنون می‌توانید به صفحه‌ای که در آن بودید بازگردید و یا با تکمیل اطلاعات حساب کاربری
                                        خود به کلیه امکانات و
                                        سرویس‌های مرسیز و سرویس‌های وابسته به آن دسترسی داشته باشید</p>
                                </div>
                                <div class="parent-btn lr-ds w-ds">
                                    <a href="/profile" type="submit" class="btn btn-gradient-primary mr-auto">  تکمیل حساب کاربری</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<!--page-login-------------------------->
<script src="{{asset('assets/js/fontawesome.js')}}"></script>
</body>

</html>
@php
session()->forget('registered');
session()->forget('register-new-user-setEmail');
@endphp
