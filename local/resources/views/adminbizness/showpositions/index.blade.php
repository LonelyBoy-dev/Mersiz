@extends('adminbizness.layout.master')


@section('content')
    <style>
        .card {
            box-shadow: unset;
        }
        .info-box-2 {
            box-shadow: unset;
        }
        .btn:not(.btn-link):not(.btn-circle) {
            box-shadow: unset;
        }
        .btn-success, .btn-success:hover, .btn-success:active, .btn-success:focus {
            background-color: #77da8f !important;
        }
    </style>

    <div class="row">
        <?php
        $submultiple=0;
        $refral_codes = App\Tree::where('reference_code', Auth::user()->reference_code)->where('right_total_sell', '>=', 2000000)->where('left_total_sell', '>=', 2000000)->first();
        if (!empty($refral_codes)){
            $right_pricr = $refral_codes->right_total_sell;
            $left_price = $refral_codes->left_total_sell;


            if ($right_pricr < $left_price) {
                $submultiple = (int)($right_pricr / 2000000);
            } elseif ($right_pricr > $left_price) {
                $submultiple = (int)($left_price / 2000000);
            }else{
                $submultiple = (int)($right_pricr / 2000000);
            }

        }
        ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="float: right">
            @if(Auth()->id() == 1)
                <div class="form-group form-float">
                    <div class="form-line">
                        <input id="scode" onkeyup="getuser()" style="padding: 6px 12px 6px 0px;" type="text" class="form-control" placeholder="جستجو">
                    </div>
                </div>
                <div id="w-code" class="row">

                </div>
            @endif

            <div class="card">
                <div onclick="getlar(this)" class="header" style="background: #77da8f;cursor: pointer">
                    <h2 id="uplinecode" style="color: #ffffff;border: 1px solid #fff;border-radius: 6px;padding: 6px;display: inline-block">
                        <i class="material-icons">fiber_pin</i> کد رأس : <span class="vrl">{{Auth::user()->reference_code}}</span>
                    </h2>

                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a onclick="getlar(this)" id="lftd" data-code="{{$left_hand}}" class="btn btn-success btn-flat btn-block lnb vrl" style="background-color: unset !important; color: #00bcd4 !important; border: 1px dashed #00bcd4 !important;">{{ !empty($left_hand) ? $left_hand : 'خالی'}}</a>
                            <br>
                            <div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-col-cyan">
                                    <div class="panel-heading" role="tab" id="headingTwo_19">
                                        <h4 class="panel-title">
                                            <a class="" role="button" data-toggle="collapse" data-parent="#accordion_19" href="#collapseTwo_19" aria-expanded="true" aria-controls="collapseTwo_19">
                                                <i class="material-icons">people_outline</i>
                                                L
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo_19" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo_19">
                                        <div data-code="{{$left_hand}}" class="panel-body">
                                            <div class="row">
                                                <div id="lft" class="col-lg-12">
                                                    <ul>
                                                        <li>نام : {{$name_left}}</li>
                                                        <li>استان : {{$state_left}}</li>
                                                        <li>شهر : {{$city_left}}</li>
                                                        <li>شماره تماس : {{$mobile_left}}</li>
                                                        <li>تعداد نفرات : {{$leftcount}}</li>
                                                        <li>تعداد تعادل : {{$submultiple}}</li>
                                                        <li>ذخیره : {{$leftsave}}</li>
                                                        <li>پورسانت مستقیم : {{$direct_selling}}</li>
                                                        {{-- <li>پورسانت فروش : {{$leftsave}}</li>--}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a onclick="getlar(this)" id="rgtd" data-code="{{$right_hand}}" class="btn btn-success btn-flat btn-block lnb vrl" style="background-color: unset !important; color: #00bcd4 !important; border: 1px dashed #00bcd4 !important;">{{ !empty($right_hand) ? $right_hand : 'خالی'}}</a>
                            <br>
                            <div class="panel-group" id="accordion_18" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-col-cyan">
                                    <div class="panel-heading" role="tab" id="headingTwo_18">
                                        <h4 class="panel-title">
                                            <a class="" role="button" data-toggle="collapse" data-parent="#accordion_18" href="#collapseTwo_18" aria-expanded="true" aria-controls="collapseTwo_18">
                                                <i class="material-icons">people_outline</i>
                                                R
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo_18" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo_18">
                                        <div data-code="{{$right_hand}}" class="panel-body">
                                            <div class="row">
                                                <div id="rgt" class="col-lg-12">
                                                    <ul>
                                                        <li>نام : {{$name_right}}</li>
                                                        <li>استان : {{$state_right}}</li>
                                                        <li>شهر : {{$city_right}}</li>
                                                        <li>شماره تماس : {{$mobile_right}}</li>
                                                        <li>تعداد نفرات : {{$rightcount}}</li>
                                                        <li>تعداد تعادل : {{$submultiple}}</li>
                                                        <li>ذخیره : {{$rightsave}}</li>
                                                        <li>پورسانت مستقیم : {{$direct_selling}}</li>
                                                        {{--  <li>پورسانت فروش : {{$rightsave}}</li>--}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function getlar(item) {
            var code = $(item).parent().find('.vrl').attr('data-code');
            $.ajax({
                type: "post",
                url: "/getlar",
                data: {
                    code: code,
                    _token: '{{csrf_token()}}',
                },
                dataType: 'json',
                success: function (data) {

                    $('#lft').html(
                        "<ul>" +
                        "<li> نام :  "+ data.name_left +"  </li>" +
                        "<li> استان :  "+ data.state_left +"  </li>" +
                        "<li> شهر :  "+ data.city_left +"  </li>" +
                        "<li> شماره تماس :  "+ data.mobile_left +"  </li>" +
                        "<li> تعداد نفرات :  "+ data.leftcount +"  نفر</li>" +
                        "<li> تعداد تعادل :  "+ data.balance +"  </li>" +
                        "<li> ذخیره : "+ data.leftsave +" تومان</li>" +
                        "<li> پورسانت مستقیم : "+ data.direct_selling_left +" تومان</li>" +
                        /*  "<li> پورسانت : "+ data.leftsave +" تومان</li>" +*/
                        "</ul>"
                    );

                    $('#rgt').html(
                        "<ul>" +
                        "<li> نام :  "+ data.name_right +"  </li>" +
                        "<li> استان :  "+ data.state_right +"  </li>" +
                        "<li> شهر :  "+ data.city_right +"  </li>" +
                        "<li> شماره تماس :  "+ data.mobile_right +"  </li>" +
                        "<li> تعداد نفرات :  "+ data.rightcount +"  نفر</li>" +
                        "<li> تعداد تعادل :  "+ data.balance +"  </li>" +
                        "<li> ذخیره : "+ data.rightsave +" تومان</li>" +
                        "<li> پورسانت مستقیم : "+ data.direct_selling_right +" تومان</li>" +
                        /* "<li> پورسانت : "+ data.rightsave +" تومان</li>" +*/
                        "</ul>"
                    );



                    $('#lftd').attr('data-code',data.vleft);
                    $('#rgtd').attr('data-code',data.vright);
                    $('#lftd').html(data.vleft);
                    $('#rgtd').html(data.vright);


                    $('#uplinecode').html('<i class="material-icons">fiber_pin</i> کد آپلاین : <span data-code="'+ data.reference +'" class="vrl">'+ code +'</span>');
                },
                error: function (err) {

                    if (err.status == 422) {
                    }
                }
            });
        }


        function getuser() {
            $('#w-code').html('');
            var code = $('#scode').val();
            $.ajax({
                type: "post",
                url: "/getusercode",
                data: {
                    code: code,
                    _token: '{{csrf_token()}}',
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data.code, function(i, order){
                        $('#w-code').append('<div class="col-lg-3" style="margin-bottom: 2px"><a onclick="getlar(this)" data-code="'+ order.reference_code +'" class="btn btn-success btn-flat btn-block vrl">'+ order.reference_code +'</a></div>');
                    });
                },
                error: function (err) {
                    if (err.status == 422) {
                    }
                }
            });
        }


    </script>
@endsection

