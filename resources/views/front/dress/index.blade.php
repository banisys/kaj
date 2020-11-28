@extends('layouts.front.dress')
@section('content')
    <div id="area">
        <div class="posts-tracking text-center">

                <img src="">
                <a href="https://tracking.post.ir/"> رهگیری محصولات پستی</a>

        </div>

        <div class="container-fluid  mt-4">
            <div class="row no-gutters">
                <div class="col-md-12 px-0">
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

            </div>
        </div>

        <div class="banner-area hm1-banner py-5">
            <div class="banner-area-bg bg-left">
                <img src="./dress/images/terme2.png">
            </div>
            <div class="banner-area-bg bg-right">
                <img src="./dress/images/terme.png">
            </div>
             <div class="banner-area-bg bg-center">
                <img src="./dress/images/terme2.png">
            </div>
            <div class="banner-area-bg bg-left-two">
                <img src="./dress/images/terme.png">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <div class="banner-wrapper banner-border ml-10 mb-20">
                            <div class="banner-img">
                                <a @click="redirectToUrl(i1.url)" style="cursor: pointer">
                                    <img :src="'/images/index/'+i1.image">
                                </a>
                            </div>
                        </div>
                        <div class="banner-wrapper banner-border ml-10 mb-20">
                            <div class="banner-img">
                                <a @click="redirectToUrl(i2.url)" style="cursor: pointer">
                                    <img :src="'/images/index/'+i2.image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="banner-wrapper mrg-mb-md">
                            <div class="banner-img">
                                <a @click="redirectToUrl(i3.url)" style="cursor: pointer">
                                    <img :src="'/images/index/'+i3.image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="banner-wrapper banner-border-2 mr-10 mb-20">
                            <div class="banner-img">
                                <a @click="redirectToUrl(i4.url)" style="cursor: pointer">
                                    <img :src="'/images/index/'+i4.image">
                                </a>
                            </div>
                        </div>
                        <div class="banner-wrapper banner-border-2 mr-10 mb-20">
                            <div class="banner-img">
                                <a @click="redirectToUrl(i5.url)" style="cursor: pointer">
                                    <img :src="'/images/index/'+i5.image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="features-area text-center d-block">
            <h1>با خیال راحت</h1>
            <p>از فروشگاه ترمه تن  خرید کنید </p>
            <div class="col-12 d-flex justify-content-center clearfix mt-5">
                <div class="col-12 col-lg-8 d-flex flex-row flex-wrap justify-content-center">
                    <div class="col-12 col-md-4 float-none">
                        <img src="/images/terme-serv.svg"  class="col-5 mx-auto d-block float-none">
                        <span class="feature-title d-block mt-3">پاسخگویی پشتیبانی</span>
                        <span class="feature-desc d-block mt-2">9:00 الی 13:00 16:00 الی 22:00</span>
                    </div>
                    <div  class="col-12 col-md-4 float-none">
                        <img src="/images/terme-check.svg"  class="col-5 mx-auto d-block float-none">
                        <span class="feature-title d-block mt-3">تضمین کیفیت </span>
                        <span class="feature-desc d-block mt-2">تضمین بالاترین کیفیت و اصل بودن کالا</span>
                    </div>
                    <div  class="col-12 col-md-4  float-none" >
                        <img src="/images/terme-sale.svg" class="col-5 mx-auto d-block float-none">
                        <span class="feature-title d-block mt-3">قیمت استثنایی</span>
                        <span class="feature-desc d-block mt-2">تضمین مناسب ترین قیمت موجود در بازار</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-area pb-80 pro d-block mt-4">
            <div class="container px-0">
                <div class="row col-12 no-gutters px-0">
                    <template v-for="(product, $index) in newProducts" :key="$index">
                        <div class="col-6 col-sm-6 col-md-3  my-3 p-0">
                            <div class="product-wrapper mx-2"
                                 style="border:1px solid #d0d0d0;border-radius:6px;margin-bottom: 3px;">
                                <div class="product-img">
                                    <a :href=`/detail/${product.slug}`>
                                        <img :src="'/images/product/'+product.image" :alt="product.name">
                                    </a>
                                </div>
                                <div class="product-content text-center" style="direction: rtl">
                                    <a :href=`/detail/${product.slug}`>
                                        <h4>
                                            @{{ product.name }}
                                        </h4>
                                    </a>
                                    <div class="product-price mt-3" style="direction: rtl">
                                        <span>
                                            @{{ calculateDiscount(product.price,product.discount) }} تومان
                                        </span>
                                        <span v-if="checkHaveDiscount(product['discount'])" class="old">@{{ numberFormat(product.price) }} تومان </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <infinite-loading @infinite="fetchproducts"></infinite-loading>

        <div class="container-fluid mb-5">
            <div class="row no-gutters">
                <a :href="`//${i6.url}`" class="col-12">
                    <img :src="'/images/index/'+i6.image" style="width: 100%">
                </a>
            </div>
        </div>
    </div>


@endsection

