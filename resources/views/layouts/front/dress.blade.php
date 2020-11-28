<!doctype html>
<html class="no-js" lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ترمه تن</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="enamad" content="931192"/>

    <script src="{{ asset('/js/dress/app.js')}}"></script>
    <link rel="stylesheet" href="/dress/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/dress/assets/css/animate.css">
    <link rel="stylesheet" href="/dress/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/dress/assets/css/chosen.min.css">
    <link rel="stylesheet" href="/dress/assets/css/easyzoom.css">
    <link rel="stylesheet" href="/dress/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/dress/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/dress/assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="/dress/assets/css/bundle.css">
    <link rel="stylesheet" href="/dress/assets/css/style.css">
    <link rel="stylesheet" href="/dress/assets/css/rtl.css">
    <link rel="stylesheet" href="/dress/assets/css/responsive.css">
    <script src="/dress/assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="/js/infiniti.js"></script>

    @yield('style')

</head>
<body>
<style>
    @keyframes animate1 {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(1);
        }
    }

    .image-anim {
        animation-name: animate1;
        animation-duration: 4s;
        animation-iteration-count: infinite;
    }

    search-input:focus {
        background-color: white;
    }
</style>

<div class="preloader"
     style="width: 100%;height: 100vh;background: white;position: fixed;top: 0;z-index: 99999999"></div>
<img class="image-anim preloader" src="/dress/assets/img/logo/logo2.png"
     style=";position: absolute;top: 40%;z-index: 9999999999;right: 40%;transform: translateX(-50%)">

