@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-5 pb-5" id="area" style="position: relative">
        <span style="position: absolute;margin-right:10px;top: -14px;background-color: #f4f6f9;color: #9f9f9f;">افزودن دسته عامل تاثیر گذار بر قیمت</span>
        <div class="row" style="border: 1px #dedede solid;padding:35px 5px 35px 5px;border-radius: 10px">
            <div class="col-md-12">
                <form class="form-inline" method="post" enctype="multipart/form-data" @submit="formSubmit">

                    <label for="name" class="ml-3"> عنوان : </label>
                    <input type="text" name="title" class="form-control" v-model="form.name" autofocus id="name">

                    <label for="exampleFormControlSelect1" class="ml-3 mr-5">دسته بندی :</label>
                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.cat" @change="onChange()">
                        <option value="" disabled hidden>انتخاب کنید...</option>
                        <option v-for="cat in cats" :value="cat.id">
                            @{{ cat.name }}
                        </option>
                    </select>

                    <template v-if="flag">
                        <label for="exampleFormControlSelect1" class="ml-3 mr-5">برند :</label>
                        <select class="form-control" id="exampleFormControlSelect1" v-model="form.brand">
                            <option value="" disabled hidden>انتخاب کنید...</option>
                            <option v-for="brand in brands" :value="brand.id">
                                @{{ brand.name }}
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
                        <td></td>
                    </tr>
                    <tr v-for="(effect,index) in effects.data" :key="effect.id">
                        <td>@{{effect.name}}</td>
                        <td>@{{ effect.cat.name }}</td>
                        <td>@{{ effect.brand.name }}</td>
                        <td>
                            <a @click="deleteEffectPrice(effect.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-3">
            <pagination :data="effects" @pagination-change-page="fetchEffectPrice" style="margin:auto"></pagination>
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
                },
                search: {
                    brand: '',
                    name: '',
                    cat: '',
                },
                brands: '',
                cats: '',
                error: {
                    name: '',
                    cat: '',
                    brand: '',
                },
                data_results: [],
                flag: false,
                effects: []
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
                fetchEffectPrice(page = 1) {
                    let data = this;
                    axios.get('/admin/effect/fetch?page=' + page).then(res => {
                        data.effects = res.data;
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    this.$Progress.start();
                    let data = this;
                    axios.post('/admin/effect/store', {
                        name: this.form.name,
                        cat: this.form.cat,
                        brand: this.form.brand,
                    }).then(function (response) {
                        if (response.data === 'iterate') {
                            data.form.name = "";
                            data.form.cat = "";
                            data.form.brand = "";
                            data.error.name = "";
                            data.error.cat = "";
                            data.error.brand = "";
                            swal.fire(
                                {
                                    text: " برای این دسته و برند قبلا ثبت شده است  !",
                                    type: "error",
                                    confirmButtonText: 'باشه',
                                }
                            );
                        }else {
                            data.form.name = "";
                            data.form.cat = "";
                            data.form.brand = "";
                            data.error.name = "";
                            data.error.cat = "";
                            data.error.brand = "";
                            swal.fire(
                                {
                                    text: " با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );


                            this.fetchEffectPrice();

                        }
                    }).catch(function (error) {
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

                    });
                    this.fetchEffectPrice();
                    this.$Progress.finish();
                },
                deleteEffectPrice(id) {
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
                            axios.get(`/admin/effect/delete/${id}`)
                                .then((res) => {
                                    if (res.data === "cant") {
                                        swal.fire(
                                            {
                                                text: "این دسته دارای وابستگی می باشد و نمیتوان آن را حذف کرد",
                                                type: "warning",
                                                confirmButtonText: 'باشه',
                                            }
                                        );
                                    }else {
                                        swal.fire(
                                            {
                                                text: "این دسته با موفقیت حذف شد !",
                                                type: "success",
                                                confirmButtonText: 'باشه',
                                            }
                                        );
                                        this.fetchEffectPrice();
                                    }
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
                        axios.get('/admin/effect/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.effects = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchEffectPrice();
                    }
                },
                searchCat(page = 1) {
                    data = this;
                    if (this.search.cat.length > 0) {
                        axios.get('/admin/effect/search?page=' + page, {params: {cat: this.search.cat}}).then(response => {
                            data.effects = response.data;
                        });
                    }
                    if (this.search.cat.length === 0) {
                        this.fetchEffectPrice();
                    }
                },
                searchBrand(page = 1) {
                    data = this;
                    if (this.search.brand.length > 0) {
                        axios.get('/admin/effect/search?page=' + page, {params: {brand: this.search.brand}}).then(response => {
                            data.effects = response.data;
                        });
                    }
                    if (this.search.brand.length === 0) {
                        this.fetchEffectPrice();
                    }
                },
                onChange() {
                    this.flag = true;
                    y = this.form.cat;
                    let data = this;
                    axios.get(`/admin/effect/brand/${y}`).then(res => {
                        data.brands = res.data;
                    });
                },
            },
            mounted: function () {
                this.fetchCat();
                this.fetchEffectPrice();
            }
        })
    </script>
    <script>
        $("#side_price").addClass("menu-open");
        $("#side_effect_price").addClass("active");
    </script>
@endsection

@section('style')
    <style>
        .fa {
            font-size: 1.1rem;
        }
    </style>
@endsection

