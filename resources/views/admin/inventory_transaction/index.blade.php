@extends('layouts.admin.admin')
@section('title') تراکنش محصولات @endsection
@section('content')

    <div class="container-fluid mt-4" id="area">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive bg-light align-middle">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                    <th scope="col"> ردیف </th>
                        <th scope="col"> کد محصول</th>
                        <th scope="col">نام محصول</th>
                        <th scope="col">ویژگی ها</th>
                        <th scope="col">شناسه کاربر</th>
                        <th scope="col">تاریخ</th>
                    <th scope="col">موجودی جدید</th>
                        <th scope="col"> موجودی قبلی</th>
                        <th scope="col">قیمت اصلی</th>
                        <th scope="col">قیمت نهایی</th>
                     <th scope="col">
                         توضیحات
                         <div class="input-group-append">
                            <button @click="export2excel" class="btn btn-success" type="button">
                                <i class="nav-icon fa  fa-file"></i>
                                 <!--<i v-if="loading" class="nav-icon fa fa-spinner fa-spin"></i>-->
                            </button>
                        </div>
                         </th>
                    </tr>
                    </thead>
                    <tbody>
                         <tr>
                             <td>
                                 <i v-if="pluss" class="fa fa-plus" style="color: #888888;float: left;cursor: pointer"
                                   @click="toggleFlag()"></i>
                                <i v-if="pluss2" class="fa fa-minus" style="color: #888888;float: left;cursor: pointer"
                                   @click="toggleFlag()"></i>
                             </td>
                             <td>
                                 <input type="text" class="form-control" v-model="search.code"
                                        @keyup="filter()" placeholder="جستجو">
                             </td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td>
                                  
                                <input type="text" class="form-control" v-model="search.shamsi_c" style="direction: ltr;"
                                       @keyup="filter()" placeholder="جستجو">
                                <input type="text" class="form-control" v-model="search.shamsiless" v-if="fflag"
                                       style="direction: ltr;"
                                       @keyup="filter()" placeholder="تاریخ های قبل از">
                                <input type="text" class="form-control" v-model="search.shamsimore" v-if="fflag"
                                       style="direction: ltr;"
                                       @keyup="filter()" placeholder="تاریخ های بعد از">
                            
                             </td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td>
                                <select class="form-control" v-model="search.cat" @change="filter()">
                                    <option value="" >انتخاب کنید...</option>
                                    <!--disabled hidden-->
                                    <option v-for="(caption,index) in cats" :value="index">@{{ caption }}</option>
                                </select>
                             </td>
                             
                            <!--<td>-->
                            <!--    {{--<select class="form-control" v-model="search.cat" @change="searchCat()">--}}-->
                            <!--    {{--<option value="" disabled hidden>انتخاب کنید...</option>--}}-->
                            <!--    {{--<option value="999999">همه دسته ها</option>--}}-->
                            <!--    {{--<option v-for="cat in cats" :value="cat.id">@{{ cat.name }}</option>--}}-->
                            <!--    {{--</select>--}}-->
                            <!--    <button @click="clickCatBtn" id="btn-cat">-->
                            <!--        @{{ form.cat }}-->
                            <!--        <i class="right fa fa-angle-down" id="angle-down"></i>-->
                            <!--    </button>-->
    
                            <!--    <div v-if="flag" id="sss">-->
                            <!--        <ul v-if="flag1">-->
                            <!--            <li style="line-height: 35px;"-->
                            <!--                @click="fetchChild(root.id,root.name)"-->
                            <!--                v-for="(root,index) in roots">-->
                            <!--                @{{ root.name }}-->
                            <!--                <i id="angle-left" class="right fa fa-angle-left"></i>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--        <ul v-if="flag2">-->
                            <!--            <li style="color: #a0a0a0" @click="back(holder.parentName)">-->
                            <!--                <i class="right fa fa-angle-right"-->
                            <!--                   style="float: right;margin:11px 0 0 5px;"></i>-->
                            <!--                @{{ holder.parentName }}-->
                            <!--            </li>-->
                            <!--            <li style="margin-top: 10px" v-if="!childs.length"-->
                            <!--                @click="fixCat()">-->
                            <!--                     <span-->
                            <!--                         style="border-radius: 46px;color: white;margin-right: 15px;padding: 4px 13px;background-color: #007ac8;">-->
                            <!--                                         @{{ holder.selfName }}-->
                            <!--                                    </span>-->
                            <!--            </li>-->
                            <!--            <li v-for="(child,index) in childs"-->
                            <!--                @click="fetchChild(child.id,child.name)"-->
                            <!--                style="margin-right: 10px;">-->
                            <!--                @{{ child.name }}-->
                            <!--                <i id="angle-left" v-if="child.children_recursive.length"-->
                            <!--                   class="right fa fa-angle-left"></i>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--    </div>-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    <input type="text" class="form-control" v-model="search.name"-->
                            <!--           @keyup="searchName" placeholder="جستجو بر اساس نام">-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    <input type="text" class="form-control" v-model="search.brand"-->
                            <!--           @keyup="searchBrand" placeholder="جستجو بر اساس برند">-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    <input type="text" class="form-control" v-model="search.price" style="direction: ltr;"-->
                            <!--           @keyup="searchPrice" placeholder="جستجو بر اساس قیمت">-->
                            <!--    <input type="text" class="form-control" v-model="search.less" v-if="fflag"-->
                            <!--           style="direction: ltr;"-->
                            <!--           @keyup="searchLess" placeholder="قیمت های کمتر از">-->
                            <!--    <input type="text" class="form-control" v-model="search.more" v-if="fflag"-->
                            <!--           style="direction: ltr;"-->
                            <!--           @keyup="searchMore" placeholder="قیمت های بیشتر از">-->
                            <!--</td>-->
    
                            <!--<td>-->
                            <!--    <input type="text" class="form-control" v-model="search.shamsi_c" style="direction: ltr;"-->
                            <!--           @keyup="searchShamsi_c" placeholder="جستجوی تاریخ ">-->
                            <!--    <input type="text" class="form-control" v-model="search.shamsiless" v-if="fflag"-->
                            <!--           style="direction: ltr;"-->
                            <!--           @keyup="searchShamsiLess" placeholder="تاریخ های قبل از">-->
                            <!--    <input type="text" class="form-control" v-model="search.shamsimore" v-if="fflag"-->
                            <!--           style="direction: ltr;"-->
                            <!--           @keyup="searchShamsiMore" placeholder="تاریخ های بعد از">-->
                            <!--</td>-->
                            <!--<td>-->
    
                            <!--    <i v-if="pluss" class="fa fa-plus" style="color: #888888;float: left;cursor: pointer"-->
                            <!--       @click="toggleFlag()"></i>-->
                            <!--    <i v-if="pluss2" class="fa fa-minus" style="color: #888888;float: left;cursor: pointer"-->
                            <!--       @click="toggleFlag()"></i>-->
                            <!--</td>-->
                    </tr>
                    <tr v-for="(transaction,index) in transactions">
                        <td>@{{getRowIndex(index)}}</td>
                        <td>@{{transaction.product_code}}</td>
                        <td>@{{transaction.inventory.product_name}}</td>
                         <td>
                            <div v-if="transaction.inventory.effect_price_name">@{{transaction.inventory.effect_price_name + " : " + transaction.inventory.effect_spec_name}}</div>
                            <div v-if="transaction.inventory.color_name" style="padding: 3px 6px;border-radius: 4px;font-size: 14px" class="ml-2">
                                <!--color: white;-->
                                رنگ : <span  class="p-1 rounded " :class="[invertColor(transaction.inventory.color_code)]" :style="{'background-color': transaction.inventory.color_code}">@{{transaction.inventory.color_name}}</span>
                            </div>
                        </td>
                        <td>@{{transaction.user_id}}</td>
                        <td>@{{transaction.created_at}}</td>
                        <td>
                             <!--<span style="background-color:rgb(0,149,47);font-weight: bold;border-radius: 20px">-->
                                 @{{transaction.balance}}
                             <!--</span>-->
                        </td>
                        <td>
                             <!--<span style="background-color:rgb(0,149,47);font-weight: bold;border-radius: 20px">-->
                                 @{{transaction.old_balance}}
                             <!--</span>-->
                        </td>
                        <td>@{{transaction.inventory.product_price}}</td>
                        <td>@{{final_price(transaction)}}</td>
                        <td>
                            <div v-for="(info,info_index) in info_text(transaction)"> @{{info}}</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <pagination :data="transactions_paginator" @pagination-change-page="paginate" style="margin:auto"></pagination>
        </div>
        <!--<div v-if="showModal">-->
        <!--    <transition name="modal">-->
        <!--        <div class="modal-mask">-->
        <!--            <div class="modal-dialog-scrollable" role="document" style="max-width:100%;">-->
        <!--                <div class="modal-content">-->
        <!--                    <div class="modal-header">-->
        <!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
        <!--                            <span aria-hidden="true" @click="showModal = false">&times;</span>-->
        <!--                        </button>-->
        <!--                    </div>-->
        <!--                    <div class="modal-body" style="text-align: center">-->
        <!--                        <img v-if="pic" :src="'/images/brand/'+pic" style="width: 100%">-->
        <!--                        <p v-if="description">@{{ description }}</p>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </transition>-->
        <!--</div>-->
    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                transactions_paginator: {!!json_encode($transactions)!!},
                fflag: false,
                pluss: true,
                pluss2: false,
                current_page: null,
                cats : {
                        'change' : 'تغییر موجودی',
                        'sell' : 'فروش'
                    },
                search: {
                    cat : '',
                    code : '',
                    shamsi_c : '',
                    shamsiless : '',
                    shamsimore : ''
                }
            },
            computed:{
                transactions(){
                    return this.transactions_paginator.data;
                },
            },
            
            methods: {
                info_text(transaction){
                    let output = {};
                    if (transaction.info!==null && transaction.info!==undefined)
                    {
                        let type_text = 'نوع : ';
                       switch (transaction.info.type)
                       {
                            case 'add':
                                type_text += 'افزایش موجودی';
                                break;
                            case 'remove':
                                type_text += 'کاهش موجودی';
                                break;
                            case 'change':
                                type_text += 'تغییر موجودی';
                                break;
                            case 'sell':
                                type_text += 'فروش';
                                break;
                            default:
                                type_text += 'نامشخص';
                                break;
                                
                       }
                        output['type'] = type_text;
               
                        let factor_num = transaction.info.factor_num;
                
                        if (factor_num!==null && factor_num!==undefined)
                            output['factor_num'] = "شماره فاکتور : " + factor_num;
                            
                        let user_phone = transaction.info.user_phone;
                            
                        if (user_phone!==null && user_phone!==undefined)
                            output['user_phone'] = "تلفن مشتری : " + user_phone;
                    }                        
                    return output;
                },
               final_price(transaction){
                    return Number(transaction.inventory.product_price) * (1 - Number(transaction.inventory.product_discount)/100);
                },
                invertColor(value)
                {
                    const hexCode = value.charAt(0) === '#' ? value.substr(1, 6) : value;

                    const hexR = parseInt(hexCode.substr(0, 2), 16);
                    const hexG = parseInt(hexCode.substr(2, 2), 16);
                    const hexB = parseInt(hexCode.substr(4, 2), 16);
                    // Gets the average value of the colors
                    const contrastRatio = (hexR + hexG + hexB) / (255 * 3);

                    return ( contrastRatio >= 0.5  ? 'text-dark' : 'text-light');
                },
                paginate(page) {
                    let link = this.transactions_paginator.first_page_url;
                 
                    link = link.replace(new RegExp('page=1$'), 'page='+ page);
                    
                    axios.get(link).then(res => {
                        this.transactions_paginator = res.data;
                        this.current_page = this.transactions_paginator.current_page;
                    });
                },
               
                export2excel() {
                     params = {
                         export2excel : true,
                         filters : this.search
                     };
                     
                     window.location.href = '/admin/inventory_transactions?filters='+JSON.stringify(this.search)+'&export2excel=1';
                    //   axios.get('/admin/inventory_transactions', {
                    //     params: params
                    // }).then(res => {
                    //     // this.transactions_paginator = res.data;
                    //     // console.log(this.transactions_paginator);
                    // });
                },
                filter() {
                       
                        // let params = {};
                        let params = {filters : this.search};
                    
                        // // if (this.current_page!==null && this.current_page!==undefined)
                        // //     params['page'] = this.current_page;
                        // if (columnname!==null && columnname!==undefined)
                        // {
                        //     let keyword = this.search[columnname];
                        //     if (keyword!==null && keyword!==undefined)
                        //     {
                        //         params['filters'] = {};
                        //         params['filters'][columnname] = keyword.trim();
                        //     }
                            
                        // }
                        // // console.log(params);
                        
                    axios.get('/admin/inventory_transactions', {
                        params: params
                    }).then(res => {
                        this.transactions_paginator = res.data;
                        // console.log(this.transactions_paginator);
                    });
                    
                },
                getRowIndex(index){
                    return index + this.transactions_paginator.from;
                },
                setExist(id) {
                    window.location.href = `/admin/exist/set/${id}`;
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

                    // console.log(this.search.cat);

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
                // console.log(this.transactions_paginator);
                // this.fetchProducts();
                // this.fetchCat();
                // this.fetchRootCat();
            }
        });
    </script>
    <script>
        $("#side_exist").addClass("menu-open");
        $("#side_inventory_transactions").addClass("active");
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