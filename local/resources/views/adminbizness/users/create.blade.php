@extends('adminbizness.layout.master')

@section('style_link')
@endsection

@section('style')
    <style xmlns="">
        .waitMe_container .waitMe {
            border-radius: unset !important;
        }

        .card {
            box-shadow: none;
        }

        .clearfix > div {
            float: right;
        }

        .nav-tabs > li {
            float: right;
        }
        tr td{
            text-align: center;
        }

        .profile-footer li {
            width: 100%;
            float: right;
        }

        .profile-footer li > span {
            float: right;
            margin-left: 5px;
        }

        .form-group > label {
            float: right;
        }

        [type="radio"]:not(:checked), [type="radio"]:checked {
            left: 0;
        }

        .profile-card .profile-body .content-area p:last-child {
            color: #61c579;
            border: 1px dashed #61c579;
            margin: 0 16px;
            padding: 6px;
            border-radius: 10px;
        }

        .invalid-feedback strong {
            COLOR: RED;
            FONT-SIZE: 11PX;
        }

        .waitMe_container .waitMe {
            border-radius: 100%;
        }

        .browse-select-general {
            width: 100px;
            text-align: center !important;
            border: dotted 2px #797979;
            padding: 19px 0 !important;
            cursor: pointer;
            margin: auto;
            border-radius: 5px;
            color: #afafaf;
            margin-right: 20px;
        }
        .hr-span{
            position: relative;
        }
        .hr-span span{
            position: absolute;
            top: -14px;
            right: 14px;
            border: 1px dashed #61c579;
            padding: 3px 9px;
            background: #fff;
            border-radius: 5px;
        }
    </style>
@endsection

