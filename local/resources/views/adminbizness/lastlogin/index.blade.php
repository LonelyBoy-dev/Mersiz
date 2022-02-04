@extends('adminbizness.layout.master')

@section('Admin_content')
    <div class="row">

        <div class="col-xs-12">
            @if(session('delete_product'))
                <div class="alert alert-dismissible" role="alert" style="background-color: #61c579;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{session('delete_product')}}
                </div>
            @endif

            <?php
            session()->forget('delete_product');
            ?>
        </div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{--            <div class="card">--}}
            <div class="header">
                <div class="row"
                     style="display: flex;justify-content: space-between;align-items: center;margin-bottom: 15px">
                    <div class="col-lg-10" style="font-size: 15px;color: #666666">
                        آخرین ورود
                    </div>
                    <a class="">
                    </a>

                </div>
            </div>
            <div class="body table-responsive">
                <table class="table table-hover" style="text-align: center;background: white">
                    <tbody>
                    <tr style="background: #f7f7f7">
                        <td>کاربر</td>
                        <td>آی پی</td>
                        <td>سیستم عامل</td>
                        <td>دستگاه</td>
                        <td>مرورگر</td>
                        <td>تاریخ و ساعت ورود</td>
                    </tr>
                    @foreach($lastlogin as $item)
                        <?php $user = App\User::findorfail($item->user_id); ?>
                        <tr style="vertical-align: middle">
                            <td>{{$user->name.' '.$user->family}}</td>
                            <td>{{$item->ip}}</td>
                            <td>{{$item->os}}</td>
                            <td>{{$item->device}}</td>
                            <td>{{$item->browser}}</td>
                            <td>{{Verta($item->created_at)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{--            </div>--}}
        </div>

        <div class="col-lg-12" align="center" dir="ltr">
            {{ $lastlogin->links() }}
        </div>

    </div>
@endsection
