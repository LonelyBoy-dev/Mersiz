@extends('adminbizness.layout.master')
@section('style_link')
    <link href="{{asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <script src="{{asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <link href="{{asset('themes/explorer-fas/theme.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
@endsection

@section('style')
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
        .card{
            box-shadow: unset;
        }
        .col-lg-4,.col-lg-8{
            float: right;
        }
        .krajee-default.file-preview-frame .kv-file-content {
            width: 163px;
            height: 120px;
        }
        #somecomponent {
            width: 100%;
            height: 400px;
            border: 1px solid rgba(0,0,0,0.45);
            margin: 11px 0 0 20px;
            border-radius: 5px;
        }
        @media (min-width: 1281px){
            .popover.bottom {
                top: 1335px !important;
            }
        }

    </style>
@endsection

@section('Admin_content')


    <div class="col-xs-12" style="margin-bottom: 30px">
        <div>
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">question_answer</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">افزودن سوالات متداول</b>
            </h2>
            <a href="{{route('faq.index')}}" style="float: left" title="برگشت"> <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>


    </div>

    @include('adminbizness.partial.error')
    <form action="{{route('faq.store')}}" method="post" enctype="multipart/form-data">
    <div class="row">

            @csrf

            <div class="col-lg-12 col-xs-12 col-sm-12">

                <div class="col-lg-8 col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        باکس سوال
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input onkeyup="convertToSlug()" type="text" id="title" name="Question"
                                                           class="form-control" value="{{old('Question')}}">
                                                    <label class="form-label"> عنوان سوال: </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <label class="form-label"> جواب : </label>
                                                <div class="form-line">
                                                    {{--                                        <textarea id="editor1" name="content"--}}
                                                    {{--                                                  class="form-control">{{old('content')}}</textarea>--}}

                                                    {{ Form::textarea('Answer', old('Answer'), ['class' => 'form-control', 'id'=>'editor1']) }}

                                                </div>
                                            </div>
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
                                                {{--                                                <select required id="" name="status"--}}
                                                {{--                                                        class="selectpicker form-control show-tick">--}}
                                                {{--                                                    <option value="0">پیش نویس</option>--}}
                                                {{--                                                    <option value="1">انتشار</option>--}}
                                                {{--                                                </select>--}}
                                                {{ Form::select('status', ['DRAFT' => 'پیش نویس', 'PUBLISHED' => 'انتشار'], ['class' => 'selectpicker form-control show-tick']) }}

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <input type="submit" value="ایجاد نوشته جدید" class="btn btn-success btn-block waves-effect"/>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                    </div>

                </div>

            </div>


    </div>
    </form>


@endsection
@section('script_link')
    <script type="text/javascript" src="{{asset('js/frotel/ostan.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/frotel/city.js')}}"></script>


    <script src="{{asset('js/plugins/piexif.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/plugins/sortable.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/fileinput.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/locales/fa.js')}}" type="text/javascript"></script>
    <script src="{{asset('themes/fas/theme.js')}}" type="text/javascript"></script>
    <script src="{{asset('themes/explorer-fas/theme.js')}}" type="text/javascript"></script>

@endsection

@section('script')
{{--    <script>
        $('#somecomponent').locationpicker();
    </script>--}}

    <script>
        $("#photos").fileinput({

            showCaption: false,
            showUpload: false,
            required: false,
            theme: 'fas',
            language: 'fa',
            showBrowse: false,
            browseOnZoneClick: true,
            // request:true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            // uploadExtraData:function () {
            //     return {
            //         _token:$("input[name='_token']").val()
            //     };
            // },
            allowedFileExtensions: ['jpg', 'png'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function (event, data, previewId, index) {
            console.log(data);
        });

        $("#photos1").fileinput({

            showCaption: false,
            maxFileCount: 1,
            showUpload: false,
            required: false,
            theme: 'fas',
            language: 'fa',
            showBrowse: false,
            browseOnZoneClick: true,
            request: true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            uploadExtraData: function () {
                return {
                    _token: $("input[name='_token']").val()
                };
            },
            allowedFileExtensions: ['jpg', 'png'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function (event, data, previewId, index) {
            console.log(data);
        });

        $("#video").fileinput({

            showCaption: false,
            maxFileCount: 1,
            showUpload: false,
            required: false,
            theme: 'fas',
            language: 'fa',
            showBrowse: false,
            browseOnZoneClick: true,
            request: true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            uploadExtraData: function () {
                return {
                    _token: $("input[name='_token']").val()
                };
            },
            allowedFileExtensions: ['mp4'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function (event, data, previewId, index) {
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
                "                                                <input type=\"checkbox\" id=\"check" + i + "\" name=\"item_index[]\">\n" +
                "                                                <label for=\"check" + i + "\"></label>\n" +
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

    <script>
        $("#photos").fileinput({

            showUpload: false,
            required: false,
            theme: 'fas',
            language: 'fa',
            showBrowse: false,
            browseOnZoneClick: true,
            request: true,
            {{--uploadUrl: "{{route('photos.store')}}",--}}
            uploadExtraData: function () {
                return {
                    _token: $("input[name='_token']").val()
                };
            },
            allowedFileExtensions: ['jpg', 'png'],
            overwriteInitial: false,
            maxFileSize: 1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function (event, data, previewId, index) {
            console.log(data);
        });
    </script>

    <script>

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
