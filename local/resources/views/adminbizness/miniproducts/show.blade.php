@extends('adminbizness.layout.master')

@section('Admin_content')

    <link href="{{asset('themes/explorer-fas/theme.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.rateit/1.1.3/rateit.min.css" media="all" rel="stylesheet" type="text/css"/>

    <style>
        .card {
            margin-bottom: 10px;
            padding: 0 10px;
        }
        .bs-caret{
            display: none;
        }
        .card .body .col-lg-12 {
            margin-bottom: unset;
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
        .swal2-popup.swal2-toast {
            margin-top: 10em;
        }
        .swal2-popup.swal2-toast .swal2-title {
            font-size: 1.5em;
        }
        @media only screen and (max-width: 768px) {
            .swal2-container.swal2-rtl.swal2-top.swal2-backdrop-show {
                width: 90% !important;
            }
        }
        .checked {
            color: orange;
        }

    </style>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <div style="display: flex;justify-content: space-between;align-items: center">
                        <h5>
                            {{$miniproduct->title}}
                        </h5>
                        <span style="display: flex;justify-content: space-between;align-items: center">
                            <span style="display: flex;flex-direction: row-reverse;justify-content: space-around">
                                <i onclick="like({{$miniproduct->id}})" class="glyphicon glyphicon-thumbs-up" style="margin:0 4px 0 14px;color: #0f9d58;cursor: pointer"></i> <div id="liketxt">{{$miniproduct->islike}}</div>
                            </span>
                            <span style="display: flex;flex-direction: row-reverse;justify-content: space-around">
                                <i onclick="dislike({{$miniproduct->id}})"id="dislike" class="glyphicon glyphicon-thumbs-down" style="margin:0 4px 0 0;color: #ff484f;cursor: pointer"></i> <div id="disliketxt">{{$miniproduct->dislike}}</div>
                            </span>
                                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#defaultModal" style="padding-right: 20px;color: rgb(161, 129, 239)">نظرات کاربران ({{count($commentminiproducts)}} نظر)</button>

 <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">نظرات کاربران در رابطه با این محصول</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12" style="height: 400px; overflow-y: scroll;padding: 0 10px;background: #f7f7f7;box-shadow: 0px 0px 8px 3px #ccc inset;">
                                    @foreach($commentminiproducts as $commentminiproduct)
                                        <?php $user = App\User::findorfail($commentminiproduct->user_id) ?>
                                        <div style="margin-top: 20px">
                                            <span style="display: flex;justify-content: space-between;align-items: center">
                                                <span style="background: #a27df9;color: #fff;padding: 4px 40px;border-top-left-radius: 20px;border-bottom-right-radius: 20px">{{$user->name.' '.$user->family}} </span>

                    @if($commentminiproduct->rate == 0)
                                                    <div>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                                                @endif
                                                @if($commentminiproduct->rate == 1)
                                                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                                                @endif
                                                @if($commentminiproduct->rate == 2)
                                                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                                                @endif
                                                @if($commentminiproduct->rate == 3)
                                                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                                                @endif
                                                @if($commentminiproduct->rate == 4)
                                                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                                                @endif
                                                @if($commentminiproduct->rate == 5)
                                                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                    </div>
                                                @endif

                                            </span>
                                        <div style="background: #fafafa; padding: 10px; border: 6px double #a27df9;">
                                            {{$commentminiproduct->content}}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-toggle="modal" data-target="#defaultModal2">نظر خود را ثبت کنید</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">بستن پنجره</button>
                        </div>
                    </div>
                </div>
            </div>

 <div class="modal fade" id="defaultModal2" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">نظر خودت رو بگو!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                <div class="form-line">
                                    <textarea id="txtcomment" placeholder="نظرت رو اینجا بنویس!" rows="3" class="form-control no-resize auto-growth" style="overflow: hidden; overflow-wrap: break-word; height: 32px;"></textarea>
                                </div>
                            </div>
                                </div>
                                <div class="col-sm-12" align="left">
                                    امتیاز بدهید
<input type="range" value="0" step="1" id="backing5">
<div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false" data-rateit-min="0" data-rateit-max="5">
</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="sendcomment(this, {{$miniproduct->id}})" type="button" class="btn btn-link waves-effect" data-toggle="modal" data-target="#defaultModal2">ثبت نظر</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">منصرف شدم!</button>
                        </div>
                    </div>
                </div>
            </div>



                        </span>
                    </div>
                </div>
                <div class="body">
                    <?php echo $miniproduct->description ?>
                </div>
                <div class="card-footer text-muted" style="padding: 10px 10px 4px 10px;display: flex;align-items: center;justify-content: space-between;border: 2px dashed #e2e2e2;border-bottom: none">

                    <h5>میانگین امتیاز این محصول : </h5>
                    @if($rate == 0)
                    <div>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                    @endif
                    @if($rate == 1)
                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                    @endif
                    @if($rate == 2)
                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                    @endif
                    @if($rate == 3)
                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                    @endif
                    @if($rate == 4)
                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons">grade</i>
                    </div>
                    @endif
                    @if($rate == 5)
                    <div>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                        <i class="material-icons checked">grade</i>
                    </div>
                    @endif

                </div>

            </div>
        </div>

        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h5>
                        ویدئوی معرفی
                    </h5>
                </div>
                <div class="body">
                    <video width="100%" controls>
                        <source src="{{asset($miniproduct->video)}}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h5>
                        فایل راهنمای PDF
                    </h5>
                </div>
                <div class="body">
                    <object data="{{asset($miniproduct->pdf)}}" type="application/pdf" width="100%" height="400"></object>
                    <br>
                    <span>
                        <a class="btn btn-success btn-block" href="{{asset($miniproduct->pdf)}}">دانلود فایل</a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h5>
                        فایل راهنمای صوتی
                    </h5>
                </div>
                <div class="body">
                    <center>
                        <audio controls>
                            <source src="{{asset($miniproduct->voice)}}" type="audio/mp3">
                            Your browser does not support the audio tag.
                        </audio>
                    </center>
                    <br>
                    <span>
                        <a class="btn btn-success btn-block" href="{{asset($miniproduct->voice)}}">دانلود فایل</a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h5>
                        کد تخفیف
                    </h5>
                </div>
                <div class="body" style="text-align: center">
                    <a onclick="getoffcode(this, {{$miniproduct->id}})" class="btn waves-effect btn-success btn-block">دریافت کد تخفیف</a>
                    <span id="offcode" style="background: #f92fa6;color: #fff;padding: 10px;border-radius: 6px;display: none"></span>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.rateit/1.1.3/jquery.rateit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
    <script !src="">
        function sendcomment(item, id) {

            var txt = $('#txtcomment').val();
            var rate = $('#backing5').val();

            if(txt == '' || rate == 0){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'لطفا نظر خود را نوشته و یک امتیاز ثبت کنید!'
                })
            }else{
                $.ajax({
                    type: "post",
                    url: "/commentminiproduct",
                    data: {
                        txt: txt,
                        id: id,
                        rate: rate,
                        userid : '{{Auth()->id()}}',
                        _token: '{{csrf_token()}}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.msg);
                    },
                    error: function (err) {
                        if (err.status == 422) {
                        }
                    }
                });
            }
        }

        function getoffcode(item, id) {
            $.ajax({
                type: "post",
                url: "/getoffcode",
                data: {
                    id: id,
                    userid : '{{Auth()->id()}}',
                    _token: '{{csrf_token()}}',
                },
                dataType: 'json',
                success: function (data) {
                    $('#offcode').html(data.msg);
                    $('#offcode').show(200);
                    $(item).hide(100);
                },
                error: function (err) {
                    if (err.status == 422) {
                    }
                }
            });
        }

        function like(id) {
            $.ajax({
                type: "post",
                url: "/setlike",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}',
                },
                dataType: 'json',
                success: function (data) {
                    $('#liketxt').html(data.msg);
                },
                error: function (err) {
                    if (err.status == 422) {
                    }
                }
            });
        }

        function dislike(id) {
            $.ajax({
                type: "post",
                url: "/setdislike",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}',
                },
                dataType: 'json',
                success: function (data) {
                    $('#disliketxt').html(data.msg);
                },
                error: function (err) {
                    if (err.status == 422) {
                        console.log(err);
                    }
                }
            });
        }
    </script>


@endsection

@section('script_link')


@endsection
