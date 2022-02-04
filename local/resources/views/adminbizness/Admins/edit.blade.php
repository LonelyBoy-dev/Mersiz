@extends('adminbizness.layout.master')

@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection

@section('style')
    <style>
        .table th{
            text-align: center;
        }
        .nav-tabs > li{
            float: right;
        }
        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 60px;
        }
        [type="checkbox"].filled-in:checked.chk-col-light-green + label:after{
            right: 0;
        }
        [type="checkbox"].filled-in:not(:checked) + label:after{
            right: 0;
        }
        [type="checkbox"].filled-in:checked + label:before{
            right: 11px;
        }
        [type="checkbox"] + label{
            padding-right: 26px;
            font-size: 11pt;
        }
    </style>
@endsection

@section('Admin_content')

    <div class="col-xs-12 head" style="margin-bottom: 20px;display: flex;justify-content: space-between">
        <div style="width: 100%">
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">person</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">دسترسی ها</b>
            </h2>
            <a href="{{route('admins.index')}}" style="float: left" title="برگشت"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 80px">
            <div class="card" style="box-shadow: none">

                <div class="body">
                    <!-- Nav tabs -->
                    <form method="post" action="{{route('admins.store')}}">
                        @csrf
                        @foreach($permissions as $permission)
                            <ul>
                                <li style="margin-bottom: 10px">
                                    <?php $check=App\Permission_role::where(['permission_id'=>$permission->id,'user_id'=>$user->id])->first() ?>
                                   {{-- <input name="permission[]" value="{{$permission->id}}" type="checkbox" id="md_checkbox_{{$permission->id}}" class="filled-in chk-col-light-green" @if($check)checked @endif>--}}
                                    <label style="font-weight: 700" for="md_checkbox_{{$permission->id}}"> {{$permission->name}}</label>
                                </li>

                                <?php $parents=App\Permission::where('parent',$permission->id)->get(); ?>

                                @if($parents)
                                    <ul style="padding-right: 25px;">

                                        @foreach($parents as $parent)
                                            <?php $check=App\Permission_role::where(['permission_id'=>$parent->id,'user_id'=>$user->id])->first() ?>
                                        <li><input name="permission[]" value="{{$parent->id}}" type="checkbox" id="md_checkbox_{{$parent->id}}" class="filled-in chk-col-light-green"  @if($check)checked @endif>
                                            <label for="md_checkbox_{{$parent->id}}"> {{$parent->name}}</label></li>
                                            @endforeach
                                    </ul>
                                    <hr style="border-top: 1px solid #61c579;">
                                @endif
                            </ul>
                        @endforeach
                        <input name="user_id" value="{{$user->id}}" type="hidden">
                            <button type="submit" class="btn btn-success waves-effect">ثبت دسترسی ها</button>
                    </form>

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
        @if(session('Permission'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('Permission')}}</span>',
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
    Session::forget('Permission');
@endphp
