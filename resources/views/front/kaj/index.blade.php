@extends('layouts.front.kaj')
@section('content')
    <section class="col-12 px-0">
        <div class="swiper-container carouselTop">
            <div class="swiper-wrapper">
                <div v-for="item in slider" class="swiper-slide">
                    <div class="">
                        <div class="">
                            <img class="w-100" :src="'/images/slider/'+item.image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next swiper-arrow"></div>
            <div class="swiper-button-prev swiper-arrow"></div>
        </div>
    </section>
    <section class="banners mt-3">
        <div class="row no-gutters h-100">
            <div class="col-6 h-100 tallBanner">
                <img :src="'/images/index/'+i5.image" class="w-100 h-100 px-2">
            </div>
            <div class="col-3 squareBanner h-100">
                <div><img :src="'/images/index/'+i3.image" class="w-100 h-100 px-2 pb-3" alt=""></div>
                <div><img :src="'/images/index/'+i4.image" class="w-100 h-100 px-2 pb-3" alt=""></div>
            </div>
            <div class="col-3 squareBanner">
                <div><img :src="'/images/index/'+i1.image" class="w-100 h-100 px-2 pb-3" alt=""></div>
                <div><img :src="'/images/index/'+i2.image" class="w-100 h-100 px-2 pb-3" alt=""></div>
            </div>
        </div>
    </section>
    <section class="slider-sug col-12 d-flex flex-row-reverse py-5 mt-5">
        <div class="slider-title col-3 px-0 position-relative">
            <img class="w-100" src="/layout_kaj/images/slider.jpg">
            <div class="slider-buttons">
                <div class="swiper-button-next swiper-sug-next"></div>
                <div class="swiper-button-prev swiper-sug-prev"></div>
            </div>
        </div>
        <div class="col-9 d-flex flex-row-reverse">
            <div class="swiper-container suggest">
                <div class="swiper-wrapper">
                    <div v-for="suggest in suggests" class="swiper-slide">
                        <div class="sug-slider-item">
                            <div class="sug-slider-img">
                                <a :href=`/detail/${suggest.slug}`>
                                    <img class="w-100" :src="'/images/product/'+suggest.image" :alt="suggest.name">
                                </a>
                            </div>
                            <div class="sug-slider-info text-right bg-white py-3  px-3">
                                <div class="title">
                                    <a :href=`/detail/${suggest.slug}`>
                                        <h3>@{{ suggest.name }}</h3>
                                    </a>
                                </div>
                                <div class="price d-flex justify-content-end">
                                    <div class="old-price rtl pr-3">
                                        @{{ calculateDiscount(suggest.price,suggest.discount) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                    <div class="new-price rtl" v-if="checkHaveDiscount(suggest['discount'])">
                                        @{{ numberFormat(suggest.price) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                </div>
                                <div class="primary-button text-center mt-4">
                                    <a href="/layout_kaj/" class="">مشاهده جزیات</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-for="suggest in suggests" class="swiper-slide">
                        <div class="sug-slider-item">
                            <div class="sug-slider-img">
                                <a :href=`/detail/${suggest.slug}`>
                                    <img class="w-100" :src="'/images/product/'+suggest.image" :alt="suggest.name">
                                </a>
                            </div>
                            <div class="sug-slider-info text-right bg-white py-3  px-3">
                                <div class="title">
                                    <a :href=`/detail/${suggest.slug}`>
                                        <h3>@{{ suggest.name }}</h3>
                                    </a>
                                </div>
                                <div class="price d-flex justify-content-end">
                                    <div class="old-price rtl pr-3">
                                        @{{ calculateDiscount(suggest.price,suggest.discount) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                    <div class="new-price rtl" v-if="checkHaveDiscount(suggest['discount'])">
                                        @{{ numberFormat(suggest.price) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                </div>
                                <div class="primary-button text-center mt-4">
                                    <a href="/layout_kaj/" class="">مشاهده جزیات</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-for="suggest in suggests" class="swiper-slide">
                        <div class="sug-slider-item">
                            <div class="sug-slider-img">
                                <a :href=`/detail/${suggest.slug}`>
                                    <img class="w-100" :src="'/images/product/'+suggest.image" :alt="suggest.name">
                                </a>
                            </div>
                            <div class="sug-slider-info text-right bg-white py-3  px-3">
                                <div class="title">
                                    <a :href=`/detail/${suggest.slug}`>
                                        <h3>@{{ suggest.name }}</h3>
                                    </a>
                                </div>
                                <div class="price d-flex justify-content-end">
                                    <div class="old-price rtl pr-3">
                                        @{{ calculateDiscount(suggest.price,suggest.discount) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                    <div class="new-price rtl" v-if="checkHaveDiscount(suggest['discount'])">
                                        @{{ numberFormat(suggest.price) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                </div>
                                <div class="primary-button text-center mt-4">
                                    <a href="/layout_kaj/" class="">مشاهده جزیات</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-for="suggest in suggests" class="swiper-slide">
                        <div class="sug-slider-item">
                            <div class="sug-slider-img">
                                <a :href=`/detail/${suggest.slug}`>
                                    <img class="w-100" :src="'/images/product/'+suggest.image" :alt="suggest.name">
                                </a>
                            </div>
                            <div class="sug-slider-info text-right bg-white py-3  px-3">
                                <div class="title">
                                    <a :href=`/detail/${suggest.slug}`>
                                        <h3>@{{ suggest.name }}</h3>
                                    </a>
                                </div>
                                <div class="price d-flex justify-content-end">
                                    <div class="old-price rtl pr-3">
                                        @{{ calculateDiscount(suggest.price,suggest.discount) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                    <div class="new-price rtl" v-if="checkHaveDiscount(suggest['discount'])">
                                        @{{ numberFormat(suggest.price) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                </div>
                                <div class="primary-button text-center mt-4">
                                    <a href="/layout_kaj/" class="">مشاهده جزیات</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-for="suggest in suggests" class="swiper-slide">
                        <div class="sug-slider-item">
                            <div class="sug-slider-img">
                                <a :href=`/detail/${suggest.slug}`>
                                    <img class="w-100" :src="'/images/product/'+suggest.image" :alt="suggest.name">
                                </a>
                            </div>
                            <div class="sug-slider-info text-right bg-white py-3  px-3">
                                <div class="title">
                                    <a :href=`/detail/${suggest.slug}`>
                                        <h3>@{{ suggest.name }}</h3>
                                    </a>
                                </div>
                                <div class="price d-flex justify-content-end">
                                    <div class="old-price rtl pr-3" v-if="checkHaveDiscount(suggest['discount'])">
                                        @{{ numberFormat(suggest.price) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                    <div class="new-price rtl">
                                        @{{ calculateDiscount(suggest.price,suggest.discount) }}
                                        <span class="toman">تومان</span>
                                    </div>
                                </div>
                                <div class="primary-button text-center mt-4">
                                    <a href="/layout_kaj/" class="">مشاهده جزیات</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="products-container mt-5">
        <div class="row no-gutters">
            <template v-for="(product, $index) in newProducts" :key="$index">
                <div class="product-items ">
                    <div class="pro-img">
                        <a :href=`/detail/${product.slug}`>
                            <img class="w-100" :src="'/images/product/'+product.image" :alt="product.name">
                        </a>
                    </div>
                    <div class="pro-info text-right bg-white py-3  ">
                        <div class="title">
                            <a :href=`/detail/${product.slug}`>
                                <h3>@{{ product.name }}</h3>
                            </a>


                            <template v-for="color in product.colors">
                                <a :href=`/detail/${product.slug}/${color.id}` class="color-chosen"
                                   :style="{backgroundColor: color.code}">
                                </a>
                            </template>


                        </div>
                        <div class="price d-flex justify-content-end mt-3">
                            <div class="old-price rtl pr-3" v-if="checkHaveDiscount(product['discount'])">
                                @{{ numberFormat(product.price) }}
                                <span class="toman">تومان</span>
                            </div>
                            <div class="new-price rtl">
                                @{{ calculateDiscount(product.price,product.discount) }}
                                <span class="toman">تومان</span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </section>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#area',
            data: {
                suggests: [],
                cats: [],
                brands: [],
                brandsChosen: [],
                filters: [],
                offers: [],
                loader: false,
                search: '',
                flagMore: true,
                slider: [],
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
                choseColor(productSlug, colorId) {

                    window.location.href = `/detail/${productSlug}/${colorId}`

                },
                async fetchSuggest() {
                    let _this = this;
                    await axios.get(`/fetch/suggests`).then(res => {
                        _this.suggests = res.data
                    })
                    var suggest = new Swiper('.suggest', {
                        slidesPerView: 4,
                        spaceBetween: 10,
                        autoplay: true,

                        navigation: {
                            nextEl: '.swiper-sug-next',
                            prevEl: '.swiper-sug-prev',
                        },
                    })
                },
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
                    })
                },
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
                async fetchSlider() {
                    let _this = this;
                    await axios.get(`/fetch/slider`).then(res => {
                        _this.slider = res.data
                    })
                    let carouselTop = new Swiper('.carouselTop', {
                        slidesPerView: 1,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    })
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
                        _this.i1 = res.data.i1
                        _this.i2 = res.data.i2
                        _this.i3 = res.data.i3
                        _this.i4 = res.data.i4
                        _this.i5 = res.data.i5
                    });
                },
                fetchRootCat() {
                    let _this = this;
                    axios.get(`/category/fetch/cat/root`).then(res => {
                        _this.roots = res.data;
                    });
                },
                redirectToUrl(url) {
                    window.location = url;
                },
            },
            mounted: function () {
                this.fetchproducts();
                this.fetchSuggest();
                this.fetchSlider()
                this.fetchImage()
            }
        })

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
    </script>

@endsection

@section('style')
    <style>
        .color-chosen {
            width: 37px;
            height: 27px;
            display: inline-block;
            vertical-align: bottom;
            cursor: pointer;
        }
    </style>
@endsection
