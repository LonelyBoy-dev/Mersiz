@extends('adminbizness.layout.master')

@section('style_link')

@endsection

@section('style')

@endsection

@section('content')
    <link href="{{asset('plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <style>
        .col-lg-6,.col-lg-4{
            float: right;
        }

        .card {
            box-shadow: unset;
        }
        .card .header h2 {
            line-height: 2;
        }
    </style>
    <?php
    if(Auth()->user()->package == 1){
        $package = 5;
    }
    elseif(Auth()->user()->package == 2){
        $package = 25;
    }
    elseif(Auth()->user()->package == 3){
        $package = 50;
    }
    elseif(Auth()->user()->package == 4){
        $package = 100;
    }
    ?>
    @if($package != Auth()->user()->status_registercard)
        <div class="row">
            <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                @include('adminbizness.partial.error')
                <div class="alert bg-blue alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?php
                    if(Auth()->user()->package == 1){
                        echo 'شما مجاز به ثبت 5 کارت بانکی هستید.';
                    }
                    elseif(Auth()->user()->package == 2){
                        echo 'شما مجاز به ثبت 25 کارت بانکی هستید.';
                    }
                    elseif(Auth()->user()->package == 3){
                        echo 'شما مجاز به ثبت 50 کارت بانکی هستید.';
                    }
                    elseif(Auth()->user()->package == 4){
                        echo 'شما مجاز به ثبت 100 کارت بانکی هستید.';
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 10px">


            </div>
        </div>
        {!! Form::open(['method' => 'POST', 'action' => ['AdminB\AdminRegisterCardController@store']]) !!}
        <div class="row clearfix wform-card" style="direction: rtl;">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            اطلاعات کارت بانکی
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <?php
                                        $name = Auth::user()->name;$code = Auth::user()->national_code;
                                        ?>
                                        <input type="text" name="name" value="<?= $name ?>" class="form-control">
                                        <label class="form-label">نام و نام خانوادگی</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" name="mellicode" value="<?= $code ?>" class="form-control">
                                        <label class="form-label">کد ملی</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input onkeyup="getbank()" type="number" class="form-control" name="cardnumber">
                                        <label class="form-label">شماره کارت</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="bank" class="form-control">
                                        <label class="form-label">نام بانک</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {{--                                        {{ Form::select('state', ['' => 'انتخاب کنید',$ostan], null, ['class' => 'form-control show-tick']) }}--}}
                                        {{ Form::select('state', $ostan, null, ['class' => 'form-control show-tick', 'id'=>'state', 'onchange'=>'getcity()']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="city" name="city">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea type="text" name="address" class="form-control"></textarea>
                                        <label class="form-label">آدرس پستی</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-success waves-effect btn-block" type="submit">ثبت کارت</button>
                    </div>
                </div>
            </div>

        </div>
        {!! Form::close() !!}
    @else
        <div class="alert bg-blue alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            کاربر گرامی شما تعداد کارت های بانکی مجاز را ثبت نموده اید!
        </div>
    @endif

    <div class="row clearfix">



        @foreach($cards as $card)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card profile-card">
                    <div class="profile-header" style="background-color: #61c579;">&nbsp;</div>

                    <div class="profile-body">
                        <div class="image-area">
                            <label class="wimgpf" for="image_profile" style="cursor: pointer">
                                <img id="imgpf" src="<?php
                                switch ($card->bank) {
                                    case "بانک انصار":
                                        echo asset('images/ansar.jpg');
                                        break;
                                    case "بانک ملی ایران":
                                        echo asset('images/melli.jpg');
                                        break;
                                    case "بانک سپه":
                                        echo asset('images/sepah.jpg');
                                        break;
                                    case "بانک توسعه صادرات":
                                        echo asset('images/tosesaderat.jpg');
                                        break;
                                    case "بانک صنعت و معدن":
                                        echo asset('images/sanat.jpg');
                                        break;
                                    case "بانک کشاورزی":
                                        echo asset('images/keshavarzi.jpg');
                                        break;
                                    case "بانک مسکن":
                                        echo asset('images/maskan.jpg');
                                        break;
                                    case "پست بانک ایران":
                                        echo asset('images/postbank.jpg');
                                        break;
                                    case "بانک توسعه تعاون":
                                        echo asset('images/banklogo (18).jpg');
                                        break;
                                    case "بانک اقتصاد نوین":
                                        echo asset('images/eghtesad.jpg');
                                        break;
                                    case "بانک پارسیان":
                                        echo asset('images/parsian.jpg');
                                        break;
                                    case "بانک پاسارگاد":
                                        echo asset('images/pasargad.jpg');
                                        break;
                                    case "بانک کارآفرین":
                                        echo asset('images/karafarin.jpg');
                                        break;
                                    case "بانک سامان":
                                        echo asset('images/saman.jpg');
                                        break;
                                    case "بانک سینا":
                                        echo asset('images/sina.jpg');
                                        break;
                                    case "بانک سرمایه":
                                        echo asset('images/sarmaye.jpg');
                                        break;
//                                    case "بانک تات":
//                                        echo asset('images/sanat.jpg');
//                                        break;
                                    case "بانک شهر":
                                        echo asset('images/shahr.jpg');
                                        break;
                                    case "بانک دی":
                                        echo asset('images/day.jpg');
                                        break;
                                    case "بانک صادرات":
                                        echo asset('images/saderat.jpg');
                                        break;
                                    case "بانک ملت":
                                        echo asset('images/melat.jpg');
                                        break;
                                    case "بانک تجارت":
                                        echo asset('images/tejarat.jpg');
                                        break;
                                    case "بانک رفاه":
                                        echo asset('images/refah.jpg');
                                        break;
                                    case "بانک مهر اقتصاد":
                                        echo asset('images/Mehr-eghtesad.jpg');
                                        break;
                                }
                                ?>" alt="" style="width: 135px;height: 135px;border: 2px solid #61c579;">
                            </label>
                        </div>
                        <div class="content-area">
                            <h3 style="font-size: 20px;font-weight: unset">{{$card->bank}}</h3>
                            <p></p>
                            <p>شماره کارت :  {{$card->cardnumber}}</p>
                        </div>
                    </div>
                    <div class="profile-footer" style="direction: rtl;">
                        <ul>
                            <li style="display: flex;justify-content: space-between">
                                <span>نام و نام خانوادگی : </span>
                                <span>{{$card->name}}</span>
                            </li>
                            <li style="display: flex;justify-content: space-between">
                                <span>کد ملی : </span>
                                <span>{{$card->mellicode}}</span>
                            </li>
                            <li style="display: flex;justify-content: space-between">
                                <span> استان : </span>
                                <span>{{$card->state}}</span>
                            </li>
                            <li style="display: flex;justify-content: space-between;margin-bottom: unset">
                                <span>شهر : </span>
                                <span>{{$card->city}}</span>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection

@section('script_link')
@endsection

@section('script')
    <script>
        function getbank() {
            var cardnumber = $("input[name=cardnumber]").val();
            if(cardnumber.length == 6){
                switch(cardnumber) {
                    case '603799':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک ملی ایران');
                        break;
                    case '585983':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک تجارت');
                        break;
                    case '589210':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک سپه');
                        break;
                    case '627648':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک توسعه صادرات');
                        break;
                    case '627961':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک صنعت و معدن');
                        break;
                    case '603770':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک کشاورزی');
                        break;
                    case '628023':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک مسکن');
                        break;
                    case '627760':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('پست بانک ایران');
                        break;
                    case '502908':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک توسعه تعاون');
                        break;
                    case '627412':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک اقتصاد نوین');
                        break;
                    case '622106':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک پارسیان');
                        break;
                    case '502229':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک پاسارگاد');
                        break;
                    case '627488':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک کارآفرین');
                        break;
                    case '621986':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک سامان');
                        break;
                    case '639346':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک سینا');
                        break;
                    case '639607':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک سرمایه');
                        break;
                    case '636214':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک تات');
                        break;
                    case '502806':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک شهر');
                        break;
                    case '502938':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک دی');
                        break;
                    case '603769':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک صادرات');
                        break;
                    case '610433':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک ملت');
                        break;
                    case '627353':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک تجارت');
                        break;
                    case '589463':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک رفاه');
                        break;
                    case '627381':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک انصار');
                        break;
                    case '639370':
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک مهر اقتصاد');
                        break;
                    default:
                        $("input[name=bank]").parent().addClass('focused');
                        $("input[name=bank]").val('بانک مورد نظر یافت نشد!');
                }
            }else if(cardnumber.length < 6){
                $("input[name=bank]").parent().removeClass('focused');
                $("input[name=bank]").val('');
            }
        }

        // get state and set select city
        function getcity() {
            $("select[name=city]").parent().find('.filter-option').html('');
            $("select[name=city]").parent().find('.inner').html('');
            $("#city").html('');
            var state = $("select[name=state]").val();
            $.ajax({
                url: '/getstate',
                type: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    state: state
                },
                success: function (data) {
                    var i = 0;
                    $.each(data, function (key, value) {
                        if(i == 0){
                            $("select[name=city]").parent().find('.filter-option').html(value);
                            var isselect = 'selected';
                        }else{
                            var isselect = '';
                        }
                        var option = new Option(key, value);
                        $("select[name=city]").parent().find('.inner').append('<li data-original-index="'+i+'" class="'+ isselect +'"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">'+value+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>');
                        $(option).html(value);
                        $("#city").append(option);
                        i++;
                    });
                },
                error: function (xhr, b, c) {
                    console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                }
            });
        }
        // get state and set select city

    </script>
@endsection
