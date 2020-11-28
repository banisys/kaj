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
    <link rel="stylesheet" href="/plugins/font-awesome/css/fontawesome-free-5.6.1-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="/layout/slick/slick-1.8.1/slick-1.8.1/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/layout/slick/slick-1.8.1/slick-1.8.1/slick/slick-theme.css">
    <link rel="shortcut icon" type="image/x-icon" href="/layout_balance/images/favicon.png">
    <link rel="stylesheet" href="/layout_balance/css/animate.css">
    <script src="{{ asset('/js/app.js')}}"></script>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/layout_balance/css/ionicons.min.css">
    <link rel="stylesheet" href="/layout_balance/css/all.min.css">
    <link rel="stylesheet" href="/layout_balance/css/themify-icons.css">
    <link rel="stylesheet" href="/layout_balance/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/layout_balance/owlcarousel/css/owl.theme.css">
    <link rel="stylesheet" href="/layout_balance/owlcarousel/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/layout_balance/css/magnific-popup.css">
    <link rel="stylesheet" href="/layout_balance/css/jquery-ui.css">
    <link rel="stylesheet" href="/layout_balance/css/style.css">
    <link rel="stylesheet" href="/layout_balance/css/responsive.css">
    <link rel="stylesheet" id="layoutstyle" href="/layout_balance/color/theme-default.css">
    
     <link rel="stylesheet" href="/dress/assets/css/style.css">
    @yield('style')
</head>

<body onscroll="sticky()" id="home">
<style>
    #wave1 {
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        height: 50px;
        width: 50px;
        margin: -25px 0 0 -25px;
        border-radius: 50%;
    }

    #wave1:before, #wave1:after {
        content: '';
        border: 2px solid #008744;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        position: absolute;
        left: 0px;
    }

    #wave1:before {
        -webkit-transform: scale(1, 1);
        -ms-transform: scale(1, 1);
        transform: scale(1, 1);
        opacity: 1;
        -webkit-animation: spWaveBe 0.6s infinite linear;
        animation: spWaveBe 0.6s infinite linear;
    }

    #wave1:after {
        -webkit-transform: scale(0, 0);
        -ms-transform: scale(0, 0);
        transform: scale(0, 0);
        opacity: 0;
        -webkit-animation: spWaveAf 0.6s infinite linear;
        animation: spWaveAf 0.6s infinite linear;
    }

    @-webkit-keyframes spWaveAf {
        from {
            -webkit-transform: scale(0.5, 0.5);
            transform: scale(0.5, 0.5);
            opacity: 0;
        }
        to {
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
    }

    @keyframes spWaveAf {
        from {
            -webkit-transform: scale(0.5, 0.5);
            transform: scale(0.5, 0.5);
            -webkit-transform: scale(0.5, 0.5);
            transform: scale(0.5, 0.5);
            opacity: 0;
        }
        to {
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
    }

    @-webkit-keyframes spWaveBe {
        from {
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        to {
            -webkit-transform: scale(1.5, 1.5);
            transform: scale(1.5, 1.5);
            opacity: 0;
        }
    }

    @keyframes spWaveBe {
        from {
            -webkit-transform: scale(1, 1);
            transform: scale(1, 1);
            opacity: 1;
        }
        to {
            -webkit-transform: scale(1.5, 1.5);
            transform: scale(1.5, 1.5);
            opacity: 0;
        }
    }
</style>
{{--<div id="overlayer"--}}
{{--style="position:absolute;top: 0;left: 0;background-color: white;width: 100%;height: 100vh;z-index: 10000"--}}
{{--v-if="loader">--}}
{{--<div id="wave1"></div>--}}
{{--</div>--}}
<style>
    #header .nav.nav-tabs {
        display: block;
        border-bottom: 0;
        border-right: 1px solid #ddd;
    }

    #header .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
    }

    #header .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: 0rem !important;
        border-top-right-radius: 0rem !important;
    }

    #header .nav.nav-tabs {
        display: block;
        border-bottom: 0;
        border-right: 1px solid transparent;
    }

    #header .tab-content {
        text-align: right;
    }

    #header #megaContainer {
        position: absolute;
        top: 60px;
        left: 27px;
        width: 100%;
        z-index: 999;
        padding: 12px 10px;
    }

</style>



@yield('content')

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
            // this.fetchCart();
            this.fetchMegaCats();
            this.fetchMegas();
        }
    });
</script>
<script>
    $(document).ready(function () {
        $("#overlayer").delay(1000).fadeOut("slow");
    });
</script>
@yield('script')
</body>
</html>
