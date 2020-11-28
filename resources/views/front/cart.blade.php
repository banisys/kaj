@extends('layouts.front.kaj')
@section('content')
    <div id="area">
        <div class="breadcrumb-area mt-37 hm-4-padding">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h2>صفحه سبد خرید</h2>
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">خانه</a>
                        </li>
                        <li>صفحه سبد خرید</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="product-cart-area hm-3-padding pt-5 pb-130">
            <div class="container-fluid">
                <div class="row">
                    <div class="cart-desktop col-12 d-none d-md-block px-0 px-md-2">
                        <div class="rtl">
                            <div class="col-12">
                                <div class="cart-table-title d-none d-md-block">
                                    <div class="d-flex  py-3 px-2 text-center">
                                        <div class="col-1  product-subtotal">حذف</div>
                                        <div class="col-2   product-name">عکس محصولات</div>
                                        <div class="col-3   product-price">نام محصولات</div>
                                        <div class="col-3  product-name">قیمت واحد</div>
                                        <div class="col-1   product-price">تعداد</div>
                                        <div class="col-2  product-quantity">جمع</div>
                                    </div>
                                </div>
                                <div>
                                    <template v-for="(cart, name, index) in carts">
                                        <div
                                            class="d-flex flex-wrap justify-content-between p-3 align-items-center cart-items-table">
                                            <div class="product-cart-icon col-1 pr-0  product-subtotal  text-center">
                                                <a @click="deleteCart(cart.id)">
                                                    <i class="text-danger" aria-hidden="true"
                                                       style="font-size:16px ;font-style: normal">&#10006</i>
                                                </a>
                                            </div>
                                            <div class="product-thumbnail col-5 col-lg-2  d-flex align-items-center">
                                                <a href="#">
                                                    <img style="width: 140px;"
                                                         :src="'/images/product/'+cart.product.image">
                                                </a>
                                            </div>
                                            <div class="product-name col-6 col-lg-3  ">
                                                <a href="#" style="color:#333"> @{{ cart.product.name }}</a>
                                                <div v-if="cart.cart_values[0]" class="d-block">
                                                    سایز : @{{ cart.cart_values[0].effect_value.key }}
                                                </div>
                                                <div v-else class="d-block">---</div>
                                                <br>
                                                <div v-if="cart.color" class="d-block" style="color:#777">
                                                    رنگ : @{{ cart.color.name}}
                                                </div>
                                                <div v-else>---</div>
                                            </div>
                                            <div class="product-price col-lg-3 text-center ">
                                                <span class="amount">
                                                                @{{ numberFormat(cart.price) }} تومان
                                                </span>
                                            </div>
                                            <div class="product-quantity col-lg-1   d-flex align-items-center">
                                                <select
                                                    style="cursor:pointer;border-radius: 5px;padding:0 5px;border-color: #dddddd;color: grey;direction: ltr"
                                                    v-model="cart.number"
                                                    @change="onChange($event,cart.price,cart.product.discount,cart.id)">
                                                    <option value="1">1</option>
                                                    <option value="2" v-if="checkNum2(cart.number2)">2</option>
                                                    <option value="3" v-if="checkNum3(cart.number2)">3</option>
                                                    <option value="4" v-if="checkNum4(cart.number2)">4</option>
                                                    <option value="5" v-if="checkNum5(cart.number2)">5</option>
                                                    <option value="6" v-if="checkNum6(cart.number2)">6</option>
                                                    <option value="7" v-if="checkNum7(cart.number2)">7</option>
                                                    <option value="8" v-if="checkNum8(cart.number2)">8</option>
                                                    <option value="9" v-if="checkNum9(cart.number2)">9</option>
                                                    <option value="10" v-if="checkNum10(cart.number2)">10</option>
                                                    <option value="11" v-if="checkNum11(cart.number2)">11</option>
                                                    <option value="12" v-if="checkNum12(cart.number2)">12</option>
                                                    <option value="13" v-if="checkNum13(cart.number2)">13</option>
                                                    <option value="14" v-if="checkNum14(cart.number2)">14</option>
                                                    <option value="15" v-if="checkNum15(cart.number2)">15</option>
                                                </select>
                                            </div>
                                            <div class="product-subtotal col-lg-2 text-center ">
                                                @{{numberFormat(cart.total) }} تومان
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cart-mobile col-12 d-md-none px-0 px-md-2">
                        <div class=" rtl ">
                            <div class="col-12">
                                <div>
                                    <template v-for="(cart, name, index) in carts">
                                        <div
                                            class="d-flex flex-wrap py-3 px-2 position-relative  px-0  cart-items-table">
                                            <div
                                                class="product-cart-icon py-1 px-2 product-subtotal  text-center">
                                                <a @click="deleteCart(cart.id)" style="font-size:12px">
                                                    <i class="text-danger" aria-hidden="true"
                                                       style="font-style:normal;">X</i>
                                                </a>
                                            </div>
                                            <div class="col-5 px-0">
                                                <div class="product-thumbnail col-12 px-0  d-flex align-items-center">
                                                    <a href="#">
                                                        <img style="width: 140px;"
                                                             :src="'/images/product/'+cart.product.image">
                                                    </a>
                                                </div>
                                            </div>
                                            <div
                                                class="col-7 d-flex justify-content-between align-items-center flex-wrap px-2">
                                                <div class="product-name  col-12 px-0">
                                                    <a href="#" style="color:#333"> @{{ cart.product.name }}</a>
                                                    <div v-if="cart.cart_values[0]">
                                                        سایز : @{{ cart.cart_values[0].effect_value.key }}
                                                    </div>
                                                    <div v-else>---</div>
                                                    <br>
                                                    <div v-if="cart.color" style="color:#888">
                                                        رنگ : @{{ cart.color.name}}
                                                    </div>
                                                    <div v-else>---</div>
                                                </div>
                                                <div class="product-quantity d-flex align-items-center">
                                                    <select
                                                        style="cursor:pointer;border-radius: 5px;padding:0 5px;border-color: #dddddd;color: grey;direction: ltr"
                                                        v-model="cart.number"
                                                        @change="onChange($event,cart.price,cart.product.discount,cart.id)">
                                                        <option value="1">1</option>
                                                        <option value="2" v-if="checkNum2(cart.number2)">2</option>
                                                        <option value="3" v-if="checkNum3(cart.number2)">3</option>
                                                        <option value="4" v-if="checkNum4(cart.number2)">4</option>
                                                        <option value="5" v-if="checkNum5(cart.number2)">5</option>
                                                        <option value="6" v-if="checkNum6(cart.number2)">6</option>
                                                        <option value="7" v-if="checkNum7(cart.number2)">7</option>
                                                        <option value="8" v-if="checkNum8(cart.number2)">8</option>
                                                        <option value="9" v-if="checkNum9(cart.number2)">9</option>
                                                        <option value="10" v-if="checkNum10(cart.number2)">10</option>
                                                        <option value="11" v-if="checkNum11(cart.number2)">11</option>
                                                        <option value="12" v-if="checkNum12(cart.number2)">12</option>
                                                        <option value="13" v-if="checkNum13(cart.number2)">13</option>
                                                        <option value="14" v-if="checkNum14(cart.number2)">14</option>
                                                        <option value="15" v-if="checkNum15(cart.number2)">15</option>
                                                    </select>
                                                </div>
                                                <div class="product-subtotal  text-center ">
                                                    @{{numberFormat(cart.total) }} تومان
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-5">
                    <div class="col-md-7 col-sm-6">

                    </div>
                    <div class="col-md-5 col-sm-6">
                        <div class="shop-total">
                            <h3>کل سبد خرید</h3>
                            <ul>
                                <li>
                                    جمع کل سفارش :
                                    <span>@{{ numberFormat(sum_price) }} تومان</span>
                                </li>
                                <li>
                                    جمع مبلغ تخفیف :
                                    <span>@{{ numberFormat(sum_price - sum_total) }} تومان</span>
                                </li>
                                <li class="order-total">
                                    مجموع :
                                    <span>@{{ numberFormat(sum_total) }} تومان</span>
                                </li>

                            </ul>
                        </div>

                        <div class="continue-shopping-btn text-center d-lg-flex justify-content-between">
                            <a class="mb-3 mb-lg-0"
                               style="cursor: pointer;padding: 15px 20px;background-color:white;color:#E63946" href="/">
                                افزودن محصول جدید</a>
                            <a style="cursor: pointer;padding: 15px 20px;" @click="shipping()">ثبت
                                سفارش و پرداخت</a>
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
                carts: [],
                sum_total: 0,
                sum_price: 0,
                sum_discount: 0,
            },
            methods: {
                fetchCart() {
                    let _this = this;
                    axios.get('/fetch/cart').then(res => {
                        if (res.data.length > 0) {
                            _this.carts = res.data;
                            console.log(_this.carts);
                        } else {
                            window.location.href = `/`;
                        }
                    });
                },
                fetchSumTotal() {
                    let data = this;
                    axios.get('/fetch/cart/sum/total').then(res => {
                        data.sum_total = res.data;
                    });
                },
                fetchSumPrice() {
                    let data = this;
                    axios.get('/fetch/cart/sum/price').then(res => {
                        data.sum_price = res.data;
                    });
                },
                calculateDiscount(price, discount) {
                    onePercent = price / 100;
                    difference = 100 - discount;
                    total = difference * onePercent;
                    total = Math.round(total);
                    return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                onChange(event, price, discount, cart) {
                    let _this = this;
                    axios.post('/cart/total', {
                        cart: cart,
                        price: price,
                        discount: discount,
                        number: event.target.value,
                    }).then(function (res) {
                        _this.fetchCart();
                        _this.fetchSumTotal();
                        _this.fetchSumPrice();
                    });
                },
                shipping() {
                    window.location.href = `/shipping`;
                    sessionStorage.setItem("destination", "/shipping")
                },
                deleteCart(id) {
                    let _this = this;
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
                                _this.fetchCart();
                                _this.fetchSumTotal();
                                _this.fetchSumPrice();
                            });
                        }
                    });
                },
                numberFormat(price) {
                    price = Math.trunc(price);
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                checkNum2(num) {
                    if (num >= 2) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum3(num) {
                    if (num >= 3) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum4(num) {
                    if (num >= 4) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum5(num) {
                    if (num >= 5) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum6(num) {
                    if (num >= 6) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum7(num) {
                    if (num >= 7) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum8(num) {
                    if (num >= 8) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum9(num) {
                    if (num >= 9) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum10(num) {
                    if (num >= 10) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum11(num) {
                    if (num >= 11) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum12(num) {
                    if (num >= 12) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum13(num) {
                    if (num >= 13) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum14(num) {
                    if (num >= 14) {
                        return true;
                    } else {
                        return false;
                    }
                },
                checkNum15(num) {
                    if (num >= 15) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            mounted: function () {
                this.fetchCart();
                this.fetchSumTotal();
                this.fetchSumPrice();
            }
        })
    </script>


@endsection

@section('style')
    <style>
        input, select {
            background: white
        }
    </style>
@endsection

