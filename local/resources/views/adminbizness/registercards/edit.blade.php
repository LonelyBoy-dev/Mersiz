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
    elseif(Auth()->user()->package == 3){
        $package = 25;
    }
    elseif(Auth()->user()->package == 5){
        $package = 50;
    }
    elseif(Auth()->user()->package == 8){
        $package = 100;
    }
    ?>
        {!! Form::model($registercard, ['method' => 'PATCH', 'action' => ['AdminB\AdminRegisterCardController@update', $registercard->id]]) !!}
        <div class="row clearfix wform-card" style="direction: rtl;">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ویرایش اطلاعات کارت بانکی
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                        <label class="form-label">نام و نام خانوادگی</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {{ Form::number('mellicode', null, ['class' => 'form-control']) }}
                                        <label class="form-label">کد ملی</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {{ Form::number('cardnumber', null, ['class' => 'form-control', 'onkeyup' => 'getbank()']) }}
                                        <label class="form-label">شماره کارت</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {{ Form::text('bank', null, ['class' => 'form-control']) }}
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
{{--                                        <select class="form-control show-tick" id="city" name="city">--}}
{{--                                        </select>--}}
                                        {{ Form::select('city', $city, null, ['class' => 'form-control show-tick', 'id'=>'city', 'onchange'=>'getcity()']) }}

                                    </div>
                                </div>
                            </div>


                        </div>
                        <button class="btn btn-success waves-effect btn-block" type="submit">بروزرسانی کارت</button>
                    </div>
                </div>
            </div>

        </div>
        {!! Form::close() !!}


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
