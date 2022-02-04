@extends('adminbizness.layout.master')
@section('style_link')

@endsection
@section('style')
@endsection
@section('Admin_content')
    <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
        <div style="min-width: 150px">
            <h2 style="margin-top: 0">
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">add_shopping_cart</i>
                <b style="color: #555;margin: 8px 5px 0 0;float: right;font-size: 18pt;">افزودن فایل اکسل</b>
            </h2>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                <div class="card">
                    <div class="header" style="border: unset">
                        <h5>
                            انتخاب فایل اکسل با فیلدهای (id و عنوان و قیمت و موجودی)
                        </h5>
                    </div>
                    <form method="POST" action="{{route('product.store.excel')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="body" style="padding: 8px">

                            <div class="row clearfix" style="display:flex;">

                                <div class="col-lg-9" style="margin-right: 30px">
                                    <input type="file" id="photos1" name="fileExcel" class="form-control file" data-overwrite-initial="false" data-theme="fas">
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn bg-green waves-effect" title="افزودن جدید">
                                        <i class="material-icons">add_circle</i>
                                        <span>آپلود</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>


                </div>
            </div>


        </div>
    </div>
@endsection
@section('script')
    <script>
        @if(session('insertProduct'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('insertProduct')}}</span>',
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
@endsection
<?php
Session::forget('insertProduct');
?>