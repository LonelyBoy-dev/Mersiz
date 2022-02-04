@extends('adminbizness.layout.master')

@section('style')
    <style>
        .card > .header.h{
            padding-bottom: 46px!important;

        }
        .header h2{
            float: right;
            margin-top: 7px!important;
        }
        .header h6{
            display: inline-block;
            width: 100%;
            height: 39px;
        }
        .header a{
           float: left;
            margin-top: -5px;
        }
        .header .image{
            float: right;
            margin-left: 5px;
            border-radius: 100%;
            overflow: hidden;
        }
        .badge {
            font-size: 11px;
        }
        .card .body.b{
            float: right;
            width: 100%;
            background-size: cover!important;
}
        .dropdown-menu a{
            width: 100%;
        }
        .header h6 span{
            margin-bottom: 5px;
        }

        .clearfix .card .header{
            padding-bottom: 0;
        }
        .card .body .clearfix > div {
            float: right;
        }
        .delete{
            padding: 7px 18px;
            color: #666;
        }
    </style>
@endsection

@section('Admin_content')
    <div class="row main-index Topseller clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            @if(session('insert-topseller') and session('insert-topseller')=='success')
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    فروشنده جدید با موفقیت ثبت شد!
                </div>
            @endif

            @if(session('edit-topseller') and session('edit-topseller')=='success')
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    فروشنده با موفقیت بروزرسانی شد!
                </div>
            @endif

            @if(session('delete-topseller') and session('delete-topseller')=='success')
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    فروشنده با موفقیت حذف شد!
                </div>
            @endif
            <?php
            Session::forget('insert-topseller');
            Session::forget('edit-topseller');
            Session::forget('delete-topseller');
            ?>

            <div class="card">
                <div class="header h">
                    <h2>
                        باشگاه میلیونرها
                    </h2>
                    @can('Topsellers_create')
                    <a href="{{route('Topsellers.create')}}" type="button"
                       class="btn btn-primary btn-circle waves-effect waves-circle waves-float">
                        <i class="material-icons">add</i>
                    </a>
                        @endcan
                </div>
                <div class="body">
                    <div class="row clearfix">
                        @if($top_sellers)
                        <?php $i=0; ?>
                        @foreach($top_sellers as $top_seller)
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="card">
                                    <div class="header">
                                        <div class="image">
                                            @if(@$top_seller->user->avatar=='')
                                                <img src="{{asset('images/user.png')}}" width="48" height="48" alt="User" />
                                            @else
                                                <img src="{{asset('images/user_profile/'.@$top_seller->user->avatar)}}" width="48" height="48" alt="User" />
                                            @endif
                                        </div>
                                        <h2>

                                            {{@$top_seller->user->name}}
                                           {{-- <small>
                                                @if(@$top_seller->user->level==1)
                                                    Beginner
                                                @elseif(@$top_seller->user->level==2)
                                                    Presenter
                                                @elseif(@$top_seller->user->level==3)
                                                    Trainer
                                                @elseif(@$top_seller->user->level==4)
                                                    Advisor
                                                @elseif(@$top_seller->user->level==5)
                                                    Leader
                                                @elseif(@$top_seller->user->level==6)
                                                    Top Leader
                                                @elseif(@$top_seller->user->level==7)
                                                    Masster
                                                @endif
                                            </small>--}}
                                            <small>مقدار فروش : {{number_format(@$top_seller->sell)}} تومان </small>
                                        </h2>
                                        <h6>
                                            @if(@$top_seller->day==1)
                                                <span class="badge bg-orange">نماینده برتر روزانه</span>
                                            @endif
                                            @if(@$top_seller->week==1)
                                                    <span class="badge bg-teal">نماینده برتر هفته</span>
                                             @endif
                                            @if(@$top_seller->month==1)
                                            <span class="badge bg-cyan">نماینده برتر ماه</span>
                                            @endif

                                                @if(@$top_seller->season==1)
                                                    <span class="badge bg-cyan">نماینده برتر فصل</span>
                                                @endif

                                        </h6>


                                        <ul class="header-dropdown m-r--5">
                                            <li class="dropdown">
                                                <a href="javascript:void(0);" class="dropdown-toggle"
                                                   data-toggle="dropdown" role="button" aria-haspopup="true"
                                                   aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                    @can('Topsellers_edit')
                                                    <li><a href="{{route('Topsellers.edit',@$top_seller->id)}}">ویرایش</a></li>
                                                    @endcan
                                                        @can('Topsellers_delete')
                                                            <li>
                                                    <form method="post" action="{{route('Topsellers.destroy',$top_seller->id)}}">
                                                        @csrf
                                                        <input name="_method" value="DELETE" type="hidden">
                                                        <a class="delete" href="javascript:void(0);">حذف</a>
                                                    </form></li>
                                                        @endcan
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>

                                    <div style="@if(@$top_seller->user->level==1)
                                        background: url({{asset('images/background/white.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==2)
                                        background: url({{asset('images/background/yellow.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==3)
                                        background: url({{asset('images/background/green.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==4)
                                        background: url({{asset('images/background/blue.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==5)
                                        background: url({{asset('images/background/red.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==6)
                                        background: url({{asset('images/background/banafsh.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==7)
                                        background: url({{asset('images/background/black.svg')}}) no-repeat;
                                    @endif
                                        "  class="body b">

                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
                        @endforeach
                            @else

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content_user')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


            <div class="card">
                <div class="header">

                </div>
                <div class="body">
                    <div class="row clearfix">
                        <?php $i=0; ?>
                        @foreach($top_sellers as $top_seller)
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="card">
                                    <div class="header">
                                        <div class="image">
                                            @if(@$top_seller->user->avatar=='')
                                                <img src="{{asset('images/user.png')}}" width="48" height="48" alt="User" />
                                            @else
                                                <img src="{{asset('images/user_profile/'.@$top_seller->user->avatar)}}" width="48" height="48" alt="User" />
                                            @endif
                                        </div>
                                        <h2>

                                            {{@$top_seller->user->name}}<small>مقدار فروش : {{number_format(@$top_seller->sell)}} تومان </small>
                                        </h2>
                                        <h6>
                                            @if(@$top_seller->day==1)
                                                <span class="badge bg-orange">نماینده برتر روزانه</span>
                                            @endif
                                            @if(@$top_seller->week==1)
                                                <span class="badge bg-teal">نماینده برتر هفته</span>
                                            @endif
                                            @if(@$top_seller->month==1)
                                                <span class="badge bg-cyan">نماینده برتر ماه</span>
                                            @endif

                                            @if(@$top_seller->season==1)
                                                <span class="badge bg-cyan">نماینده برتر فصل</span>
                                            @endif
                                        </h6>

                                    </div>

                                    <div style="@if(@$top_seller->user->level==1)
                                        background: url({{asset('images/background/white.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==2)
                                        background: url({{asset('images/background/yellow.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==3)
                                        background: url({{asset('images/background/green.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==4)
                                        background: url({{asset('images/background/blue.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==5)
                                        background: url({{asset('images/background/red.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==6)
                                        background: url({{asset('images/background/banafsh.svg')}}) no-repeat;
                                    @elseif(@$top_seller->user->level==7)
                                        background: url({{asset('images/background/black.svg')}}) no-repeat;
                                    @endif
                                    " class="body b">

                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('.delete').click(function () {
            var tag=this;
            Swal.fire({
                title: ' سوال حذف شود',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله حذف شود!',
                cancelButtonText: 'لغو'
            }).then((result) => {
                if (result.value) {
                    $(tag).parents('form').submit();
                }
            })
        })

    </script>
@endsection
