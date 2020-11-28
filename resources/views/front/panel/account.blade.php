@extends('layouts.front.dress')
@section('content')

    <div class="clearfix container mb-5" id="area" style="max-width: 1140px">
        @include('layouts.front.aside')
        <div class="col-lg-10 float-right pl-0 content mt-3">

            <div class="col-md-12 px-0 mt-5 clearfix account-info">
                <div class="shipping-form-items py-4 col-lg-6 float-lg-left px-5" id="label1">
                    <input type="text" id="Name" v-model="form.name"
                           class="col-md-12 mx-auto d-block pl-0" placeholder="نام و نام خانوادگی">
                    <span style="color: red;margin-top:20px"><br> @{{ error.name }} </span>
                    <label for="Name">نام و نام خانوادگی</label>
                </div>
                <div class="shipping-form-items py-4 col-lg-6 float-lg-left px-5" id="label2">

                    <input type="text"
                           v-model="form.mobile"
                           class="col-md-12 mx-auto d-block pl-0" placeholder="شماره همراه">
                    <span style="color: red;margin-top: 20px"><br> @{{ error.mobile }} </span>
                    <label for="Num">شماره همراه</label>

                </div>
                <div class="shipping-form-items py-4  col-lg-6 float-lg-right px-5" id="label3">

                    <input type="text" id="PostalCode"
                           v-model="form.postal_code"
                           class="col-md-12 mx-auto d-block pl-0" placeholder="کد پستی ">
                    <span style="color: red;margin-top:20px"><br> @{{ error.postal_code }} </span>
                    <label for="PostalCode">کد پستی</label>

                </div>

                <div class="shipping-form-items py-4 col-lg-6 float-lg-right px-5" id="label4">

                    <input type="text" id="town"
                           v-model="form.state"
                           class="col-md-12 mx-auto d-block pl-0" placeholder="استان">
                    <span style="color: red;margin-top:20px"><br> @{{ error.state }} </span>
                    <label for="town">استان</label>

                </div>

                <div class="shipping-form-items py-4  col-lg-6 float-lg-right px-5" id="label5">

                    <input type="text" id="City"
                           v-model="form.city"
                           class="col-md-12 mx-auto d-block pl-0" placeholder="شهر">
                    <span style="color: red;margin-top:20px"><br> @{{ error.city }} </span>
                    <label for="City" class="pr-1">شهر</label>


                </div>

                <div class="shipping-form-items py-4  col-lg-6 float-lg-left px-5" id="label7">
                    <input type="text" id="HomeNumber"
                           v-model="form.tell"
                           class="col-md-12 float-right" placeholder="شماره ثابت">
                    <span style="color: red;margin-top:20px"><br> @{{ error.tell }} </span>

                    <label for="HomeNumber">شماره ثابت</label>

                </div>

                <div class="shipping-form-items py-4  col-lg-12 float-lg-right  px-5" id="label6">
                    <input type="text" id="Address"
                           v-model="form.address"
                           class="col-md-12 pl-0 pr-4 float-left" placeholder="آدرس">
                    <span style="color: red;margin-top:20px"><br> @{{ error.address }} </span>
                    <label for="Address">آدرس</label>

                </div>

                <div class="shipping-form-items py-4  col-lg-12 float-lg-left">
                    <button type="submit" @click="formSubmit"
                            style="float: left;width: 80px;background-color: #123b66;border-color: #56718c;cursor: pointer"
                            class="btn btn-secondary mr-4">
                        ثبت
                    </button>

                </div>


            </div>
        </div>

    </div>
    <br>
    <br>
@endsection

@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                form: {
                    "name": '',
                    "postal_code": '',
                    "city": '',
                    "state": '',
                    "address": '',
                    "tell": '',
                    "image": '',
                    "mobile": '',
                },
                error: {
                    name: '',
                    postal_code: '',
                    city: '',
                    mobile: '',
                    state: '',
                    address: '',
                    tell: '',
                    image: '',
                },
                user: [],
                allErrors: [],
                flag: true,
            },
            methods: {
                onImageChange(e) {
                    this.flag = false;
                    this.form.image = e.target.files[0];
                },
                formSubmit(e) {
                    e.preventDefault();
                    let data = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };
                    var formData = new FormData;

                    formData.append('name', this.form.name);
                    formData.append('postal_code', this.form.postal_code);
                    formData.append('city', this.form.city);
                    formData.append('mobile', this.form.mobile);
                    formData.append('state', this.form.state);
                    formData.append('address', this.form.address);
                    formData.append('tell', this.form.tell);

                    axios.post('/panel/account/store', formData, config).then(function (res) {
                        swal.fire(
                            {
                                text: "پروفایل شما با موفقیت ویرایش شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        data.flag = true;
                        data.fetchUser();
                    }).catch(function (error) {
                        data.allErrors = error.response.data.errors;
                        x = error.response.data.errors;
                        if (Array.isArray(x.postal_code)) {
                            data.error.postal_code = data.allErrors.postal_code[0];
                        }
                        if (Array.isArray(x.name)) {
                            data.error.name = data.allErrors.name[0];
                        }
                        if (Array.isArray(x.mobile)) {
                            data.error.mobile = data.allErrors.mobile[0];
                        }
                        if (Array.isArray(x.state)) {
                            data.error.state = data.allErrors.state[0];
                        }
                        if (Array.isArray(x.city)) {
                            data.error.city = data.allErrors.city[0];
                        }
                        if (Array.isArray(x.address)) {
                            data.error.address = data.allErrors.address[0];
                        }
                        if (Array.isArray(x.tell)) {
                            data.error.tell = data.allErrors.tell[0];
                        }
                    });
                },
                fetchUser() {
                    let data = this;
                    axios.get(`/panel/fetch/user`).then(res => {
                        data.form = res.data;
                        data.user = res.data;
                    });
                },
                exit() {
                    this.$refs.formExit.submit();
                },
            },
            mounted: function () {
                this.fetchUser();
            }
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(160)
                        .height('auto');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#info-btn").addClass('active-menu');
    </script>
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="/layout/style.css">
    <style>
        #panel_side > li{
            text-align: right !important;
        }
    </style>
    <style>
        input{background-color: unset !important;}

        .active-menu .fa {
            color: #c40316
        }

        .active-menu  {
            background-color: aliceblue;
        }

        .active-menu span {
            font-weight: bold;
            color: #123b66 !important;
        }

        #panel_side li:hover a, #panel_side li:hover a span {
            color: #123b66 !important;
        }

        #panel_side li a {
            color: #c9c9c9
        }
        .navbar .navbar-nav > li > .nav-link {

            padding: 5px 10px;

        }

    </style>
@endsection

