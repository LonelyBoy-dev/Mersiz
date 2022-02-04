

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
                    <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">sms</i>
                    <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">شکایات و پیشنهادات</b>
                </h2>
            </div>

            <div>


                @can('complains_delete')
                    <button onclick="delete_complains()" type="button" class="btn btn-danger waves-effect" title="حذف دسته جمعی">
                        <i class="material-icons">delete_forever</i>
                        <span>حذف دسته جمعی</span>
                    </button>
                @endcan
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active"><a href="#Question" data-toggle="tab">سوالات</a></li>
                                <li role="presentation"><a href="#profile" data-toggle="tab">شکایات</a></li>
                                <li role="presentation"><a href="#messages" data-toggle="tab">پیشنهاد/انتقاد</a></li>
                                <li role="presentation"><a href="#settings" data-toggle="tab">درخواست ها</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="Question">
                                    <div class="table-responsive">
                                        <table style="width: 100%;" id="posts" class="table table-striped table-hover dataTable js-exportable">
                                            <thead>
                                            <tr>
                                                <th style="padding: 0;background-image: none;">
                                                    <input value="0" name="" type="checkbox" id="check_All" class="filled-in chk-col-light-blue">
                                                    <label style="margin: 10px 10px 0 0;" for="check_All"></label>
                                                </th>
                                                <th>کاربر</th>
                                                <th>عنوان درخواست</th>
                                                <th>متن درخواست</th>
                                                <th>تاریخ ثبت</th>
                                                <th>فعالیت ها</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($complains as $complain)
                                                @if($complain->CaseTypeCode=="سوال")
                                                <tr id="post{{$complain->id}}">
                                                    <td style="padding: 0;">
                                                        <input name="delete" type="checkbox" id="md_checkbox_{{$complain->id}}" value="{{$complain->id}}" class="filled-in chk-col-light-blue checkBox">
                                                        <label style="margin: 10px 10px 0 0;" for="md_checkbox_{{$complain->id}}"></label>
                                                    </td>
                                                    <td><a href="/admin/users/{{$complain->user_id}}/edit">{{$complain->user->name.' '.$complain->user->family}}</a></td>
                                                    <td>{{$complain->title}}</td>
                                                    <td>{{$complain->Message}}</td>
                                                    <td>{{Verta::instance($complain->created_at)}}</td>
                                                    <td>
                                                        @can('complains_delete')
                                                            <button onclick="delete_complain(this,'{{$complain->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
                                                                <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                                حذف</button>
                                                        @endcan

                                                        @can('complains_show')
                                                                <button type="button" data-id="{{$complain->id}}" class="btn bg-light-blue waves-effect defaultModal" style="padding: 1px 5px;margin-bottom: 5px" title="مشاهده" data-toggle="modal" data-target="#defaultModal"><i class="material-icons" style="font-size: 15px;">mode_edit</i>مشاهده</button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile">
                                    <div class="table-responsive">
                                        <table style="width: 100%;" id="posts2" class="table table-striped table-hover dataTable js-exportable">
                                            <thead>
                                            <tr>
                                                <th style="padding: 0;background-image: none;">
                                                    <input value="0" name="" type="checkbox" id="check_All" class="filled-in chk-col-light-blue">
                                                    <label style="margin: 10px 10px 0 0;" for="check_All"></label>
                                                </th>
                                                <th>کاربر</th>
                                                <th>عنوان درخواست</th>
                                                <th>متن درخواست</th>
                                                <th>تاریخ ثبت</th>
                                                <th>فعالیت ها</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($complains as $complain)
                                                @if($complain->CaseTypeCode=="شکایت")
                                                    <tr id="post{{$complain->id}}">
                                                        <td style="padding: 0;">
                                                            <input name="delete" type="checkbox" id="md_checkbox_{{$complain->id}}" value="{{$complain->id}}" class="filled-in chk-col-light-blue checkBox">
                                                            <label style="margin: 10px 10px 0 0;" for="md_checkbox_{{$complain->id}}"></label>
                                                        </td>
                                                        <td><a href="/admin/users/{{$complain->user_id}}/edit">{{$complain->user->name.' '.$complain->user->family}}</a></td>
                                                        <td>{{$complain->title}}</td>
                                                        <td>{{$complain->Message}}</td>
                                                        <td>{{Verta::instance($complain->created_at)}}</td>
                                                        <td>
                                                            @can('complains_delete')
                                                                <button onclick="delete_complain(this,'{{$complain->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
                                                                    <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                                    حذف</button>
                                                            @endcan

                                                            @can('complains_show')
                                                                <button type="button" data-id="{{$complain->id}}" class="btn bg-light-blue waves-effect defaultModal" style="padding: 1px 5px;margin-bottom: 5px" title="مشاهده" data-toggle="modal" data-target="#defaultModal"><i class="material-icons" style="font-size: 15px;">mode_edit</i>مشاهده</button>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages">
                                    <div class="table-responsive">
                                        <table style="width: 100%;" id="posts3" class="table table-striped table-hover dataTable js-exportable">
                                            <thead>
                                            <tr>
                                                <th style="padding: 0;background-image: none;">
                                                    <input value="0" name="" type="checkbox" id="check_All" class="filled-in chk-col-light-blue">
                                                    <label style="margin: 10px 10px 0 0;" for="check_All"></label>
                                                </th>
                                                <th>کاربر</th>
                                                <th>عنوان درخواست</th>
                                                <th>متن درخواست</th>
                                                <th>تاریخ ثبت</th>
                                                <th>فعالیت ها</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($complains as $complain)
                                                @if($complain->CaseTypeCode=="پیشنهاد/انتقاد")
                                                    <tr id="post{{$complain->id}}">
                                                        <td style="padding: 0;">
                                                            <input name="delete" type="checkbox" id="md_checkbox_{{$complain->id}}" value="{{$complain->id}}" class="filled-in chk-col-light-blue checkBox">
                                                            <label style="margin: 10px 10px 0 0;" for="md_checkbox_{{$complain->id}}"></label>
                                                        </td>
                                                        <td><a href="/admin/users/{{$complain->user_id}}/edit">{{$complain->user->name.' '.$complain->user->family}}</a></td>
                                                        <td>{{$complain->title}}</td>
                                                        <td>{{$complain->Message}}</td>
                                                        <td>{{Verta::instance($complain->created_at)}}</td>
                                                        <td>
                                                            @can('complains_delete')
                                                                <button onclick="delete_complain(this,'{{$complain->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
                                                                    <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                                    حذف</button>
                                                            @endcan

                                                            @can('complains_show')
                                                                <button type="button" data-id="{{$complain->id}}" class="btn bg-light-blue waves-effect defaultModal" style="padding: 1px 5px;margin-bottom: 5px" title="مشاهده" data-toggle="modal" data-target="#defaultModal"><i class="material-icons" style="font-size: 15px;">mode_edit</i>مشاهده</button>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="settings">
                                    <div class="table-responsive">
                                        <table style="width: 100%;" id="posts4" class="table4 table-striped table-hover dataTable js-exportable">
                                            <thead>
                                            <tr>
                                                <th style="padding: 0;background-image: none;">
                                                    <input value="0" name="" type="checkbox" id="check_All" class="filled-in chk-col-light-blue">
                                                    <label style="margin: 10px 10px 0 0;" for="check_All"></label>
                                                </th>
                                                <th>کاربر</th>
                                                <th>عنوان درخواست</th>
                                                <th>متن درخواست</th>
                                                <th>تاریخ ثبت</th>
                                                <th>فعالیت ها</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($complains as $complain)
                                                @if($complain->CaseTypeCode=="درخواست")
                                                    <tr id="post{{$complain->id}}">
                                                        <td style="padding: 0;">
                                                            <input name="delete" type="checkbox" id="md_checkbox_{{$complain->id}}" value="{{$complain->id}}" class="filled-in chk-col-light-blue checkBox">
                                                            <label style="margin: 10px 10px 0 0;" for="md_checkbox_{{$complain->id}}"></label>
                                                        </td>
                                                        <td><a href="/admin/users/{{$complain->user_id}}/edit">{{$complain->user->name.' '.$complain->user->family}}</a></td>
                                                        <td>{{$complain->title}}</td>
                                                        <td>{{$complain->Message}}</td>
                                                        <td>{{Verta::instance($complain->created_at)}}</td>
                                                        <td>
                                                            @can('complains_delete')
                                                                <button onclick="delete_complain(this,'{{$complain->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
                                                                    <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                                    حذف</button>
                                                            @endcan

                                                            @can('complains_show')
                                                                <button type="button" data-id="{{$complain->id}}" class="btn bg-light-blue waves-effect defaultModal" style="padding: 1px 5px;margin-bottom: 5px" title="مشاهده" data-toggle="modal" data-target="#defaultModal"><i class="material-icons" style="font-size: 15px;">mode_edit</i>مشاهده</button>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endif
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
        </div>
    </div>


    <div class="modal fade " id="defaultModal" tabindex="-1" role="dialog" style="display: none; padding-right: 17px;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel" style="float: right"></h4>
                    <span id="complain-date" style="float: left"></span>
                </div>
                <form method="post" id="from-modal">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 modal-title">
                            <span>نوع درخواست:</span>
                            <span id="CaseTypeCode"></span>
                        </div>
                        <div class="col-md-12 modal-title">
                            <span>عنوان درخواست:</span>
                            <span id="complain-title"></span>
                        </div>
                        <div class="col-md-12 modal-title">
                            <span>متن درخواست:</span>
                            <span id="complain-Message"></span>
                        </div>
                        <div class="col-md-12 modal-title" style="display: flex">
                            <span style="line-height: 37px;">وضعیت:</span>
                            <select name="status" style="float: right" class="form-control show-tick">
                                <option value="SEEN">برسی شد</option>
                                <option value="Waiting">در انتظار بررسی</option>
                            </select>

                        </div>

                        <div class="col-md-12 modal-title">
                            <span class="card-inside-title">پاسخ</span>
                            <div class="row clearfix">
                                <input name="id-complain" value="" type="hidden">
                                <input name="user_id" value="" type="hidden">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea name="answer" rows="3" class="form-control no-resize" placeholder="پاسخ خود را بنویسید"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: left;margin-top: 100px;">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">لغو</button>
                        <button type="button" id="save-modal" class="btn btn-link waves-effect">ذخیره</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- #END# Hover Rows -->
