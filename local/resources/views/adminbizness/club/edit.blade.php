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
    <div class="col-xs-12 head" style="margin-bottom: 20px;display: flex;justify-content: space-between">
        <div style="width: 100%">
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">list</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">ویرایش دسته </b>
            </h2>
            <a href="{{route('categories.index')}}" style="float: left" title="برگشت"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>
    </div>
    {!! Form::model($category, ['method' => 'PATCH', 'action' => ['Admin\AdminCategoriesController@update', $category->id], 'files' => true]) !!}
        <div class="row">
            <div class="col-xs-12">
                @include('adminbizness.partial.error')

                @if(session('updatecategory'))
                    <div class="alert alert-dismissible" role="alert" style="background-color: #61c579;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        {{session('updatecategory')}}
                    </div>
                @endif

                <?php
                session()->forget('updatecategory');
                ?>
            </div>

            <div class="col-lg-12 col-xs-12 col-sm-12 ali-flex" >

                <div class="col-lg-8 col-xs-12 col-sm-12 ali-margin-0" style="margin-left: 8px;display: inline-table">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 " style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    ویرایش دسته
                                </h5>
                            </div>
                            <div class="body">
                                <div class="col-xs-12 col-lg-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            {{ Form::text('title', null, ['class' => 'form-control', 'onkeyup'=>'convertToSlug()']) }}
                                            <label class="form-label"> عنوان : </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-lg-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="slug" name="slug"
                                            {{ Form::text('slug', null, ['class' => 'form-control']) }}
                                            <label class="form-label"> نامک : </label>
                                        </div>
                                    </div>
                                </div>

                                {{--                                <div class="col-lg-12 col-xs-12">--}}
                                {{--                                    <div class="form-group form-float">--}}
                                {{--                                        <div class="form-line">--}}
                                {{--                                        <textarea type="text" id="shortContent" name="shortContent" rows="4"--}}
                                {{--                                                  class="form-control">{{old('description')}}</textarea>--}}
                                {{--                                            <label class="form-label"> توضیحات دسته : </label>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                    </div>


                </div>


                <div class="col-lg-4 col-xs-12 col-sm-12" style="margin-right: 0">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                            <div class="body">
                                <div class="col-lg-12" style="display: grid">
                                    <input type="submit" value="بروزرسانی دسته"
                                           style="padding: 5px;border-radius: 0;margin-bottom: 14px"
                                           class="btn btn-success waves-effect"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    دسته مادر
                                </h5>
                            </div>
                            <div class="body">
                                <div class="form-group form-float">
                                    {{ Form::select('parent', $categories, null, ['class' => 'selectpicker form-control show-tick']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    نمایش در صفحه اصلی
                                </h5>
                            </div>
                            <div class="body">
                                <div class="form-group form-float">
                                    <select required id="status" name="showindex"
                                            class="selectpicker form-control show-tick">
                                        <option value="NO" @if($category->showindex=="NO")selected @endif>نمایش داده نشود</option>
                                        <option value="YES" @if($category->showindex=="YES")selected @endif>نمایش داده شود</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        تصویر شاخص محصول
                                    </h5>
                                </div>
                                <div class="body" style="padding: 8px">
                                    <div class="row clearfix">
                                        <div class="col-lg-12">
                                            {{ Form::file('image', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'photos1', 'data-theme'=>'fas']) }}

                                            {{--                                        <input type="file" id="photos1" name="image" class="form-control file" data-overwrite-initial="false" data-theme="fas">--}}
                                        </div>
                                        @if($category->imgName!="")
                                            <div class="col-lg-12">
                                                <img width="250px" height="130px" style="max-height: 250px" class="img-fluid" src="{{asset($category->imgPath)}}" alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{--                        <div class="col-xs-12 col-lg-12 ali-m-bottom-6 "--}}
                        {{--                             style="background: white;padding-top: 20px;margin-bottom: 14px">--}}
                        {{--                            <div class="header ali-border-b">--}}
                        {{--                                <h5>--}}
                        {{--                                    تصویر--}}
                        {{--                                </h5>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="body">--}}
                        {{--                                <div class="form-group form-float">--}}
                        {{--                                    <div class="col-lg-12" align="center">--}}
                        {{--                                            <label class="lbl-cursor" for="imgFile"--}}
                        {{--                                                   style="display: block;background: #6184e4;color: white;padding: 5px;border-radius: 0;margin-bottom: 14px">انتخاب--}}
                        {{--                                                تصویر</label>--}}
                        {{--                                        <input id="imgFile" name="imgFile" accept="image/*" type="file" style="display: none">--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                    </div>
                </div>

            </div>

        </div>

    {!! Form::close() !!}


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


    </script>


@endsection
