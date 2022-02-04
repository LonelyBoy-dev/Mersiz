@extends('menu::layouts.app')


@section('Admin_content')
    <style>
        .btn-success{
            color: #000;
        }
    </style>
        @include('menu::layouts.sidebar')
        <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
            <div style="min-width: 150px">
                <h2 style="margin-top: 0">
                    <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">list</i>
                    <b style="color: #555;margin: 7px 5px 0 0;float: right;font-size: 18pt;">مدیریت منو</b>
                </h2>
            </div>

        </div>


        <div class="row clearfix">
              <!-- Navbar -->
<!--            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                  <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#pablo">Laravel Menu Builder</a>
                  </div>
                  <button class="navbar-toggler show-sidebar" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                  </button>
                </div>
            </nav>
              &lt;!&ndash; End Navbar &ndash;&gt;-->

            <div class="cx-main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <nest-menu prefix="{{ menu_base_url().menu_prefix() }}"></nest-menu>
                        </div>
                    </div>
                 </div>
            </div>
         </div>
@endsection

@section('script')
    <script>
        $('#menuTable').DataTable({
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
    </script>
@endsection
