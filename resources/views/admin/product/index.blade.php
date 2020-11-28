@extends('layouts.admin.admin')
@section('title') محصولات @endsection
@section('content')
    <div class="container-fluid mt-4" id="area">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>دسته</th>
                        <th>نام</th>
                        <th>برند</th>
                        <th>قیمت</th>
                        <th>تاریخ</th>
                        <th>
                            <span>@{{ products.total }}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            {{--<select class="form-control" v-model="search.cat" @change="searchCat()">--}}
                            {{--<option value="" disabled hidden>انتخاب کنید...</option>--}}
                            {{--<option value="999999">همه دسته ها</option>--}}
                            {{--<option v-for="cat in cats" :value="cat.id">@{{ cat.name }}</option>--}}
                            {{--</select>--}}
                            <button @click="clickCatBtn" id="btn-cat">
                                @{{ form.cat }}
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
                                             <span
                                                 style="border-radius: 46px;color: white;margin-right: 15px;padding: 4px 13px;background-color: #007ac8;">
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
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجو بر اساس نام">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.brand"
                                   @keyup="searchBrand" placeholder="جستجو بر اساس برند">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.price" style="direction: ltr;"
                                   @keyup="searchPrice" placeholder="جستجو بر اساس قیمت">
                            <input type="text" class="form-control" v-model="search.less" v-if="fflag"
                                   style="direction: ltr;"
                                   @keyup="searchLess" placeholder="قیمت های کمتر از">
                            <input type="text" class="form-control" v-model="search.more" v-if="fflag"
                                   style="direction: ltr;"
                                   @keyup="searchMore" placeholder="قیمت های بیشتر از">
                        </td>

                        <td>
                            <input type="text" class="form-control" v-model="search.shamsi_c" style="direction: ltr;"
                                   @keyup="searchShamsi_c" placeholder="جستجوی تاریخ ">
                            <input type="text" class="form-control" v-model="search.shamsiless" v-if="fflag"
                                   style="direction: ltr;"
                                   @keyup="searchShamsiLess" placeholder="تاریخ های قبل از">
                            <input type="text" class="form-control" v-model="search.shamsimore" v-if="fflag"
                                   style="direction: ltr;"
                                   @keyup="searchShamsiMore" placeholder="تاریخ های بعد از">
                        </td>
                        <td>

                            <i v-if="pluss" class="fa fa-plus" style="color: #888888;float: left;cursor: pointer"
                               @click="toggleFlag()"></i>
                            <i v-if="pluss2" class="fa fa-minus" style="color: #888888;float: left;cursor: pointer"
                               @click="toggleFlag()"></i>
                        </td>
                    </tr>
                    <tr v-for="(product,index) in products.data">
                        <td>@{{product.cat.name}}</td>
                        <td>@{{product.name}}</td>
                        <td>@{{product.brand}}</td>

                        <td @dblclick="editPrice(product.id,product.price,product.discount)">
                            <span :id="'price'+product.id">
                                @{{numberFormat(product.price)}}
                            </span>

                            <div :class="'input'+product.id" class="display-none">
                                <span style="color: #7d7d7d">قیمت پایه :</span>
                                <input type="number" :id="'inputPrice'+product.id"
                                       style="direction: ltr;padding: 0 0 0 8px;width: 100%;border: 1px solid #d0d0d0;"
                                       v-model="product.price" @keyup="changePrice(product.id,index)"
                                       @keyup.enter="SubmitEditPrice(product.id,index)">
                                <br><br>
                                <span style="color: #7d7d7d">قیمت پس از تخفیف :</span>
                                <input @keyup="calDiscount(index)" v-model="form.afterDiscount"
                                       type="number"
                                       style="direction: ltr;padding: 0 0 0 8px;width: 100%;border: 1px solid #d0d0d0;"
                                       @keyup.enter="SubmitEditPrice(product.id,index)">
                                <br><br>
                                <span style="color: #7d7d7d">تخفیف :</span>
                                <input type="number" :id="'inputDiscount'+product.id"
                                       style="direction: ltr;padding: 0 0 0 8px;width: 100%;border: 1px solid #d0d0d0;"
                                       @keyup="calDiscountPrice2(product.id)"
                                       v-model="product.discount"
                                       @keyup.enter="SubmitEditPrice(product.id,index)">
                            </div>

                        </td>

                        <td>@{{product.shamsi_c}}</td>
                        <td>
                            <a @click="editProduct(product.id)" style="font-size: 20px;" class="ml-2">
                                <i class="fa fa-edit" style="color: #28a745"></i>
                            </a>
                            <a @click="deleteProduct(product.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <pagination :data="products" @pagination-change-page="fetchProducts" style="margin:auto"></pagination>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                flagPrice: true,
                flagPriceInput: false,
                pluss: true,
                pluss2: false,
                fflag: false,
                fflag2: false,
                fflag3: false,
                showModal: false,
                cats: false,
                search: {
                    id: '',
                    name: '',
                    brand: '',
                    shamsi_c: '',
                    exist: '',
                    existless: '',
                    existmore: '',
                    shamsiless: '',
                    shamsimore: '',
                    more: '',
                    less: '',
                    price: '',
                    cat: '',
                },
                description: '',
                products: [],
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
                form: {
                    cat: 'انتخاب کنید...',
                    afterDiscount: '',
                },
                holderPriceId: '',
                holderPrice: '',
                holderDiscount: '',

            },
            methods: {
                calDiscount(index) {
                    if (this.products.data[index].price == '') {
                        swal.fire(
                            {
                                text: 'لطفا ابتدا قیمت پایه را وارد کنید .',
                                type: 'warning',
                                confirmButtonText: 'باشه',
                            }
                        );
                        this.form.afterDiscount = '';
                    } else {
                        per = this.products.data[index].price / 100;

                        x = this.form.afterDiscount / per;
                        y = 100 - x;
                        this.products.data[index].discount = Math.round(y);
                    }
                },
                calDiscountPrice(price, discount) {
                    per = price / 100;
                    x = 100 - discount;
                    y = x * per;

                    this.form.afterDiscount = Math.round(y);
                },
                calDiscountPrice2(id) {
                    per = $(`#inputPrice${id}`).val() / 100;
                    x = 100 - $(`#inputDiscount${id}`).val();
                    y = x * per;

                    this.form.afterDiscount = Math.round(y);
                },
                changePrice(id, index) {
                    this.form.afterDiscount = null;
                    this.products.data[index].discount = null;
                },
                editPrice(id, price, discount) {
                    this.holderPrice = price;
                    this.holderDiscount = discount;

                    $(`.input${this.holderPriceId}`).addClass("display-none");
                    $(`#price${this.holderPriceId}`).removeClass("display-none");

                    $(`#price${id}`).addClass("display-none");
                    $(`.input${id}`).removeClass("display-none");
                    $(`#inputPrice${id}`).select();

                    this.holderPriceId = id;

                    this.calDiscountPrice(price, discount);
                },
                SubmitEditPrice(id,index) {
                    if (this.products.data[index].discount == null) {
                        swal.fire(
                            {
                                text: "تخفیف یا قیمت پس از تخفیف را وارد کنید .",
                                type: "warning",
                                confirmButtonText: 'باشه',
                            }
                        );
                        return false;
                    }

                    let formData = new FormData();
                    formData.append('id', id);
                    formData.append('price', $(`#inputPrice${id}`).val());
                    formData.append('discount', $(`#inputDiscount${id}`).val());

                    axios.post('/admin/product/edit/price', formData)
                        .then(function (response) {
                            swal.fire(
                                {
                                    type: "success",
                                    position: 'center',
                                    icon: 'success',
                                    title: ' با موفقیت ثبت شد !',
                                    showConfirmButton: false,
                                    timer: 2000
                                }
                            );
                        });
                },
                editProduct(id) {
                    window.location.href = `/admin/product/edit/${id}`;
                },
                fetchProducts(page = 1) {
                    let data = this;
                    axios.get('/admin/product/aaa/fetch?page=' + page).then(res => {
                        data.products = res.data;
                    });
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
                    if (this.fflag === false) {
                        this.fflag = true;
                    } else {
                        if (this.fflag === true) {
                            this.fflag = false;
                        }
                    }
                },
                async searchCat(page = 1) {
                    await this.fetchCatId();

                    console.log(this.search.cat);

                    this.search.name = '';
                    data = this;
                    if (this.search.cat > 0) {
                        await axios.get('/admin/product/a/search?page=' + page, {
                            params: {
                                cat: this.search.cat,
                                brand: this.search.brand,
                                price: this.search.price,
                                less: this.search.less,
                                more: this.search.more,
                                exist: this.search.exist,
                                shamsi_c: this.search.shamsi_c,
                            }
                        }).then(response => {
                            data.products = response.data;
                        });
                    }
                },
                searchName(page = 1) {
                    this.search.cat = '';
                    this.search.brand = '';
                    this.search.shamsi_c = '';
                    this.search.exist = '';
                    this.search.less = '';
                    this.search.more = '';
                    data = this;
                    if (this.search.name.length > 0) {
                        axios.get('/admin/product/a/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.products = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchProducts();
                    }
                },
                searchBrand(page = 1) {
                    this.search.name = '';
                    data = this;
                    if (this.search.brand.length > 0) {
                        axios.get('/admin/product/a/search?page=' + page, {
                            params: {
                                price: this.search.price,
                                brand: this.search.brand,
                                cat: this.search.cat,
                                less: this.search.less,
                                more: this.search.more,
                                exist: this.search.exist,
                                shamsi_c: this.shamsi_c,
                            }
                        }).then(response => {
                            data.products = response.data;
                        });
                    }
                    if (this.search.brand.length === 0) {
                        this.fetchProducts();
                    }
                },
                searchShamsi_c(page = 1) {
                    this.search.name = '';
                    this.search.id = '';
                    data = this;
                    if (this.search.shamsi_c.length > 0) {
                        axios.get('/admin/product/a/search?page=' + page, {params: {shamsi_c: this.search.shamsi_c}}).then(response => {
                            data.products = response.data;
                        });
                    }
                    if (this.search.shamsi_c.length === 0) {
                        this.fetchProducts();
                    }
                },
                searchLess(page = 1) {
                    this.search.name = '';
                    this.search.id = '';
                    this.search.more = '';
                    this.search.price = '';
                    data = this;
                    if (this.search.less.length > 0) {
                        axios.get('/admin/product/a/search?page=' + page, {
                            params: {
                                less: this.search.less,
                                brand: this.search.brand,
                            }
                        }).then(response => {
                            data.products = response.data;
                        });
                    }
                    if (this.search.less.length === 0) {
                        this.fetchProducts();
                    }
                },
                searchMore(page = 1) {
                    this.search.name = '';
                    this.search.id = '';
                    this.search.less = '';
                    this.search.price = '';
                    data = this;
                    if (this.search.more.length > 0) {
                        axios.get('/admin/product/a/search?page=' + page, {
                            params: {
                                more: this.search.more, brand: this.search.brand,
                            }
                        }).then(response => {
                            data.products = response.data;
                        });
                    }
                    if (this.search.more.length === 0) {
                        this.fetchProducts();
                    }
                },
                searchPrice(page = 1) {
                    this.search.name = '';
                    this.search.id = '';
                    this.search.less = '';
                    this.search.more = '';
                    data = this;
                    if (this.search.price.length > 0) {
                        axios.get('/admin/product/a/search?page=' + page, {
                            params: {
                                price: this.search.price, brand: this.search.brand,
                            }
                        }).then(response => {
                            data.products = response.data;
                        });
                    }
                    if (this.search.price.length === 0) {
                        this.fetchProducts();
                    }
                },
                searchShamsiLess(page = 1) {
                    this.search.name = '';
                    data = this;
                    if (this.search.shamsiless.length > 7) {
                        axios.get('/admin/product/a/search?page=' + page, {params: {shamsiless: this.search.shamsiless}}).then(response => {
                            data.products = response.data;
                        });
                    }
                    if (this.search.shamsiless.length === 0) {
                        this.fetchProducts();
                    }
                },
                searchShamsiMore(page = 1) {
                    this.search.name = '';
                    data = this;
                    if (this.search.shamsimore.length > 7) {
                        axios.get('/admin/product/a/search?page=' + page, {params: {shamsimore: this.search.shamsimore}}).then(response => {
                            data.products = response.data;
                        });
                    }
                    if (this.search.shamsimore.length === 0) {
                        this.fetchProducts();
                    }
                },
                deleteProduct(id) {
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
                            axios.get(`/admin/product/delete/${id}`).then(res => {
                                this.fetchProducts();
                            });
                        }
                    });
                },
                fetchCat() {
                    let data = this;
                    axios.get('/admin/catspec/cat').then(res => {
                        data.cats = res.data;

                    });
                },
                numberFormat(number) {
                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
                    this.form.cat = this.holder.selfName;
                    this.flag = false;
                    this.searchCat();
                },
                async fetchCatId() {
                    let _this = this;
                    await axios.get(`/admin/product/fetch/cat/id/${_this.form.cat}`).then(res => {
                        _this.search.cat = res.data;
                    });
                },
            },
            mounted: function () {
                this.fetchProducts();
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
    <script>
        $("#side_product").addClass("menu-open");
        $("#side_product_index").addClass("active");
    </script>
@endsection

@section('style')
    <style>
        .display-none {
            display: none
        }

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

    <style>
        li {
            list-style: none
        }

        #btn-cat {
            position: relative;
            background-color: white;
            border: 1px solid #dee2e6;
            width: 210px;
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
            z-index: 99;
            background-color: white;
            padding: 5px 15px;
            width: 210px;
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
