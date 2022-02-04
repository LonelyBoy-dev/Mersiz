@extends('adminbizness.layout.master')
@section('style_link')
    <link rel="stylesheet" href="{{asset('js/persianDatepicker-master/css/persianDatepicker-default.css')}}" />
@endsection

@section('style')
    <style>
        [type="checkbox"] + label:before, [type="checkbox"]:not(.filled-in) + label:after {
            right: 0;
        }
        [type="checkbox"] + label {
            padding-right: 26px;
        }
        [type="checkbox"]:checked + label:before {
            right: 9px;
        }
        .bootstrap-tagsinput .tag [data-role="remove"]:after {
            font-family: Arial;
        }
        .file-drop-zone-title {
            font-size: 0.8em;
            padding: 26px 10px;
        }
        .file-preview {
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 10px;
            padding: 0 10px;
        }
        .bootstrap-select.btn-group .dropdown-toggle .filter-option {
            text-align: right;
        }
        .bs-caret{
            display: none;
        }
        .card .body .col-lg-12 {
            margin-bottom: unset;
        }
        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 100%;
        }
        .card .header {
            padding: 6px 14px;
            border-bottom: 2px solid rgb(161, 129, 239);
        }
        .card{
            box-shadow: unset;
        }
        .col-lg-4,.col-lg-8{
            float: right;
        }
        .krajee-default.file-preview-frame .kv-file-content {
            width: 163px;
            height: 120px;
        }
        #somecomponent {
            width: 100%;
            height: 400px;
            border: 1px solid rgba(0,0,0,0.45);
            margin: 11px 0 0 20px;
            border-radius: 5px;
        }
        @media (min-width: 1281px){
            .popover.bottom {
                top: 1335px !important;
            }
        }

    </style>
@endsection
@section('Admin_content')

    @include('adminbizness.partial.error')
    <div class="col-xs-12 head" style="margin-bottom: 20px;display: flex;justify-content: space-between">
        <div style="width: 100%">
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">confirmation_number</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">ویرایش کد تخفیف جدید</b>
            </h2>
            <a href="{{route('discountcodes.index')}}" style="float: left" title="برگشت"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>
    </div>

        {!! Form::model($discountcode, ['method' => 'PATCH', 'action' => ['Admin\AdminDiscountcodesController@update', $discountcode->id]]) !!}

        <div class="row">

            <div class="col-xs-12">
                @if(session('insertcategory'))
                    <div class="alert alert-dismissible" role="alert" style="background-color: #61c579;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        {{session('insertcategory')}}
                    </div>
                @endif

                <?php
                session()->forget('insertcategory');
                ?>
            </div>

            <div class="col-lg-12 col-xs-12 col-sm-12 ali-flex" >

                <div class="col-lg-8 col-xs-12 col-sm-12 ali-margin-0" style="margin-left: 8px;display: inline-table">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 " style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    ویرایش کد تخفیف
                                </h5>
                            </div>
                            <div class="body">
                                <div class="col-xs-12 col-lg-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input  type="text" id="title" name="code"
                                                    class="form-control" value="@if(old('code')==""){{$discountcode->code}}@else{{old('code')}}@endif">
                                            <label class="form-label"> کد : </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-lg-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" id="slug" name="darsad"
                                                   class="form-control" value="@if(old('darsad')==""){{$discountcode->darsad}}@else{{old('darsad')}}@endif">
                                            <label class="form-label"> درصد تخفیف : </label>
                                        </div>
                                    </div>
                                </div>

                                {{--                                <div class="col-lg-12 col-xs-12">--}}
                                {{--                                    <div class="form-group form-float">--}}
                                {{--                                        <div class="form-line">--}}
                                {{--                                        <textarea type="text" id="shortContent" name="shortContent" rows="4"--}}
                                {{--                                                  class="form-control">{{old('description')}}</textarea>--}}
                                {{--                                            <label class="form-label"> توضیحات دسته : </label>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                    </div>


                </div>


                <div class="col-lg-4 col-xs-12 col-sm-12" style="margin-right: 0">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                            <div class="body">
                                <div class="col-lg-12" style="display: grid">
                                    <input type="submit" value="ویرایش کد تخفیف"
                                           style="padding: 5px;border-radius: 0;margin-bottom: 14px"
                                           class="btn btn-success waves-effect"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input  type="number" id="title" name="max"
                                            class="form-control" value="@if(old('max')==""){{$discountcode->max}}@else{{old('max')}}@endif">
                                    <label class="form-label"> تعداد قابل استفاده : </label>
                                </div>
                            </div>
                            <div class="form-group form-float" style="margin-bottom: 0">
                                <div class="header ali-border-b">
                                    <h5>
                                        تاریخ اتمام
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="ali-flex" data-mddatetimepicker="true" data-trigger="click"
                                         data-targetselector="#endDate" data-enabletimepicker="false"
                                         data-placement="bottom" data-fromdate="true"
                                         data-mdformat="yyyy/MM/dd dddd"
                                         data-disablebeforetoday="true">
                                        <div class="col-sm-1">
                                            <i class="material-icons">date_range</i>
                                        </div>
                                        <div class="col-sm-11">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="pdpSelectedBefore" name="end_date"
                                                           class="datetimepicker form-control"
                                                           placeholder="تاریخ اتمام تخفیف" value="@if(old('end_date')==""){{$discountcode->end_date}}@else{{old('end_date')}}@endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6 "--}}
                        {{--                             style="background: white;padding-top: 20px;margin-bottom: 14px">--}}
                        {{--                            <div class="header ali-border-b">--}}
                        {{--                                <h5>--}}
                        {{--                                    تصویر--}}
                        {{--                                </h5>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="body">--}}
                        {{--                                <div class="form-group form-float">--}}
                        {{--                                    <div class="col-lg-12" align="center">--}}
                        {{--                                            <label class="lbl-cursor" for="imgFile"--}}
                        {{--                                                   style="display: block;background: #6184e4;color: white;padding: 5px;border-radius: 0;margin-bottom: 14px">انتخاب--}}
                        {{--                                                تصویر</label>--}}
                        {{--                                        <input id="imgFile" name="imgFile" accept="image/*" type="file" style="display: none">--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                    </div>
                </div>

            </div>

        </div>
        {!! Form::close() !!}







@endsection
@section('script_link')
    <script src="{{asset('js/persianDatepicker-master/js/persianDatepicker.min.js')}}"></script>
@endsection

@section('script')
    <script>
        $("#pdpSelectedBefore").persianDatepicker({
            showGregorianDate: true,
            formatDate: "YYYY-0M-DD"
        });
    </script>
@endsection
