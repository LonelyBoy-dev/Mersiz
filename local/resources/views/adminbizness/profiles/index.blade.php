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
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">ویرایش کاربر</b>
            </h2>
            <a href="{{route('dashboard.index')}}" style="float: left" title="برگشت"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>
    </div>

    <div class="row clearfix" style="direction: rtl">

        <div class="col-xs-12 col-sm-3">
            <div class="card profile-card">

                <div class="profile-header" style="background-color: #61c579;">&nbsp;</div>
                <div class="profile-body">
                    <div class="image-area">
                        @if(@$user->avatar!="")
                            <label class="wimgpf" for="image_profile" style="cursor: pointer">
                                <img id="imgpf" src="{{asset($user->avatar)}}" alt="{{$user->name}}"
                                     style="width: 135px;height: 135px;border: 2px solid #61c579;"/>
                            </label>
                        @else
                            <label class="wimgpf" for="image_profile" style="cursor: pointer">
                                <img id="imgpf" style="width: 135px;height: 135px;border: 2px solid #61c579;"
                                     src="{{asset('images/profile.jpg')}}" alt="عکس پروفایل"/>
                            </label>
                        @endif
                    </div>
                    <div class="content-area">
                        <h3 style="font-size: 20px;font-weight: unset">{{$user->name.' '.$user->family}}</h3>

                    </div>

                </div>
                <div class="profile-footer" style="direction: rtl;display: inline-block;">
                    <ul>

                        <li>
                            <span>تاریخ ثبت نام :</span>
                            <span>{{Verta::instance($user->created_at)->format('%d %B %Y | H:i:s')}}</span>
                        </li>




                        @if($user->id!=1)

                            @can('users_edit_add_admin')
                                <li id="isadmin" align="center">
                                    <?php
                                    $role_user = App\Role_user::where('user_id', $user->id)->first();
                                    ?>


                                    @if(empty($role_user))
                                        <button type="button" onclick="isadmin(this,'admin')"
                                                style="color: #0f828e;background-color: #61c0c582 !important;border: 1px dashed #3d8890;"
                                                class="btn btn-success status_change_profile">افزودن به لیست مدیران
                                        </button>
                                    @else
                                        <button type="button" onclick="isadmin(this,'notadmin')"
                                                style="color: #bb4141;background-color: #c56f6182 !important;border: 1px dashed #903d3d;margin-right: 5px"
                                                class="btn btn-success status_change_profile">حذف از لیست مدیران
                                        </button>
                                        <a href="{{route('admins.edit',$user->id)}}"
                                           style="DISPLAY: block;margin-top: 10px;">مدیریت دسترسی ها</a>
                                    @endif

                                </li>
                            @endcan
                        @endif
                    </ul>
                    {{-- <a href="" target="_blank" class="btn btn-primary btn-lg waves-effect btn-block" style="background-color: #8b9ae2!important;">جنیالوژی کاربر</a>--}}
                </div>
            </div>


        </div>
        <div class="col-xs-12 col-sm-9">
            <div class="card">

                <div class="body">


                    <div>

                        <form class="form-horizontal" method="post" autocomplete="off"
                              action="{{route('profile.update',$user->id)}}" enctype="multipart/form-data">
                            @csrf
                            {{ @method_field('PATCH') }}
                            <div class="form-group">
                                <label for="NameSurname" class="col-sm-3 control-label">نام*</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="NameSurname" name="name"
                                               placeholder="نام را وارد کنید"
                                               value="@if(old('name')==""){{$user->name}}@else{{old('name')}} @endif" required>
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
                                               value="@if(old('family')==""){{$user->family}}@else{{old('family')}} @endif" required>
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
                                               value="@if(old('mobile')==""){{$user->mobile}}@else{{old('mobile')}} @endif" required>
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
                                               placeholder="ایمیل را وارد کنید" value="@if(old('email')==""){{$user->email}}@else{{old('email')}} @endif">
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
                                               id="radio_1" @if($user->sex=="M")checked @endif/>
                                        <label for="radio_1">آقا</label>
                                        <input name="sex" value="F" class="radio-col-green" type="radio"
                                               id="radio_2" @if($user->sex=="F")checked @endif/>
                                        <label for="radio_2">خانم</label>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-span">
                                <hr>
                                <span>در صورت تغییر، پسورد را وارد کنید</span>
                            </div>
                            <div class="form-group" style="margin-top: 30px">
                                <label for="password" class="col-sm-3 control-label">پسورد </label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="password" class="form-control" id="password"
                                               name="password" placeholder="در صورت تغییر، پسورد را وارد کنید"
                                               value="@if(old('password')!=""){{old('password')}} @endif" >
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">تکرار پسورد </label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input id="password-confirm" type="password" class="form-control" placeholder="تکرار پسورد را وارد کنید" name="password_confirmation" >
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

                                    @can('users_Confirmation')
                                        @if($user->profile_status=="Waiting")
                                            <button type="button"
                                                    onclick="profile_status('profile_status','Confirmation')"
                                                    style="float:right;color: #555;background-color: #61c57982 !important;border: 1px dashed #3d9051;"
                                                    class="btn btn-success status_change_profile">تائید
                                                اطلاعات کاربر
                                            </button>
                                            <button type="button"
                                                    data-toggle="modal" data-target="#exampleModalprofile"
                                                    style="float:right;color: #555;background-color: #c56f6182 !important;border: 1px dashed #903d3d;margin-right: 5px"
                                                    class="btn btn-success status_change_profile">عدم تائید
                                                اطلاعات کاربر
                                            </button>
                                        @endif
                                    @endcan
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="exampleModalprofile" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <input name="answer_id" type="hidden">
                    <input name="service_id" type="hidden">
                    <div class="form-group">
                        <label for="commentText" class="col-form-label"> علت عدم اطلاعات پروفایل:</label>
                        <textarea name="rejection_profile"
                                  style="border: 1px solid #eee;padding:10px;border-radius: 5px;"
                                  class="form-control" id="commentText"></textarea>
                        <input type="hidden" class="form-control" id="parentId"/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                    <button style="float: left" id="replycm" onclick="profile_status('profile_status','disapproval')"
                            class="btn btn-primary" data-parentid=""
                            data-dismiss="modal">
                        ثبت
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="exampleModalmadarek" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <input name="answer_id" type="hidden">
                    <input name="service_id" type="hidden">
                    <div class="form-group">
                        <label for="commentText" class="col-form-label"> علت عدم تایید مدارک:</label>
                        <textarea name="rejection_documents"
                                  style="border: 1px solid #eee;padding:10px;border-radius: 5px;"
                                  class="form-control" id="commentText"></textarea>
                        <input type="hidden" class="form-control" id="parentId"/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                    <button style="float: left" id="replycm" onclick="profile_status('documents_status','disapproval')"
                            class="btn btn-primary" data-parentid=""
                            data-dismiss="modal">
                        ثبت
                    </button>
                </div>
            </div>
        </div>
    </div>


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
            var data = {_token: CSRF_TOKEN, status: status, user_id: '{{$user->id}}'};
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
            var data = {_token: CSRF_TOKEN, status: status, user_id: '{{$user->id}}'};
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

        $('#active_sendmoney_status').on('change', function () {

            var status = "INACTIVE";
            if ($(this).is(':checked')) {
                status = "ACTIVE";
            }
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Change_status_user_sendmoney')}}';
            var data = {_token: CSRF_TOKEN, status: status, user_id: '{{$user->id}}'};
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


        $('#active_seller_status').on('change', function () {

            var status = "NO";
            if ($(this).is(':checked')) {
                status = "YES";
            }
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Change_status_user_seller')}}';
            var data = {_token: CSRF_TOKEN, status: status, user_id: '{{$user->id}}'};
            $.post(url, data, function (msg) {
                if (msg == "ACTIVE") {

                    $.notify({
                        // options
                        message: 'با موفقیت به لیست فروشندگان اضافه شد'
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
                        message: 'با موفقیت از لیست فروشندگان حذف شد'
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
        @if(session('user_change'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('user_change')}}</span>',
            icon: '',
        }, {
            // settings
            type: 'success',
            allow_dismiss:false,
            placement: {
                from: "top",
                align: "left"
            },
            animate: {
                enter: 'animated fadeIn',
                exit: 'animated fadeOut'
            }
        });
        @endif
    </script>

    @can('users_edit_add_admin')
        <script>
            function isadmin(tag, admin) {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('Change_user_isadmin')}}';
                var data = {_token: CSRF_TOKEN, admin: admin, user_id: '{{$user->id}}'};
                $.post(url, data, function (msg) {
                    if (msg == "delete") {
                        $.notify({
                            // options
                            message: 'با موفقیت از لیست مدیران حذف شد'
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
                        $(tag).remove();
                        $('#isadmin').append('<button type="button" onclick="isadmin(this,\'admin\')"  style="color: #0f828e;background-color: #61c0c582 !important;border: 1px dashed #3d8890;" class="btn btn-success status_change_profile">افزودن به لیست مدیران</button>');
                        $('#isadmin a').remove();
                    } else if (msg == "admin") {
                        $.notify({
                            // options
                            message: 'با موفقیت به لیست مدیران اضافه شد'
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
                        $(tag).remove();
                        $('#isadmin').append('<button type="button" onclick="isadmin(this,\'notadmin\')" style="color: #bb4141;background-color: #c56f6182 !important;border: 1px dashed #903d3d;margin-right: 5px" class="btn btn-success status_change_profile">حذف از لیست مدیران</button><a href="<?=route('admins.edit', $user->id)?>" style="DISPLAY: block;margin-top: 10px;">مدیریت دسترسی ها</a>')
                    }
                })
            }
        </script>
    @endcan
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
            var state = '{{$user->ostan_id}}';
            if (value_ostan == state) {
                $(this).attr('selected', 'selected');
                ldMenu(value_ostan, 'city');

            }


        });

        $('.city option').each(function (index) {
            var city = '{{$user->city_id}}';
            var city_value = $(this).val();
            if (city_value == city) {
                $(this).attr('selected', 'selected');
                $('.selectpicker').selectpicker('refresh');
            }
        });


        function uploadimageprofile() {
            $('.profile-body .wimgpf').waitMe({
                effect: 'pulse',
                text: 'در حال بارگذاری ...',
                maxSize: '',
                waitTime: 1,
                textPos: 'vertical',
                fontSize: '10',
                source: '',
            });
            var formData = new FormData();
            formData.append("file", $('#image_profile')[0].files[0]);
            formData.append("id", '{{$user->id}}');
            $.ajax({
                type: "post",
                url: "{{route('uploadimageprofile')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('.wimgpf').slideDown(300);
                    $('.waitMe').fadeOut();
                    $('.profile-body #imgpf').attr('src', data.status);
                },
                error: function (err) {
                    if (err.status == 422) {
                        $('#error_user').slideDown(150);
                        $.each(err.responseJSON.errors, function (i, error) {
                            $('#error_item').append($('<span style="color: #fff;font-size: 12px">' + error[
                                    0] +
                                '</span><br>'));
                        });
                    }
                }
            });

        }
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

    <script>
        function profile_status(profile, status) {
            var rejection_profile = $('textarea[name=rejection_profile]').val();
            var rejection_documents = $('textarea[name=rejection_documents]').val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Change_documents_status_user')}}';
            var data = {
                _token: CSRF_TOKEN,
                status: status,
                profile: profile,
                rejection_documents: rejection_documents,
                rejection_profile: rejection_profile,
                user_id: '{{$user->id}}'
            };
            $.post(url, data, function (msg) {
                $('.status_change_profile').remove();
                if (msg == "ok") {
                    $.notify({
                        // options
                        message: 'با موفقیت تائید شد'
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
                        message: 'با موفقیت رد شد'
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
        }
    </script>

    <script>
        function get_user(tag) {
            $(tag).parents().find('.invalid-feedback').remove();
            var value = $(tag).val();
            if (value.length > 6) {
                if (value != '') {
                    var CSRF_TOKEN = '{{ csrf_token() }}';
                    var url = '{{route('get_user_reference')}}';
                    var data = {_token: CSRF_TOKEN, value: value};
                    $.post(url, data, function (msg) {
                        if (msg == 'notok') {
                            $(tag).parents().find('.invalid-feedback').remove();
                            $(tag).parents('.form-group').append('<span class="invalid-feedback" role="alert"><strong style="    color: #103c5a;">کاربر پیدا نشد</strong></span>');
                        } else {
                            $(tag).parents().find('.invalid-feedback').remove();
                            $(tag).parents('.form-group').append('<span class="invalid-feedback" role="alert"><strong style="    color: #103c5a;">' + msg.name + '</strong></span>');
                            $('.waitMe').fadeOut();
                        }
                    });
                }
            }


        }

        function users_move() {

            var value = $('input[name=users_move]').val();

            var move_type = $('select[name=move_type]').val();

            if (value.length > 6) {
                $('.bg-blue').waitMe({
                    effect: 'pulse',
                    text: '',
                    maxSize: '',
                    waitTime: 1,
                    textPos: 'vertical',
                    fontSize: '10',
                    source: '',
                });

                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('get_user_reference')}}';
                var data = {_token: CSRF_TOKEN, value: value, move_type: move_type};
                $.post(url, data, function (msg) {
                    if (msg.name != "") {
                        $('.waitMe').fadeOut();
                        Swal.fire({
                            text: "شما در حال انتقال جایگاه به " + msg.name + " هستید، آیا اطمینان دارید ؟",
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            position: 'top',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: 'rgb(181, 178, 178)',
                            confirmButtonText: 'بله انتقال بده',
                            cancelButtonText: 'لغو',

                        }).then((result) => {
                            if (result.value) {

                                $('.class-card').waitMe({
                                    effect: 'pulse',
                                    text: 'در حال انتقال لطفا کمی صبر کنید ...',
                                    maxSize: '',
                                    waitTime: 1,
                                    textPos: 'vertical',
                                    fontSize: '10',
                                    source: '',
                                });
                                $('#move_user').submit();

                            }
                        })
                    }
                });
            }
        }
    </script>
@endsection

@php
    Session::forget('user_change');
    Session::forget('user_chagne_danger');
    session::forget('tab_pass');
    session::forget('user_chagne_city');
    session::forget('tab_user_move');
@endphp
