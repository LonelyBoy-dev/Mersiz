@extends('adminbizness.layout.master')

@section('content')
    <div class="row">

        <div class="col-xs-12">
            @if(session('success_payment'))
                <div class="alert alert-dismissible" role="alert" style="background-color: #61c579;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{session('success_payment')}}
                </div>
            @endif

            <?php
            session()->forget('success_payment');
            ?>
        </div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{--            <div class="card">--}}
            <div class="header">
                <div class="row"
                     style="display: flex;justify-content: space-between;align-items: center;margin-bottom: 15px">
                    <div class="col-lg-10" style="font-size: 15px;color: #666666">
                        لیست دانلودها
                    </div>
                    <div>
                    </div>

                </div>
            </div>
            <div class="body table-responsive">
                <table class="table table-hover" style="text-align: center;background: white">
                    <tbody>
                    <tr>
                        <td>شماره فاکتور</td>
                        <td>شماره ارجاع</td>
                        <td>شماره تراکنش</td>
                        <td>تاریخ ثبت سفارش</td>
                        <td>وضعیت سفارش</td>
                        <td>مبلغ پرداختی</td>
                        <td>لینک دانلود</td>
                    </tr>
                    @foreach($orders as $item)
                        <?php
//                        $user = App\User::findorfail($item->user_id);
                        ?>
                        <tr style="vertical-align: middle">
                            <td>{{$item->factor_number}}</td>
                            <td>{{$item->refId}}</td>
                            <td>{{$item->authority}}</td>
                            <td>{{Verta($item->created_at)}}</td>
                            @if($item->pay_status == 'OK')
                                <td>
                                    پرداخت شد
                                </td>
                            @else
                                <td>
                                    پرداخت نشد
                                </td>
                            @endif
                            <td>{{number_format($item->payprice)}} تومان </td>

                            <td>
                                <a href="{{$item->linkdownload}}">دانلود</a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{--            </div>--}}
        </div>
    </div>
@endsection
