

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>برسی کد | سوپر مارکت قزوین مرسیز</title>
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
    .form-line input{
        text-align: center;
    }
    .Again{
        width: 100%;display: inline-block;text-align: center;cursor: pointer;
    }
    .end-timer{
        float: right;
        width: 100%;
        text-align: center;
    }
    .again-loader{
        position: absolute;
        top: 0;
        width: 100%;
        background: #ffffff73;
        z-index: 10;
        height: 100%;
        left: 0;
        text-align: center;
        padding: 65px;
        display: none;
    }
</style>
<?php
$selectedTime = date('Y-m-d H:i:s');
$rem1 = strtotime("+1 minutes", strtotime($selectedTime));


$rem2 = date('Y-m-d H:i:s');

$rem2 = strtotime($rem2);

/************ NOW TIME **********/
if(!session()->get('timeNow')){
    session()->put('timeNow', $rem2);
}
if(session()->get('timeNow')){
    $rem3 = session()->get('timeNow');
}
/************ NOW TIME **********/

$rem = abs($rem1 - $rem2);

if($rem == 0){
    session()->forget('timeNow');
}
?>
<body class="login-page">
<div class="login-box">
 {{--   <h3 style="color: #0f9d58">code:{{session('code-taid')}}</h3>--}}

    <div class="logo">
        <a href="javascript:void(0);">{{ __('تائید شماره موبایل') }}<b></b></a>
    </div>
    <div class="card">
        @if(!empty(session('verifire_notok')))
            <div style="text-align: right;direction: rtl" class="alert bg-red alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                {{session('verifire_notok')}}
            </div>
        @endif
        <?php
            Session::forget('verifire_notok');

        ?>



        <div class="body" style="position: relative">
            <div class="again-loader">
                <img src="{{asset('images/again_loader.svg')}}">
            </div>
            <form id="sign_in" name="form" action="{{ route('verifire_code') }}" method="POST">
                @csrf

                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">verified_user</i>
                        </span>
                    <div class="form-line">
                        <input type="number" onkeyup="submitform()" onfocus="submitform()" class="form-control" name="code" placeholder="کد تائید را وارد کنید" required>
                        <input type="hidden" class="form-control" name="mobile" value="{{session('verifire_mobile')}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        {{--                        <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">--}}
                        {{--                        <label for="rememberme">Remember Me</label>--}}
                    </div>
                   {{-- <div class="col-xs-12">
                        <button class="btn btn-block bg-pink waves-effect" type="submit">تائید</button>

                    </div>--}}
{{--                    <span class="end-timer" id="countdown">60</span>--}}
                    <span class="again_code">
                        <a class="Again">ارسال مجدد کد تائید</a>
                    </span>

                </div>
                <div class="row m-t-15 m-b--20">
                    <div class="col-xs-12 forget ">
{{--                        <div>--}}
{{--                            <a href="{{route('register.index')}}">! ثبت نام</a>--}}
{{--                        </div>--}}

                    </div>
                    {{--                    <div class="col-xs-6 align-right">--}}
                    {{--                        <a href="forgot-password.html">Forgot Password?</a>--}}
                    {{--                    </div>--}}
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
</body>
<script>
    $('.Again').click(function () {
        $('.again-loader').fadeIn();
        var CSRF_TOKEN ='{{ csrf_token() }}';
        var url='{{route('Again_code')}}';
        var data={_token: CSRF_TOKEN};
        $.post(url,data,function (msg) {
            if(msg=='ok'){
                $('.again-loader').fadeOut();
            }
        })
    });

    function submitform() {
        var  code=$('input[name=code]').val();
        if (code.length==6){
            document.forms["form"].submit();
        }
    }

</script>
{{--<script>

    ثانیه شمار

    var seconds = $('.end-timer').html();
    function secondPassed() {
        var minutes = Math.round((seconds - 30)/60);
        var remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }
        document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
        if (seconds == 0) {
            clearInterval(countdownTimer);

            let timerInterval
            Swal.fire({
                title: 'زمان شما به پایان رسید!',
                timer: 3000,
                onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                                b.textContent = Swal.getTimerLeft()
                            }

                        }
                    }, 100)
                },
                onClose: () => {

                    clearInterval(timerInterval);
                    $('.again_code').empty();
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })

        } else {
            seconds--;
        }
    }
    var countdownTimer = setInterval('secondPassed()', 1000);
</script>--}}
</html>
