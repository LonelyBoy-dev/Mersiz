
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>فاکتور فروش</title>
    <style>

        @font-face {
            font-family: 'Vazir';
            src: url("{{asset('fonts/Vazir.ttf')}}") format("truetype"),
            url("{{asset('fonts/Vazir.eot?#iefix')}}") format("embedded-opentype");

        }
    </style>
    <style>
        h1,h2,h3,h4,h5,h6,a,td,th,span,div,table,button{
            font-family: Vazir;
        }
        html, body {
            padding: 0;
            margin: 0 auto;
            max-width: 29.7cm;
            -webkit-print-color-adjust: exact;
        }

        body {
            padding: 0.5cm
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-spacing: 0;
        }

        .header-table {
            table-layout: fixed;
            border-spacing: 0;
        }

        .header-table td {
            padding: 0;
            vertical-align: top;
        }

        body {
            font: 9pt Vazir;
            direction: rtl;
        }

        .print-button {
            cursor: pointer;
            -webkit-box-shadow: none;
            box-shadow: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            border-radius: 5px;
            background: none;
            -webkit-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
            position: relative;

            outline: none;
            text-align: center;

            padding: 8px 16px;
            font-size: 12px;
            font-size: .857rem;
            line-height: 1.833;
            font-weight: 700;
            background-color: #0fabc6;
            color: #fff;
            border: 1px solid #0fabc6;
        }

        .page {
            background: white;
            page-break-after: always;
        }

        .flex {
            display: flex;
        }

        .flex > * {
            float: left;
        }

        .flex-grow {
            flex-grow: 10000000;
        }

        .barcode {
            text-align: center;
            margin: 12px 0 0 0;
            height: 30px;
        }

        .barcode span {
            font-size: 35pt;
            font-family: 'Libre Barcode 128';
        }

        .portait {
            transform: rotate(-90deg) translate(0, 40%);
            text-align: center;
        }

        .header-item-wrapper {
            border: 1px solid #000;
            width: 100%;
            height: 100%;
            background: #eee;
            display: flex;
            align-content: center;
        }

        thead, tfoot {
            background: #eee;
        }

        .header-item-data {
            height: 100%;
            width: 100%;
        }

        .bordered {
            border: 1px solid #000;
            padding: 0.12cm;
        }

        .header-table table {
            width: 100%;
            vertical-align: middle;
        }

        .content-table {
            border-collapse: collapse;
        }

        .content-table td, th {
            border: 1px solid #000;
            text-align: center;
            padding: 0.1cm;
            font-weight: normal;
        }

        table.centered td {
            vertical-align: middle;
        }

        .serials {
            direction: ltr;
            text-align: left;
        }

        .title {
            text-align: right;
        }

        .grow {
            width: 100%;
            height: 100%;
        }

        .font-small {
            font-size: 8pt;
        }

        .font-medium {
            font-size: 10pt;
        }

        .font-big {
            font-size: 15pt;
        }

        .label {
            font-weight: bold;
            padding: 0 0 0 2px;
        }

        @page {
            size: A4 landscape;
            margin: 0;
            margin-bottom: 0.5cm;
            margin-top: 0.5cm;
        }

        .ltr {
            direction: ltr;
            display: block;
        }
    </style>
</head>
<body>
<button class="print-button" id="print-button">پرینت</button>
<div class="page">
    <h1 style="text-align: center;">
        فاکتور فروش
    </h1>
    <table class="header-table" style="width: 100%">
