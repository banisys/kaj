<!DOCTYPE html>
<html class="no-js" lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>فروشگاه 19 آنلاین</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/online/assets/img/favicon.ico')}}">
    <meta name="theme-color" content="#c40316">

    <script src="{{ asset('/js/online/app.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/online/assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('/online/assets/css/style.css')}}">

    @yield('style')
</head>

<body>

<div class="off_canvars_overlay"></div>
<div class="Offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                </div>
                <div class="Offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>
                    <div class="antomi_message">
                        <p>ارسال رایگان - ضمانت بازگشت وجه 30 روزه</p>
                    </div>
                    <div class="header_top_settings text-right">
                        <ul>
                            <li><a href="#">آدرس‌های فروشگاه</a></li>
                            <li><a href="#">پیگیری سفارش</a></li>
                            <li>تلفن تماس: <a class="ltr-text" href="tel:+(+98)800456789">(+98) 800 456 789 </a></li>
                            <li>ضمانت کیفیت محصولات</li>
                        </ul>
                    </div>
                    <div class="header_configure_area">
                        <div class="header_wishlist">
                            <a href="wishlist.html"><i class="ion-android-favorite-outline"></i>
                                <span class="wishlist_count">3</span>
                            </a>
                        </div>
                        <div class="mini_cart_wrapper">
                            <a href="javascript:void(0)">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="cart_price"><i class="ion-ios-arrow-down"></i></span>
                                <span class="cart_count">2</span>

                            </a>
                            <!--mini cart-->
                            <div class="mini_cart">
                                <div class="mini_cart_inner">
                                    <div class="cart_item">
                                        <div class="cart_img">
                                            <a href="#"><img src="/online/assets/img/s-product/product.jpg" alt=""></a>
                                        </div>
                                        <div class="cart_info">
                                            <a href="#">گوشی هوشمند سامسونگ A50</a>
                                            <p>تعداد: 1 × <span> 60,000 تومان </span></p>
                                        </div>
                                        <div class="cart_remove">
                                            <a href="#"><i class="ion-android-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="cart_item">
                                        <div class="cart_img">
                                            <a href="#"><img src="/online/assets/img/s-product/product2.jpg" alt=""></a>
                                        </div>
                                        <div class="cart_info">
                                            <a href="#">صندلی آشپزخانه پلاستیکی Nilper</a>
                                            <p>تعداد: 1 × <span> 60,000 تومان </span></p>
                                        </div>
                                        <div class="cart_remove">
                                            <a href="#"><i class="ion-android-close"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mini_cart_table">
                                    <div class="cart_total">
                                        <span>جمع اجزا:</span>
                                        <span class="price">138,000 تومان</span>
                                    </div>
                                    <div class="cart_total mt-10">
                                        <span>جمع کل:</span>
                                        <span class="price">138,000 تومان</span>
                                    </div>
                                </div>
                                <div class="mini_cart_footer">
                                    <div class="cart_button">
                                        <a href="cart.html">مشاهده سبد</a>
                                    </div>
                                    <div class="cart_button">
                                        <a href="checkout.html">پرداخت</a>
                                    </div>

                                </div>
                            </div>
                            <!--mini cart end-->
                        </div>
                    </div>
                    <div class="search_container">
                        <form action="#">
                            <div class="hover_category">
                                <select class="select_option" name="select" id="categori1">
                                    <option selected value="1">همه دسته ها</option>
                                    <option value="2">لوازم جانبی</option>
                                    <option value="3">سایر لوازم جانبی</option>
                                    <option value="4">لوازم کامپیوتر</option>
                                    <option value="5">دوربین و ویدیو</option>
                                    <option value="6">صفحه نمایش</option>
                                    <option value="7">تبلت ها</option>
                                    <option value="8">لپ تاپ ها</option>
                                    <option value="9">کیف دستی</option>
                                    <option value="10">هدفون و اسپیکر</option>
                                    <option value="11">گیاهان دارویی</option>
                                    <option value="12">سبزیجات</option>
                                    <option value="13">فروشگاه</option>
                                    <option value="14">لپ تاپ و کامپیوتر</option>
                                    <option value="15">ساعت ها</option>
                                    <option value="16">لوازم الکترونیکی</option>
                                </select>
                            </div>
                            <div class="search_box">
                                <input placeholder="جستجوی محصول ..." type="text">
                                <button type="submit">جستجو</button>
                            </div>
                        </form>
                    </div>
                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li class="menu-item-has-children active">
                                <a href="#">خانه</a>
                                <ul class="sub-menu">
                                    <li><a href="index.html">خانه 1</a></li>
                                    <li><a href="index-2.html">خانه 2</a></li>
                                    <li><a href="index-3.html">خانه 3</a></li>
                                    <li><a href="index-4.html">خانه 4</a></li>
                                    <li><a href="index-5.html">خانه 5</a></li>
                                    <li><a href="index-6.html">خانه 6</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">فروشگاه</a>
                                <ul class="sub-menu">
                                    <li class="menu-item-has-children">
                                        <a href="#">طرح های فروشگاه</a>
                                        <ul class="sub-menu">
                                            <li><a href="shop.html">فروشگاه</a></li>
                                            <li><a href="shop-fullwidth.html">تمام عرض</a></li>
                                            <li><a href="shop-fullwidth-list.html">تمام عرض لیست</a></li>
                                            <li><a href="shop-left-sidebar.html">نوار کناری چپ </a></li>
                                            <li><a href="shop-left-sidebar-list.html"> نوار کناری چپ لیست</a></li>
                                            <li><a href="shop-list.html">نمایش لیست</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">سایر صفحات</a>
                                        <ul class="sub-menu">
                                            <li><a href="cart.html">سبد خرید</a></li>
                                            <li><a href="wishlist.html">لیست علاقه‌مندی‌ها</a></li>
                                            <li><a href="checkout.html">پرداخت</a></li>
                                            <li><a href="my-account.html">حساب کاربری</a></li>
                                            <li><a href="404.html">خطای 404</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">انواع محصول</a>
                                        <ul class="sub-menu">
                                            <li><a href="product-details.html">جزئیات محصول</a></li>
                                            <li><a href="product-sidebar.html">محصول با نوار کناری</a></li>
                                            <li><a href="product-grouped.html">محصول گروهبندی شده</a></li>
                                            <li><a href="variable-product.html">محصول متغیر</a></li>
                                            <li><a href="product-countdown.html">محصول شمارنده</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">بلاگ</a>
                                <ul class="sub-menu">
                                    <li><a href="blog.html">بلاگ</a></li>
                                    <li><a href="blog-details.html">جزئیات مطلب بلاگ</a></li>
                                    <li><a href="blog-fullwidth.html">بلاگ تمام عرض</a></li>
                                    <li><a href="blog-right-sidebar.html">نوار کناری راست</a></li>
                                    <li><a href="blog-no-sidebar.html">بلاگ بدون نوار کناری</a></li>
                                </ul>

                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">صفحات </a>
                                <ul class="sub-menu">
                                    <li><a href="about.html">درباره ما</a></li>
                                    <li><a href="faq.html">سوالات متداول</a></li>
                                    <li><a href="privacy-policy.html">سیاست حریم خصوصی</a></li>
                                    <li><a href="contact.html">تماس</a></li>
                                    <li><a href="login.html">ورود</a></li>
                                    <li><a href="404.html">خطای 404</a></li>
                                    <li><a href="compare.html">مقایسه</a></li>
                                    <li><a href="coming-soon.html">به زودی</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="my-account.html">حساب کاربری</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="about.html">درباره ما</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="contact.html"> تماس با ما</a>
                            </li>
                        </ul>
                    </div>
                    <div class="Offcanvas_footer">
                        <span><a href="#"><i class="fa fa-envelope-o"></i> info@yourdomain.com</a></span>
                        <ul>
                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<header id="header" style="position: relative">
    <div @click="searchClose" v-show="flag"
         style="width: 100%;height: 162px;background-color: white;opacity:0;position: absolute;top: 0px;left: 0;z-index:998"></div>

    <div @click="flagMega=!flagMega" v-show="flagMega"
         style="width: 100%;height: 100vh;background-color: white;opacity:0.2;position: absolute;top: 0px;left: 0;z-index:998"></div>
    <div @click="flagMega=!flagMega" v-show="flagMega"
         style="width: 100%;height: 100vh;background-color: black;opacity: .5;position: absolute;top: 214px;left: 0;z-index:998"></div>
    <div v-show="flagMega" id="megaContainer"
         style="position: absolute;top: 202px;width: 100%;z-index: 999;padding: 12px 10px;">
        <div class="container"
             style="background-color: white;border-bottom-right-radius: 6px;border-bottom-left-radius: 6px;padding-top:20px;border: 2px solid #c40316;">
            <div class="row">

                <div class="col-2">
                    <ul class="nav nav-tabs flex-column" id="myTab" role="tablist"
                        style="background-color: #f6f6f6;height: min-content;border-left: 1px solid #dedede;">
                        <li class="nav-item" v-for="(megaCat,index) in megaCats" style="padding-bottom:5px;">
                            <a class="nav-link mega-cat-item" data-toggle="tab" :href="'#mega'+megaCat.id" role="tab"
                               @mouseover="hoverMegaCat(megaCat.id)"
                               :aria-controls="'#mega'+megaCat.id" :id="'mega-cat'+megaCat.id">
                                @{{ megaCat.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-10" style="padding: 0 15px;" @mouseover="hoverMegaContainer()">
                    <div class="tab-content" style="margin: unset">
                        <div class="tab-pane" v-for="(megaCat,index,key) in megaCats"
                             :class="activeFirstMega(index)"
                             :id="'mega'+megaCat.id"
                             role="tabpanel">
                            <ul>
                                <li class="col-3 px-0 float-left maga-item" v-for="item in megas[megaCat.id]"
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

    <div class="main_header">
        <div class="container">

            <div class="header_top">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-5">
                        <div class="antomi_message">
                            <p>ارسال رایگان - ضمانت بازگشت وجه 30 روزه</p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="header_top_settings text-right">
                            <ul>
                                <li><a href="#">آدرس‌های فروشگاه</a></li>
                                <li><a href="#">پیگیری سفارش</a></li>
                                <li>تلفن تماس: <a class="ltr-text" href="tel:+(+98)800456789">(+98) 800 456 789 </a>
                                </li>
                                <li>ضمانت کیفیت محصولات</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header_middle sticky-header">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-6">
                        <div class="logo">
                            <a href="index.html"><img src="/online/assets/img/logo/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12">
                        <div class="main_menu menu_position text-center">
                            <nav>
                                <ul>
                                    <li><a class="active" href="index.html">خانه<i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu">
                                            <li><a href="index.html">خانه فروشگاه 1</a></li>
                                            <li><a href="index-2.html">خانه فروشگاه 2</a></li>
                                            <li><a href="index-3.html">خانه فروشگاه 3</a></li>
                                            <li><a href="index-4.html">خانه فروشگاه 4</a></li>
                                            <li><a href="index-5.html">خانه فروشگاه 5</a></li>
                                            <li><a href="index-6.html">خانه فروشگاه 6</a></li>
                                        </ul>
                                    </li>
                                    <li class="mega_items"><a href="shop.html">فروشگاه<i
                                                class="fa fa-angle-down"></i></a>
                                        <div class="mega_menu">
                                            <ul class="mega_menu_inner">
                                                <li><a href="#">طرح های فروشگاه</a>
                                                    <ul>
                                                        <li><a href="shop-fullwidth.html">تمام عرض</a></li>
                                                        <li><a href="shop-fullwidth-list.html">تمام عرض لیست</a></li>
                                                        <li><a href="shop-left-sidebar.html">نوار کناری چپ </a></li>
                                                        <li><a href="shop-left-sidebar-list.html"> نوار کناری چپ
                                                                لیست</a></li>
                                                        <li><a href="shop-list.html">نمایش لیست</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#">سایر صفحات</a>
                                                    <ul>
                                                        <li><a href="cart.html">سبد خرید</a></li>
                                                        <li><a href="wishlist.html">لیست علاقه‌مندی‌ها</a></li>
                                                        <li><a href="checkout.html">پرداخت</a></li>
                                                        <li><a href="my-account.html">حساب کاربری</a></li>
                                                        <li><a href="404.html">خطای 404</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#">انواع محصول</a>
                                                    <ul>
                                                        <li><a href="product-details.html">جزئیات محصول</a></li>
                                                        <li><a href="product-sidebar.html">محصول با نوار کناری</a></li>
                                                        <li><a href="product-grouped.html">محصول گروهبندی شده</a></li>
                                                        <li><a href="variable-product.html">محصول متغیر</a></li>
                                                        <li><a href="product-countdown.html">محصول شمارنده</a></li>

                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="blog.html">بلاگ<i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu pages">
                                            <li><a href="blog-details.html">جزئیات مطلب بلاگ</a></li>
                                            <li><a href="blog-fullwidth.html">بلاگ تمام عرض</a></li>
                                            <li><a href="blog-right-sidebar.html">نوار کناری راست</a></li>
                                            <li><a href="blog-no-sidebar.html">بلاگ بدون نوار کناری</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">صفحات <i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu pages">
                                            <li><a href="about.html">درباره ما</a></li>
                                            <li><a href="faq.html">سوالات متداول</a></li>
                                            <li><a href="privacy-policy.html">سیاست حریم خصوصی</a></li>
                                            <li><a href="contact.html">تماس</a></li>
                                            <li><a href="login.html">ورود</a></li>
                                            <li><a href="404.html">خطای 404</a></li>
                                            <li><a href="compare.html">مقایسه</a></li>
                                            <li><a href="coming-soon.html">به زودی</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="about.html">درباره ما</a></li>
                                    <li><a href="contact.html"> تماس با ما</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="header_configure_area">
                            <div class="header_wishlist">
                                <a href="wishlist.html"><i class="ion-android-favorite-outline"></i>
                                    <span class="wishlist_count">3</span>
                                </a>
                            </div>
                            <div class="mini_cart_wrapper">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-shopping-bag"></i>
                                    <span class="cart_price">
                                        <i class="ion-ios-arrow-down"></i>
                                    </span>
                                    <span class="cart_count">@{{ countCart }}</span>

                                </a>

                                <div class="mini_cart" v-if="carts.length">
                                    <div class="mini_cart_inner">
                                        <template v-for="(cart, name, index) in carts">
                                            <div class="cart_item">
                                                <div class="cart_img">
                                                    <a href="#">
                                                        <img :src="'/images/product/'+cart.product.image">
                                                    </a>
                                                </div>
                                                <div class="cart_info">
                                                    <a href="#">@{{ cart.product.name }}</a>
                                                    <p>
                                                        <span> @{{ numberFormat(cart.price*cart.number) }} تومان </span>
                                                        <span style="color: grey">  - تعداد : @{{ cart.number }} </span>
                                                    </p>
                                                </div>
                                                <div class="cart_remove">
                                                    <a @click="deleteCart(cart.id)">
                                                        <i class="ion-android-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="mini_cart_table">
                                        <div class="cart_total mt-10">
                                            <span>جمع کل:</span>
                                            <span class="price">@{{ numberFormat(totalCart) }} تومان</span>
                                        </div>
                                    </div>
                                    <div class="mini_cart_footer">
                                        <div class="cart_button">
                                            <a href="{{url('/cart')}}">مشاهده سبد</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="mini_cart" v-else>
                                    <p class="my-3" style="text-align: center;">سبد خرید خود را تشکیل دهید</p>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header_bottom">
                <div class="row align-items-center">
                    <div class="column1 col-lg-3 col-md-6">
                        <div class="categories_menu categories_three">
                            <div class="categories_title" @click="flagMega=!flagMega">
                                <h2 class="categori_toggle">دسته بندی ها</h2>
                            </div>

                        </div>
                    </div>

                    <div class="column2 col-lg-6 ">
                        <div class="search_container">
                            <form action="#">
                                <div class="search_box">
                                    <input @keyup="autoComplete"
                                           v-model="searchquery"
                                           placeholder="جستجوی محصول ..." type="text">
                                    <i class="ion-ios-close-empty"
                                       v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                                       @click="searchClose"
                                       style="position: absolute;left:136px;top: 1px;font-size: 30px;cursor: pointer;padding: 10px"></i>
                                    <button type="submit">جستجو</button>
                                    <div
                                        v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                                        style="position: absolute;width: 100%;z-index: 100;top: 52px;">
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
                                    <div @click="searchClose" v-if="flag"
                                         style="background-color: black;opacity:.3;position: fixed;width: 100%;height: 100%;top: 215px;left: 0;z-index:9"></div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="column3 col-lg-3 col-md-6">
                        <div class="header_bigsale">
                            <a href="#">فروش بزرگ جمعه سیاه</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</header>


@yield('content')

<footer class="footer_widgets">
    <!--newsletter area start-->
    <div class="newsletter_area">
        <div class="container">
            <div class="newsletter_inner">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-5">
                        <div class="newsletter_sing_up">
                            <h3>عضویت در خبرنامه</h3>
                            <p>با عضویت از <span>30% تخفیف</span> بهره مند شوید</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7">
                        <div class="subscribe_content">
                            <p><strong>به 226,000+ مشترک ما</strong> بپیوندید و از تخفیف های ویژه هفتگی مخصوص مشترکین
                                خبرنامه بهره مند شوید.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="subscribe_form">
                            <form id="mc-form" class="mc-form footer-newsletter">
                                <input id="mc-email" type="email" autocomplete="off" placeholder="... آدرس ایمیل شما"
                                       dir="ltr">
                                <button id="mc-submit">اشتراک</button>
                            </form>
                            <!-- mailchimp-alerts Start -->
                            <div class="mailchimp-alerts text-centre">
                                <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                            </div><!-- mailchimp-alerts end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--newsletter area end-->
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5 col-sm-7">
                    <div class="widgets_container contact_us">
                        <h3>دریافت برنامه</h3>
                        <div class="aff_content">
                            <p>برنامه <strong>آنتومی</strong> هم اکنون در گوگل پلی و اپل استور آماده دریافت است.</p>
                        </div>
                        <div class="app_img">
                            <figure class="app_img">
                                <a href="#"><img src="/online/assets/img/icon/icon-appstore.png" alt=""></a>
                            </figure>
                            <figure class="app_img">
                                <a href="#"><img src="/online/assets/img/icon/icon-googleplay.png" alt=""></a>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-5">
                    <div class="widgets_container widget_menu">
                        <h3>اطلاعات</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="about.html">درباره ما</a></li>
                                <li><a href="#">نحوه ارسال</a></li>
                                <li><a href="#">محصولات جدید</a></li>
                                <li><a href="#">محصولات برتر</a></li>
                                <li><a href="my-account.html">حساب کاربری</a></li>
                                <li><a href="#">سابقه خرید</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="widgets_container widget_menu">
                        <h3>حساب کاربری</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="my-account.html">حساب کاربری</a></li>
                                <li><a href="cart.html">سبد خرید</a></li>
                                <li><a href="wishlist.html">علاقه‌مندی‌ها</a></li>
                                <li><a href="#">کاهش قیمت‌ها</a></li>
                                <li><a href="#">سابقه خرید</a></li>
                                <li><a href="#">سفارشات بین المللی</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-5 col-sm-6">
                    <div class="widgets_container widget_menu">
                        <h3>خدمات مشتری</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">نقشه سایت</a></li>
                                <li><a href="my-account.html">حساب کاربری</a></li>
                                <li><a href="#">نحوه ارسال</a></li>
                                <li><a href="#">سابقه خرید</a></li>
                                <li><a href="wishlist.html">علاقه‌مندی‌ها</a></li>
                                <li><a href="#">ویژه ها</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-7 col-sm-12">
                    <div class="widgets_container">
                        <h3>اطلاعات تماس</h3>
                        <div class="footer_contact">
                            <div class="footer_contact_inner">
                                <div class="contact_icone">
                                    <img src="/online/assets/img/icon/icon-phone.png" alt="">
                                </div>
                                <div class="contact_text">
                                    <p>تلفن تماس 24 ساعته: <br> <strong class="ltr-text">(+98) 123 456 789</strong></p>
                                </div>
                            </div>
                            <p>تبریز، چهار راه آبرسان، فلکه دانشگاه، برج تجاری بلور، طبقه 456، واحد 45</p>
                        </div>

                        <div class="footer_social">
                            <ul>
                                <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="copyright_area">
                        <p>ارائه شده در وب‌سایت <a href="https://www.rtl-theme.com" target="_blank">راست‌چین</a></p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer_payment text-right">
                        <img src="/online/assets/img/icon/payment.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- modal area start-->
<div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="/online/assets/img/product/productbig2.jpg"
                                                             alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="/online/assets/img/product/productbig3.jpg"
                                                             alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="/online/assets/img/product/productbig4.jpg"
                                                             alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="/online/assets/img/product/productbig5.jpg"
                                                             alt=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab"
                                               aria-controls="tab1" aria-selected="false"><img
                                                    src="/online/assets/img/product/product1.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab2" role="tab"
                                               aria-controls="tab2" aria-selected="false"><img
                                                    src="/online/assets/img/product/product6.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link button_three" data-toggle="tab" href="#tab3" role="tab"
                                               aria-controls="tab3" aria-selected="false"><img
                                                    src="/online/assets/img/product/product9.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab4" role="tab"
                                               aria-controls="tab4" aria-selected="false"><img
                                                    src="/online/assets/img/product/product14.jpg" alt=""></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>گوشی هوشمند سامسونگ A50</h2>
                                </div>
                                <div class="modal_price mb-10">
                                    <span class="new_price">64,000 تومان</span>
                                    <span class="old_price">78,000 تومان</span>
                                </div>
                                <div class="modal_description mb-15">
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                        گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و
                                        برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای </p>
                                </div>
                                <div class="variants_selects">
                                    <div class="variants_size">
                                        <h2>اندازه</h2>
                                        <select class="select_option">
                                            <option selected value="1">کوچک</option>
                                            <option value="1">متوسط</option>
                                            <option value="1">بزرگ</option>
                                            <option value="1">XL</option>
                                            <option value="1">XXL</option>
                                        </select>
                                    </div>
                                    <div class="variants_color">
                                        <h2>رنگ</h2>
                                        <select class="select_option">
                                            <option selected value="1">بنفش</option>
                                            <option value="1">اطلسی</option>
                                            <option value="1">مشکی</option>
                                            <option value="1">صورتی</option>
                                            <option value="1">نارنجی</option>
                                        </select>
                                    </div>
                                    <div class="modal_add_to_cart">
                                        <form action="#">
                                            <input min="1" max="100" step="2" value="1" type="number">
                                            <button type="submit">افزودن به سبد</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal_social">
                                    <h2>اشتراک گذاری این محصول</h2>
                                    <ul>
                                        <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                        <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal area end-->

<script src="{{asset('/online/assets/js/plugins.js')}}"></script>
<script src="{{asset('/online/assets/js/main.js')}}"></script>
<script>
    var app = new Vue({
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
        },
        methods: {
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
        }
    });
</script>
<script>
    setTimeout(function () {
        $('#megaContainer .nav-item a').hover(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    }, 1000);
</script>
@yield('script')
</body>
</html>
