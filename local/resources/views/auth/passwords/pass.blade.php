

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('plugins/node-waves/waves.css')}}" rel="stylesheet"/>

    <!-- Animation Css -->
    <link href="{{asset('plugins/animate-css/animate.css')}}" rel="stylesheet"/>

    <!-- Custom Css -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-rtl.css')}}" rel="stylesheet">
</head>
<style>
    body,a{
        font-family: Vazir;
    }
    .input-group-addon{
        float: right;
    }
    .form-line{
        float: right;
        width: 97%!important;
        margin-right: 5px;
    }
    .form-line input{
        text-align: right;
        padding-right: 7px !important;
    }
    @media (max-width: 767px){
        .login-box{
            padding: 0 35px;
        }
        .login-page{
            background-size: 146% 185%;
            background-position: -79px -60px;
        }
    }
    .card {
        box-shadow: 0 0 27px 0px #000;
        background: #fff;
        margin-top: 50px;
    }
    .login-page{
        background: url({{asset('images/background/login.svg')}});
        background-size: cover;
    }

    .bg-pink {
        background-color: #064c56bf!important;
    }

    .forget{
        text-align: center;
    }
    .forget div{
        float: right;
        width: 100%;
    }
    .invalid-feedback{
        color: red;
        width: 100%;
        display: block;
        text-align: center;
    }
</style>
<?php
if(!empty(session('user_info_register'))){
    $user_info=session('user_info_register');
}else{
    $user_info='';
}

?>
<body class="login-page">
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">{{ __('فراموشی پسورد') }}<b></b></a>
    </div>
    <div class="card">
        @if(session('Access') and session('Access')=='NOT')
            <div style="text-align: right;direction: rtl" class="alert bg-red alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                شما مجوز دسترسی به پنل را ندارید
            </div>
        @endif
        <div class="body">
            <form id="sign_in" action="{{ route('reset_password') }}" method="POST">
                @csrf
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                    <div class="form-line">
                        <input required type="password" class="form-control" name="password" minlength="6" placeholder="پسورد جدید را وارد کنید"
                               autofocus>
                        <span class="error1">

                        </span>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <input type="hidden" class="form-control" name="mobile" value="{{session('verifire_code_password')}}" required>

                    </div>
                </div>
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password_confirmation"  minlength="6" placeholder="تکرار پسورد را وارد کنید" required>
                        <span class="error2">

                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        {{--                        <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">--}}
                        {{--                        <label for="rememberme">Remember Me</label>--}}
                    </div>
                    <div class="col-xs-12">
                        <button class="btn btn-block bg-pink waves-effect" id="submit">تغییر</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{asset('plugins/node-waves/waves.js')}}"></script>

<!-- Validation Plugin Js -->
<script src="{{asset('plugins/jquery-validation/jquery.validate.js')}}"></script>

<!-- Custom Js -->
<script src="{{asset('js/admin.js')}}"></script>
<script src="{{asset('js/pages/examples/sign-in.js')}}"></script>
<script>
    $('#submit').click(function () {
        $('.error1').empty();
        $('.error2').empty();

        var password=$('input[name=password]').val();
        var password_confirmation=$('input[name=password_confirmation]').val();
        var ok=1;


        if(password==""){
            ok=0;
            $('.error1').append('<span class="invalid-feedback" role="alert"><strong>پسورد جدید را وارد کنید</strong></span>')
        }else{
            if(password.length<6){
                ok=0;
                $('.error1').append('<span class="invalid-feedback" role="alert"><strong>حداقل 6 کاراکتر</strong></span>')
            }
        }

        if(password_confirmation==""){
            ok=0;
            $('.error2').append('<span class="invalid-feedback" role="alert"><strong>تکرار پسورد  را وارد کنید</strong></span>')
        }else{
            if(password_confirmation.length<6){
                ok=0;
                $('.error2').append('<span class="invalid-feedback" role="alert"><strong>حداقل 6 کاراکتر</strong></span>')
            }else{
                if(password!=password_confirmation){
                    ok=0;
                    $('.error2').append('<span class="invalid-feedback" role="alert"><strong>تکرار پسورد و پسورد باهم همخوانی ندارد</strong></span>')
                }
            }
        }


        if(ok==0){
            return false;
        }else{
            $('#sign_in').submit();
        }

    })
</script>
</body>

</html>
