@extends('layouts.front.kaj')

@section('content')
    <div id="area" class="my-5 pt-5" style="direction: rtl">
        <div class="shop_area shop_reverse pb-0">
            <div
                style="opacity:.9;position:absolute;top: 0;left: 0;background-color: white;width: 100%;height: 100vh;z-index: 10000"
                v-if="loader">
                <div id="wave1"></div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-12">

                        <aside class="sidebar_widget">
                            <div class="sidebar">
                                <div class="widget" style="text-align: right">
                                    <span style="color: #c40316;font-weight: bold;font-size: 15px">دسته های برند @{{name}}</span>
                                    <hr class="my-3">
                                    <div class="filter-dropdown" style="padding:5px 15px;background-color: white">
                                        <ul class="filter-checkboxes">
                                            <li v-for="brand in cats" class="categor-li" style="margin-bottom:6px">
                                                <input class="checked" type="checkbox"
                                                       :value="brand.name"
                                                       :id="replaceUnder(brand.name)"
                                                       @change="changeCat(brand.name)">
                                                <label class="pr-4" :for="replaceUnder(brand.name)">
                                                    <div class="col-12 float-right" style="padding: 0 7px;">
                                                        <span style="margin-right: 20px">@{{ brand.name }}</span>
                                                        <span style="float: left;color: grey">@{{ brand.name_f }}</span>
                                                    </div>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </aside>

                    </div>

                    <div class="col-lg-9 col-md-12">
                        <div class="row mb-2 px-4">
                            <div class="col-md-9">

                            </div>
                            <div class="col-md-3">
                                <span style="float: left"> @{{ products.total }} کالا</span>
                            </div>

                        </div>
                        <hr class="my-0">
                        <div class="row no-gutters shop_wrappe mt-5">
                            <template v-for="(product,index) in products.data">
                                <div class="product-items ">
                                    <div class="pro-img">
                                        <a :href=`/detail/${product.slug}`>
                                            <img class="w-100" :src="'/images/product/'+product.image"
                                                 :alt="product.name">
                                        </a>
                                    </div>
                                    <div class="pro-info text-right bg-white py-3">
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
                                            <div class="old-price rtl pr-3"
                                                 v-if="checkHaveDiscount(product['discount'])">
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

                        <div class="row mt-5">
                            <div class="col-12" style="text-align: center">
                                <div @click="goUp()" style="display: inline-block">
                                    <pagination :limit="2" :data="products"
                                                @pagination-change-page="fetchProducts"></pagination>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                holder: '',
                products: [],
                cal_discount: '',
                cats: [],
                name: [],
                filter_cats: [],
                flag: false,
                filters: [],
                brands: [],
                catChosen: [],
                loader: false,
                brandImage: '',
            },
            methods: {
                fetchProducts(page = 1) {
                    this.loader = true;
                    let data = this;
                    axios.get(`/fetch/brand/products/${this.name}?page=` + page).then(res => {
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
                    axios.get(`/fetch/brand/cat/${this.name}`).then(function (res) {
                        _this.cats = res.data.cats;
                        _this.brandImage = res.data.image;
                    });
                },
                redirectFilter(cat) {
                    window.location.href = `/search/${cat}`;
                },
                fetchFilter() {
                    let data = this;
                    axios.get(`/filter/fetch/${this.name}`).then(function (res) {
                        data.filter_cats = res.data;
                    });
                },
                changeFilter(key, value) {
                    item = key + ':' + value;
                    id = item.split(":");
                    last = id[id.length - 1];

                    $(`#aaa${last}`).removeClass('without-after-element');


                    if ($(`#${value}`).prop('checked')) {
                        this.filters.push(key + ':' + value);
                    } else {
                        index = this.filters.indexOf(key + ':' + value);
                        this.filters.splice(index, 1);
                    }
                    this.searchProducts();
                },
                searchProducts() {
                    parts = window.location.href.split('/');
                    brand = parts.pop() || parts.pop();
                    let data = this;
                    axios.post('/filter/search/cat/brand', {
                        cat: this.catChosen,
                        brand: brand,
                    }).then(res => {
                        data.products = res.data;
                    });
                },
                changeCat(name) {
                    str = name.replace(/\s+/g, '_');

                    if ($(`#${str}`).prop('checked')) {
                        this.catChosen.push(str);
                    } else {
                        index = this.catChosen.indexOf(str);
                        this.catChosen.splice(index, 1);
                    }
                    this.searchProducts();
                },
                removeFilter(item) {
                    index = this.filters.indexOf(item);
                    this.filters.splice(index, 1);
                    id = item.split(":");
                    last = id[id.length - 1];
                    $(`#aaa${last}`).addClass('without-after-element');
                    $(`#${last}`).prop('checked', false);
                    this.searchProducts();
                },
                replaceUnder(id) {
                    str = id.replace(/\s+/g, '_');
                    return str;
                },
                goUp() {
                    $("html, body").animate({scrollTop: 0}, "slow");
                },
                ggg() {
                    this.loader = false;
                },
                replaceUnder(id) {
                    str = id.replace(/\s+/g, '_');
                    return str;
                },
                detail(slug) {
                    window.location.href = `/detail/${slug}`;
                },
                checkHaveDiscount(discount) {
                    if (discount == 0) {
                        return false;
                    } else {
                        return true;
                    }
                },
            },
            mounted: function () {
                parts = window.location.href.split('/');
                name = parts.pop() || parts.pop();
                this.name = name;
                this.fetchProducts();
                this.fetchCats();
                this.fetchFilter();
            }
        })
    </script>

