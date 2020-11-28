<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>صفحه ورود</title>
    <script src="{{ asset('/js/app.js')}}"></script>
    <link rel="stylesheet" href="/layout/fontawesome-free-5.6.1-web/css/all.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/layout_balance/css/style.css">
    <style>
        #swal2-content {
            text-align: center;
        }

        * {
            direction: rtl;
            text-align: right
        }

        .a-paragraph {
            font-size: 15px;
            color: #adadad;
        }

        .a-h3 {
            background: #e2e2e2;
        }

        .a-main-container {
            border: 1px solid #d4d4d4;
            border-radius: 4px;
        }

        .a-btn {
            color: gray;
            border: 1px solid #d6d6d6;
        }

        .a-btn2 {
            margin-right: 25px;
        }

        .a-input {
            border: 1px solid #aaaaaa;
            direction: ltr;
        }

        .a-error {
            font-size: 13px;
            margin-right: 15px;
            color: #dc3545;
        }

        body {
            background: white;
        }
    </style>
</head>
<body>
<div id="area">
    <div v-show="flag1" class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 px-0 pb-3 a-main-container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center py-2 a-h3">ورود / ثبت‌نام</h3>
                        <p class="text-center my-4 a-paragraph mx-3">برای ورود و یا ثبت‌نام در سایت شماره موبایل خود
                            را
                            وارد
                            نمایید تا کد تاییدی برای شما پیامک
                            شود</p>
                        <input class="text-center col-11 form-control mx-auto a-input" v-model="form.mobile" type="text"
                               autofocus>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-8">
                        <span class="a-error">@{{ error }}</span>
                    </div>
                    <div class="col-md-4 text-left">
                        <button class="btn btn-sm ml-4 a-btn" @click="getCode($event)">بعدی</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <div v-show="flag2" class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 px-0 pb-3 a-main-container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center py-2 a-h3">کد تایید ثبت‌نام</h3>
                        <p class="text-center my-4 a-paragraph mx-3">
                            کاربر با موفقیت ایجاد شد. لطفا کد پیامک شده برای شماره @{{ form.mobile }} را وارد نمایید.
                        </p>

                        <input class="text-center col-11 form-control mx-auto a-input" v-model="code" type="text">

                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <button class="btn btn-sm ml-4 a-btn a-btn2" @click="back()">قبلی</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button class="btn btn-sm ml-4 a-btn-back" @click="login($event)">بعدی</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>

<script>
    new Vue({
        el: '#area',
        data: {
            form: {
                name: '',
                mobile: '',
                nationalCode: '',
            },
            code: '',
            flag1: true,
            flag2: false,
            error: '',
        },
        methods: {
            getCode(e) {
                e.preventDefault()
                let _this = this

                if (this.form.mobile.length !== 11) {
                    this.error = 'شماره همراه را به صورت صحیح وارد کنید'
                    return false
                }

                axios.post('/login/send/code', {
                    mobile: this.form.mobile,
                }).then(function (res) {
                    console.log(res.data)
                    _this.flag1 = false
                    _this.flag2 = true
                    _this.error = ''
                })
            },
            login(e) {
                e.preventDefault()
                axios.post('/login/check/code', {
                    code: this.code,
                    mobile: this.form.mobile,
                }).then(function (res) {
                    if (res.data === '111') {
                        window.location.href = '/cart'
                    } else {
                        swal.fire(
                            {
                                text: "کد تایید صحیح نمی باشد!",
                                type: "error",
                                confirmButtonText: 'باشه',
                            }
                        )
                    }
                })
            },
            back() {
                this.flag1 = true
                this.flag2 = false
            },
        }
    })
</script>

</body>
</html>
