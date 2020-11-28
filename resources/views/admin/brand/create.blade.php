@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-5 pb-5" id="area" style="position: relative">
        <span style="position: absolute;margin-right:10px;top: -14px;background-color: #f4f6f9;color: #9f9f9f;">افزودن برند</span>
        <div class="row" style="border: 1px #dedede solid;padding:35px 5px 0 5px;border-radius: 10px">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>دسته بندی :
                                    {{--                                    <span style="color: red">*</span>--}}
                                </label>
                                <br>
                                <button @click="clickCatBtn" id="btn-cat">
                                    @{{ form.name }}
                                    <i class="right fa fa-angle-down" id="angle-down"></i>
                                </button>

                                <div v-if="flag" id="sss">
                                    <ul v-if="flag1">
                                        <li style="color: black;font-weight: bold;background-color: #f1f1f1;padding-right: 6px;border-radius: 6px"
                                            @click="fixRoot()">
                                            ریشه
                                        </li>
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
                                        <li v-for="(child,index) in childs"
                                            @click="fetchChild(child.id,child.name)"
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
                                <label for="name" class="col-md-12 control-label">نام لاتین :
                                    {{--                                    <span style="color: red">*</span>--}}
                                </label>
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="form.name_e"
                                       autofocus>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="col-md-12 control-label">نام فارسی :
                                    {{--                                    <span style="color: red">*</span>--}}
                                </label>
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="form.name_f">
                            </div>
                        </div>
                        {{--                        <div class="col-md-3">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label for="email" class="col-md-4 control-label">توضیحات :</label>--}}
                        {{--                                <textarea class="form-control" v-model="form.description" rows="1"--}}
                        {{--                                          @click.once="empty()"--}}
                        {{--                                          name="editor1"></textarea>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="col-md-2" style="margin-top: 32px">
                            <div class="form-group">
                                {{--                                <label for="fileImage" id="label_file" class="btn btn-success"--}}
                                {{--                                       style="font-weight: lighter;margin-bottom: 0;position: relative">انتخاب عکس--}}
                                {{--                                </label>--}}
                                {{--                                <span style="position: absolute;top: 45px;left: 72px;font-size: 14px;color: #969696;">سایز = 500 * 500</span>--}}
                                {{--                                <input type="file" onchange="readURL(this);" style="display:none;" id="fileImage"--}}
                                {{--                                       name="fileImage" @change="onImageChange">--}}

                                <button type="button" class="btn btn-primary" @click="formSubmit">
                                    ثبت
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 ">
                            {{--                            <span style="color: red"> @{{ error.cat_id }} </span>--}}
                        </div>
                        <div class="col-md-2">
                            <span style="color: red"> @{{ error.name_e }} </span>
                        </div>
                        <div class="col-md-2">
                            <span style="color: red"> @{{ error.name_f }} </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">نام لاتین</th>
                        <th scope="col">نام فارسی</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" name="name" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجو بر اساس نام لاتین">
                        </td>
                        <td>

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr v-for="(brand,index) in brands.data" :key="brand.id">
                        <td>@{{brand.name}}</td>
                        <td>@{{brand.name_f}}</td>

                        <td>
                            <a class="btn btn-sm btn-primary ml-3" @click="showCat(brand.cats,brand.id)"
                               style="color: white">
                                ویرایش دسته
                            </a>

                            {{--                            <a @click="showImage(brand.id)" style="font-size: 20px;">--}}
                            {{--                                <i class="fa fa-image ml-3" style="color: #17a2b8;"></i>--}}
                            {{--                            </a>--}}

                            {{--                            <a @click="showDescription(brand.id,index)" style="font-size: 20px;">--}}
                            {{--                                <i class="fa fa-comment-alt ml-3" style="color: #17a2b8;"></i>--}}
                            {{--                            </a>--}}
                            <a @click="deleteBrand(brand.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-3">
            <pagination :data="brands" @pagination-change-page="fetchBrands" style="margin:auto"></pagination>
        </div>
        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-dialog-scrollable" role="document" style="max-width:100%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" @click="showModal = false">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="text-align: center">
                                <img v-if="pic" :src="'/images/brand/'+pic">
                                <p v-if="description">@{{ description }}</p>


                                <select v-if="modalCats" multiple name="artists2[]" v-model="selected_cats"
                                        style="width: 30%;height:80%">
                                    <option v-for="cat in cats" :value="cat.id">
                                        @{{ cat.name }}
                                    </option>
                                </select>
                                <br>
                                <br>
                                <button v-if="modalCats" type="button" class="btn btn-primary" @click="formSubmit2">
                                    ثبت
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
@endsection
@section('script')
    <script>
        new Vue({
            el: '#area',
            data: {
                selected_cats: [],
                category: '',
                cats: [],
                showModal: false,
                form: {
                    name_e: '',
                    name_f: '',
                    image: null,
                    description: '',
                    name: 'انتخاب کنید...',
                },
                search: {
                    id: '',
                    name: '',
                },
                error: {
                    name: '',
                    name_f: '',
                    name_e: '',
                    image: '',
                    description: '',
                },
                brands: [],
                pic: '',
                description: '',
                modalCats: false,
                brandHolder: '',
                editCat: '2',
                // tree
                categories: [],
                output: '',
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
                    this.form.name = this.holder.selfName;
                    this.flag = false;
                },
                fixRoot() {
                    this.form.name = 'ریشه';
                    this.flag = false;
                },
                fetchCat() {
                    let _this = this;
                    axios.get('/admin/catspec/cat').then(res => {
                        _this.cats = res.data;
                    });
                },
                onImageChange(e) {
                    this.form.image = e.target.files[0];
                },
                empty() {
                    this.form.description = "";
                },
                fetchBrands(page = 1) {
                    axios.get('/admin/brand/fetch?page=' + page).then(res => {
                        this.$data.brands = res.data;
                    });
                },
                deleteBrand(id) {
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

                            axios.get(`/admin/brand/delete/${id}`)
                                .then((res) => {

                                    if (res.data === "cant") {
                                        swal.fire(
                                            {
                                                text: "این برند دارای وابستگی می باشد و نمیتوان آن را حذف کرد",
                                                type: "warning",
                                                confirmButtonText: 'باشه',
                                            }
                                        );
                                    } else {
                                        swal.fire(
                                            {
                                                text: "این برند با موفقیت حذف شد !",
                                                type: "success",
                                                confirmButtonText: 'باشه',
                                            }
                                        );
                                        _this.fetchBrands();
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
                searchId(page = 1) {
                    data = this;
                    if (this.search.id.length > 0) {
                        axios.get('/admin/brand/search?page=' + page, {params: {id: this.search.id}}).then(response => {
                            data.brands = response.data;
                        });
                    }
                    if (this.search.id.length === 0) {
                        this.fetchBrands();
                    }
                },
                searchName(page = 1) {
                    data = this;
                    if (this.search.name.length > 0) {
                        axios.get('/admin/brand/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.brands = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchBrands();
                    }
                },
                showDescription(id, index) {
                    this.modalCats = false;
                    this.pic = '';
                    let data = this;
                    this.showModal = true;

                    axios.get(`/admin/brand/description/${id}`).then(function (res) {
                        data.description = res.data;

                    }).catch(function (error) {
                    });
                },
                showImage(id) {
                    this.modalCats = false;
                    this.description = '';
                    let data = this;
                    this.showModal = true;
                    this.pic = true;
                    axios.get(`/admin/brand/image/${id}`).then(function (res) {
                        data.pic = res.data;
                    }).catch(function (error) {
                    });
                },
                showCat(cats, brandId) {
                    this.description = '';
                    this.brandHolder = brandId;
                    let _this = this;
                    this.pic = false;
                    this.modalCats = true;
                    this.showModal = true;

                    arr = [];
                    Object.keys(cats).forEach(key => {
                        arr.push(cats[key].id);
                    });
                    this.selected_cats = arr;
                },
                formSubmit(e) {
                    e.preventDefault();

                    if (this.form.name === 'انتخاب کنید...') {
                        swal.fire(
                            {
                                text: "دسته بندی را مشخص کنید .",
                                type: "warning",
                                confirmButtonText: 'باشه',
                            }
                        );
                        return false;
                    }

                    let data = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };
                    let formData = new FormData();
                    formData.append('name', this.form.name);
                    formData.append('name_e', this.form.name_e);
                    formData.append('name_f', this.form.name_f);
                    formData.append('image', this.form.image);
                    formData.append('description', this.form.description);

                    axios.post('/admin/brand/store', formData, config)
                        .then(function (response) {
                            location.reload();
                        })
                        .catch(function (error) {
                            data.error.name_e = "";
                            data.error.name_f = "";
                            data.error.cat_id = "";

                            this.allerros = error.response.data.errors;
                            let x = error.response.data.errors;

                            if (Array.isArray(x.name_e)) {
                                data.error.name_e = this.allerros.name_e[0];
                            }

                            if (Array.isArray(x.name_f)) {
                                data.error.name_f = this.allerros.name_f[0];
                            }

                        });
                },
                formSubmit2(e) {
                    e.preventDefault();
                    let _this = this;
                    let formData = new FormData();
                    formData.append('cats', this.selected_cats);
                    formData.append('brand', this.brandHolder);

                    axios.post('/admin/brand/edit/cat', formData)
                        .then(function (response) {
                            location.reload();
                        });
                },
            },
            mounted: function () {
                this.fetchBrands();
                this.fetchCat();
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
        });
    </script>
    <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
        setTimeout(function () {
            $(document).ready(function () {
                $('#select-cat').multiselect({
                    nonSelectedText: 'انتخاب دسته',
                    nSelectedText: ' - تعداد انتخاب',
                    allSelectedText: 'تمام گزینه ها انتخاب شد',
                    numberDisplayed: 2
                });
            });
        }, 1500);
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(100)
                        .height(100);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $("#side_brand").addClass("menu-open");
        $("#side_brand_add").addClass("active");
    </script>
@endsection
@section('style')
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
            width: 100% !important;
            text-align: right !important;
            background-color: white;
            min-height: 26px !important;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .btn-group {
            width: 100% !important;
        }
    </style>
    <style>
        .modal-mask {
            position: fixed !important;
            z-index: 9998 !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100vh !important;
            background-color: rgba(0, 0, 0, .5) !important;
            display: table !important;
            transition: opacity .3s ease !important;
        }

        .modal-content {
            max-height: calc(100vh - -3.5rem) !important;
            height: 100vh
        }

        .fa {
            font-size: 1.1rem;
        }
    </style>
    <style>
        li {
            list-style: none
        }

        #btn-cat {
            position: relative;
            background-color: white;
            border: 1px solid #ced4da;
            width: 100%;
            padding: 8px 8px 0 8px;
            border-radius: 5px;
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
            top: 74px;
            z-index: 99;
            background-color: white;
            padding: 5px 15px;
            width: 100%;
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

        label {
            font-weight: unset !important;
        }

        button:focus {
            outline: rgba(122, 186, 255, 0.68) solid 2px !important;
        }
    </style>
@endsection
