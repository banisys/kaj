@extends('layouts.admin.admin')
@section('title') کد تخفیف @endsection
@section('content')
    <div class="container" id="area">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" @submit="formSubmit">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="name" class="col-md-12 control-label">نام :</label>
                                    <input id="name" type="text" class="form-control"
                                           name="name" v-model="form.name" autofocus>
                                    <span style="color:red">@{{ error.name }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label"
                                           style="max-width: 100%">دسته بندی :</label>

                                    <select class="form-control" v-model="category">
                                        <option value="">انتخاب کنید...</option>
                                        <option value="9999">همه دسته ها</option>
                                        <option v-for="cat in cats" :value="cat.id">
                                            @{{ cat.name }}
                                        </option>
                                    </select>
                                    <span v-if="error.cat_id"
                                          style="color:red">لطفا دسته بندی تخفیف را انتخاب کنید</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">برندها :</label>

                                    <select class="form-control" v-model="brands">
                                        <option value="">انتخاب کنید...</option>
                                        <option value="9999">همه برند ها</option>
                                        <option v-for="brand in f_brands.data" :value="brand.id">@{{ brand.name }}
                                        </option>
                                    </select>
                                    <span v-if="error.brand_id" style="color:red">لطفا برند تخفیف را انتخاب کنید</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="name" class="col-md-12 control-label">حداقل خرید :</label>
                                    <input id="name" type="text" class="form-control"
                                           v-model="form.min">
                                    {{--<span style="color:red">@{{ error.name }}</span>--}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="code" class="col-md-12 control-label">کد تخفیف :</label>
                                    <input id="code" type="text" class="form-control"
                                           placeholder="کد تخفیف را وارد نمایید" name="code" v-model="form.code"
                                           autofocus>
                                    <span v-if="error.code" style="color:red">کد تخفیف الزامی است</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="percent" class="col-md-12 control-label">درصد تخفیف :</label>
                                    <input id="percent" type="text" placeholder="درصد تخفیف را وارد نمایید"
                                           class="form-control" name="percent" v-model="form.percent">
                                    <span v-if="error.percent" style="color:red">درصد تخفیف الزامی است</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="expir" class="col-md-12 control-label">پایان تخفیف :</label>
                                    <input id="expir" type="text" placeholder="پایان تخفیف را وارد نمایید ( تعداد روز )"
                                           class="form-control" name="expir" v-model="form.expir">
                                    <span v-if="error.expir" style="color:red">تاریخ پایان تخفیف الزامی است</span>
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-top: 32px">

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        ثبت
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">دسته بندی</th>
                        <th scope="col">برند</th>
                        <th scope="col">تاریخ پایان</th>
                        <th scope="col"> درصد تخفیف</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" name="name" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجو بر اساس نام">
                        </td>
                        <td>
                            <select @change="searchCat" class="form-control" v-model="search.cat_id">
                                <option value="">انتخاب کنید...</option>
                                <option value="9999">همه دسته ها</option>
                                <option v-for="cat in cats" :value="cat.id">@{{ cat.name }}</option>
                            </select>
                        </td>
                        <td>
                            <select @change="searchBrand" class="form-control" v-model="search.brand_id">
                                <option value="">انتخاب کنید...</option>
                                <option value="9999">همه برندها</option>
                                <option v-for="brand in f_brands.data" :value="brand.id">@{{ brand.name }}</option>
                            </select>
                        </td>
                        <td>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr v-for="off in offs" :key="off.id">
                        <td>@{{off[1]}}</td>
                        <td>@{{off[5]}}</td>
                        <td>@{{off[6]}}</td>
                        <td>@{{off[3]}}</td>
                        <td>@{{off[4]}} %</td>
                        <td>
                            <a @click="showModelContent(off[0])" style="font-size: 20px;">
                                <i class="fa fa-list ml-3" style="color: #17a2b8;"></i>
                            </a>
                            <a @click="deleteBrand(off[0])" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2">
            {{--            <pagination :data="offs" @pagination-change-page="fetchOffs"></pagination>--}}
        </div>

    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                f_brands: [],
                brands: '',
                category: '',
                offs: [],
                cats: false,
                showModal: false,
                form: {
                    name: '',
                    code: '',
                    cat_id: '',
                    brand_id: '',
                    expir: '',
                    percent: '',
                    min: 0,
                },
                search: {
                    name: '',
                    cat_id: '',
                    brand_id: '',
                    expir: '',
                },
                error: {
                    name: '',
                    cat_id: '',
                    brand_id: '',
                    code: '',
                    percent: '',
                    expir: '',
                },
            },
            methods: {
                fetchOffs(page = 1) {
                    let data = this;
                    axios.get('/admin/off/fetchOffs?page=' + page).then(res => {
                        data.offs = res.data.off;
                    });
                },
                fetchCat(page = 1) {
                    let data = this;
                    axios.get('/admin/off/fetchCat?page=' + page).then(res => {
                        data.cats = res.data;


                    });
                },
                fetchBrands(page = 1) {
                    let data = this;
                    axios.get('/admin/off/fetchBrands?page=' + page).then(res => {
                        data.f_brands = res.data;

                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    let data = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };
                    let formData = new FormData();
                    formData.append('name', this.form.name);
                    formData.append('code', this.form.code);
                    formData.append('percent', this.form.percent);
                    formData.append('cat_id', data.category);
                    formData.append('brand_id', data.brands);
                    formData.append('expir', this.form.expir);
                    formData.append('min', this.form.min);
                    axios.post('/admin/off/store', formData, config)
                        .then(function (response) {
                            data.category = "";
                            data.form.name = "";
                            data.form.percent = "";
                            data.form.code = "";
                            data.form.cat_id = "";
                            data.form.brand_id = "";
                            data.form.min = "";
                            data.error.name = "";
                            data.error.percent = "";
                            data.error.code = "";
                            data.error.cat_id = "";
                            data.error.brand_id = "";
                            data.error.expir = "";
                            swal.fire(
                                {
                                    text: "تخفیف با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                            data.fetchOffs();
                        })
                        .catch(function (error) {
                            data.error.name = "";
                            data.error.percent = "";
                            data.error.code = "";
                            data.error.cat_id = "";
                            data.error.brand_id = "";
                            data.error.expir = "";

                            this.allerros = error.response.data.errors;
                            x = error.response.data.errors;

                            if (Array.isArray(x.name)) {
                                data.error.name = this.allerros.name[0];
                            }
                            if (Array.isArray(x.cat_id)) {
                                data.error.cat_id = this.allerros.cat_id[0];
                            }
                            if (Array.isArray(x.brand_id)) {
                                data.error.brand_id = this.allerros.brand_id[0];
                            }
                            if (Array.isArray(x.percent)) {
                                data.error.percent = this.allerros.percent[0];
                            }
                            if (Array.isArray(x.expir)) {
                                data.error.expir = this.allerros.expir[0];
                            }
                            if (Array.isArray(x.code)) {
                                data.error.code = this.allerros.code[0];
                            }

                        });
                },
                deleteBrand(id) {
                    let data = this;
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
                            console.log("ok");
                            axios.get(`/admin/off/delete/${id}`)
                                .then(() => {
                                    swal.fire(
                                        {
                                            text: "تخفیف با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    data.fetchOffs();
                                }).catch(() => {
                                swal.fire(
                                    {
                                        text: "درخواست شما انجام نشد !",
                                        type: "error",
                                        confirmButtonText: 'باشه',
                                    }
                                )
                            });

                        }
                    });
                },
                searchName(page = 1) {
                    data = this;
                    if (this.search.name) {
                        axios.get('/admin/off/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.offs = response.data.off;
                            console.log(response);
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchOffs();
                    }
                },
                searchCat(page = 1) {

                    data = this;

                    if (this.search.cat_id) {

                        axios.get('/admin/off/search?page=' + page, {params: {category: this.search.cat_id}}).then(response => {
                            data.offs = response.data.off;
                            console.log(data.offs);
                        });
                    }
                    if (this.search.cat_id.length === 0) {
                        this.fetchOffs();
                    }
                },
                searchBrand(page = 1) {
                    data = this;
                    if (this.search.brand_id) {
                        axios.get('/admin/off/search?page=' + page, {params: {brand: this.search.brand_id}}).then(response => {
                            data.offs = response.data.off;
                        });
                    }
                    if (this.search.brand_id.length === 0) {
                        this.fetchOffs();
                    }
                },
                showModelContent(id) {
                    let data = this;
                    axios.get(`/admin/off/fetch/detail/${id}`).then(res => {
                        swal.fire({
                            title: 'کد : ' + res.data.code,
                            type: 'info',
                            html: 'حداقل خرید : ' + res.data.min + ' تومان ',
                            showCloseButton: false,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText:
                                'باشه',
                        });
                    });
                },
            },
            mounted: function () {
                this.fetchBrands();
                this.fetchOffs();
                this.fetchCat();
            }
        });
    </script>
@endsection

@section('style')
    <style>
        .modal-mask {
            position: fixed !important;
            z-index: 9998 !important;
            top: 0 !important;
            left: 0 !important;
            width: 82.5% !important;
            height: 100vh !important;
            background-color: rgba(0, 0, 0, .5) !important;
            display: table !important;
            transition: opacity .3s ease !important;
        }

        .modal-content {
            max-height: calc(100vh - -3.5rem) !important;
            height: 100vh
        }
    </style>
    <link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>
    <style>
        .multiselect-container {
            direction: ltr !important;
            width: 100% !important;
        }

        .multiselect-container label {
            display: block !important;
            text-align: right !important;
            color: #717171 !important;
            margin-top: 5px !important;

        }

        .multiselect {
            width: 326px !important;
            text-align: right !important;
            background-color: white;
            min-height: 26px !important;
        }

        .dropdown-toggle::after {
            display: none !important;
        }
    </style>
@endsection
