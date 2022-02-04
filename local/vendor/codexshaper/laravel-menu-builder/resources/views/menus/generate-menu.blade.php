<ul class="level_root list {{ $settings['levels']['root']['style'] }}">
    @php $agent=new Jenssegers\Agent\Agent();@endphp
    @if ($agent->isMobile())
        <?php
        $categories=App\Category::where('parent','0')->get();
        ?>
    @foreach($categories as $category)
        @php $level1_parents=App\Category::where('parent',$category->id)->get(); @endphp
        <li class="menu-li">
            <div class="d-flex align-items-center">
                <a @if(count($level1_parents))href="#homeSubmenu-{{$category->id}}" @else href="/search/{{$category->slug}}" @endif class="menu-parent" @if(count($level1_parents)) data-toggle="collapse" @endif aria-expanded="false">{{$category->title}}</a>
            </div>
            @if(count($level1_parents))
                <ul class="collapse" id="homeSubmenu-{{$category->id}}" data-parent="#menuCollapseParent" style="">
                    @foreach($level1_parents as $level1_parent)
                        @php $level2_parents=App\Category::where('parent',$level1_parent->id)->get(); @endphp
                        <li>
                            <div class="d-flex align-items-center">
                                <a @if(count($level2_parents))href="#homeSubmenu-{{$level1_parent->id}}" a:fa @else href="/search/{{$level1_parent->slug}}" @endif  class="menu-parent"  @if(count($level2_parents))data-toggle="collapse" @else style="content: unset" @endif aria-expanded="false">{{$level1_parent->title}}</a>
                            </div>

                            <ul class="collapse" id="homeSubmenu-{{$level1_parent->id}}" data-parent="#homeSubmenu-{{$level1_parent->id}}">
                                @foreach($level2_parents as $level2_parent)
                                    @php $level3_parents=App\Category::where('parent',$level2_parent->id)->get(); @endphp
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <a @if(count($level3_parents))href="#homeSubmenu-{{$level2_parent->id}}" @else href="/search/{{$level2_parent->slug}}" @endif class="menu-parent" @if(count($level3_parents))data-toggle="collapse" @else style="content: unset" @endif aria-expanded="false">{{$level2_parent->title}}</a>
                                        </div>
                                        <ul @if(count($level3_parents)) class="collapse" @endif id="homeSubmenu-{{$level2_parent->id}}" data-parent="#homeSubmenu-{{$level2_parent->id}}">
                                            @foreach($level3_parents as $level3_parent)
                                           <li><a href="/search/{{$level3_parent->slug}}">{{$level3_parent->title}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                </ul>
                @endif

        </li>
            @endforeach
    @else
        <?php
        $categories=App\Category::where('parent','0')->get();
        ?>
        @foreach($categories as $category)
                @php $level1_parents=App\Category::where('parent',$category->id)->get(); @endphp
                <li class="nav-item dropdown dropdown-keepopen mega-dropdown">
                    <a class="nav-link @if(count($level1_parents))dropdown-toggle @endif" href="/search/{{$category->slug}}" role="button" data-id="{{$category->id}}"
                       @if(count($level1_parents))data-toggle="dropdown" @endif data-behavior="hover" aria-haspopup="true"
                       aria-expanded="false">{{ $category->title }}</a>
                @if (count($level1_parents) > 0)
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

                                            @foreach($level1_parents as $level1_parent)

                                                <a class="list-group-item list-group-item-action @if($ferst==1)active @endif"
                                                   onclick="location.href=&#39;/{{$level1_parent->slug}}&#39;;" id="v-tab-{{$level1_parent->id}}"
                                                   tab-toggle="hover" data-toggle="tab" data-target="#v-content-{{$level1_parent->id}}"
                                                   href="/search/{{$level1_parent->slug}}" role="tab" aria-controls="v-content-{{$level1_parent->id}}"
                                                   aria-selected="true">{{$level1_parent->title}}</a>
                                                @php $ferst++; @endphp
                                                @php $level2_parents[]=App\Category::where('parent',$level1_parent->id)->get(); @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </aside>
                                <!--side categories menu end-->
                                <!--mega-menu_content-->

                                <div class="col-lg-10" id="mega-menu_content_4">
                                    <div class="tab-content">
                                        @php $ferst=1;$item=0; @endphp

                                        @foreach($level2_parents as $level2_parent)
                                            @php $level3_parents=App\Category::where('parent',@$level2_parent[0]['id'])->get(); @endphp
                                            <div class="tab-pane @if($ferst==1) active @endif" id="v-content-{{@$level2_parent[0]['parent']}}" role="tabpanel" aria-labelledby="v-tab-{{@$level2_parent[0]['parent']}}">
                                                <div class="mega-menu_content">
                                                    <!--menu links-->
                                                    <div class="col-lg-12">
                                                        <div class="mega-menu_sublist-container">


                                                            <!--menu-row-->
                                                            <ul class="mega-menu_sublist-row">
                                                                <!--title-->

                                                                    <li class="mega-menu_sublist-item">
                                                                        <a class="mega-menu_sublist-title"
                                                                           href="/search/{{@$level2_parent[0]['slug']}}">{{@$level2_parent[0]['title']}}</a>
                                                                    </li>
                                                                    <!--title end-->
                                                                    <!--link item-->

                                                                    @foreach($level3_parents as $level3_parent)
                                                                        <li class="mega-menu_sublist-item">
                                                                            <a class="mega-menu_sublist-link"
                                                                               href="/search/{{$level3_parent->slug}}">{{$level3_parent->title}}</a>
                                                                        </li>
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
            @endforeach

    @endif


    @foreach ($menuItems as $menu)
        @can($menu->middleware)
        @include(
        	'menu::menus.recursive',
        	[
        		'menu'=>$menu,
        		'settings'=>$settings,
        		'i' => 0
        	])
        @endcan
    @endforeach
</ul>
