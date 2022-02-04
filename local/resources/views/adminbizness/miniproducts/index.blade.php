@extends('adminbizness.layout.master')

@section('Admin_content')
    <div class="row">

        <div class="col-xs-12">
            @if(session('delete_miniproduct'))
                <div class="alert alert-dismissible" role="alert" style="background-color: #61c579;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{session('delete_miniproduct')}}
                </div>
            @endif

            <?php
            session()->forget('delete_miniproduct');
            ?>
        </div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{--            <div class="card">--}}
            <div class="header">
                <div class="row"
                     style="display: flex;justify-content: space-between;align-items: center;margin-bottom: 15px">
                    <div class="col-lg-10" style="font-size: 15px;color: #666666">
                        لیست شرکت های طرف قرارداد
                    </div>
                    <a class="btn btn-success waves-effect" href="{{route('miniproducts.create')}}">
                        افزودن شرکت
                    </a>

                </div>
            </div>
            <div class="body table-responsive">
                <table class="table table-hover" style="text-align: center;background: white">
                    <tbody>
                    <tr>
                        <td>شناسه</td>
                        <td>لوگوی شرکت</td>
                        <td>نام شرکت</td>
                        <td>وضعیت</td>
                        <td>اقدامات</td>
                    </tr>
                    @foreach($miniproducts as $item)
                        <tr style="vertical-align: middle">
                            <td scope="row">{{$item->id}}</td>
                            @if(!empty($item->image))
                                <td><img class="img-fluid" src="{{asset($item->image)}}" style="max-height: 40px;max-width: 60px"></td>
                            @else
                                <td><img class="img-fluid" src="{{asset('images/noimage.png')}}" style="max-height: 40px;max-width: 60px"></td>
                            @endif
                            <td>{{$item['title']}}</td>

                            @if($item->status == 0)
                                <td>
                                    <i class="material-icons" style="color: #cb4f40">clear</i>
                                </td>
                            @else
                                <td>
                                    <i class="material-icons" style="color: #40bf85">done</i>
                                </td>
                            @endif

                            <td>
                                {!! Form::open(['method' => 'DELETE', 'action' => ['AdminB\AdminminiproductsController@destroy', $item->id],'style'=>'display:unset']) !!}
                                <button type="submit" class="btn waves-effect waves-light bg-red">حذف</button>
                                {!! Form::close() !!}


                                <a href="{{route('miniproducts.edit', $item->id)}}" class="btn bg-blue waves-effect">
                                    ویرایش
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




