@extends('front.profile.layout')
@section('style_link')
    <link href="{{asset('js/Mh1PersianDatePicker.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content_panel')
    <div class="card mb-16">
        <!--card header-->
        <div class="card-header card-header-right-border">
            <div class="card-header_caption">
                <div class="card-header_caption-title">
                    <div class="card-header_caption-text">حساب کاربری</div>
                </div>
            </div>
        </div>
        <!--card header end-->
        <!--card body-->
        <div class="card-body">
            <form class="row align-items-center" method="post" autocomplete="off" action="{{route('profile.edit_profile')}}" novalidate="novalidate">
               @csrf
                <div class="col-lg-7">

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="text-caption text-secondary" for="FirstName">نام <em class="mr-4 text-danger">*</em></label>
                            <input type="text" class="form-control" data-val="true" data-val-required="نام ضروری است" id="FirstName" name="name" value="@if(old('name')){{old('name')}}@else{{$user->name}}@endif">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                 </span>
                            @endif
                            <span class="text-danger field-validation-valid" data-valmsg-for="name" data-valmsg-replace="true"></span>
                        </div>
                        <!--form item-->
                        <div class="form-group col-lg-6">
                            <label class="text-caption text-secondary" for="LastName">نام خانوادگی <em class="mr-4 text-danger">*</em></label>
                            <input type="text" class="form-control" data-val="true" data-val-required="نام خانوادگی ضروری است" id="LastName" name="family" value="@if(old('family')){{old('family')}}@else{{$user->family}}@endif">
                            @if ($errors->has('family'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('family') }}</strong>
                                                 </span>
                            @endif
                            <span class="text-danger field-validation-valid" data-valmsg-for="family" data-valmsg-replace="true"></span>
                        </div>
                        <!--form item-->
                        <div class="form-group col-lg-6">
                            <label class="text-caption text-secondary" for="Gender">جنسیت</label>
                            <select style="border-radius: 5px" type="text" class="form-control" data-val="true" data-val-required="The جنسیت field is required." id="Gender" name="sex">
                                <option @if($user->sex=="F")selected @endif value="F">مرد</option>
                                <option @if($user->sex=="M")selected @endif value="M">زن</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="text-caption text-secondary" for="DOBString">تاریخ تولد</label>
                            <input type="" class="form-control" id="birthday"
                                   onclick="Mh1PersianDatePicker.Show(this,<?= "'" . Verta::now()->format('Y/n/j') . "'" ?>)"
                                   name="birthday" placeholder="" value="@if(old('birthday')){{old('birthday')}}@else{{$user->birthday}}@endif">
                            <input type="hidden" id="DOBString" name="DOBString" value="">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="text-caption text-secondary" for="MobileNumber">شماره همراه <em class="mr-4 text-danger">*</em></label>
                            <input style="text-align: left" type="text" class="form-control" data-val="true" disabled data-val-regex="فرمت شماره همراه نامعتبر است" data-val-regex-pattern="^[0|۰]{1}[9|۹]{1}[۰|0-۹|9]{9}" id="MobileNumber" value="{{$user->mobile}}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="text-caption text-secondary" for="Email">ایمیل</label>
                            <input style="text-align: left" type="email" class="form-control" data-val-email="فرمت ایمیل صحیحی نیست" id="Email" name="email" value="@if(old('email')){{old('email')}}@else{{$user->email}}@endif">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                 </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-lg-5 justify-content-center">

                    <div class="py-48">
                        <div class="text-center mb-12">
                            <i class="ico ico-color_users ico-128px ico-fw-0"></i>
                        </div>
                        <div class="text-center">
                            <button id="editBtn" class="btn btn-outline-primary px-24" type="submit">ثبت اطلاعات</button>
                        </div>
                    </div>

                </div>
                <!--edit form end-->

        </div>
    </div>
    <!--card body end-->

    <div class="modal fade" id="emailVerifyModal" tabindex="-1" role="dialog" aria-labelledby="emailVerifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">

                <!--header-->
                <div class="modal-header">
                    <h5 class="modal-title text-primary">اعتبار سنجی ایمیل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ico ico-close ico-fw-0"></i></span>
                    </button>
                </div>
                <!--header end-->


                <div class="modal-body">
                    <div class="my-16 text-caption text-center">
                        <span>ایمیلی حاوی کد فعال سازی به ایمیل شما ارسال شد. لطفا کد ارسال شده را در فیلد زیر وارد کنید </span>
                    </div>

                    <div class="form-group text-center">
                        <input id="verifyCode" type="text" class="form-control text-center" placeholder="کد امنیتی...">
                    </div>

                    <div class="form-group text-center">
                        <button type="button" id="verifySbBtn" class="btn btn-outline-primary"><i class="ico ico-box-check"></i>ثبت</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script_link')
    <script src="{{asset('js/Mh1PersianDatePicker.js')}}"></script>
