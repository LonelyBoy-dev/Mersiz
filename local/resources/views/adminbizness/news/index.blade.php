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
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">chrome_reader_mode</i>
                <b style="color: #555;margin: 7px 5px 0 0;float: right;font-size: 18pt;">مدیریت خبرها</b>
            </h2>
        </div>

    </div>



    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 col-lg-12 ali-m-bottom-6" style="background: white;padding-top: 20px">
                <div class="card">
                    <div class="header">
                        <h5>
                            عنوان اخبار
                        </h5>
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                 </span>
                        @endif
                    </div>
                    <form method="POST" action="{{route('news.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="body" style="padding: 8px">

                            <div class="row clearfix" style="display:flex;">

                                <div class="col-lg-9" style="margin-right: 30px">
                                    <input type="text" id="title" name="title" class="form-control" placeholder="عنوان اخبار را وارد کنید">
                                </div>

                                <div class="col-md-3">
                                    <button type="submit"
                                            class="btn bg-green waves-effect" title="افزودن جدید">
                                        <i class="material-icons">add_circle</i>
                                        <span>ذخیره</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>


                </div>
                        <div class="card">
                            <div class="body" style="padding: 0">
                                <div class="box-body">
                                    <br>
                                    <div class="container-fluid table-responsive">

                                        <table class="table text-center table-striped" id="myTable"
                                               style="width: 100%;font-size: 13px">
                                            <thead class="bg-blue-gradient">
                                            <tr id="">
                                                <th>#</th>
                                                <th>عنوان خبر</th>
                                                <th> وضعیت</th>
                                                <th>تاریخ ثبت </th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $i=1; @endphp
                                            @foreach($newss as $news)
                                                <tr>
                                                    <th scope="row">{{$i++}}</th>
                                                    <td>{{$news->title}}</td>
                                                    <td>
                                                        <div id="title_status">
                                                            @if($news->status=="Show")
                                                                <span class="badge bg-teal">نمایش</span>
                                                            @else
                                                                <span class="badge bg-orange">عدم نمایش</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{Verta::instance($news->created_at)->format('%d %B %Y')}}</td>
                                                    <td>
                                                                <span id="status">
                                                                    @if($news->status=="Show")
                                                                        <button onclick="change_status(this)"
                                                                                style="padding: 2px 4px;font-size: 13px;" type="button" data-id="{{$news->id}}" data-status="DontShow"
                                                                                class="btn btn-warning waves-effect">
                                                                    <i class="material-icons" style="font-size: 15px;">kitchen</i>
                                                                    <span> عدم نمایش</span>
                                                                </button>
                                                                    @else
                                                                        <button onclick="change_status(this)" data-id="{{$news->id}}" data-status="Show"
                                                                                style="padding: 2px 4px;font-size: 13px;" type="button"
                                                                                class="btn btn-success waves-effect">
                                                                    <i class="material-icons" style="font-size: 15px;">kitchen</i>
                                                                   <span>نمایش</span>
                                                                </button>
                                                                    @endif
                                                                </span>


                                                                <button onclick="removenews(this,'{{$news->id}}')"
                                                                        style="padding: 2px 4px;font-size: 13px;" type="button"
                                                                        class="btn btn-danger waves-effect">
                                                                    <i style="font-size: 16px;" class="material-icons">delete_forever</i>
                                                                    <span>حذف</span>
                                                                </button>
                                                      </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
            </div>


        </div>
    </div>
@endsection


@section('script_link')
@endsection

@section('script')

    <script>
        @if(session('news-create'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('news-create')}}</span>',
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
        function removenews(tag, id) {

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
                    var url = '{{route('news.delete_news')}}';
                    var data = {_token: CSRF_TOKEN, id: id};
                    $.post(url, data, function (msg) {
                        if (msg == "delete") {
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
                        $(tag).parents('tr').remove();
                    });
                }
            })

        }

        function change_status(item){
            $('#title_status').html('')
            $('#status').html('')
            var id=$(item).attr('data-id');
            var status=$(item).attr('data-status');
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('news.change_status_news')}}';
            var data = {_token: CSRF_TOKEN, id: id,status:status};
            $.post(url, data, function (msg) {
                if (status==="Show"){
                    $('#title_status').append('<span class="badge bg-teal">نمایش</span>');
                    $('#status').append('<button onclick="change_status(this)" style="padding: 2px 4px;font-size: 13px;" type="button" data-id="'+id+'" data-status="DontShow" class="btn btn-warning waves-effect"><i class="material-icons" style="font-size: 15px;">kitchen</i><span> عدم نمایش</span></button>');
                }else {
                    $('#title_status').append('<span class="badge bg-orange">عدم نمایش</span>');
                    $('#status').append('<button onclick="change_status(this)" style="padding: 2px 4px;font-size: 13px;" type="button" data-id="'+id+'" data-status="Show" class="btn btn-success waves-effect"><i class="material-icons" style="font-size: 15px;">kitchen</i><span>  نمایش</span></button>');
                }

            });
        }
    </script>

@endsection
<?php
Session::forget('news-create');
?>

