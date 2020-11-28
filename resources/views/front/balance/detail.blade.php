@extends('layouts.front.balance')
@section('content')

    <section class="mt-4" id="area" style="text-align: right;background-color: #eceff3;">
        <div class="container" style="background-color: white;padding: 27px 40px;border: 1px solid rgb(221, 221, 221)">
            <div class="row">
                <div class="col-md-6 pl-5">
                    <ul class="mb-3">
                        <a href="{{url('/')}}" style="padding: 0 6px;color: #a2a2a2">خانه</a>
                        <template v-for="(category, index) in categories">
                            <i class="fa fa-chevron-left" style="color: #a2a2a2;font-size: 13px"></i>
                            <a @click.stop="redirectFilter(category)"
                               style="padding: 0 6px;color: #a2a2a2;cursor: pointer">@{{ category }}</a>
                        </template>
                    </ul>
                    <br>
                    <div class="product product--layout--standard" data-layout="standard" style="border: unset">
                        <div class="product__content">
                            <div class="product__gallery">
                                <div class="product-gallery">
                                    <div class="product-gallery__featured">
                                        <div class="owl-carousel" id="product-image">
                                            <template v-for="(gallery, index) in galleries">
                                                <a :href="'/images/gallery/'+gallery.image" target="_blank">
                                                    <img :src="'/images/gallery/'+gallery.image">
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="product-gallery__carousel">
                                        <div class="owl-carousel" id="product-carousel">
                                            <template v-for="(gallery, index) in galleries">
                                                <a href="" class="product-gallery__carousel-item">
                                                    <img class="product-gallery__carousel-image"
                                                         :src="'/images/gallery/'+gallery.image">
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pr_detail">
                        <div class="product-description">
                            <div class="product-title mb-3">
                                <span id="dis" style="background-color: #25659a;">%@{{ discount }}</span>
                                <h4 class="mb-3">
                                    <a href="#" class="mb-3">
                                        @{{ name }}
                                    </a>
                                </h4>
                                <span style="font-weight: bold">برند :    @{{ brand }}</span>
                            </div>
                            <div class="product_price">
                                <span>قیمت : </span>
                                <span class="price mb-2 ml-4"
                                      style="display: inline">@{{ calculateDiscount() }} تومان</span>
                                <span style="text-decoration: line-through">@{{ numberFormat(price) }} تومان </span>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="detail-attr my-4">
                                <h4>ویژگی های محصول</h4>
                                {{--<ul class="mr-4 mt-3">--}}
                                {{--<li v-for="(spec, index) in specs" style="margin-bottom: 5px">--}}
                                {{--<span class="detail-attr-style"></span>--}}
                                {{--<span style="display: inline-block;">@{{ spec.key }}</span>--}}
                                {{--<span style="display: inline-block;font-weight: bold" class="detail-attr-value"> :  @{{ spec.value }} </span>--}}
                                {{--</li>--}}
                                {{--</ul>--}}

                                <div class="mt-3" v-html="product.short_desc"></div>

                            </div>
                        </div>
                        <hr v-if="effectPrice.length">

                        <label v-if="effectPrice.length" style="font-weight: bold">@{{ effectPrice }} :</label>
                        <br>
                        <div class="mr-3">
                            <template v-for="(item, index2) in effectSpecs">
                                <div style="display: inline-block" :id="'eff'+item.id">
                                    <label :class="{'radio-border': border}"
                                           :id="'ex'+index2"
                                           class="form-check-label ml-5 uuu oop2 mt-3"
                                           @click="setBorder('ex'+index2)" style="position: relative;"
                                           :for="'ex'+index2">
                                        @{{ item.name }}
                                        <input type="radio" name="eff"
                                               @change="onChangeEffect($event,effectPrice,item.name,item.id)"
                                               style="position: absolute;left: 0;top: 0;width: 100%;height: 100%;opacity: 0"
                                               :id="item.id" :value="item.id">
                                    </label>
                                </div>
                            </template>
                        </div>


                        <hr v-if="colors.length">
                        <span v-if="colors.length" style="font-weight: bold">انتخاب رنگ :</span>
                        <div class="example ex1" style="margin-top: 10px;margin-right:0">
                            <template v-for="color in colors">
                                <label class="radio red ml-4 mt-3 oop" style="background-color: unset;"
                                       :id="'color_label'+color.id">
                                    <a class="ml-2" style="display: inline-block;color: black">@{{ color.name }}</a>
                                    <input type="radio" name="group1"
                                           :value="color.price" :id="'color'+color.id"
                                           @change="onChangeColor($event,color.id)"/>
                                    <span :style="{backgroundColor: color.code}"
                                          style=" width: 45px;height: 27px;display: inline-block;vertical-align: bottom;">
                                        </span>
                                </label>
                            </template>
                        </div>

                        <hr>
                        <div class="cart_extra">
                            <div class="cart_btn mr-3">
                                <button class="btn btn-default btn-radius btn-sm btn-addtocart" v-if="!notifyMe"
                                        @click="formSubmit"
                                        type="button">افزودن به
                                    سبد خرید
                                </button>
                                <button class="btn btn-default btn-radius btn-sm btn-addtocart" v-if="notifyMe"
                                        type="button">
                                    در صورت موجود شدن به من خبر بده
                                </button>
                                @auth
                                    <a class="add_wishlist mr-3" style="background-color: #ff4343;color: white"
                                       @click.prevent="fav(product.id)">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="medium_divider clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-style1">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description"
                                   role="tab" aria-controls="Description" aria-selected="true">شرح</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info"
                                   role="tab" aria-controls="Additional-info" aria-selected="false">اطلاعات محصول</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab"
                                   aria-controls="Reviews" aria-selected="false">نظرات</a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab">
                            <div class="tab-pane fade show active" id="Description" role="tabpanel"
                                 aria-labelledby="Description-tab">
                                <p v-html="product.description"></p>
                            </div>
                            <div class="tab-pane fade" id="Additional-info" role="tabpanel"
                                 aria-labelledby="Additional-info-tab">
                                <div v-for="catspec in catspecs"
                                     v-if="checkExistCatspec(catspec.specifications)"
                                     style="direction: rtl;margin-bottom:40px">
                                    <i class="fa fa-caret-left" style="color: #2879fe"></i>
                                    <span
                                        style="color: #0c5460;font-weight: bold;font-size:18px">@{{ catspec.name }}</span>
                                    <div class="form-inline" v-for="specification in catspec.specifications"
                                         v-if="checkExistSpec(specification.name)" style="direction: rtl;">
                                        <div class="col-md-12 form-group" style="margin: 20px 0px 5px;">
                                            <label class="col-md-3 col-form-label" for="name">@{{
                                                specification.name}}
                                                :</label>
                                            <input type="text" class="form-control col-md-9 gg" readonly
                                                   :value="getValue(specification.name)"
                                                   :name="specification.name" :id="specification.id"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                @auth
                                    <div class="detail-tab-rate clearfix">
                                        <div class="detail-tab-rate-opinion-input" style="margin-bottom: 10px">
                                            <label>دیدگاه خود را وارد کنید </label>
                                            <textarea placeholder="متن " style="width: 100%;padding:10px" rows="6"
                                                      v-model="body"></textarea>
                                        </div>
                                        {{--<div class="g-recaptcha" data-sitekey="6LcWYLYUAAAAAAoIQW_7nzBcTf1coeKKICdtoJ8c"--}}
                                        {{--style="float: right;margin-bottom: 15px;margin-right: 10px"></div>--}}
                                        <button class="btn btn-success" @click="storeComment"
                                                style="float: left;margin-bottom: 20px;margin-left: 37px;width: 140px;">
                                            ارسال
                                        </button>
                                    </div>
                                @else
                                    <div class="alert alert-info mb-4 bt-2" role="alert">
                                        جهت ارسال دیدگاه ابتدا باید وارد شوید .
                                        <a href="{{ route('login') }}" class="ml-2 mr-5"
                                           style="color: rgb(255, 255, 255);font-size: 16px;background-color: #84c9ff;padding: 0px 15px;border-radius: 20px;">ورود</a>
                                    </div>
                                @endauth
                                <div class="detail-tab-reviews clearfix"
                                     style="border-right: 2px dashed #e0e0e0;padding-right:25px;">
                                    <template v-for="(parent_comment, key, index) in parent_comments">
                                        <div class="detail-tab-review-img">
                                            <img :src="'/images/user/profile/'+parent_comment.user.image">
                                            <span style="vertical-align: bottom;margin-right: 8px;">@{{ parent_comment.user.name }}</span>
                                            <br>
                                            <span
                                                style="color: #a5a5a5;font-size: 15px;">@{{ parent_comment.shamsi_c }}</span>
                                            <span style="color: #a5a5a5;font-size: 15px;">
                                                (@{{ getHour(parent_comment.created_at) }})
                                            </span>
                                        </div>
                                        <div class="detail-tab-review-txt my-3" style="padding-right: 30px;">
                                            @{{ parent_comment.body }}
                                            @auth
                                                <a @click="replyComment(key)"
                                                   style="float: left;margin-bottom: 20px;margin-left: 37px;cursor: pointer;color: #38c172;"><i
                                                        class="fa fa-arrow-right" style="vertical-align: sub;"></i>
                                                    پاسخ
                                                </a>
                                            @endauth
                                        </div>

                                        <template v-for="(reply, key, index) in parent_comment.replies">
                                            <div class="detail-tab-review-txt answer"
                                                 style="background-color: rgba(222, 222, 222, 0.2);padding: 15px;margin-top: 10px;margin-bottom: 10px;border-radius: 10px;display: grid;border: 2px dashed #e0e0e0;margin-right: 15px;display: block">

                                                <div class="detail-tab-review-img">
                                                    <img :src="'/images/user/profile/'+parent_comment.user.image">
                                                    <span style="vertical-align: bottom;margin-right: 8px;">
                                                        @{{ reply.user.name }}
                                                    </span><br>
                                                    <span
                                                        style="color: #a5a5a5;font-size: 15px;">@{{ reply.shamsi_c }}</span>
                                                    <span style="color: #a5a5a5;font-size: 15px;">
                                                        @{{ getHour(reply.created_at) }}
                                                    </span>
                                                    <span>@{{reply.body}}</span>
                                                    <div class="detail-tab-review-txt my-3"
                                                         style="padding-right: 30px;">
                                                        @{{reply.body}}
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <div :id="'ali'+key" style="display: none" class="hasan">

                                    <textarea placeholder="پاسخ خود را به این دیدگاه وارد کنید... "
                                              style="width: 100%;padding:10px;direction: rtl;"
                                              rows="5"
                                              v-model="reply"></textarea>
                                            <br>
                                            <button class="btn btn-success btn-sm"
                                                    @click="storeReplyComment(parent_comment.id)"
                                                    style="float: left;margin-bottom: 20px;margin-left: 37px;">ارسال
                                            </button>
                                        </div>
                                        <br>
                                        <br>
                                    </template>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="medium_divider clearfix"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mt-4 mb-3 pb-2 mx-3" style="border-bottom: 1px solid #dbdbdb">
                <div class="col-12 pr-3">
                    <i class="fas fa-star" style="color: rgb(204, 185, 0)"></i>
                    <span style="color: #25659a;padding: 2px;width: 100%;font-size: 19px;">محصولات مرتبط  </span>
                </div>
            </div>
            <div class="row">
                <div class="small_divider clearfix"></div>
                <div class="product_slider carousel_slide5 owl-carousel owl-theme nav_top_right2 px-4"
                     data-margin="0"
                     data-nav="true" data-dots="false">
                    <template v-for="(product,index) in related">
                        <div class="item">
                            <div class="product"
                                 style="height: 400px;position: relative;border-radius: 0;padding: 15px">
                                {{--<span class="pr_flash bg_green">فروش</span>--}}
                                <div class="product_img">
                                    <a href="#" @click.prevent="detail(product.slug)">
                                        <img style="width: 100%;height:100%"
                                             :src="'/images/product/'+product.image" :alt="product.name">
                                    </a>
                                    <div class="product_action_box">
                                        <ul class="list_none pr_action_btn">
                                            @auth
                                                <li @click.prevent="fav(product.id)">
                                                    <a href="#" style="background-color: #e3342f">
                                                        <i class="fas fa-heart"></i>
                                                    </a>
                                                </li>
                                            @endauth
                                            <li @click.prevent="detail(product.slug)">
                                                <a href="#"> <i class="fas fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="product_info mb-4">
                                    <h6><a href="#" class="pro_name"
                                           @click.prevent="detail(product.slug)"
                                        >@{{ product.name }}</a></h6>
                                    <div style="position: absolute;bottom:15px;width: 100%;left: 0;padding: 0 15px;">
                                            <span class="price">@{{ calculateDiscount(product.price,product.discount) }}
                                            <span style="font-size:11px">تومان</span>
                                            </span>
                                        <span id="price">@{{ numberFormat(product.price) }}
                                            <span style="font-size:11px">تومان</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        var app = new Vue({
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
                effectCondition: 0
            },
            methods: {
                fetchProduct(slug) {
                    let data = this;
                    parts = window.location.href.split('/');
                    slug = parts.pop() || parts.pop();
                    axios.get(`/fetch/product/${slug}`).then(res => {
                        data.product = res.data;
                        data.name = data.product.name;
                        data.brand = data.product.brand;
                        data.price = parseInt(data.product.price);
                        data.discount = data.product.discount;
                        data.base_price = parseInt(data.product.price);
                    });
                    this.fetchGallery(slug);
                },
                fetchGallery(slug) {
                    let data = this;
                    axios.get(`/fetch/product/galleries/${slug}`).then(res => {
                        data.galleries = res.data;
                    });
                },
                fetchRelated(slug) {
                    let data = this;
                    axios.get(`/related/product/${slug}`).then(res => {
                        data.related = res.data;
                    });
                },
                async fetchColor(slug) {
                    let _this = this;
                    await axios.get(`/fetch/color/${window.slug}`).then(res => {
                        _this.colors = res.data;
                    });


                    if (typeof this.effectPrice.length == 'undefined' && this.colors.length == 0) {

                        axios.post(`/check/product/exist/nothing/set/${window.slug}`)
                            .then(function (response) {
                                if (response.data === false) {
                                    _this.notifyMe = true;
                                } else {
                                    _this.notifyMe = false;
                                }
                            });
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
                    parts = window.location.href.split('/');
                    slug = parts.pop() || parts.pop();
                    let data = this;
                    axios.get(`/fetch/effect/price/${slug}`).then(res => {
                        data.another = res.data;
                    });
                },
                checkColor(effect) {
                    $('.oop').removeClass('have');
                    $('.oop').addClass('have2');

                    let _this = this;
                    let formData = new FormData();
                    formData.append('effect', effect);

                    axios.post(`/check/color/exist/${window.slug}`, formData)
                        .then(function (response) {
                            response.data.forEach(element =>
                                $('#color_label' + element['color_id']).addClass('have')
                            );
                        }).catch(function (error) {
                    });
                },
                checkEffect(color) {
                    $('.oop2').removeClass('has');
                    $('.oop2').addClass('has2');

                    parts = window.location.href.split('/');
                    slug = parts.pop() || parts.pop();

                    let _this = this;
                    let formData = new FormData();
                    formData.append('color', color);

                    axios.post(`/check/effect/exist/${slug}`, formData)
                        .then(function (response) {
                            response.data.forEach(element =>
                                $('#eff' + element['effect_spec_id'] + ' > label').addClass('has')
                            );
                        }).catch(function (error) {
                    });
                },
                onChangeEffect(event, key, effect, id) {
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
                onChangeColor(event, color) {
                    this.price = this.price - this.holder;
                    this.holder = parseInt(event.target.value);
                    this.price = this.price + parseInt(event.target.value);
                    this.color_id = color;

                    if (this.effectPrice !== '') {
                        this.checkEffect(color);
                    }

                    this.isExistProduct();
                    this.fetchColorGalleries(color);
                },
                isExistProduct() {
                    let _this = this;

                    if (this.colors.length == 0) {
                        if (document.querySelector('input[name="eff"]:checked') != null) {
                            let formData = new FormData();
                            formData.append('effect', document.querySelector('input[name="eff"]:checked').id);

                            axios.post(`/check/product/exist/color/not/set/${window.slug}`, formData)
                                .then(function (response) {
                                    if (response.data === false) {
                                        _this.notifyMe = true;
                                    } else {
                                        _this.notifyMe = false;
                                    }
                                }).catch(function (error) {
                            });
                        }

                    } else if (typeof this.effectPrice.length == 'undefined') {
                        if (document.querySelector('input[name="group1"]:checked') != null) {
                            let formData = new FormData();
                            formData.append('color', document.querySelector('input[name="group1"]:checked').id);

                            axios.post(`/check/product/exist/effect/not/set/${window.slug}`, formData)
                                .then(function (response) {
                                    if (response.data === false) {
                                        _this.notifyMe = true;
                                    } else {
                                        _this.notifyMe = false;
                                    }
                                }).catch(function (error) {
                            });
                        }
                    } else {
                        if (document.querySelector('input[name="eff"]:checked') != null
                            && document.querySelector('input[name="group1"]:checked') != null) {
                            let formData = new FormData();
                            formData.append('effect', document.querySelector('input[name="eff"]:checked').id);
                            formData.append('color', document.querySelector('input[name="group1"]:checked').id);
                            axios.post(`/check/product/exist/${window.slug}`, formData)
                                .then(function (response) {
                                    if (response.data === false) {
                                        _this.notifyMe = true;
                                    } else {
                                        _this.notifyMe = false;
                                    }
                                }).catch(function (error) {
                            });
                        }
                    }

                },
                fetchColorGalleries(color) {
                    parts = window.location.href.split('/');
                    slug = parts.pop() || parts.pop();
                    let data = this;
                    axios.get(`/fetch/color/galleries/${slug}/${color}`).then(res => {
                        if (res.data.length) {
                            data.galleries = res.data;
                        }
                    });
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
                    let data = this;
                    axios.get(`/fetch/product/category/${slug}`).then(res => {
                        data.categories = res.data;
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
                parts = window.location.href.split('/');
                window.slug = parts.pop() || parts.pop();
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
    <script src="/detail-gallery/vendor/nouislider-12.1.0/nouislider.min.js"></script>
    <script src="/detail-gallery/vendor/lightgallery-1.6.12/js/lightgallery.min.js"></script>
    <script src="/detail-gallery/vendor/lightgallery-1.6.12/js/lg-thumbnail.min.js"></script>
    <script src="/detail-gallery/vendor/lightgallery-1.6.12/js/lg-zoom.min.js"></script>
    <script src="/detail-gallery/js/main.js"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="/detail-gallery/vendor/lightgallery-1.6.12/css/lightgallery.min.css">
    <link rel="stylesheet" href="/detail-gallery/css/custom.css">
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
            float: left;
            font-size: 15px;
            background-color: #07d765;
            color: white;
            padding: 8px;
            border-radius: 30px;
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
            margin-right: 20px;
            display: inline-block;
            cursor: pointer;
        }

        .ex1 span {
            display: block;
            padding: 5px 10px 5px 25px;
            border: 2px solid #535353;
            border-radius: 5px;
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
            border: 2px solid #686868;
        }

        .ex1 .red input:checked + span:before {
            background-color: #0aa0d7;

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

        body {
            background-color: #eceff3;
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
            border: 2px dashed #4d4d4d;
            padding: 2px 8px;
        }
    </style>
@endsection