@section('Admin_content')
    @if(session('user_chagne'))
        <div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            {{session('user_chagne')}}
        </div>
    @endif
    @if(session('user_chagne_danger'))
        <div class="alert bg-red alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            {{session('user_chagne_danger')}}
        </div>
    @endif
    @if(session('user_chagne_city'))
        <div class="alert bg-red alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            {{session('user_chagne_city')}}
        </div>
    @endif
    <div class="col-xs-12 head" style="margin-bottom: 20px;display: flex;justify-content: space-between">
        <div style="width: 100%">
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">person</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">افزودن کاربر جدید</b>
            </h2>
            <a href="{{route('user-s.index')}}" style="float: left" title="برگشت"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>
    </div>
    <form class="form-horizontal" method="POST" action="{{route('user-s.store')}}" enctype="multipart/form-data">
        @csrf
    <div class="row clearfix" style="direction: rtl">

        <div class="col-xs-12 col-sm-3">
            <div class="card profile-card">

                <div class="profile-header" style="background-color: #61c579;">&nbsp;</div>
                <div class="profile-body">
                    <div class="image-area">

                            <label class="wimgpf" for="image_profile" style="cursor: pointer">
                                <img id="imgpf" style="width: 135px;height: 135px;border: 2px solid #61c579;"
                                     src="{{asset('images/profile.jpg')}}" alt="عکس پروفایل"/>
                            </label>
                    </div>

                </div>
                <div class="profile-footer" style="direction: rtl;display: inline-block;">
                    <ul>

                        @can('users_status')
                            <li style="margin-bottom: 0">
                                <span style="margin-bottom: 10px">وضعیت کاربر : </span>
                                <div class="switch" align="center">
                                    <label><span style="float: left">غیر فعال</span><input id="active_user" checked name="active_user"
                                                                                           type="checkbox"><span
                                            class="lever switch-col-green"></span><span>فعال</span></label>
                                </div>
                            </li>
                        @endcan

                    </ul>
                    {{-- <a href="" target="_blank" class="btn btn-primary btn-lg waves-effect btn-block" style="background-color: #8b9ae2!important;">جنیالوژی کاربر</a>--}}
                </div>
            </div>


        </div>
        <div class="col-xs-12 col-sm-9">
            <div class="card">

                <div class="body">


                    <div>


                            <div class="form-group">
                                <label for="NameSurname" class="col-sm-3 control-label">نام*</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="NameSurname" name="name"
                                               placeholder="نام را وارد کنید"
                                               value="{{old('name')}}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="NameSurfamily" class="col-sm-3 control-label">نام
                                    خانوادگی*</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="NameSurfamily"
                                               name="family"
                                               placeholder="نام خانوادگی را وارد کنید"
                                               value="{{old('family')}}" required>
                                    </div>
                                    @if ($errors->has('family'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('family') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="mobile" class="col-sm-3 control-label">شماره موبایل*</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                               placeholder="شماره موبایل را وارد کنید"
                                               value="{{old('mobile')}}" required>
                                    </div>
                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('mobile') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label"> ایمیل*</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="ایمیل را وارد کنید" value="{{old('email')}}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="sex" class="col-sm-3 control-label">جنسیت</label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input name="sex" value="M" class="radio-col-green" type="radio"
                                           id="radio_1" @if(old('sex')=="M")checked @endif/>
                                    <label for="radio_1">آقا</label>
                                    <input name="sex" value="F" class="radio-col-green" type="radio"
                                           id="radio_2" @if(old('sex')=="F")checked @endif/>
                                    <label for="radio_2">خانم</label>
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">پسورد* </label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="password" class="form-control" id="password"
                                               name="password" placeholder="پسورد را وارد کنید"
                                               value="{{old('password')}}" >
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">تکرار پسورد* </label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input id="password-confirm" type="password" class="form-control" placeholder="تکرار پسورد را وارد کنید" name="password_confirmation" required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                 </span>
                                @endif
                            </div>
                        </div>




                            @can('users_edit_profile')
                                <input onchange="uploadimageprofile()" style="display: none" type="file"
                                       name="image_profile" id="image_profile">
                            @endcan




                            <div class="form-group ">
                                <div class="col-sm-12" style="margin-bottom: 0">
                                    @can('users_edit')
                                        <button type="submit" style="float:left;" class="btn btn-success">
                                            ذخیره تغییرات
                                        </button>
                                    @endcan

                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

  </form>

    @php
        Session::forget('user_chagne');
        Session::forget('user_chagne_danger');
        session::forget('tab_pass');
        session::forget('user_chagne_city');
        session::forget('tab_user_move');
    @endphp
@endsection

@section('script_link')
    <script src="{{asset(('js/frotel/ostan.js'))}}"></script>
    <script src="{{asset('js/frotel/city.js')}}"></script>
@endsection

@section('script')
    <script>
        $('#active_user').on('change', function () {

            var status = "INACTIVE";
            if ($(this).is(':checked')) {
                status = "ACTIVE";
            }
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Change_status_user')}}';
            var data = {_token: CSRF_TOKEN, status: status'};
            $.post(url, data, function (msg) {
                if (msg == "ACTIVE") {

                    $.notify({
                        // options
                        message: 'با موفقیت فعال شد'
                    }, {
                        // settings
                        type: 'success',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                } else {
                    $.notify({
                        // options
                        message: 'با موفقیت غیر فعال شد'
                    }, {
                        // settings
                        type: 'success',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                }
            });
        });


        $('#active_wallet_status').on('change', function () {

            var status = "INACTIVE";
            if ($(this).is(':checked')) {
                status = "ACTIVE";
            }
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Change_status_user_wallet')}}';
            var data = {_token: CSRF_TOKEN, status: status};
            $.post(url, data, function (msg) {
                if (msg == "ACTIVE") {

                    $.notify({
                        // options
                        message: 'با موفقیت فعال شد'
                    }, {
                        // settings
                        type: 'success',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                } else {
                    $.notify({
                        // options
                        message: 'با موفقیت غیر فعال شد'
                    }, {
                        // settings
                        type: 'success',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                }
            });
        });


    </script>


    <script>

        loadOstan('ostan');

        $("#ostan").change(function () {
            var i = $(this).find('option:selected').val();
            ldMenu(i, 'city');
            $('.selectpicker').selectpicker('refresh');
        });

        function set_state_name() {
            var ostan_name = $('#ostan option:selected').text();
            var city_name = $('#city option:selected').text();
            $('input[name=city]').val(city_name);
            $('input[name=ostan]').val(ostan_name);
        }

        $('#ostan option').each(function (index) {

            var value_ostan = $(this).val();
            var state = '{{old('ostan_id')}}';
            if (value_ostan == state) {
                $(this).attr('selected', 'selected');
                ldMenu(value_ostan, 'city');

            }


        });

        $('.city option').each(function (index) {
            var city = '{{old('city_id')}}';
            var city_value = $(this).val();
            if (city_value == city) {
                $(this).attr('selected', 'selected');
                $('.selectpicker').selectpicker('refresh');
            }
        });



    </script>



    <script>
        $('#insert-Heirs').click(function () {
            $('#Heirs').append(' <div class="" style="border: 1px dashed #ccc;padding: 3px 15px 3px 4px;margin-bottom: 10px;">\n' +
                '                                            <button type="button" class="delete-Heirs btn bg-blue-grey waves-effect" style="float:left;padding: 1px 5px;">حذف</button>\n' +
                '                                            <div class="form-group">\n' +
                '                                                <label for="NameSurname" class="col-sm-3 control-label">نام و نام خانوادگی</label>\n' +
                '                                                <div class="col-sm-9">\n' +
                '                                                    <div class="form-line">\n' +
                '                                                        <input type="text" class="form-control" id="NameSurname" name="frm[item_name][]" placeholder="نام و نام خانوادگی را وارد کنید" value="" required>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '\n' +
                '                                            <div class="form-group">\n' +
                '                                                <label for="NameSurname" class="col-sm-3 control-label">درصد انتقال</label>\n' +
                '                                                <div class="col-sm-9">\n' +
                '                                                    <div class="form-line">\n' +
                '                                                        <input type="number" class="form-control" max="100" id="NameSurname" name="frm[item_value][]" placeholder="درصد انتقال" value="" required>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>');
            $('.delete-Heirs').click(function () {
                $(this).parent().remove();
            });
        });

        $('.delete-Heirs').click(function () {
            $(this).parent().remove();
        });
    </script>


@endsection