@endsection

@section('script_link')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
@endsection


@section('script')
    <script>

        $('.defaultModal').click(function () {
           var item=this;
           var id=$(item).attr('data-id');
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('complain.complain-details')}}';
            var data = {_token: CSRF_TOKEN, id: id};
            $.post(url, data, function (msg) {
                $('#defaultModalLabel').text(msg.name);
                $('#CaseTypeCode').text(msg.CaseTypeCode);
                $('#complain-title').text(msg.title);
                $('#complain-Message').text(msg.Message);
                $('input[name=id-complain]').val(msg.id);
                $('input[name=user_id]').val(msg.user_id);
                $('#complain-date').text(msg.created_at);
                $('textarea[name=answer]').val(msg.answer);
                if (msg.status=="SEEN"){
                    $('ul.dropdown-menu li:first-child').addClass('selected');
                    $('ul.dropdown-menu li:last-child').removeClass('selected');
                    $(".dropdown-toggle").attr('title','برسی شد');
                    $(".dropdown-toggle span:first-child").text('برسی شد')
                }else {
                    $('ul.dropdown-menu li:last-child').addClass('selected');
                    $('ul.dropdown-menu li:first-child').removeClass('selected');
                    $(".dropdown-toggle").attr('title','در انتظار بررسی');
                    $(".dropdown-toggle span:first-child").text('در انتظار بررسی')
                }

            });
        });

        $('#save-modal').click(function () {
            var data_val=$('#from-modal').serializeArray();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('complain.complain-save-details')}}';
            var data = {_token: CSRF_TOKEN, data_val: data_val};
            $.post(url, data, function (msg) {
                console.log(msg)
               $('#defaultModal').removeClass('in');
               $('.modal-backdrop').remove();
               $('#defaultModal').hide();
                $.notify({
                    // options
                    message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت ذخیره شد</span>',
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
            });

        })

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
        $('#posts2').DataTable({
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
        $('#posts3').DataTable({
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
        $('#posts4').DataTable({
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
        $('#check_All').click(function(){
            if(this.checked){
                $('.checkBox').each(function(){
                    this.checked = true;
                })
            }else{
                $('.checkBox').each(function(){
                    this.checked = false;
                })
            }

        });



        function delete_complains() {
            var ChkBox=document.getElementsByClassName("checkBox");
            if ($(ChkBox).is(':checked')){
                var selectedLanguage = new Array();
                $('input[name="delete"]:checked').each(function() {
                    selectedLanguage.push(this.value);
                });
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
                        var url = '{{route('complain.delete_complains')}}';
                        var data = {_token: CSRF_TOKEN, selectedLanguage: selectedLanguage};
                        $.post(url, data, function (msg) {

                            if (msg == "deleted") {
                                selectedLanguage.forEach(function (element) {
                                    $(ChkBox).parents('#post' + element).remove()
                                });
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

                        });
                    }
                })

            }else{
                $.notify({
                    // options
                    message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> شما چیزی برای حذف انتخاب نکرده اید</span>',
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
            }

        }

        function delete_complain(tag,id) {

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
                    var url = '{{route('complain.delete_complain')}}';
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
Session::forget('posts-create');
?>
