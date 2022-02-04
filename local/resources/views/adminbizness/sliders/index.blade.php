@extends('adminbizness.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection
@section('style')
    <style>
        .card .card-inside-title {
            margin-top: 10px;
        }

        .setting {
            margin-bottom: 0 !important;
        }

        .invalid-feedback strong {
            COLOR: RED;
            FONT-SIZE: 11PX;
        }

        .slider-body {
            padding: 10px 20px 0;
        }

        .card .header {
            border: none;
            padding-bottom: 1px;
        }
    </style>
@endsection

@section('Admin_content')

    <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
        <div style="min-width: 150px">
            <h2 style="margin-top: 0">
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">photo_size_select_actual</i>
                <b style="color: #555;margin: 7px 5px 0 0;float: right;font-size: 18pt;">مدیریت اسلایدر</b>
            </h2>
        </div>

    </div>



    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                <div class="card">
                    <div class="header">
                        <h5>
                            انتخاب تصویر
                        </h5>
                        @if ($errors->has('image'))
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                 </span>
                        @endif
                    </div>
                    <form method="POST" action="{{route('sliders.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="body" style="padding: 8px">

                            <div class="row clearfix" style="display:flex;">

                                <div class="col-lg-9" style="margin-right: 30px">
                                    <input type="file" id="photos1" name="image" class="form-control file"
                                           data-overwrite-initial="false" data-theme="fas">
                                </div>

                                <div class="col-md-3">
                                    <button type="submit"
                                            class="btn bg-green waves-effect" title="افزودن جدید">
                                        <i class="material-icons">add_circle</i>
                                        <span>آپلود</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>


                </div>
                @foreach($sliders as $slider)
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 slider" style="float: right">
                        <div class="card">
                            <div class="body" style="padding: 0">
                                <div class="image">
                                    <button onclick="delete_img(this,'{{$slider->id}}')" type="button"
                                            class="btn btn-danger waves-effect" title="حذف"
                                            style="padding: 1px 5px;margin-bottom: 5px;position: absolute;top: 7px;left: 7px">
                                        <i class="material-icons" style="font-size: 15px;">delete_forever</i>
                                        حذف
                                    </button>
                                    <img width="100%" height="186" src="{{asset($slider->imgPath)}}">
                                </div>
                                <div class="slider-body">
                                    <div class="row clearfix">
                                        <div class="col-sm-12" style="margin-bottom: 0">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" onblur="setTitle(this,{{$slider->id}})"
                                                           name="link" class="form-control"
                                                           placeholder="عنوان را وارد کنید" value="{{$slider->title}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" onblur="setText(this,{{$slider->id}})"
                                                           name="link" class="form-control"
                                                           placeholder="توضیحات را وارد کنید" value="{{$slider->text}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" onblur="setLink(this,{{$slider->id}})"
                                                           name="link" class="form-control"
                                                           placeholder="لینک را وارد کنید" value="{{$slider->link}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" onblur="setAlt(this,{{$slider->id}})"
                                                           name="link" class="form-control"
                                                           placeholder="عنوان تصویر را وارد کنید(alt)" value="{{$slider->alt}}">
                                                </div>
                                            </div>
                                        {{--    <div class="form-group form-float">
                                                <label>موقعیت</label>
                                                <select required id="position" onchange="change_position(this,{{$slider->id}})"
                                                        name="position"
                                                        class="selectpicker form-control show-tick">
                                                    <option value="" @if($slider->position=="")selected @endif>بدون موقیعت</option>
                                                    <option value="top" @if($slider->position=="top")selected @endif>بنر بالا</option>
                                                    <option value="center" @if($slider->position=="center")selected @endif>بنر وسط</option>
                                                    <option value="bottom" @if($slider->position=="bottom")selected @endif>بنر پایین</option>
                                                </select>
                                            </div>--}}

                                            <div class="form-group form-float">
                                                <label>وضعیت</label>
                                                <select required id="status" onchange="change_status(this,{{$slider->id}})"
                                                        name="status"
                                                        class="selectpicker form-control show-tick">
                                                    <option value="DontShow" @if($slider->status=="DontShow")selected @endif>نمایش داده نشود</option>
                                                    <option value="Show" @if($slider->status=="Show")selected @endif>نمایش داده شود</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
@endsection


@section('script_link')
@endsection

@section('script')

    <script>
        @if(session('img-create'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('img-create')}}</span>',
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
    <script>
        function delete_img(tag, id) {

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
                    var url = '{{route('slider.delete_image_slider')}}';
                    var data = {_token: CSRF_TOKEN, id: id};
                    $.post(url, data, function (msg) {
                        if (msg == "deleted") {
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
                        $(tag).parents('.slider').remove();
                    });
                }
            })

        }
    </script>
    <script>
        function setTitle(tag, id) {
            var link = $(tag).val();
            if (link != "") {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('slider.set_Title_slider')}}';
                var data = {_token: CSRF_TOKEN, id: id, link: link};
                $.post(url, data, function (msg) {
                    if (msg == "ok") {
                        $.notify({
                            // options
                            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت ثبت شد</span>',
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
        }

        function setText(tag, id) {
            var link = $(tag).val();
            if (link != "") {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('slider.set_Text_slider')}}';
                var data = {_token: CSRF_TOKEN, id: id, link: link};
                $.post(url, data, function (msg) {
                    if (msg == "ok") {
                        $.notify({
                            // options
                            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت ثبت شد</span>',
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
        }


        function setLink(tag, id) {
            var link = $(tag).val();
            if (link != "") {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('slider.set_link_slider')}}';
                var data = {_token: CSRF_TOKEN, id: id, link: link};
                $.post(url, data, function (msg) {
                    if (msg == "ok") {
                        $.notify({
                            // options
                            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت ثبت شد</span>',
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
        }

         function setAlt(tag, id) {
            var link = $(tag).val();
            if (link != "") {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('slider.set_alt_slider')}}';
                var data = {_token: CSRF_TOKEN, id: id, link: link};
                $.post(url, data, function (msg) {
                    if (msg == "ok") {
                        $.notify({
                            // options
                            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت ثبت شد</span>',
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
        }

        function change_status(tag, id) {
            var status = $(tag).val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('slider.set_status_slider')}}';
            var data = {_token: CSRF_TOKEN, id: id, status: status};
            $.post(url, data, function (msg) {
                if (msg == "ok") {
                    $.notify({
                        // options
                        message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت ثبت شد</span>',
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
        function change_position(tag, id) {
            var position = $(tag).val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('slider.set_position_slider')}}';
            var data = {_token: CSRF_TOKEN, id: id, position: position};
            $.post(url, data, function (msg) {
                if (msg == "ok") {
                    $.notify({
                        // options
                        message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> با موفقیت ثبت شد</span>',
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
    </script>
@endsection
<?php
Session::forget('img-create');
?>