@section('script')

    <script>
        new Vue({
            el: '#area',
            data: {
                cats: [],
                brands: [],
                brandsChosen: [],
                filters: [],
                offers: [],
                loader: false,
                search: '',
                flagMore: true,
                slider: [],
                // online
                newProducts: [],
                i1: '',
                i2: '',
                i3: '',
                i4: '',
                i5: '',
                i6: '',
                page: 1,
            },
            computed: {
                filteredList() {
                    return this.brands.filter(brand => {
                        return brand.name.includes(this.search) || brand.name_f.includes(this.search);
                    });
                }
            },
            methods: {
                // startOnline
                fetchproducts($state) {
                    this.loader = true;
                    // let _this = this;
                    // axios.get('/fetch/new/products').then(res => {
                    //     _this.newProducts = res.data;
                    // });

                    axios.get('/fetch/new/products', {
                        params: {
                            page: this.page,
                        },
                    }).then((result) => {
                        let products = result.data.data;

                        if (products.length) {
                            this.page += 1;
                            this.newProducts.push(...products);
                            $state.loaded();
                        } else {
                            $state.complete();
                        }
                    });
                },
                // endOnline
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
                    let _this = this;
                    axios.get('/fetch/search/cats').then(function (res) {
                        _this.cats = res.data;
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
                    let _this = this;
                    axios.get(`/fetch/offers`).then(res => {
                        _this.offers = res.data;
                    });
                },
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
                checkHaveDiscount(discount) {
                    if (discount == 0) {
                        return false;
                    } else {
                        return true;
                    }
                },
                fetchImage() {
                    let _this = this;
                    axios.get('/admin/index/fetch/image').then(res => {
                        _this.i1 = res.data.i1;
                        _this.i2 = res.data.i2;
                        _this.i3 = res.data.i3;
                        _this.i4 = res.data.i4;
                        _this.i5 = res.data.i5;
                        _this.i6 = res.data.i6;
                    });
                },
                fetchRootCat() {
                    let _this = this;
                    axios.get(`/category/fetch/cat/root`).then(res => {
                        _this.roots = res.data;
                        console.log(_this.roots);
                    });
                },
                redirectToUrl(url) {
                    window.location = url;
                },
            },
            mounted: function () {
                // this.fetchproducts();
                // this.fetchOffers();
                this.fetchSlider();
                this.fetchImage();
            }
        });

        setTimeout(function () {
            $('.owl-one').owlCarousel({
                rtl: true,
                loop: true,
                nav: true,
                autoplay: true,
                autoplayTimeout: 6000,
                items: 5,
                dots: false,
                navText: ['<i class="ion-ios-arrow-forward"></i>', '<i class="ion-ios-arrow-back"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 4,
                    },

                }
            });

            $('.owl-two').owlCarousel({
                rtl: true,
                loop: true,
                nav: true,
                autoplay: true,
                autoplayTimeout: 6000,
                items: 5,
                dots: false,
                navText: ['<i class="ion-ios-arrow-forward"></i>', '<i class="ion-ios-arrow-back"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 4,
                    },

                }
            });

        }, 3000);
    </script>

    <script>
        var aTags = document.getElementsByClassName("infinite-status-prompt");
        var searchText = "SearchingText";
        var found;
        for (var i = 0; i < aTags.length; i++) {
            if (aTags[i].textContent == 'کالای بیشتری یافت نشد') {
                found = aTags[i];
                break;
            }
        }
        $(found).addClass("red6");
        console.log(found.innerHTML);
    </script>

@endsection

@section('style')

    <style>

        .bg-center{
         top:50%;
         left:50%;
         transform:translate(-50%,-50%) scale(2) ;
        }
        .bg-left-two{
            top:0;
            left:-200px;
            transform:scale(1.2) rotate(180deg);
        }
        .banner-area{
            position:relative;
        }
        .banner-area-bg{
            position:absolute;
            opacity:0.07;
            z-index:-1;
        }
        .bg-left{
            top:50%;
            left:-50px;
        }
        .bg-right{
            top:0;
            right:-50px;
            transform:rotate(-45deg);
        }
        .red6{
            background: #2f2f2f !important;
            color: #ffc107 !important;
            font-size: 18px !important;
            padding: 20px !important;
            margin-bottom: 100px !important;
        }
        .ion-ios-arrow-back, .ion-ios-arrow-forward {
            color: #6d6d6d;
        }

        .pro .owl-next {
            position: absolute;
            left: -7%;
            top: 28%;
            font-size: 70px !important;
            opacity: 1;
            padding: 14px 34px !important;
            border-radius: 100px;
        }

        .pro .owl-prev {
            position: absolute;
            right: -7%;
            top: 28%;
            font-size: 70px !important;
            opacity: 1;
            padding: 14px 34px !important;
            border-radius: 100px;
        }

        .pro .owl-theme .owl-nav [class*=owl-]:hover {
            opacity: 1;
        }

        @media only screen and (max-width: 768px) {
            .pro .owl-prev {
                font-size: 35px !important;
            }

            .pro .owl-next {
                font-size: 35px !important;
            }

            .product-content a {
                font-size: 12px;
            }

            .banner-border {
                width: 50% !important;
                float: right;
            }

            .banner-border-2 {
                width: 50% !important;
                float: right;
                margin-right: 0px !important;
            }

        }

        @media only screen and (min-width: 320px) and (max-width: 380px) {
            .product-wrapper {
                height: 260px;
            }
        }

        @media only screen and (min-width: 380px) and (max-width: 425px) {
            .product-wrapper {
                height: 290px;
            }
        }

        @media only screen and (min-width: 425px) and (max-width: 470px) {
            .product-wrapper {
                height: 350px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .banner-border {
                width: 50% !important;
                float: right;
                margin-left: 0px !important;
            }

            .banner-border-2 {
                width: 50% !important;
                float: right;
                margin-right: 0px !important;
            }
        }
    </style>
@endsection

