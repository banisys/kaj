@extends('layouts.admin.admin')
@section('content')
    <div class="container-fluid mt-4" id="area">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group d-flex flex-row ">
                    <label for="name" class="col-md-3 mt-2 control-label"
                           style="display: inline-block;text-align: left">کد محصول :</label>
                    <input id="name" type="text" class="col-md-5 form-control" @keyup.enter="formSubmit"
                           style="display: inline-block;direction: ltr;border-bottom-left-radius: 0;border-top-left-radius: 0;"
                           maxlength="11"
                           v-model="code" autofocus>
                    <button type="button" class="btn btn-dark" @click="formSubmit"
                            style="border: unset;border-bottom-right-radius: 0;border-top-right-radius: 0;background-color: #343a40">
                        <i class="nav-icon fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped table-bordered" v-if="product.product_id">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th v-if="product.effect_spec" scope="col">@{{ product.effect_price.name }}</th>
                        <th v-if="product.color" scope="col">رنگ</th>
                        <th scope="col">تعداد</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>@{{product.product.name}}</td>
                        <td v-if="product.effect_spec">@{{product.effect_spec.name}}</td>
                        <td v-if="product.color">@{{product.color.name}}</td>
                        <td>
                            <input @keyup.enter="changeExist" id="name" type="number" minlength="0" class="col-md-5 form-control" v-model="product.num">
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" @click="changeExist">
                                اعمال
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                product: [],
                code: "",
            },
            methods: {
                formSubmit(e) {
                    e.preventDefault();
                    let _this = this;
                    let formData = new FormData();
                    formData.append('code', this.code);

                    axios.post('/admin/exist/search/product/code', formData)
                        .then(function (response) {
                            _this.product = response.data;
                        })
                        .catch(function (error) {

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
            },
            mounted: function () {
            }
        });
    </script>
    <script>
        $("#side_exist").addClass("menu-open");
        $("#side_exist_product_code").addClass("active");
    </script>
@endsection

@section('style')

@endsection