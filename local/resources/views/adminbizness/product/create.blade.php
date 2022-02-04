@extends('adminbizness.layout.master')
@section('style_link')
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

    </style>
@endsection

@section('Admin_content')

    <div class="col-xs-12 head" style="margin-bottom: 20px;display: flex;justify-content: space-between">
        <div style="width: 100%">
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">add_shopping_cart</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">افزودن محصول جدید</b>
            </h2>
            <a href="{{route('products.index')}}" style="float: left" title="برگشت"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>
    </div>
    <div class="row">
        {{--    @include('adminbizness.partial.error')--}}
        <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="col-xs-12">
                    @include('adminbizness.partial.error')


                </div>

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
                                            <div class="form-group form-float ">
                                                <div class="form-line">
                                                    {{--                                                <input type="text" id="title" name="title"--}}
                                                    {{--                                                       class="form-control" value="{{old('title')}}">--}}
                                                    {{ Form::text('title', old('title'), ['class' => 'form-control', 'onkeyup'=>'convertToSlug()']) }}
                                                    <label class="form-label"> عنوان : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float ">
                                                <div class="form-line">
                                                    {{--                                                <input type="text" id="slug" name="slug"--}}
                                                    {{--                                                       class="form-control" value="{{old('slug')}}">--}}
                                                    {{ Form::text('slug', old('slug'), ['class' => 'form-control']) }}
                                                    <label class="form-label"> نامک : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xs-12">
                                            <div class="form-group form-float ">
                                                <div class="form-line">
                                                    {{ Form::textarea('shortContent', old('shortContent'), ['class' => 'form-control', 'rows' => 5]) }}
                                                    <label class="form-label"> خلاصه محصول : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float ">
                                                <label class="form-label"> توضیحات : </label>
                                                <div class="form-line">
                                                    {{ Form::textarea('content', old('content'), ['class' => 'form-control', 'id'=>'editor1']) }}
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
                                        {{--                                        <div class="form-group form-float">--}}
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
                    <div class="row" style="margin-top: 8px">
                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        تصاویر گالری محصول
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12">
                                            {{ Form::file('photo[]', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'multiple'=>'multiple', 'id'=>'photos', 'data-theme'=>'fas']) }}
                                            {{--                                        <input type="file" id="photos" name="photo[]" class="form-control file" data-overwrite-initial="false" multiple data-theme="fas">--}}
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
                                                <div class="form-group form-float">
                                                    <label class="form-label" style="top: -15px;"> وضیعت : </label>
                                                    {{ Form::select('status', ['DRAFT' => 'پیش نویس', 'PUBLISHED' => 'انتشار'], ['class' => 'selectpicker form-control show-tick']) }}
                                                </div>

                                        </div>
                                        {{--<div class="col-lg-12">
                                            <div class="form-group form-float">
                                                <label class="form-label" style="top: -15px;"> جزو محصولات پیشنهادی : </label>
                                        <select required id="special" name="special"
                                                class="selectpicker form-control show-tick">

                                            <option value="NO" @if(old('special')=="NO")selected @endif>خیر</option>
                                            <option value="YES" @if(old('special')=="YES")selected @endif>بله</option>
                                        </select>
                                            </div>
                                        </div>--}}
                                        <div class="col-lg-12">
                                            <div class="form-group form-float">
                                                <label class="form-label" style="top: -15px;"> جزو سبد روز : </label>
                                        <select required id="special" name="day_basket"
                                                class="selectpicker form-control show-tick">

                                            <option value="NO" @if(old('day_basket')=="NO")selected @endif>خیر</option>
                                            <option value="YES" @if(old('day_basket')=="YES")selected @endif>بله</option>
                                        </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="submit" value="ثبت محصول" class="btn btn-success btn-block waves-effect"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


