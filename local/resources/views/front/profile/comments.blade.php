@extends('front.profile.layout')
@section('style')
    <style>
        .item .box-option_label{
            display: flex;
            border: unset;
            border-bottom: 1px solid #ccc !important;
            border-radius: unset !important;
        }
        .c-profile-comments__status--approved {
            border-color: #4caf50;
            background-color: rgba(76,175,80,.1);
            color: #2e7b32;

        }
        .c-profile-comments__status--Waiting {
            border-color: #f9a825;
            background-color: rgba(249,168,37,.1);
            color: #f57f17;

        }
        .c-profile-comments__status {
            position: absolute;
            width: 86px;
            font-size: 12px;
            font-size: .857rem;
            line-height: 22px;
            padding: 0 12px;
            border: 1px solid #fff;
            border-radius: 8px;
            margin-left: 15px;
            left: 0;
        }
        .c-profile-comments__status--rejected {
            border-color: #d32f2f;
            background-color: rgba(211,47,47,.1);
            color: #b2001a;
        }
    </style>
    @endsection
@section('content_panel')

    <div class="card mb-16" data-controller="ProfileMessage">

        <!--card header-->
        <div class="card-header card-header-right-border">
            <div class="card-header_caption">
                <div class="card-header_caption-title">
                    <div class="card-header_caption-text">نظرهای من</div>
                </div>
            </div>
        </div>
        <!--card header end-->
        <!--card body-->
        <div class="card-body">

            <div class="row align-items-center">
                @foreach($comments as $comment)
                <div class="col-lg-12 item">
                    <div class="box-option mb-16">
                        @if ($comment->status=="SEEN")
                            <div class="c-profile-comments__status c-profile-comments__status--approved">
                                تایید شده
                            </div>
                        @elseif($comment->status=='Waiting')
                            <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 110px;">
                                در انتظار بررسی
                            </div>
                        @elseif($comment->status=='UNSEEN')
                            <div class="c-profile-comments__status c-profile-comments__status--rejected">
                                تایید نشده
                            </div>
                        @endif

                        <input type="radio" class="box-option_control" id="box-option" checked
                               value="{{$comment->id}}">
                        <label class="box-option_label" for="box-option-{{$comment->id}}">
                            <div class="col-md-2" style="line-height: 157px">
                                <div class="mb-12">
                                    <img width="100px" src="{{asset($comment->product->image)}}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-12" style="margin-top: 10px">
                                    <a href="/product/{{$comment->product->slug}}" class="text-secondary">{{$comment->product->title}}</a>&nbsp;
                                </div>
                                <div class="mb-12" style="min-height: 64px;    margin-top: 30px;">

                                    <span>
                                         <span class="address-plaque" style="font-weight: 700">
                                                    {{$comment->title}}
                                         </span><br>
                                        {{$comment->content}}
                                        </span>
                                </div>

                            </div>
                            <div class="d-flex align-items-center">


                                <div class="justify-content-end flex-shrink-1" style="position: absolute;bottom: 15px">
                                    <a href="/comment/{{$comment->product->slug}}/{{$comment->id}}" class="btn btn-sm btn-outline-secondary mr-4 EditAddress"
                                             data-id="{{$comment->id}}">ویرایش
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-primary mr-4 btn-delete"
                                            data-id="{{$comment->id}}"><i
                                            class="ico ico-delete ico-18px"></i>حذف
                                    </button>
                                </div>

                            </div>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
            <nav class="d-flex align-items-center justify-content-center py-8">
                {{$comments->links()}}
            </nav>

        </div>
        <!--card body end-->

    </div>
@endsection

@section('script')
    @if(session('edit_comment'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('نظر شما با موفقیت ویرایش شده و بعد از تائید مدیر در سایت نمایش داده می شود');
        </script>
    @endif
    <script>
        $('.btn-delete').click(function () {
            var item=this;
            var data_id=$(this).attr('data-id');
            alertify.confirm("آیا از حذف مطمئن هستید؟",
                function () {
                    $.ajax({
                        type: "post",
                        url: "{{route('comments.removeComments')}}",
                        data: {
                            id: data_id,
                            _token: '{{csrf_token()}}',
                        },
                        dataType: 'json',
                        success: function () {
                            $(item).parents('.item').remove();
                        },
                        error: function (err) {
                            if (err.status == 422) {
                                $('#error_user').slideDown(100);
                                $.each(err.responseJSON.errors, function (i, error) {
                                    $('#error_item').append($('<span style="color: white;">' + error[
                                            0] +
                                        '</span><br>'));
                                });
                            }
                        }
                    });
                },
                function () {

                }).set('labels', {ok: 'بله', cancel: 'خیر!'}).setHeader('<em> پیغام </em> ');
        })
    </script>
@endsection
@php
    Session::forget('edit_comment');
@endphp
