@extends('layouts.front.dress')
@section('content')
    <div class="clearfix container mb-5" id="area" style="max-width: 1140px">
        @include('layouts.front.aside')
        <div class="col-lg-9 float-right pl-0 pr-0  content mt-5">
            <div class="col-md-12 orders pl-0 pr-0   text-center">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">شماره فاکتور</th>
                        <th scope="col">تاریخ</th>
                        <th scope="col">وضعیت</th>
                        <th scope="col">
                            <span style="color:#c40316;font-weight: bold">مجموع :@{{ orders.total }}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(order,index) in orders.data" :key="order.id">
                        <td>@{{ order.id}}</td>
                        <td>@{{order.shamsi_c}}</td>
                        <td>
                            @{{ fetchStatus(order.status) }}
                        </td>
                        <td>
                            <a @click="factor(order.id)"
                               style="font-size: 20px;background-color: #ffcbc9;padding: 0 10px;border-radius: 8px;">
                                <i class="fa fa-list-alt" style="color: #3a3a3a"></i>
                                <span style="font-size: 15px;vertical-align: middle;">فاکتور</span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-if="flag2"
                     class="alert alert-info" role="alert" style="text-align: center">
                    لیست سفارشات شما خالی است !
                </div>
            </div>
            <div class="row mt-2 mr-3 d-flex justify-content-center">
                <pagination :data="orders" @pagination-change-page="fetchOrders"></pagination>
            </div>
        </div>


    </div>
@endsection

@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                orders: [],
                user: [],
                form: {
                    image: '',
                },
                flag: true,
                flag2: false,
            },
            methods: {
                fetchOrders(page = 1) {
                    let data = this;
                    axios.get('/order/fetch?page=' + page).then(res => {
                        data.orders = res.data;
                        data.emptyOrder();
                    });

                },
                factor(id) {
                    window.open(`/factor/${id}`, '_blank');
                },
                fetchStatus(id) {
                    if (id === 0) {
                        return "در صف بررسی"
                    }
                    if (id === 1) {
                        return "ارسال شد"
                    }
                    if (id === 2) {
                        return "لغو شد"
                    }
                    if (id === 3) {
                        return "آماده ارسال"
                    }
                },
                fetchUser() {
                    let data = this;
                    axios.get(`/panel/fetch/user`).then(res => {
                        data.user = res.data;
                        data.form.image = data.user.image;
                    });
                },
                exit() {
                    this.$refs.formExit.submit();
                },
                emptyOrder() {
                    if (!this.orders.data.length) {
                        this.flag2 = true;
                    }
                },
            },
            mounted: function () {
                this.fetchOrders();
                this.fetchUser();
            }
        });
        $("#order-btn").addClass('active-menu');
    </script>

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="/layout/style.css">
    <style>
        #panel_side > li {
            text-align: right !important;
        }

        .admin {
            background-color: #ffef636b !important
        }

        .active-menu .fa {
            color: #c40316
        }

        .active-menu {
            background-color: aliceblue;
        }

        .active-menu span {
            font-weight: bold;
            color: #c40316 !important;
        }

        #panel_side li:hover a, #panel_side li:hover a span {
            color: #123b66 !important;
        }

        #panel_side li a {
            color: #c9c9c9
        }

        .account-img {
            display: none
        }
    </style>
@endsection

