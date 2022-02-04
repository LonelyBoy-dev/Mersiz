@extends('adminbizness.layout.master')

@section('Admin_content')


    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="float: right">
            <div class="info-box hover-expand-effect">
                <div class="icon bg-teal">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">بازدید کننده کل</div>
                    <div style="line-height: 2.5">{{$total_ip}} نفر </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="float: right">
            <div class="info-box hover-expand-effect">
                <div class="icon bg-green">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">بازدید کل</div>
                    <div style="line-height: 2.5">{{$total_view}} نفر </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="float: right">
            <div class="info-box hover-expand-effect">
                <div class="icon bg-light-green">
                    <i class="material-icons">phone_iphone</i>
                </div>
                <div class="content">
                    <div class="text">بازدید از موبایل</div>
                    <div style="line-height: 2.5">{{count($total_mobile)}} نفر </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="float: right">
            <div class="info-box hover-expand-effect">
                <div class="icon bg-lime">
                    <i class="material-icons">desktop_mac</i>
                </div>
                <div class="content">
                    <div class="text">بازدید از کامپیوتر</div>
                    <div style="line-height: 2.5">{{count($total_computer)}} نفر </div>
                </div>
            </div>
        </div>
    </div>




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
            <div class="body table-responsive">
                <table class="table table-hover" style="text-align: center;background: white">
                    <tbody>
                    <tr style="background: #f7f7f7">
                        <td>عنوان محصول</td>
                        <td>آی پی</td>
                        <td>سیستم عامل</td>
                        <td>دستگاه</td>
                        <td>مرورگر</td>
                        <td>تاریخ و ساعت بازدید</td>
                    </tr>
                    @foreach($stats as $item)
                        <?php $product = App\Product::findorfail($item->product_id); ?>
                        <tr style="vertical-align: middle">
                            <td>{{Illuminate\Support\Str::limit($product->title, 70)}}</td>
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
            {{ $stats->links() }}
        </div>

    </div>
@endsection
