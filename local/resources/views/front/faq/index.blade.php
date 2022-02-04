@extends('front.layout.master')
@section('style')

@endsection
@section('content')
    <div class="container my-16">

        <div class="card">

            <!--card header-->
            <div class="card-header card-header-right-border">
                <div class="card-header_caption">
                    <div class="card-header_caption-title">
                        <div class="card-header_caption-text">سوالات متداول</div>
                    </div>
                </div>
            </div>
            <!--card header end-->
            <!--card body-->
            <div class="card-body">

<!--                <div class="text-center h5 font-weight-bold my-16">سوال شما در کدام دسته بندی قرار می‌گیرد؟</div>


                &lt;!&ndash;tab and tab content&ndash;&gt;
                <ul class="nav nav-tabs nav-tabs_icon d-flex justify-content-center my-24 mx-auto" id="myTab" role="tablist">
                    &lt;!&ndash;tab item active&ndash;&gt;
                    <li class="nav-item">
                        <a class="nav-link active" id="icon-tab_0" data-toggle="tab" href="#tab-body_0" role="tab" aria-controls="tab-body_0" aria-selected="true">
                            <div class="nav-link_icon"><i class="ico ico-bag"></i></div>
                            <div class="nav-link_subtitle">خرید</div>
                        </a>
                    </li>
                    &lt;!&ndash;tab item active end&ndash;&gt;
                    &lt;!&ndash;tab item active&ndash;&gt;
                    <li class="nav-item">
                        <a class="nav-link" id="icon-tab_1" data-toggle="tab" href="#tab-body_1" role="tab" aria-controls="tab-body_1" aria-selected="false">
                            <div class="nav-link_icon"><i class="ico ico-user"></i></div>
                            <div class="nav-link_subtitle">معرفی</div>
                        </a>
                    </li>
                    &lt;!&ndash;tab item active end&ndash;&gt;
                    &lt;!&ndash;tab item active&ndash;&gt;
                    <li class="nav-item">
                        <a class="nav-link" id="icon-tab_2" data-toggle="tab" href="#tab-body_2" role="tab" aria-controls="tab-body_2" aria-selected="false">
                            <div class="nav-link_icon"><i class="ico ico-deliver"></i></div>
                            <div class="nav-link_subtitle">تحویل</div>
                        </a>
                    </li>
                    &lt;!&ndash;tab item active end&ndash;&gt;
                    &lt;!&ndash;tab item active&ndash;&gt;
                    <li class="nav-item">
                        <a class="nav-link" id="icon-tab_3" data-toggle="tab" href="#tab-body_3" role="tab" aria-controls="tab-body_3" aria-selected="false">
                            <div class="nav-link_icon"><i class="ico ico-wallet"></i></div>
                            <div class="nav-link_subtitle">پرداخت</div>
                        </a>
                    </li>
                    &lt;!&ndash;tab item active end&ndash;&gt;
                    &lt;!&ndash;tab item active&ndash;&gt;
                    <li class="nav-item">
                        <a class="nav-link" id="icon-tab_4" data-toggle="tab" href="#tab-body_4" role="tab" aria-controls="tab-body_4" aria-selected="false">
                            <div class="nav-link_icon"><i class="ico ico-deliver_not"></i></div>
                            <div class="nav-link_subtitle">مرجوعی</div>
                        </a>
                    </li>
                    &lt;!&ndash;tab item active end&ndash;&gt;
                    &lt;!&ndash;tab item active&ndash;&gt;
                    <li class="nav-item">
                        <a class="nav-link" id="icon-tab_5" data-toggle="tab" href="#tab-body_5" role="tab" aria-controls="tab-body_5" aria-selected="false">
                            <div class="nav-link_icon"><i class="ico ico-question"></i></div>
                            <div class="nav-link_subtitle">عمومی</div>
                        </a>
                    </li>
                    &lt;!&ndash;tab item active end&ndash;&gt;
                </ul>
                <div class="tab-content" id="myTabContent">-->
                    <!--tab body active-->
                    <div class="tab-pane fade show active" id="tab-body_0" role="tabpanel" aria-labelledby="icon-tab_0">
                        <!--begin::Section-->
                        @foreach($faqs as $faq)
                        <div class="m-accordion m-accordion--default" id="m_accordion_0" role="tablist{{$faq->id}}">

                            <!--begin::Item-->
                            <div class="m-accordion__item">
                                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_0_item_0_head" data-toggle="collapse" href="#m_accordion_{{$faq->id}}_item_0_body" aria-expanded="false">
                                    <span class="m-accordion__item-title">{{$faq->Question}}</span>
                                    <span class="m-accordion__item-mode"></span>
                                </div>
                                <div class="m-accordion__item-body collapse" id="m_accordion_{{$faq->id}}_item_0_body" role="tabpanel" aria-labelledby="m_accordion_0_item_0_head" data-parent="#m_accordion_0">
                                    <div class="m-accordion__item-content">
                                        <?= $faq['Answer'] ?>
                                    </div>
                                </div>
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Section-->
                        @endforeach



                    </div>
                    <!--tab body active end-->

                </div>
                <!--tab and tab content end-->

            </div>
            <!--card body end-->

        </div>

    </div>
@endsection
