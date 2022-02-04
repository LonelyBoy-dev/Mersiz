@extends('front.profile.layout')
@section('style_link_profile')
    <style>
        .deleteAdddress{
            color: #fb4b63;
            border-color: #fb4b63;
        }
        #app {
            width: 100%;
            height: 400px;
            direction: ltr;
        }
    </style>

    @endsection

@section('content_panel')


        <div class="card mb-16" data-controller="ProfileAddress">
            <!--card header-->
            <div class="card-header card-header-right-border">
                <div class="card-header_caption">
                    <div class="card-header_caption-title">
                        <div class="card-header_caption-text">آدرس های من</div>
                    </div>
                </div>
                    <div class="text-center" style="margin: 17px 5px 0 0;">
                        <!-- Button trigger modal -->
                        <button type="button" id="AddNewAddress" class="btn btn-outline-primary px-24" data-toggle="modal" data-target="#newAddressModal"><i class="ico ico-plus"></i>افزودن آدرس جدید</button>

                        <!-- Modal -->
                    </div>
            </div>
            <!--card header end-->
            <!--card body-->
            <div class="card-body">
                <div class="row align-items-center">

                    @foreach($addresses as $address)
                        <div class="col-lg-6 item">
                            <div class="box-option mb-16">
                                <input type="radio" class="box-option_control" id="box-option-{{$address->id}}" @if($address->selected=="YES")checked @endif name="SelectAddress"
                                       value="{{$address->id}}">
                                <label class="box-option_label" for="box-option-{{$address->id}}">
                                    <div class="p-20">
                                        <div class="mb-12">
                                            <span class="text-secondary">تحویل گیرنده:</span>&nbsp;
                                            <span>{{$address->name}}</span>
                                        </div>
                                        <div class="mb-12" style="min-height: 64px">
                                            <span class="text-secondary">آدرس:</span>&nbsp;
                                            <span>
                                           {{$address->address}}
                                            &nbsp;
                                                <span class="address-plaque">
                                                    پلاک {{$address->plaque}}
                                                </span>

                                            @if ($address->unit!="")
                                                    <span class="address-unit">
                                                    واحد {{$address->unit}}
                                                </span>
                                                @endif

                                        </span>
                                        </div>
                                        <div class="d-flex align-items-center">

                                            <div class="flex-grow-1 d-flex">

                                                <div class="w-100">
                                                    <div>
                                                        <span class="text-secondary">شماره همراه:</span>&nbsp;
                                                        <span>{{$address->mobile}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="justify-content-end flex-shrink-1">
                                                <button type="button"  class="btn btn-sm btn-outline-secondary mr-4 EditAddress"
                                                        data-toggle="modal" data-target="#newAddressModal" data-id="{{$address->id}}">ویرایش
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-primary mr-4 deleteAdddress"
                                                         data-id="{{$address->id}}"><i
                                                        class="ico ico-delete ico-18px"></i>حذف
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>

            <div class="modal" id="newAddressModal" tabindex="-1" role="dialog" aria-labelledby="newAddressModalLabel"
                 aria-modal="true" style="padding-right: 17px;">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">

                        <!--header-->
                        <div class="modal-header">
                            <h5 class="modal-title text-primary">ثبت آدرس جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="ico ico-close ico-fw-0"></i></span>
                            </button>
                        </div>
                        <!--header end-->


                        <div class="modal-body">
                            <form class="submit-form" method="post" id="frmAddAddress" action="/profile/saveaddresse"
                                  novalidate="novalidate">
                                @csrf
                                <input type="hidden" value="0" data-val="true"
                                       data-val-required="The Id field is required." id="Id" name="Id">
                                <input type="hidden" value="0" data-val="true"
                                       data-val-required="The SectorId field is required." id="SectorId"
                                       name="SectorId">
                                <input type="hidden" data-val="true" data-val-number="The field Lat must be a number."
                                       id="Lat" name="Lat" value="">
                                <input type="hidden" data-val="true" data-val-number="The field Lng must be a number."
                                       id="Lng" name="Lng" value="">
                                <input type="hidden" value="1" data-val="true"
                                       data-val-required="The Type field is required." id="Type" name="Type">
                                <input type="hidden" data-val="true"
                                       data-val-required="The IsCheckout field is required." id="IsCheckout"
                                       name="IsCheckout" value="False">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group d-flex justify-content-between">
                                            <div class="w-50 ml-8">
                                                <label class="text-caption" for="Transferee">نام و نام خانوادگی تحویل
                                                    گیرنده<em class="mr-4 text-danger">*</em></label>
                                                <input type="text" class="form-control " data-val="true"
                                                       data-val-length="نام و نام خانوادگی تحویل گیرنده نمی تواند بیشتر از 150 کاراکتر باشد"
                                                       data-val-length-max="100"
                                                       data-val-required="نام و نام خانوادگی تحویل گیرنده ضروری است"
                                                       id="Transferee" maxlength="100" name="name" value="">
                                                <span class="text-danger field-validation-valid" data-valmsg-for="name" data-valmsg-replace="true"></span>

                                            </div>

                                            <div class="w-50">
                                                <label class="text-caption" for="MobilePhone">شماره همراه<em class="mr-4 text-danger">*</em></label>
                                                <input type="text" class="form-control" data-val="true"
                                                       data-val-regex="فرمت شماره همراه نامعتبر است" data-val-required="شماره ضروری است"
                                                       data-val-regex-pattern="^[0|۰]{1}[9|۹]{1}[۰|0-۹|9]{9}"
                                                       id="MobilePhone" name="mobile" value="">
                                                <span class="text-danger field-validation-valid"
                                                      data-valmsg-for="mobile" data-valmsg-replace="true"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-caption" for="Address">آدرس<em
                                                    class="mr-4 text-danger">*</em></label>
                                            <input type="text" class="form-control" data-val="true"
                                                   data-val-length="آدرس نمی تواند بیشتر از 500 کاراکتر باشد"
                                                   data-val-length-max="500" data-val-required="آدرس ضروری است"
                                                   id="Address" maxlength="500" name="address" value="">
                                            <span class="text-danger field-validation-valid" data-valmsg-for="address"
                                                  data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="form-group d-flex justify-content-between">
                                            <div class="w-20 ml-8">
                                                <label class="text-caption" for="Plaque">پلاک<em
                                                        class="mr-4 text-danger">*</em></label>
                                                <input type="text" class="form-control" dir="ltr" data-val="true"
                                                       data-val-length="پلاک نمی تواند بیشتر از 20 کاراکتر باشد"
                                                       data-val-length-max="20" data-val-required="پلاک ضروری است"
                                                       id="Plaque" maxlength="20" name="plaque" value="">
                                                <span class="text-danger field-validation-valid"
                                                      data-valmsg-for="plaque" data-valmsg-replace="true"></span>
                                            </div>
                                            <div class="w-20 ml-8">
                                                <label class="text-caption" for="Unit">واحد</label>
                                                <input type="text" class="form-control" dir="ltr" data-val="true"
                                                       data-val-length="واحد نمی تواند بیشتر از 20 کاراکتر باشد"
                                                       data-val-length-max="20" id="unit" maxlength="20" name="unit">
                                            </div>
                                            <div class="w-60">
                                                <label class="text-caption" for="PostalCode">کد پستی</label>
                                                <input type="text" class="form-control" dir="ltr" data-val="true"
                                                       data-val-length="کد پستی نمی تواند کمتر از 10 کاراکتر باشد"
                                                       data-val-length-min="10" id="PostalCode" maxlength="10"
                                                       name="postalcode" value="">
                                                <span class="text-danger field-validation-valid"
                                                      data-valmsg-for="postalcode" data-valmsg-replace="true"></span>
                                                <input type="hidden" name="status" value="">
                                                <input type="hidden" name="Map" value="">
                                            </div>
                                        </div>
                                        <!--confirm btn-->
                                        <button type="button" data-click="saveAddress"
                                                class="btn btn-block btn-primary mt-8"><i
                                                class="ico ico-checkbox filter-white"></i>تایید آدرس
                                        </button>
                                    </div>

                                    <div class="col-lg-6">
                                        <!--find address input-->
                                        <div class="input-group mt-16 mb-8" id="SearchLocationResultForm"
                                             autocomplete="off">
                                            <span>برای ثبت آدرس خود، روی مکان مورد نظر روی نقشه کلیک کنید</span>
                                                <div id="app"></div>
                                        </div>


                                    </div>
                                </div>


                            </form>
                            <!--confirm btn end-->
                        </div>
                    </div>
                </div>
            </div>


        </div>


@endsection

@section('script_map')
    <link rel="stylesheet" href="{{asset('map/css/mapp.min.css')}}">
    <link rel="stylesheet" href="{{asset('map/css/fa/style.css')}}" data-locale="true">

    <script type="text/javascript" src="{{asset('map/js/mapp.env.js')}}"></script>
    <script type="text/javascript" src="{{asset('map/js/mapp.min.js')}}"></script>
    <script>

        $('#app').click(function () {

            setTimeout(function(){
                var contents=$('.mapp-modal > .contents').text();
                contents=contents.split('عرض');
                $('input[name=address]').val(contents[0]);
            }, 800);

        })
    </script>
@endsection
@section('script_link')

    <script src="{{asset('assets/js/profile-address.es5.js')}}"></script>

@endsection

@section('script')
    @if(session('save_address'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('آدرس جدید با موفقیت ثبت شد');
        </script>
    @endif
    @if(session('save_address_update'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('آدرس شما با موفقیت ویرایش شد');
        </script>
    @endif

    <script>
        $('.deleteAdddress').click(function () {
            var item=this;
            var data_id=$(this).attr('data-id');
            alertify.confirm("آیا از حذف مطمئن هستید؟",
                function () {
                    $.ajax({
                        type: "post",
                        url: "{{route('address.removeAddress')}}",
                        data: {
                            id: data_id,
                            _token: '{{csrf_token()}}',
                        },
                        dataType: 'json',
                        success: function () {
                            $(item).parents('.item').remove();
                        },
                        error: function (err) {
                            if (err.status == 422) {
                                $('#error_user').slideDown(100);
                                $.each(err.responseJSON.errors, function (i, error) {
                                    $('#error_item').append($('<span style="color: white;">' + error[
                                            0] +
                                        '</span><br>'));
                                });
                            }
                        }
                    });
                },
                function () {

                }).set('labels', {ok: 'بله', cancel: 'خیر!'}).setHeader('<em> پیغام </em> ');
        })


        $('.box-option_label').click(function (){
            var data_id=$(this).parents('.box-option').find('input').val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('address.selectDefaultAddress')}}';
            var data = {_token: CSRF_TOKEN,data_id:data_id};
            $.post(url, data, function (msg) {

            });
        })
        $('#AddNewAddress').click(function () {
            $('#app').empty();
            $('#frmAddAddress input[name=status]').val('insert');
            $('#frmAddAddress input[name=name]').val("");
            $('#frmAddAddress input[name=mobile]').val("");
            $('#frmAddAddress input[name=address]').val("");
            $('#frmAddAddress input[name=plaque]').val("");
            $('#frmAddAddress input[name=unit]').val("");
            $('#frmAddAddress input[name=postalcode]').val("");
            $('#frmAddAddress input[name=data_id]').remove();
            $('.modal-title ').text('افزودن آدرس جدید');
            $(document).ready(function () {
                var app = new Mapp({
                    element: '#app',
                    presets: {
                        latlng: {
                            lat: 36.29991,
                            lng: 50.01080,
                        },
                        zoom: 13
                    },
                    apiKey: '{{setting()['Api_map']}}'
                });
                app.addLayers();
                app.map.on('click', function (e) {
                    var crosshairIcon = {
                        iconUrl: '{{asset('map/assets/images/marker-icon.png')}}',
                        iconSize: [20, 20], // size of the icon
                        iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
                    }

                    var marker = app.addMarker({
                        name: 'advanced-marker',
                        latlng: {
                            lat: e.latlng.lat,
                            lng: e.latlng.lng,
                        },
                        icon: crosshairIcon,
                        popup:false,
                        pan: false,
                        draggable: true,
                        history: false,
                    });
                    $('input[name=Map]').val(marker._latlng);

                    app.showReverseGeocode({
                        state: {
                            latlng: {
                                lat: e.latlng.lat,
                                lng: e.latlng.lng,
                            },
                            zoom: 16,
                        },
                    });

                })
            });

        })
        $('.EditAddress').click(function () {
            $('#app').empty();
            var data_id=$(this).attr('data-id');

            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('address.get_info_address')}}';
            var data = {_token: CSRF_TOKEN,data_id:data_id};
            $.post(url, data, function (msg) {
                $('#frmAddAddress').append(' <input type="hidden" name="data_id" value="'+data_id+'">');
                $('#frmAddAddress input[name=status]').val('update');
                $('#frmAddAddress input[name=name]').val(msg.name);
                $('#frmAddAddress input[name=mobile]').val(msg.mobile);
                $('#frmAddAddress input[name=address]').val(msg.address);
                $('#frmAddAddress input[name=plaque]').val(msg.plaque);
                $('#frmAddAddress input[name=unit]').val(msg.unit);
                $('#frmAddAddress input[name=postalcode]').val(msg.postal_code);
                $('#frmAddAddress input[name=Map]').val(msg.Map);
                $('.modal-title ').text('ویرایش آدرس');
                $(document).ready(function () {
                    var app = new Mapp({
                        element: '#app',
                        presets: {
                            latlng: {
                                lat: msg.lat,
                                lng: msg.lng,
                            },
                            zoom: 13
                        },
                        apiKey: '{{setting()['Api_map']}}'
                    });
                    app.addLayers();
                    app.map.on('click', function (e) {
                        var crosshairIcon = {
                            iconUrl: '{{asset('map/assets/images/marker-icon.png')}}',
                            iconSize: [20, 20], // size of the icon
                            iconAnchor: [10, 10], // point of the icon which will correspond to marker's location
                        }

                        var marker = app.addMarker({
                            name: 'advanced-marker',
                            latlng: {
                                lat: e.latlng.lat,
                                lng: e.latlng.lng,
                            },
                            icon: crosshairIcon,
                            popup:false,
                            pan: false,
                            draggable: true,
                            history: false,
                        });
                        $('input[name=Map]').val(marker._latlng);

                        app.showReverseGeocode({
                            state: {
                                latlng: {
                                    lat: e.latlng.lat,
                                    lng: e.latlng.lng,
                                },
                                zoom: 16,
                            },
                        });

                    })
                });
            });
        })
    </script>
@endsection
@php
    Session::forget('save_address');
    Session::forget('save_address_update');
@endphp
