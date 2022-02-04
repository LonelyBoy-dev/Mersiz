@extends('adminbizness.layout.master')

@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection
@section('style')
    <style>
        .table thead tr th,.table tbody tr td {
            text-align: center;
        }
        [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
            left: 0;
        }

        .swal2-html-container{
            display: block;
            background: red;
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
            padding: 10px;
            border-radius: 3px 3px 0 0;
            color: #fff;
            font-size: 12pt;
            font-weight: 700;
            text-align: right;
        }
        .swal2-actions{
            margin-top: 40px!important;;
        }
        [data-notify="container"] {
            width: 23%;
        }

        @media screen and (max-width: 480px) {
            .head {
                flex-direction: column;
                margin-bottom: 35px !important;
            }
            .head div:first-child {
                margin-bottom: 10px;
            }
        }
    </style>@endsection

@section('Admin_content')
    <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
        <div style="min-width: 150px">
            <h2 style="margin-top: 0">
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">shopping_basket</i>
                <b style="color: #555;margin: 8px 5px 0 0;float: right;font-size: 18pt;">محصولات</b>
            </h2>
        </div>

        <div>
            <a href="{{route('products.create')}}" type="button" class="btn bg-green waves-effect" title="افزودن جدید">
                <i class="material-icons">add_circle</i>
                <span>افزودن جدید</span>
            </a>
            <button onclick="delete_posts()" type="button" class="btn btn-danger waves-effect" title="حذف دسته جمعی">
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

                        <form>
                            <div class="table-responsive">
                                <form action="{{route('products.index')}}" method="get">
                                    <div class="col-sm-11 col-md-4" style="float: right">

                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{@$_GET['key']}}" name="key" placeholder="جستجو">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 col-md-1" style="float: right">
                                        <button type="submit" style="margin-right: -47px;margin-top: 7px;padding: 0;" class="btn btn-default waves-effect">
                                            <i class="material-icons">search</i>
                                        </button>
                                    </div>
                                </form>

                                <table style="width: 100%" id="posts" class="table table-striped">
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
                                        <td>دسته بندی</td>
                                        <td>قیمت اصلی</td>
                                        <th>تاریخ انتشار</th>
                                        <th>فعالیت ها</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($productItems as $product)
                                        <tr id="post{{$product->id}}">
                                            <td style="padding: 0;">
                                                <input name="delete" type="checkbox" id="md_checkbox_{{$product->id}}" value="{{$product->id}}" class="filled-in chk-col-light-blue checkBox">
                                                <label style="margin: 10px 10px 0 0;" for="md_checkbox_{{$product->id}}"></label>
                                            </td>
                                            <td style="width: 100px">
                                                @if($product->image)
                                                    @if(file_exists(public_path() . '/' . $product->image))
                                                        <img style="width: 80%" src="{{asset($product->image)}}">
                                                    @else
                                                        <img style="width: 80%" src="{{asset('images/nopic.png')}}">
                                                    @endif
                                                    @else
                                                    <img style="width: 80%" src="{{asset('images/nopic.png')}}">
                                                @endif
                                            </td>
                                            <td><a target="_blank" href="/product/{{$product->slug}}">{{$product->title}}</a></td>
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

                                                <button onclick="delete_post(this,'{{$product->id}}')" type="button" class="btn btn-danger waves-effect" title="حذف" style="padding: 1px 5px;margin-bottom: 5px">
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
                        </form>

                        <div style="text-align: center">
                            {{$productItems->links("pagination::bootstrap-4")}}
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


        /*$('#posts').DataTable({
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
        });*/

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
                        var url = '{{route('post.delete_products')}}';
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
                    var url = '{{route('post.delete_product')}}';
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
        @if(session('insertProduct'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('insertProduct')}}</span>',
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
Session::forget('insertProduct');
?>



