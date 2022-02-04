
@if ($menu->menu_id==1)
    @can($menu->middleware)

        <li data-id="{{$menu->id}}" class="@if ($menu->custom_class=="")menu_item @else {{$menu->custom_class}} @endif">
            <a target="{{$menu->target}}" href="{{ menu_url($menu) }}">
                <span class="menu-icon"></span>{!! $menu->icon !!}
                <span class="menu-title">{{ $menu->title }}</span>
            </a>
            @if (count($menu->children) > 0)
                <ul class="
        level_{{ ++$i }}
                {{ menu_lebel_show($settings['levels'], 'level_'.$i) }}
                {{ menu_lebel_position($settings['levels'], 'level_'.$i) }}">
                    @foreach($menu->children as $menu)
                        @include(
                            'menu::menus.recursive',
                            [
                                'menu'=>$menu,
                                'settings'=>$settings,
                                'i' => $i
                            ])
                    @endforeach
                </ul>
            @endif
        </li>
    @endcan





@else

    @php $agent=new Jenssegers\Agent\Agent();@endphp
    @if ($agent->isMobile())
        <li class="menu-li">
            <div class="d-flex align-items-center">
                <a @if(count($menu->children))href="#homeSubmenu-{{$menu->id}}" @else href="{{$menu->url}}" @endif class="menu-parent" @if(count($menu->children))data-toggle="collapse" @endif aria-expanded="false">{{ $menu->title }}</a>
            </div>
            @if (count($menu->children) > 0)
            <ul class="collapse" id="homeSubmenu-{{$menu->id}}" data-parent="#menuCollapseParent" style="">
                @php $ferst=1; @endphp
                @foreach($menu->children as $menu)
                <li>
                    <div class="d-flex align-items-center">
                        <a @if(count($menu->children))href="#homeSubmenu-{{$menu->id}}" @else href="{{$menu->url}}" @endif class="menu-parent" @if(count($menu->children))data-toggle="collapse" @endif aria-expanded="false">{{$menu->title}}</a>
                    </div>
                    <ul class="collapse" id="homeSubmenu-{{$menu->id}}" data-parent="#homeSubmenu-{{$menu->id}}">
                        @foreach($menu->children as $ch_menus2)
                        <li>
                            <div class="d-flex align-items-center">
                                <a @if(count($ch_menus2->children))href="#homeSubmenu-{{$ch_menus2->id}}" @else href="{{$ch_menus2->url}}" @endif class="menu-parent"  @if(count($ch_menus2->children))data-toggle="collapse" @endif aria-expanded="false">{{$ch_menus2->title}}</a>
                            </div>
                            <ul class="collapse" id="homeSubmenu-{{$ch_menus2->id}}" data-parent="#homeSubmenu-{{$ch_menus2->id}}">
                                @foreach($ch_menus2->children as $menu3)
                                <li><a href="{{$menu3->link}}">{{$menu3->title}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </li>
                    @php $ferst++; @endphp
                    <?php $menus2[]=$menu->children ?>
                @endforeach
            </ul>
            @endif
        </li>
    @else

    <li class="nav-item dropdown dropdown-keepopen mega-dropdown">
        <a class="nav-link @if(count($menu->children))dropdown-toggle @endif" href="{{ menu_url($menu) }}" role="button" data-id="{{$menu->id}}"
           @if(count($menu->children))data-toggle="dropdown" @endif data-behavior="hover" aria-haspopup="true"
           aria-expanded="false">{{ $menu->title }}</a>
    @if (count($menu->children) > 0)
        <!--mega menu-->
            <div class="dropdown-menu mega-menu">

                <!--mega-menu container-->
                <div class="mega-menu_container">

                    <!--side categories menu-->
                    <aside class="col-lg-2">
                        <div class="mega-menu_category">
                            <div class="list-group list-group-flush m-0" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                @php $ferst=1;$menu_id=[]; @endphp

                                @foreach($menu->children as $menu)

                                    <a class="list-group-item list-group-item-action @if($ferst==1)active @endif"
                                       onclick="location.href=&#39;/{{$menu->url}}&#39;;" id="v-tab-{{$menu->id}}"
                                       tab-toggle="hover" data-toggle="tab" data-target="#v-content-{{$menu->id}}"
                                       href="/{{$menu->url}}" role="tab" aria-controls="v-content-{{$menu->id}}"
                                       aria-selected="true">{{$menu->title}}</a>
                                    @php $ferst++; @endphp
                                    <?php $menus2[]=$menu->children; $menu_id[]=$menu->id; ?>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                    <!--side categories menu end-->
                    <!--mega-menu_content-->

                    <div class="col-lg-10" id="mega-menu_content_4">
                        <div class="tab-content">
                            @php $ferst=1;$item=0; @endphp
                            @foreach($menus2 as $ch_menus2)
                               
                            <div class="tab-pane @if($ferst==1) active @endif" id="v-content-{{@$menu_id[$item]}}" role="tabpanel" aria-labelledby="v-tab-{{@$menu_id[$item]}}">
                                <div class="mega-menu_content">
                                    <!--menu links-->
                                    <div class="col-lg-12">
                                        <div class="mega-menu_sublist-container">


                                            <!--menu-row-->
                                            <ul class="mega-menu_sublist-row">
                                                <!--title-->
                                                @foreach($ch_menus2 as $menu2)
                                                <li class="mega-menu_sublist-item">
                                                    <a class="mega-menu_sublist-title"
                                                       href="/{{$menu2->url}}">{{$menu2->title}}</a>
                                                </li>
                                                <!--title end-->
                                                <!--link item-->
                                               @foreach($menu2->children as $menu3)
                                                    <li class="mega-menu_sublist-item">
                                                        <a class="mega-menu_sublist-link"
                                                           href="/{{$menu3->url}}">{{$menu3->title}}</a>
                                                    </li>
                                               @endforeach
                                            @endforeach
                                                <!--link item end-->
                                                <!--link item end-->
                                            </ul>
                                            <!--menu-row end-->
                                            <!--show more-->


                                          {{--  <div class="mega-menu_sublist-more">
                                                <a href="/{{$menu->url}}"><i
                                                        class="ico ico-plus"></i>مشاهده موارد بیشتر</a>
                                            </div>--}}
                                            <!--show more end-->

                                        </div>
                                    </div>
                                    <!--menu links end-->
                                    <!--menu picture-->
                                    <div class="col-lg-4">
                                        <div class="mega-menu_adplacement">
                                            <a class="mega-menu_adplacement-item" title="some thing">

                                            </a>
                                        </div>
                                    </div>
                                    <!--menu picture end-->
                                </div>
                            </div>

                                @php $ferst++;$item++; @endphp
                            @endforeach
                        </div>
                    </div>

                    <!--mega-menu_content end-->
                </div>
                <!--mega-menu container end-->
            </div>
            <!--mega menu end-->
        @endif
    </li>
        @endif
@endif

