@extends('adminbizness.layout.master')

@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection

@section('style')
    <style>
        .table th {
            text-align: center;
        }

        .nav-tabs > li {
            float: right;
        }

        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 60px;
        }
    </style>
@endsection

@section('Admin_content')
    @if(session('alert-success'))
        <div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            {{session('alert-success')}}
        </div>
    @endif
    <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
        <div style="min-width: 150px">
            <h2 style="margin-top: 0">
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">add_alert</i>
                <b style="color: #555;margin: 7px 5px 0 0;float: right;font-size: 18pt;"> مدیریت اعلان</b>
            </h2>
        </div>

    </div>


    <div class="row clearfix">

        <form method="post" action="{{route('alerts.store')}}">
            @csrf
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            افزودن اعلان جدید
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="form-group">
                                <label for="NameSurname" style="float: right"
                                       class="col-sm-3 control-label">عنوان</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="NameSurname" name="title"
                                               placeholder="عنوان را وارد کنید">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="account_number" style="float: right"
                                       class="col-sm-3 control-label">توضیحات</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <textarea name="description" rows="4" class="form-control no-resize"
                                                  placeholder="توضیحات را وارد کنید"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-success waves-effect btn-block" type="submit">ثبت اعلان</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 80px">
            <div class="card" style="box-shadow: none">
                <div class="body">
                    <!-- Nav tabs -->


                    <div class="box-body">
                        <br>
                        <div class="container-fluid table-responsive">

                            <table class="table table-bordered text-center table-striped" id="myTable"
                                   style="width: 100%;font-size: 13px">
                                <thead class="bg-blue-gradient">
                                <tr id="">
                                    <th>#</th>
                                    <th>عنوان</th>
                                    <th>متن</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($alerts as $alert)
                                    <tr>
                                        <th scope="row">{{$i++}}</th>
                                        <td>{{$alert->title}}</td>
                                        <td>{{$alert->description}}</td>
                                        <td class="status_title">@if($alert->status=="SEEN")<span>نمایش</span>@else<span>عدم نمایش</span>@endif</td>
                                        <td>{{Verta::instance($alert->created_at)->format('%d %B %Y | H:i:s')}}</td>
                                        <td>
                                            <span id="status">
                                                  @if($alert->status=="SEEN")
                                                    <button onclick="alert_status(this,'UNSEEN','{{$alert->id}}')"
                                                            style="padding: 2px 4px;font-size: 13px;" type="button"
                                                            class="btn btn-info waves-effect">
                                                <i style="font-size: 16px;" class="material-icons">visibility_off</i>
                                                <span>عدم نمایش</span>
                                            </button>
                                                @else
                                                    <button onclick="alert_status(this,'SEEN','{{$alert->id}}')" style="padding: 2px 4px;font-size: 13px;" type="button" class="btn btn-info waves-effect"><i style="font-size: 16px;" class="material-icons">visibility</i><span>نمایش دادن</span></button>
                                                @endif

                                            </span>

                                            <button onclick="alert_remove(this,'{{$alert->id}}')"
                                                    style="padding: 2px 4px;font-size: 13px;" type="button"
                                                    class="btn btn-danger waves-effect">
                                                <i style="font-size: 16px;" class="material-icons">delete_forever</i>
                                                <span>حذف</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>


    </div>
@endsection

@section('script_link')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
@endsection


@section('script')

    @can('users_edit_add_admin')
        <script>
            function alert_remove(tag, alert_id) {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('alert_remove')}}';
                var data = {_token: CSRF_TOKEN, alert_id: alert_id};
                $.post(url, data, function (msg) {
                    if (msg == "delete") {
                        $.notify({
                            // options
                            message: 'با موفقیت حذف شد'
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
                        $(tag).parents('tr').remove();
                    }
                })
            }


            function alert_status(tag, status,alert_id) {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('alert_status')}}';
                var data = {_token: CSRF_TOKEN, status: status,alert_id:alert_id};
                $.post(url, data, function (msg) {
                    if(msg=="SEEN"){

                        $(tag).parents('tr').find('.status_title').empty();
                        $(tag).parents('tr').find('.status_title').append('<span>نمایش</span>');
                        $(tag).parents('#status').append('<button onclick="alert_status(this,\'UNSEEN\','+alert_id+')" style="padding: 2px 4px;font-size: 13px;" type="button" class="btn btn-info waves-effect"><i style="font-size: 16px;" class="material-icons">visibility_off</i><span>عدم نمایش</span></button>');
                        $(tag).remove();
                    }else{

                        $(tag).parents('tr').find('.status_title').empty();
                        $(tag).parents('tr').find('.status_title').append('<span> عدم نمایش</span>');
                        $(tag).parents('#status').append('<button onclick="alert_status(this,\'SEEN\','+alert_id+')" style="padding: 2px 4px;font-size: 13px;" type="button" class="btn btn-info waves-effect"><i style="font-size: 16px;" class="material-icons">visibility</i><span>نمایش دادن</span></button>');
                        $(tag).remove();
                    }
                })
            }
        </script>
    @endcan
    <script>


        $('#myTable').DataTable({
            "lengthMenu": [
                [20, 30, 40],
                [20, 30, 40],
            ],
            "language": {
                "sEmptyTable": "هیچ داده‌ای در جدول وجود ندارد",
                "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                "sInfoEmpty": "نمایش 0 تا 0 از 0 ردیف",
                "sInfoFiltered": "(فیلتر شده از _MAX_ ردیف)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "نمایش _MENU_ ردیف",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "جستجو:",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oPaginate": {
                    "sFirst": "برگه‌ی نخست",
                    "sLast": "برگه‌ی آخر",
                    "sNext": "بعدی",
                    "sPrevious": "قبلی"
                },
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            }
        });

        $('#myTable2').DataTable({
            "lengthMenu": [
                [20, 30, 40],
                [20, 30, 40],
            ],
            "language": {
                "sEmptyTable": "هیچ داده‌ای در جدول وجود ندارد",
                "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                "sInfoEmpty": "نمایش 0 تا 0 از 0 ردیف",
                "sInfoFiltered": "(فیلتر شده از _MAX_ ردیف)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "نمایش _MENU_ ردیف",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "جستجو:",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oPaginate": {
                    "sFirst": "برگه‌ی نخست",
                    "sLast": "برگه‌ی آخر",
                    "sNext": "بعدی",
                    "sPrevious": "قبلی"
                },
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            }
        });

        $('.dataTables_length select').addClass('tbl_data');

    </script>
@endsection
@php
    Session::forget('alert-success');
@endphp
