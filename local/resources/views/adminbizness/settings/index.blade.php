@extends('adminbizness.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection
@section('style')
    <style>
        .card .card-inside-title{
            margin-top: 10px;
        }
        .setting{
            margin-bottom: 0!important;
        }
        [type="radio"]:not(:checked), [type="radio"]:checked{
            right: 0;
            left: auto;
        }
    </style>
    <style>

        #app {
            width: 100%;
            height: 400px;
            direction: ltr;
            z-index: 1;
        }
    </style>
    <link rel="stylesheet" href="{{asset('map/css/mapp.min.css')}}">
    <link rel="stylesheet" href="{{asset('map/css/fa/style.css')}}" data-locale="true">
@endsection

@section('Admin_content')

    <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
        <div style="min-width: 150px">
            <h2 style="margin-top: 0">
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">settings_applications</i>
                <b style="color: #555;margin: 7px 5px 0 0;float: right;font-size: 18pt;">تنضیمات سایت</b>
            </h2>
        </div>

    </div>



    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <form method="POST" action="{{route('settings.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="body">
                            @foreach($settings as $setting)
                                @if($setting->type=="img")
                                    <h2 class="card-inside-title">{{$setting->title}}</h2>
                                    <div class="row clearfix">
                                        <div class="col-sm-12 setting">
                                            <div class="form-group">
                                                <img width="150" height="150" src="{{asset($setting->value)}}">
                                                <div class="form-line">
                                                    <input type="file" name="{{$setting->setting}}" class="form-control" value="{{$setting->value}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                    @if($setting->type=="text")
                                    <h2 class="card-inside-title">{{$setting->title}}</h2>
                                    <div class="row clearfix">
                                        <div class="col-sm-12 setting">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="{{$setting->setting}}" class="form-control" value="{{$setting->value}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                    @if($setting->type=="number")
                                    <h2 class="card-inside-title">{{$setting->title}}</h2>
                                    <div class="row clearfix">
                                        <div class="col-sm-12 setting">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" name="{{$setting->setting}}" class="form-control" value="{{$setting->value}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                    @if($setting->type=="text2")

                                        <div class="">
                                            <div class="col-sm-6 setting" style="float: right">
                                                <h2 class="card-inside-title">{{$setting->title}}</h2>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" name="{{$setting->setting}}" class="form-control" value="{{$setting->value}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($setting->type=="enum")
                                    <h2 class="card-inside-title">{{$setting->title}}</h2>
                                    <div class="row clearfix">
                                        <div class="col-sm-12 setting">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input name="{{$setting->setting}}" type="radio" id="radio_1" @if($setting->value=="true")checked="" @endif value="true">
                                                    <label for="radio_1">فعال</label>

                                                    <input name="{{$setting->setting}}" type="radio" id="radio_2" value="false" @if($setting->value=="false")checked="" @endif>
                                                    <label for="radio_2">غیر فعال</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                    @if($setting->type=="select")
                                        @if ($setting->setting!="currency")
                                            <h2 class="card-inside-title">{{$setting->title}}</h2>
                                            <div class="row clearfix">
                                                <div class="col-sm-12 setting">
                                                    <div class="form-group form-float">
                                                        <select name="{{$setting->setting}}" class="selectpicker form-control show-tick">
                                                            <?php $value = explode('/', $setting->orgv); ?>
                                                            @foreach($value as $item)
                                                                <option @if($item == $setting->orgv) selected @endif value="{{$item}}">{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    @endif

                                    @if($setting->type=="text_editor")
                                <h2 class="card-inside-title">{{$setting->title}}</h2>
                                <div class="row clearfix">
                                    <div class="col-sm-12 setting">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea type="text" id="editor1" name="{{$setting->setting}}" class="form-control " value="">{{$setting->value}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @endif
                                    @if($setting->type=="map")
                                <h2 class="card-inside-title">{{$setting->title}}</h2>
                                <div class="row clearfix">

                                        <div id="app"></div>
                                        <input id="map-id" type="hidden" value="{{setting()['map']}}" name="{{$setting->setting}}" >
                                </div>
                                    @endif
                                    @if($setting->type=="textarea")
                                        <h2 class="card-inside-title">{{$setting->title}}</h2>
                                        <div class="row clearfix">
                                            <div class="col-sm-12 setting">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea type="text" rows="3" name="{{$setting->setting}}" class="form-control " >{{$setting->value}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="row clearfix">
                                    <div class="col-sm-12 setting">
                                        <div class="form-group">
                                            <button type="submit" style="float:left;" class="btn btn-success waves-effect">بروزرسانی</button>
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    @php
        $mapss=explode('(',setting()['map']);
        $maps=str_replace(array( '(', ')' ), '', $mapss[1]);
        $map=explode(',',$maps);
        if (setting()['map']==""){
            $lat="35.73249";
            $lng="51.42268";
        }else{
            $lat=$map[0];
            $lng=$map[1];
        }
    @endphp
@endsection


@section('script_map')
    <script type="text/javascript" src="{{asset('map/js/mapp.env.js')}}"></script>
    <script type="text/javascript" src="{{asset('map/js/mapp.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var app = new Mapp({
                element: '#app',
                presets: {
                    latlng: {
                        lat: {{$lat}},
                        lng: {{$lng}},
                    },
                    zoom: 13
                },
                apiKey: '{{setting()['Api_map']}}'
            });
            app.addVectorLayers();
            // Add in a crosshair for the map
            var crosshairIcon = L.icon({
                iconUrl: '{{asset('map/assets/images/marker-icon.png')}}',
                iconSize:     [20, 20], // size of the icon
                iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
            });
            crosshairMarker = new L.marker(app.map.getCenter(), {icon: crosshairIcon, clickable:false});
            crosshairMarker.addTo(app.map);
            // Move the crosshair to the center of the map when the user pans
            app.map.on('move', function(e) {
                crosshairMarker.setLatLng(app.map.getCenter());
            });
            crosshairMarker.on('click', function(event){
                $('#map-id').val(event.latlng)
            });


        });
        $('#app').click(function () {

            setTimeout(function(){
                var contents=$('.mapp-modal > .contents').text();
                contents=contents.split('عرض');
                $('input[name=address]').val(contents[0]);
            }, 500);

        })
    </script>
@endsection

@section('script')

    <script>
        @if(session('change_setting'))
        $.notify({
            // options
            message: '<i style="float: right;margin-top: -3px;margin-left: 10px" class="material-icons">warning</i> <span style="float: right"> {{session('change_setting')}}</span>',
            icon: '',
        }, {
            // settings
            type: 'success',
            allow_dismiss:false,
            placement: {
                from: "top",
                align: "left"
            },
            animate: {
                enter: 'animated fadeIn',
                exit: 'animated fadeOut'
            }
        });
        @endif
    </script>

@endsection
<?php
Session::forget('change_setting');
?>

