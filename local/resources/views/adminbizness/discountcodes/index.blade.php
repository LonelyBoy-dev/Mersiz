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
    </style>
@endsection

@section('Admin_content')
    <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
        <div style="min-width: 150px">
            <h2 style="margin-top: 0">
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">confirmation_number</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">کد تخفیف</b>
            </h2>
        </div>

        <div>
            <a href="{{route('discountcodes.create')}}" type="button" class="btn bg-green waves-effect" title="افزودن جدید">
                <i class="material-icons">add_circle</i>
                <span>افزودن جدید</span>
            </a>
            <button onclick="delete_products_Categories()" type="button" class="btn btn-danger waves-effect" title="حذف دسته جمعی">
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
                                <table style="width: 100%;" id="posts" class="table table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th style="padding: 0;background-image: none;">
                                            <input value="0" name="" type="checkbox" id="check_All" class="filled-in chk-col-light-blue">
                                            <label style="margin: 10px 10px 0 0;" for="check_All"></label>
                                        </th>
                                        <th>کد</th>
                                        <th>درصد تخفیف</th>
                                        <th>قابل استفاده</th>
                                        <th>تعداد استفاده شده</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>تاریخ پایان</th>
                                        <th>فعالیت ها</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($discountcodes as $discountcode)
                                        @php
                                            $applicants = App\Discountcode::where('end_date', '<', \Illuminate\Support\Carbon::now()->format('Y-m-d'))->where('id',$discountcode->id)->first();
                                        @endphp

                                        <tr id="post{{$discountcode->id}}" @if($applicants) style="background-color: #ffe2e2;position: relative" @endif>

                                            <td style="padding: 0;">
                                                <input name="delete" type="checkbox" id="md_checkbox_{{$discountcode->id}}" value="{{$discountcode->id}}" class="filled-in chk-col-light-blue checkBox">
                                                <label style="margin: 10px 10px 0 0;" for="md_checkbox_{{$discountcode->id}}"></label>
                                            </td>
                                            <td>{{$discountcode->code}}</td>
                                            <td>{{$discountcode->darsad}} % </td>
                                            <td>{{$discountcode->max}}بار</td>
                                            <td>{{$discountcode->used}}بار</td>
                                            <td>{{Verta::instance($discountcode->created_at)->format('%d %B %Y')}}</td>
                                            <td>{{Verta::instance($discountcode->end_date)->format('%d %B %Y')}}</td>
                                            <td>

                                                <button onclick="delete_product_category(this,'{{$discountcode->id}}')" type="button" class="btn btn-danger waves-effect" style="padding: 1px 5px;margin-bottom: 5px">
                                                    <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                                    حذف</button>
                                                <a href="{{route('discountcodes.edit',$discountcode->id)}}" type="button" class="btn bg-light-blue waves-effect" style="padding: 1px 5px;margin-bottom: 5px">
                                                    <i class="material-icons" style="font-size: 15px;">mode_edit</i>
                                                    <span>ویرایش</span>
                                                </a>


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
    </div>
@endsection


@section('script_link')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
@endsection

@section('script')
    <script>
        @if(session('code-create'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('code-create')}}</span>',
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



        function delete_products_Categories() {
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
                        var url = '{{route('code.delete_discountcodes')}}';
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
                            if (msg == "parent") {
                                $.notify({
                                    // options
                                    message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right">  دسته بندی هایی که دارای زیر دسته هستند حذف نشدند</span>',
                                    icon: '',
                                }, {
                                    // settings
                                    type: 'warning',
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

        function delete_product_category(tag,id) {

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
                    var url = '{{route('code.delete_discountcode')}}';
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
                            $(tag).parents('tr').remove();
                        }
                        if (msg=="parent"){
                            $.notify({
                                // options
                                message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> این دسته بندی دارای زیر دسته می باشد</span>',
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
                    });
                }
            })

        }
    </script>
@endsection

<?php
Session::forget('code-create');
?>
