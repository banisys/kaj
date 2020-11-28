@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-5 pb-5" id="area" style="position: relative">
        <span style="position: absolute;margin-right:10px;top: -14px;background-color: #f4f6f9;color: #9f9f9f;">افزودن تعداد برای هر ویژگی محصول</span>
        <div class="row" style="border: 1px #dedede solid;padding:35px 5px 35px 5px;border-radius: 10px">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <div v-if="colors.length" class="example ex1" style="display: inline-block">
                                <template v-for="color in colors">
                                    <label class="radio red ml-2" style="background-color: unset;">
                                        <a style="display: inline-block">@{{ color.name }}</a>
                                        <input type="radio" name="group1"
                                               :value="color.price" :id="'color'+color.id"
                                               @change="onChangeColor($event,color.id)"/>
                                        <span :style="{ backgroundColor: color.code}"
                                              style=" width: 45px;height: 27px;display: inline-block;vertical-align: bottom;">
                                        </span>
                                    </label>
                                </template>
                            </div>


                            <label v-if="effectPrice.length" class="ml-2 mr-5">@{{ effectPrice }} :</label>

                            <select v-if="effectPrice.length" class="form-control"
                                    style="width: auto;display: inline-block;"
                                    v-model="form.effect">
                                <option value="" disabled hidden>انتخاب کنید...</option>
                                <option v-for="effectSpec in effectSpecs" :value="effectSpec.id">
                                    @{{ effectSpec.name }}
                                </option>
                            </select>


                            <label class="ml-2 mr-5">تعداد :</label>
                            <input type="number" class="form-control" style="display: inline-block;width: auto"
                                   v-model="form.num">
                                   
                            <label class="ml-2 mr-5">شماره فاکتور :</label>
                            <input type="text" class="form-control" style="display: inline-block;width: auto"
                               v-model="form.factor_num">

                            <button type="button" class="btn btn-primary mr-5" @click="formSubmit"
                                    style="padding: 5px 11px;">
                                ثبت
                            </button>
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
                        <th v-if="colors.length" scope="col">رنگ</th>
                        <th v-if="effectPrice.length" scope="col">@{{ effectPrice }}</th>
                        <th scope="col">تعداد</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(exist,index) in exists.data">
                        <td v-if="colors.length">@{{exist.color.name}}</td>

                        <td v-if="effectPrice.length">@{{ exist.effect_spec.name }}</td>

                        <td>@{{ exist.num }}</td>
                        <td>
                            <a @click="deleteExist(exist.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-2">
            <pagination :data="exists" @pagination-change-page="fetchExists"></pagination>
        </div>
    </div>