@endsection
@section('script')
    @if(session('edit_profile'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('اطلاعات شما با موفقیت ذخیره شد');
        </script>
    @endif
    <div class="datepicker-plot-area" style="top: 647px; left: 441.406px; display: none;"><div class="navigator"><div class="datepicker-header"><div class="btn-next"><i class="ico ico-chevron-down ico-rotate-90"></i></div><div class="btn-switch">۱۳۹۹ دی</div><div class="btn-prev"><i class="ico ico-chevron-up ico-rotate-90"></i></div></div></div> <div class="datepicker-day-view" style=""><div class="month-grid-box today"><div class="header"><div class="title"></div><div class="header-row"><div class="header-row-cell">ش</div><div class="header-row-cell">ی</div><div class="header-row-cell">د</div><div class="header-row-cell">س</div><div class="header-row-cell">چ</div><div class="header-row-cell">پ</div><div class="header-row-cell">ج</div></div></div><table cellspacing="0" class="table-days"><tbody><tr><td><span unixdate="1608323400000" class="other-month">۲۹</span></td><td><span unixdate="1608409800000" class="other-month">۳۰</span></td><td><span unixdate="1608496200000">۱</span></td><td><span unixdate="1608582600000">۲</span></td><td><span unixdate="1608669000000">۳</span></td><td><span unixdate="1608755400000">۴</span></td><td><span unixdate="1608841800000">۵</span></td></tr><tr><td><span unixdate="1608928200000">۶</span></td><td><span unixdate="1609014600000">۷</span></td><td><span unixdate="1609101000000">۸</span></td><td><span unixdate="1609187400000">۹</span></td><td><span unixdate="1609273800000">۱۰</span></td><td><span unixdate="1609360200000">۱۱</span></td><td><span unixdate="1609446600000">۱۲</span></td></tr><tr><td><span unixdate="1609533000000">۱۳</span></td><td><span unixdate="1609619400000">۱۴</span></td><td><span unixdate="1609705800000">۱۵</span></td><td><span unixdate="1609792200000">۱۶</span></td><td><span unixdate="1609878600000">۱۷</span></td><td><span unixdate="1609965000000">۱۸</span></td><td><span unixdate="1610051400000">۱۹</span></td></tr><tr><td><span unixdate="1610137800000">۲۰</span></td><td><span unixdate="1610224200000">۲۱</span></td><td><span unixdate="1610310600000">۲۲</span></td><td><span unixdate="1610397000000">۲۳</span></td><td><span unixdate="1610483400000">۲۴</span></td><td><span unixdate="1610569800000">۲۵</span></td><td><span unixdate="1610656200000">۲۶</span></td></tr><tr><td><span unixdate="1610742600000" class="today selected">۲۷</span></td><td><span unixdate="1610829000000">۲۸</span></td><td><span unixdate="1610915400000">۲۹</span></td><td><span unixdate="1611001800000">۳۰</span></td><td><span unixdate="1611088200000" class="other-month">۱</span></td><td><span unixdate="1611174600000" class="other-month">۲</span></td><td><span unixdate="1611261000000" class="other-month">۳</span></td></tr><tr><td><span unixdate="1611347400000" class="other-month">۴</span></td><td><span unixdate="1611433800000" class="other-month">۵</span></td><td><span unixdate="1611520200000" class="other-month">۶</span></td><td><span unixdate="1611606600000" class="other-month">۷</span></td><td><span unixdate="1611693000000" class="other-month">۸</span></td><td><span unixdate="1611779400000" class="other-month">۹</span></td><td><span unixdate="1611865800000" class="other-month">۱۰</span></td></tr></tbody></table></div></div><div class="datepicker-month-view" style="display: none;"><div class="month1 month-item">فروردین</div><div class="month2 month-item">اردیبهشت</div><div class="month3 month-item">خرداد</div><div class="month4 month-item">تیر</div><div class="month5 month-item">مرداد</div><div class="month6 month-item">شهریور</div><div class="month7 month-item">مهر</div><div class="month8 month-item">آبان</div><div class="month9 month-item">آذر</div><div class="month10 month-item selected">دی</div><div class="month11 month-item">بهمن</div><div class="month12 month-item">اسفند</div></div><div class="datepicker-year-view" style="display: none;"><div class="year-item">۱۳۹۲</div><div class="year-item">۱۳۹۳</div><div class="year-item">۱۳۹۴</div><div class="year-item">۱۳۹۵</div><div class="year-item">۱۳۹۶</div><div class="year-item">۱۳۹۷</div><div class="year-item">۱۳۹۸</div><div class="year-item selected">۱۳۹۹</div><div class="year-item">۱۴۰۰</div><div class="year-item">۱۴۰۱</div><div class="year-item">۱۴۰۲</div><div class="year-item">۱۴۰۳</div></div><div class="datepicker-time-view" style="display: none;"></div><div class="toolbox "><div class="btn-today">امروز</div></div></div>

@endsection
@php
    Session::forget('edit_profile');
@endphp
