<section id="brands">

    <div class="container mb-20">

        <div class="card">

            <!--card header-->
            <div class="card-header card-header-right-border">

                <!--header caption-->
                <div class="card-header_caption">
                    <div class="card-header_caption-title">
                        <div class="card-header_caption-text">{{$content}}</div>
                    </div>
                </div>
                <!--header caption end-->
                <!--header tools-->
                <!--header tools end-->

            </div>
            <!--card header end-->
            <!--slider and card body-->
            <div class="position-relative">
                <!-- Swiper -->
                <div class="swiper-container swiper-container-brands swiper-container-horizontal swiper-container-rtl">
                    <div class="swiper-wrapper">
                        <?php $i=1; ?>
                        @foreach($brands as $brand)

                        <div class="swiper-slide @if($i==1)swiper-slide-active @elseif($i==2) swiper-slide-next @endif" @if($i==1 or $i==2) style="width: 260.2px;" @endif>
                            <div class="product-box product-box_hover brand-box">
                                <a href="/brands/mazmaz" class="product-box_image">
                                    <img src="{{asset($brand->imgPath)}}"
                                         alt="{{$brand->alt}}" class="swiper-lazy swiper-lazy-loaded">
                                </a>


                            </div>
                        </div>
                                <?php $i++; ?>
                        @endforeach
                    </div>

                    <!-- Add Arrows -->
                    <div class="swiper-button-next swiper-button-custom d-none d-lg-block" tabindex="0"
                         role="button" aria-label="Next slide" aria-disabled="false"></div>
                    <div class="swiper-button-prev swiper-button-custom d-none d-lg-block swiper-button-disabled"
                         tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                        class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                        class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                        class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
            </div>
            <!--slider and card body end-->

        </div>

    </div>


</section>
