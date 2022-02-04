<table>
    <tbody>
    <tr>
        <td>عنوان محصول</td>
        <td>قیمت اصلی</td>
        <td>قیمت حراج</td>
        <td>حاشیه سود</td>
        <td>تعداد</td>
        <td>فروشنده</td>
        <td>استان</td>
        <td>شهر</td>
        <td>مبلغ پرداخت شده</td>
        <td>نوع محصول</td>
        <td>شماره تماس</td>
        <td>توضیحات</td>
        <td>تاریخ</td>
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
            <td>{{number_format($item->payprice)}} تومان </td>
            <td>{{$item->type}}</td>
            <td>{{$item->tell}}</td>
            <td>{{$item->description}}</td>
            <td>{{Verta($item->created_at)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
