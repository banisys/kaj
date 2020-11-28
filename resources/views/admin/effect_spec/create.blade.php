@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-5 pb-5" id="area" style="position: relative">
        <span style="position: absolute;margin-right:10px;top: -14px;background-color: #f4f6f9;color: #9f9f9f;">افزودن عامل تاثیر گذار بر قیمت محصول</span>
        <div class="row" style="border: 1px #dedede solid;padding:35px 5px 35px 5px;border-radius: 10px">
            <div class="col-md-12">
                <form class="form-inline" method="post" enctype="multipart/form-data" @submit="formSubmit">

                    <label for="name" class="ml-3"> عنوان : </label>
                    <input type="text" name="title" class="form-control" v-model="form.name" autofocus id="name">

                    <label for="exampleFormControlSelect1" class="ml-3 mr-3">دسته بندی :</label>
                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.cat" @change="onChange()">
                        <option value="" disabled hidden>انتخاب کنید...</option>
                        <option v-for="cat in cats" :value="cat.id">
                            @{{ cat.name }}
                        </option>
                    </select>

                    <template v-if="flag">
                        <label for="exampleFormControlSelect1" class="ml-3 mr-3">برند :</label>
                        <select class="form-control" id="exampleFormControlSelect1" v-model="form.brand"
                                @change="onChange2()">
                            <option value="" disabled hidden>انتخاب کنید...</option>
                            <option v-for="brand in brands" :value="brand.id">
                                @{{ brand.name }}
                            </option>
                        </select>
                    </template>

                    <template v-if="flag2">
                        <label for="exampleFormControlSelect1" class="ml-3 mr-3">دسته عامل :</label>
                        <select class="form-control" id="exampleFormControlSelect1" v-model="form.effect_price">
                            <option value="" disabled hidden>انتخاب کنید...</option>
                            <option v-for="effect_price in effect_prices" :value="effect_price.id">
                                @{{ effect_price.name }}
                            </option>
                        </select>
                    </template>

                    <div class="form-check">
                        <button type="submit" class="btn btn-primary">ثبت</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3 mr-3">
                <span style="color: red"> @{{ error.name }} </span>
            </div>
            <div class="col-md-3">
                <span style="color: red"> @{{ error.cat }} </span>
            </div>
            <div class="col-md-3">
                <span style="color: red"> @{{ error.brand }} </span>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">دسته</th>
                        <th scope="col">برند</th>
                        <th scope="col">دسته عامل</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجو بر اساس نام">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.cat" @keyup="searchCat"
                                   placeholder="جستجو بر اساس دسته">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.brand" @keyup="searchBrand"
                                   placeholder="جستجو بر اساس برند">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.effect_price"
                                   @keyup="searchEffectPrice"
                                   placeholder="جستجو بر اساس دسته عامل">
                        </td>
                        <td></td>
                    </tr>
                    <tr v-for="(effect_spec,index) in effect_specs.data" :key="effect_spec.id">
                        <td>@{{effect_spec.name}}</td>
                        <td>@{{ effect_spec.cat.name }}</td>
                        <td>@{{ effect_spec.brand.name }}</td>
                        <td>@{{ effect_spec.effect_price.name }}</td>
                        <td>
                            <a @click="deleteEffectSpec(effect_spec.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-3">
            <pagination :data="effect_specs" @pagination-change-page="fetchEffectSpec" style="margin:auto"></pagination>
        </div>
    </div>
@endsection

