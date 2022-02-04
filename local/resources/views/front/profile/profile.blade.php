@extends('front.profile.layout')


@section('content_panel')
<!-- Content Header (Page header) -->
<style>
    .profile h5{
        margin-top: 8px;
    }
    .profile .row{
        padding: 10px 20px!important;
    }
    .profile .btn{
        margin-top: 10px;
        margin-left: 20px;
        float: left;
        background-color: #7fad39;
        border-color: #7fad39;
    }
    .invalid-feedback{
        display: block;
        font-size: 11px;
    }
  /*  .form-control{
        display: block!important;
    }*/
    div.nice-select{
        display: none!important;
    }
</style>
<section class="content-header">
    <h1>
        ویرایش اطلاعات شخصی
    </h1>

</section>

<!-- Main content -->
<section class="content">
    <div class="box">

        <div class="box-body profile">
            <form method="POST" action="{{route('panel.edit_profile')}}">
                @csrf
                <div class="row">
                    <div class="col-md-6">نام:
                        <h5>
                            <input class="form-control" type="text" name="name" value="@if(old('name')==""){{$user->name}}@else{{old('name')}} @endif">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                 </span>
                            @endif
                        </h5>
                    </div>

                    <div class="col-md-6">نام خانوادگی:
                        <h5>
                            <input class="form-control" type="text" name="family" value="@if(old('family')==""){{$user->family}}@else{{old('family')}} @endif">
                            @if ($errors->has('family'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('family') }}</strong>
                                                 </span>
                            @endif
                        </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">شماره تلفن همراه:
                        <h5>
                            <input class="form-control" type="text" name="mobile" value="@if(old('mobile')==""){{$user->mobile}}@else{{old('mobile')}} @endif">
                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('mobile') }}</strong>
                                                 </span>
                            @endif
                        </h5>
                    </div>

                    <div class="col-md-6">ایمیل:
                        <h5>
                            <input class="form-control" type="text" name="email" value="@if(old('email')==""){{$user->email}}@else{{old('email')}} @endif">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                 </span>
                            @endif
                        </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <label for="ostan_id" class="col-sm-3 control-label">استان</label>
                        <div class="col-sm-12" style="padding: 0">
                            <select id="ostan" name="ostan_id" class="selectpicker state ostan form-control show-tick" data-live-search="true">
                                <option>استان را انتخاب کنید</option>
                            </select>
                            @if ($errors->has('state'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                 </span>
                            @endif
                        </div>
                        <input name="state" type="hidden" value="@if(old('state')==""){{$user->ostan}}@else{{old('state')}} @endif">
                    </div>

                    <div class="col-lg-6">
                        <label for="city_id" class="col-sm-3 control-label">شهر</label>
                        <div class="col-sm-12" style="padding: 0">
                            <select  id="city" name="city_id" onchange="set_state_name()"
                                     class="selectpicker form-control show-tick city">
                                <option>ابتدا استان را انتخاب کنید</option>
                            </select>
                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                 </span>
                            @endif
                        </div>
                        <input name="city" type="hidden" value="@if(old('city')==""){{$user->city}}@else{{old('city')}} @endif">
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">کد پستی:
                        <h5>
                            <input class="form-control" type="text" name="postal_code" value="@if(old('postal_code')==""){{$user->postal_code}}@else{{old('postal_code')}} @endif">
                            @if ($errors->has('postal_code'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('postal_code') }}</strong>
                                                 </span>
                            @endif
                        </h5>
                    </div>

                    <div class="col-md-6">آدرس:
                        <h5>
                            <input class="form-control" type="text" name="address" value="@if(old('address')==""){{$user->address}}@else{{old('address')}} @endif">
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                 </span>
                            @endif
                        </h5>
                    </div>
                </div>
                <button type="submit" class="btn btn-info pull-right">ویرایش اطلاعات</button>
            </form>

        </div>
    </div>

</section>
<!-- /.content -->

@endsection

@section('script_link')
    <script src="{{asset(('js/frotel/ostan.js'))}}"></script>
    <script src="{{asset('js/frotel/city.js')}}"></script>
@endsection

@section('script')

    <script>

        loadOstan('ostan');
        $("#ostan").change(function () {
            var i = $(this).find('option:selected').val();
            ldMenu(i, 'city');
            $('.selectpicker').selectpicker('refresh');
        });

        function set_state_name() {
            var ostan_name = $('#ostan option:selected').text();
            var city_name = $('#city option:selected').text();
            $('input[name=city]').val(city_name);
            $('input[name=state]').val(ostan_name);
        }

        $('#ostan option').each(function (index) {

            var value_ostan = $(this).val();
            var state =@if(old('ostan_id')=="")'{{$user->ostan_id}}'@else'{{old('ostan_id')}}' @endif;
            if (value_ostan == state) {
                $(this).attr('selected', 'selected');
                ldMenu(value_ostan, 'city');

            }


        });

        $('.city option').each(function (index) {
            var city = @if(old('city_id')=="")'{{$user->city_id}}'@else'{{old('city_id')}}' @endif;
            var city_value = $(this).val();
            if (city_value == city) {
                $(this).attr('selected', 'selected');
                $('.selectpicker').selectpicker('refresh');
            }
        });

    </script>

    @if(session('edit_profile'))
        <script>
            alertify.set('notifier','position', 'bottom-left');
            alertify.success('اطلاعات شما با موفقیت ویرایش شد');
        </script>
    @endif
@endsection
@php
    Session::forget('edit_profile');
@endphp
