@extends('front.layout.master')

@section('content')

    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">خانه</a></li>
                    <li class='active'>دسته بندی</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row'>
                <div class='col-xs-12 col-sm-12 col-md-3 sidebar'>
                    <!-- ================================== TOP NAVIGATION ================================== -->
                    <!-- /.side-menu -->
                    <!-- ================================== TOP NAVIGATION : END ================================== -->
                    <div class="sidebar-module-container">
                        <div class="sidebar-filter">
                            <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                            <!-- ============================================== COLOR============================================== -->
                            <form id="form-filter-attribute" method="post" action="{{route('shop.doSearch')}}"
                                  enctype="multipart/form-data">
                            <?php $st=1; ?>
                            @foreach($attributes as $attribute)
                                <?php $st++ ?>
                            <div class="sidebar-widget">
                                <div class="widget-header">
                                    <h4 class="widget-title">{{$attribute->title}}</h4>
                                </div>
                                <div class="sidebar-widget-body">
                                    <ul class="list">
                                        <?php $row=1; ?>
                                        @foreach($attribute->attribute_values as $attribute_value)
                                        <li><input class="filte_right" name="attr-<?=$attribute['id']?>[]" value="{{$attribute_value->id}}" type="checkbox" ><span style="margin-right: 5px">{{$attribute_value->value}}</span></li>
                                                <?php $row++; ?>
                                            @endforeach
                                    </ul>
                                </div>
                                <!-- /.sidebar-widget-body -->
                            </div>
                        @endforeach
                            <!-- /.sidebar-widget -->
                            </form>
                        </div>
                        <!-- /.sidebar-filter -->
                    </div>
                    <!-- /.sidebar-module-container -->
                </div>
                <!-- /.sidebar -->
                <div class="col-xs-12 col-sm-12 col-md-9 rht-col">
                    <!-- ========================================== SECTION – HERO ========================================= -->




                    <div class="clearfix filters-container m-t-10">
                        <div class="row">
                            <!-- /.col -->
                            <div class="col col-sm-6 col-md-6 col-xs-6 col-lg-6 text-left">
                                <div class="pagination-container">
                                    <div class="product-short">
                                        <p style="float: right">مرتب سازی بر اساس:</p>
                                        <select style="float: right" name="sort" id="sort" onchange="doSearch()">
                                            <option value="new">جدید ترین</option>
                                            <option value="sell">پرفروش ترین</option>
                                            <option value="view">پرپازدیدترین</option>
                                            <option value="priceLow">ارزان ترین</option>
                                            <option value="priceHigh">گران ترین</option>
                                        </select>
                                    </div>
                                    <!-- /.list-inline -->
                                </div>
                                <!-- /.pagination-container -->
                            </div>
                            <!-- /.col -->
                            <div class="col col-sm-6 col-md-4 col-lg-4 hidden-sm">
                                <div class="col col-sm-6 col-md-6 no-padding">
                                    <div class="lbl-cnt"> <span class="lbl">مرتب سازی براساس</span>
                                        <div class="toolbar-amount">
                                            <select id="limit" name="limit" onchange="doSearch()">
                                                <option value="10">10 آیتم در هر صفحه</option>
                                                <option value="20">20 آیتم در هر صفحه</option>
                                                <option value="30">30 آیتم در هر صفحه</option>
                                            </select>
                                        </div>
                                        <!-- /.fld -->
                                    </div>
                                    <!-- /.lbl-cnt -->
                                </div>
                                <!-- /.col -->

                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="search-result-container ">
                        <div id="myTabContent" class="tab-content category-list">
                            <div class="tab-pane active " id="grid-container">
                                <div class="category-product">
                                    <div class="row" id="products">
                                        @foreach($productItems as $item)
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="item">
                                                <div class="products">
                                                    <div class="product">
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a href="/product/{{$item->slug}}">
                                                                    <img src="{{asset($item->image)}}" alt="{{$item->title}}">
                                                                </a>
                                                            </div>
                                                            <!-- /.image -->
                                                            @if($item->discount>0)
                                                            <div class="tag new"><span>{{$item->discount}}%</span></div>
                                                            @endif
                                                        </div>
                                                        <!-- /.product-image -->

                                                        <div class="product-info text-right">
                                                            <h3 class="name"><a href="/product/{{$item->slug}}">{{Illuminate\Support\Str::limit($item->title,37)}}</a></h3>
                                                            {{--<div class="rating rateit-small"></div>
                                                            <div class="description"></div>--}}
                                                            @if($item->discount>0)
                                                                <div class="product-price"> <span class="price"> {{number_format($item->price*(100-$item->discount)/100)}} تومان </span> <span class="price-before-discount">{{number_format($item->price)}} تومان</span> </div>
                                                            @else
                                                                <div class="product-price"> <span class="price"> {{number_format($item->price)}} تومان </span></div>
                                                            @endif

                                                        </div>
                                                        <!-- /.product-info -->
                                                        <div class="cart clearfix animate-effect">
                                                            <div class="action">
                                                                <ul class="list-unstyled">
                                                                    @if($item->depot>0)
                                                                        <li class="add-cart-button btn-group" onclick="addcart(this,'{{$item->id}}')">
                                                                            <button data-toggle="tooltip" class="btn btn-primary icon" type="button" title=""> <i class="fa fa-shopping-cart"></i> </button>
                                                                            <button class="btn btn-primary cart-btn" type="button">افزودن به سبد</button>
                                                                        </li>
                                                                    @else
                                                                        <li class="add-cart-button btn-group">
                                                                            <button data-toggle="tooltip" class="btn btn-primary icon" type="button" title=""> ناموجود</button>
                                                                        </li>
                                                                    @endif
                                                                    @php
                                                                        $favorite=App\Favorite::where(['user_id'=>Auth::id(),'product_id'=>$item->id])->first()
                                                                    @endphp
                                                                    @if(empty($favorite))
                                                                        <li class="lnk wishlist"  onclick="favorite(this,{{$item->id}})"> <a data-toggle="tooltip" class="add-to-cart" title=""> <i class="icon fa fa-heart"></i> </a> </li>
                                                                    @else
                                                                        <li class="lnk wishlist" style="color: red" onclick="favorite(this,{{$item->id}})"> <a data-toggle="tooltip" class="add-to-cart" title=""> <i class="icon fa fa-heart"></i> </a> </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                            <!-- /.action -->
                                                        </div>
                                                        <!-- /.cart -->
                                                    </div>
                                                    <!-- /.product -->

                                                </div>
                                                <!-- /.products -->
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.category-product -->

                            </div>
                            <!-- /.tab-pane -->

                        </div>
                        {{$productItems->links()}}
                    </div>
                    <!-- /.search-result-container -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->

            <!-- /.logo-slider -->
            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
        </div>
        <!-- /.container -->

    </div>
    <!-- /.body-content -->
    <!-- ============================================================= FOOTER ============================================================= -->