@endsection
@section('script')
    <script>
        new Vue({
            el: '#area',
            data: {
                effectPrice: '',
                effectSpecs: [],
                effects: [],
                colors: [],
                exists: [],
                form: {
                    color_id: null,
                    effect: '',
                    num: 0,
                    factor_num: ''
                },
            },
            methods: {
                onChangeColor(event, color) {
                    this.form.color_id = color;
                },
                fetchExists(page = 1) {
                    let _this = this;
                    parts = window.location.href.split('/');
                    id = parts.pop() || parts.pop();
                    axios.get(`/admin/exist/fetch/${id}?page=` + page).then(res => {
                        _this.exists = res.data;
                        console.log(_this.exists);
                    });
                },
                deleteExist(id) {
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
                            axios.get(`/admin/exist/delete/${id}`)
                                .then(() => {
                                    swal.fire(
                                        {
                                            text: " با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    _this.fetchExists();
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
                formSubmit(e) {
                    e.preventDefault();
                    parts = window.location.href.split('/');
                    id = parts.pop() || parts.pop();
                    let _this = this;
                    let formData = new FormData();

                    if (typeof this.effectPrice.length !== 'undefined') {
                        formData.append('effect_spec', this.form.effect);
                    } else {
                        formData.append('effect_spec', 'effect not set');
                    }

                    if (this.colors.length != 0) {
                        formData.append('color_id', this.form.color_id);
                    } else {
                        formData.append('color_id', 'color not set');
                    }


                    formData.append('num', this.form.num);
                    formData.append('factor_num', this.form.factor_num);
                    formData.append('product_id', id);

                    axios.post('/admin/exist/store/num', formData)
                        .then(function (response) {
                            swal.fire(
                                {
                                    text: " با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                            _this.fetchExists();
                        }).catch(function (error) {
                    });
                },
            },
            mounted: async function () {
                this.fetchExists();
                parts = window.location.href.split('/');
                id = parts.pop() || parts.pop();
                let _this = this;

                await axios.get(`/admin/exist/get/slug/${id}`).then(res => {
                    window.slug = res.data;
                });

                await axios.get(`/admin/exist/fetch/effect/price/${window.id}`).then(res => {
                    _this.effectPrice = res.data;

                });

                await axios.get(`/admin/exist/fetch/effect/spec/${window.id}`).then(res => {
                    _this.effectSpecs = res.data;
                });

                await axios.get(`/fetch/color/${window.slug}`).then(res => {
                    _this.colors = res.data;
                });
            },
        });
    </script>
@endsection
@section('style')
    <link rel="stylesheet" href="/detail-gallery/vendor/lightgallery-1.6.12/css/lightgallery.min.css">
    <link rel="stylesheet" href="/detail-gallery/css/custom.css">
    <style>
        #Reviews img {
            width: 70px;
            border-radius: 60px;
        }

        body {
            background-color: white
        }

        #dis {
            float: left;
            font-size: 15px;
            background-color: #07d765;
            color: white;
            padding: 8px;
            border-radius: 30px;
        }
    </style>
    <style>
        .example {
            margin: 20px;
        }

        .example input {
            display: none;
        }

        .example label {
            margin-right: 20px;
            display: inline-block;
            cursor: pointer;
        }

        .ex1 span {
            display: block;
            padding: 5px 10px 5px 25px;
            border: 2px solid #ddd;
            border-radius: 5px;
            position: relative;
            transition: all 0.25s linear;
        }

        .ex1 span:before {
            content: '';
            position: absolute;
            left: 5px;
            top: 50%;
            -webkit-transform: translatey(-50%);
            transform: translatey(-50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ffffff;
            transition: all 0.25s linear;
            border: 2px solid #ffffff;
        }

        .ex1 .red input:checked + span:before {
            background-color: #0aa0d7;

        }

        .answer {
            position: relative;
        }

        .answer:after {
            position: absolute;
            top: 50%;
            right: -40px;
            height: 2px;
            width: 40px;
            content: "";
            background-color: #e0e0e0;
        }

        #Description p {
            line-height: 35px
        }

        textarea {
            border-color: #e0e0e0;
        }

        body {
            background-color: #eceff3;
        }

        .product:hover {
            box-shadow: unset !important;
        }
    </style>
    <style>
        .product-gallery__featured {
            box-shadow: inset 0 0 0 2px #f2f2f2;
            padding: 2px;
            border-radius: 2px
        }

        .product-gallery__featured a {
            display: block;
            padding: 20px
        }

        .product-gallery__carousel {
            margin-top: 16px
        }

        .product-gallery__carousel-item {
            cursor: pointer;
            display: block;
            box-shadow: inset 0 0 0 2px #f2f2f2;
            padding: 12px;
            border-radius: 2px
        }

        .product-gallery__carousel-item--active {
            box-shadow: inset 0 0 0 2px #ffd333
        }

        .product-tabs {
            margin-top: 50px
        }

        .product-tabs__list {
            display: -ms-flexbox;
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: -2px
        }

        .product-tabs__list:after,
        .product-tabs__list:before {
            content: "";
            display: block;
            width: 8px;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .product-tabs__item {
            font-size: 20px;
            padding: 18px 48px;
            border-bottom: 2px solid transparent;
            color: inherit;
            font-weight: 500;
            border-radius: 3px 3px 0 0;
            transition: all .15s
        }

        .product-tabs__item:hover {
            color: inherit;
            background: #f7f7f7;
            border-bottom-color: #d9d9d9
        }

        .product-tabs__item:first-child {
            margin-right: auto
        }

        .product-tabs__item:last-child {
            margin-left: auto
        }

        .product-tabs__item--active {
            transition-duration: 0s
        }

        .product-tabs__item--active,
        .product-tabs__item--active:hover {
            cursor: default;
            border-bottom-color: #ffd333;
            background: transparent
        }

        .product-tabs__content {
            border: 2px solid #f0f0f0;
            border-radius: 2px;
            padding: 80px 90px
        }

        .product-tabs__pane {
            overflow: hidden;
            height: 0;
            opacity: 0;
            transition: opacity .5s
        }

        .product-tabs__pane--active {
            overflow: visible;
            height: auto;
            opacity: 1
        }

        .product-tabs--layout--sidebar .product-tabs__item {
            padding: 14px 30px
        }

        .product-tabs--layout--sidebar .product-tabs__content {
            padding: 48px 50px
        }

        .radio-border {
            border: 2px solid red
        }
    </style>
@endsection
