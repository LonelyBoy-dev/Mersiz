@extends('adminbizness.layout.master')
@section('style_link')
    <link href="{{ asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <link href="{{ asset('themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <link href="{{ asset('pages/grapesjs-preset-webpage.min.css') }}" rel="stylesheet" />
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="{{ asset('pages/grapesjs-preset-webpage.min.js') }}"></script>
@endsection

@section('style')
    <style>
        [type="checkbox"]+label:before,
        [type="checkbox"]:not(.filled-in)+label:after {
            right: 0;
        }

        [type="checkbox"]+label {
            padding-right: 26px;
        }

        [type="checkbox"]:checked+label:before {
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

        .bs-caret {
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

        .card {
            box-shadow: unset;
        }

        .col-lg-4,
        .col-lg-8 {
            float: right;
        }

        .krajee-default.file-preview-frame .kv-file-content {
            width: 163px;
            height: 120px;
        }

        #somecomponent {
            width: 100%;
            height: 400px;
            border: 1px solid rgba(0, 0, 0, 0.45);
            margin: 11px 0 0 20px;
            border-radius: 5px;
        }

        @media (min-width: 1281px) {
            .popover.bottom {
                top: 1335px !important;
            }
        }

        #gjs h1,
        #gjs h2,
        #gjs h3,
        #gjs h4,
        #gjs h5,
        #gjs h6,
        #gjs span,
        #gjs a {
            font: normal normal normal 14px/1 FontAwesome !important;
        }

        .gjs-pn-panel.gjs-pn-views-container.gjs-one-bg.gjs-two-color{
            direction: ltr;
        }
  /*      .gjs-pn-options{
            right: 20% !important;
        }
        .gjs-pn-views{
            width: 20% !important;
        }
        .gjs-pn-views-container{
            width: 20% !important;
        }*/
        .gjs-pn-views-container #gjs-sm-right .gjs-field-units{
            width: 20px;
        }
        .gjs-pn-views-container .gjs-field-units button{
            padding: 5px 0;
            width: 100%;
            height: 100%;
        }
        .gjs-pn-views-container .gjs-field-units div.gjs-input-unit{
            height: 100%;
        }
        .gjs-pn-views-container .gjs-field-units  span.filter-option{
            margin: 0;
            text-align: center!important;
        }
        .bootstrap-select.btn-group .dropdown-toggle .filter-option{
            text-align: center!important;
        }
        .gjs-field-units{
            right: 14px;
        }

    </style>
@endsection

@section('Admin_content')


    <div class="col-xs-12" style="margin-bottom: 30px">
        <div>
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">textsms</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">???????????? ???????? ????????</b>
            </h2>
            <a href="{{ route('pages.index') }}" style="float: left" title="??????????"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>


    </div>

    @include('adminbizness.partial.error')
    <form action="{{ route('pages.store') }}" method="post" enctype="multipart/form-data">
        <div class="row">

            @csrf

            <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="col-lg-8 col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        ???????? ????????
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input onkeyup="convertToSlug()" type="text" id="title" name="title"
                                                        class="form-control" value="{{ old('title') }}">
                                                    <label class="form-label"> ?????????? : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" id="slug" name="slug" class="form-control"
                                                        value="{{ old('slug') }}">
                                                    <label class="form-label"> ???????? : </label>
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
                                        ??????????
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {{-- <select required id="" name="status" --}}
                                                {{-- class="selectpicker form-control show-tick"> --}}
                                                {{-- <option value="0">?????? ????????</option> --}}
                                                {{-- <option value="1">????????????</option> --}}
                                                {{-- </select> --}}
                                                {{ Form::select('status', ['DRAFT' => '?????? ????????', 'PUBLISHED' => '????????????'], ['class' => 'selectpicker form-control show-tick']) }}

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <input type="submit" value="?????????? ???????? ????????"
                                                class="btn btn-success btn-block waves-effect store_page" />
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                    </div>

                </div>

                <div class="col-lg-12 col-xs-12 col-sm-12">

                    <div class="row" style="margin-top: 8px">
                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        ???????? ?????? :
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">

                                                <div class="form-line">
                                                    {{-- <textarea id="editor1" name="content" --}}
                                                    {{-- class="form-control">{{old('content')}}</textarea> --}}

                                                    {{-- {{ Form::textarea('content', old('content'), ['class' => 'form-control', 'id'=>'gjs']) }} --}}

                                                    <div id="gjs"></div>
                                                    <textarea style="display: none" name="page"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row" style="margin-top: 8px">
                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        ??????
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-xs-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{-- <input type="text" id="seoTitle" name="seoTitle" --}}
                                                    {{-- class="form-control" value="{{old('seoTitle')}}"> --}}
                                                    {{ Form::text('seoTitle', old('seoTitle'), ['class' => 'form-control']) }}
                                                    <label class="form-label"> ?????????? ?????? : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xs-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{-- <textarea type="text" id="seoContent" name="seoContent" rows="4" --}}
                                                    {{-- class="form-control">{{old('seoContent')}}</textarea> --}}
                                                    {{ Form::textarea('seoContent', old('seoContent'), ['class' => 'form-control', 'rows' => 5]) }}
                                                    <label class="form-label"> ?????????????? ?????? : </label>
                                                </div>
                                            </div>
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
    <script type="text/javascript" src="{{ asset('js/frotel/ostan.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/frotel/city.js') }}"></script>


    <script src="{{ asset('js/plugins/piexif.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/sortable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/locales/fa.js') }}" type="text/javascript"></script>
    <script src="{{ asset('themes/fas/theme.js') }}" type="text/javascript"></script>
    <script src="{{ asset('themes/explorer-fas/theme.js') }}" type="text/javascript"></script>

