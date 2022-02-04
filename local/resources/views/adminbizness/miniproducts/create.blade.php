@extends('adminbizness.layout.master')

@section('Admin_content')

    <link href="{{asset('themes/explorer-fas/theme.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <style>
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
            border-bottom: 2px solid rgb(161, 129, 239);
        }
        .col-lg-8,.col-lg-4{
            float: right;
        }
        .card{
            box-shadow: unset;
        }

    </style>
    <div class="row">

        {{--    @include('adminbizness.partial.error')--}}
        <form action="{{route('miniproducts.store')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="col-lg-12 col-xs-12 col-sm-12">
                @include('adminbizness.partial.error')

                <div class="row">
                    <div class="col-lg-8 col-xs-12 col-sm-12">
                        <div class="row">
                            <div class="col-xs-12 col-lg-12">
                                <div class="card">
                                    <div class="header">
                                        <h5>
                                            ایجاد محصول
                                        </h5>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-lg-12">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        {{ Form::text('title', old('title'), ['class' => 'form-control']) }}
                                                        <label class="form-label"> عنوان محصول : </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-lg-12">
                                                <div class="form-group form-float">
                                                    <label class="form-label"> توضیحات : </label>
                                                    <div class="form-line">
                                                        {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'id'=>'editor1']) }}

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-12">
                                <div class="card">
                                    <div class="header">
                                        <h5>
                                            بارگذاری فایل اکسل
                                        </h5>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-lg-12">
                                                        {{ Form::file('import_file', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'import_file', 'data-theme'=>'fas']) }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12">
                        <div class="row">
                            <div class="col-xs-12 col-lg-12">
                                <div class="card">
                                    <div class="header">
                                        <h5>
                                            وضعیت
                                        </h5>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    {{ Form::select('status', ['0' => 'پیش نویس', '1' => 'انتشار'], ['class' => 'selectpicker form-control show-tick']) }}
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <input type="submit" value="ثبت محصول" class="btn btn-success btn-block waves-effect"/>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <div class="col-xs-12 col-lg-12">
                                <div class="card">
                                    <div class="header">
                                        <h5>
                                            دسترسی محصول
                                        </h5>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-lg-12">
                                                <div class="form-group form-float">
                                                    {{ Form::select('package', ['1' => 'پکیج یک', '2' => 'پکیج دو', '3' => 'پکیج سه', '4' => 'پکیج چهار'], ['class' => 'selectpicker form-control show-tick']) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="col-xs-12 col-lg-12">
                                <div class="card">
                                    <div class="header">
                                        <h5>
                                            لینک محصول
                                        </h5>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-lg-12">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        {{ Form::text('link', old('link'), ['class' => 'form-control']) }}
                                                        <label class="form-label"> لینک : </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-lg-12">
                                <div class="card">
                                    <div class="header">
                                        <h5>
                                            لوگوی محصول
                                        </h5>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-lg-12">
                                                {{ Form::file('image', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'image', 'data-theme'=>'fas']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h5>
                                    فایل PDF
                                </h5>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-12">
                                        {{ Form::file('pdf', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'pdf', 'data-theme'=>'fas']) }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h5>
                                    ویدئوی محصول
                                </h5>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-12">
                                        {{ Form::file('video', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'video', 'data-theme'=>'fas']) }}
                                        {{--                                        <input type="file" id="video" name="video" class="form-control file" data-overwrite-initial="false" data-theme="fas">--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h5>
                                    فایل صوتی
                                </h5>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-12">
                                        {{ Form::file('voice', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'voice', 'data-theme'=>'fas']) }}
                                        {{--                                        <input type="file" id="video" name="video" class="form-control file" data-overwrite-initial="false" data-theme="fas">--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script_link')

    <script src="{{asset('js/fileinput.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/locales/fa.js')}}" type="text/javascript"></script>
    <script src="{{asset('themes/explorer-fas/theme.js')}}" type="text/javascript"></script>
    <script src="{{asset('themes/explorer-fas/fas-theme.js')}}" type="text/javascript"></script>

    <script>

        $("#pdf").fileinput({

            showCaption:false,
            showUpload:false,
            required:false,
            theme: 'fas',
            language: 'fa',
            showBrowse:false,
            browseOnZoneClick:true,
            // request:true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            // uploadExtraData:function () {
            //     return {
            //         _token:$("input[name='_token']").val()
            //     };
            // },
            allowedFileExtensions:['pdf'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
            console.log(data);
        });

        $("#import_file").fileinput({

            showCaption:false,
            showUpload:false,
            required:false,
            theme: 'fas',
            language: 'fa',
            showBrowse:false,
            browseOnZoneClick:true,
            // request:true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            // uploadExtraData:function () {
            //     return {
            //         _token:$("input[name='_token']").val()
            //     };
            // },
            allowedFileExtensions:['xlsx'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
            console.log(data);
        });

        $("#voice").fileinput({

            showCaption:false,
            showUpload:false,
            required:false,
            theme: 'fas',
            language: 'fa',
            showBrowse:false,
            browseOnZoneClick:true,
            // request:true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            // uploadExtraData:function () {
            //     return {
            //         _token:$("input[name='_token']").val()
            //     };
            // },
            allowedFileExtensions:['mp3','ogg'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
            console.log(data);
        });

        $("#image").fileinput({

            showCaption:false,
            maxFileCount:1,
            showUpload:false,
            required:false,
            theme: 'fas',
            language: 'fa',
            showBrowse:false,
            browseOnZoneClick:true,
            request:true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            uploadExtraData:function () {
                return {
                    _token:$("input[name='_token']").val()
                };
            },
            allowedFileExtensions:['jpg', 'png'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
            console.log(data);
        });

        $("#video").fileinput({

            showCaption:false,
            maxFileCount:1,
            showUpload:false,
            required:false,
            theme: 'fas',
            language: 'fa',
            showBrowse:false,
            browseOnZoneClick:true,
            request:true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            uploadExtraData:function () {
                return {
                    _token:$("input[name='_token']").val()
                };
            },
            allowedFileExtensions:['mp4'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
            console.log(data);
        });
    </script>

    <script>
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //     }
        // });
        var i = 0;

        function addMore() {
            // $(".product-item:last").clone().insertAfter(".product-item:last");
            $(".items").append("                                <div class=\"product-item\">\n" +
                "                                    <div class=\"col-xs-12 col-lg-12\">\n" +
                "                                        <div class=\"form-group form-float\">\n" +
                "                                            <div class=\"form-line\" style=\"padding:0 !important;\">\n" +
                "                                                <input type=\"checkbox\" id=\"check"+i+"\" name=\"item_index[]\">\n" +
                "                                                <label for=\"check"+i+"\"></label>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"col-xs-12 col-lg-12\">\n" +
                "                                        <div class=\"form-group form-float\">\n" +
                "                                            <div class=\"form-line\" style=\"padding:0 !important;\">\n" +
                "\n" +
                "                                                <input type=\"text\" id=\"feature\" name=\"feature[]\"\n" +
                "                                                       class=\"form-control\" >\n" +
                "                                                <label class=\"form-label\"> خصوصیت : </label>\n" +
                "\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"col-xs-12 col-lg-12\">\n" +
                "                                        <div class=\"form-group form-float\">\n" +
                "                                            <div class=\"form-line\" style=\"padding:0 !important;\">\n" +
                "                                                <input type=\"text\" id=\"featureValue\" name=\"featureValue[]\"\n" +
                "                                                       class=\"form-control\" >\n" +
                "                                                <label class=\"form-label\">مقدار خصوصیت : </label>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "                                    </div>\n" +
                "                                </div>\n");
            i++;
        }

        function deleteRow() {
            $("DIV.product-item").each(function (index, item) {
                jQuery(':checkbox', this).each(function () {
                    if ($(this).is(':checked')) {
                        $(item).remove();
                    }
                })
            })
        }


    </script>
@endsection
