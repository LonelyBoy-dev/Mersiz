                <!--today-offer-->
                <div class="col-xl-3 order-xl-0 order-1">
                    <!--today-offer-->
                    <div class="card card-equal-height">

                        <a class="card-header bg-gradient-primary card-header-slim text-white">

                            <div class="card-header_caption mx-auto">
                                <div class="card-header_caption-title">
                                    <div class="card-header_caption-text">{{$content}}</div>
                                </div>
                            </div>

                        </a>

                        <!--slider and card body-->
                        <div class="p-0 d-flex h-100 align-items-center">
                            <!-- Swiper -->
                            <div class="swiper-container swiper-container-single-products swiper-container-horizontal swiper-container-rtl">
                                <div class="swiper-wrapper">
                                    <!--product item-->
                                @php $item_row=1; @endphp
                                @foreach($products_discount as $item)
                                    <!--product item-->
                                        <div class="swiper-slide @if($item_row==4)swiper-slide-prev @elseif($item_row==5) swiper-slide-active @elseif($item_row==6) swiper-slide-next @endif" style="width: 260.2px;">
                                            <div class="product-box product-box_hover">

                                                <!--product image and badge-->
                                                <a href="/product/{{$item->slug}}" class="product-box_image"
                                                   data-click="showProductDetail" data-productid="{{$item->id}}" data-storeid="{{$item->id}}"
                                                   data-supplier="False">
                                                    <img src="{{asset($item->image)}}"
                                                         alt="{{$item->title}}" width="210" height="210"
                                                         class="swiper-lazy swiper-lazy-loaded">
                                                    @if ($item->discount>0)
                                                        <div class="product-box_discount"><span>%{{$item->discount}}<small>تخفیف</small></span></div>
                                                    @endif
                                                </a>
                                                <!--product image and badge end-->
                                                <!--product title-->
                                                <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                                   class="product-box_title text-dark"><h2
                                                        style="font-size: 0.85rem">{{$item->title}}</h2></a>
                                                <!--product title end-->
                                                <!--product content-->
                                                @if ($item->depot>0)
                                                    <div class="product-box_content">

                                                        <!--price-->
                                                        <a href="/product/{{$item->slug}}" data-click="showProductDetail"
                                                           data-productid="{{$item->id}}" class="product-box_price">
                                                            @if ($item->discount>0)
                                                                <div class="product-box_price flex-row flex-nowrap h-auto mb-16">
                                                                    <del class="ml-8">{{number_format($item->price)}}</del>
                                                                    <div class="product-box_price-value">{{number_format($item['price'] * (100-$item['discount']) / 100)}}<span
                                                                            class="product-box_price-currency">{{setting()['currency']}}</span></div>
                                                                </div>
                                                            @else

                                                                <div class="product-box_price flex-row flex-nowrap h-auto mb-16">
                                                                    <div class="product-box_price-value">{{number_format($item->price)}}<span
                                                                            class="product-box_price-currency">{{setting()['currency']}}</span></div>
                                                                </div>
                                                            @endif


                                                        </a>

                                                        <!--price end-->
                                                        <!--action-->
                                                        <div class="product-box_action">
                                                            <button onclick="addcart(this,'{{$item->id}}')" type="button" class="btn btn-gradient-primary add-to-cart pr-8 pl-8"><i class="ico ico-color_plus-circle filter-none"></i>افزودن
                                                                به سبد
                                                            </button>
                                                        </div>
                                                        <!--action btn-->

                                                    </div>
                                                @else
                                                    <div class="product-box_content">
                                                        <a href="/product/{{$item->slug}}" data-click="showProductDetail" data-productid="{{$item->id}}" class="product-box_price">
                                                            <div class="product-box_price-value">تمام شد!</div>
                                                        </a>
                                                        <div class="product-box_action">
                                                            <button type="button" class="btn btn-gradient-secondary request-quantity" data-productid="{{$item->id}}" data-storeid="{{$item->id}}" data-supplier="False">موجود کن</button>
                                                        </div>
                                                    </div>
                                            @endif


                                            <!--product content end-->

                                            </div>
                                        </div>
                                        <!--product item end-->
                                        @php $item_row++; @endphp
                                    @endforeach


                                </div>

                                <!-- Add Arrows -->
                                <div class="swiper-button-next swiper-button-custom d-none d-lg-block swiper-button-disabled"
                                     tabindex="0" role="button" aria-label="Next slide" aria-disabled="true"></div>
                                <div class="swiper-button-prev swiper-button-custom d-none d-lg-block" tabindex="0"
                                     role="button" aria-label="Previous slide" aria-disabled="false"></div>

                            </div>
                        </div>
                        <!--slider and card body end-->

                    </div>
                    <!--today-offer end-->

                </div>
                <!--today-offer end-->
