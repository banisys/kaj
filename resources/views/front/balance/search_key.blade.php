@extends('layouts.front.kaj')

@section('content')
    <br>
    <div id="area" class="my-lg-5" style="direction: rtl">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <aside class="sidebar_widget">
                        <div class="sidebar" v-if="filters2.length">
                            <div class="widget" style="text-align: right">
                                <h5 class="widget_title" style="margin-bottom: unset">فیلتر ها</h5>
                                <div class="filter-dropdown" style="background-color: white">
                                    <ul class="filter-checkboxes mt-3">
                                        <li v-for="filter in filters2" class="categor-li"
                                            style="margin-bottom:6px;padding:5px 10px;border: 1px solid #d6d6d6;">
                                        <span style="font-size: 14px;color: #797979;">
                                           @{{ filter }}
                                        </span>
                                            <a style="float: left;font-size: 16px;color: #797979;cursor: pointer"
                                               @click="removeFilter(filter)">
                                                <i class="ion-ios-close-empty" style="color: rgb(220, 53, 69);"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar">
                            <div class="widget" style="text-align: right">
                                <ul>
                                    <li v-for="(filter_cat, index) in filter_cats" class="filter-ul-li">
                                        <div @click="clickTitle(filter_cat.id)">
                                            <i style="display: inline-block"
                                               :class="['fa','fa-plus' ,'col-2', 'filter-ul-li-div','hasan'+filter_cat.id]"></i>
                                            <i style="display: none"
                                               :class="['fa','fa-minus' ,'col-2', 'filter-ul-li-div','ali'+filter_cat.id]"></i>
                                            <span class="col-10"
                                                  style="user-select: none;">@{{ filter_cat.name }}</span>
                                        </div>

                                        <div class="filter-dropdown karan" :id="filter_cat.id"
                                             style="display:none;">
                                            <ul class="filter-checkboxes mt-3">
                                                <li v-for="filter in filter_cat.filters" class="categor-li">
                                                    <input class="checked" style="opacity: 0"
                                                           :value="'filter_name'+filter.id"
                                                           type="checkbox" :id="'filter_name'+filter.id"
                                                           @change="changeFilter(filter_cat.name,filter.id,filter.name)">

                                                    <label class="pr-4" :for="'filter_name'+filter.id"
                                                           :id="'aaa'+filter.id">
                                                        <div class="col-12 float-right">
                                                            <span style="color: grey;margin-right: 20px">@{{ filter.name }}</span>
                                                        </div>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar mt-4">
                            <div class="widget" style="text-align: right">

                                <div class="form-group">
                                    <button id="btn-cat" style="visibility: hidden">
                                        <template v-show="form.brands.length"> @{{ form.brands }}</template>
                                        <i class="right fa fa-angle-down" id="angle-down"></i>
                                    </button>
                                    <div id="sss">
                                        <input type="text" v-model="brandSearch" style="color: #2b2b2b"
                                               id="input-search"
                                               @keyup="searchBrand"
                                               placeholder="جستجو...">
                                        <ul v-show="flagBrand1">
                                            <li style="line-height: 35px;" @click="selectBrand(brand.name,brand.id)"
                                                v-for="(brand,index) in brands"
                                                :id="'brand-id'+brand.id">
                                                <span>@{{ brand.name }}</span>
                                                <span style="float: left">@{{ brand.name_f }}</span>
                                            </li>
                                            <li v-show="!brands.length">
                                                <span style="color: red">موردی یافت نشد</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </aside>
                </div>

                <div class="col-lg-9 col-md-12 pt-4 pt-lg-0">
                    <div class="row mb-2 px-4">
                        <div class="col-md-9">
                            <div class="breadcrumb_content">
                                <a href="{{ url('/') }}">خانه</a>
                                <template v-for="(category, index) in categories">
                                    <i class="fa fa-chevron-left mx-2" style="color: #c40316;font-size: 12px;display:inline-block"></i>
                                    <a @click.stop="redirectFilter(category)" style="cursor: pointer"
                                    >@{{ category }}</a>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <span class="float-right float-lg-left pt-4 pt-lg-0"> @{{ products.total }} کالا</span>
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
@endsection

