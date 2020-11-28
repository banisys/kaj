@extends('layouts.front.balance')
@section('content')
    <section id="area">
        <div style="opacity:.9;position:absolute;top: 0;left: 0;background-color: white;width: 100%;height: 100vh;z-index: 10000"
             v-if="loader">
            <div id="wave1"></div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div id="carouselExampleIndicators" class="carousel slide mt-1" data-ride="carousel">
                        <ol class="carousel-indicators">

                            <li v-for="(item,index) in slider"
                                data-target="#carouselExampleIndicators"
                                data-slide-to="index" :class="ifActive(index)"></li>

                        </ol>
                        <div class="carousel-inner">

                            <div v-for="(item,index) in slider" :class="[(index===0) ? 'active' : '', 'carousel-item']">
                                <a :href="item.url">
                                    <img class="d-block w-100"
                                         :src="'/images/slider/'+item.image">
                                </a>

                            </div>

                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 pr-0">
                    <img src="https://dkstatics-public.digikala.com/digikala-adservice-banners/1000020101.jpg">
                    <img class="mt-2"
                         src="https://dkstatics-public.digikala.com/digikala-adservice-banners/1000020534.jpg">
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row" style="margin: unset">
                <div class="col-lg-10" style="position: relative">
                    <div class="row pb-1">
                        <div class="col-lg-12">
                            <span style="float: left;font-size: 14px;color: #b1b1b1">
                                 @{{ products.total }} کالا
                            </span>
                        </div>
                    </div>
                    <div class="row shop_container grid_view">
                        <template v-for="(product,index) in products.data">
                            <div class="col-lg-3 col-sm-6" style="padding: 0;">
                                <div class="product"
                                     style="height: 400px;position: relative;border-radius: 0;padding: 15px">
                                    {{--<span class="pr_flash bg_green">فروش</span>--}}
                                    <div class="product_img">
                                        <a href="#" @click.prevent="detail(product.slug)">
                                            <img style="width: 100%;height:100%"
                                                 :src="'/images/product/'+product.image" :alt="product.name">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                @auth
                                                    <li @click.prevent="fav(product.id)">
                                                        <a href="#" style="background-color: #e3342f">
                                                            <i class="fas fa-heart"></i>
                                                        </a>
                                                    </li>
                                                @endauth
                                                <li @click.prevent="detail(product.slug)">
                                                    <a href="#"> <i class="fas fa-eye"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="product_info mb-4">
                                        <h6>
                                            <a href="#" class="pro_name" @click.prevent="detail(product.slug)">
                                                @{{ product.name }}
                                            </a>
                                        </h6>
                                        <div style="position: absolute;bottom:15px;width: 100%;left: 0;padding: 0 15px;">
                                            <span class="price">@{{ calculateDiscount(product.price,product.discount) }}
                                            <span style="font-size:11px">تومان</span>
                                            </span>
                                            <span id="price">@{{ numberFormat(product.price) }}
                                            <span style="font-size:11px">تومان</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3 mt-lg-4" style="text-align: center">
                            <div @click="goUp()" style="display: inline-block">
                                <pagination :data="products" @pagination-change-page="fetchProducts"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 order-lg-first mt-5 mt-lg-0 pt-4" style="padding-right: 0">
                    <div class="sidebar">
                        <div class="widget" style="text-align: right">
                            <ul id="categories">
                                <template v-for="(cat,key,index) in cats">
                                    <li @click.stop="redirectFilter(cat.name)" style="font-size:13px;">
                                        <i class="fas fa-chevron-down"
                                           style="margin-left: 3px;font-size: 12px;color: #100009;"></i>
                                        <span style="color: black;font-weight: bold;">@{{ cat.name }}</span>
                                        <item :cat="cat"></item>
                                    </li>
                                    <hr v-if="cats.length !== key+1"
                                        style="margin-top: .7rem;margin-bottom: .7rem">
                                </template>
                            </ul>
                            <span style="color:#3490dc;text-decoration: underline;cursor: pointer" class="mr-3"
                                  @click="more" v-if="flagMore">+ موارد بیشتر</span>
                            <span style="color:#3490dc;text-decoration: underline;cursor: pointer" class="mr-3"
                                  @click="less" v-if="!flagMore">- موارد کمتر</span>
                        </div>
                    </div>
                    <div class="sidebar mt-4">
                        <div class="widget" style="text-align: right">
                            <input type="text" v-model="search"
                                   style="border-radius: 4px;border: 1px #dddddd solid;padding: 5px 10px;width: 100%"
                                   placeholder="جستجوی نام برند"/>
                            <div class="filter-dropdown"
                                 style="padding:5px 15px;background-color: white;border: 1px solid #dddddd">
                                <ul class="filter-checkboxes mt-3">
                                    <li v-for="brand in filteredList" class="categor-li">
                                        <input class="checked" type="checkbox"
                                               :value="brand.name"
                                               :id="replaceUnder(brand.name)"
                                               @change="changeBrand(brand.name)">
                                        <label class="pr-4" :for="replaceUnder(brand.name)">
                                            <div class="col-12 float-right" style="padding: 0 7px;">
                                                <span>@{{ brand.name }}</span>
                                                <span style="float: left;color: grey">@{{ brand.name_f }}</span>
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="offers.length" class="row mt-4 mb-3 pb-2 mx-3" style="border-bottom: 1px solid #dbdbdb">
                <div class="col-12 pr-3">
                    <i class="fas fa-star" style="color: rgb(204, 185, 0)"></i>
                    <span style="color: #25659a;padding: 2px;width: 100%;font-size: 19px;">پیشنهاد به شما</span>
                </div>
            </div>
            <div class="row" v-if="offers.length">
                <div class="small_divider clearfix"></div>
                <div class="product_slider carousel_slide5 owl-carousel owl-theme nav_top_right2 px-4"
                     data-margin="0"
                     data-nav="true" data-dots="false">
                    <template v-for="(product,index) in offers">
                        <div class="item">
                            <div class="product"
                                 style="height: 400px;position: relative;border-radius: 0;padding: 15px">
                                {{--<span class="pr_flash bg_green">فروش</span>--}}
                                <div class="product_img">
                                    <a href="#" @click.prevent="detail(product.slug)">
                                        <img style="width: 100%;height:100%"
                                             :src="'/images/product/'+product.image" :alt="product.name">
                                    </a>
                                    <div class="product_action_box">
                                        <ul class="list_none pr_action_btn">
                                            @auth
                                                <li @click.prevent="fav(product.id)">
                                                    <a href="#" style="background-color: #e3342f">
                                                        <i class="fas fa-heart"></i>
                                                    </a>
                                                </li>
                                            @endauth
                                            <li @click.prevent="detail(product.slug)">
                                                <a href="#"> <i class="fas fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="product_info mb-4">
                                    <h6><a href="#" class="pro_name"
                                           @click.prevent="detail(product.slug)"
                                        >@{{ product.name }}</a></h6>
                                    <div style="position: absolute;bottom:15px;width: 100%;left: 0;padding: 0 15px;">
                                        <span class="price">@{{ calculateDiscount(product.price,product.discount) }}</span>
                                        <span style="font-size:11px">تومان</span>
                                        <span id="price">@{{ numberFormat(product.price) }}</span>
                                        <span style="font-size:11px">تومان</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        Vue.component('item', {
            name: 'item',
            props: ['cat'],
            template: '<ul style="margin-bottom: 5px;margin-top: 5px"><li v-for="item in cat.children_recursive" @click.stop="redirectFilter(item.name)" style="margin-right: 10px;text-align: right;font-size:13px"><i class="fas fa-chevron-left" style="margin-left: 3px;font-size: 12px;color: #afafaf;"></i>' +
                ' @{{ item.name }}' +
                '<item :cat="item"></item></li></ul>',
            methods: {
                redirectFilter(cat) {
                    window.location.href = `/search/${cat}`;
                },
            }
        });

        var app = new Vue({
            el: '#area',
            data: {
                products: {},
                cats: [],
                brands: [],
                brandsChosen: [],
                filters: [],
                offers: [],
                loader: false,
                search: '',
                flagMore: true,
                slider: [],
            },
            computed: {
                filteredList() {
                    return this.brands.filter(brand => {
                        return brand.name.includes(this.search) || brand.name_f.includes(this.search);
                    });
                }
            },
            methods: {
                fetchProducts(page = 1) {
                    this.loader = true;
                    let data = this;
                    axios.get('/fetch/products?page=' + page).then(res => {
                        data.products = res.data;
                    });
                    setTimeout(this.ggg, 2000);
                },
                calculateDiscount(price, discount) {
                    onePercent = price / 100;
                    difference = 100 - discount;
                    total = difference * onePercent;
                    result = Math.round(total);
                    return result.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                numberFormat(price) {
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                fetchCats() {
                    let data = this;
                    axios.get('/fetch/search/cats').then(function (res) {
                        data.cats = res.data;

                    });
                },
                redirectFilter(cat) {
                    window.location.href = `/search/${cat}`;
                },
                fetchBrand() {
                    let data = this;
                    axios.get(`/fetch/all/brands`).then(res => {
                        data.brands = res.data;
                    });
                },
                replaceUnder(id) {
                    str = id.replace(/\s+/g, '_');
                    return str;
                },
                changeBrand(name) {
                    str = name.replace(/\s+/g, '_');

                    if ($(`#${str}`).prop('checked')) {
                        this.brandsChosen.push(str);

                    } else {
                        index = this.brandsChosen.indexOf(str);
                        this.brandsChosen.splice(index, 1);
                    }
                    this.searchProducts();
                },
                searchProducts() {
                    let data = this;
                    axios.post('/search/brands', {
                        brand: this.brandsChosen,
                    }).then(res => {
                        data.products = res.data;
                    });
                },
                detail(slug) {
                    window.location.href = `/detail/${slug}`;
                },
                fav(id) {
                    let data = this;
                    axios.get(`/add/fav/${id}`).then(res => {
                        swal.fire(
                            {
                                text: "این کالا به لیست علاقه مندی ها افزوده شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                    });
                },
                fetchOffers() {
                    let data = this;
                    axios.get(`/fetch/offers`).then(res => {
                        data.offers = res.data;
                    });
                },
                // detail(slug) {
                //     window.location.href = `/detail/${slug}`;
                // },
                // fav(id) {
                //     let data = this;
                //     axios.get(`/add/fav/${id}`).then(res => {
                //         swal.fire(
                //             {
                //                 text: "این کالا به لیست علاقه مندی ها افزوده شد !",
                //                 type: "success",
                //                 confirmButtonText: 'باشه',
                //             }
                //         );
                //     });
                // },
                goUp() {
                    $("html, body").animate({scrollTop: 0}, "slow");
                },
                ggg() {
                    this.loader = false;
                },
                more() {
                    this.flagMore = false;
                    $("#categories").addClass("more");
                },
                less() {
                    this.flagMore = true;
                    $("#categories").removeClass("more");
                },
                fetchSlider() {
                    let _this = this;
                    axios.get(`/fetch/slider`).then(res => {
                        _this.slider = res.data;
                    });
                },
                ifActive(index) {
                    if (index === 0) {
                        return 'active'
                    }
                },
            },
            mounted: function () {
                this.fetchProducts();
                this.fetchCats();
                this.fetchBrand();
                this.fetchOffers();
                this.fetchSlider();
            }
        })
    </script>

@endsection

@section('style')
    <style>
        #categories {
            padding: 10px 20px;
            background-color: white;
            border: 1px solid #dddddd;
            height: 312px;
            overflow: hidden
        }

        .more {
            height: auto !important;
            overflow: visible !important;
        }

        .carousel-control-prev {
            right: unset !important
        }
    </style>
@endsection

