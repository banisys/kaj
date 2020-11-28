@extends('layouts.front.online')
@section('content')
    <div class="clearfix container mb-5" id="area" style="max-width: 1140px">
        <div class="row">
            @include('layouts.front.aside')

            <div class="col-lg-9 float-right pl-0 content mt-5 px-5 pt-5">

                <table class="table table-striped">
                    <thead>
                    <tr style="text-align:right">
                        <th scope="col">کد تیکت</th>
                        <th scope="col">دپارتمان</th>
                        <th scope="col">وضعیت</th>
                        <th scope="col">تاریخ</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--<tr>--}}
                    {{--<td>--}}
                    {{--<select class="form-control" v-model="search.cat" @change="searchCat()">--}}
                    {{--<option value="" disabled hidden>انتخاب کنید...</option>--}}
                    {{--<option value="999999">همه دسته ها</option>--}}
                    {{--<option v-for="cat in cats" :value="cat.id">@{{ cat.name }}</option>--}}
                    {{--</select>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--<input type="text" class="form-control" v-model="search.name"--}}
                    {{--@keyup="searchName" placeholder="جستجو بر اساس نام">--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--<input type="text" class="form-control" v-model="search.brand"--}}
                    {{--@keyup="searchBrand" placeholder="جستجو بر اساس برند">--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--<input type="text" class="form-control" v-model="search.price"--}}
                    {{--@keyup="searchPrice" placeholder="جستجو بر اساس قیمت">--}}
                    {{--<input type="text" class="form-control" v-model="search.less" v-if="flag"--}}
                    {{--@keyup="searchLess" placeholder="قیمت های کمتر از">--}}
                    {{--<input type="text" class="form-control" v-model="search.more" v-if="flag"--}}
                    {{--@keyup="searchMore" placeholder="قیمت های بیشتر از">--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--<input type="text" class="form-control" v-model="search.exist"--}}
                    {{--@keyup="searchExist" placeholder="جستجو بر اساس موجودی">--}}
                    {{--<input type="text" class="form-control" v-model="search.existless" v-if="flag"--}}
                    {{--@keyup="searchExistLess" placeholder="موجودی های کمتر از">--}}
                    {{--<input type="text" class="form-control" v-model="search.existmore" v-if="flag"--}}
                    {{--@keyup="searchExistMore" placeholder="موجودی های بیشتر از">--}}

                    {{--</td>--}}
                    {{--<td>--}}
                    {{--<input type="text" class="form-control" v-model="search.shamsi_c"--}}
                    {{--@keyup="searchShamsi_c" placeholder="جستجوی تاریخ ">--}}
                    {{--<input type="text" class="form-control" v-model="search.shamsiless" v-if="flag"--}}
                    {{--@keyup="searchShamsiLess" placeholder="تاریخ های قبل از">--}}
                    {{--<input type="text" class="form-control" v-model="search.shamsimore" v-if="flag"--}}
                    {{--@keyup="searchShamsiMore" placeholder="تاریخ های بعد از">--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--<span style="color:rgb(0,149,47);font-weight: bold"> @{{ products.total }}</span>--}}
                    {{--<i v-if="pluss" class="fa fa-plus"--}}
                    {{--style="color: #888888;font-size:20px;float: left;cursor: pointer"--}}
                    {{--@click="toggleFlag()"></i>--}}
                    {{--<i v-if="pluss2" class="fa fa-minus"--}}
                    {{--style="color: #888888;font-size:20px;float: left;cursor: pointer"--}}
                    {{--@click="toggleFlag()"></i>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    <tr v-for="(ticket,index) in tickets.data" style="text-align: right;">
                        <td>@{{ticket.id}}</td>
                        <td>@{{ticket.department}}</td>
                        <td>@{{ticket.status}}</td>
                        <td>@{{ticket.shamsi_c}}</td>
                        {{--<td>@{{product.name}}</td>--}}
                        {{--<td>@{{product.brand}}</td>--}}
                        {{--<td>@{{product.price}}</td>--}}
                        {{--<td>@{{product.exist}}</td>--}}
                        {{--<td>@{{product.shamsi_c}}</td>--}}
                        <td>
                            <a @click="detail(ticket.group)" class="ml-2 btn btn-primary btn-sm" style="background-color: #c40316;color: white;border-color: unset">
                                مشاهده تیکت
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="row mt-2 mr-3">
                    <pagination :data="tickets" @pagination-change-page="fetchTickets"></pagination>
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
                user: [],
                flag: true,
                form: {
                    image: '',
                },
                tickets: [],
            },
            methods: {
                fetchUser() {
                    let data = this;
                    axios.get(`/panel/fetch/user`).then(res => {
                        data.user = res.data;
                        data.form.image = data.user.image;
                    });
                },
                fetchTickets(page = 1) {
                    let data = this;
                    axios.get('/panel/ticket/fetch?page=' + page).then(res => {
                        data.tickets = res.data;
                    });
                },
                detail(group) {
                    window.location.href = `/panel/ticket/detail/${group}`;
                },
                exit() {
                    this.$refs.formExit.submit();
                },
            },
            mounted: function () {
                this.fetchUser();
                this.fetchTickets();
            }
        });

        $("#ticket-list-btn").addClass('active-menu');
    </script>
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="/layout/style.css">
    <style>
        #panel_side > li{
            text-align: right !important;
        }

        .active-menu .fa  {
            color: #c40316
        }
        .active-menu span  {
            font-weight: bold;
            color: #c40316 !important;
        }

        #panel_side li:hover a, #panel_side li:hover a span {
            color: white !important;
        }

        #panel_side li a {
            color: #c9c9c9 !important
        }
        .account-img{display: none}
        .active-menu  {
            background-color: aliceblue;
        }
    </style>
@endsection

