<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>فاکتور</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/layout/style.css">
    <link rel="stylesheet" href="/dist/css/bootstrap-rtl.min.css">
    <style>
        * {
            font-size: 1rem
        }

        .table-bordered, .table-bordered td, .table-bordered th {
            border: 1px solid #bdbdbd !important;
        }

        table {
            margin: 5px !important;
        }

        /*.last-table table thead tr td{*/
        /*    background-color: rgb(73, 80, 87) !important;*/
        /*    color:white;*/
        /*}*/
        @media print {
            .title-bg {
                background-color: rgb(73, 80, 87) !important;
            }
        }
    </style>
</head>
<body>
<div id="area">
    <div class="container my-5 p-3" style="border: 1px dashed #a8a8a8">
        <div class="row">
            <div class="col-4">
                <div class="row">
                    <div class="col-12 mb-3">
                        <span>شماره فاکتور : @{{ order.id }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span>تاریخ : @{{order.shamsi_c}} - @{{ getHours(order.created_at) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-4" style="text-align: center;font-size: 1.6rem">فروشگاه ترمه تن</div>
            <div class="col-4" style="text-align: left">
                <img src="/images/logo-factor.png" style="width:35%">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row mb-3 mt-3">
                    <div class="col-12 py-1 title-bg"
                         style="text-align: center;border-bottom: 2px #495057 solid;border-top: 2px #495057 solid;">
                        <span style="font-size: 1.2rem;color: #1a1a1a">مشخصات خریدار</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <span>نام خانوادگی : @{{ order.name }}</span>
                    </div>
                    <div class="col-3">
                        {{--                        <span>تلفن : @{{ order.tell }}</span>--}}
                    </div>
                    <div class="col-3">
                        <span>همراه : @{{ order.cell }}</span>
                    </div>
                    <div class="col-3">
                        <span>شماره پیگیری : @{{ order.refid }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">

                        <span>استان/شهر : @{{ order.city }} - @{{ order.state }}</span>
                    </div>
                    <div class="col-6">
                        <span>کد پستی : @{{ order.postal_code }}</span>

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <span style="font-size: 21px">نشانی : @{{ order.address }}</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead style="background: #eaeaea">
                    <tr>
                        <td scope="col">ردیف</td>
                        <td scope="col">کد محصول</td>
                        <td scope="col">نام</td>
                        <td scope="col">مشخصات محصول</td>
                        <td scope="col">تعداد</td>
                        <td scope="col">قیمت واحد</td>
                        <td scope="col">تخفیف</td>
                        <td scope="col">کل</td>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="(order_value, name, index) in order_values">
                        <tr>
                            <td>@{{ index+1 }}</td>
                            <td>@{{ order_value[0].product_code }}</td>
                            <td>@{{ order_value[0].product_name }}</td>
                            <td>
                                <template v-for="(item, name, index) in order_value" v-if="item.key">
                                    <span>@{{ item.key }} : </span>
                                    <span>@{{ item.value }}</span><br>
                                </template>
                                <span v-if="order_value[0].color_name" style="display: block;">
                                    رنگ : @{{ order_value[0].color_name}}
                                </span>
                            </td>
                            <td>@{{ order_value[0].number }}</td>
                            <td>@{{ numberFormat(order_value[0].price) }}</td>
                            <td>
                                @{{ calOff(order_value[0].price,order_value[0].discount)}}
                                <span style="font-size:0.8rem;color: #828282">( %@{{ order_value[0].discount}} )</span>
                            </td>
                            <td>@{{ calTotal(order_value[0].total,order_value[0].cart_id) }}</td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-4 clearfixlast-table">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td style="background: #eaeaea">مجموع کالاهای خریداری شده :</td>
                        <td> @{{ totalNumber }} عدد</td>
                    </tr>
                    </thead>
                </table>
                <br>
                <span class="mt-5" style="display: inline-block;margin-right: 8px">شماره فاکتور : @{{ order.id }}</span>
            </div>
            <div class="col-4">

            </div>
            <div class="col-4 clearfixlast-table">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td style="background: #eaeaea">مبلغ کل خرید :</td>
                        <td>@{{ numberFormat(sum_price) }} تومان</td>
                    </tr>
                    <tr>
                        <td style="background: #eaeaea">مجموع تخفیفات :</td>

                        <td>@{{
                            calSamDiscount(sum_price,order.sum_final,order.distance)
                            }} تومان
                        </td>
                        {{--                        <td>@{{ numberFormat(sum_price-order.sum_final) }} تومان</td>--}}
                    </tr>
                    <tr>
                        <td style="background: #eaeaea">هزینه بسته بندی ارسال :</td>
                        <td>@{{ numberFormat(order.distance) }} تومان</td>
                    </tr>
                    <tr>
                        <td style="background: #eaeaea">مبلغ قابل پرداخت :</td>
                        <td>@{{ numberFormat(order.sum_final+order.distance) }} تومان</td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>


    </div>
    <div>
        <button onclick="window.print();" class="print-page-button" style="height: 36px;background-color: #495057">
            چاپ فاکتور
        </button>
    </div>
</div>

<script src="/js/app.js"></script>

<script>
    new Vue({
        el: '#area',
        data: {
            order: [],
            order_values: [],
            sum: 0,
            sum_price: 0,
            percent: [],
            num_per: 0,
            totalNumber: 0,
        },
        methods: {
            calSamDiscount(sum_price, sum_final, distance) {
                return ((sum_price + distance) - sum_final) - distance
            },
            getHours(created_at) {
                let result = created_at.split(" ");
                return result[1];
            },
            fetchOrder(id) {
                let data = this;
                axios.get(`/factor/fetch/order/${id}`).then(res => {
                    data.order = res.data;
                    console.log(data.order)

                });
            },
            fetchOrderValues(id) {
                let data = this;
                axios.get(`/admin/fetch/order/value/${id}`).then(res => {
                    data.order_values = res.data;
                    console.log(data.order_values)
                });
            },
            calOff(price, discount) {
                per = parseInt(price) / 100;
                dif = 100 - parseInt(discount);

                ff = parseInt(per * dif);
                return ff.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            calSum() {
                let data = this;
                axios.get(`/admin/fetch/order/${id}`).then(res => {
                    data.order = res.data;
                });
            },
            fetchSumPrice(id) {
                let data = this;
                axios.get(`/admin/order/sum/price/${id}`).then(res => {
                    data.sum_price = res.data;
                });
            },
            fetchNumber(id) {
                let _this = this;
                axios.get(`/admin/order/fetch/number/${id}`).then(res => {
                    _this.totalNumber = res.data;
                });
            },
            numberFormat(price) {
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            hasOff(cart_id) {
                obj = this;
                Object.keys(this.order_values).forEach(function (key) {
                    if (parseInt(key) === parseInt(cart_id)) {
                        result = obj.order_values[parseInt(key)][0].off_percent;
                    }
                });
                return result;
            },
            calTotal(total, cart_id) {
                obj = this;
                Object.keys(this.order_values).forEach(function (key) {
                    if (parseInt(key) === parseInt(cart_id)) {
                        percent = obj.order_values[parseInt(key)][0].off_percent;
                    }
                });

                x = 100 - percent;
                y = total / 100;
                z = x * y;
                z = Math.trunc(z);
                return z.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
        },
        mounted: function () {
            parts = window.location.href.split('/');
            id = parts.pop() || parts.pop();
            this.fetchOrder(id);
            this.fetchOrderValues(id);
            this.fetchSumPrice(id);
            this.fetchNumber(id);
        }
    });
</script>

</body>
</html>
