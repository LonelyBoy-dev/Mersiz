@extends('adminbizness.layout.master')

@section('Admin_content')
    <link href="{{asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <script src="{{asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>

    <link href="{{asset('themes/explorer-fas/theme.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    {{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">--}}

    @include('adminbizness.partial.error')
    <div class="col-xs-12 head" style="margin-bottom: 20px;display: flex;justify-content: space-between">
        <div style="width: 100%">
            <h2>
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">list</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">افزودن دسته جدید</b>
            </h2>
            <a href="{{route('PostCategory.index')}}" style="float: left" title="برگشت"> <i
                    style="float: right;font-size: 29pt;color: #555;" class="material-icons">keyboard_backspace</i></a>

        </div>
    </div>
    <form action="{{route('PostCategory.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-12 col-xs-12 col-sm-12 ali-flex" >

                <div class="col-lg-8 col-xs-12 col-sm-12 ali-margin-0" style="margin-left: 8px;display: inline-table">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 " style="background: white;padding-top: 20px">
                            <div class="header ali-border-b">
                                <h5>
                                    ایجاد دسته
                                </h5>
                            </div>
                            <div class="body">
                                <div class="col-xs-12 col-lg-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input onkeyup="convertToSlug()" type="text" id="title" name="title"
                                                   class="form-control" value="{{old('title')}}">
                                            <label class="form-label"> عنوان : </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-lg-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="slug" name="slug"
                                                   class="form-control" value="{{old('slug')}}">
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
                                    <input type="submit" value="ایجاد دسته"
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
                                    <select required id="status" name="parent"
                                            class="selectpicker form-control show-tick">
                                        <option value="0">هیچکدام</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

            </div>

        </div>

    </form>






@endsection

@section('script')
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


