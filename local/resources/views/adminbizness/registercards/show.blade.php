@extends('adminbizness.layout.master')

@section('style_link')

@endsection

@section('style')

@endsection

@section('content')
    <link href="{{asset('plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <style>
        .col-lg-6,.col-lg-4{
            float: right;
        }
        .card {
            box-shadow: unset;
        }
        .card .header h2 {
            line-height: 2;
        }
        .dropdown-menu > li > form > button {
            padding: 7px 18px;
            color: #666;
            -moz-transition: all 0.5s;
            -o-transition: all 0.5s;
            -webkit-transition: all 0.5s;
            transition: all 0.5s;
            font-size: 14px;
            line-height: 25px;
        }
    </style>


    <div class="row clearfix">
        @foreach($cards as $card)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="header bg-blue">

                        <h2>
                            {{$card->bank}} <small>شماره کارت :  {{$card->cardnumber}}</small>
                        </h2>


                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">

                                    <li><a href="{{route('registercard.edit', $card->id)}}" class=" waves-effect waves-block">ویرایش</a></li>

                                    <li>
                                        {!! Form::open(['method' => 'DELETE', 'action' =>['AdminB\AdminRegisterCardController@destroy', $card->id]]) !!}
                                        <button type="submit" class="waves-effect waves-block">حذف</button>
                                        {!! Form::close() !!}
                                    </li>

                                </ul>
                            </li>
                        </ul>

                    </div>
                    <div class="body" style="display: flex;flex-direction: column;line-height: 2">
                        <span>نام و نام خانوادگی : {{$card->name}}</span>
                        <span>کد ملی : {{$card->mellicode}}</span>
                        <span>استان : {{$card->state}}</span>
                        <span>شهر : {{$card->city}}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script>

    </script>
@endsection

@section('script_link')
@endsection

@section('script')
@endsection
