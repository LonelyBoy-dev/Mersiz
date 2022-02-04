

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
        .body .col-xs-6.col-lg-4{
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
                    <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">local_shipping</i>
                    <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">ثبت کد ارسال</b>
                </h2>
            </div>

            <div>

            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                    <form action="{{route('Sending-agent.store')}}" method="post">
                        @csrf
                        <div class="col-xs-12 col-lg-12 " style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    ثبت کد
                                </h5>
                            </div>
                            <div class="body">
                                <div class="col-xs-6 col-lg-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input  type="text" id="title" name="factor_number"
                                                    class="form-control" value="{{old('factor_number')}}">
                                            <label class="form-label"> شماره فاکتور : </label>
                                        </div>
                                        @if ($errors->has('factor_number'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('factor_number') }}</strong>
                                                 </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-xs-6 col-lg-4">

                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" id="slug" name="verification_code"
                                                   class="form-control" value="{{old('verification_code')}}">
                                            <label class="form-label"> کد : </label>
                                        </div>
                                        @if ($errors->has('verification_code'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('verification_code') }}</strong>
                                                 </span>
                                        @endif
                                    </div>
                                </div>
                                    <div class="col-xs-6 col-lg-4">
                                        <button  type="submit" class="btn bg-green waves-effect" title="افزودن جدید">
                                            <i class="material-icons">add_circle</i>
                                            <span>ثبت کد</span>
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
                                                <th>شماره فاکتور</th>
                                                <th>کد تایید</th>
                                                <th>تاریخ ثبت</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $i=1; ?>
                                            @foreach($registersendingcodes as $registersendingcode)
                                                    <tr id="post{{$registersendingcode->id}}">
                                                        <td>{{$i}}</td>
                                                        <td><a>{{$registersendingcode->factor_number}}</a></td>
                                                        <td><a>{{$registersendingcode->verification_code}}</a></td>
                                                        <td><a>{{Verta::instance($registersendingcode->created_at)}}</a></td>
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

    </script>

    <script>
        @if(session('registersendingcode'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('registersendingcode')}}</span>',
            icon: '',
        }, {
            // settings
            type: 'warning',
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
        @if(session('registersendingcode_save'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('registersendingcode_save')}}</span>',
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
Session::forget('registersendingcode');
Session::forget('registersendingcode_save');
?>
