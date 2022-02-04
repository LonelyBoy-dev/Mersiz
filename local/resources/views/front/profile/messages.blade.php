@extends('front.profile.layout')
@section('style')
    <style>
        select.form-control{
            border-radius: 5px;
        }

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
            width: 86px;
            font-size: 12px;
            line-height: 22px;
            padding: 0 12px;
            border: 1px solid #fff;
            border-radius: 8px;
            margin-left: 15px;
        }
        .c-profile-comments__status--rejected {
            border-color: #d32f2f;
            background-color: rgba(211,47,47,.1);
            color: #b2001a;
        }
    </style>
@endsection
@section('content_panel')

    <div class="card mb-16" data-controller="ProfileComplain">

        <!--card header-->
        <div class="card-header card-header-right-border">
            <div class="card-header_caption">
                <div class="card-header_caption-title">
                    <div class="card-header_caption-text">
                        <span>پیغام ها</span>
                    </div>
                </div>
            </div>
        </div>
        <!--card header end-->
        <!--card body-->
        <div class="card-body">

            <!--table-->
            <div class="table-responsive">
                <table class="table subtitle2 m-0">
                    <thead class="bg-secondary text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">متن پیام</th>
                        <th scope="col">تاریخ ثبت</th>

<!--                        <th scope="col">تصویر</th>
                        <th scope="col">مدیا</th>-->
                    </tr>
                    </thead>
                    <tbody class="font-weight-normal">

                    <?php $i=1; ?>
                    @foreach($messages as $message)
                    <tr class="bg-gray-50" id="collapseTable-1">
                        <td colspan="1">
                            <span>{{$i}}</span>
                        </td>
                        <td colspan="1">
                            <span>{{$message->message}}</span>
                        </td>
                        <td colspan="1">
                            <span>{{Verta::instance($message->created_at)->formatDatetime()}}</span>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!--table end-->

        </div>
        <!--card body end-->


    </div>

@endsection
@section('script')
    @if(session('complain__store'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('<?= session('complain__store') ?>');
        </script>
    @endif
@endsection
@php
    Session::forget('complain__store');
@endphp
