

@extends('adminbizness.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
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
                    <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">textsms</i>
                    <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">مطالب</b>
                </h2>
            </div>

            <div>
                @can('post_create')
                <a href="{{route('posts.create')}}" type="button" class="btn bg-green waves-effect" title="افزودن جدید">
                    <i class="material-icons">add_circle</i>
                    <span>افزودن جدید</span>
                </a>
                @endcan

                @can('post_delete')
                <button onclick="delete_posts()" type="button" class="btn btn-danger waves-effect" title="حذف دسته جمعی">
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
                            <form>
                                <div class="table-responsive">
                                    <table style="width: 100%;" id="posts" class="table table-striped table-hover dataTable js-exportable">
                                        <thead>
                                        <tr>
                                            <th style="padding: 0;background-image: none;">
                                                <input value="0" name="" type="checkbox" id="check_All" class="filled-in chk-col-light-blue">
                                                <label style="margin: 10px 10px 0 0;" for="check_All"></label>
                                            </th>
                                            <th style="background-image: none;">تصویر</th>
                                            <th>عنوان</th>
                                            <th>وضعیت</th>
                                            <th>بازدید</th>
                                            <th>دسته بندی</th>
                                            <th>تاریخ انتشار</th>
                                            <th>فعالیت ها</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($posts as $post)
                                            <tr id="post{{$post->id}}">
                                                <td style="padding: 0;">
                                                    <input name="delete" type="checkbox" id="md_checkbox_{{$post->id}}" value="{{$post->id}}" class="filled-in chk-col-light-blue checkBox">
                                                    <label style="margin: 10px 10px 0 0;" for="md_checkbox_{{$post->id}}"></label>
                                                </td>
                                                <td style="width: 100px">@if($post->imgName=="") بدون تصویر @else <img style="width: 100%;max-width: 100px" src="{{asset($post->imgPath)}}">@endif</td>
                                                <td>{{$post->title}}</td>
                                                <td>@if($post->status=="PUBLISHED")<span style="color: #0f9d58">منتشر شده</span> @elseif($post->status=="PENDING")<span style="color: #f39c12">انتظار</span> @else<span style="color: #03A9F4">پیش نویس</span> @endif</td>
                                                <td>{{$post->view}}</td>
                                                <td>
                                                    @foreach ($post->postcategories as $val)
                                                        <span class="label label-primary">{{$val->title}}</span>
                                                    @endforeach
                                                </td>
                                                <td>{{Verta::instance($post->created_at)}}</td>
                                                <td>
                                                    @can('post_delete')
                                                    <button onclick="delete_post(this,'{{$post->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
                                                        <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                        حذف</button>
                                                    @endcan

                                                    @can('post_edit')
                                                    <a href="{{route('posts.edit',$post->id)}}" type="button" class="btn bg-light-blue waves-effect" title="ویرایش" style="padding: 1px 5px;margin-bottom: 5px">
                                                        <i class="material-icons" style="font-size: 15px;">mode_edit</i>
                                                        <span>ویرایش</span>
                                                    </a>
                                                        @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>    </div>

    <!-- #END# Hover Rows -->
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



        function delete_posts() {
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
                        var url = '{{route('post.delete_posts')}}';
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

        function delete_post(tag,id) {

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
                    var url = '{{route('post.delete_post')}}';
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