<div id="header">
    <div class="wrapper">
        <div class="mobile-menu pb-5 px-3 d-lg-none">
            <div class="row no-gutters">
                <div class="col-5 px-0">
                    <div class="logo-menu-wrapper">
                        <div class="logo" style="margin-top:8px">
                            <a href="{{url('/')}}"><img style="width:50%" src="/dress/assets/img/logo/logo.png" alt=""/></a>
                        </div>
                    </div>
                </div>
                <div class="col-4 px-0 pt-3 mr-3">
                    <div class="header-login same-style">


                        <ul class="header_list border_list list_none header_dropdown text-center text-md-right"
                            style="text-align: initial;border: 2px solid #eea5a6;
                                    display: inline-block;padding: 5px 5px;border-radius:4px;">
                        @auth
                            <!--<i class="ti-user"-->
                                <!--   style="font-size: 20px;color: white;vertical-align: middle;"></i>-->
                                <li class="dropdown mx-1 profile-drop" style="padding-left: 0;display: inline-block">


                                    <a class="dropdown-toggle" href="#" id="navbarDropdown"
                                       role="button" style="color: white;font-size: 13px;"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        پروفایل
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{url('/panel/account')}}">
                                            پروفایل کاربری
                                        </a>

                                        <a class="dropdown-item">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button
                                                    style="background-color: unset;border: unset;color: #dc3545;font-size:12px;margin-top:4px"
                                                    type="submit">
                                                    خروج
                                                </button>
                                            </form>
                                        </a>

                                    </div>
                                </li>
                            @else

                                <div>
                                    <a href="{{ route('login') }}" class="text-white">
                                        <!--<i class="ti-user"-->
                                        <!--   style="font-size: 20px;color: white;vertical-align: middle;">-->

                                        <!--</i>-->
                                        ورود / ثبت نام
                                    </a>

                                    <a href="{{ route('login') }}" class="mr-2"
                                       style="color:white;font-size: 13px;"></a>
                                    <span style="color: #dfa336;font-size: 13px;"></span>
                                    <a href="{{ route('login') }}" class="ml-1"
                                       style="color:white;font-size: 13px;">
                                    </a>
                                </div>
                            @endauth
                        </ul>

                    </div>
                </div>
                <div class="col-2 pt-4 text-center text-white close-menu">
                    <span style="font-size:19px">X</span></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mobile-menu-search" style="padding-top:46px ">

                        <input @keyup="autoComplete" id="search-input"
                               style="border:2px solid #eea5a6;background-color: white;padding-right: 15px;border-radius:90px;color: #555555"
                               v-model="searchquery"
                               placeholder="جستجوی محصول ..." type="text">
                        <i class="ti-search"
                           style="position: absolute;top:50%;left:30px;font-size: 24px;color: #757575 !important;"></i>
                        <i class="ion-ios-close-empty"
                           v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                           @click="searchClose"
                           style="position: absolute;left:136px;top: 15px;font-size: 30px;cursor: pointer;padding: 10px"></i>
                        <div
                            v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                            style="position: absolute;width: 95%;z-index: 100;top:88px;">
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
                                    <span
                                        style="margin-right:50px;font-size: 14px;color: #b9b9b9;">@{{ result.name_f }}</span>
                                </li>
                            </ul>
                        </div>
                        {{--<div @click="searchClose" v-if="flag"--}}
                        {{--style="background-color: black;opacity:.3;position: fixed;width: 100%;height: 100%;top: 91px;left: 0;z-index:9"></div>--}}
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5 text-right">
                <a class="navbar-brand" href="{{ url('/cart') }}"
                   style="color: white;font-size: 0.9rem;padding:10px 25px 7px 16px;background-color: #1c4b7c;width:100%;margin-bottom: 15px">
                    <i class="ti-shopping-cart" style="font-size: 1.1rem;padding-left: 5px;"></i>
                    سبد خرید
                </a>
                <a class="navbar-brand" href="{{ url('/') }}"
                   style="color: white;font-size: 0.9rem;padding:10px 25px 7px 16px;background-color: #1c4b7c;width:100%">
                    <i class="ti-home" style="font-size: 1.1rem;padding-left: 5px;"></i>
                    صفحه اصلی
                </a>

                <!--<button class="navbar-toggler" type="button" data-toggle="collapse"-->
                <!--        data-target="#navbarSupportedContent"-->
                <!--        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">-->
                <!--<span class="navbar-toggler-icon"></span>-->
                <!--</button>-->


                <ul class="mobile-menu-links ttt">
                    <template v-for="(root,index) in roots">
                        <li class="my-3 mobile-menu-link-one pt-2 px-3" @click="openMenu(root.id)"
                            :id=`item-${root.id}`>
                            <a href="#" class="d-block">
                                @{{ root.name }}
                                <ol class="col-4 col-sm-3 mx-auto px-0 float-none sub-links pr-2">
                                    <template v-for="(cat,index) in root.children_recursive">
                                        <li class="my-3">
                                            <a @click="selectResult(cat.name,'cat')">@{{ cat.name }}</a>
                                        </li>
                                    </template>
                                </ol>
                            </a>
                        </li>
                    </template>
                </ul>


            </div>
        </div>
    </div>
    <div>
        <div class="header-container" style="background-color:rgba(237, 177, 175, 0.31);padding-bottom: 40px">
            <header>
                <div class="sidebar-cart onepage-sidebar-area">
                    <div class="wrap-sidebar">
                        <div class="sidebar-cart-all">
                            <div class="sidebar-cart-icon">
                                <button class="op-sidebar-close"><span class="ti-close"></span></button>
                            </div>
                            <div class="cart-content">
                                <h3 v-if="carts.length">سبد خرید</h3>
                                <ul v-if="carts.length">
                                    <template v-for="(cart, name, index) in carts">
                                        <li class="single-product-cart">
                                            <div class="cart-img">
                                                <a href="#"><img style="width: 120px;height: 120px"
                                                                 :src="'/images/product/'+cart.product.image"></a>
                                            </div>
                                            <div class="cart-title" style="direction: rtl">
                                                <h3><a href="#">@{{ cart.product.name }}</a></h3>
                                                <span>  @{{ numberFormat(cart.price*cart.number) }}  تومان</span>
                                                <span>- تعداد : @{{ cart.number }}</span>
                                            </div>
                                            <div class="cart-delete">
                                                <a @click="deleteCart(cart.id)"><i class="ti-trash"></i></a>
                                            </div>
                                        </li>
                                    </template>

                                    <li class="single-product-cart">
                                        <div class="cart-total">
                                            <h4>جمع : <span>@{{ numberFormat(totalCart) }} تومان</span></h4>
                                        </div>
                                    </li>
                                </ul>
                                <div class="my-5" v-else>
                                    <h4>سبد خرید خود را تشکیل دهید</h4>
                                </div>
                                <div class="cart-checkout-btn" v-if="carts.length">
                                    <a class="cr-btn btn-style cart-btn-style"
                                       href="{{url('/cart')}}"><span>مشاهده سبد خرید</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="position: relative" class="header-area transparent-bar">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-5 col-5">
                                <div class="logo-menu-wrapper">
                                    <div class="logo" style="margin-top:8px">
                                        <a href="{{url('/')}}">
                                            <img src="/dress/assets/img/logo/logo.png"
                                                 style="width: 50%;"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-7 d-none d-md-block">
                                <div class="search">

                                    <input @keyup="autoComplete" id="search-input"
                                           style="border:2px solid #eea5a6;background-color: white;padding-right: 15px;border-radius:90px;color:#535353"
                                           v-model="searchquery"
                                           placeholder="جستجوی محصول ..." type="text">
                                    <i class="ti-search"
                                       style="position: absolute;bottom:32%;transform:translateY(50%);left:30px;font-size: 24px;color:#535353 !important;"></i>
                                    <i class="ion-ios-close-empty"
                                       v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                                       @click="searchClose"
                                       style="position: absolute;left:136px;top: 38px;font-size: 30px;cursor: pointer;padding: 10px"></i>
                                    <div
                                        v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                                        style="position: absolute;width: 95%;z-index: 100;top:88px;">
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
                                    {{--<div @click="searchClose" v-if="flag"--}}
                                    {{--style="background-color: black;opacity:.3;position: fixed;width: 100%;height: 100%;top: 91px;left: 0;z-index:9"></div>--}}
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-7 col-7">
                                <div class="header-site-icon">
                                    <div class="header-login same-style ml-3 d-none d-lg-flex">

                                        <ul class="header_list border_list list_none header_dropdown text-center text-md-right"
                                            style="text-align: initial;border: 2px solid #eea5a6;
                                    display: inline-block;padding: 8px 8px;border-radius:4px;">
                                            @auth
                                                <i class="ti-user"
                                                   style="font-size: 20px;color: #2d2d2d;vertical-align: middle;"></i>
                                                <li class="dropdown mx-1 profile-drop"
                                                    style="padding-left: 0;display: inline-block">


                                                    <a class="dropdown-toggle" href="#" id="navbarDropdown"
                                                       role="button" style="color: #323232;font-size: 13px;"
                                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        پروفایل
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                                        <a class="dropdown-item" href="{{url('/panel/account')}}">
                                                            پروفایل کاربری
                                                        </a>
                                                        <a class="dropdown-item">
                                                            <form method="POST" action="{{ route('logout') }}">
                                                                @csrf
                                                                <button
                                                                    style="background-color: unset;border: unset;color: #dc3545;font-size:12px;margin-top:4px"
                                                                    type="submit">
                                                                    خروج
                                                                </button>
                                                            </form>
                                                        </a>

                                                    </div>
                                                </li>
                                            @else

                                                <div>
                                                    <i class="ti-user"
                                                       style="font-size: 20px;color: black;vertical-align: middle;"></i>
                                                    <a href="{{ route('login') }}" class="mr-2"
                                                       style="color:#2d2d2d;font-size: 13px;">ورود</a>
                                                    <span style="color: #dfa336;font-size: 13px;">/</span>
                                                    <a href="{{ url('register') }}" class="ml-1"
                                                       style="color:#2d2d2d;font-size: 13px;">ثبت
                                                        نام</a>
                                                </div>
                                            @endauth
                                        </ul>

                                    </div>
                                    <div class="header-cart same-style mt-2 d-none d-lg-flex">
                                        <button class="sidebar-trigger">
                                            <i class="ti-shopping-cart" style="color: black;font-size:2rem;"></i>
                                            <span style="background-color: #ffcbc9;color: #0d3349;" class="count-style">@{{ countCart }}</span>
                                            <i style="position: absolute;font-size: 0.9rem;color: black;font-style: normal;width: 70px;top: 13px;right: 44px;">سبد
                                                خرید</i>
                                        </button>
                                    </div>

                                    <div class="header-menu d-block d-lg-none">
                                        <span class="bars"></span>
                                        <span class="bars"></span>
                                        <span class="bars"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>


        <nav class="navbar navbar-expand-lg px-5 cat-nav d-none d-lg-flex " style="background-color: #ffcbc9">
            <a class="navbar-brand" href="{{ url('/') }}"
               style="color: black;font-size: 0.8rem;padding: 7px 4% 7px 10px;">
                <i class="ti-home" style="font-size: 1.1rem;padding-left: 5px;"></i>
                صفحه اصلی
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto mr-4">
                    <template v-for="(root,index) in roots">
                        <li class="nav-item dropdown ml-3">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                @{{ root.name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <template v-for="(cat,index) in root.children_recursive">
                                    <a class="dropdown-item" @click="selectResult(cat.name,'cat')">@{{ cat.name }}</a>
                                </template>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </nav>
    </div>
</div>


@yield('content')


<footer class="gray-bg footer-padding">
    <div class="container-fluid">
        <div class="footer-top pt-85 pb-25">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="footer-widget mb-30">
                        <div class="footer-widget-title">
                            <h3>در تماس باشید</h3>
                        </div>
                        <div class="food-info-wrapper">
                            <div class="food-address">
                                <div class="food-info-icon">
                                    <i class="ion-ios-home-outline"></i>
                                </div>
                                <div class="food-info-content">
                                    <p>شعبه 1 :</p>
                                    <p class="mb-3">
                                        تهران ، اسلامشهر ، شهرک واوان بلوار ولیعصر پاساژ مهستان طبقه اول واحد 13
                                    </p>
                                </div>
                            </div>
                            <div class="food-address">
                                <div class="food-info-icon">
                                    <i class="ion-ios-telephone-outline"></i>
                                </div>
                                <div class="food-info-content">
                                    <p style="direction: ltr">021-561 640 02</p>
                                </div>
                            </div>

                            <div class="food-address">
                                <div class="food-info-icon">
                                    <i class="ion-ios-telephone"></i>
                                </div>
                                <div class="food-info-content">
                                    <p style="direction: ltr">0919 99 69 350</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="footer-widget mb-30">
                        <div class="footer-widget-title">
                            <h3>روش های پرداخت</h3>
                        </div>
                        <div class="food-widget-content">
                            <ul class="quick-link">
                                <li><a href="/online/online">پرداخت آنلاین</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="footer-widget mb-30">
                        <div class="footer-widget-title">
                            <h3>قوانین و مقررات</h3>
                        </div>
                        <div class="food-widget-content">
                            <ul class="quick-link">
                                <li><a href="/delivery">شرایط تحویل کالا</a></li>
                                <li><a href="/rolls">قوانین استفاده از سایت</a></li>
                                <li class="mt-5">
                                    <a target="_blank"
                                       href="https://trustseal.enamad.ir/?id=164750&Code=1lMUgF4lWM5z4NkyVDX0">
                                        <img src="/star1.png" style="cursor:pointer" id="1lMUgF4lWM5z4NkyVDX0">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget mb-30">
                        <div class="footer-widget-title">
                            <h3>ترمه تن</h3>
                        </div>
                        <div class="food-widget-content">
                            <ul class="quick-link">
                                <li><a href="/about-us">درباره ما</a></li>
                                <li><a href="/contact-us">تماس با ما</a></li>
                                <li><a href="/complaint">ثبت شکایات</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget mb-30">
                        <div class="footer-widget-title">
                            <h3>موقعیت مکانی</h3>
                        </div>
                        <div class="twitter-info-wrapper">
                            <img src="/images/map.jpg" style="width: 100%;border: 1px solid #f3a395;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="display:flex;flex-direction:row-reverse">
                <div class="col-md-9">
                    <a href="https://www.instagram.com/termetan/">
                        <img style="display: inline-block;width: 35px;margin-right: 15px;"
                             src="/dress/images/instagram.svg">
                    </a>
                    <a href="https://t.me/termetan">
                        <img style="display: inline-block;width: 35px;margin-right: 15px;"
                             src="/dress/images/telegram.svg">
                    </a>
                </div>
                <div class="col-md-3 samane">
                    <a href="https://tracking.post.ir/"
                       style="    background: #08317d;color: white;padding: 5px 20px;border-radius: 4px;display: inline-block;margin-top: 8px;">
                        سامانه رهگیری مرسولات پستی
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span class="ion-android-close" aria-hidden="true"></span>
    </button>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="qwick-view-left">
                    <div class="quick-view-learg-img">
                        <div class="quick-view-tab-content tab-content">
                            <div class="tab-pane active show fade" id="modal1" role="tabpanel">
                                <img src="/dress/assets/img/quick-view/l1.jpg" alt="">
                            </div>
                            <div class="tab-pane fade" id="modal2" role="tabpanel">
                                <img src="/dress/assets/img/quick-view/l2.jpg" alt="">
                            </div>
                            <div class="tab-pane fade" id="modal3" role="tabpanel">
                                <img src="/dress/assets/img/quick-view/l3.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="quick-view-list nav" role="tablist">
                        <a class="active" href="#modal1" data-toggle="tab" role="tab" aria-selected="true"
                           aria-controls="home1">
                            <img src="/dress/assets/img/quick-view/s1.jpg" alt="">
                        </a>
                        <a href="#modal2" data-toggle="tab" role="tab" aria-selected="false" aria-controls="home2">
                            <img src="/dress/assets/img/quick-view/s2.jpg" alt="">
                        </a>
                        <a href="#modal3" data-toggle="tab" role="tab" aria-selected="false" aria-controls="home3">
                            <img src="/dress/assets/img/quick-view/s3.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="qwick-view-right">
                    <div class="qwick-view-content">
                        <h3>ماگ دست ساز</h3>
                        <div class="price">
                            <span class="new">90000تومان</span>
                            <span class="old">120000تومان  </span>
                        </div>
                        <div class="rating-number">
                            <div class="quick-view-rating">
                                <i class="ion-ios-star red-star"></i>
                                <i class="ion-ios-star red-star"></i>
                                <i class="ion-ios-star red-star"></i>
                                <i class="ion-ios-star red-star"></i>
                                <i class="ion-ios-star red-star"></i>
                            </div>
                        </div>
                        <p>چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                            تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. .</p>
                        <div class="quick-view-select">
                            <div class="select-option-part">
                                <label>سایز*</label>
                                <select class="select">
                                    <option value="">- لطفا انتخاب کنید -</option>
                                    <option value="">900</option>
                                    <option value="">700</option>
                                </select>
                            </div>
                            <div class="select-option-part">
                                <label>رنگ *</label>
                                <select class="select">
                                    <option value="">-لطفا انتخاب کنید -</option>
                                    <option value="">نارنجی</option>
                                    <option value="">صورتی</option>
                                    <option value="">زرد</option>
                                </select>
                            </div>
                        </div>
                        <div class="quickview-plus-minus">
                            <div class="cart-plus-minus">
                                <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                            </div>
                            <div class="quickview-btn-cart">
                                <a class="btn-style cr-btn" href="#"><span>افزودن به سبد خرید</span></a>
                            </div>
                            <div class="quickview-btn-wishlist">
                                <a class="btn-hover cr-btn" href="#"><span><i
                                            class="ion-ios-heart-outline"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/dress/assets/js/vendor/jquery-1.12.0.min.js"></script>
<script src="/dress/assets/js/popper.js"></script>
<script src="/dress/assets/js/bootstrap.min.js"></script>
<script src="/dress/assets/js/isotope.pkgd.min.js"></script>
<script src="/dress/assets/js/imagesloaded.pkgd.min.js"></script>
<script src="/dress/assets/js/jquery.counterup.min.js"></script>
<script src="/dress/assets/js/waypoints.min.js"></script>
<script src="/dress/assets/js/ajax-mail.js"></script>
<script src="/dress/assets/js/owl.carousel.min.js"></script>
<script src="/dress/assets/js/plugins.js"></script>
<script src="/dress/assets/js/main.js"></script>


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
<script>
    $(document).ready(function () {
        $(".header-menu").click(function () {
            $(".mobile-menu").addClass("open");

        });
        $(".close-menu").click(function () {
            $(".mobile-menu").removeClass("open");
        });
    });
</script>
@yield('script')
<style>
    .dropdown-menu{
        top:115% !important;
        border-top:none;
    }
    
    
    .dropdown-item:focus, .dropdown-item:hover{
        background-color:#f1edec;
    }
    .cat-nav .dropdown-menu {
        right: 0 !important;
        text-align: right !important;
        border-radius: 0 !important;
        padding: 0 !important;
    }

    .cat-nav .dropdown-item {
        right: 0 !important;
        text-align: right !important;
        padding: 12px !important;
        font-size: 13px;
        cursor: pointer;
    }

    .cat-nav #navbarDropdown {
        color: #2f2f2f;
        font-size:13px !important;
    }

    .cat-nav .dropdown-toggle::after {
        display: none;
    }


    .profile-drop .dropdown-menu {
        top: 7px !important;
        left: -62px !important;
        text-align: right !important;
        border-radius: 0 !important;
        border: 2px solid #888888 !important;
        padding: 0 !important;
    }

    .profile-drop .dropdown-item {
        right: 0 !important;
        text-align: right !important;
        padding: 9px 12px 9px 0px !important;
        font-size: 0.8rem;
        border-bottom: 1px dashed #c6c6c6;
        cursor: pointer;
    }

    @media only screen and (max-width: 768px) {
        .samane a {
            width: 100%;
            text-align: center;
            margin-top: 15px !important;
            padding: 10px 20px !important;
        }
    }
</style>

</body>

</html>
