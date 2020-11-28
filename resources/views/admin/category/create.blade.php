@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-5" id="area">
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <span
                        style="position: absolute;margin-right:10px;top: -14px;background-color: #f4f6f9;color: #9f9f9f;">افزودن دسته بندی</span>
                    <div style="border: 1px #dedede solid;padding:35px 5px 15px 5px;border-radius: 10px" class="row">
                        {{--                        <div class="col-md-2">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label>--}}
                        {{--                                    نوع :--}}
                        {{--                                    <span style="color: red">*</span>--}}
                        {{--                                </label>--}}
                        {{--                                <select class="form-control" v-model="form.type" @change="changeType($event)">--}}
                        {{--                                    <option value="" disabled hidden>انتخاب کنید...</option>--}}
                        {{--                                    <option value="محصول">محصول</option>--}}
                        {{--                                    <option value="بلاگ">بلاگ</option>--}}
                        {{--                                    <option value="صفحه">صفحه</option>--}}
                        {{--                                </select>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>دسته والد :
{{--                                    <span style="color: red">*</span>--}}
                                </label><br>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>نام دسته :
{{--                                    <span style="color: red">*</span>--}}
                                </label>
                                <input type="text" class="form-control" v-model="form.title">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label>برند :</label><br>
                                <button @click="clickBrandBtn" id="btn-cat">
                                    <template v-show="form.brands.length"> @{{ form.brands }}</template>
                                    <i class="right fa fa-angle-down" id="angle-down"></i>
                                </button>
                                <div v-show="flagBrand" id="sss">
                                    <input type="text" v-model="brandSearch"
                                           id="input-search"
                                           @keyup="searchBrand"
                                           placeholder="جستجو...">
                                    <ul v-show="flagBrand1">
                                        <li style="line-height: 35px;" @click="selectBrand(brand.name,brand.id)"
                                            v-for="(brand,index) in brands"
                                            :id="'brand-id'+brand.id">
                                            <span>@{{ brand.name }}</span>
                                            <span style="float: left">@{{ brand.name_f }}</span>
                                        </li>
                                        <li v-show="!brands.length">
                                            <span style="color: red">موردی یافت نشد</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        {{--                        <div class="col-md-4">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <div class="mb-3">--}}
                        {{--                                    <label>توضیحات :</label>--}}
                        {{--                                    <textarea class="form-control" v-model="form.description" rows="1"--}}
                        {{--                                              name="category_description" style="width: 100%">لطفا متن مورد نظر خودتان را وارد کنید</textarea>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="col-md-2" style="margin-top: 32px">
                            <div class="form-group">
                                {{--                                <label for="fileImage" id="label_file" class="btn btn-success"--}}
                                {{--                                       style="font-weight: lighter;margin-bottom: 0">انتخاب عکس--}}
                                {{--                                </label>--}}
                                {{--                                <input type="file" onchange="readURL(this);" style="display:none;" id="fileImage"--}}
                                {{--                                       name="fileImage" @change="onImageChange">--}}
                                <button type="button" class="btn btn-primary" @click="formSubmit">
                                    ثبت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="widget" style="text-align: right">
                    <ul id="categories">
                        <template v-for="(cat,key,index) in cats">
                            <li style="font-size:14px;">
                                <input v-on:keydown.enter.prevent="redirectFilter($event,cat.id)"
                                       :value="cat.name"
                                       style="border: unset;background-color: #f4f6f9;color: #c40316;font-weight: bold;display:inline-block; ">
                                <item :cat="cat"></item>
                            </li>
                            <hr v-if="cats.length !== key+1"
                                style="margin-top: .7rem;margin-bottom: .7rem">
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        Vue.component('item', {
            name: 'item',
            props: ['cat'],
            template: '<ul style="margin-bottom:8px;margin-top:8px">' +
                '<li v-for="item in cat.children_recursive" style="margin-right:15px;text-align: right;font-size:14px;margin-bottom: 10px;">' +
                '<i class="fas fa-chevron-left" style="margin-left: 3px;font-size: 12px;color: #afafaf;"></i>' +
                '<input v-on:keydown.enter.prevent="redirectFilter($event,item.id)" :value="item.name" style="border: unset;background-color: #f4f6f9;">' +
                '<item :cat="item"></item></li></ul>',
            methods: {
                redirectFilter(e, id) {
                    if (e.target.value == '') {
                        this.deleteCategory(id);
                    } else {
                        let formData = new FormData();
                        formData.append('name', e.target.value);
                        formData.append('id', id);

                        axios.post('/admin/category/edit', formData)
                            .then(function (response) {
                                location.reload();
                            });
                    }
                },
                deleteCategory(id) {
                    let obj = this;
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
                            axios.get(`/admin/category/delete/${id}`)
                                .then((res) => {
                                    if (res.data === "cant") {
                                        swal.fire(
                                            {
                                                text: "این دسته دارای وابستگی می باشد و نمیتوان آن را حذف کرد",
                                                type: "warning",
                                                confirmButtonText: 'باشه',
                                            }
                                        );
                                        setTimeout(function () {
                                            location.reload();
                                        }, 3000);
                                    } else {
                                        location.reload();
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
            }
        });

        new Vue({
            el: '#area',
            data: {
                form: {
                    name: 'انتخاب کنید...',
                    title: '',
                    description: '',
                    image: null,
                    type: '',
                    brands: [],
                },
                selected: "selected",
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
                search: {
                    name: '',
                },
                categories2: [],
                parents: '',
                parentname: [],
                parpar: [],
                error: {
                    name: '',
                    parent: '',
                },
                data_results: [],
                brands: [],
                showModal: false,
                cats: [],
                catHolder: '',
                flagBrand: false,
                flagBrand1: true,
                holderBrandId: [],
                brandSearch: '',
            },
            methods: {
                searchBrand() {
                    let _this = this;
                    if (this.brandSearch === '') {
                        this.fetchBrands();
                    } else {
                        axios.get(`/admin/category/search/brand/${this.brandSearch}`).then(response => {
                            _this.brands = response.data;
                        });
                    }
                },
                redirectFilter(e, id) {
                    if (e.target.value == '') {
                        this.deleteCategory(id);
                    } else {
                        let formData = new FormData();
                        formData.append('name', e.target.value);
                        formData.append('id', id);

                        axios.post('/admin/category/edit', formData)
                            .then(function (response) {
                                location.reload();
                            });
                    }
                },
                deleteCategory(id) {
                    let obj = this;
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
                            axios.get(`/admin/category/delete/${id}`)
                                .then((res) => {
                                    if (res.data === "cant") {
                                        swal.fire(
                                            {
                                                text: "این دسته دارای وابستگی می باشد و نمیتوان آن را حذف کرد",
                                                type: "warning",
                                                confirmButtonText: 'باشه',
                                            }
                                        );
                                        setTimeout(function () {
                                            location.reload();
                                        }, 3000);
                                    } else {
                                        location.reload();
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
                fetchCats() {
                    let data = this;
                    axios.get('/fetch/search/cats').then(function (res) {
                        data.cats = res.data;
                    });
                },
                fetchCategories() {
                    let data = this;
                    axios.get('/admin/category/fetch')
                        .then(res => {
                            data.categories = res.data;
                        });
                },
                clickCatBtn() {
                    if (this.flag === false) {
                        this.flag = true;
                    } else if (this.flag === true) {
                        this.flag = false
                    }
                },
                clickBrandBtn() {
                    if (this.flagBrand === false) {
                        this.flagBrand = true;
                    } else if (this.flagBrand === true) {
                        this.flagBrand = false
                    }
                },
                selectBrand(name, id) {
                    existInHolder = false;
                    existBrand = false;

                    this.holderBrandId.forEach(function (item) {
                        if (item === id) {
                            existInHolder = true;
                        }
                    });

                    this.form.brands.forEach(function (item) {
                        if (item === name) {
                            existBrand = true;
                        }
                    });

                    if (existInHolder) {
                        for (var i = 0; i < this.holderBrandId.length; i++) {
                            if (this.holderBrandId[i] === id) {
                                this.holderBrandId.splice(i, 1);
                            }
                        }

                    } else {
                        this.holderBrandId.push(id);
                    }

                    if (existBrand) {
                        for (var i = 0; i < this.form.brands.length; i++) {
                            if (this.form.brands[i] === name) {
                                this.form.brands.splice(i, 1);
                            }
                        }
                    } else {
                        this.form.brands.push(name);
                    }
                },
                fetchRootCat(type) {
                    let data = this;
                    axios.get(`/admin/category/fetch/cat/root/${type}`).then(res => {
                        data.roots = res.data;
                    });
                    this.holder.parentName = 'ریشه';
                    this.holder.parentId = '';
                    this.holder.grandName = 'ریشه';
                    this.holder.grandId = '';
                },
                fetchChild(id, name) {
                    let data = this;
                    let type = 'محصول';

                    data.holder.grandName = data.holder.parentName;
                    data.holder.grandId = data.holder.parentId;

                    data.holder.parentName = data.holder.selfName;
                    data.holder.parentId = data.holder.selfId;

                    data.holder.selfName = name;
                    data.holder.selfId = id;
                    axios.get(`/admin/category/fetch/cat/child/${id}/${type}`).then(res => {
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
                onImageChange(e) {
                    this.form.image = e.target.files[0];
                },
                searchName() {
                    data = this;
                    if (this.search.name.length > 0) {
                        axios.get('/admin/category/search', {params: {name: this.search.name}}).then(response => {
                            data.categories2 = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchCategories2();
                    }
                },
                changeType(event) {
                    this.fetchRootCat(event.target.value);
                },
                fetchBrands() {
                    let _this = this;
                    axios.get('/admin/category/fetch/brand').then(res => {
                        _this.brands = res.data;
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    if (this.form.name === 'انتخاب کنید...' || this.form.title === '') {
                        swal.fire(
                            {
                                text: "دسته والد و نام دسته را وارد کنید",
                                type: "warning",
                                confirmButtonText: 'باشه',
                            }
                        );
                    } else {
                        let _this = this;
                        const config = {
                            headers: {'content-type': 'multipart/form-data'}
                        };

                        let formData = new FormData();
                        formData.append('name', this.form.title);
                        formData.append('description', this.form.description);
                        formData.append('parent', this.form.name);
                        formData.append('image', this.form.image);
                        formData.append('type', this.form.type);
                        formData.append('brand_id', this.holderBrandId);

                        axios.post('/admin/category/store', formData, config)
                            .then(function (response) {
                                location.reload();
                            })
                            .catch(function () {

                            });
                    }
                },
            },
            mounted: function () {
                this.fetchBrands();
                this.fetchCats();
                this.fetchRootCat('محصول');
            },
            updated: function () {

                for (var i = 0; i < this.brands.length; i++) {
                    $(`#brand-id${this.brands[i].id}`).removeClass("brand-select");
                }

                for (var j = 0; j < this.holderBrandId.length; j++) {
                    $(`#brand-id${this.holderBrandId[j]}`).addClass("brand-select");
                }


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
        $("#category_image").click(function () {
            $("input[id='category_file']").click();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#category_image').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        $("#side_category").addClass("menu-open");
        $("#side_category_add").addClass("active");
    </script>
@endsection

@section('style')
    <style>
        #input-search {
            display: block;
            border-bottom: 1px solid gray;
            border-left: unset;
            border-right: unset;
            border-top: unset;
            width: 100%;
            margin-bottom: 10px;
        }

        .brand-select {
            line-height: 35px;
            padding: 0px 10px;
            border-radius: 5px;
            background-color: #358fdc;
            color: white;
            margin-top: 2px;
            margin-bottom: 2px;
            transition: all 0.3s;
        }

        #categories {
            cursor: pointer;
            user-select: none
        }

        #categories > li {
            position: relative;
        }

        #categories > li ul > li {
            position: relative;
        }

        #area {
            text-align: right
        }

        #price {
            text-decoration-line: line-through;
            display: inline-block;
            float: left;
            font-size: 14px;
            margin-right: 12px;
        }

        .price {
            display: inline-block;
            float: right;
        }

        .pro_name {
            line-height: 28px;
        }

        .nav-link {
            padding: 5px 10px !important;
        }

        .dropdown-menu-right, .dropdown-menu {
            text-align: right
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
            height: 41px;
            overflow: hidden;
        }

        #angle-down {
            float: left;
            margin: 6px 2px;
            color: #636363;
        }

        #sss {
            position: absolute;
            list-style: none;
            top: 73px;
            z-index: 99;
            background-color: white;
            padding: 5px 15px;
            width: 100%;
            line-height: 35px;
            border: 1px solid #c8c8c8;
            overflow-x: hidden;
            max-height: 350px;
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

        label{
            font-weight: unset !important;
        }
        button:focus {
            outline: rgba(122, 186, 255, 0.68) solid 2px !important;
        }
    </style>
@endsection
