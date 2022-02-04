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
                        لیست سفارش {{$orders[0]->name}} به شماره فاکتور {{$orders[0]->factor_number}}
                    </div>
                    <div>
                    </div>

                </div>
            </div>
            <div class="body table-responsive">
                <table class="table table-hover" style="text-align: center;background: white">
                    <tbody>
                    <tr>
                        <td>عنوان محصول</td>
                        <td>قیمت اصلی</td>
                        <td>قیمت حراج</td>
                        <td>حاشیه سود</td>
                        <td>تعداد سفارش</td>
                        <td>فروشنده</td>
                        <td>استان</td>
                        <td>شهر</td>
                        <td>آدرس پستی مقصد</td>
                        <td>شماره تماس</td>
                        <td>توضیحات</td>
                        <td>اقدامات</td>
                    </tr>
                    @foreach($orders as $item)
                        <?php
                        $product = App\Product::findorfail($item->product_id);
                        $seller = App\User::findorfail($item->seller_id);
                        ?>
                        <tr style="vertical-align: middle">
                            <td>{{$product->title}}</td>
                            <td>{{number_format($item->price)}} تومان </td>
                            <td>{{number_format($item->sale)}} تومان </td>
                            <td>{{number_format($item->marginprice)}} تومان </td>
                            <td>{{$item->count .' '.$product->unit}}</td>
                            <td>{{$seller->name.' '.$seller->family}}</td>
                            <td>{{$item->state}}</td>
                            <td>{{$item->city}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->tell}}</td>
                            <td>{{$item->description}}</td>
                            <td>
                                <a href="{{route('orders-product.show', $item->factor_number)}}" class="btn bg-blue waves-effect">
                                    آماده ارسال
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
