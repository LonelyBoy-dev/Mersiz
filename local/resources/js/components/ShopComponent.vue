<template>
    <div>
        <div class="row small-gutters">

            <!--sidebar wrap-->
            <aside class="col-xl-3 d-none d-xl-block">
                <div class="sidebar-wrapper">
                    <div class="listing-sidebar mb-4">
                        <div class="box-header-product-feature mb-3">
                            <span class="title-product">فیلتر محصولات</span>
                        </div>
                        <form id="form-filter-attribute">
                            <div v-for="(attribute, index) in attributes" class="box">
                                <div class="box-header">
                                    <h2 class="mb-0">
                                        <button class="btn btn-block text-right" data-toggle="collapse"
                                                href="#collapseExample" role="button" aria-expanded="false"
                                                aria-controls="collapseExample">
                                            {{ attribute.title }}
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseExample" class="collapse show">
                                    <div class="card-main mb-3">
                                        <div v-for="attribute_values in attribute.attribute_values" class="form-auth-row">
                                            <label class="ui-checkbox">
                                                <input type="checkbox" @click="addFilter(attribute_values.id,'attr-'+attribute.id+'[]',index)"
                                                       :name="'attr-'+attribute.id+'[]'" :value="attribute_values.id"
                                                       :id="attribute_values.value+'-'+attribute_values.id">
                                                <span class="ui-checkbox-check"></span>
                                            </label>
                                            <label :for="attribute_values.value+'-'+attribute_values.id"
                                                   class="remember-me">{{ attribute_values.value }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <div class="box">
                        <div class="mt-5">
                                                <span @click="getFilterProduct()" class="btn btn-range btn-block">
                                                    اعمال
                                                </span>
                        </div>
                        </div>
                        <!--                        <div class="box">
                                                    <div class="box-header">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-block text-right" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                                                                برند
                                                                <i class="mdi mdi-chevron-down"></i>
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseExample2" class="collapse">
                                                        <div class="card-main mb-3">
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">همه</label>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">آدیداس</label>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">پوما</label>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">نایک</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="box">
                                                    <div class="box-header">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-block text-right" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                                                                فروشنده
                                                                <i class="mdi mdi-chevron-down"></i>
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseExample3" class="collapse">
                                                        <div class="card-main mb-3">
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">دیجی استور</label>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">فروشنده رسمی برند</label>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">فروشنده برگزیده</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-block text-right" data-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
                                                                رنگ
                                                                <i class="mdi mdi-chevron-down"></i>
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseExample4" class="collapse">
                                                        <div class="card-main mb-3">
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">مشکی</label>
                                                                <span class="filter-color" style="background-color: rgb(43,43,43)"></span>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">سفید</label>
                                                                <span class="filter-color" style="background-color: rgb(255,255,255)"></span>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">آبی</label>
                                                                <span class="filter-color" style="background-color: rgb(0,0,255)"></span>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">سبز</label>
                                                                <span class="filter-color" style="background-color: rgb(0,128,0)"></span>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">قرمز
                                                                </label>
                                                                <span class="filter-color" style="background-color: rgb(255,0,0)"></span>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">بنفش</label>
                                                                <span class="filter-color" style="background-color: rgb(128,0,128)"></span>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">صورتی</label>
                                                                <span class="filter-color" style="background-color: rgb(255,192,203)"></span>
                                                            </div>
                                                            <div class="form-auth-row">
                                                                <label class="ui-checkbox">
                                                                    <input type="checkbox" value="1" name="login" id="remember">
                                                                    <span class="ui-checkbox-check"></span>
                                                                </label>
                                                                <label for="remember" class="remember-me">طلایی</label>
                                                                <span class="filter-color" style="background-color: rgb(201,146,18)"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>-->

                        <div class="box">
                            <div class="box-header">
                                <h2 class="mb-0">
                                    <button class="btn btn-block text-right" data-toggle="collapse"
                                            href="#collapseExample5" role="button" aria-expanded="false"
                                            aria-controls="collapseExample5">
                                        محدوده قیمت
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseExample5" class="collapse show">
                                <div class="card-main mb-3">
                                    <div class="box-data">
                                        <div class="mt-5 mb-4">
                                            <div id="slider-non-linear-step"></div>
                                        </div>
                                        <div class="filter-range mt-2 mb-2">
                                            <input id="amountPriceFiltter" v-model="priceFiltter" value=""
                                                   @click="doSearch()">
                                            <span>قیمت: </span>
                                            <span class="example-val" id="slider-non-linear-step-value"></span> تومان
                                        </div>
                                        <div class="mt-5">
                                                <span  class="btn btn-range btn-block" id="sabt-price">
                                                    اعمال محدوده قیمت
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="box">
                            <div class="statusswitcher">
                                <a href="#">
                                    <label for="switch1">
                                        <input type="checkbox" id="switch1"><span class="switch"><h1
                                        class="switch-title">فقط کالای موجود</h1></span>
                                        <span class="toggle"></span>
                                    </label>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </aside>
            <!--sidebar wrap end-->
            <!--product list wrap-->
            <div class="col-xl-9">

                <!--product list action-->
                <div class="d-flex align-items-center mb-16">

                    <!--breadcrumb-->
                    <nav class="ml-auto d-none d-lg-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">خانه</a></li>
                            <li class="breadcrumb-item"><a href="foodstuffs">مواد غذایی</a></li>
                            <li class="breadcrumb-item"><a href="dairy-products">لبنیات</a></li>
                        </ol>
                    </nav>
                    <!--breadcrumb end--><!--sort box-->
                    <div class="d-flex justify-content-lg-end align-items-center">
                        <span>نمایش براساس:</span>
                        <select class="select-css" v-model="sort" >
                            <option value="priceLow">ارزانترین ها</option>
                            <option value="priceHigh">گرانترین ها</option>
                            <option value="discount">پرتخفیف ترین ها</option>
                            <option value="sale">پرفروش ترین ها</option>
                            <option value="view">محبوب ترین ها</option>
                            <option value="new">جدیدترین ها</option>
                        </select>


                    </div>
                    <!--sort box end-->
                </div>


                <!--product list action end-->
                <!--grid product wrap-->
                <div class="card" id="search-box">
                    <div class="card-body">
                        <h1 style="text-align: right">لبنیات</h1>
                        <div class="row small-gutters">


                            <!--product item-->
                            <div v-for="product in products.data" class="col-lg-3 col-md-4 col-sm-6 p-1"
                                 style="width: 260.2px;">
                                <div class="product-box product-box_hover">

                                    <!--product image and badge-->
                                    <a :href="'/product/'+product.slug" class="product-box_image"
                                       data-click="showProductDetail" :data-productid="product.id"
                                       :data-storeid="product.id"
                                       data-supplier="False">
                                        <img :src="'http://127.0.0.1:8000/'+product.image"
                                             alt="product.title" width="210" height="210"
                                             class="swiper-lazy swiper-lazy-loaded">

                                    </a>
                                    <!--product image and badge end-->
                                    <!--product title-->
                                    <a :href="'/product/'+product.slug" data-click="showProductDetail"
                                       :data-productid="product.id" class="product-box_title text-dark"><h2
                                        style="font-size: 0.85rem">{{ product.title }}</h2></a>
                                    <!--product title end-->
                                    <!--product content-->
                                    <div class="product-box_content">

                                        <!--price-->
                                        <a href="" data-click="showProductDetail"
                                           data-productid="11299" class="product-box_price">
                                            <div class="product-box_price-value">100,000 <span
                                                class="product-box_price-currency">{{setting()['currency']}}</span></div>
                                        </a>

                                        <!--price end-->
                                        <!--action-->
                                        <div class="product-box_action">
                                            <button type="button" class="btn btn-gradient-primary add-to-cart pr-8 pl-8"
                                                    data-productid="11299" data-storeid="1966" data-supplier="False"
                                                    data-qty="1"><i class="ico ico-color_plus-circle filter-none"></i>افزودن
                                                به سبد
                                            </button>
                                        </div>
                                        <!--action btn-->

                                    </div>
                                    <!--product content end-->
                                    <!--                                    <div class="product-box_content">

                                                                            &lt;!&ndash;price&ndash;&gt;
                                                                            <a href="/13409" data-click="showProductDetail" data-productid="13409" class="product-box_price">
                                                                                <div class="product-box_price-value">تمام شد!</div>
                                                                            </a>

                                                                            &lt;!&ndash;price end&ndash;&gt;
                                                                            &lt;!&ndash;action&ndash;&gt;
                                                                            <div class="product-box_action">
                                                                                <button type="button" class="btn btn-gradient-secondary request-quantity" data-productid="13409" data-storeid="3530" data-supplier="False"><i class="ico ico-color_check-circle filter-none"></i>موجود کن</button>
                                                                            </div>
                                                                            &lt;!&ndash;action btn&ndash;&gt;

                                                                        </div>-->
                                </div>
                            </div>
                            <!--product item end-->

                        </div>
                    </div>
                    <div class="card-footer bg-white border-top">

                        <nav class="d-flex align-items-center justify-content-center py-8" v-if="products.last_page">
                            <paginate
                                v-model="page"
                                :page-count="products.last_page"
                                :page-range="3"
                                :margin-pages="2"
                                :click-handler="clickCallback"
                                :prev-text="'قبلی'"
                                :next-text="'بعدی'"
                                :container-class="'pagination mb-0 mx-auto'"
                                :page-class="'page-item'">
                            </paginate>

                        </nav>

                    </div>
                </div>
                <div class="tab-pane fade show active" id="tab-body_0" role="tabpanel" aria-labelledby="icon-tab_0">

                </div>

                <!--grid product wrap end-->
            </div>
            <!--product list wrap end-->

        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            products: [],
            attributes: [],
            sort: [],
            priceFiltter: [],
            page: 1,
            paginate: 2,
            attributeGroups: [],
            selectedAttribute: [],
            computedAttribute: [],
            dataval: [],
        }
    },
    props: ['category'],
    mounted() {
        axios.get('/api/products/' + this.category).then(res => {
            console.log(res.data.attributes)
            this.products = res.data.products
            this.attributes = res.data.attributes
        }).catch(err => {
            console.log(err)
        })

    },
    methods: {
        clickCallback: function (pageNum) {
            this.products = [];
            axios.get('/api/products/' + this.category + '?page=' + pageNum).then(res => {
                this.products = res.data.products
            }).catch(err => {
                console.log(err)
            })
        },
        doSearch: function () {
            this.products = [];
            axios.get('/api/doSearch/' + this.category + '?sort=' + this.sort + '&page=' + this.page + '&priceFiltter=' + this.priceFiltter).then(res => {
                this.products = res.data.products
                console.log(res.data.products)
            }).catch(err => {
                console.log(err)
            })
        },
        addFilter: function(event,val, index){
            var dataval=$('#form-filter-attribute').serializeArray();

            for(var i=0; i<this.selectedAttribute.length; i++){
                var current = this.selectedAttribute[i];
                if(current.index == index){
                    this.selectedAttribute.splice(i, 1)
                }
            }
            this.selectedAttribute.push({
                'index': index,
                'event': event,
                'val': val,
            })
            this.dataval.push({
                dataval
            })

            this.computedAttribute = []
            for(var i=0; i<this.selectedAttribute.length; i++){
                this.computedAttribute.push(this.selectedAttribute[i].value)

            }

        },
        getFilterProduct:function (){

            this.products=[];
            var attributesd=JSON.stringify(this.dataval);

            var attributes=JSON.stringify(this.computedAttribute);
            axios.get('/api/filter-product/'+this.category+'/'+this.sort+'/'+this.page+'/'+attributes+'/?page='+this.page).then(res => {

                this.products = res.data.products
            }).catch(err => {
                console.log(err)
            })
        }

    }
}
</script>