@endsection

@section('style')
    <style>
        .page-link {
            border-radius: 60px !important;
            margin-left: 5px !important;
            color: #f3a395 !important
        }

        .pagination .active .page-link {
            background: #f3a395 !important;
            border-color: #ddd !important;
            color: white !important;
        }

        input {
            background: white
        }

        #categories {
            cursor: pointer;
            user-select: none
        }

        #categories > li {
            position: relative;
        }


        #categories > li ul > li {
            position: relative;
        }

        #area {
            text-align: right
        }

        #price {
            text-decoration-line: line-through;
            display: inline-block;
            float: left;
            font-size: 14px;
            margin-right: 12px;
        }

        .price {
            display: inline-block;
            float: right;
        }

        .pro_name {
            line-height: 28px;
        }

        .nav-link {
            padding: 5px 10px !important;
        }

        .dropdown-menu-right, .dropdown-menu {
            text-align: right
        }
    </style>
    <style>
        .filter {
            border: 1px solid #ddd;
            background-color: white;
            /*height: 100vh;*/
            transition: 0.3s;
            /*position:sticky !important;*/
            /*position: -webkit-sticky ;*/
            /*top:100px !important;*/

        }

        .filter-mobile {
            position: absolute;
            border: 1px solid #ddd;
            top: 0;
            left: -100vw;
            height: 100vh;
            z-index: 1000;
            transition: 0.3s;
            overflow-y: scroll;
            background-color: #f8f8f8;
        }

        #drop5, #drop6, #drop7, #drop8 {
            background-color: white;
        }

        .filter-mobile ul li {
            border: 1px solid #ddd;
            text-align: right;
            list-style: none;
            padding: 10px 5px 5px 5px !important;
            margin: 10px;
            position: relative;
            height: 40px;
            transition: 0.4s;
            font-size: 14px;
            color: #4A4A4A;
            overflow: hidden;
            cursor: pointer;
        }

        .filter-mobile ul li i {
            float: left;
            padding-top: 5px;
            color: #2D2D2D !important;
        }

        .filter-mobile ul li p {
            margin: 0 !important;
        }

        .filter-mobile-open {
            position: fixed !important;
            top: 0;
            left: 0;
        }

        .filter-mobile-close {
            width: 100%;
            height: 50px;
            background-color: #2978ef;
            color: white;
        }

        .filter-mobile-close div {
            width: 50%;
            height: 100%;
            float: right;
        }

        .filter-mobile-close div button {
            margin: 0 20%;
            padding-top: 15px;
            width: 50%;
            background-color: transparent;
            color: white;
            font-size: 14px;
            border: none;
        }

        .filter-ul-li {
            border: 1px solid #ddd;
            text-align: right;
            list-style: none;
            padding: 10px 5px 5px 5px !important;
            margin: 10px 0;
            position: relative;
            transition: 0.4s;
            font-size: 14px;
            color: #4A4A4A;
            cursor: pointer;
            overflow: hidden;
        }

        .search-filter-side-icon {
            float: right !important;
            font-size: 10px;
            padding-left: 5px;
            color: #aaa;
        }

        .filter-togglecheck input {
            width: 50px;
            height: 15px;
            display: none;
            position: absolute;
            top: 50%;
            right: 0;

        }

        .filter-togglecheck input:checked ~ label {
            background-color: #2978ef;
        }

        .filter-togglecheck input:checked ~ label:after {
            right: 50%;
            border-color: #2978ef;

        }

        .filter-togglecheck label {
            border-radius: 10px;
            width: 100%;
            height: 20px;
            border: 1px solid #bbb;
            background-color: #eee;
            margin-top: 3px;
            margin-bottom: 0;
            position: relative;
            cursor: pointer;
        }

        .filter-togglecheck label:after {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 0;
            border-radius: 50%;
            border: 1px solid #bbb;
            background-color: white;
            width: 40%;
            height: 85%;
            content: '';
            cursor: pointer;
            transition: 0.3s;
        }

        .filter-togglecheck .col-9 {
            cursor: normal;
        }

        .filter-ul-li ul li {
            list-style: none;

        }

        .filter::-webkit-scrollbar {
            width: 5px;
            border-radius: 10px;

        }

        .filter-dropdown::-webkit-scrollbar {
            width: 7px;
            display: none;
            border: 1px solid #eee;
            border-radius: 15px;
        }

        #drop1 .filter-dropdown:hover::-webkit-scrollbar {
            display: block !important;
        }

        #drop2 .filter-dropdown:hover::-webkit-scrollbar {
            display: block !important;
        }

        #drop5 .filter-dropdown::-webkit-scrollbar {
            display: block !important;
        }

        #drop6 .filter-dropdown::-webkit-scrollbar {
            display: block !important;
        }

        ::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 30px;

        }

        .filter ul li i {
            float: left;
            padding-top: 5px;
            color: #2D2D2D !important;
        }

        .filter ul li p {
            margin: 0 !important;
        }

        .filter-dropdown {
            overflow-y: scroll;
            overflow-x: hidden;
            margin-top: 7px;
            padding: 0 15px;
            /*height: 0;*/
        }

        .filter-dropdown ul li input {
            float: right;
            padding-left: 5px !important;
            background: transparent !important;
            width: 30px;
            height: 30px;
            position: absolute;
            top: 0;
            right: 10px;
            opacity: 0;
        }

        .filter-checkboxes li:hover {
            background-color: #f8f8f8;
            transition: 0.2s;
            border-radius: 15px;
        }

        .filter-checkboxes li {
            background-color: white;
            color: #272727;
            position: relative;
            transition: 0.1s;
        }

        .filter-checkboxes li label {
            width: 100%;
            overflow: hidden;
            position: relative;
            text-align: right;
            cursor: pointer;
            margin: 0 !important;
        }

        .filter-dropdown ul li input:checked ~ label:after {
            background-color: #2978ef;
            border-radius: 15px;
        }

        .filter-checkboxes li label:after {
            position: absolute;
            top: 0;
            right: 0;
            width: 20px;
            height: 20px;
            border-radius: 5px;
            border: 2px solid #ddd;
            content: '';
            background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 2px 3px;
            transition: border-radius 0.8s;

        }

        .filter-dropdown ul li input:checked ~ label {
            color: #2978ef;
            font-weight: 900;
        }

        .filter-color {
            border-radius: 50%;
            height: 25px !important;
            cursor: pointer;
            padding: 20px !important;
            margin: 20px 5px !important;
            width: calc(20% - 10px);
        }

        .catagor-li > ul > li {
            position: relative;
        }

        .catagor-li > ul > li:after {
            position: absolute;
            content: "\f107";
            font-family: "Font Awesome 5 Free";
            font-style: normal;
            font-weight: 700;
            text-decoration: inherit;
            top: 0;
            right: -15px;
            color: #000;
            padding-left: 5px;
            font-size: 13px;
        }

        .color-container {
            width: 80%;
            height: 20px;
            margin: 0 auto !important;
        }

        .blue {
            background-color: rgba(0, 84, 152, 1.00);
        }

        .lightblue {
            background-color: rgba(26, 196, 188, 1.00);
        }

        .black {
            background-color: rgba(0, 0, 0, 1.00);
        }

        .gray {
            background-color: rgba(112, 112, 112, 1.00);
        }

        .brown {
            background-color: rgba(39, 32, 32, 1.00);
        }

        .filter-dropdown input[type=range] {
            width: 80%;
            margin: 15px 25px;
            padding: 0 !important;
            -webkit-appearance: none;
            border-radius: 8px;
            height: 11px;
            border: 1px solid #aaa;
            background-color: #fff;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 15px;
            height: 25px;
            border-radius: 30px;
            background-color: #008202;
        }

        .filter-dropdown input[type=text] {
            border: none;
            border-bottom: 2px solid green;
            color: green;
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        .filter-dropdown {
              background-color: white;
              width: 100%;
            /*  height:0;*/
            transition: 0.5s;
        }

        .filter-dropdown ul li {
              border: none;
        }

        .filter-dropdown ul li a {
              color: #8B8B8B;
        }

        .drop-toggle {
              height: 40vh !important;
        }

        .widget {
            font-size: 13px
        }
    </style>
    <style>
        #categories {
            padding: 10px 20px;
            height: 312px;
            overflow: hidden
        }

        .more {
            height: auto !important;
            overflow: visible !important;
        }
    </style>
@endsection

