<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>پوشاک کاج</title>
    <script src="{{ asset('/js/dress/app.js')}}"></script>
    <link rel="stylesheet" href="/layout_kaj/css/bootstrap.min.css">
    <link rel="stylesheet" href="/layout_kaj/css/style.css">
    <link rel="stylesheet" href="/layout_kaj/css/swiper.css">
    <link rel="stylesheet" href="/layout_kaj/fonts/fontawesome-free-5.6.1-web/css/all.min.css">
    @yield('style')
</head>
<body>

<header class="col-12 px-0 pt-3" id="header">
    <div class="header d-flex flex-row-reverse justify-content-between px-3">
        <div class="col-lg-5 text-right d-flex flex-row-reverse align-items-center">
            <div class="logo">
                <a href="{{url('/')}}">
                    <h1 class="mb-0">LOGO</h1>
                </a>
            </div>
            <div class="search col-10 px-0 mr-5">
                <div style="background-color: #f5f5f5;border-radius: 10px;padding: 5px 20px;border: 1px solid #eee;">
                    <input @keyup="autoComplete" id="search-input"
                           style="border: none;background-color: transparent;text-align: right;direction: rtl;padding: 10px;outline: none;"
                           v-model="searchquery"
                           placeholder="جستجوی محصول ..." type="text">
                    <i class="fa fa-search"
                       style="position: absolute;bottom: 50%;transform: translateY(50%);left: 22px;font-size: 24px;color: #afafaf !important;"></i>
                </div>
                <i class="fa fa-times"
                   v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                   @click="searchClose"
                   style="position: absolute;left: 72px;top: 8px;font-size: 20px;cursor: pointer;padding: 10px;color: #da3d64;"></i>
                <div
                    v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                    style="position: absolute;width: 100%;z-index: 100;top: 53px;direction: rtl;left: 32px;">
                    <ul class="list-group down-select">
                        <li class="list-group-item" v-for="(result,index) in data_results.product"
                            @click="selectResult(result.name,'product')"
                            style="text-align: right;cursor: pointer">
                            <span class="auto_search">محصول</span>
                            <span class="auto_search2">@{{ result.name }}</span>
                        </li>
                        <li class="list-group-item" v-for="(result,index) in data_results.category"
                            @click="selectResult(result.name,'cat')"
                            style="text-align: right;cursor: pointer">
                            <span class="auto_search">دسته ها</span>
                            <span class="auto_search2">@{{ result.name }}</span>
                        </li>
                        <li class="list-group-item" v-for="(result,index) in data_results.brand"
                            @click="selectResult(result.name,'brand')"
                            style="text-align: right;cursor: pointer">
                            <span class="auto_search">برند</span>
                            <span class="auto_search2">@{{ result.name }}</span>
                            <span style="margin-right:50px;font-size: 14px;color: #b9b9b9;">@{{ result.name_f }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-3 text-right mr-5 pt-3">


            <ul class="header_list border_list list_none header_dropdown text-center text-md-right"
                style="direction: rtl">
                @auth
                    <li class="dropdown mx-1 profile-drop" style="padding-left: 0;display: inline-block">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown"
                           style="font-size: 15px;border-radius: 5px;padding: 2px 10px;border: 2px solid #c1c1c1;"
                           role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            پروفایل
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="text-align: right;right: 0">
                            <a class="dropdown-item" href="{{url('/panel/account')}}">
                                پروفایل کاربری
                            </a>

                            <a class="dropdown-item">
                                <a href="/logout"
                                   style="color: #dc3545;padding: 0px 25px;"
                                   type="submit">
                                    خروج
                                </a>

                            </a>

                        </div>
                    </li>
                @else

                    <div>
                        <a href="/login" style="border: 1px solid #afafaf;padding: 4px 12px;border-radius: 5px;">ورود /
                            ثبت نام</a>
                    </div>
                @endauth
            </ul>
        </div>
        <div class="cart-btn col-lg-3">
            <a href="/cart">
                <button class="primary-button">
                    سبد خرید
                    <i class="fa fa-shopping-bag"></i>
                </button>
            </a>
        </div>
    </div>

    <nav class="mt-4 text-center">
        <ul class="d-flex flex-row-reverse justify-content-around mb-0">
            <template v-for="root in roots">
                <li class="nav-item dropdown ml-3">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        @{{ root.name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <template v-for="cat in root.children_recursive">
                            <a class="dropdown-item" @click="selectResult(cat.name,'cat')">@{{ cat.name }}</a>
                        </template>
                    </div>
                </li>
            </template>
        </ul>
    </nav>
</header>


<div class="container-fluid">
    <div class="row" id="area">
        <div class="col-12">
            @yield('content')
        </div>
    </div>
</div>


<footer class="mt-5 py-5 px-5 col-12">
    <div class="text-right col-12 d-flex flex-row-reverse justify-content-between ">
        <ul class="col-lg-2">
            <h4>ارتباط با ما </h4>
            <hr>
            <li class="rtl">
                <span>تلفن:</span>
                <a href="/layout_kaj/">02122556699</a>
            </li>
            <li class="rtl">
                <span class="fab fa-telegram"></span>
                <a href="/layout_kaj/">کانال تلگرام</a>
            </li>
            <li class="rtl">
                <span class="fab fa-instagram"></span>
                <a href="/layout_kaj/">صفحه اینستاگرام</a>
            </li>
        </ul>
        <ul>
            <h4>دسترسی ها </h4>
            <hr>
            <li><a href="/layout_kaj/">
                    صفحه اصلی
                </a></li>
            <li><a href="/layout_kaj/">
                    قوانین و مقررات
                </a></li>
            <li><a href="/layout_kaj/">
                    ثبت شکایت
                </a></li>
            <li><a href="/layout_kaj/">
                    کتاب‌ها
                </a></li>
            <li><a href="/layout_kaj/">
                    درباره ما
                </a></li>
        </ul>
        <ul>
            <h4>نماد اعتماد</h4>
            <hr>
            <li>
                <img class="" src="/layout_kaj/images/enamad.png" alt="">
            </li>
        </ul>
        <ul>
            <h4>نقشه فروشگاه</h4>
            <hr>
            <li class="">
                <iframe
                    src="/layout_kaj/https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1620.1071581853782!2d51.3982171002868!3d35.696343321600274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc67de61e03bcf6f7!2sParmonet%20Group!5e0!3m2!1sen!2sus!4v1605009695318!5m2!1sen!2sus"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen=""
                    aria-hidden="false" tabindex="0"></iframe>
            </li>
        </ul>
    </div>
</footer>


<script src="/layout_kaj/js/index.js"></script>
<script src="/layout_kaj/js/jquery.min.js"></script>
<script src="/dress/assets/js/popper.js"></script>
<script src="/dress/assets/js/bootstrap.min.js"></script>
<script src="/layout_kaj/js/swiper.js"></script>

<script>
    new Vue({
        el: '#header',
        data: {
            flag: false,
            products: {},
            searchquery: '',
            data_results: {
                product: {},
                category: {},
                brand: {},
            },
            focus: 0,
            carts: [],
            countCart: 0,
            totalCart: 0,
            flagMega: false,
            megaCats: [],
            megas: [],
            magaCatPrevHolder: '',
            magaCatHolder: '',
            roots: []
        },
        methods: {
            openMenu(id) {
                $(`#item-${id}`).toggleClass("open-link");
            },
            fetchRootCat() {
                let _this = this;
                axios.get(`/category/fetch/cat/root`).then(res => {
                    _this.roots = res.data;
                });
            },
            searchClose() {
                this.flag = false;
                this.data_results.product = {};
                this.data_results.category = {};
                this.data_results.brand = {};
                this.searchquery = '';
            },
            hoverMegaCat(id) {
                $(`#mega-cat${this.magaCatPrevHolder}`).css({"color": "black"});
                this.magaCatPrevHolder = this.magaCatHolder;
                this.magaCatHolder = id;
            },
            hoverMegaContainer() {
                $(`#mega-cat${this.magaCatHolder}`).css({"color": "#c40316"});
            },
            activeFirstMega(index) {
                if (index === 0) {
                    return 'active show';
                }
            },
            autoComplete(event) {
                event.preventDefault();
                if (this.searchquery.length === 0) {
                    this.data_results.product = [];
                    this.data_results.category = [];
                    this.data_results.brand = [];
                    this.flag = false;
                    return false;
                }
                li_count = $('.down-select li').length;

                switch (event.keyCode) {
                    case 13:
                        name = $('.select_search .auto_search2').text();
                        cat = $('.select_search .auto_search').text();
                        if (cat === 'دسته ها') {
                            type = 'cat';
                        }
                        if (cat === 'محصول') {
                            type = 'product';
                        }
                        if (cat === 'برند') {
                            type = 'brand';

                        }
                        this.selectResult(name, type);
                        break;

                    case 38:
                        if (this.focus === 1) {
                            return false;
                        }
                        this.focus--;
                        $(`.down-select li`).removeClass("select_search");
                        $(`.down-select li:nth-child(${this.focus})`).addClass("select_search");
                        this.searchquery = $(`.down-select li:nth-child(${this.focus})`).text();

                        return false;

                    case 40:
                        if (this.focus === li_count) {
                            return false;
                        }
                        this.focus++;
                        $(`.down-select li`).removeClass("select_search");
                        $(`.down-select li:nth-child(${this.focus})`).addClass("select_search");
                        this.searchquery = $(`.down-select li:nth-child(${this.focus})`).text();
                        return false;
                    case 37:
                        return false;

                    case 39:
                        return false;

                }
                let data = this;
                if (this.searchquery.length > 2) {
                    this.flag = true;
                    axios.get('/autocomplete/search', {
                        params: {
                            searchquery: data.searchquery,
                        }
                    }).then(response => {
                        data.data_results.product = response.data.product;
                        data.data_results.category = response.data.category;
                        data.data_results.brand = response.data.brand;
                    });
                }
            },
            selectResult(name, type) {
                window.location.href = `/auto/search/${type}/${name}`;
            },
            showSearchBar() {
                this.flag = true;
                setTimeout(function () {
                    $("#search_input").select();
                }, 500);
            },
            closeSearchBar() {
                this.flag = false;
            },
            fetchCart() {
                let data = this;
                data.totalCart = 0;
                axios.get('/fetch/cart').then(res => {
                    data.carts = res.data;
                    data.countCart = res.data.length;
                    for (const [key, value] of Object.entries(res.data)) {
                        data.totalCart += value.total;
                    }
                });
            },
            numberFormat(price) {
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            deleteCart(id) {
                let data = this;
                swal.fire({
                    text: "آیا از پاک کردن اطمینان دارید ؟",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله',
                    cancelButtonText: 'لغو',
                }).then((result) => {
                    if (result.value) {
                        axios.get(`/cart/delete/${id}`).then(res => {
                            data.fetchCart();
                        });
                    }
                });
            },
            fetchMegaCats() {
                axios.get('/mega/cat/fetch').then(res => {
                    this.$data.megaCats = res.data;
                });

            },
            fetchMegas() {
                axios.get('/megas/fetch').then(res => {
                    this.$data.megas = res.data;
                });
            },
            megaDisplay() {
                this.flagMega = true;
            },
        },
        mounted: function () {
            this.fetchCart();
            this.fetchMegaCats();
            this.fetchMegas();
            this.fetchRootCat();
        }
    });

    $(document).ready(function () {
        setTimeout(function () {
            $(".preloader").css("display", "none");
        }, 2000);
    });


</script>
@yield('script')
</body>
</html>
