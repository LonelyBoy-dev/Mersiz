@extends('front.profile.layout')
@section('style')
    <style>
        select.form-control{
            border-radius: 5px;
        }

        .item .box-option_label{
            display: flex;
            border: unset;
            border-bottom: 1px solid #ccc !important;
            border-radius: unset !important;
        }
        .c-profile-comments__status--approved {
            border-color: #4caf50;
            background-color: rgba(76,175,80,.1);
            color: #2e7b32;

        }
        .c-profile-comments__status--Waiting {
            border-color: #f9a825;
            background-color: rgba(249,168,37,.1);
            color: #f57f17;

        }
        .c-profile-comments__status {
            width: 86px;
            font-size: 12px;
            line-height: 22px;
            padding: 0 12px;
            border: 1px solid #fff;
            border-radius: 8px;
            margin-left: 15px;
        }
        .c-profile-comments__status--rejected {
            border-color: #d32f2f;
            background-color: rgba(211,47,47,.1);
            color: #b2001a;
        }
    </style>
@endsection
@section('content_panel')

    <div class="card mb-16" data-controller="ProfileComplain">

        <!--card header-->
        <div class="card-header card-header-right-border">
            <div class="card-header_caption">
                <div class="card-header_caption-title">
                    <div class="card-header_caption-text">
                        <span>شکایات و پیشنهادات</span>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary mt-16" data-toggle="modal" data-target="#addComplainModal"><i class="ico ico-plus"></i>درخواست جدید</button>
        </div>
        <!--card header end-->
        <!--card body-->
        <div class="card-body">

            <!--table-->
            <div class="table-responsive">
                <table class="table subtitle2 m-0">
                    <thead class="bg-secondary text-white">
                    <tr>
                        <th scope="col">شماره پیگیری</th>
                        <th scope="col">نوع</th>
                        <th scope="col">تاریخ ثبت</th>
                        <th scope="col">وضعیت</th>
                        <th scope="col">عنوان درخواست</th>
                        <th scope="col">متن درخواست</th>
                        <th scope="col">پاسخ</th>
<!--                        <th scope="col">تصویر</th>
                        <th scope="col">مدیا</th>-->
                    </tr>
                    </thead>
                    <tbody class="font-weight-normal">

                    @foreach($complains as $complain)
                    <tr class="bg-gray-50" id="collapseTable-1">
                        <td colspan="1">
                            <span>#{{$complain->id}}</span>
                        </td>
                        <td colspan="1">
                            <span>{{$complain->CaseTypeCode}}</span>
                        </td>
                        <td colspan="1">
                            <span>{{Verta::instance($complain->created_at)->formatDatetime()}}</span>
                        </td>
                        <td colspan="1">
                            @if ($complain->status=="SEEN")
                                <div class="c-profile-comments__status c-profile-comments__status--approved">
                                    برسی شده
                                </div>
                            @elseif($complain->status=='Waiting')
                                <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 103px;">
                                    در انتظار بررسی
                                </div>
                            @elseif($complain->status=='UNSEEN')
                                <div class="c-profile-comments__status c-profile-comments__status--rejected">
                                    تایید نشده
                                </div>
                            @endif
                        </td>
                        <td colspan="1">
                            <span>{{$complain->title}}</span>
                        </td>
                        <td colspan="1">
                            <span>{{$complain->Message}}</span>
                        </td>
                        <td colspan="1">
                            @if ($complain->answer=="")
                                @if($complain->status=="SEEN")
                                    <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 80px;">
                                        بدون پاسخ
                                    </div>
                                @else
                                <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 96px;">
                                    در انتظار پاسخ
                                </div>
                                @endif
                            @else
                                {{$complain->answer}}
                            @endif
                        </td>
                    </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
            <!--table end-->

        </div>
        <!--card body end-->


    </div>

    <div class="modal" id="addComplainModal" tabindex="-1" role="dialog" aria-labelledby="addComplainModalLabel" aria-modal="true" style="padding-right: 17px;">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <!--header-->
                <div class="modal-header">
                    <h5 class="modal-title text-primary">ثبت درخواست جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ico ico-close ico-fw-0"></i></span>
                    </button>
                </div>
                <!--header end-->
                <div class="modal-body">
                    <form method="post" id="frmAddComplain" class="submit-form" enctype="multipart/form-data" action="/profile/Store-complain" novalidate="novalidate">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <label class="text-caption" for="CaseTypeCode">نوع درخواست</label>
                                <select class="form-control" data-change="caseTypeSelect" data-val="true" data-val-required="نوع درخواست ضروری است" id="CaseTypeCode" name="CaseTypeCode">
                                    <option value="">لطفا یک مورد را انتخاب کنید...</option>
                                    <option value="سوال">سوال</option>
                                    <option value="شکایت">شکایت</option>
                                    <option value="پیشنهاد/انتقاد">پیشنهاد/انتقاد</option>
                                    <option value="درخواست">درخواست</option>
                                </select>
                                <span class="text-danger field-validation-valid" data-valmsg-for="CaseTypeCode" data-valmsg-replace="true"></span>
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="text-caption" for="CaseSubTypeCode">عنوان درخواست</label>

                                <input type="text" class="form-control " data-val="true" data-val-required="عنوان ضروری است" placeholder="عنوان درخواست..." id="CaseSubTypeCode" name="title" value="" data-val-maxlength-max="255" maxlength="255" >
                                <span class="text-danger field-validation-valid" data-valmsg-for="CaseSubTypeCode" data-valmsg-replace="true"></span>
                            </div>


                            <div class="form-group col-lg-12">
                                <label class="text-caption" for="MessageDescription">متن درخواست</label>
                                <textarea class="form-control" rows="3" placeholder="متن درخواست ..." data-val="true" data-val-maxlength="طول متن درخواست نمی تواند بیشتر از 255 کاراکتر باشد" data-val-maxlength-max="255" data-val-required="متن درخواست ضروری است" id="MessageDescription" maxlength="255" name="MessageDescription"></textarea>
                                <span class="text-danger field-validation-valid" data-valmsg-for="MessageDescription" data-valmsg-replace="true"></span>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-block btn-primary"><i class="ico ico-checkbox filter-white"></i>ثبت درخواست</button>
                        <input name="__RequestVerificationToken" type="hidden" value="CfDJ8ApCcpNMgRVPiUaCN0sn-3EeU-x1yDdvhoNFvQGhjCw-Qu4FYJhkO0AK_vlc3QBNkQzdXOB84ugzrWjDy8PpQ8GRZeMlN5XL56ZKkRtGZ-L5N6H6u85UZUV1z_hu-B9jS5TI3Sch2JbcdCeedvuMTx5E6c2pEC-pdwEpkb9T1J3YiO_1xf3dhBAjBnyZTN16VQ"></form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if(session('complain__store'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('<?= session('complain__store') ?>');
        </script>
    @endif
@endsection
@php
    Session::forget('complain__store');
@endphp