@section('script')
    <script>

        var app = new Vue({
            el: '#area',
            data: {
                form: {
                    name: '',
                    cat: '',
                    brand: '',
                    effect_price: '',
                },
                search: {
                    brand: '',
                    name: '',
                    cat: '',
                    effect_price: '',
                },
                brands: '',
                effect_prices: [],
                cats: '',
                error: {
                    name: '',
                    cat: '',
                    brand: '',
                },
                data_results: [],
                flag: false,
                flag2: false,
                effect_specs: [],
            },
            methods: {
                fetchCat() {

                    this.$Progress.start();
                    let data = this;
                    axios.get('/admin/catspec/cat').then(res => {
                        data.cats = res.data;

                    });
                    this.$Progress.finish();
                },
                fetchEffectSpec(page = 1) {
                    let data = this;
                    axios.get('/admin/effect/spec/fetch?page=' + page).then(res => {
                        data.effect_specs = res.data;
                        console.log(data.effect_specs)
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    this.$Progress.start();
                    let data = this;
                    axios.post('/admin/effect/spec/store', {
                        name: this.form.name,
                        cat: this.form.cat,
                        brand: this.form.brand,
                        effect_price: this.form.effect_price,
                    })
                        .then(function () {
                            data.form.name = "";
                            data.form.cat = "";
                            data.form.brand = "";
                            data.form.effect_price = "";
                            data.error.name = "";
                            data.error.cat = "";
                            data.error.brand = "";
                            data.error.effect_price = "";

                            swal.fire(
                                {
                                    text: " با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                        })
                        .catch(function (error) {
                            data.error.name = "";
                            data.error.cat = "";
                            this.allerros = error.response.data.errors;
                            x = error.response.data.errors;

                            if (Array.isArray(x.name)) {
                                data.error.name = this.allerros.name[0];
                            }
                            if (Array.isArray(x.cat)) {
                                data.error.cat = this.allerros.cat[0];
                            }
                            if (Array.isArray(x.brand)) {
                                data.error.brand = this.allerros.brand[0];
                            }
                            if (Array.isArray(x.effect_price)) {
                                data.error.effect_price = this.allerros.effect_price[0];
                            }

                        });
                    this.fetchEffectSpec();
                    this.$Progress.finish();

                },
                deleteEffectSpec(id) {
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
                            axios.get(`/admin/effect/spec/delete/${id}`)
                                .then(() => {
                                    swal.fire(
                                        {
                                            text: " با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    this.fetchEffectSpec();
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
                    if (this.search.name.length > 0) {
                        axios.get('/admin/effect/spec/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.effect_specs = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchEffectSpec();
                    }
                },
                searchCat(page = 1) {
                    data = this;
                    if (this.search.cat.length > 0) {
                        axios.get('/admin/effect/spec/search?page=' + page, {params: {cat: this.search.cat}}).then(response => {
                            data.effect_specs = response.data;
                        });
                    }
                    if (this.search.cat.length === 0) {
                        this.fetchEffectSpec();
                    }
                },
                searchBrand(page = 1) {
                    data = this;
                    if (this.search.brand.length > 0) {
                        axios.get('/admin/effect/spec/search?page=' + page, {params: {brand: this.search.brand}}).then(response => {
                            data.effect_specs = response.data;
                        });
                    }
                    if (this.search.brand.length === 0) {
                        this.fetchEffectSpec();
                    }
                },
                searchEffectPrice(page = 1) {
                    data = this;
                    if (this.search.effect_price.length > 0) {
                        axios.get('/admin/effect/spec/search?page=' + page, {params: {effect_price: this.search.effect_price}}).then(response => {
                            data.effect_specs = response.data;
                        });
                    }
                    if (this.search.effect_price.length === 0) {
                        this.fetchEffectSpec();
                    }
                },
                onChange() {
                    this.flag = true;
                    y = this.form.cat;
                    let data = this;
                    console.log(y);
                    axios.get(`/admin/effect/brand/${y}`).then(res => {
                        data.brands = res.data;
                    });
                },
                onChange2() {
                    this.flag2 = true;
                    brandId = this.form.brand;
                    catId = this.form.cat;
                    let data = this;
                    axios.get(`/admin/effect/spec/brand/${brandId}/${catId}`).then(res => {
                        data.effect_prices = res.data;
                    });
                },
            },
            mounted: function () {
                this.fetchCat();
                this.fetchEffectSpec();
            }
        })
    </script>
    <script>
        $("#side_price").addClass("menu-open");
        $("#side_effect_spec_add").addClass("active");
    </script>
@endsection
@section('style')
    <style>
        .fa {
            font-size: 1.1rem;
        }
    </style>
@endsection

