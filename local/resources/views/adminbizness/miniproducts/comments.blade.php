@extends('adminbizness.layout.master')

@section('Admin_content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{--            <div class="card">--}}
            <div class="header">
                <div class="row"
                     style="display: flex;justify-content: space-between;align-items: center;margin-bottom: 15px">
                    <div class="col-lg-10" style="font-size: 15px;color: #666666">
                        لیست نظرات
                    </div>
<div></div>
                </div>
            </div>
            <div class="body table-responsive">
                <table class="table table-hover" style="text-align: center;background: white">
                    <tbody>
                    <tr>
                        <td>شناسه</td>
                        <td>نام کاربر</td>
                        <td>متن نظر</td>
                        <td>نام محصول</td>
                        <td>وضعیت</td>
                        <td>اقدامات</td>
                    </tr>
                    @foreach($commentminiproducts as $item)
                        <?php
                            $user = App\User::findorfail($item->user_id);
                            $product = App\Miniproduct::findorfail($item->product_id);
                        ?>
                        <tr style="vertical-align: middle">
                            <td scope="row">{{$item->id}}</td>

                            <td>{{$user->name.' '.$user->family}}</td>
                            <td>{{$item->content}}</td>
                            <td>{{$product->title}}</td>

                            @if($item->status == 'ACTIVE')
                                <td>
                                    <span style="color: #40bf85">تایید شده</span>
                                </td>
                            @else
                                <td>
                                    <span style="color: #cb4f40">تایید نشده</span>
                                </td>
                            @endif

                            <td>
                                <a href="{{route('verifymini', $item->id)}}" class="btn bg-green waves-effect">
                                    تایید
                                </a>
                                <a href="{{route('deletemini', $item->id)}}" class="btn waves-effect waves-light bg-red">حذف</a>
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




