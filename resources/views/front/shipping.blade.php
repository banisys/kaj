@extends('layouts.front.front')
@section('content')
    <div class="container" id="area">
        <section class="steps" style="padding: 0;height: 180px">
            <div class="step-line" style="transform: translateY(60px);">
                <div class="step-item"><a href="/cart">
                        <img src="/layout/img/shopping-bag.png">
                    </a>
                    <span>سبد خرید</span>
                </div>
                <div class="step-item"><a href="shipping.html"><img src="/layout/img/home.png" alt=""></a><span
                            id="second">اطلاعات ارسال</span>
                </div>
                <div class="step-item">
                    <a href="payment.html">
                        <img src="/layout/img/buy.png">
                    </a>
                    <span>اطلاعات پرداخت</span>
                </div>
                <span id="stepLoad"></span>
            </div>
        </section>

        <section class="col-12 clearfix shipping mb-5" style="padding: unset;background-color: white;">
            <div v-show="flag1">
                <div class="col-12 col-lg-3 float-lg-right px-0 shipping-header"
                     style="color: #2662a1;">مشخصات شخص گیرنده را وارد کنید
                </div>
                <br>
                <div class="col-12 px-0 mt-5">
                    <div class="shipping-form-items py-4 col-lg-6 float-lg-right" id="label1">
                        <input type="text" id="Name" class="col-10 mx-auto d-block pl-0 pr-4 bun" v-model="form.name">
                        <label for="Name">نام و نام خانوادگی</label>
                        <span><i class="fa fa-user"></i></span>
                        <p style="color: red;text-align:center"> @{{ error.name }} </p>
                    </div>

                    <div class="shipping-form-items py-4 col-lg-6 float-lg-right" id="label2">
                        <input type="text" id="Num" class="col-10 mx-auto d-block pl-0 pr-4 bun" v-model="form.cell">
                        <label for="Num">شماره همراه</label>
                        <span><i class="fa fa-mobile-alt"></i></span>
                        <p style="color: red;text-align:center"> @{{ error.cell }} </p>
                    </div>

                    <div class="shipping-form-items py-4  col-lg-6 float-lg-right" id="label3">
                        <input type="text" id="PostalCode" class="col-10 mx-auto d-block pl-0 pr-4 bun"
                               v-model="form.postal_code">
                        <label for="PostalCode">کد پستی</label>
                        <span><i class="fa fa-map-pin"></i></span>
                        <p style="color: red;text-align:center"> @{{ error.postal_code }} </p>
                    </div>

                    <div class="shipping-form-items py-4 col-lg-3 float-lg-right" id="label4">
                        <label for="town">استان</label>
                        <select class="form-control" id="town" v-model="form.state"
                                @change="selectState($event)">
                            <option value="0" disabled hidden>انتخاب استان...</option>
                            <option :value="state.id" v-for="(state,index) in states">
                                @{{ state.name }}
                            </option>
                        </select>

                        <p style="color: red;text-align:center"> @{{ error.state }} </p>
                    </div>

                    <div class="shipping-form-items py-4  col-lg-3 float-lg-right" id="label5">
                        <select class="form-control" id="town" v-model="form.city">
                            <option value="0" disabled hidden>انتخاب شهر...</option>
                            <option :value="city.id" v-for="(city,index) in citys">
                                @{{ city.name }}
                            </option>
                            <option v-if="!citys.length">استان را انتخاب کنید</option>
                        </select>
                        <label for="City" class="pr-1">شهر</label>
                        <p style="color: red;text-align:center"> @{{ error.city }} </p>
                    </div>

                    <div class="shipping-form-items py-5 col-lg-12 float-lg-right" id="label6">
                        <input type="text" id="Address" class="col-11 mx-auto d-block pl-0 pr-4 bun"
                               v-model="form.address">
                        <p style="color: red;text-align:center"> @{{ error.address }} </p>
                        <label for="Address" class="pr-1" style="right:8%">آدرس</label>
                        <span style="right: 5%;"><i class="fa fa-map-marked-alt"></i></span>
                    </div>

                    <div class="shipping-form-items mb-4 col-lg-6 float-lg-left mx-auto ">
                        <button class="col-lg-5 d-block px-0" @click="transit"
                                style="float: left;width: 130px;height: 40px;border-radius: 0">ادامه
                            <i class="fa fa-arrow-left "></i>
                        </button>

                    </div>
                </div>
            </div>
            <div v-show="flag2">
                <div class="col-12 clearfix">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 shipping-time-receipt pb-5">

                            <div class="col-12 shipping-time-divider pb-5"
                                 style="text-align: center;border-right: unset;">
                                <div class="col-12 clearfix mt-2">
                                    <h3 class="col-lg-12 float-right pb-3 mr-1"
                                        style="text-align: right;color: #ababab">فاکتور
                                        خرید</h3>
                                </div>
                                <div class="col-12 clearfix mt-2">
                                    <p class="col-6 float-right" style="text-align: right;color: red">جمع سفارش</p>
                                    <p class="col-6 float-right rtl"> @{{ numberFormat(sum_price) }} تومان</p>
                                </div>
                                <div class="col-12 clearfix shipping-time-receipt-discount">
                                    <p class="col-6 float-right" style="text-align: right;color: #0b94c8">جمع تخفیف
                                        ها </p>
                                    <p class="col-6 float-right rtl"> @{{ numberFormat(sum_price - sum_total) }}
                                        تومان</p>
                                </div>
                                <div class="col-12 clearfix shipping-time-receipt-divider pb-2">
                                    <p class="col-6 float-right" style="text-align: right;color: rgb(0, 146, 1)">هزینه
                                        ارسال
                                    </p>
                                    <p class="col-6 float-right rtl"> @{{ numberFormat(deliveryPrice) }} تومان</p>
                                </div>
                                <div class="col-12 clearfix pt-2 shipping-time-receipt-price">
                                    <p class="col-6 float-right" style="text-align: right">مبلغ قابل پرداخت </p>
                                    <p class="col-6 float-right rtl ">
                                        @{{ numberFormat((sum_price-(sum_price - sum_total))+deliveryPrice) }}
                                        تومان</p>
                                </div>
                            </div>


                            <div class="col-12 shipping-time-divider d-flex flex-row"
                                 style="text-align: center;border-right: unset;">
                                <div class="col-6" @click="bank('zarinpal')" :class="{'zarinpal': zarinpalFlag}"
                                     style="cursor: pointer">
                                    <img src="/images/zarinpal.svg" style="width: 100%">

                                </div>
                                <div class="col-6" @click="bank('sadad')" :class="{'sadad': sadadFlag}"
                                     style="cursor: pointer">
                                    <img src="/images/sadad.png" style="width: 85%">

                                </div>
                            </div>


                            <div class="col-12 shipping-time-receipt-button mb-lg-3 mt-5">
                                <button class="col-lg-5" @click="shippingShow"
                                        style="float: right;width: 130px;height: 40px;margin-right:20px;direction: ltr;border-radius: 0">
                                    مرحله قبل <i class="fa fa-arrow-right "></i>
                                </button>

                                <button class="col-lg-5" @click="formSubmitEpay"
                                        style="width: 130px;height: 40px;float: left;border-radius: 0">
                                    پرداخت
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>

            </div>
            <div v-show="flag3">
                <section class="col-12 px-0 payment-container clearfix" style="padding: unset">
                    <div class="row">
                        <section class="col-md-3"></section>
                        <section class="col-md-6 py-3 py-lg-0 float-right payment-gifts  clearfix"
                                 style="border: unset">
                            <div class="col-12  mt-5 payment-price">
                                <div class="clearfix">
                                    <p class="col-6 float-right px-0 text-right">مبلغ کل خرید</p>
                                    <p class="col-6 float-right px-0 text-left rtl">@{{ numberFormat(sum_price) }}
                                        تومان</p>
                                </div>
                                <div class="clearfix">
                                    <p class="col-8 float-right  px-0 text-right">هزینه ارسال</p>
                                    <p class="col-4 float-right px-0 text-left">@{{ numberFormat(deliveryPrice)
                                        }}تومان </p>
                                </div>
                                <div class="clearfix  payment-disc">
                                    <p class="col-6 float-right px-0 text-right">مجموع تخفیف ها</p>
                                    <p class="col-6 float-right  px-0 text-left rtl">@{{ numberFormat(sum_price -
                                        sum_total)
                                        }} تومان</p>
                                </div>
                                <div class="clearfix mt-3">
                                    <p class="col-6 float-right px-0 text-right">قابل پرداخت</p>
                                    <p class="col-6 float-right px-0 text-left rtl">@{{
                                        numberFormat(sum_final) }} تومان</p>

                                    {{--                                    <p class="col-6 float-right px-0 text-left rtl">@{{--}}
                                    {{--                                        numberFormat(sum_final + form.distance) }} تومان</p>--}}
                                </div>

                            </div>
                            <br>
                            <button class="col-lg-5" @click="deliveryShow"
                                    style="float: right;width: 130px;height: 40px;margin-right:20px;direction: ltr;background-color: #2662a1;color: white;border: unset;border-radius:0px;">
                                مرحله قبل <i class="fa fa-arrow-right "></i>
                            </button>
                            <button class="col-lg-5"
                                    style="float: left;width: 130px;height: 40px;margin-left:20px;direction: ltr;background-color: #2662a1;color: white;border: unset;border-radius:0px;"
                                    @click="formSubmitEpay">
                                پرداخت
                            </button>
                        </section>
                        <section class="col-md-3"></section>
                    </div>
                </section>

            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#area',
            data: {
                form: {
                    name: '',
                    postal_code: '',
                    city: '',
                    cell: '',
                    state: '',
                    address: '',
                    distance: '',
                    delivery_time: '',
                },
                error: {
                    name: '',
                    postal_code: '',
                    city: '',
                    cell: '',
                    state: '',
                    address: '',
                    distance: '',
                    delivery_time: '',
                    lat: '',
                },
                date: '',
                sum_total: 0,
                sum_price: 0,
                sum_final: 0,
                flag1: true,
                flag2: false,
                flag3: false,
                off: '',
                offShow: true,
                offMessage: false,
                carts: [],
                sum_total2: 0,
                sum_price2: 0,
                sum_discount2: 0,
                deliveryPrice: 12000,
                chosenBank: 'sadad',
                zarinpalFlag: false,
                sadadFlag: true,
                states: '',
                citys: '',
            },
            methods: {
                bank(bank) {
                    this.chosenBank = bank
                    if (bank === 'zarinpal') {
                        this.zarinpalFlag = true
                        this.sadadFlag = false
                    }
                    if (bank === 'sadad') {
                        this.zarinpalFlag = false
                        this.sadadFlag = true
                    }
                },
                async fetchCartNumber() {
                    let _this = this;
                    await axios.get('/cart/fetch/number').then(function (res) {
                        if (res.data > 4) {
                            _this.deliveryPrice = 15000;
                        }
                    })
                    this.fetchSumFinal();
                },
                transit() {
                    swal.fire({
                        imageUrl: '/warnning.jpg',
                        imageAlt: 'A tall image',
                        width: '45%'
                    })
                    let data = this;
                    axios.post('/valid/shipping', {
                        name: this.form.name,
                        postal_code: this.form.postal_code,
                        city: this.form.city,
                        cell: this.form.cell,
                        state: this.form.state,
                        address: this.form.address,
                    }).then(function () {
                        data.flag1 = false;
                        data.flag2 = true;
                        data.flag3 = false;
                        window.scrollTo(0, 0);

                    }).catch(function (error) {
                        data.error.name = "";
                        data.error.postal_code = "";
                        data.error.city = "";
                        data.error.cell = "";
                        data.error.state = "";
                        data.error.address = "";

                        this.allerros = error.response.data.errors;
                        x = error.response.data.errors;
                        if (Array.isArray(x.name)) {
                            data.error.name = this.allerros.name[0];
                        }
                        if (Array.isArray(x.postal_code)) {
                            data.error.postal_code = this.allerros.postal_code[0];
                        }
                        if (Array.isArray(x.city)) {
                            data.error.city = this.allerros.city[0];
                        }
                        if (Array.isArray(x.cell)) {
                            data.error.cell = this.allerros.cell[0];
                        }
                        if (Array.isArray(x.state)) {
                            data.error.state = this.allerros.state[0];
                        }
                        if (Array.isArray(x.address)) {
                            data.error.address = this.allerros.address[0];
                        }
                    });
                },
                deliveryPrice2() {
                    cal = this.form.distance * 2.2;
                    cal = cal / 1000;
                    cal = Math.round(cal);
                    cal = cal * 1000;

                    return cal;
                },
                shippingShow() {
                    this.flag2 = false;
                    this.flag3 = false;
                    this.flag1 = true;
                    window.scrollTo(0, 0);

                },
                paymentShow() {
                    var width = 50;
                    var loop = setInterval(funcWidth, 100);

                    function funcWidth() {
                        if (width < 100) {
                            width++;
                            document.getElementById("stepLoad").style.width = width + '%';
                        } else {
                            clearInterval(loop);
                        }
                    }

                    $(document).ready(function () {
                        $(".step-item:nth-child(1)").css(
                            {
                                "border-color": "#2662a1",
                                "box-shadow": "0 0 10px gray"
                            });

                        $(".step-item:nth-child(2)").css(
                            {
                                "transition-delay": "5s",
                                "border-color": "#2662a1",
                                "box-shadow": "0 0 10px gray"
                            });

                        $(".step-item:nth-child(3)").css(
                            {
                                "transition-delay": "4s",
                                "border-color": "#2662a1",
                                "box-shadow": "0 0 10px gray"
                            });
                        $(".step-item span:first").css("color", "#2662a1");
                        $("#second").css(
                            {
                                "color": "#2662a1",
                                "transition-delay": "5s"
                            });
                        $(".step-item span:last").css(
                            {
                                "color": "#2662a1",
                                "transition-delay": "9s"
                            });

                    });
                    this.flag1 = false;
                    this.flag2 = false;
                    this.flag3 = true;
                    window.scrollTo(0, 0);
                    this.form.delivery_time = document.querySelector('input[name="radio"]:checked').value;
                },
                deliveryShow() {
                    this.flag1 = false;
                    this.flag2 = true;
                    this.flag3 = false;
                    window.scrollTo(0, 0);

                },
                fetchDate() {
                    let data = this;
                    axios.get(`/fetch/date`).then(res => {
                        data.date = res.data;
                    });
                },
                fetchSumFinal() {
                    let _this = this;
                    axios.get('/fetch/cart/sum/total').then(res => {
                        _this.sum_final = parseInt(res.data) + _this.deliveryPrice;
                    });
                },
                fetchSumPrice() {
                    let data = this;
                    axios.get('/fetch/cart/sum/price').then(res => {
                        data.sum_price = res.data;
                    });
                },
                fetchSumTotal() {
                    let data = this;
                    axios.get('/fetch/cart/sum/total').then(res => {
                        data.sum_total = res.data;
                    });
                },
                calOff() {
                    let data = this;
                    axios.post('/off', {
                        code: this.off,
                        sum_final: this.sum_final,
                    }).then(function (res) {
                        sum = res.data;
                        if (sum === 0) {
                            swal.fire(
                                {
                                    text: "چنین کد تخفیفی وجود ندارد !",
                                    type: "warning",
                                    confirmButtonText: 'باشه',
                                }
                            );
                            data.off = '';
                        } else if (sum === 'nothing') {
                            swal.fire(
                                {
                                    text: "محصولات انتخابی شما شامل این کد تخفیف نمی باشد !",
                                    type: "warning",
                                    confirmButtonText: 'باشه',
                                }
                            );
                            data.off = '';
                        } else {
                            data.sum_final = sum;
                            data.offShow = false;
                            data.offMessage = true;
                        }
                    });
                },
                fetchCart2() {
                    let data = this;
                    axios.get('/fetch/cart').then(res => {
                        data.carts = res.data;
                    });
                },
                fetchSumTotal2() {
                    let data = this;
                    axios.get('/fetch/cart/sum/total').then(res => {
                        data.sum_total2 = res.data;
                    });
                },
                fetchSumPrice2() {
                    let data = this;
                    axios.get('/fetch/cart/sum/price').then(res => {
                        data.sum_price2 = res.data;
                    });
                },
                calculateDiscount2(price, discount) {
                    onePercent = price / 100;
                    difference = 100 - discount;
                    total = difference * onePercent;
                    ttt = Math.round(total);
                    return ttt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                numberFormat(price) {
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                formSubmit() {
                    let data = this;
                    lat = $('#latitude').val();
                    lon = $('#longitude').val();
                    axios.post('/order/store', {
                        name: this.form.name,
                        postal_code: this.form.postal_code,
                        city: this.form.city,
                        cell: this.form.cell,
                        state: this.form.state,
                        address: this.form.address,
                        lat: lat,
                        lon: lon,
                        distance: this.form.distance,
                        delivery_time: this.form.delivery_time,
                        sum_final: this.sum_final,
                        code: this.off,
                    }).then(function (res) {
                        window.location.href = `/panel/orders`;
                    })
                },
                formSubmitEpay() {
                    let _this = this
                    axios.post('/order/epay/store/session', {
                        name: this.form.name,
                        postal_code: this.form.postal_code,
                        city: this.form.city,
                        cell: this.form.cell,
                        state: this.form.state,
                        address: this.form.address,
                        distance: this.deliveryPrice,
                        sum_final: this.sum_final,
                    }).then(function (res) {
                        window.location.href = `/order/epay/redirect/${_this.chosenBank}`;
                        //   window.location.href = `/order/epay/redirect/zarinpal`;
                    });
                },
                fetchStates() {
                    let _this = this;
                    axios.get('/fetch/state').then(function (res) {
                        _this.states = res.data
                    })
                },
                selectState(event) {
                    let _this = this;
                    axios.get(`/fetch/city/${event.target.value}`).then(function (res) {
                        _this.citys = res.data
                    })
                },
                async fetchUser() {
                    let _this = this;
                    await axios.get('/fetch/user/info').then(res => {
                        _this.form.name = res.data.name;
                        _this.form.cell = res.data.mobile;
                        _this.form.postal_code = res.data.postal_code;
                        _this.form.state = res.data.state;
                        _this.form.city = res.data.city;
                        _this.form.address = res.data.address;
                    })
                    let event = {target: {value: null}}
                    event.target.value = _this.form.state

                    this.selectState(event)
                },
            },
            async created() {
                await this.fetchCartNumber()
                this.fetchDate()
                this.fetchSumPrice()
                this.fetchSumTotal()
                this.fetchCart2()
                this.fetchSumTotal2()
                this.fetchSumPrice2()
                this.fetchStates()
                this.fetchUser()
            }
        })
    </script>

    <script>
        var width = 25;
        var loop = setInterval(funcWidth, 100);

        function funcWidth() {
            if (width < 50) {
                width++;
                document.getElementById("stepLoad").style.width = width + '%';
            } else {
                clearInterval(loop);
            }
        }

        $(document).ready(function () {
            $(".step-item:nth-child(1)").css(
                {
                    "border-color": "#2662a1",
                    "box-shadow": "0 0 10px gray"
                });

            $(".step-item:nth-child(2)").css(
                {
                    "transition-delay": "3s",
                    "border-color": "#2662a1",
                    "box-shadow": "0 0 10px gray"
                });


            $(".step-item span:first").css("color", "#2662a1");
            $("#second").css(
                {
                    "color": "#2662a1",
                    "transition-delay": "5s"
                });
        });
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <style>
        .zarinpal {
            border: 1px solid #aaa;
            background: #e6e6e6;
            padding-top: 10px;
        }

        .sadad {
            border: 1px solid #aaa;
            background: #e6e6e6;
            padding-top: 10px;
        }

        .bun {
            border-color: unset !important;
        }

        .slide-fade-enter-active {
            transition: all .3s ease;
        }

        .slide-fade-leave-active {
            transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
        }

        .slide-fade-enter, .slide-fade-leave-to {
            transform: translateX(400px);
            opacity: 1;
        }

        #map {
            height: 500px;
        }

        .shipping-time {
            background: white;
            position: absolute !important;
            font-size: 14px;
            text-align: center;
            border: 1px solid #ddd;
            top: 0;
            right: -150%;
        }

        .shipping-time-head {
            position: absolute !important;
            top: -20px;
            right: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: white;
            font-weight: 600;
        }

        .shipping-time .col-lg-6 ul {
            text-align: center;
            display: flex;
            flex-direction: row-reverse;
        }

        .shipping-time .col-lg-6 .tab-content .container div {
            color: #aaa;
            cursor: pointer;
        }

        .shipping-time .nav-tabs .nav-link.active {
            background-color: transparent !important;
            border-color: transparent transparent #2662a1 transparent !important;
            border-width: 3px;
        }

        .shipping-time .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: black;
        }

        .shipping-time a {
            color: #aaa;
        }

        .shipping-time .tab-content {
            background-color: #fff;
        }

        .shipping-time-header {
            position: absolute;
            top: -15px;
            right: 0;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            background-color: white;
        }

        .shipping-time .col-lg-6 h3 {
            font-size: 15px;
            text-align: right;
        }

        .shipping-time .col-lg-6 span p {
            font-size: 14px;

        }

        .shipping-time-receipt {
            padding-top: 40px !important;
        }

        .shipping-time-receipt h3 {
            border-bottom: 1px solid #ddd;
        }

        .shipping-time-divider {
            border-right: 1px solid #ddd;
        }

        .shipping-time-receipt-divider {
            border-bottom: 1px solid #ddd;
            color: green;
        }

        .shipping-time-receipt-discount {
            color: #ff253a;
        }

        .shipping-time-receipt-price {
            font-weight: 600;
        }

        .shipping-time-receipt-button button {
            border-radius: 10px;
            border: none;
            outline: transparent !important;

            text-align: center;
            color: white;
            overflow: hidden;

        }

        .shipping-time-receipt-button button div {
            width: 100%;
            height: 100%;
            background-color: transparent;
            position: relative;
            padding: 5px 10px;
            z-index: 0;
        }

        .shipping-time-receipt-button button div i {

            height: 100%;
            background-color: transparent;
            position: absolute;
            left: 10%;
            top: 25%;
        }

        .shipping-time-receipt-button button div:after {
            position: absolute;
            top: 0;
            left: 0;
            content: '';
            height: 100%;
            width: 30%;
            background-color: #fff;
            opacity: 0.1;
            z-index: -1;
            clip-path: polygon(70% 0, 100% 50%, 70% 100%, 0 100%, 0 0);
            transition: 0.3s;
            pointer-events: none;
        }

        .shipping-time-receipt-button button div:hover:after {
            width: 150%;
        }

        .faktor {
            color: #aaa;
        }

        .funkyradio {
            direction: rtl
        }
    </style>
    <style>
        .funkyradio div {
            clear: both;
            overflow: hidden;
        }

        .funkyradio label {
            width: 100%;
            border-radius: 3px;
            border: 1px solid #D1D3D4;
            font-weight: normal;
        }

        .funkyradio input[type="radio"]:empty,
        .funkyradio input[type="checkbox"]:empty {
            display: none;
        }

        .funkyradio input[type="radio"]:empty ~ label,
        .funkyradio input[type="checkbox"]:empty ~ label {
            position: relative;
            line-height: 2.5em;
            text-indent: 3.25em;
            margin-top: 2em;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .funkyradio input[type="radio"]:empty ~ label:before,
        .funkyradio input[type="checkbox"]:empty ~ label:before {
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            content: '';
            width: 2.5em;
            background: #D1D3D4;
            border-radius: 3px 0 0 3px;
        }

        .funkyradio input[type="radio"]:hover:not(:checked) ~ label,
        .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
            color: #888;
        }

        .funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
        .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
            content: '\2714';
            text-indent: .9em;
            color: #C2C2C2;
        }

        .funkyradio input[type="radio"]:checked ~ label,
        .funkyradio input[type="checkbox"]:checked ~ label {
            color: #777;
        }

        .funkyradio input[type="radio"]:checked ~ label:before,
        .funkyradio input[type="checkbox"]:checked ~ label:before {
            content: '\2714';
            text-indent: .9em;
            color: #333;
            background-color: #ccc;
        }

        .funkyradio input[type="radio"]:focus ~ label:before,
        .funkyradio input[type="checkbox"]:focus ~ label:before {
            box-shadow: 0 0 0 3px #999;
        }

        .funkyradio-default input[type="radio"]:checked ~ label:before,
        .funkyradio-default input[type="checkbox"]:checked ~ label:before {
            color: #333;
            background-color: #ccc;
        }

        .funkyradio-primary input[type="radio"]:checked ~ label:before,
        .funkyradio-primary input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #337ab7;
        }

        .funkyradio-success input[type="radio"]:checked ~ label:before,
        .funkyradio-success input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #5cb85c;
        }

        .funkyradio-danger input[type="radio"]:checked ~ label:before,
        .funkyradio-danger input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #d9534f;
        }

        .funkyradio-warning input[type="radio"]:checked ~ label:before,
        .funkyradio-warning input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #f0ad4e;
        }

        .funkyradio-info input[type="radio"]:checked ~ label:before,
        .funkyradio-info input[type="checkbox"]:checked ~ label:before {
            color: #fff;
            background-color: #5bc0de;
        }

        label {
            color: unset !important;
        }

        .shipping-form-items label {
            top: 17% !important;
        }

        .shipping-form-items input:not(:placeholder-shown) ~ span i {
            color: #aaa !important;
        }
    </style>
@endsection