{{--                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        نوع محصول
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12">
                                            <div class="form-group form-float">
                                                {{ Form::select('type', ['فیزیکی' => 'فیزیکی', 'دانلودی' => 'دانلودی', 'پیش خرید' => 'پیش خرید'], ['class' => 'selectpicker form-control show-tick']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>--}}

                        <div class="col-xs-12 col-lg-12" id="upfile">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        آپلود فایل دانلودی
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12">
                                            {{ Form::file('file', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'file', 'data-theme'=>'fas']) }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        بخش مالی
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{ Form::number('mainPrice', old('mainPrice'), ['class' => 'form-control']) }}
                                                    <label class="form-label"> قیمت اصلی : </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{ Form::number('discount', old('discount'), ['class' => 'form-control']) }}
                                                    <label class="form-label"> میزان تخفیف (%) : </label>
                                                </div>
                                            </div>
                                        </div>

                                        {{--@if(Auth()->user()->seller == 'NO')
                                            <div class="col-xs-12 col-lg-12">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        {{ Form::number('marginprice', old('marginprice'), ['class' => 'form-control']) }}
                                                        <label class="form-label"> حاشیه سود : </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif--}}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        انبار
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{ Form::number('depot', old('depot'), ['class' => 'form-control']) }}
                                                    <label class="form-label"> موجودی انبار : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{ Form::select('unit', ['عدد' => 'عدد', 'دستگاه' => 'دستگاه', 'پک' => 'پک', 'سانتی متر' => 'سانتی متر', 'متر' => 'متر', 'گرم' => 'گرم', 'کیلوگرم' => 'کیلوگرم'], null, ['class' => 'selectpicker form-control show-tick']) }}
                                                    <label class="form-label" style="top: -15px;"> واحد : </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    {{ Form::number('buy_limited', old('buy_limited'), ['class' => 'form-control']) }}
                                                    <label class="form-label"> محدودیت خرید : </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xs-12 col-lg-12">
                            <div class="card" style="padding-bottom: 10px;">
                                <div class="header" style="margin-bottom: 10px;">
                                    <h5>
                                        دسته بندی
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
                        </div>

                        <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                        برند
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12">
                                            <div class="form-group form-float">
                                                <select required id="status" name="brand"
                                                        class="selectpicker form-control show-tick">
                                                    <option value="0">بدون برند</option>
                                                    @foreach($brands as $brand)
                                                        @php $imgBrand='<img width="30px" style="float:right;margin-left: 5px;" src="'.asset($brand->imgPath).'">' @endphp
                                                        <option data-subtext="{{$imgBrand}}" value="{{$brand->id}}">{{$brand->title}} </option><img src="{{asset($brand->imgPath)}}">
                                                    @endforeach
                                                </select>
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
                                        مشخصات فنی
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="items">


                                            @if(old('feature')!="" and old('featureValue')!="")
                                                <?php $row=0; ?>
                                                @foreach(old('feature') as $feature)
                                                    <div class="product-item">
                                                        <div class="col-xs-12 col-lg-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="checkbox" id="check{{$row}}" name="item_index[]">
                                                                    <label for="check{{$row}}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-lg-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">

                                                                    <input type="text" id="feature" name="feature[]"
                                                                           class="form-control" value="{{$feature}}">
                                                                    <label class="form-label"> خصوصیت : </label>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-lg-12">
                                                            <div class="form-group form-float ">
                                                                <div class="form-line">
                                                                    <input type="text" id="featureValue" name="featureValue[]"
                                                                           class="form-control" value="{{old('featureValue')[$row]}}">
                                                                    <label class="form-label">مقدار خصوصیت : </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <?php $row++; ?>
                                                @endforeach
                                            @else
                                                <div class="product-item">
                                                    <div class="col-xs-12 col-lg-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="checkbox" id="check" name="item_index[]">
                                                                <label for="check"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-lg-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">

                                                                <input type="text" id="feature" name="feature[]"
                                                                       class="form-control" value="{{old('feature[]')}}">
                                                                <label class="form-label"> خصوصیت : </label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-lg-12">
                                                        <div class="form-group form-float ">
                                                            <div class="form-line">
                                                                <input type="text" id="featureValue" name="featureValue[]"
                                                                       class="form-control" value="{{old('featureValue[]')}}">
                                                                <label class="form-label">مقدار خصوصیت : </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif



                                        </div>
                                    </div>
                                    <div class="row clearfix" align="">
                                        <div class="col-xs-6">
                                            {!! Form::button('افزودن',['onclick'=>'addMore()','class' =>'btn btn-success waves-effect btn-block']) !!}
                                        </div>
                                        <div class="col-xs-6">
                                            {!! Form::button('حذف',['onclick'=>'deleteRow()','class' =>'btn btn-danger waves-effect btn-block']) !!}
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
                                    </div>
                                </div>

                            </div>
                        </div>

                       <div class="col-xs-12 col-lg-12">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

        <!--                 <div class="col-xs-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h5>
                                       فایل صوتی
                                    </h5>
                                </div>
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-12">
                                            {{ Form::file('sound', ['class' => 'form-control file', 'data-overwrite-initial' => 'false', 'data-theme' => 'fas', 'id'=>'sound', 'data-theme'=>'fas']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>

                </div>

            </div>

        </form>
    </div>

    <script>
        function convertToSlug()
        {
            var Text = $('input[name=title]').val();
            if(Text.length > 0){
                $('input[name=slug]').parent().addClass('focused');
            }else{
                $('input[name=slug]').parent().removeClass('focused');
            }
            $('input[name=slug]').val(Text
                .toLowerCase().replace(/ /g,'-'));
        }


        var type = $('select[name=type]');
        $(type).change(function () {
            if($(this).val() == 'دانلودی'){
                $('#upfile').slideDown(500);
            }else{
                $('#upfile').slideUp(500);
            }
        })


    </script>



    <script src="{{asset('js/fileinput.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/locales/fa.js')}}" type="text/javascript"></script>
    <script src="{{asset('themes/fas/theme.js')}}" type="text/javascript"></script>
    <script src="{{asset('themes/explorer-fas/theme.js')}}" type="text/javascript"></script>

    <script>
        $("#photos").fileinput({

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
            allowedFileExtensions:['jpg', 'jpeg', 'png'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
            console.log(data);
        });

        $("#photos1").fileinput({

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
            allowedFileExtensions:['jpg', 'jpeg', 'png'],
            overwriteInitial: false,
            // maxFileSize:1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        }).on('filepreupload', function(event, data, previewId, index) {
            console.log(data);
        });

        $("#file").fileinput({

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

        $("#sound").fileinput({

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
            allowedFileExtensions:['mp3'],
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
        var i = 0;

        function addMore() {
            // $(".product-item:last").clone().insertAfter(".product-item:last");
            $(".items").append("                                <div class=\"product-item\">\n" +
                "                                    <div class=\"col-xs-12 col-lg-12\">\n" +
                "                                        <div class=\"form-group form-float \">\n" +
                "                                            <div class=\"form-line\" style=\"padding:0 !important;\">\n" +
                "                                                <input type=\"checkbox\" id=\"check"+i+"\" name=\"item_index[]\">\n" +
                "                                                <label for=\"check"+i+"\"></label>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"col-xs-12 col-lg-12\">\n" +
                "                                        <div class=\"form-group form-float \">\n" +
                "                                            <div class=\"form-line\ focused\" style=\"padding:0 !important;\">\n" +
                "\n" +
                "                                                <input type=\"text\" id=\"feature\" name=\"feature[]\"\n" +
                "                                                       class=\"form-control\" >\n" +
                "                                                <label class=\"form-label\"> خصوصیت : </label>\n" +
                "\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"col-xs-12 col-lg-12\">\n" +
                "                                        <div class=\"form-group form-float \">\n" +
                "                                            <div class=\"form-line\ focused\" style=\"padding:0 !important;\">\n" +
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


