

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
                    <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">مدیریت نظرات</b>
                </h2>
            </div>

            <div>



                <button onclick="delete_comments()" type="button" class="btn btn-danger waves-effect" title="حذف دسته جمعی">
                    <i class="material-icons">delete_forever</i>
                    <span>حذف دسته جمعی</span>
                </button>

            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->

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
                                            <th>پست</th>
                                            <th>متن نظر</th>
                                            <th>تاریخ ثبت</th>
                                            <th> وضعیت</th>
                                            <th>فعالیت ها</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($comments as $comment)

                                            <tr id="post{{$comment->id}}">
                                                <td style="padding: 0;">
                                                    <input name="delete" type="checkbox" id="md_checkbox_{{$comment->id}}" value="{{$comment->id}}" class="filled-in chk-col-light-blue checkBox">
                                                    <label style="margin: 10px 10px 0 0;" for="md_checkbox_{{$comment->id}}"></label>
                                                </td>
                                                <td><a>{{@$comment->name}}</a></td>
                                                <td><a href="/post/{{@$comment->post->slug}}">{{@$comment->post->title}}</a></td>
                                                <td>{{$comment->content}}</td>
                                                <td>{{Verta::instance($comment->created_at)}}</td>
                                                <td>
                                                    @if($comment->status=="SEEN")
                                                        <span id="badge-{{$comment->id}}" class="badge bg-teal">تائید شده</span>
                                                    @elseif($comment->status=="Waiting")
                                                        <span id="badge-{{$comment->id}}" class="badge bg-orange">در انتظار تائید</span>
                                                    @elseif($comment->status=="UNSEEN")
                                                        <span id="badge-{{$comment->id}}" class="badge bg-pink">تائید نشد</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('complains_delete')
                                                        <button onclick="delete_comment(this,'{{$comment->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
                                                            <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                            حذف</button>
                                                    @endcan

                                                    @can('complains_show')
                                                        <button type="button" data-id="{{$comment->id}}" class="btn bg-light-blue waves-effect defaultModal" style="padding: 1px 5px;margin-bottom: 5px" title="مشاهده" data-toggle="modal" data-target="#defaultModal"><i class="material-icons" style="font-size: 15px;">mode_edit</i>مشاهده</button>
                                                    @endcan
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
    </div>


    <div class="modal fade " id="defaultModal" tabindex="-1" role="dialog" style="display: none; padding-right: 17px;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel" style="float: right"></h4>
                    <span id="comment-date" style="float: left"></span>
                </div>
                <form method="post" id="from-modal">
                    @csrf
                    <div class="modal-body">

                        <div class="col-md-12 modal-title">
                            <span>پست:</span>
                            <span id="comment-product-title"><a href=""></a></span>
                        </div>
                        <div class="col-md-12 modal-title">
                            <span>متن نظر:</span>
                            <span id="comment-Message"></span>
                        </div>
                        <div class="col-md-12 modal-title" style="display: flex">
                            <span style="line-height: 37px;">وضعیت:</span>
                            <select name="status" style="float: right" class="form-control show-tick">
                                <option class="SEEN" value="SEEN">تائید شد</option>
                                <option class="UNSEEN" value="UNSEEN">تائید نشد</option>
                                <option class="Waiting" value="Waiting">در انتظار بررسی</option>
                            </select>

                        </div>
                        <input name="id-comment" value="" type="hidden">
                        <!--                        <div class="col-md-12 modal-title">
                                                    <span class="card-inside-title">پاسخ</span>
                                                    <div class="row clearfix">

                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <textarea name="answer" rows="3" class="form-control no-resize" placeholder="پاسخ خود را بنویسید"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
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
            var url = '{{route('post.comment-post-details')}}';
            var data = {_token: CSRF_TOKEN, id: id};
            $.post(url, data, function (msg) {
                $('#defaultModalLabel').text(msg.name);
                $('#comment-product-title a').text(msg.product_title);
                $('#comment-product-title a').attr('href','/post/'+msg.product_slug);
                $('#comment-Message').text(msg.Message);
                $('input[name=id-comment]').val(msg.id);
                $('#comment-date').text(msg.created_at);
                $('textarea[name=answer]').val(msg.answer);
                if (msg.status=="SEEN"){
                    $('ul.dropdown-menu li a.SEEN').parent().addClass('selected');
                    $('ul.dropdown-menu li a.Waiting').parent().removeClass('selected');
                    $('ul.dropdown-menu li a.UNSEEN').parent().removeClass('selected');
                    $(".dropdown-toggle").attr('title','تائید شد');
                    $(".dropdown-toggle span:first-child").text('تائید شد')
                }else if(msg.status=="Waiting") {
                    $('ul.dropdown-menu li a.SEEN').parent().removeClass('selected');
                    $('ul.dropdown-menu li a.Waiting').parent().addClass('selected');
                    $('ul.dropdown-menu li a.UNSEEN').parent().removeClass('selected');
                    $(".dropdown-toggle").attr('title','در انتظار تائید');
                    $(".dropdown-toggle span:first-child").text('در انتظار تائید')
                }else if(msg.status=="UNSEEN") {
                    $('ul.dropdown-menu li a.SEEN').parent().removeClass('selected');
                    $('ul.dropdown-menu li a.Waiting').parent().removeClass('selected');
                    $('ul.dropdown-menu li a.UNSEEN').parent().addClass('selected');
                    $(".dropdown-toggle").attr('title','تائید نشد');
                    $(".dropdown-toggle span:first-child").text('تائید نشد')
                }

            });
        });

        $('#save-modal').click(function () {
            var data_val=$('#from-modal').serializeArray();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('post.comment-post-details-details')}}';
            var data = {_token: CSRF_TOKEN, data_val: data_val};
            $.post(url, data, function (msg) {
                $('#defaultModal').removeClass('in');
                $('.modal-backdrop').remove();
                $('#defaultModal').hide();
                console.log(msg.id)
                var text="";
                var color="";
                if (msg.status=="SEEN"){
                    text="تائید شد";
                    color="badge bg-teal";
                }else if(msg.status=="UNSEEN"){
                    text="تائید نشد";
                    color="badge bg-pink";
                }else if(msg.status=="Waiting"){
                    text="در انتظار تائید";
                    color="badge bg-orange";
                }
                $('#badge-'+msg.id).text(text);
                $('#badge-'+msg.id).attr('class',color);
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



        function delete_comments() {
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
                        var url = '{{route('comment.delete-comments-post')}}';
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

        function delete_comment(tag,id) {

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
                    var url = '{{route('comment.delete-comment-post')}}';
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