@endsection

@section('script')
    {{-- <script>
        $('#somecomponent').locationpicker();
    </script> --}}
    <script type="text/javascript">

        var editor = grapesjs.init({
            container: '#gjs',

            plugins: ['gjs-preset-webpage'],
            pluginsOpts: {
                'gjs-preset-webpage': {
                    // options
                }
            }

        });
        var blockManager = editor.BlockManager;
        blockManager.add('my-first-block', {
            label: '?????????????? ???? ????????',
            content: "[b count=2]",
            removable: true,
        });

        $('.store_page').click(function () {
            var gjs=$('.gjs-frame').html();

            var InnerHtml =  editor.getHtml() + '<style>' + editor.getCss()  + '</style>';
            $('textarea[name=page]').val(InnerHtml)
        })


    </script>


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
            {{-- uploadUrl: "{{route('photos.store')}}", --}}
            // uploadExtraData:function () {
            //     return {
            //         _token:$("input[name='_token']").val()
            //     };
            // },
            allowedFileExtensions: ['jpg', 'png'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function(filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
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
            {{-- uploadUrl: "{{route('photos.store')}}", --}}
            uploadExtraData: function() {
                return {
                    _token: $("input[name='_token']").val()
                };
            },
            allowedFileExtensions: ['jpg', 'png'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function(filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
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
            {{-- uploadUrl: "{{route('photos.store')}}", --}}
            uploadExtraData: function() {
                return {
                    _token: $("input[name='_token']").val()
                };
            },
            allowedFileExtensions: ['mp4'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function(filename) {
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
                "                                                <input type=\"checkbox\" id=\"check" + i +
                "\" name=\"item_index[]\">\n" +
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
                "                                                <label class=\"form-label\"> ???????????? : </label>\n" +
                "\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"col-xs-12 col-lg-12\">\n" +
                "                                        <div class=\"form-group form-float\">\n" +
                "                                            <div class=\"form-line\" style=\"padding:0 !important;\">\n" +
                "                                                <input type=\"text\" id=\"featureValue\" name=\"featureValue[]\"\n" +
                "                                                       class=\"form-control\" >\n" +
                "                                                <label class=\"form-label\">?????????? ???????????? : </label>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "                                    </div>\n" +
                "                                </div>\n");
            i++;
        }

        function deleteRow() {
            $("DIV.product-item").each(function(index, item) {
                jQuery(':checkbox', this).each(function() {
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
            {{-- uploadUrl: "{{route('photos.store')}}", --}}
            uploadExtraData: function() {
                return {
                    _token: $("input[name='_token']").val()
                };
            },
            allowedFileExtensions: ['jpg', 'png'],
            overwriteInitial: false,
            maxFileSize: 1000,
            slugCallback: function(filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
            console.log(data);
        });

    </script>

    <script>
        function deleteRow() {
            $("DIV.product-item").each(function(index, item) {
                jQuery(':checkbox', this).each(function() {
                    if ($(this).is(':checked')) {
                        $(item).remove();
                    }
                })
            })
        }

    </script>

    <script>
        function convertToSlug() {
            var Text = $('input[name=title]').val();
            if (Text.length > 0) {
                $('input[name=slug]').parent().addClass('focused');
            } else {
                $('input[name=slug]').parent().removeClass('focused');
            }
            $('input[name=slug]').val(Text
                .toLowerCase().replace(/ /g, '-'));
        }

    </script>
@endsection
