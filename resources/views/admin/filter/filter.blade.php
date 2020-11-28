@extends('layouts.admin.admin')

@section('content')
    <div class="container mt-4" id="area">
        <div class="row">
            <div class="col-md-12">
                <div class="form-inline">
                    <label for="name" class="ml-3"> عنوان : </label>
                    <input type="text" name="title" class="form-control" v-model="form.name" autofocus id="name">

                    <label for="exampleFormControlSelect1" class="ml-3 mr-5">دسته بندی :</label>
                    <button @click="clickCatBtn" id="btn-cat">
                        @{{ cat }}
                        <i class="right fa fa-angle-down" id="angle-down"></i>
                    </button>

                    <div v-if="flag" id="sss">
                        <ul v-if="flag1">
                            <li style="line-height: 35px;"
                                @click="fetchChild(root.id,root.name)"
                                v-for="(root,index) in roots">
                                @{{ root.name }}
                                <i id="angle-left" class="right fa fa-angle-left"></i>
                            </li>
                        </ul>
                        <ul v-if="flag2">
                            <li style="color: #a0a0a0" @click="back(holder.parentName)">
                                <i class="right fa fa-angle-right"
                                   style="float: right;margin:11px 0 0 5px;"></i>
                                @{{ holder.parentName }}
                            </li>
                            <li style="margin-top: 10px" v-if="!childs.length"
                                @click="fixCat()">
                                             <span style="border-radius: 46px;color: white;margin-right: 15px;padding: 4px 13px;background-color: #007ac8;">
                                                                 @{{ holder.selfName }}
                                                            </span>
                            </li>
                            <li v-for="(child,index) in childs"
                                @click="fetchChild(child.id,child.name)"
                                style="margin-right: 10px;">
                                @{{ child.name }}
                                <i id="angle-left" v-if="child.children_recursive.length"
                                   class="right fa fa-angle-left"></i>
                            </li>
                        </ul>
                    </div>

                    <template v-if="fflag2">
                        <label for="exampleFormControlSelect1" class="ml-3 mr-3">دسته عامل :</label>
                        <select class="form-control" id="exampleFormControlSelect1" v-model="form.filter_cat">
                            <option value="" disabled hidden>انتخاب کنید...</option>
                            <option v-for="filter_cat in filter_cats" :value="filter_cat.id">
                                @{{ filter_cat.name }}
                            </option>
                        </select>
                    </template>

                    <div class="form-check">
                        <button type="button" @click="formSubmit" class="btn btn-primary">ثبت</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3 mr-3">
                <span style="color: red"> @{{ error.name }} </span>
            </div>
            <div class="col-md-3">
                <span style="color: red"> @{{ error.cat }} </span>
            </div>

        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">دسته</th>
                        <th scope="col">فیلتر دسته</th>
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
                            <input type="text" class="form-control" v-model="search.filter_cat"
                                   @keyup="searchEffectPrice"
                                   placeholder="جستجو بر اساس دسته عامل">
                        </td>
                        <td></td>
                    </tr>
                    <tr v-for="(filter,index) in filters.data">
                        <td>@{{filter.name}}</td>
                        <td>@{{ filter.cat.name }}</td>

                        <td>@{{ filter.filter_cat.name }}</td>
                        <td>
                            <a @click="deleteFilter(filter.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-2">
            <pagination :data="filters" @pagination-change-page="fetchFilter"></pagination>
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
                    cat: 'انتخاب کنید...',
                    filter_cat: '',
                },
                search: {
                    name: '',
                    cat: '',
                    filter_cat: '',
                },
                brands: '',
                filter_cats: [],
                cats: '',
                error: {
                    name: '',
                    cat: '',
                },
                data_results: [],
                fflag: false,
                fflag2: false,
                filters: [],
                cat: 'انتخاب کنید...',
                //tree
                holder: {
                    selfName: 'ریشه',
                    selfId: '',
                    parentName: '',
                    parentId: '',
                    grandName: 'ریشه',
                    grandId: '',
                },
                flag: false,
                flag1: true,
                flag2: false,
                roots: [],
                childs: [],

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
                fetchFilter(page = 1) {
                    let data = this;
                    axios.get('/admin/filter/fetch?page=' + page).then(res => {
                        data.filters = res.data;
                    });
                },
                deleteFilter(id) {
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
                            axios.get(`/admin/filter/delete/${id}`)
                                .then(() => {
                                    swal.fire(
                                        {
                                            text: "فیلتر ، با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    data.fetchFilter();
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
                async onChange2() {
                    await this.fetchCatId();
                    this.fflag2 = true;
                    let data = this;

                    axios.get(`/admin/filter/cat/${this.form.cat}`).then(res => {
                        data.filter_cats = res.data;
                        console.log(data.filter_cats);
                    });
                },

                clickCatBtn() {
                    if (this.flag === false) {
                        this.flag = true;
                    } else if (this.flag === true) {
                        this.flag = false
                    }
                },
                fetchRootCat() {
                    let data = this;
                    axios.get(`/admin/brand/fetch/cat/root`).then(res => {
                        data.roots = res.data;
                    });
                    this.holder.parentName = 'ریشه';
                    this.holder.parentId = '';
                    this.holder.grandName = 'ریشه';
                    this.holder.grandId = '';
                },
                fetchChild(id, name) {
                    let data = this;

                    this.holder.grandName = this.holder.parentName;
                    this.holder.grandId = this.holder.parentId;

                    this.holder.parentName = this.holder.selfName;
                    this.holder.parentId = this.holder.selfId;

                    this.holder.selfName = name;
                    this.holder.selfId = id;
                    axios.get(`/admin/brand/fetch/cat/child/${id}`).then(res => {
                        data.childs = res.data;
                        data.flag1 = false;
                        data.flag2 = true;
                    });
                },
                back(parent) {
                    let data = this;
                    if (parent === 'ریشه') {
                        this.flag1 = true;
                        this.flag2 = false;
                        this.holder.selfName = 'ریشه';
                        this.holder.selfId = '';
                        this.holder.parentName = '';
                        this.holder.parentId = '';
                        this.holder.grandName = '';
                        this.holder.grandId = '';
                        axios.get('/admin/mega/fetch/cat/root').then(res => {
                            data.roots = res.data;
                        });
                    } else {
                        axios.get(`/admin/mega/fetch/cat/child/${this.holder.parentId}`).then(res => {
                            data.childs = res.data;
                            data.holder.selfName = data.holder.parentName;
                            data.holder.selfId = data.holder.parentId;
                            data.holder.parentName = data.holder.grandName;
                            data.holder.parentId = data.holder.grandId;
                        });
                    }
                },
                fixCat() {
                    this.cat = this.holder.selfName;
                    this.flag = false;
                    this.onChange2();
                },
                async fetchCatId() {
                    let _this = this;
                    await axios.get(`/admin/product/fetch/cat/id/${_this.cat}`).then(res => {
                        _this.form.cat = res.data;
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    if(this.form.filter_cat==''){
                        swal.fire(
                            {
                                text: "لطفا دسته عامل را مشخص کنید .",
                                type: "warning",
                                confirmButtonText: 'باشه',
                            }
                        );
                    }else {
                        let data = this;
                        axios.post('/admin/filter/store', {
                            name: this.form.name,
                            cat: this.form.cat,
                            filter_cat: this.form.filter_cat,
                        })
                            .then(function () {
                                data.error.name = "";
                                data.error.cat = "";
                                data.error.filter_cat = "";

                                swal.fire(
                                    {
                                        text: " با موفقیت ثبت شد !",
                                        type: "success",
                                        confirmButtonText: 'باشه',
                                    }
                                );
                                data.fetchFilter();
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
                                if (Array.isArray(x.effect_price)) {
                                    data.error.effect_price = this.allerros.effect_price[0];
                                }

                            });
                        this.fetchFilter();
                    }
                },
            },
            mounted: function () {
                this.fetchCat();
                this.fetchFilter();
                this.fetchRootCat();
            },
            updated: function () {
                if (this.holder.parentName === this.holder.selfName) {
                    this.holder.parentName = 'ریشه';
                    this.holder.parentId = '';
                    this.holder.grandName = 'ریشه';
                    this.holder.grandId = '';
                }
            }
        })
    </script>
    <script>
        $("#side_filter").addClass("menu-open");
        $("#side_filter_index").addClass("active");
    </script>
@endsection

@section('style')
    <style>
        li {
            list-style: none
        }

        #btn-cat {
            position: relative;
            background-color: white;
            border: 1px solid #dee2e6;
            width: 200px;
            padding: 8px 8px 0 8px;
            border-radius: 7px;
            text-align: right;
            color: #484848;
        }

        #angle-down {
            float: left;
            margin: 6px 2px;
            color: #636363;
        }

        #sss {
            position: absolute;
            list-style: none;
            top: 39px;
            z-index: 99;
            right: 417px;
            background-color: white;
            padding: 5px 15px;
            width: 200px;
            line-height: 35px;
            box-shadow: 0px 10px 21px 0px rgba(0, 0, 0, 0.75);
        }

        #angle-left {
            float: left;
            margin-top: 10px;
            color: #636363;
        }

        #sss li {
            cursor: pointer
        }

        .fa {
            font-size: 1.1rem
        }

    </style>
@endsection

