@extends('layouts.admin.admin')
@section('title') مگا منو @endsection
@section('content')
    <div class="container" id="area">
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>دسته بندی :</label>
                                <button @click="clickCatBtn" id="btn-cat">
                                    @{{ form.name }}
                                    <i class="right fa fa-angle-down" id="angle-down"></i>
                                </button>
                                <div v-if="flag" id="sss">
                                    <ul v-if="flag1">
                                        <li style="line-height: 35px;" @click="fetchChild(root.id,root.name)"
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
                                        <li style="color: black;font-weight: bold;background-color: #f1f1f1;padding-right: 6px;border-radius: 6px"
                                            @click="fixCat()">@{{ holder.selfName }}
                                        </li>
                                        <li v-for="(child,index) in childs" @click="fetchChild(child.id,child.name)"
                                            style="margin-right: 10px;">
                                            @{{ child.name }}
                                            <i id="angle-left" v-if="child.children_recursive.length"
                                               class="right fa fa-angle-left"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>دسته مگامنو :</label>
                                <select class="form-control" v-model="form.megaCatId">
                                    <option value="" disabled hidden>انتخاب کنید...</option>
                                    <option v-for="megaCat in megaCats" :value="megaCat.id">@{{ megaCat.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>عنوان :</label>
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="form.title">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>اولویت :</label>
                                <input id="name" type="number" class="form-control" name="priority"
                                       v-model="form.priority">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color: #f4f6f9">e</label>
                                <button @click="formSubmit($event,'cat')" type="submit" class="btn btn-primary"
                                        style="display: block">
                                    ثبت
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" v-model="form.name">
                                    <option value="" disabled hidden>انتخاب برند...</option>
                                    <option v-for="brand in brands" :value="brand.name">@{{ brand.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" v-model="form.megaCatId">
                                    <option value="" disabled hidden>دسته مگامنو...</option>
                                    <option v-for="megaCat in megaCats" :value="megaCat.id">@{{ megaCat.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input id="name" type="text" class="form-control" name="name" placeholder="عنوان"
                                       v-model="form.title">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input id="name" type="number" class="form-control" name="priority" placeholder="اولویت"
                                       v-model="form.priority">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button @click="formSubmit($event,'brand')" type="submit" class="btn btn-primary">
                                    ثبت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">عنوان</th>
                        <th scope="col">دسته مگامنو</th>
                        <th scope="col">اولویت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(mega,index) in megas.data">
                        <td>@{{mega.name}}</td>
                        <td>@{{ mega.title }}</td>
                        <td>@{{ mega.mega_cat.name }}</td>
                        <td>@{{ mega.priority }}</td>
                        <td>
                            <a @click="deleteMega(mega.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-2">
            <pagination :data="megas" @pagination-change-page="fetchMegas"></pagination>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                holder: {
                    selfName: 'ریشه',
                    selfId: '',
                    parentName: '',
                    parentId: '',
                    grandName: 'ریشه',
                    grandId: '',
                },
                form: {
                    name: '',
                    title: '',
                    priority: 1,
                    brand: '',
                    megaCatId: '',
                },
                flag: false,
                flag1: true,
                flag2: false,
                roots: [],
                childs: [],
                brands: [],
                megas: [],
                megaCats: [],
            },
            methods: {
                clickCatBtn() {
                    if (this.flag === false) {
                        this.flag = true;
                    } else if (this.flag === true) {
                        this.flag = false
                    }
                },
                fetchRootCat() {
                    let data = this;
                    axios.get('/admin/mega/fetch/cat/root').then(res => {
                        data.roots = res.data;
                    });
                    this.holder.parentName = 'ریشه';
                    this.holder.parentId = '';
                    this.holder.grandName = 'ریشه';
                    this.holder.grandId = '';
                },
                fetchChild(id, name) {
                    let data = this;

                    data.holder.grandName = data.holder.parentName;
                    data.holder.grandId = data.holder.parentId;

                    data.holder.parentName = data.holder.selfName;
                    data.holder.parentId = data.holder.selfId;

                    data.holder.selfName = name;
                    data.holder.selfId = id;
                    axios.get(`/admin/mega/fetch/cat/child/${id}`).then(res => {
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
                    this.form.name = this.holder.selfName;
                    this.flag = false;
                },
                fetchBrands() {
                    let data = this;
                    axios.get('/admin/mega/fetch/brands').then(res => {
                        data.brands = res.data;
                    });
                },
                formSubmit(e,type) {
                    e.preventDefault();
                    let data = this;
                    axios.post('/admin/mega/store', {
                        name: this.form.name,
                        title: this.form.title,
                        priority: this.form.priority,
                        type: type,
                        mega_cat_id: this.form.megaCatId,
                    }).then(function (response) {
                        swal.fire(
                            {
                                text: " با موفقیت ثبت شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                    }).catch(function (error) {

                    });
                    this.fetchMegas();
                },
                fetchMegas(page = 1) {
                    let data = this;
                    axios.get('/admin/megas/fetch?page=' + page).then(res => {
                        data.megas = res.data;
                    });
                },
                deleteMega(id) {
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
                            axios.get(`/admin/mega/delete/${id}`)
                                .then(() => {
                                    swal.fire(
                                        {
                                            text: " با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    this.fetchMegas();
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
                fetchMegaCats() {
                    let data = this;
                    axios.get('/admin/mega/fetch/megacats').then(res => {
                        data.megaCats = res.data;
                        console.log(data.megaCats)
                    });
                },
            },
            mounted: function () {
                this.fetchRootCat();
                this.fetchBrands();
                this.fetchMegas();
                this.fetchMegaCats();
            },
            updated: function () {
                if (this.holder.parentName === this.holder.selfName) {
                    this.holder.parentName = 'ریشه';
                    this.holder.parentId = '';
                    this.holder.grandName = 'ریشه';
                    this.holder.grandId = '';
                }
            }
        });
    </script>
    <script>
        $("#side_mega").addClass("menu-open");
        $("#side_maga_item").addClass("active");
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
            width: 170px;
            padding: 6px 10px;
            border-radius: 7px;
            text-align: right;
        }

        #angle-down {
            float: left;
            margin: 6px 2px;
            color: #636363;
        }

        #sss {
            position: absolute;
            list-style: none;
            top: 74px;
            z-index: 99;
            background-color: white;
            padding: 5px 15px;
            width: 167px;
            line-height: 35px;
        }

        #angle-left {
            float: left;
            margin-top: 10px;
            color: #636363;
        }

        #sss li {
            cursor: pointer
        }
    </style>
@endsection
