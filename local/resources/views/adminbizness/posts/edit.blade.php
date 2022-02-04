@extends('adminbizness.layout.master')
@section('style_link')
    <link href="{{asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <script src="{{asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <link href="{{asset('themes/explorer-fas/theme.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>

    <!-- PersianDateTimePicker Css-->
    <link href="{{asset('js/plugins/jalali-date/jquery.Bootstrap-PersianDateTimePicker.css')}}" media="all"
          rel="stylesheet" type="text/css"/>
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
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">textsms</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">ویرایش مطلب</b>
            </h2>
            <a href="{{route('posts.index')}}" style="float: left" title="برگشت"> <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>
        </div>


    </div>


    @include('adminbizness.partial.error')
    {!! Form::model($post, ['method' => 'PATCH', 'action' => ['Admin\AdminPostsController@update', $post->id], 'files' => true]) !!}
        <div class="row">

            @csrf

            <div class="col-lg-12 col-xs-12 col-sm-12">

                <div class="col-lg-8 col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                       باکس مطلب
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input onkeyup="convertToSlug()" type="text" id="title" name="title"
                                                           class="form-control" value="@if(old('title')==""){{$post->title}}@else{{old('title')}} @endif">
                                                    <label class="form-label"> عنوان : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" id="slug" name="slug"
                                                           class="form-control" value="@if(old('slug')==""){{$post->slug}}@else{{old('slug')}} @endif">
                                                    <label class="form-label"> نامک : </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <label class="form-label"> توضیحات : </label>
                                                <div class="form-line">
                                                    {{--                                        <textarea id="editor1" name="content"--}}
                                                    {{--                                                  class="form-control">{{old('content')}}</textarea>--}}

                                                    {{ Form::textarea('content', old('content'), ['class' => 'form-control', 'id'=>'editor1']) }}

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xs-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{--                                        <textarea type="text" id="shortContent" name="shortContent" rows="4"--}}
                                                    {{--                                                  class="form-control">{{old('shortContent')}}</textarea>--}}
                                                    {{ Form::textarea('shortContent', old('shortContent'), ['class' => 'form-control', 'rows' => 5]) }}
                                                    <label class="form-label">  شرح مختصر(توضیحی کوتاه از نوشته ) : </label>
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
                                        سئو
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-xs-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{--                                                <input type="text" id="seoTitle" name="seoTitle"--}}
                                                    {{--                                                       class="form-control" value="{{old('seoTitle')}}">--}}
                                                    {{ Form::text('seoTitle', old('seoTitle'), ['class' => 'form-control']) }}
                                                    <label class="form-label"> عنوان سئو : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xs-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{--                                        <textarea type="text" id="seoContent" name="seoContent" rows="4"--}}
                                                    {{--                                                  class="form-control">{{old('seoContent')}}</textarea>--}}
                                                    {{ Form::textarea('seoContent', old('seoContent'), ['class' => 'form-control', 'rows' => 5]) }}
                                                    <label class="form-label"> توضیحات سئو : </label>
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                    <div class="col-lg-12 col-xs-12">--}}
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label class="form-label"> برچسب ها : </label>--}}
                                        {{--                                            <div class="form-line">--}}
                                        {{--                                                <input type="text" id="tags" name="tags" data-role="tagsinput"--}}
                                        {{--                                                       class="form-control" value="{{old('tags')}}">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                    </div>--}}
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
                                                {{ Form::select('status', ['DRAFT' => 'پیش نویس', 'PUBLISHED' => 'انتشار'],$post->status, ['class' => 'selectpicker form-control show-tick']) }}

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <input type="submit" value="ویرایش مطلب" class="btn btn-success btn-block waves-effect"/>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        دسته بندی
                                    </h5>
                                </div>
                                <div class="body ">
                                    <div class="form-group">
                                        <div class="row clearfix">
                                            @foreach($categories as $category)
                                                <div class="col-lg-12">
                                                    <input <?php
                                                           foreach ($category_product as $category_id){
                                                               if ($category->id == $category_id->id){
                                                                   echo 'checked';
                                                               }
                                                           }
                                                           ?>
                                                           type="checkbox" id="{{$category->id}}" name="checkbox[]" value="{{$category->id}}">
                                                    <label for="{{$category->id}}">{{$category->title}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        تصویر شاخص محصول
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12">
                                            {{ Form::file('image', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'photos1', 'data-theme'=>'fas']) }}

                                            {{--                                        <input type="file" id="photos1" name="image" class="form-control file" data-overwrite-initial="false" data-theme="fas">--}}
                                        </div>
                                        @if($post->imgName!="")
                                            <div class="col-lg-12">
                                                <img width="250px" height="130px" style="max-height: 250px" class="img-fluid" src="{{asset($post->imgPath)}}" alt="">
                                            </div>
                                            @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>


        </div>
    {!! Form::close() !!}


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
    <script>
        function set_state_name() {
            var ostan_name=$('#ostan option:selected').text();
            var city_name=$('#city option:selected').text();
            $('input[name=cityName]').val(city_name);
            $('input[name=stateName]').val(ostan_name);
        }
        loadOstan('ostan');

        $("#ostan").change(function(){
            var i=$(this).find('option:selected').val();
            ldMenu(i,'city');
            $('.selectpicker').selectpicker('refresh');
        });


        $('#ostan option').each(function (index) {

                <?php
                if(old('state')==""){
                    $state=$post->stateId;
                }else{
                    $state=old('state');
                }

                ?>
            var value_ostan = $(this).val();
            var state = '{{$state}}';
            if (value_ostan == state) {
                $(this).attr('selected', 'selected');
                ldMenu(value_ostan, 'city');

            }


        });

        $('.city option').each(function (index) {
                <?php
                if(old('city')==""){
                    $city=$post->cityId;
                }else{
                    $city=old('city');
                }

                ?>
            var city ='{{$city}}';
            var city_value = $(this).val();
            if (city_value == city) {
                $(this).attr('selected','selected');
                $('.selectpicker').selectpicker('refresh');
            }
        });



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
