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
        .close{
            padding: 0;
            position: absolute;
            left: 0;
            top: 0;
        }

        [type="checkbox"] + label:before, [type="checkbox"]:not(.filled-in) + label:after {
            right: 0;
        }
        [type="checkbox"] + label {
            padding-right: 26px;
        }
        [type="checkbox"]:checked + label:before {
            right: 9px;
        }
        .bootstrap-tagsinput .tag [data-role="remove"]:after {
            font-family: Arial;
        }
        .file-drop-zone-title {
            font-size: 0.8em;
            padding: 26px 10px;
        }
        .file-preview {
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 10px;
            padding: 0 10px;
        }
        .bootstrap-select.btn-group .dropdown-toggle .filter-option {
            text-align: right;
        }
        .bs-caret{
            display: none;
        }
        .card .body .col-lg-12 {
            margin-bottom: unset;
        }
        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 100%;
        }
        .card .header {
            padding: 6px 14px;
            border-bottom: 2px solid #61c579;
        }
        .card{
            box-shadow: unset;
        }
        .col-lg-4,.col-lg-8{
            float: right;
        }


    </style>
@endsection

@section('Admin_content')

    @include('adminbizness.partial.error')
    <div class="col-xs-12 head" style="margin-bottom: 20px;display: flex;justify-content: space-between">
        <div style="width: 100%">
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">list</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">???????????? ?????????? ????????</b>
            </h2>
            <a href="{{route('attribute.index')}}" style="float: left" title="??????????"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>
    </div>
    <form action="{{route('attribute.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-xs-12">
                @if(session('insertcategory'))
                    <div class="alert alert-dismissible" role="alert" style="background-color: #61c579;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button>
                        {{session('insertcategory')}}
                    </div>
                @endif

                <?php
                session()->forget('insertcategory');
                ?>
            </div>

            <div class="col-lg-12 col-xs-12 col-sm-12 ali-flex" >

                <div class="col-lg-8 col-xs-12 col-sm-12 ali-margin-0" style="margin-left: 8px;display: inline-table">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 " style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    ?????????? ????????
                                </h5>
                            </div>
                            <div class="body">
                                <div class="col-xs-12 col-lg-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input onkeyup="convertToSlug()" type="text" id="title" name="title"
                                                   class="form-control" value="{{old('title')}}">
                                            <label class="form-label"> ?????????? : </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-lg-12 value"  style="padding-right: 50px">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="value[]" class="form-control" placeholder="??????????" value="{{old('value')}}">

                                        </div>
                                    </div>
                                </div>
                                <button onclick="add_value()" style="margin-bottom: 10px" type="button" class="btn bg-blue waves-effect">
                                    <i class="material-icons">library_add</i>
                                    <span>?????????? ????????</span>
                                </button>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="col-lg-4 col-xs-12 col-sm-12" style="margin-right: 0">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                            <div class="body">
                                <div class="col-lg-12" style="display: grid">
                                    <input type="submit" value="?????????? ??????????" style="padding: 5px;border-radius: 0;margin-bottom: 14px" class="btn btn-success waves-effect"/>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    ?????????? ???? ???????? ??????????????
                                </h5>
                            </div>
                            <div class="body">
                                <div class="form-group form-float">
                                    <select required id="status" name="inshop"
                                            class="selectpicker form-control show-tick">
                                        <option value="NO">?????????? ???????? ????????</option>
                                        <option value="YES">?????????? ???????? ??????</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding: 0">
                            <div class="card" style="padding-bottom: 10px;">
                                <div class="header" style="margin-bottom: 10px;">
                                    <h5>
                                        ???????? ????????
                                    </h5>
                                </div>
                                <div class="body scroll" style="height: 200px">
                                    <div class="form-group form-float">
                                        <div class="">
                                            @foreach($categories as $category)
                                                <div class="col-lg-12">
                                                    {{ Form::checkbox('checkbox[]', $category->id, false, ['class' => 'form-control chk-col-green', 'id'=>$category->id]) }}
                                                    {{--                                                <input type="checkbox" id="{{$category->id}}" name="checkbox[]" value="{{$category->id}}">--}}
                                                    <label for="{{$category->id}}">{{$category->title}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="card" style="padding-bottom: 10px;margin: 0;box-shadow: none">
                                <div class="header" style="margin-bottom: 10px;">
                                    <h5>
                                        ???????? ????????
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <select class="form-control show-tick" name="category">
                                                <option>???????????? ????????</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="body scroll" style="height: 200px">
                                    <div class="form-group form-float">
                                        <div class="">
                                            @foreach($categories as $category)
                                                <div class="col-lg-12">
                                                    {{ Form::checkbox('checkbox[]', $category->id, false, ['class' => 'form-control chk-col-green', 'id'=>$category->id]) }}
                                                                                                    <input type="checkbox" id="{{$category->id}}" name="checkbox[]" value="{{$category->id}}">
                                                    <label for="{{$category->id}}">{{$category->title}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

    <div class="col-xs-12 head" style="margin-bottom: 20px;display: flex;justify-content: space-between">
        <div style="width: 100%">

        </div>
    </div>


    <script>
        function convertToSlug()
        {
            var Text=$('input[name=title]').val();
            if(Text.length > 0){
                $('input[name=slug]').parent().addClass('focused');
            }else{
                $('input[name=slug]').parent().removeClass('focused');
            }
            $('input[name=slug]').val(Text
                .toLowerCase().replace(/ /g,'-'));
        }
    </script>




@endsection

@section('script_link')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
@endsection

@section('script')
    <script>
        function add_value() {
            $('.value').append('<div class="form-group form-float"><div class="form-line "><input type="text" name="value[]" class="form-control" placeholder="??????????" value="{{old('value')}}"> <button type="button" class="btn bg-pink waves-effect waves-light close"><i class="material-icons">close</i></button></div></div>')
            $('.close').click(function () {
                $(this).parents('.form-group').remove();
            })
        }

    </script>
    <script>
        @if(session('categories-create'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('categories-create')}}</span>',
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
                "sEmptyTable": "?????? ??????????????? ???? ???????? ???????? ??????????",
                "sInfo": "?????????? _START_ ???? _END_ ???? _TOTAL_ ????????",
                "sInfoEmpty": "?????????? 0 ???? 0 ???? 0 ????????",
                "sInfoFiltered": "(?????????? ?????? ???? _MAX_ ????????)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "?????????? _MENU_ ????????",
                "sLoadingRecords": "???? ?????? ????????????????...",
                "sProcessing": "???? ?????? ????????????...",
                "sSearch": "??????????:",
                "sZeroRecords": "???????????? ???? ?????? ???????????? ???????? ??????",
                "oPaginate": {
                    "sFirst": "????????????? ????????",
                    "sLast": "????????????? ??????",
                    "sNext": "????????",
                    "sPrevious": "????????"
                },
                "oAria": {
                    "sSortAscending": ": ???????? ???????? ?????????? ???? ???????? ??????????",
                    "sSortDescending": ": ???????? ???????? ?????????? ???? ???????? ??????????"
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
                    text: " ?????? ???? ?????? ?????? ???????? ?????????????? ?????????? ??",
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
                    confirmButtonText: '?????? ?????? ????',
                    cancelButtonText: '??????',

                }).then((result) => {
                    if (result.value) {
                        var CSRF_TOKEN = '{{ csrf_token() }}';
                        var url = '{{route('post.delete_products_Categories')}}';
                        var data = {_token: CSRF_TOKEN, selectedLanguage: selectedLanguage};
                        $.post(url, data, function (msg) {

                            if (msg == "deleted") {
                                selectedLanguage.forEach(function (element) {
                                    $(ChkBox).parents('#post' + element).remove()
                                });
                                $.notify({
                                    // options
                                    message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> ???? ???????????? ?????? ????</span>',
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
                                    message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right">  ???????? ???????? ???????? ???? ?????????? ?????? ???????? ?????????? ?????? ??????????</span>',
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
                    message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> ?????? ???????? ???????? ?????? ???????????? ?????????? ??????</span>',
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
                text: " ?????? ???? ?????? ?????? ???????? ?????????????? ?????????? ??",
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
                confirmButtonText: '?????? ?????? ????',
                cancelButtonText: '??????',

            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = '{{ csrf_token() }}';
                    var url = '{{route('post.delete_product_Category')}}';
                    var data = {_token: CSRF_TOKEN, id: id};
                    $.post(url, data, function (msg) {
                        if (msg=="deleted"){
                            $.notify({
                                // options
                                message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> ???? ???????????? ?????? ????</span>',
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
                                message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> ?????? ???????? ???????? ?????????? ?????? ???????? ???? ????????</span>',
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
Session::forget('categories-create');
?>
