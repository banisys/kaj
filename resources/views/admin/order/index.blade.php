@extends('layouts.admin.admin')
@section('content')
    <div class="container-fluid" id="area">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">شماره فاکتور</th>
                        <th scope="col">نام</th>
                        <th scope="col">همراه</th>
                        <th scope="col">استان</th>
                        <th scope="col">قیمت</th>
                        <th scope="col">کد پیگیری</th>
                        <th scope="col">تاریخ</th>
                        <th scope="col">وضعیت</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control" v-model="search.id"
                                   @keyup="searchId" placeholder="شماره فاکتور">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجوی نام">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.mobile"
                                   @keyup="searchMobile" placeholder="جستجو بر اساس همراه">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.state"
                                   @keyup="searchState" placeholder="جستجو بر اساس استان">
                        </td>
                        <td></td>
                        <td>
                            <input type="text" class="form-control" v-model="search.refid"
                                   @keyup="searchRefid" placeholder="جستجوی کد پیگیری">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.shamsi_c"
                                   @keyup="searchShamsi_c" placeholder="جستجوی تاریخ">
                            <input type="text" class="form-control" v-model="search.shamsiless" v-if="flag"
                                   @keyup="searchShamsiLess" placeholder="تاریخ های قبل از">
                            <input type="text" class="form-control" v-model="search.shamsimore" v-if="flag"
                                   @keyup="searchShamsiMore" placeholder="تاریخ های بعد از">
                        </td>
                        <td>
                            <select class="form-control" @change="searchStatus()" v-model="search.status">
                                <option value="" disabled hidden>انتخاب کنید...</option>
                                <option value="0">در صف بررسی</option>
                                <option value="3">آماده ارسال</option>
                                <option value="1">ارسال شد</option>
                                <option value="2">لغو شد</option>
                            </select>
                        </td>
                        <td>
                            <span style="color:rgb(0,149,47);font-weight: bold"> @{{ orders.total }}</span>
                            <i v-if="pluss" class="fa fa-plus"
                               style="color: #888888;font-size:20px;float: left;cursor: pointer"
                               @click="toggleFlag()"></i>
                            <i v-if="pluss2" class="fa fa-minus"
                               style="color: #888888;font-size:20px;float: left;cursor: pointer"
                               @click="toggleFlag()"></i>
                        </td>
                    </tr>
                    <tr v-for="(order,index) in orders.data" :id="'tr'+order.id" @click="selectRow(order.id)">
                        <td>@{{order.id}}</td>
                        <td>@{{order.name}}</td>
                        <td>@{{order.cell}}</td>
                        <td>@{{order.state}}</td>
                        <td>@{{numberFormat(order.sum_final+order.distance)}}</td>
                        <td>@{{order.refid}}</td>
                        <td> @{{ getHours(order.created_at) }} - @{{order.shamsi_c}}</td>
                        <td>
                            <select class="form-control" @change="status(order.id,$event)">
                                <option value="0" :selected="0 == order.status">در صف بررسی</option>
                                <option value="3" :selected="3 == order.status">آماده ارسال</option>
                                <option value="1" :selected="1 == order.status">ارسال شد</option>
                                <option value="2" :selected="2 == order.status">لغو شد</option>
                            </select>
                        </td>
                        <td>
                            <a @click="factor(order.id)" class="ml-2 btn btn-primary btn-sm" style="color: white">
                                فاکتور
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2 mr-3">
            <div class="col-12" style="text-align:center">
                <pagination :limit="1" :data="orders" @pagination-change-page="fetchOrders"></pagination>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                pluss: true,
                confirmFlag: true,
                pluss2: false,
                flag: false,
                flag2: false,
                flag3: false,
                cats: false,
                search: {
                    id: '',
                    name: '',
                    mobile: '',
                    state: '',
                    status: '',
                    shamsi_c: '',
                    shamsiless: '',
                    shamsimore: '',
                    refid: '',
                },
                description: '',
                orders: [],
                holderClass: '',
            },
            methods: {
                numberFormat(price) {
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                getHours(created_at) {
                    let result = created_at.split(" ");
                    return result[1];
                },
                fetchOrders(page = 1) {
                    let data = this;
                    axios.get('/admin/order/fetch?page=' + page).then(res => {
                        data.orders = res.data;
                    });
                },
                status(id, event) {
                    if (event.target.value == 9999) {
                        swal.fire({
                            text: "از موجودی انبار کسر خواهد شد ، آیا اطمینان دارید ؟",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'بله',
                            cancelButtonText: 'لغو',
                        }).then((result) => {
                            if (result.value) {
                                axios.post(`/admin/change/status/${id}`, {
                                    status: event.target.value,
                                }).then(function () {
                                    swal.fire(
                                        {
                                            text: "تغییرات با موفقیت اعمال شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                });
                            }
                        });
                    } else {
                        axios.post(`/admin/change/status/${id}`, {
                            status: event.target.value,
                        }).then(function () {
                            swal.fire(
                                {
                                    text: "تغییرات با موفقیت اعمال شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                        });
                    }
                },
                toggleFlag() {
                    if (this.pluss === false) {
                        this.pluss = true;
                    } else {
                        if (this.pluss === true) {
                            this.pluss = false;
                        }
                    }
                    if (this.pluss2 === false) {
                        this.pluss2 = true;
                    } else {
                        if (this.pluss2 === true) {
                            this.pluss2 = false;
                        }
                    }
                    if (this.flag === false) {
                        this.flag = true;
                    } else {
                        if (this.flag === true) {
                            this.flag = false;
                        }
                    }
                },
                searchId(page = 1) {
                    data = this;
                    if (this.search.id.length > 0) {
                        axios.get('/admin/order/search?page=' + page,
                            {params: {id: this.search.id}}).then(response => {
                            data.orders = response.data;
                        });
                    }
                    if (this.search.id.length === 0) {
                        this.fetchOrders();
                    }
                },
                searchName(page = 1) {
                    let data = this;
                    if (this.search.name.length > 0) {
                        axios.get('/admin/order/search?page=' + page,
                            {params: {name: this.search.name}}).then(response => {
                            data.orders = response.data;
                            console.log(data.orders)
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchOrders();
                    }
                },
                searchMobile(page = 1) {
                    let _this = this;
                    if (this.search.mobile.length > 0) {
                        axios.get('/admin/order/search?page=' + page,
                            {params: {mobile: this.search.mobile}}).then(response => {
                            _this.orders = response.data;

                        });
                    }
                    if (this.search.mobile.length === 0) {
                        this.fetchOrders();
                    }
                },
                searchState(page = 1) {
                    data = this;
                    if (this.search.state.length > 0) {
                        axios.get('/admin/order/search?page=' + page,
                            {params: {state: this.search.state}}).then(response => {
                            data.orders = response.data;
                        });
                    }
                    if (this.search.state.length === 0) {
                        this.fetchOrders();
                    }
                },
                searchRefid(page = 1) {
                    let _this = this;
                    if (this.search.refid.length > 0) {
                        axios.get('/admin/order/search?page=' + page,
                            {params: {refid: this.search.refid}}).then(response => {
                            _this.orders = response.data;
                        });
                    }
                    if (this.search.refid.length === 0) {
                        this.fetchOrders();
                    }
                },
                searchShamsi_c(page = 1) {
                    data = this;
                    if (this.search.shamsi_c.length > 0) {
                        axios.get('/admin/order/search?page=' + page,
                            {params: {shamsi_c: this.search.shamsi_c}}).then(response => {
                            data.orders = response.data;
                        });
                    }
                    if (this.search.shamsi_c.length === 0) {
                        this.fetchOrders();
                    }
                },
                searchStatus(page = 1) {
                    data = this;
                    if (this.search.status.length > 0) {
                        axios.get('/admin/order/search?page=' + page,
                            {params: {status: this.search.status,}}).then(response => {
                            data.orders = response.data;
                        });
                    }
                    if (this.search.status.length === 0) {
                        this.fetchOrders();
                    }
                },
                searchShamsiLess(page = 1) {
                    data = this;
                    if (this.search.shamsiless.length > 7) {
                        axios.get('/admin/order/search?page=' + page, {params: {shamsiless: this.search.shamsiless}}).then(response => {
                            data.orders = response.data;
                        });
                    }
                    if (this.search.shamsiless.length === 0) {
                        this.fetchOrders();
                    }
                },
                searchShamsiMore(page = 1) {
                    data = this;
                    if (this.search.shamsimore.length > 7) {
                        axios.get('/admin/order/search?page=' + page, {params: {shamsimore: this.search.shamsimore}}).then(response => {
                            data.orders = response.data;
                        });
                    }
                    if (this.search.shamsimore.length === 0) {
                        this.fetchOrders();
                    }
                },
                deleteOrder(id) {
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
                            axios.get(`/admin/order/delete/${id}`).then(res => {
                                this.fetchOrders();
                            });
                        }
                    });
                },
                factor(id) {
                    window.open(`/factor/${id}`, '_blank');
                },
                confirm(id) {
                    let _this = this;
                    axios.get(`/admin/factor/confirm/${id}`).then(function () {
                        swal.fire(
                            {
                                text: "محصولات موجود در فاکتور از انبار کسر شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        _this.fetchNotConfirm();
                        _this.confirmFlag = true;
                    });
                },
                selectRow(id) {
                    $(this.holderClass).removeClass('select-row');
                    this.holderClass = `#tr${id}`;
                    $(`#tr${id}`).addClass('select-row');
                },
                fetchNotConfirm(page = 1) {
                    this.confirmFlag = false;
                    let _this = this;
                    axios.get('/admin/order/not-confirm/fetch?page=' + page).then(res => {
                        _this.orders = res.data;
                    });
                },
                fetchConfirm(page = 1) {
                    this.confirmFlag = true;
                    let _this = this;
                    axios.get('/admin/order/confirm/fetch?page=' + page).then(res => {
                        _this.orders = res.data;
                    });
                },
            },
            mounted: function () {
                this.fetchOrders();
            }
        });
    </script>

@endsection

@section('style')
    <style>
        .pagination{    display: inline-flex;}

        .select-row {
            border: 2px #6bb2ff dotted;
        }
    </style>
@endsection
