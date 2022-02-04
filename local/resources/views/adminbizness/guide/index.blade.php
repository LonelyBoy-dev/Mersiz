@extends('adminbizness.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection
@section('style')
    <style>
        .table {
            text-align: center;

        }

        .dataTable {
            width: 100% !important;
        }

        .nav-tabs > li {
            float: right;
        }

        .modal-title {
            margin: 8px 0;
        }

        .modal-title span:first-child {
            font-size: 15px;
            font-weight: 600;
        }

        .dataTables_scrollHeadInner {
            width: auto !important;
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
        <form id="form" action="{{route('guide.store')}}" method="post">
            <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
                <div style="min-width: 150px">
                    <h2 style="margin-top: 0">
                        <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">help</i>
                        <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;"> راهنمای سایت</b>
                    </h2>
                </div>

                <div>
                    <button type="submit" class="btn bg-green waves-effect" title="ذخیره">
                        <i class="material-icons">add_circle</i>
                        <span>ذخیره</span>
                    </button>
                </div>

            </div>
<?php 
$guide=App\About::find(5);
?>
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                @csrf
                                <textarea id="editor1" name="content"
                                          class="form-control">@if(old ('content')){{old ('content')}}@else{{$guide->content}}@endif</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
            ordering: true,
            scrollX: 0,
            paging: true,
            "bLengthChange": false,
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
        $('#check_All').click(function () {
            if (this.checked) {
                $('.checkBox').each(function () {
                    this.checked = true;
                })
            } else {
                $('.checkBox').each(function () {
                    this.checked = false;
                })
            }

        });


    </script>
    <script>
        @if(session('posts-create'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('posts-create')}}</span>',
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
@endsection
<?php
Session::forget('posts-create');
?>
