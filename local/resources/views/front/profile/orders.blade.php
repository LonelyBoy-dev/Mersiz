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
            width: 86px;
            font-size: 12px;
            font-size: .857rem;
            line-height: 22px;
            padding: 0 12px;
            border: 1px solid #fff;
            border-radius: 8px;
            left: 0;
            margin: 0 auto;
        }
        .c-profile-comments__status--rejected {
            border-color: #d32f2f;
            background-color: rgba(211,47,47,.1);
            color: #b2001a;
        }
        .table th, .table td{
            border-top: unset;
        }
        .o-link {
            display: inline-block;
            color: #00bfd6!important;
            font-size: 14px;
            line-height: 28px;
            font-weight: 700;
            cursor: pointer;
            background: transparent;
        }
    </style>
@endsection
@section('content_panel')

    <div class="card mb-16" data-controller="ProfileShoppingHistory">

        <!--card header-->
        <div class="card-header card-header-right-border">
            <div class="card-header_caption">
                <div class="card-header_caption-title">
                    <div class="card-header_caption-text">سابقه خرید</div>
                </div>
            </div>
        </div>
        <!--card header end-->
        <!--card body-->
        <div class="card-body">

            <div id="filter-result">
                <!--table-->
                <div class="table-responsive">
                    <table class="table subtitle2 m-0">
                        <thead class="bg-secondary text-white">
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th scope="col">شماره پیگیری</th>
                            <th scope="col">تاریخ خرید</th>
                            <th scope="col">جمع پرداخت</th>
                            <th scope="col" style="text-align: center;width: 7px;">وضعیت</th>
                            <th class="text-center" scope="col" style="    width: 115px;">جزئیات</th>
                        </tr>
                        </thead>
                        <tbody class="font-weight-normal">
                        <?php $i=1; ?>

                            @foreach($orders as $order)
                               <?php $item=App\Order::where('factor_number',$order->factor_number)->first() ?>
                               @if ($item->pay_method=="online" and $item->pay_status=="NOK")
                               @else
                                   <tr style="border-bottom: 1px solid #5555551a;">
                                   <td>{{$i}}</td>
                                   <td>{{$order->factor_number}}</td>
                                   <td>{{Verta::instance($item->created_at)->format('%d %B %Y')}}</td>
                                   <td>{{number_format($item->total).' '.setting()['currency']}}</td>
                                   <td class="text-center">@if ($item->send_status=="در حال برسی")
                                           <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 110px;">
                                               در انتظار بررسی
                                           </div>
                                       @elseif ($item->send_status=="در حال پیگیری سفارش")
                                           <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 151px;background-color: rgb(237 255 56 / 37%);color: #959e0b;">
                                               در حال پیگیری سفارش
                                           </div>
                                       @elseif ($item->send_status=="در حال بسته بندی")
                                           <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 126px;background-color: rgb(134 92 25 / 10%);color: #8e613a;">
                                               در حال بسته بندی
                                           </div>
                                       @elseif ($item->send_status=="ارسال شده")
                                           <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 84px;background-color: rgb(207 218 44 / 14%);color: #c3da05;">
                                               ارسال شده
                                           </div>
                                       @elseif ($item->send_status=="تحویل داده شده")
                                           <div class="c-profile-comments__status c-profile-comments__status--Waiting" style=" width: 116px;background-color: rgb(61 185 30 / 10%);color: #269c18;">
                                               تحویل داده شده
                                           </div>
                                       @endif
                                   </td>
                                   <td>
                                       <a class="o-link" href="/profile/orders/{{$order->factor_number}}">مشاهده جزئیات</a>
                                   </td>
                               </tr>
                               @endif

                                <?php $i++; ?>
                            @endforeach
                        </tbody>

                    </table>

                </div>

                <!--table end-->
            </div>

        </div>
        <!--card body end-->
        <div style="display: flex;justify-content: center;">
            {{$orders->links()}}
        </div>

    </div>

@endsection