<!--        <tr>
            <td style="width: 1.8cm; height: 2.5cm;vertical-align: middle;padding-bottom: 4px;">
                <div class="header-item-wrapper">
                    <div class="portait" style="margin:5px">حق‌العمل کار</div>
                </div>
            </td>
            <td style="padding: 0 4px 4px;height: 2cm;">
                <div class="bordered grow header-item-data">
                    <table class="grow centered">
                        <tr>
                            <td style="width: 7cm">
                                <span class="label">فروشنده:</span> شركت نوآوران فن‌آوازه (سهامی خاص)
                            </td>
                            <td style="width: 5cm">
                                <span class="label">شناسه ملی:</span> ۱۰۳۲۰۸۴۵۸۵۷
                            </td>
                            <td>
                                <span class="label">شماره ثبت:</span> ۴۳۳۸۴۵
                            </td>
                            <td>
                                <span class="label">شماره اقتصادی:</span> ۴۱۱۴۱۹۱۳۶۵۱۱
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">نشانی شرکت:</span>تهران - گاندی جنوبی - نبش خیابان بیست و
                                یکم - پلاک ۲۸
                            </td>
                            <td>
                                <span class="label">کدپستی:</span> ۱۵۱۷۸۶۳۳۳۲
                            </td>
                            <td>
                                <span class="label">تلفن و فکس:</span> ۰۲۱۶۱۹۳۰۰۰۰
                            </td>
                        </tr>
                    </table>            </div>
            </td>
            <td style="width: 4.5cm;height: 2cm;padding: 0 0 4px;">
                <div class="bordered grow" style="padding: 2mm 5mm;">
                    <div class="flex">
                        <div class="font-small">شماره فاکتور:</div>
                        <div class="flex-grow" style="text-align: left">۸۴۰۱۶۲۵</div>
                    </div>
                    <div class="barcode">
                        <span style="font-family: 'Libre Barcode 128'">ÍÂ(H092Î</span>
                    </div>
                </div>
            </td>
        </tr>-->
        <tr>
            <td style="width: 1.8cm; height: 2cm;vertical-align: center; padding: 0 0 4px">
                <div class="header-item-wrapper">
                    <div class="portait" style="margin: 20px">خریدار</div>
                </div>
            </td>
            <?php $user=App\User::find($orders[0]->user_id); ?>
            <td style="height: 2cm;vertical-align: center; padding: 0 4px 4px">
                <div class="bordered header-item-data">
                    <table style="height: 100%" class="centered">
                        <tr>
                            <td style="width: 6.9cm">
                                <span class="label">خریدار:</span>  {{$orders[0]->name}}
                            </td>
                            <td>
                                <span class="label">شماره‌ فاکتور :</span> {{$orders[0]->factor_number}}
                            </td>
                            <td>
                                <span class="label">شناسه ملی:</span> {{$user->national_code}}
                            </td>

                        </tr>
                        <tr>
                            <td colspan="4">
                                <span class="label">نشانی:</span>{{$orders[0]->address}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">شماره تماس:</span>  {{$orders[0]->mobile}}
                            </td>
                            <td>
                                <span class="label">شماره ثبت:</span> -
                            </td>
                        </tr>
                    </table>            </div>
            </td>
            <td style="padding: 0 0 4px;    width: 200px;">
                <div class="grow bordered" style="padding: 2mm 5mm;">
                    <div class="flex">
                        <div>تاریخ:</div>
                        <div class="flex-grow"
                             style="text-align: left">{{Verta::instance($orders[0]->created_at)->format('%d %B %Y')}}</div>
                    </div>
                    <div class="flex">
                        <div>پیگیری:</div>
                        <div class="flex-grow font-medium"
                             style="text-align: left">{{$orders[0]->factor_number}}</div>
                    </div>
                    <div class="barcode">
                        <span><img style="width: 100%;display: block" src="data:image/png;base64,{{ base64_encode($barcode) }}"></span>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <table class="content-table">
        <thead>
        <tr>
            <th>ردیف</th>
            <th>شناسه کالا یا خدمت</th>
            <th style="width: 30%">شرح کالا یا خدمت</th>
            <th>تعداد</th>
            <th>مبلغ واحد ({{setting()['currency']}})</th>
            <th>مبلغ کل ({{setting()['currency']}})</th>
            <th>تخفیف ({{setting()['currency']}})</th>
            <th>مبلغ کل پس از تخفیف ({{setting()['currency']}})</th>
<!--            <th style="width: 2.3cm"> جمع مالیات و عوارض ارزش افزوده ({{setting()['currency']}})</th>
            <th style="width: 2.5cm"> جمع کل پس از تخفیف و مالیات و عوارض ({{setting()['currency']}})</th>-->
        </tr>
        </thead>
    <?php $i=1; ?>
        @foreach($orders as $order)
            <?php $product=App\Product::find($order->product_id); ?>
        <tr>
            <td>{{$i}}</td>
            <td>{{$product->id}}</td>
            <td>
                <div class="title">{{$product->title}}</div>
            </td>
            <td><span class="ltr">{{$order->count}}</span></td>
            <td><span class="ltr">
                                           {{number_format($order->price)}}
                                    </span></td>

            <td><span class="ltr">
                                          {{number_format($order->price*$order->count)}}
                                        </span></td>

            <td><span class="ltr">
                                           {{number_format($order->disprice)}}
                                        </span></td>

            <td><span class="ltr">
                                          {{number_format($order->payprice)}}
                                        </span></td>

<!--            <td><span class="ltr">
                                            ۰
                                        </span></td>

            <td><span class="ltr">
                                        ۱,۲۸۰,۰۰۰
                                        </span></td>-->

        </tr>
                <?php $i++; ?>
        @endforeach
        <tfoot>
        <tr>
            <td colspan="5">
            <td colspan="2" class="font-small">
                جمع کل پس از تخفیف و کسر مالیات و عوارض ({{setting()['currency']}}):
            </td>
            <td><span class="ltr">
                                  {{number_format($orders[0]->total)}}
                                </span></td>
        </tr>
        <tr style="background: #fff">
            <td colspan="8" style="height: 2.5cm;vertical-align: top">
                <div class="flex">
                    <div class="flex-grow">مهر و امضای فروشنده:</div>
                    <div class="flex-grow">تاریخ تحویل:</div>
                    <div class="flex-grow">ساعت تحویل:</div>


                    <div class="flex-grow">مهر و امضای خریدار:</div>
                </div>
                <div class="flex">
                    <div class="flex-grow">
<!--                        <img class="footer-img uk-align-center" width="150px"
                             src="https://www.digikala.com/static/files/acb0d08c.jpg">-->
                    </div>
                    <div class="flex-grow">{{$orders[0]->send_day}}</div>
                    <div class="flex-grow">{{$orders[0]->send_time}}</div>


                    <div class="flex-grow"></div>
                </div>
<!--                <h3>            به هنگام ارسال در سامانه معاملات فصلی ( ماده 169 مکرر) گزینه خرید از طریق حق العمل کار را انتخاب کنید
                </h3>-->
            </td>
        </tr>
        </tfoot>
    </table>
</div>    </body>
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script>
    var printButton = document.getElementById('print-button');
    printButton.addEventListener('click', function() {
        window.print();
    })
</script>
</html>
