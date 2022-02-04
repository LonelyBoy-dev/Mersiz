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
    @if(session('askformoney'))
        <div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            {{session('askformoney')}}
        </div>
    @endif

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 80px">
            <div class="card" style="box-shadow: none">
                <div class="body">
                    <!-- Nav tabs -->

                    <div class="box-body">
                        <br>
                        <div class="container-fluid table-responsive">

                            <table class="table text-center table-striped" id="myTable"
                                   style="width: 100%;font-size: 13px">
                                <thead class="bg-blue-gradient">
                                <tr id="">
                                    <th>#</th>
                                    <th>نام و نام خانوادگی</th>
                                    <th>نام کاربری</th>
                                    <th>موبایل</th>
                                    <th>تاریخ ثبت نام</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{$i++}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td>{{Verta::instance($user->created_at)->format('%d %B %Y | H:i:s')}}</td>
                                        <td>@if($user->id!=1)
                                                @can('admins_edit')
                                                    <a href="{{route('admins.edit',$user->id)}}"
                                                       style="padding: 2px 4px;font-size: 13px;" type="button"
                                                       class="btn btn-info waves-effect">
                                                        <i style="font-size: 16px;" class="material-icons">lock</i>
                                                        <span>دسترسی ها</span>
                                                    </a>
                                                @endcan
                                                @can('admins_delete')
                                                    <button onclick="removeadmin(this,'notadmin','{{$user->id}}')"
                                                            style="padding: 2px 4px;font-size: 13px;" type="button"
                                                            class="btn btn-danger waves-effect">
                                                        <i style="font-size: 16px;" class="material-icons">delete_forever</i>
                                                        <span>حذف</span>
                                                    </button>
                                                @endcan
                                            @endif</td>
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


            function removeadmin(tag, admin, user_id) {

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
                        var url = '{{route('Change_user_isadmin')}}';
                        var data = {_token: CSRF_TOKEN, admin: admin, user_id: user_id};
                        $.post(url, data, function (msg) {
                            if (msg == "delete") {
                                $.notify({
                                    // options
                                    message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت حذف شد</span>',
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
                            }
                            $(tag).parents('tr').remove();
                        });
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
            ordering:  true,
            scrollX:0,
            paging: true,
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
    Session::forget('askformoney');
@endphp
