@extends('layouts.admin.admin')
@section('content')
    <div class="container-fluid mt-4" id="area">
        <!--<div class="row">-->
        <!--    <div class="col-md-6">-->
        <!--        <div class="form-group d-flex flex-row ">-->
        <!--            <label for="name" class="col-md-3 mt-2 control-label"-->
        <!--                   style="display: inline-block;text-align: left">شماره همراه کاربر :</label>-->
        <!--            <input id="name" type="text" class="col-md-5 form-control" @keyup.enter="formSubmit"-->
        <!--                   style="display: inline-block;direction: ltr;border-bottom-left-radius: 0;border-top-left-radius: 0;"-->
        <!--                   maxlength="11"-->
        <!--                   v-model="code" autofocus>-->
        <!--            <button type="button" class="btn btn-dark" @click="formSubmit"-->
        <!--                    style="border: unset;border-bottom-right-radius: 0;border-top-right-radius: 0;background-color: #343a40">-->
        <!--                <i class="nav-icon fa fa-search"></i>-->
        <!--            </button>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!--<div class="row mt-4">-->
        <!--    <div class="col-md-12">-->
        <!--        <table class="table table-striped table-bordered">-->
        <!--            <tbody>-->
        <!--            <tr v-for="(item , key ,index) in carts">-->
        <!--                <td>-->
        <!--                    شماره سبد : @{{removeDecimal(key)}}-->
        <!--                </td>-->
        <!--                <td>-->
        <!--                    <table>-->
        <!--                        <tbody>-->
        <!--                        <template v-for="(cart, index) in item">-->
        <!--                            <tr>-->
        <!--                                <td>@{{ index+1 }}</td>-->
        <!--                                <td>@{{ cart.product.name }}</td>-->
        <!--                                <td>-->
        <!--                                    <span v-if="cart.color">-->
        <!--                                        رنگ : @{{ cart.color.name}}-->
        <!--                                    </span>-->
        <!--                                    <span v-else>---</span>-->
        <!--                                </td>-->
        <!--                                <td>-->
        <!--                                    <span v-if="cart.cart_values[0]">-->
        <!--                                        سایز : @{{ cart.cart_values[0].effect_value.key }}-->
        <!--                                    </span>-->
        <!--                                    <span v-else>---</span>-->
        <!--                                </td>-->
        <!--                                <td class="product-quantity">-->
        <!--                                    تعداد : @{{ cart.number }}-->
        <!--                                </td>-->
        <!--                            </tr>-->
        <!--                        </template>-->
        <!--                        </tbody>-->
        <!--                    </table>-->
        <!--                </td>-->
        <!--            </tr>-->

        <!--            </tbody>-->
        <!--        </table>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group d-flex flex-row ">
                    
                    <div class="input-group mb-3">
                        
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="created">زمان ایجاد :</label>
                      </div>
                      <select v-model="search.created" @keyup.enter="filter" class="custom-select" id="created">
                       <option value="" >انتخاب کنید...</option>
                            <!--disabled hidden-->
                        <option v-for="(caption,index) in created_cats" :value="index">@{{ caption }}</option>
                      </select>
                      
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="status"> وضعیت :</label>
                      </div>
                      <select v-model="search.status" @keyup.enter="filter" class="custom-select" id="status">
                       <option value="" >انتخاب کنید...</option>
                            <!--disabled hidden-->
                        <option v-for="(caption,index) in status_cats" :value="index">@{{ caption }}</option>
                      </select>
                      
                       <div class="input-group-prepend">
                        <label class="input-group-text" for="mobile">شماره همراه :</label>
                      </div>
                      <input v-model="search.mobile" autofocus maxlength="11" @keyup.enter="filter" id="mobile" type="text" class="form-control" >
                      
                      
                        
                        <div v-if="search.status=='unpaid'" class="input-group-append">
                            <button :disabled="loading" @click="notify" class="btn btn-warning" type="button">
                                <i v-if="!loading" class="nav-icon fa  fa-envelope"></i>
                                 <i v-if="loading" class="nav-icon fa fa-spinner fa-spin"></i>
                            </button>
                        </div>
                        
                        
                          <div class="input-group-append">
                            <button :disabled="loading" @click="filter" class="btn btn-dark" type="button">
                                <i v-if="!loading" class="nav-icon fa fa-search"></i>
                                 <i v-if="loading" class="nav-icon fa fa-spinner fa-spin"></i>
                            </button>
                        </div>
                    </div>
                    
                   <!-- <label for="mobile" class="col-md-3 mt-2 control-label"-->
                   <!--        style="display: inline-block;text-align: left">شماره همراه :</label>-->
                   <!-- <input id="mobile" type="text" class="col-md-5 form-control" @keyup.enter="filter"-->
                   <!--        style="display: inline-block;direction: ltr;border-bottom-left-radius: 0;border-top-left-radius: 0;"-->
                   <!--        maxlength="11"-->
                   <!--        v-model="search.mobile" autofocus>-->
                           
                   <!-- <label for="created" class="col-md-3 mt-2 control-label"-->
                   <!--    style="display: inline-block;text-align: left">زمان ایجاد :</label>-->
                   <!-- <select id="created" class="form-control" v-model="search.created" @keyup.enter="filter">-->
                   <!--     <option value="" >انتخاب کنید...</option>-->
                   <!--         disabled hidden-->
                   <!--     <option v-for="(caption,index) in created_cats" :value="index">@{{ caption }}</option>-->
                   <!-- </select>-->
                    
                   <!-- <label for="status" class="col-md-3 mt-2 control-label"-->
                   <!--style="display: inline-block;text-align: left">وضعیت :</label>-->
                   <!-- <select id="status" class="form-control" v-model="search.status" @keyup.enter="filter">-->
                   <!--     <option value="" >انتخاب کنید...</option>-->
                   <!--         disabled hidden-->
                   <!--     <option v-for="(caption,index) in status_cats" :value="index">@{{ caption }}</option>-->
                   <!-- </select>-->
                    
                   <!-- <button :disabled="loading" type="button" class="btn btn-dark" @click="filter"-->
                   <!--         style="border: unset;border-bottom-right-radius: 0;border-top-right-radius: 0;background-color: #343a40">-->
                   <!--     <i v-if="!loading" class="nav-icon fa fa-search"></i>-->
                   <!--     <i v-if="loading" class="nav-icon fa fa-spinner fa-spin"></i>-->
                   <!-- </button>-->
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <tbody>
                    <tr v-for="(item , key ,cindex) in carts">
                        <td>
                            شماره سبد : @{{removeDecimal(key)}}
                        </td>
                        <td>
                            <table>
                                <tbody>
                                <template v-for="(cart, index) in item">
                                    <tr>
                                        <td>@{{ cart.row_index }}</td>
                                        <td>@{{ cart.product.name }}</td>
                                        <td>
                                            <span v-if="cart.color">
                                                رنگ : @{{ cart.color.name}}
                                            </span>
                                            <span v-else>---</span>
                                        </td>
                                        <td>
                                            <span v-if="cart.cart_values[0]">
                                                سایز : @{{ cart.cart_values[0].effect_value.key }}
                                            </span>
                                            <span v-else>---</span>
                                        </td>
                                        <td class="product-quantity">
                                            تعداد : @{{ cart.number }}
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <pagination :data="carts_paginator" @pagination-change-page="paginate" style="margin:auto"></pagination>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                // carts: [],
                // code: "",
                // cookie: "",
                carts_paginator: {!!json_encode($carts)!!},
                loading: false,
                current_page: null,
                created_cats : {
                        '15m' : 'پانزده دقیقه گذشته',
                        '1h' : 'ساعت گذشته',
                        '1d' : 'روز گذشته',
                        '1w' : 'هفته گذشته',
                        '1M' : 'ماه گذشته',
                },
                status_cats : {
                    'unpaid' : 'پرداخت نشده',
                    'paid' : 'پرداخت شده',
                },
                search: {
                    mobile : '',
                    created : '',
                    status : '',
                }
            },
            computed:{
                 carts(){
                     let counter = 0;
                    return this.carts_paginator.data.reduce((total, item) => {
                        let key = item.cookie;
                        item.row_index = this.getRowIndex(counter);
                        counter++;
                        if(!(key in total)) {
                          total[key] = [item];
                        } else {
                          total[key].push(item);
                        }
                        return total;
                      }, {});
                },
            },
            methods: {
                paginate(page) {
                    let link = this.carts_paginator.first_page_url;
                 
                    link = link.replace(new RegExp('page=1$'), 'page='+ page);
                    
                    this.loading = true;
                    
                    axios.get(link).then(res => {
                        this.carts_paginator = res.data;
                        this.current_page = this.carts_paginator.current_page;
                        this.loading = false;
                    }).catch(error => {
                        this.loading = false;
                    });
                },
                filter() {
                    let params = {filters : this.search};
                        
                    this.loading = true;
                        
                    axios.get('/admin/carts', {
                        params: params
                    }).then(res => {
                        this.carts_paginator = res.data;
                         this.loading = false;
                        // console.log(this.carts_paginator);
                    }).catch(error => {
                        this.loading = false;
                    });
                    
                },
                notify() {
                    
                    swal.fire({
                        title: 'ارسال پیام',
                          text: "ارسال پیام سبد های خرید پرداخت نشده",
                          icon: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'بله',
                       cancelButtonText: 'خیر',
                        }).then((result) => {
                          if (result.value) {
    
  
                    
                                let params = {filters : this.search, sendMessage: true};
                                    
                                this.loading = true;
                                    
                                axios.get('/admin/carts', {
                                    params: params
                                }).then(res => {
                                     this.loading = false;
                                    if (res.data.result == 'OK' && res.data.message == '1')
                                        swal.fire(
                                            {
                                                text: " با موفقیت ثبت شد !",
                                                type: "success",
                                                confirmButtonText: 'باشه',
                                            }
                                            );
                                    else
                                    {
                                        swal.fire(
                                            {
                                        text: " ارسال پیام انجام نشد:"+JSON.stringify( res.data.message),
                                                type: "warning",
                                                confirmButtonText: 'باشه',
                                            }
                                            );
                                    }
                                }).catch(error => {
                                    this.loading = false;
                                });
                      }
                    });
                },
                getRowIndex(index){
                    return index + this.carts_paginator.from;
                },
                formSubmit(e) {
                    e.preventDefault();
                    let _this = this;
                    let formData = new FormData();
                    formData.append('mobile', this.code);

                    axios.post('/admin/cart/search/mobile', formData)
                        .then(function (response) {
                            _this.carts = response.data;
                            console.log(_this.carts);
                        });
                },
                changeExist(e) {
                    e.preventDefault();
                    let _this = this;
                    let formData = new FormData();
                    formData.append('num', this.product.num);
                    formData.append('code', this.code);

                    axios.post('/admin/exist/product/code/change/num', formData)
                        .then(function (response) {
                            swal.fire(
                                {
                                    text: " با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                        })
                        .catch(function (error) {

                        });
                },
                numberFormat(price) {
                    price = Math.trunc(price);
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                removeDecimal(num) {
                    return parseInt(num);
                }
            },
            mounted: function () {
                this.search = {!!json_encode($filters)!!};
            }
        });
    </script>
    <script>
        $("#side_cart").addClass("menu-open");
        $("#side_cart_index").addClass("active");
    </script>
@endsection

@section('style')

@endsection
