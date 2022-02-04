@extends('adminbizness.layout.master')
@section('style')
    <style>
        .btn.btn-default {
            margin-bottom: 5px;
        }

        #levels {
            float: right;
            position: relative;
            width: 100%;
        }

        .remove-file {
            position: absolute;
            right: 0;
            background: #00bcd4;
            padding: 3px 7px 0px;
            color: #fff;
            cursor: pointer;
        }

        .col-lg-6, .col-md-6 {
            float: right;
        }
    </style>
@endsection

@section('Admin_content')
    <div class="row clearfix main-index Topseller">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ویرایش  فروشنده

                        <a href="{{route('Topsellers.index')}}" style="float:left;margin-top: -10px;" type="button" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                            <i class="material-icons">reply</i>
                        </a>
                    </h2>

                </div>
                {!! Form::open(['method'=>'PATCH','action'=>['AdminB\AdminTopsellersControllers@update',$topseller->id],'files'=>true]) !!}


                    <div class="body">


                        <div class="form-group">
                            <div class="form-line">
                                <input value="{{$topseller->sell}}" required type="number" name="sell" class="form-control"
                                       placeholder="مقدار فروش"/>
                            </div>
                        </div>

                        <div class="from-group">
                            <input type="checkbox" name="day" id="md_checkbox_31" value="1" class="filled-in chk-col-teal" @if($topseller->day==1) checked @endif>
                            <label style="margin-right: 25px;" for="md_checkbox_31">روزانه</label>

                            <input type="checkbox" name="week" id="md_checkbox_29" value="1" class="filled-in chk-col-teal" @if($topseller->week==1) checked @endif>
                            <label style="margin-right: 25px;" for="md_checkbox_29">هفتگی</label>

                            <input type="checkbox" name="month" id="md_checkbox_30" value="1" class="filled-in chk-col-teal" @if($topseller->month==1) checked @endif>
                            <label style="margin-right: 25px;" for="md_checkbox_30">ماهانه</label>


                            <input type="checkbox" name="season" id="md_checkbox_32" value="1" class="filled-in chk-col-teal" @if($topseller->season==1) checked @endif>
                            <label style="margin-right: 25px;" for="md_checkbox_32">فصلی</label>


                        </div>



                        <div class="row align-center">
                            <button type="submit" class="btn bg-deep-orange waves-effect">ثبت فروشنده</button>
                        </div>


                    </div>
                {{Form::close()}}

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>


        function deleteRow() {
            $('DIV.products').each(function (index, item) {
                jQuery(':checkbox', this).each(function () {
                    if ($(this).is(':checked')) {
                        $(item).remove();
                        level = level - 1;
                    }
                });
            });
            $('.remove-file').click(function () {
                $(this).parent().remove();
                level = level - 1;
            });
        }
    </script>
@endsection
