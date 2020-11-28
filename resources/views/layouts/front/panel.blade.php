<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>فروشگاه اینترنتی</title>
    <link rel="stylesheet" href="/layout/style.css">
    <script src="{{ asset('/js/app.js')}}"></script>
    <link rel="stylesheet" href="/dist/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/layout/slick/slick-1.8.1/slick-1.8.1/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/layout/slick/slick-1.8.1/slick-1.8.1/slick/slick-theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    @yield('style')
</head>

<body onscroll="sticky()" id="home">
<div id="area">
    <div class="container-fluid clearfix sticky-container ">
        <section class="sticky">
            <div class="col-2 float-right">
                <button><a href="">دسته بندی</a></button>
            </div>
            <div class="col-8 float-right">
                <ul>
                    <li class=" float-right"><a href="">خانه</a></li>
                    <li class=" float-right"><a href="">فروشگاه</a></li>
                    <li class=" float-right"><a href="">صفحات</a></li>
                    <li class=" float-right"><a href="">بلاگ</a></li>
                    <li class=" float-right"><a href="">ورود</a></li>
                    <li class=" float-right"><a href="">خرید</a></li>
                </ul>
            </div>
            <div class="col-2 float-right">
                <ul>
                    <li class="col-3 float-right"><a href=""><i class="fa fa-grip-horizontal"></i></a></li>
                    <li class="col-3 float-right"><a href=""><i class="fa fa-user"></i></a></li>
                    <li class="col-3 float-right"><a href=""><i class="fa fa-shopping-cart"></i></a></li>
                    <li class="col-3 float-right"><a href=""><i class="fa fa-search"></i></a></li>
                </ul>
            </div>
        </section>
    </div>
    <div class="container-fluid side-menu">
        <div class="close-menu" onClick="sideMenuClose()"><i>بستن</i><span>&times;</span></div>
        <div class="side-menu-content">
            <ul>
                <li><a href="">زنانه<i class="fa fa-female"></i></a></li>
                <li><a href="">مردانه<i class="fa fa-male"></i></a></li>
                <li><a href="">لوازم جانبی<i class="fa fa-atom"></i></a></li>
                <li><a href="">کفش<i class="fa fa-shoe-prints"></i></a></li>
                <li><a href="">تازه ها<i class="fa fa-shopping-cart"></i></a></li>
                <li><a href="">تخفیفات<i class="fa fa-cash-register"></i></a></li>
                <li><a href="">پیشنهادات ویژه<i class="fa fa-award"></i></a></li>
                <li><a href="">کارت هدیه<i class="fa fa-credit-card"></i></a></li>
                <li><a href="">خرید تم<i class="fa fa-shopping-cart"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid ">
        <div class="header-desktop col-lg-12 clearfix">
            <div class=" header-icons col-5 col-lg-5">
                <div class="col-4 col-lg-4 px-0"><a href="">حساب کاربری <i class="fa fa-user"></i></a></div>
                <div class="col-4 col-lg-4 px-0"><a href="">سبد خرید <i class="fa fa-shopping-cart"></i></a></div>
                <div class="col-4 col-lg-4 px-0"><a href="">علاقه مندی ها <i class="fa fa-heart"></i></a></div>
            </div>
            <div class="header-search col-5 col-lg-4">
                <form action="">
                    <input type=" text" placeholder="..جستجو">
                    <button><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="header-logo col-2 col-lg-3">
                <div class="logo-container">
                    <a href=""><img src="/layout/img/logoflip.png" alt=""></a>
                </div>
            </div>
        </div>
        <div class="header-category col-lg-12 clearfix">
            <ul>
                <li class="col-lg-2"><i class="fa fa-chevron-down"></i>مردانه</li>
                <li class="col-lg-2"><i class="fa fa-chevron-down"></i> زنانه</li>
                <li class="col-lg-2"><i class="fa fa-chevron-down"></i>کیف</li>
                <li class="col-lg-2"><i class="fa fa-chevron-down"></i>کفش</li>
                <li class="col-lg-2"><i class="fa fa-chevron-down"></i>جین</li>
                <li class="col-lg-2"><i class="fa fa-chevron-down"></i>کت و شلوار</li>
                <li class="col-lg-2"><i class="fa fa-chevron-down"></i>پیراهن</li>
                <li class="col-lg-2"><i class="fa fa-chevron-down"></i>وسایل جانبی</li>
            </ul>
        </div>
    </div>
    <article class="col-12 col-md-9 mx-md-auto col-lg-12 mt-3 mt-lg-5 clearfix account">
        @include('layouts.front.aside')
        @yield('content')
    </article>
    <div class="container-fluid">
        <section class="clearfix sign">
            <div class="col-12 col-md-6 col-lg-3 ">
                <p>:با ما در ارتباط باشید </p>
            </div>
            <div class="col-12 col-md-6 col-lg-6 ">
                <form action="" style="direction: ltr;">
                    <input type="text" placeholder="ایمیل خود را وارد کنید">
                    <button><a href="">به ما بپیوندید</a></button>
                </form>
            </div>
            <div class="col-12 col-md-12 col-lg-3 ">
                <ul>
                    <li><a href=""><span class="fab fa-facebook"></span><i class="fab fa-facebook"></i></a></li>
                    <li><a href=""><span class="fab fa-twitter"></span><i class="fab fa-twitter"></i></a></li>
                    <li><a href=""><span class="fab fa-instagram"></span><i class="fab fa-instagram"></i></a></li>
                    <li><a href=""><span class="fab fa-linkedin-in"></span><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href=""><span class="fab fa-youtube-square"></span><i class="fab fa-youtube-square"></i></a>
                    </li>
                </ul>
            </div>
        </section>
        <footer class="clearfix">
            <div class="col-12 col-md-6 col-lg-3">
                <ul>
                    <li class="footer-header">دسته بندی</li>
                    <li><a href="">زنان</a></li>
                    <li><a href="">مردان</a></li>
                    <li><a href="">لوازم جانبی</a></li>
                    <li><a href="">کفش</a></li>
                    <li><a href="">تازه ها</a></li>
                    <li><a href="">ترخیصی</a></li>
                    <li><a href="">بالا تنه</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <ul>
                    <li class="footer-header">با ما بخرید</li>
                    <li><a href="">درباره ما</a></li>
                    <li><a href="">سرویس ها</a></li>
                    <li><a href="">ارتباط با ما</a></li>
                    <li><a href="">قوانین</a></li>
                    <li><a href="">امنیت</a></li>
                    <li><a href="">امنیت</a></li>
                    <li><a href="">شرایط</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <ul>
                    <li class="footer-header">ارتباطات</li>
                    <li><a href=""><span>ادرس:</span>جمهوری انقلاب کوجخ پلاک واحد زنگ</a></li>
                    <li><a href=""><span>تلفن:</span>12345678</a></li>
                    <li><a href=""><span>ساعت:</span>تمام هفته صبح تا شب</a></li>
                    <li><a href="">info@gmail.com<span>:ایمیل</span></a></li>

                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3 ">
                <ul>
                    <li class="footer-header">عضویت</li>
                    <li><a href="">عضو سایت ما شوید و اولین کسسی باشید که از فروش های ویژه ما با خبر می شود</a></li>

                </ul>
            </div>


        </footer>
        <div id="accordion">
            <div class="card">
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href="#collapseOne">
                        <div class="col-10 float-right">دسته بندی</div>
                        <div class="col-2 float-right"><i class="fa fa-plus"></i></div>
                    </a>
                </div>
                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <ul>
                            <li><a href="">زنان</a></li>
                            <li><a href="">مردان</a></li>
                            <li><a href="">لوازم جانبی</a></li>
                            <li><a href="">کفش</a></li>
                            <li><a href="">تازه ها</a></li>
                            <li><a href="">ترخیصی</a></li>
                            <li><a href="">بالا تنه</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                        <div class="col-10 float-right">با ما بخرید</div>
                        <div class="col-2 float-right"><i class="fa fa-plus"></i></div>
                    </a>
                </div>
                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <ul>
                            <li><a href="">درباره ما</a></li>
                            <li><a href="">سرویس ها</a></li>
                            <li><a href="">ارتباط با ما</a></li>
                            <li><a href="">قوانین</a></li>
                            <li><a href="">امنیت</a></li>
                            <li><a href="">امنیت</a></li>
                            <li><a href="">شرایط</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                        <div class="col-10 float-right"> ارتباطات</div>
                        <div class="col-2 float-right"><i class="fa fa-plus"></i></div>
                    </a>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <ul>
                            <li><a href=""><span>ادرس:</span>جمهوری انقلاب کوجه پلاک واحد زنگ</a></li>
                            <li><a href=""><span>تلفن:</span>12345678</a></li>
                            <li><a href=""><span>ساعت:</span>تمام هفته صبح تا شب</a></li>
                            <li><a href="">info@gmail.com<span>:ایمیل</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <section class="designer ">
            <div class="col-11 px-0">
                <p>طراحی سایت توسط : گروه مهندسی پارمونت</p>
            </div>
            <div class="col-1 px-0">
                <button class="col-12">
                    <a href="#home"><i class="fa fa-chevron-circle-up"></i></a>
                </button>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript" src="/layout/slick/slick-1.8.1/slick-1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
    setTimeout(function () {
        $(document).ready(function () {
            $('.autoplay').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
            });
            $('.autoplayMobile').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
            });
        });
    }, 500);

</script>
<script>
    function sticky() {
        var objDesk = document.getElementsByClassName("sticky-container")[0];
        var objMob = document.getElementsByClassName("menus")[0];
        if (screen.width >= 992) {

            if (window.pageYOffset > 100) {
                objDesk.style.top = "0";
            }
            else {
                objDesk.style.top = "-75px";
            }
        }
        else {
            if (window.pageYOffset > 70) {
                objMob.classList.add("stickyMob");
            }
            else {
                objMob.classList.remove("stickyMob");
            }
        }

    }

    function sideMenu() {
        var objSide = document.getElementsByClassName("side-menu")[0];
        objSide.style.position = "fixed";
        objSide.style.left = "0";
    }

    function sideMenuClose() {
        var objSide = document.getElementsByClassName("side-menu")[0];
        objSide.style.position = "fixed";
        objSide.style.left = "-100vw";
    }
</script>

@yield('script')
</body>
</html>
