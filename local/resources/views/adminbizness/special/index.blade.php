@extends('adminbizness.layout.master')

@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap-material-datetimepicker.css')}}" />
    <link rel="stylesheet" href="{{asset('css/flipTimer.css')}}" />
    <link rel="stylesheet" href="{{asset('js/persianDatepicker-master/css/persianDatepicker-default.css')}}" />

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
        .dtp > .dtp-content{
            right: 41%;
        }
        .flipTimer{
            direction: ltr;
            transform: scale(.3);
            position: absolute;
            top: -26px;
            width: 111%;
            font-family: "Helvetica Neue", Helvetica, sans-serif!important;
        }
        .flipTimer span{
            font-family: "Helvetica Neue", Helvetica, sans-serif!important;
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
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">developer_board</i>
                <b style="color: #555;margin: 7px 5px 0 0;float: right;font-size: 18pt;">  محصولات سبدروز</b>
            </h2>
        </div>

    </div>

    <div class="row clearfix">

<!--        <form method="post" action="{{route('special.store')}}">
            @csrf
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            مدیریت زمان
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="float: right">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="pdpSelectedBefore" name="date"
                                               class=" form-control"
                                               placeholder="تاریخ خود را انتخاب کنید" value="{{@$spacial->date}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="timepicker form-control" name="time" placeholder="زمان خود را انتخاب کنید" value="{{@$spacial->time}}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="flipTimer">
                                    <div class="days"></div>
                                    <div class="hours"><span style="color: #555">:</span></div>
                                    <div class="minutes"><span style="color: #555">:</span></div>
                                    <div class="seconds"><span style="color: #555">:</span></div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success waves-effect btn-block" type="submit">ثبت زمان</button>
                    </div>
                </div>
            </div>
        </form>-->

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

                                    <th style="background-image: none;">تصویر</th>
                                    <th>عنوان</th>
                                    <th>وضعیت</th>
                                    <th>بازدید</th>
                                    <td>دسته بندی</td>
                                    <td>قیمت اصلی</td>
                                    <th>تاریخ انتشار</th>
                                    <th>فعالیت ها</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($spacials as $product)
                                    <tr id="post{{$product->id}}">

                                        <td style="width: 100px">@if($product->image=="") بدون تصویر @else <img style="width: 80%" src="{{asset($product->image)}}">@endif</td>
                                        <td><a href="/product/{{$product->slug}}">{{$product->title}}</a></td>
                                        <td>@if($product->status=="PUBLISHED")<span style="color: #0f9d58">منتشر شده</span> @elseif($product->status=="PENDING")<span style="color: #f39c12">انتظار</span> @else<span style="color: #03A9F4">پیش نویس</span> @endif</td>
                                        <td>{{$product->view}}</td>
                                        <td>
                                            @foreach ($product->categories as $val)
                                                <span class="label label-primary">{{$val->title}}</span>
                                            @endforeach
                                        </td>

                                        <td>{{number_format($product->price)}} تومان</td>
                                        <td>{{Verta::instance($product->created_at)}}</td>
                                        <td>

                                            <button onclick="delete_special(this,'{{$product->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
                                                <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                حذف</button>
                                            <a href="{{route('products.edit',$product->id)}}" type="button" class="btn bg-light-blue waves-effect" title="ویرایش" style="padding: 1px 5px;margin-bottom: 5px">
                                                <i class="material-icons" style="font-size: 15px;">mode_edit</i>
                                                <span>ویرایش</span>
                                            </a>
                                            <a href="/admin/product/attributes/{{$product->slug}}" type="button" class="btn btn-warning waves-effect" title="ویژگی ها" style="padding: 1px 5px;margin-bottom: 5px">
                                                <i class="material-icons" style="font-size: 15px;">kitchen</i>
                                                <span>ویژگی ها</span>
                                            </a>

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
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/jquery.flipTimer.js')}}"></script>
    <script src="{{asset('js/persianDatepicker-master/js/persianDatepicker.min.js')}}"></script>
@endsection


@section('script')
    <script>
        $('#time').bootstrapMaterialDatePicker
        ({
            date: false,
            shortTime: false,
            format: 'HH:mm'
        });
        $("#pdpSelectedBefore").persianDatepicker({
            showGregorianDate: true,
            formatDate: "YYYY-0M-DD"
        });
        $('.flipTimer').flipTimer({

            direction:'down',
            date:'{{@$spacial->date}} {{@$spacial->time}}:30',

            callback:function () {
                $('.slider2_content2_finish').fadeIn(0);
                $('.flipTimer').css('display','none');
                $('.slider2_content2').fadeOut(0);
                $('.slider2_content2_finish').css('opacity',.8);


            }
        });
    </script>
    <script>
        @if(session('spacial-create'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('spacial-create')}}</span>',
            icon: '',
        }, {
            // settings
            type: 'success',
            allow_dismiss: false,
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
            function delete_special(tag, id) {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('special.delete_special')}}';
                var data = {_token: CSRF_TOKEN, id: id};
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
    Session::forget('spacial-create');
@endphp
