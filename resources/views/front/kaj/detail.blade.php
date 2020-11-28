@extends('layouts.front.kaj')
@section('content')
    <div id="area" class="mt-5 rtl" style="text-align: right">
        <div v-if="loader"
             style="width: 100%;height:250vh;background-color: white;opacity: 0.6;position: absolute;top: 0;z-index: 99999999999"></div>
        <div class="breadcrumb-area mt-37 hm-4-padding">
            <div class="container-fluid">
                <div class=" text-right pr-lg-5">
                    <div class="mt-3">
                        <a href="{{url('/')}}" style="padding: 0 6px;color: #4f4f4f">خانه</a>
                        <template v-for="category in categories">
                            <i class="fa fa-chevron-left"
                               style="color: #4f4f4f;font-size: 13px;vertical-align: middle;"></i>
                            <a @click.stop="redirectFilter(category)"
                               style="padding: 0 6px;color: #4f4f4f;cursor: pointer;display: inline-block">@{{ category
                                }}</a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-details-area hm-3-padding py-5">
            <div class="container-fluid col-11 col-md-9 mx-auto col-lg-12">
                <div class="row">
                    <div class="col-lg-6 px-0">
                        <div class="product product--layout--standard" data-layout="standard" style="border: unset">
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <template v-for="gallery in galleries">
                                        <div class="swiper-slide">
                                            <img class="w-100" :src="'/images/gallery/'+gallery.image">
                                        </div>
                                    </template>
                                </div>
                                <div class="swiper-button-next "></div>
                                <div class="swiper-button-prev "></div>
                            </div>
                            <div class="swiper-container gallery-thumbs mt-3">
                                <div class="swiper-wrapper">
                                    <template v-for="gallery in galleries">
                                        <div class="swiper-slide mx-1">
                                            <img style="border-radius: 5px" class="w-100"
                                                 :src="'/images/gallery/'+gallery.image">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6 d-flex flex-row flex-wrap">
                        <div class="product-details-content col-12">
                            <span v-if="checkHaveDiscount()" id="dis">%@{{ discount }}</span>
                            <h1 style="color: #123b66;font-size: 2.1rem;">@{{ name }}</h1>
                            <div class="product-price">
                                <span v-if="checkHaveDiscount()" class="old">@{{ numberFormat(price) }} تومان</span>
                                <span>@{{ calculateDiscount() }} تومان</span>
                            </div>
                            <div class="product-overview">
                                <h5 class="pd-sub-title">بررسی اجمالی محصولات</h5>
                                <p v-html="product.short_desc"></p>
                            </div>
                            <hr v-if="effectPrice.length" class="my-3">

                            <label v-if="effectPrice.length" style="font-weight: bold">@{{ effectPrice }} :</label>
                            <br>
                            <div class="mr-3">
                                <template v-for="(item, index2) in effectSpecs">
                                    <div style="display: inline-block" :id="'eff'+item.id">
                                        <label :class="{'radio-border': border}"
                                               :id="'ex'+index2"
                                               class="form-check-label ml-5 uuu oop2 mt-3"
                                               @click="setBorder('ex'+index2)"
                                               style="position: relative"
                                               :for="'ex'+index2">
                                            @{{ item.name }}
                                            <input type="radio" name="eff"
                                                   @change="onChangeEffect($event,effectPrice,item.name,item.id)"
                                                   style="position: absolute;left: 0;top: 0;width: 100%;height: 100%;opacity:0;cursor: pointer"
                                                   :id="item.id" :value="item.id">
                                        </label>
                                    </div>
                                </template>
                            </div>
                            <hr v-if="colors.length" class="my-3">
                            <div class="product_variant color">
                                <label v-if="colors.length">انتخاب رنگ :</label>
                                <div class="example ex1"
                                     style="margin-top: 10px;margin-right: 0px;height: 164px;overflow: scroll;overflow-x: hidden;">
                                    <template v-for="color in colors">
                                        <label class="radio red mt-3 oop"
                                               style="background-color: unset;padding:2px 10px;"
                                               :id="'color_label'+color.id">
                                            <a class="ml-2" style="display: inline-block;color: #646464;font-size:14px">
                                                @{{color.name }}
                                            </a>
                                            <input type="radio" name="group1"
                                                   :value="color.price" :id="'color'+color.id"
                                                   @change="onChangeColor($event,color.id)"/>
                                            <span :style="{backgroundColor: color.code}"
                                                  style=" width: 37px;height: 27px;display: inline-block;vertical-align: bottom;"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>

                            <div class="quickview-plus-minus mt-5 mt-md-0">
                                <div class="quickview-btn-cart">
                                    <a style="cursor: pointer" class="btn-style cr-btn" v-if="!notifyMe"
                                       @click="formSubmit"><span>افزودن به سبد خرید</span></a>
                                    <a class="btn-style cr-btn" v-if="notifyMe">
                                        <span>در صورت موجود شدن به من اطلاع بده</span>
                                    </a>
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
    <script src="/elevateZoom-3.0.8.min.js"></script>
    <script>
        new Vue({
            el: '#area',
            data: {
                isActive: true,
                holder: 0,
                name: '',
                brand: '',
                price: 0,
                discount: '',
                product: [],
                galleries: [],
                effects: [],
                effect_prices: [],
                another: [],
                colors: [],
                color: 0,
                base_price: 0,
                values: {},
                total: 0,
                color_id: 0,
                effect_id: null,
                cal_discount: 0,
                specs: [],
                categories: [],
                catspecs: [],
                values2: [],
                body: '',
                parent_comments: [],
                reply: '',
                flag: true,
                related: [],
                border: false,
                notifyMe: false,
                effectPrice: '',
                effectSpecs: [],
                effectCondition: 0,
                auth: {!! (Auth::check()) ?  1 : 0 !!},
                loader: false,
            },
            methods: {
                checkHaveDiscount() {
                    if (this.discount == 0) {
                        return false;
                    } else {
                        return true;
                    }
                },
                fetchProduct(slug) {
                    let data = this;
                    axios.get(`/fetch/product/${window.slug}`).then(res => {
                        data.product = res.data;
                        data.name = data.product.name;
                        data.brand = data.product.brand;
                        data.price = parseInt(data.product.price);
                        data.discount = data.product.discount;
                        data.base_price = parseInt(data.product.price);
                    });
                    this.fetchGallery(slug);
                },
                lastLoop(index) {
                    if (index === this.categories.length - 1) {
                        return 'red';
                    }
                },
                async fetchGallery(slug) {
                    let data = this;
                    await axios.get(`/fetch/product/galleries/${slug}`).then(res => {
                        data.galleries = res.data;
                    });
                    var galleryThumbs = new Swiper('.gallery-thumbs', {
                        spaceBetween: 10,
                        slidesPerView: 4,
                        freeMode: true,
                        watchSlidesVisibility: true,
                        watchSlidesProgress: true,
                    });
                    var galleryTop = new Swiper('.gallery-top', {
                        spaceBetween: 10,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        thumbs: {
                            swiper: galleryThumbs
                        }
                    });
                },
                fetchRelated(slug) {
                    let data = this;
                    axios.get(`/related/product/${slug}`).then(res => {
                        data.related = res.data;
                    });
                },
                async fetchColor() {
                    let _this = this;
                    await axios.get(`/fetch/color/{{$slug}}`).then(res => {
                        _this.colors = res.data;
                    })
                    @if($color !=0)
                        this.onChangeColor2({{$price}}, '{{$color}}')
                        $("#color{{$color}}").attr('checked', 'checked')
                    @endif
                    if (typeof this.effectPrice.length == 'undefined' && this.colors.length == 0) {

                        axios.post(`/check/product/exist/nothing/set/{{$slug}}`)
                            .then(function (response) {
                                if (response.data === false) {
                                    _this.notifyMe = true;
                                } else {
                                    _this.notifyMe = false;
                                }
                            })
                    }
                },
                async fetchEffectPrice() {
                    let _this = this;
                    await axios.get(`/fetch/effect/price/${window.slug}`).then(res => {
                        _this.effectPrice = res.data;
                    });
                },
                async fetchEffectSpec() {
                    let _this = this;
                    await axios.get(`/fetch/effect/spec/${window.slug}`).then(res => {
                        _this.effectSpecs = res.data;
                    });
                },
                calculateDiscount() {
                    onePercent = this.price / 100;
                    difference = 100 - this.discount;
                    total = difference * onePercent;
                    this.cal_discount = Math.round(total);
                    return this.cal_discount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                fetchEffectAnother() {
                    let data = this;
                    axios.get(`/fetch/effect/price/${window.slug}`).then(res => {
                        data.another = res.data;
                    });
                },
                async checkColor(effect) {
                    $('.oop').removeClass('have');
                    $('.oop').addClass('have2');

                    let _this = this;
                    let formData = new FormData();
                    formData.append('effect', effect);

                    await axios.post(`/check/color/exist/${window.slug}`, formData)
                        .then(function (response) {
                            console.log(response.data);
                            response.data.forEach(element =>
                                $('#color_label' + element['color_id']).addClass('have')
                            );
                        }).catch(function (error) {
                        });
                },
                async checkEffect(color) {
                    $('.oop2').removeClass('has');
                    $('.oop2').addClass('has2');

                    parts = window.location.href.split('/');
                    slug = parts.pop() || parts.pop();

                    let _this = this;
                    let formData = new FormData();
                    formData.append('color', color);

                    await axios.post(`/check/effect/exist/${slug}`, formData)
                        .then(function (response) {
                            response.data.forEach(element =>
                                $('#eff' + element['effect_spec_id'] + ' > label').addClass('has')
                            );
                        }).catch(function (error) {
                        });
                },
                async onChangeEffect(event, key, effect, id) {
                    this.loader = true;

                    result = this.effectSpecs.filter(effectSpec => effectSpec.id == event.target.value);

                    this.effectCondition = 1;
                    this.total = 0 + this.holder;
                    this.price = parseInt(this.base_price);
                    this.price = this.price + parseInt(this.color);
                    this.effect_prices[key] = parseInt(result[0].effect_values[0].value);


                    for (let key2 in this.effect_prices) {
                        this.total = this.total + parseInt(this.effect_prices[key2]);
                    }
                    this.price = parseInt(this.price) + parseInt(this.total);
                    this.another[key] = id;

                    if (this.colors.length != 0) {
                        this.checkColor(effect, key);
                    }
                    this.isExistProduct();
                },
                async isExistProduct() {
                    console.log(this.colors)
                    let _this = this;
                    if (this.colors.length == 0) {

                        if (document.querySelector('input[name="eff"]:checked') != null) {

                            let formData = new FormData()
                            formData.append('effect', document.querySelector('input[name="eff"]:checked').id)

                            await axios.post(`/check/product/exist/color/not/set/{{$slug}}`, formData)
                                .then(function (response) {
                                    if (response.data === false) {
                                        _this.notifyMe = true
                                    } else {
                                        _this.notifyMe = false
                                    }
                                }).catch(function (error) {
                                });
                        }

                    } else if (typeof this.effectPrice.length == 'undefined') {
                        if (document.querySelector('input[name="group1"]:checked') != null) {
                            let formData = new FormData()
                            formData.append('color', document.querySelector('input[name="group1"]:checked').id);

                            await axios.post(`/check/product/exist/effect/not/set/{{$slug}}`, formData)
                                .then(function (response) {
                                    if (response.data === false) {
                                        _this.notifyMe = true;
                                    } else {
                                        _this.notifyMe = false;
                                    }
                                })
                        }
                    } else {

                        if (document.querySelector('input[name="eff"]:checked') != null
                            && document.querySelector('input[name="group1"]:checked') != null) {
                            console.log(4444444)
                            let formData = new FormData()
                            formData.append('effect', document.querySelector('input[name="eff"]:checked').id)
                            formData.append('color', document.querySelector('input[name="group1"]:checked').id)
                            await axios.post(`/check/product/exist/{{$slug}}`, formData)
                                .then(function (response) {
                                    if (response.data === false) {
                                        _this.notifyMe = true
                                    } else {
                                        _this.notifyMe = false
                                    }
                                })
                        }
                    }
                    this.loader = false
                },
                onChangeColor(event, color) {
                    this.loader = true
                    this.price = this.price - this.holder;
                    this.holder = parseInt(event.target.value);
                    this.price = this.price + parseInt(event.target.value);
                    this.color_id = color;

                    if (this.effectPrice !== '') {
                        this.checkEffect(color);
                    }

                    this.isExistProduct()
                    this.fetchColorGalleries(color)
                },
                async onChangeColor2(price, color) {
                    this.loader = true
                    this.price = this.price - this.holder;
                    this.holder = parseInt(price);
                    this.price = this.price + parseInt(price);
                    this.color_id = color;

                    if (this.effectPrice !== '') {
                        await this.checkEffect(color);
                    }

                    await this.isExistProduct()
                    await this.fetchColorGalleries(color)
                },
                fetchColorGalleries(color) {
                    let data = this
                    axios.get(`/fetch/color/galleries/{{$slug}}/${color}`).then(res => {
                        if (res.data.length) {
                            data.galleries = res.data
                        }
                    })
                },
                numberFormat(price) {
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                fetchSpec(slug) {
                    let data = this;
                    axios.get(`/fetch/product/spec/${slug}`).then(res => {
                        data.specs = res.data;
                    });
                },
                fetchCat(slug) {
                    let _this = this;
                    axios.get(`/fetch/product/category/${slug}`).then(res => {
                        _this.categories = res.data;
                    });
                },
                fetchCatspec(slug) {
                    let data = this;
                    axios.get(`/fetch/product/catspec/${slug}`).then(res => {
                        data.catspecs = res.data.catspecs;
                    });
                },
                getValue(key) {
                    result = this.values2.filter(value => value.key === key);
                    return result[0].value;
                },
                checkExistSpec(key) {
                    result = this.values2.filter(value => value.key === key);
                    if (result[0].value.length) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkExistCatspec(obj) {
                    for (let [key, Value] of Object.entries(obj)) {
                        result = this.values2.filter(value => value.key === Value.name);
                        if (result[0].value.length) {
                            return true;
                        }
                    }
                },
                getValues(slug) {
                    data = this;
                    axios.get(`/product/fetch/value/${slug}`).then(res => {
                        data.values2 = res.data;
                    });
                },
                storeComment(e) {
                    e.preventDefault();
                    data = this;
                    axios.post('/comment/store', {
                        body: this.body,
                        id: this.product.id,
                    }).then(function (response) {
                        swal.fire(
                            {
                                text: "دیدگاه شما با موفقیت ثبت شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        $('.hasan').css("display", "none");
                        data.body = '';
                        data.fetchParentComment(slug);

                    }).catch(function (error) {

                    });
                },
                storeReplyComment(id) {
                    parts = window.location.href.split('/');
                    slug = parts.pop() || parts.pop();
                    data = this;
                    axios.post('/comment/reply/store', {
                        parent: id,
                        reply: this.reply,
                        slug: slug,
                    }).then(function (response) {
                        swal.fire(
                            {
                                text: "پاسخ شما با موفقیت ثبت شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        $('.hasan').css("display", "none");
                        data.body = '';
                        data.reply = '';
                        data.fetchParentComment(slug);

                    }).catch(function (error) {
                    });
                },
                fetchParentComment(slug) {
                    let data = this;
                    axios.get(`/fetch/parent/comment/${slug}`).then(res => {
                        data.parent_comments = res.data;
                    });
                },
                getHour(date) {
                    arr = date.split(" ");
                    return arr[1];
                },
                replyComment(id) {
                    $('.hasan').css("display", "none");
                    x = '#ali' + id;
                    $(x).css("display", "block");
                },
                fav(id) {
                    if (!this.auth) {
                        window.location.href = '/login';
                    }
                    let _this = this;
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
                redirectFilter(cat) {
                    window.location.href = `/search/${cat}`;
                },
                detail(slug) {
                    window.location.href = `/detail/${slug}`;
                },
                setBorder(e) {
                    id = "#" + e;
                    $('.uuu').removeClass('radio-border');
                    $(id).addClass('radio-border');
                    notice = document.querySelector('input[name="eff"]:checked').value;

                },
                formSubmit(e) {
                    e.preventDefault();
                    data = this;
                    if (typeof this.effectPrice.length !== 'undefined') {
                        if (this.effectCondition === 0) {
                            swal.fire(
                                {
                                    text: `${this.effectPrice} را انتخاب کنید `,
                                    type: "info",
                                    confirmButtonText: 'باشه',
                                }
                            );
                            return false;
                        } else {
                            effects = document.querySelector('input[name="eff"]:checked').value;
                        }
                    } else {
                        effects = 'effect not set';
                    }

                    if (this.colors.length != 0) {
                        if (this.color_id == 0) {
                            data.flag = false;
                            swal.fire(
                                {
                                    text: `رنگ محصول خود را انتخاب کنید`,
                                    type: "info",
                                    confirmButtonText: 'باشه',
                                }
                            );
                        }
                    }
                    console.log(effects);
                    if (data.flag == true) {
                        axios.post('/cart/store', {
                            effects: effects,
                            color: this.color_id,
                            product: data.name,
                            price: this.price,
                            cal_discount: this.cal_discount,
                        }).then(function (response) {
                            window.location.href = `/cart`;
                        }).catch(function (error) {
                        });

                    }
                    data.flag = true;
                },
            },
            mounted: function () {
                window.slug = '{{$slug}}'
                this.fetchProduct(window.slug);
                this.fetchRelated(window.slug);
                this.fetchEffectPrice();
                this.fetchColor();
                this.fetchEffectAnother();
                this.fetchSpec(window.slug);
                this.fetchCat(window.slug);
                this.fetchCatspec(window.slug);
                this.getValues(window.slug);
                this.fetchParentComment(window.slug);
                this.fetchEffectSpec(window.slug);
            },
        })
    </script>
    <script>
        setTimeout(function () {
            jQuery("#image-zoom").unbind();
            jQuery("#image-zoom").on("click", function (e) {
                var ez = jQuery('#image-zoom').data('elevateZoom');
                jQuery.fancybox(ez.getGalleryList());
            });
            if (screen.width > 768) {
                $("#image-zoom").elevateZoom({
                    gallery: 'gallery',
                    cursor: "crosshair",
                    easing: true,
                    galleryActiveClass: 'active',
                    imageCrossfade: false,
                    loadingIcon: 'https://www.elevateweb.co.uk/spinner.gif',
                    zoomWindowPosition: 11,
                    zoomWindowFadeIn: true,
                    scrollZoom: true,
                    zoomWindowOffety: 40,
                    borderColour: "#ddd",

                });
                $("#image-zoom").bind("click", function (e) {
                    e.preventDefault();
                    var ez = $('#image-zoom').data('elevateZoom');
                    $.fancybox(ez.getGalleryList());
                    return false;
                });
            } else {
                $(".owl-item").find("img").click(function () {
                    // console.log($(this).attr("src"))
                    $("#image-zoom").attr("src", $(this).attr("src"))
                })

            }


            //pass the images to Fancybox


        }, 3000);
    </script>
@endsection

@section('style')

    {{--    <link rel="stylesheet" href="{{asset('/dress/online/assets/css/plugins.css')}}">--}}
    {{--    <link rel="stylesheet" href="{{asset('/dress/online/assets/css/style.css')}}">--}}
    <style>
        input {
            background: white
        }

        .bread-crumb {
            color: black !important;
        }

        .red {
            color: #c40316 !important;
        }

        .short-desc ul {
            list-style: unset;
        }
    </style>
    <style>

        .have2 {
            border: unset;
            opacity: .2;
            padding: 3px 5px;
        }

        .have {
            opacity: 1;
            padding: 3px 5px;
        }

        .has {
            opacity: 1 !important;
            color: black !important;
            font-weight: bold !important;
        }

        .has2 {
            color: #b5b5b5;

        }

        #Reviews img {
            width: 70px;
            border-radius: 60px;
        }

        body {
            background-color: white
        }

        #dis {
            font-size: 15px;
            background-color: #3490dc;
            color: white;
            padding: 8px 10px;
            border-radius: 30px;
            float: left;
        }
    </style>
    <style>
        .example {
            margin: 20px;
        }

        .example input {
            display: none;
        }

        .example label {
            /*margin-right: 20px;*/
            display: inline-block;
            cursor: pointer;
        }

        .ex1 span {
            display: block;
            padding: 10px 15px 10px 25px;
            border: 1px solid #c5c5c5;
            border-radius: 10px;
            position: relative;
            transition: all 0.25s linear;
        }

        .ex1 span:before {
            content: '';
            position: absolute;
            left: 5px;
            top: 50%;
            -webkit-transform: translatey(-50%);
            transform: translatey(-50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ffffff;
            transition: all 0.25s linear;
            border: 1px solid #c5c5c5;
        }

        .ex1 .red input:checked + span:before {
            background-color: #7c94ff;

        }

        .answer {
            position: relative;
        }

        .answer:after {
            position: absolute;
            top: 50%;
            right: -40px;
            height: 2px;
            width: 40px;
            content: "";
            background-color: #e0e0e0;
        }

        #Description p {
            line-height: 35px
        }

        textarea {
            border-color: #e0e0e0;
        }

        .product:hover {
            box-shadow: unset !important;
        }
    </style>
    <style>
        .product-gallery__featured {
            box-shadow: inset 0 0 0 2px #f2f2f2;
            padding: 2px;
            border-radius: 2px
        }

        .product-gallery__featured a {
            display: block;
            padding: 20px
        }

        .product-gallery__carousel {
            margin-top: 16px
        }

        .product-gallery__carousel-item {
            cursor: pointer;
            display: block;
            box-shadow: inset 0 0 0 2px #f2f2f2;
            padding: 12px;
            border-radius: 2px
        }

        .product-gallery__carousel-item--active {
            box-shadow: inset 0 0 0 2px #ffd333
        }

        .product-tabs {
            margin-top: 50px
        }

        .product-tabs__list {
            display: -ms-flexbox;
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: -2px
        }

        .product-tabs__list:after,
        .product-tabs__list:before {
            content: "";
            display: block;
            width: 8px;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .product-tabs__item {
            font-size: 20px;
            padding: 18px 48px;
            border-bottom: 2px solid transparent;
            color: inherit;
            font-weight: 500;
            border-radius: 3px 3px 0 0;
            transition: all .15s
        }

        .product-tabs__item:hover {
            color: inherit;
            background: #f7f7f7;
            border-bottom-color: #d9d9d9
        }

        .product-tabs__item:first-child {
            margin-right: auto
        }

        .product-tabs__item:last-child {
            margin-left: auto
        }

        .product-tabs__item--active {
            transition-duration: 0s
        }

        .product-tabs__item--active,
        .product-tabs__item--active:hover {
            cursor: default;
            border-bottom-color: #ffd333;
            background: transparent
        }

        .product-tabs__content {
            border: 2px solid #f0f0f0;
            border-radius: 2px;
            padding: 80px 90px
        }

        .product-tabs__pane {
            overflow: hidden;
            height: 0;
            opacity: 0;
            transition: opacity .5s
        }

        .product-tabs__pane--active {
            overflow: visible;
            height: auto;
            opacity: 1
        }

        .product-tabs--layout--sidebar .product-tabs__item {
            padding: 14px 30px
        }

        .product-tabs--layout--sidebar .product-tabs__content {
            padding: 48px 50px
        }

        .radio-border {
            border: 2px dashed #3f3f3f;
            padding: 2px 10px;
            border-radius: 5px;
            color: #3f3f3f;
            font-weight: bold;
        }

    </style>

    <style>

        #gallery {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        #gallery img {
            width: 100%;
        }

        /*product info table*/
        .tab-content {
            background-color: #f9fafb;
        }

        .detail-info-table-title {
            background-color: #f0f4f8;
            color: #061923;
            padding: 10px 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .detail-info-table-txt {
            background-color: #f0f4f8;
            color: #4f4f4f;
            font-size: 14px;
            padding: 10px 5px;
        }

        .nav-tabs .nav-link {
            color: #6f7478;
            border-radius: 15px 15px 0 0 !important;

        }

        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            background-color: #f9fafb !important;
            color: #061923 !important;
            border-bottom-color: #f4f7f9 !important;
            border-radius: 15px 15px 0 0 !important;
        }

        .detail-info-title {
            color: #061923;
            font-size: 18px;
            font-weight: bold;
        }

        .detail-info-txt {
            color: #6f7478;
            font-size: 14px;
            line-height: 25px;
        }

        /*Product detail Slider*/
        .owl-carousel .owl-nav button.owl-next, .owl-carousel .owl-nav button.owl-prev, .owl-carousel button.owl-dot {
            outline: none !important;
        }

        .detail-slider img {
            width: 100%;
        }

        /*detail-img-carousel*/
        .owl-carousel .owl-nav div {
            position: absolute;
            background: #f2f2f2;
            border-radius: 3px;
            height: 32px;
            top: 50%;
            transform: translatey(-50%);
            width: 32px;
            text-align: center;
            line-height: 29px;
            right: -7px;
            font-size: 18px;
            -webkit-transition: 0.3s;
            transition: 0.3s;

        }

        .owl-carousel .owl-nav div.owl-next {
            left: -7px;
            right: auto;
        }

        .owl-nav {
            display: block !important;
        }

        .owl-carousel .owl-dot, .owl-carousel .owl-nav .owl-next, .owl-carousel .owl-nav .owl-prev {
            padding-top: 3px;
        }
    </style>
@endsection

