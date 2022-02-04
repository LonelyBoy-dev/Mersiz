@extends('adminbizness.layout.master')

@section('style_link')
    @endsection

@section('Admin_content')
    @can('dashboard')

    <style>
        .info-box-2 .content h2{
            font-size: 20px!important;
        }
        .container-fluid .clearfix > div{
            float: right;
        }
        .container-fluid .icon{
            background: rgba(244, 248, 251, 0.6);
        }
        .container-fluid .icon i{
            color: #61c579;
        }
        #container * {
            direction: ltr;
        }
        .card .body.heght{
            height: 425px;
        }
        .menu{
            height: 70vh!important;
        }
        .visits th,.visits td{
            text-align: center;
        }
        .pagination > li > a, .pagination > li > span{
            float: right;
        }
    </style>

    @if(session('buy_package'))
        <div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {{session('buy_package')}}
        </div>

    @endif
    @if(session('Commission'))
        <div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {{session('Commission')}}
        </div>

    @endif
    @if(session('buy_package_danger'))
        <div class="alert bg-red alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {{session('buy_package_danger')}}
        </div>
    @endif
    @php
        Session::forget('buy_package');
        Session::forget('Commission');
        Session::forget('buy_package_danger');
    @endphp


        <div class="container-fluid">

            <!-- Widgets -->
            <div class="row clearfix">
                <?php
                $all_visit=[];
                foreach ($allvisits as $visit){
                    $all_visit[]=$visit->count;
                }
                ?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="info-box-2 bg-wheat hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">visibility</i>
                        </div>
                        <div class="content">
                            <h2 class="text">{{array_sum($all_visit)}}</h2>
                            <div class="text">بازدید کل</div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="info-box-2 bg-wheat hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">visibility</i>
                        </div>
                        <div class="content">
                            <h2 class="text">{{count($allvisits)}}</h2>

                            <div class="text">بازدید کنندگان کل</div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="info-box-2 bg-wheat hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">visibility</i>
                        </div>
                        <div class="content">

                            <h2 class="text">{{count($allvisits_days)}}</h2>
                            <div class="text">بازدید کننده امروز</div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="info-box-2 bg-wheat hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">visibility</i>
                        </div>
                        <?php
                        $all_day=[];
                        foreach ($allvisits as $allvisits_day){
                            $all_day[]=$allvisits_day->count_day;
                        }

                        ?>
                        <div class="content">
                            <h2 class="text">{{array_sum($all_day)}}</h2>
                            <div class="text">بازدید امروز</div>
                        </div>
                    </div>

                </div>


            </div>



            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header" style="padding-bottom: 35px;">
                            <h2 style="float: right">جزئیات بازدید</h2>
                            <a href="{{route('views.delete_all')}}" style="float: left;width: 100px;" type="button" class="btn bg-red btn-block btn-sm waves-effect">حذف بازدیدها</a>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos visits">
                                    <thead>
                                    <tr>
                                        <th>مرورگر</th>
                                        <th>دستگاه </th>
                                        <th>پلتفرم</th>
                                        <th>آی پی </th>
                                        <th>تاریخ بازدید</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $row=1; ?>
                                    @foreach($visits as $visit)
                                        <tr>
                                            <td>{{$visit->browser}}</td>
                                            <td>{{$visit->device}}</td>
                                            <td>{{$visit->platform}}</td>
                                            <td>{{$visit->ip}}</td>
                                            <td>{{Verta::instance($visit->created_at)}}</td>

                                        </tr>
                                        <?php $row++; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$visits->links()}}
                        </div>

                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>نمودار فروش</h2>
                        </div>
                        <div class="body">
                            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        </div>
                </div>
            </div>
            </div>

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2>آخرین پست ها فعال</h2>
                        </div>
                        <div class="body heght">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                    <tr>
                                        <th>تصویر</th>
                                        <th>عنوان</th>
                                        <th>بازدید</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($posts as $post)
                                    <tr>
                                        <td><img width="50px" src="{{asset($post->imgPath)}}"></td>
                                        <td><a target="_blank" href="/blog/{{$post->slug}}">{{$post->title}}</a></td>
                                        <td><span class="label bg-green">{{$post->view}}</span></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2>آخرین محصولات فعال</h2>
                        </div>
                        <div class="body heght">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    </thead>
                                    <tbody>
                                    @foreach($products_new as $item)
                                        <tr>
                                            <td><img width="50px" src="{{asset($item->image)}}"></td>
                                            <td><a target="_blank" href="/product/{{$item->slug}}">{{$item->title}}</a></td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>آخرین سفارشات</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                    <tr>
                                        <th>شماره فاکتور</th>
                                        <th>نوع پست</th>
                                        <th>خریدار</th>
                                        <th>مبلغ </th>
                                        <th>نحوه پرداخت	</th>
                                        <th>وضعیت پرداخت</th>
                                        <th>وضعیت سفارش</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        @php $order=\App\Order::where('factor_number',$order->factor_number)->first(); @endphp
                                        <tr>
                                            <td>{{$order->factor_number}}</td>
                                            <td>@if($order->send_day=="پست ویژه")<span class="badge bg-orange">پست ویژه</span> @else  معمولی@endif</td>
                                            <td>{{$order->name}}</td>
                                            <td>{{number_format($order->total)}} تومان</td>
                                            <td>@if ($order->pay_method=="home")
                                                    <span class="badge bg-orange">پرداخت در محل</span>
                                                @elseif($order->pay_method=="online")
                                                    <span class="badge bg-teal">پرداخت آنلاین</span>
                                                @elseif($order->pay_method=="wallet")
                                                    <span class="badge bg-teal">پرداخت از کیف پول</span>
                                                @endif</td>
                                            @if($order->pay_status == 'OK')
                                                <td>
                                                    <span class="badge bg-teal">پرداخت شد</span>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="badge bg-pink">پرداخت نشد</span>
                                                </td>
                                            @endif
                                            <td>{{$order->send_status}}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2>پرفروش ترین محصولات</h2>
                        </div>
                        <div class="body scroll-box" STYLE="height: 378px">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    </thead>
                                    <tbody>
                                    @foreach($sale_product as $item)
                                        <tr>
                                            <td><img width="50px" src="{{asset($item->image)}}"></td>
                                            <td><a target="_blank" href="/product/{{$item->slug}}">{{$item->title}}</a></td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2>پربازدید ترین محصولات</h2>
                        </div>
                        <div class="body scroll-box" STYLE="height: 378px">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos ">
                                    <thead>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    </thead>
                                    <tbody>
                                    @foreach($products_view as $item)
                                        <tr>
                                            <td><img width="50px" src="{{asset($item->image)}}"></td>
                                            <td><a target="_blank" href="/product/{{$item->slug}}">{{$item->title}}</a></td>

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
    @endcan
@endsection

@section('script_map')
<?php $jquery_min='true'; ?>
<script
    src="{{asset('plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('js/highcharts/highcharts.js')}}"></script>
    <script src="{{asset('js/highcharts/exporting.js')}}"></script>
@endsection
@section('script')
    <script>
        @if(session('deleteView'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('deleteView')}}</span>',
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
    <script type="text/javascript">
        $(function () {
            $('#container').highcharts({
                title: {
                    text: 'نمودار آمار فروش در 7 روز گذشته',
                    x: -20 //center
                },
                subtitle: {
                    text: 'فروشگاه Mersiz',
                    x: -20
                },
                xAxis: {
                    categories: [@foreach($sevendate as $date)'{{$date}}', @endforeach]
                },
                yAxis: {
                    title: {
                        text: 'تعداد سفارش'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#f00'
                    }]
                },
                tooltip: {
                    valueSuffix: ''
                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },

                series: [{
                    name: 'تعداد فروش',
                    data: [{{$values}}]
                }]
            });
        });
    </script>
@endsection
@php session()->forget('deleteView') @endphp
