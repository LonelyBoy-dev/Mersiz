@extends('adminbizness.layout.master')
@section('style_link')
    <link href="{{asset('plugins/nestable/jquery-nestable.css')}}" rel="stylesheet"/>
@endsection
@section('style')
    <style>
        .dd-list li {
            text-align: left;
        }
    </style>
@endsection
@section('Admin_content')
    <div class="col-xs-12 head" style="margin-bottom: 60px;display: flex;justify-content: space-between">
        <div style="min-width: 150px">
            <h2 style="margin-top: 0">
                <i style="float: right;font-size: 29pt;color: #555;" class="material-icons">list</i>
                <b style="color: #555;margin: 3px 5px 0 0;float: right;font-size: 18pt;">منو ساز</b>
            </h2>
        </div>

        <div>
            @can('post_create')
                <a href="{{route('posts.create')}}" type="button" class="btn bg-green waves-effect" title="افزودن جدید">
                    <i class="material-icons">add_circle</i>
                    <span>افزودن منو جدید</span>
                </a>
            @endcan

        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <span>
                        آیتم‌های منوی زیر را بکشید و رها کنید تا چینش آیتم‌ها را تعیین کنید
                    </span>

                </div>
                <div class="body">
                    <div class="clearfix m-b-20">
                        <div class="dd nestable-with-handle">
                            <ol class="dd-list">
                                @php $menus=App\Menu::where('parent','0')->get(); @endphp
                                @foreach($menus as $menu)
                                    <li class="dd-item dd3-item" data-id="{{$menu->id}}">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content">{{$menu->title}}</div>
                                        @php $menus2=App\Menu::where('parent',$menu->id)->get(); @endphp
                                        @if(count($menus2))
                                            <ol class="dd-list">
                                                @foreach($menus2 as $menu2)
                                                    <li class="dd-item dd3-item" data-id="{{$menu2->id}}">
                                                        <div class="dd-handle dd3-handle"></div>
                                                        <div class="dd3-content">{{$menu2->title}}</div>
                                                    </li>
                                                    @php $menus3=App\Menu::where('parent',$menu2->id)->get(); @endphp
                                                    @if(count($menus3))
                                                        <ol class="dd-list">
                                                            @foreach($menus3 as $menu3)
                                                                <li class="dd-item dd3-item" data-id="{{$menu3->id}}">
                                                                    <div class="dd-handle dd3-handle"></div>
                                                                    <div class="dd3-content">{{$menu3->title}}</div>
                                                                </li>
                                                                @php $menus4=App\Menu::where('parent',$menu3->id)->get(); @endphp
                                                                @if(count($menus4))
                                                                    <ol class="dd-list">
                                                                        @foreach($menus4 as $menu4)
                                                                            <li class="dd-item dd3-item" data-id="{{$menu4->id}}">
                                                                                <div class="dd-handle dd3-handle"></div>
                                                                                <div class="dd3-content">{{$menu4->title}}</div>
                                                                            </li>
                                                                            @php $menus5=App\Menu::where('parent',$menu4->id)->get(); @endphp
                                                                            @if(count($menus5))
                                                                                <ol class="dd-list">
                                                                                    @foreach($menus5 as $menu5)
                                                                                        <li class="dd-item dd3-item" data-id="{{$menu5->id}}">
                                                                                            <div class="dd-handle dd3-handle"></div>
                                                                                            <div class="dd3-content">{{$menu5->title}}</div>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ol>

                                                                            @endif
                                                                        @endforeach
                                                                    </ol>

                                                                @endif
                                                            @endforeach
                                                        </ol>

                                                    @endif
                                                @endforeach
                                            </ol>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script_link')
    @php $jquery_min='<script src="{{asset("plugins/jquery/jquery.min.js")}}"></script>'; @endphp
    <script src="{{asset('plugins/nestable/jquery.nestable.js')}}"></script>
@endsection
@section('script')
    <script>
        $(function () {
            $('.dd').nestable();

            $('.dd').on('change', function () {
                var $this = $(this);
                var serializedData = window.JSON.stringify($($this).nestable('serialize'));
                console.log(serializedData)
                $this.parents('div.body').find('textarea').val(serializedData);
            });
        })
    </script>
@endsection