@section('script')
    <script>
        Vue.component('item', {
            name: 'item',
            props: ['cat'],
            template: '<ul><li v-for="item in cat.children_recursive" @click.stop="redirectFilter(item.name)" style="margin-right: 15px;text-align: right;font-size:13px;color: #828282">@{{ item.name }}' +
            '<item :cat="item"></item></li></ul>',
            methods: {
                redirectFilter(cat) {
                    window.location.href = `/search/${cat}`;
                },
            }
        });

        new Vue({
            el: '#area',
            data: {
                holder: '',
                products: [],
                cal_discount: '',
                name: {!! $name !!},
                filter_cats: [],
                flag: false,
                filters: [],
                brands: [],
                brandsChosen: [],
                loader: false,
                search: '',
                filters2: [],
                filterConvert: '',
                categories: {},

                form: {
                    brands: [],
                },
                flagBrand: false,
                flagBrand1: true,
                holderBrandId: [],
                brandSearch: '',
            },
            computed: {
                filteredList() {
                    return this.brands.filter(brand => {
                        return brand.name.includes(this.search) || brand.name_f.includes(this.search);
                    });
                },
            },
            methods: {
                searchBrand() {
                    let _this = this;
                    if (this.brandSearch === '') {
                        this.fetchBrands();
                    } else {
                        axios.get(`/search/brand/${this.name}/${this.brandSearch}`).then(response => {
                            _this.brands = response.data;
                        });
                    }
                },
                redirectFilter(e, id) {
                    if (e.target.value == '') {
                        this.deleteCategory(id);
                    } else {
                        let formData = new FormData();
                        formData.append('name', e.target.value);
                        formData.append('id', id);

                        axios.post('/admin/category/edit', formData)
                            .then(function (response) {
                                location.reload();
                            });
                    }
                },
                selectBrand(name, id) {
                    existInHolder = false;
                    existBrand = false;

                    this.holderBrandId.forEach(function (item) {
                        if (item === id) {
                            existInHolder = true;
                        }
                    });

                    this.form.brands.forEach(function (item) {
                        if (item === name) {
                            existBrand = true;
                        }
                    });

                    if (existInHolder) {
                        for (var i = 0; i < this.holderBrandId.length; i++) {
                            if (this.holderBrandId[i] === id) {
                                this.holderBrandId.splice(i, 1);
                            }
                        }

                    } else {
                        this.holderBrandId.push(id);
                    }

                    if (existBrand) {
                        for (var i = 0; i < this.form.brands.length; i++) {
                            if (this.form.brands[i] === name) {
                                this.form.brands.splice(i, 1);
                            }
                        }
                    } else {
                        this.form.brands.push(name);
                    }
                    this.searchProducts();
                },
                clickBrandBtn() {
                    if (this.flagBrand === false) {
                        this.flagBrand = true;
                    } else if (this.flagBrand === true) {
                        this.flagBrand = false
                    }
                },

                lastLoop(index) {
                    if (index === this.categories.length - 1) {
                        return 'red';
                    }
                },
                fetchCat(slug) {
                    let _this = this;
                    axios.get(`/fetch/product/category2/${slug}`).then(res => {
                        _this.categories = res.data;
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
                fetchProducts(page = 1) {
                    this.loader = true;
                    let data = this;
                    axios.get(`/fetch/products/${this.name}?page=` + page).then(res => {
                        data.products = res.data;
                    });
                    setTimeout(this.ggg, 2000);
                },
                clickTitle(data) {
                    $(".karan").css({
                        "display": "none"
                    });
                    if (this.holder !== data) {
                        $(`#${data}`).css({
                            "display": "block"
                        });
                    }

                    $('.fa-minus').css({
                        "display": "none"
                    });

                    $(`.ali${data}`).css({
                        "display": "inline-block"
                    });

                    $('.fa-plus').css({
                        "display": "inline-block"
                    });

                    if (this.holder !== data) {
                        $(`.hasan${data}`).css({
                            "display": "none"
                        });
                    } else {
                        $(`.ali${data}`).css({
                            "display": "none"
                        });
                    }
                    if (this.holder !== data) {
                        this.holder = data;
                    } else {
                        this.holder = "";
                    }
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
                // redirectFilter(cat) {
                //     window.location.href = `/search/${cat}`;
                // },
                fetchFilter() {
                    let data = this;
                    axios.get(`/filter/fetch/${this.name}`).then(function (res) {
                        data.filter_cats = res.data;
                    });
                },
                changeFilter(key, value, filterName) {
                    $(`#aaa${value}`).removeClass('without-after-element');

                    if ($(`#filter_name${value}`).prop('checked')) {
                        this.filters.push(key + ':' + value);
                        this.filters2.push(key + ':' + filterName);
                    } else {
                        index = this.filters.indexOf(key + ':' + value);
                        index2 = this.filters2.indexOf(key + ':' + filterName);
                        this.filters.splice(index, 1);
                        this.filters2.splice(index2, 1);
                    }
                    this.searchProducts();
                },
                changeBrand(name) {
                    str = name.replace(/\s+/g, '_');
                    if ($(`#${str}`).prop('checked')) {
                        this.brandsChosen.push(str);
                        this.filters2.push('برند' + ':' + name);
                    } else {
                        index = this.brandsChosen.indexOf(name);
                        this.brandsChosen.splice(index, 1);
                        index2 = this.filters2.indexOf('برند' + ':' + name);
                        this.filters2.splice(index2, 1);
                    }
                    this.searchProducts();
                },
                searchProducts() {
                    let _this = this;
                    axios.post('/filter/search/products', {
                        brand_ids: this.holderBrandId,
                        cat: this.name
                    }).then(res => {
                        _this.products = res.data;
                    });
                },
                fetchBrands() {
                    let _this = this;
                    axios.get(`/fetch/brands/${this.name}`).then(res => {
                        _this.brands = res.data;
                    });
                },
                async removeFilter(item) {
                    a = this.filters2.indexOf(item);
                    this.filters2.splice(a, 1);

                    rrr = item.split(":");
                    if (rrr[0] === 'برند') {
                        index9 = this.brandsChosen.indexOf(rrr[1]);
                        this.brandsChosen.splice(index9, 1);
                        $(`#${rrr[1]}`).prop("checked", false);
                    } else {
                        let _this = this;
                        await axios.post('/filter/convert', {
                            filter: item,
                            cat: this.name
                        }).then(function (res) {
                            _this.filterConvert = res.data;
                        });
                        ff = _this.filterConvert.split(":");
                        $(`#filter_name${ff[1]}`).prop("checked", false);
                        index = this.filters.indexOf(_this.filterConvert);
                        this.filters.splice(index, 1);

                        index2 = this.filters2.indexOf(item);
                        this.filters2.splice(index2, 1);

                        id = _this.filterConvert.split(":");
                        last = id[id.length - 1];
                        $(`#aaa${last}`).addClass('without-after-element');
                        $(`#${last}`).prop('checked', false);
                    }
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
                window.slug = parts.pop() || parts.pop();
                this.fetchProducts();
                this.fetchFilter();
                // this.fetchBrand();
                this.fetchCat(window.slug);
                this.fetchBrands();
            },
            updated: function () {

                for (var i = 0; i < this.brands.length; i++) {
                    $(`#brand-id${this.brands[i].id}`).removeClass("brand-select");
                }
                console.log(this.holderBrandId);
                for (var j = 0; j < this.holderBrandId.length; j++) {

                    $(`#brand-id${this.holderBrandId[j]}`).addClass("brand-select");
                }
            }

        })
    </script>

@endsection

@section('style')
    <style>
        #input-search {
            display: block;
            border-bottom: 1px solid gray;
            border-left: unset;
            border-right: unset;
            border-top: unset;
            width: 100%;
            margin-bottom: 10px;
        }

        .brand-select {
            line-height: 35px;
            padding: 0px 10px;
            border-radius: 5px;
            background-color: #5f5f5f;
            color: #ffffff;
            margin-top: 2px;
            margin-bottom: 2px;
            transition: all 0.3s;
        }
    </style>
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

        .red {
            color: #c40316 !important;
        }

        .fade-enter-active, .fade-leave-active {
            transition: opacity .5s;
        }

        .fade-enter, .fade-leave-to {
            opacity: 0;
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

        #categories ul {
            border-right: 1px dashed #dcdcdc;
            padding-right: 8px;
            padding-top: 8px;
            padding-bottom: 8px;
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
            background-color: white;
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
            border-radius: 4px;
            border: 1px solid #c3c3c3;
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
    </style>
    <style>
        .without-after-element::after {
            background-color: unset !important;
            border-radius: 5px !important;
        }

        .widget {
            font-size: 13px;
        }
    </style>
@endsection