@endsection


@section('script')
    <script>
        $('.filte_right').click(function () {
            var tag=this;
            if ($(tag).is(':checked')){
                doSearch();
            }else{
                doSearch();
            }
        });
    </script>
    <script>
        function doSearch() {
            var dataval=$('#form-filter-attribute').serializeArray();

            var limit=$('#limit').val();
            var sort=$('#sort').val();
            var minamount=parseInt($('#minamount').val());
            var maxamount=parseInt($('#maxamount').val());
            $('#products').empty()
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('shop.doSearch')}}';
            var data = {_token: CSRF_TOKEN, dataval:dataval,limit:limit,sort:sort,minamount:minamount,maxamount:maxamount};
            $.post(url, data, function (msg) {
                console.log(msg)
                $('#products').append(msg)
            })
            /*$.ajax({
                type: "post",
                url: "{{route('shop.doSearch')}}",
                data: {
                    data:dataval,
                    exist: "0",
                    _token: '{{csrf_token()}}',
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data.msg);

                },
                error: function (err) {
                    if (err.status == 422) {

                    }
                }
            });*/
        }

    </script>
    <script type="text/javascript">
        function ChangeUrl(page, url) {
            var obj = { Page: page, Url: url };
            history.pushState(obj, obj.Page, 'shop?'+obj.Url);
        }
        $(function () {
            $("#button1").click(function () {
                ChangeUrl('Page1', 'Page1.htm');
            });
            $("#button2").click(function () {
                ChangeUrl('Page2', 'Page2.htm');
            });
            $("#button3").click(function () {
                ChangeUrl('Page3', 'Page3.htm');
            });
        });
    </script>
@endsection
