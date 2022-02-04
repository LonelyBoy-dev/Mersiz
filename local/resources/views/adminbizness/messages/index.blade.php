

@extends('adminbizness.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection
@section('style')
    <style>
        .table{
            text-align: center;

        }
        .dataTable{
            width: 100%!important;
        }
        .nav-tabs > li{
            float: right;
        }
        .modal-title{
            margin: 8px 0;
        }
        .modal-title span:first-child{
            font-size: 15px;
            font-weight: 600;
        }
        .dataTables_scrollHeadInner{
            width: auto!important;
        }
        .body > .col-xs-12.col-lg-12{
            float: right !important;
        }
        .invalid-feedback{
            color: red;
            font-size: 10px;
        }
        tr td{
            text-align: center;
        }
    </style>
@endsection

@section('Admin_content')



    <?php
    Session::forget('posts-success');
    ?>

    {{--@dd($productItems)--}}
    <!-- Hover Rows -->
    <div class="row">
        <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
            <div style="min-width: 150px">
                <h2 style="margin-top: 0">
                    <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">add_alert</i>
                    <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">پیغام ها</b>
                </h2>
            </div>

            <div>

            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                    <form action="{{route('messages.store')}}" method="post">
                        @csrf
                        <div class="col-xs-12 col-lg-12 " style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    ثبت پیغام جدید
                                </h5>
                            </div>
                            <div class="body">
                                <div class="col-xs-12 col-lg-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea name="message" rows="4" class="form-control no-resize" placeholder="پیام خود را وارد کنید"></textarea>
                                        </div>
                                        @if ($errors->has('message'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('message') }}</strong>
                                                 </span>
                                        @endif
                                    </div>
                                </div>


                                    <div class="col-xs-6 col-lg-4" style=" text-align: left;margin-bottom: 15px;">
                                        <button  type="submit" class="btn bg-green waves-effect" title="افزودن جدید">
                                            <i class="material-icons">add_circle</i>
                                            <span>ثبت پیام</span>
                                        </button>
                                    </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">

                                    <div class="table-responsive">
                                        <table style="width: 100%;" id="posts" class="table4 table-striped table-hover dataTable js-exportable">
                                            <thead>
                                            <tr>

                                                <th>#</th>
                                                <th>متن پیام</th>
                                                <th>تاریخ ثبت</th>
                                                <th>وضعیت</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $i=1; ?>
                                            @foreach($Messages as $Message)
                                                    <tr id="post{{$Message->id}}">
                                                        <td>{{$i}}</td>
                                                        <td><a>{{$Message->message}}</a></td>
                                                        <td><a>{{Verta::instance($Message->created_at)}}</a></td>
                                                        <td class="status_title">@if($Message->status=="Show")نمایش @elseعدم نمایش  @endif</td>
                                                        <th>
                                                            <button onclick="delete_message(this,'{{$Message->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
                                                                <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                                حذف</button>
                                                            <span class="status">
                                                                @if($Message->status=="Show")
                                                                    <button type="button" onclick="change_status(this,'{{$Message->id}}','DontShow')" class="btn btn-warning waves-effect" title="عدم نمایش" style="padding: 1px 5px;margin-bottom: 5px">
                                                                        <i class="material-icons" style="font-size: 15px;">remove_circle</i>
                                                                        <span>عدم نمایش</span>
                                                                    </button>
                                                                @else
                                                                    <button type="button" onclick="change_status(this,'{{$Message->id}}','Show')" class="btn bg-light-blue waves-effect" title="نمایش ها" style="padding: 1px 5px;margin-bottom: 5px">
                                                                        <i class="material-icons" style="font-size: 15px;">done</i>
                                                                        <span>نمایش</span>
                                                                    </button>
                                                                @endif
                                                            </span>



                                                        </th>
                                                    </tr>
                                                    <?php $i++; ?>
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
    <script>

        $('#posts').DataTable({
            "lengthMenu": [
                [10, 20, 30],
                [10, 20, 30],
            ],
            ordering:  true,
            scrollX:0,
            paging: true,
            "bLengthChange" : false,
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
        function delete_message(tag,id) {

            Swal.fire({
                text: " آیا از حذف این مورد اطمینان دارید ؟",
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
                confirmButtonText: 'بله حذف کن',
                cancelButtonText: 'لغو',

            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = '{{ csrf_token() }}';
                    var url = '{{route('message.delete_message')}}';
                    var data = {_token: CSRF_TOKEN, id: id};
                    $.post(url, data, function (msg) {
                        if (msg=="deleted"){
                            $.notify({
                                // options
                                message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت حذف شد</span>',
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
                        }
                        $(tag).parents('tr').remove();
                    });
                }
            })

        }

        function change_status(item,id,status){
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('message.change_status')}}';
            var data = {_token: CSRF_TOKEN, id: id,status:status};
            $.post(url, data, function (msg) {
                if (msg == "ok") {
                    if (status=="Show"){
                        var status_title="'DontShow'";
                        var button_status='<button type="button" onclick="change_status(this,'+id+','+status_title+')" class="btn btn-warning waves-effect" title="عدم نمایش" style="padding: 1px 5px;margin-bottom: 5px"><i class="material-icons" style="font-size: 15px;">remove_circle</i><span>عدم نمایش</span></button>';
                        $(item).parents('tr').find('.status_title').html('نمایش');
                        $(item).parents('tr').find('.status').html(button_status);
                    }else {
                        var status_title="'Show'";
                        var button_status='<button type="button" onclick="change_status(this,'+id+','+status_title+')" class="btn bg-light-blue waves-effect" title="نمایش ها" style="padding: 1px 5px;margin-bottom: 5px"><i class="material-icons" style="font-size: 15px;">done</i><span>نمایش</span></button>';

                        $(item).parents('tr').find('.status_title').text('عدم نمایش');
                        $(item).parents('tr').find('.status').html(button_status);
                    }
                }
            });
        }
    </script>

    <script>

        @if(session('message'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('message')}}</span>',
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
@endsection
<?php
Session::forget('message');
?>
