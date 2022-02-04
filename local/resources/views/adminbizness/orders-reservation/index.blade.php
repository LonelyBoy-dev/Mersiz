@extends('adminbizness.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection
@section('Admin_content')
    <div class="row">


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{--            <div class="card">--}}
            <div class="header">
                <div style="display: flex;justify-content: space-between;margin-bottom: 15px">

                        <h2 style="margin-top: 0">
                            <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">assignment_turned_in</i>
                            <b style="color: #555;margin: 8px 5px 0 0;float: right;font-size: 18pt;"> لیست محصولات رزرو شده</b>
                        </h2>

                    <div class="col-lg-6" align="left">
                        <a class="btn btn-success" href="{{route('orders.report')}}">خروجی اکسل از همه سفارشات</a>
                    </div>

                </div>
            </div>
            <div class="body table-responsive">
                <table id="orders" class="table table-striped table-hover dataTable js-exportable" style="text-align: center;background: white">
                    <tbody>
                    <tr style="background: #f7f7f7">
                        <td>شماره فاکتور</td>
                        <td>شماره تراکنش</td>
                        <td>خریدار</td>
                        <td>تاریخ ثبت سفارش</td>
                        <td>تاریخ رزرو</td>
                        <td>نحوه پرداخت</td>
                        <td>وضعیت سفارش</td>
                        <td>مبلغ فاکتور</td>
                        <td>وضعیت</td>
                        <td>اقدامات</td>
                    </tr>
                    @foreach($orders as $itemm)
                        <?php
                        $user = App\User::find($itemm->user_id);
                        $item=App\Order::where('factor_number',$itemm->factor_number)->first();
                        ?>
                        <tr style="vertical-align: middle">
                            <td>{{$itemm->factor_number}}</td>
                            <td>{{$item->authority}}</td>
                            <td>{{@$user->name.' '.@$user->family}}</td>
                            <td>{{Verta($itemm->created_at)}}</td>
                            <td>{{$item->send_day.' '.$item->send_time}}</td>
                            <td>
                                @if ($item->pay_method=="home")
                                    <span class="badge bg-orange">پرداخت در محل</span>
                                @elseif($item->pay_method=="online")
                                    <span class="badge bg-teal">پرداخت آنلاین</span>
                                @elseif($item->pay_method=="wallet")
                                    <span class="badge bg-teal">پرداخت از کیف پول</span>
                                @endif
                            </td>
                            @if($itemm->pay_status == 'OK')
                                <td>
                                    <span class="badge bg-teal">پرداخت شد</span>
                                </td>
                            @else
                                <td>
                                    <span class="badge bg-pink">پرداخت نشد</span>
                                </td>
                            @endif
                            <td>{{number_format($item->total)}} تومان</td>
                            <td>{{$item->send_status}}</td>

                            <td>
                                <a href="{{route('orders-product.show', $item->factor_number)}}"
                                   class="btn bg-blue waves-effect">
                                    مشاهده
                                </a>
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
@section('script_link')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
@endsection
@section('script')
<script>
    $('#orders').DataTable({
        "lengthMenu": [
            [10, 20, 30],
            [10, 20, 30],
        ],
        ordering:  true,
        scrollX:0,
        paging: true,
        "bLengthChange" : false,
        "language": {
            "sEmptyTable": "هیچ داده‌ای در جدول وجود ندارد",
            "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
            "sInfoEmpty": "نمایش 0 تا 0 از 0 ردیف",
            "sInfoFiltered": "(فیلتر شده از _MAX_ ردیف)",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": "نمایش _MENU_ ردیف",
            "sLoadingRecords": "در حال بارگزاری...",
            "sProcessing": "در حال پردازش...",
            "sSearch": "جستجو:",
            "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
            "oPaginate": {
                "sFirst": "برگه‌ی نخست",
                "sLast": "برگه‌ی آخر",
                "sNext": "بعدی",
                "sPrevious": "قبلی"
            },
            "oAria": {
                "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
            }
        }
    });
</script>
@endsection
