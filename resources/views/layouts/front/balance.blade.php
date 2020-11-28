<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>parmoNet</title>

    <link rel="stylesheet" href="/css/app.css">
    <script src="{{ asset('/js/app.js')}}"></script>

    <link rel="stylesheet" href="/layout_balance/css/ionicons.min.css">
    <link rel="stylesheet" href="/layout_balance/css/all.min.css">

    <link rel="stylesheet" href="/layout_balance/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/layout_balance/owlcarousel/css/owl.theme.css">
    <link rel="stylesheet" href="/layout_balance/owlcarousel/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="/layout_balance/css/style.css">
    <link rel="stylesheet" href="/layout_balance/css/responsive.css">
    <link rel="stylesheet" id="layoutstyle" href="/layout_balance/color/theme-default.css">
    @yield('style')
</head>
<body>

{{--<div id="overlayer"--}}
{{--style="position:absolute;top: 0;left: 0;background-color: white;width: 100%;height: 100vh;z-index: 10000"--}}
{{--v-if="loader">--}}
{{--<div id="wave1"></div>--}}
{{--</div>--}}


<header class="header_wrap dark_skin main_menu_uppercase" id="header" style="box-shadow:0 7px 8px 0 rgba(0,0,0,.04)">
    <div v-show="flagMega" @mouseover="flagMega=false"
         style="width: 100%;height: 100vh;background-color: black;opacity: .5;position: absolute;top: 72px;left: 0;z-index:998"></div>
    <div v-show="flagMega" id="megaContainer">
        <div @mouseleave="flagMega=false" class="container"
             style="background-color: white;border-bottom-right-radius: 6px;border-bottom-left-radius: 6px;padding-top:20px;border-top:2px dashed rgb(210, 210, 210)">
            <div class="row">
                <div class="col-2">
                    <ul class="nav nav-tabs" id="myTab" role="tablist"
                        style="background-color: #f6f6f6;height: min-content;border-left: 1px solid #dedede;">
                        <li class="nav-item" v-for="(megaCat,index) in megaCats" style="padding-bottom:5px;">
                            <a class="nav-link text-right" data-toggle="tab" :href="'#mega'+megaCat.id" role="tab"
                               :aria-controls="'#mega'+megaCat.id">
                                @{{ megaCat.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-10" style="padding: 0 15px;">
                    <div class="tab-content" style="margin: unset">
                        <div class="tab-pane" v-for="(megaCat,index,key) in megaCats" :id="'mega'+megaCat.id"
                             role="tabpanel">
                            <ul>
                                <li class="col-3 px-0 float-right" v-for="item in megas[megaCat.id]"
                                    @click="selectResult(item.name,item.type)"
                                    style="list-style: none;margin-bottom: 10px;font-size:13px;cursor: pointer;">
                                    @{{ item.title }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="position:relative;z-index:999999" v-if="flag">
        <input type="text" placeholder="نام کالا ، دسته و یا نام برند را وارد کنید..." class="form-control"
               id="search_input"
               v-model="searchquery" @keyup="autoComplete"
               style="position: relative;border-radius: 0;padding: 25px">
        <i class="ion-ios-close-empty"
           @click="closeSearchBar"
           style="position: absolute;left:16px;top: 1px;font-size: 30px;cursor: pointer;padding: 10px"></i>

        <div v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
             style="position: absolute;width: 100%;z-index: 100">
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

    <div v-if="flag"
         style="background-color: black;opacity:.8;position: fixed;width: 100%;height: 100%;top: 0;left: 0;z-index:99999"></div>

    <div class="container-fluid mb-2">
        <nav style="text-align: right;padding: 15px 0;" class="navbar navbar-expand-lg">
            <a @mouseover="flagMega=false" class="navbar-brand ml-4" href="{{url('/')}}" style="color:#25659a;font-weight: bold ">
                <img src="/layout_balance/images/logo-header.png" style="width: 50px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="ناوبری را تغییر دهید"><span
                        class="ion-android-menu"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li style="margin-left:30px">
                        <a class="nav-link" href="#" @mouseover="flagMega=!flagMega">دسته بندی کالاها</a>
                    </li>
                    <li style="margin-left: 30px">
                        <a class="nav-link" href="#" @mouseover="flagMega=false">درباره ما</a>
                    </li>
                    <li style="margin-left: 30px">
                        <a class="nav-link" href="#">تماس با ما</a>
                    </li>
                    <li style="padding-top:4px;">
                        <a @click="showSearchBar" style="cursor: pointer">
                            <span style="border: 1px solid #d7d7d7;padding: 8px 20px;border-radius: 5px;font-size: 14px;">
                                  <i class="ion-ios-search-strong" style="font-size: 20px;margin-left:6px;vertical-align: bottom;"></i>
                                جستجو در فروشگاه
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="header_list border_list list_none header_dropdown text-center text-md-right ml-3"
                style="text-align: initial;border: 1px solid #d7d7d7;display: inline-block;padding: 4px 10px;border-radius:4px;padding-left: 5px">
                @auth
                    <i class="fas fa-user" style="margin-left: 5px;color: #777777"></i>
                    <li class="dropdown" style="padding-left: 0;">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">پروفایل کاربری</a>
                        <div class="dropdown-menu shadow dropdown-menu-right">
                            <ul style="text-align: initial;">
                                <li>
                                    <a class="dropdown-item" href="{{url('/panel/account')}}">پروفایل کاربری</a>
                                </li>
                                <li><a class="dropdown-item" href="{{url('/favourites')}}">لیست علاقه مندی</a>
                                </li>
                                <li><a class="dropdown-item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button style="background-color: unset;border: unset;color: #dc3545;font-size:16px;margin-top:4px"
                                                    type="submit">
                                                خروج
                                            </button>
                                        </form>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                @else

                    <div>
                        <i class="fas fa-user" style="margin-left: 5px;color: #777777"></i>
                        <a href="{{ route('login') }}" class="ml-2"
                           style="color: #545454;font-size: 13px;">ورود</a>
                        <span style="color: #545454;font-size: 13px;">/</span>
                        <a href="{{ route('login') }}" class="mr-2"
                           style="color: #545454;font-size: 13px;padding-left: 5px">ثبت
                            نام</a>
                    </div>
                @endauth
            </ul>
            <ul class="navbar-nav attr-nav align-items-center">


                <li class="dropdown cart_wrap">
                    <a class="nav-link" href="#" data-toggle="dropdown"><i class="ion-bag"></i><span class="cart_count">
                            @{{ countCart }}
                        </span>
                    </a>
                    <div class="cart_box dropdown-menu dropdown-menu-right">
                        <ul class="cart_list">
                            <template v-for="(cart, name, index) in carts">
                                <li>
                                    <a href="#" class="item_remove" @click="deleteCart(cart.id)">
                                        <i class="ion-close"></i>
                                    </a>
                                    <a href="#">
                                        <img :src="'/images/product/'+cart.product.image">
                                        @{{ cart.product.name }}
                                    </a>
                                    <p>
                                        <span class="float-right">@{{ numberFormat(cart.total) }} تومان</span>
                                        <span style="text-decoration-line: line-through;color: #bfbfbf;font-size: 12px;float: left;">
                                            @{{ numberFormat(cart.price*cart.number) }} تومان
                                        </span>
                                    </p>
                                </li>
                            </template>
                        </ul>
                        <div class="cart_footer" v-if="carts.length">
                            <p class="cart_total">جمع کل :
                                <span class="cart_amount">
                                    <span class="price_symbole">
                                        @{{ numberFormat(totalCart) }}تومان
                                    </span>
                                </span>
                            </p>
                            <p class="cart_buttons">
                                <a href="{{url('/cart')}}" class="btn btn-dark btn-radius mb-3 ml-2 mt-2"
                                   style="float: left;padding: 4px 17px;">پرداخت</a>
                            </p>
                        </div>
                        <div class="cart_footer" v-else>
                            <p class="my-3" style="text-align: center;">سبد خرید خود را تشکیل دهید</p>
                        </div>
                    </div>
                </li>
            </ul>

        </nav>
    </div>
</header>

@yield('content')

<footer class="bg_gray mt-5" style="text-align: right">
    <div class="top_footer small_pt small_pb">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer_logo">
                        <a href="index.html"><img style="width:70%" src="/layout_balance/images/logo.png"></a>
                    </div>
                    <div class="footer_desc">
                        {{--<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک--}}
                            {{--است. </p>--}}
                    </div>
                    {{--<ul class="contact_info list_none">--}}
                        {{--<li>--}}
                            {{--<span class="ti-mobile"></span>--}}
                            {{--<p>021-66972131</p>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<span class="ti-email"></span>--}}
                            {{--<a href="mailto:info@parmonet.com">info@parmonet.com</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<span class="ti-location-pin"></span>--}}
                            {{--<address>--}}
                                {{--خیابان جمهوری اسلامی ، خیابان دانشگاه ، ساختمان شماره 35 ، طبقه سوم ، واحد 8--}}
                            {{--</address>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <h5 class="widget_title">اطلاعات</h5>
                    <ul class="list_none widget_links">
                        <li><a href="#">اطلاعات تحویل</a></li>
                        <li><a href="#">پرداخت امن</a></li>
                        <li><a href="#">دربارهی ما</a></li>
                        <li><a href="#">فروشندگان برتر</a></li>
                        <li><a href="#">سیاست حفظ حریم خصوصی</a></li>
                        <li><a href="#">نقشه سایت ما</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <h5 class="widget_title">پشتیبانی مشتری</h5>
                    <ul class="list_none widget_links">
                        <li><a href="#">حساب من</a></li>
                        <li><a href="#">سبد خرید</a></li>
                        <li><a href="#">آدرس</a></li>
                        <li><a href="#">تخفیف</a></li>
                        <li><a href="#">تاریخچه سفارشات</a></li>
                        <li><a href="#">رهگیری سفارش</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-4">
                    <h5 class="widget_title">اینستاگرام</h5>
                    <ul class="list_none instafeed">
                        <li><a href="#"><img src="/layout_balance/images/insta_img1.jpg" alt="insta_img"><span
                                        class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                        <li><a href="#"><img src="/layout_balance/images/insta_img2.jpg" alt="insta_img"><span
                                        class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                        <li><a href="#"><img src="/layout_balance/images/insta_img3.jpg" alt="insta_img"><span
                                        class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                        <li><a href="#"><img src="/layout_balance/images/insta_img4.jpg" alt="insta_img"><span
                                        class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                        <li><a href="#"><img src="/layout_balance/images/insta_img5.jpg" alt="insta_img"><span
                                        class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                        <li><a href="#"><img src="/layout_balance/images/insta_img6.jpg" alt="insta_img"><span
                                        class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                        <li><a href="#"><img src="/layout_balance/images/insta_img7.jpg" alt="insta_img"><span
                                        class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                        <li><a href="#"><img src="/layout_balance/images/insta_img8.jpg" alt="insta_img"><span
                                        class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="middle_footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shopping_info">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="box_icon">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div class="intro_desc">
                                        <h5>تحویل رایگان</h5>
                                        {{--<p>لورم ایپسوم متن ساختگی با تولید سادگی</p>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="box_icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="intro_desc">
                                        <h5>30 روز ضمانت بازگشت</h5>
                                        {{--<p>لورم ایپسوم متن ساختگی با تولید سادگی</p>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="box_icon">
                                        <i class="far fa-life-ring"></i>
                                    </div>
                                    <div class="intro_desc">
                                        <h5>27/4 پشتیبانی آنلاین</h5>
                                        {{--<p>لورم ایپسوم متن ساختگی با تولید سادگی</p>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <p class="copyright m-lg-0 text-center">کپی رایت © 2020 همه حقوق محفوظ است </p>
                </div>
                <div class="col-lg-4 order-lg-first">
                    {{--<ul class="list_none footer_payment text-center text-lg-left">--}}
                        {{--<li><a href="#"><img src="/layout_balance/images/visa.png" alt="ویزا"></a></li>--}}
                        {{--<li><a href="#"><img src="/layout_balance/images/discover.png" alt="كشف كردن"></a></li>--}}
                        {{--<li><a href="#"><img src="/layout_balance/images/master_card.png" alt="مستر کارت"></a></li>--}}
                        {{--<li><a href="#"><img src="/layout_balance/images/paypal.png" alt="پی پال"></a></li>--}}
                        {{--<li><a href="#"><img src="/layout_balance/images/amarican_express.png"--}}
                                             {{--alt="amarican_express"></a></li>--}}
                    {{--</ul>--}}
                </div>
                <div class="col-lg-4">
                    <ul class="list_none social_icons radius_social text-center text-lg-right">
                        <li><a href="#" class="sc_facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" class="sc_twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#" class="sc_google"><i class="fab fa-google-plus-g"></i></a></li>
                        <li><a href="#" class="sc_instagram"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#" class="sc_pinterest"><i class="fab fa-pinterest"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    var app = new Vue({
        el: '#header',
        data: {
            flag: false,
            products: [],
            searchquery: '',
            data_results: {
                product: [],
                category: [],
                brand: [],
            },
            focus: 0,
            carts: [],
            countCart: 0,
            totalCart: 0,
            flagMega: false,
            megaCats: [],
            megas: [],
        },
        methods: {
            autoComplete(event) {
                event.preventDefault();
                if (this.searchquery.length === 0) {
                    this.data_results.product = [];
                    this.data_results.category = [];
                    this.data_results.brand = [];
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
                            break;
                        }
                        this.focus--;
                        $(`.down-select li`).removeClass("select_search");
                        $(`.down-select li:nth-child(${this.focus})`).addClass("select_search");
                        break;

                    case 40:
                        if (this.focus === li_count) {
                            break;
                        }
                        this.focus++;
                        $(`.down-select li`).removeClass("select_search");
                        $(`.down-select li:nth-child(${this.focus})`).addClass("select_search");
                        break;
                }

                let data = this;
                if (this.searchquery.length > 2) {
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
        }
    });
</script>

@yield('script')

<script src="/layout_balance/owlcarousel/js/owl.carousel.min.js"></script>
<script src="/layout_balance/js/scripts.js"></script>

<script>
    // $(document).ready(function () {
    //     $("#overlayer").delay(1000).fadeOut("slow");
    // });

    setTimeout(function(){
        $('#megaContainer .nav-item a').hover(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    }, 1000);

</script>
</body>
</html>
