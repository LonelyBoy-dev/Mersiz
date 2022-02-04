@extends('menu::layouts.app')

@section('Admin_content')
   @if($menu->id!=1)
        @include('menu::layouts.sidebar')
        <div class="col-xs-12 head">
              <!-- End Navbar -->
             <div class="cx-main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <draggable-menu :menu="{{ $menu }}" prefix="{{ menu_base_url().menu_prefix() }}"></draggable-menu>
                        </div>
                    </div>
                 </div>
            </div>

       </div>
   @else
       <script>window.location = "/admin/menu/builder/3";</script>

    @endif
@endsection
