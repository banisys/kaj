@extends('layouts.front.online')
@section('content')
    <div class="clearfix container mb-5" id="area" style="max-width: 1140px">
        <div class="row">
            @include('layouts.front.aside')
            <div class="col-lg-9 float-right content mt-5 pt-5">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="depart">دپارتمان : </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="depart" v-model="form.department">
                            <option value="" disabled hidden>انتخاب کنید...</option>
                            <option value="فروش">فروش</option>
                            <option value="پشتیبانی">پشتیبانی</option>
                            <option value="مدیریت">مدیریت</option>
                        </select>
                    </div>
                    <span style="color: red"> @{{ error.department }} </span>
                </div>
                <div class="form-group row">
                    <label for="subject" class="col-sm-2 col-form-label">موضوع : </label>
                    <div class="col-sm-10">
                        <input type="text" v-model="form.subject" class="form-control" id="subject">
                        <span style="color: red;float: right"> @{{ error.subject }} </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="body" class="col-sm-2 col-form-label">متن پیام :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="body" rows="9" v-model="form.body"></textarea>
                        <span style="color: red;float: right"> @{{ error.body }} </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="attach" class="col-sm-2 col-form-label">ضمیمه ها :</label>
                    <div class="col-sm-10">
                        <input type="file" id="attach" @change="onImageChange" style="float: right">
                        <button type="submit" class="btn btn-primary" @click="formSubmit"
                                style="float: left;width: 80px;background-color: #c40316;border-color: #c40316;border-radius:4px">
                            ثبت
                        </button>
                    </div>
                </div>
                <div class="form-group row" style="text-align: right">
                    <label for="attach" class="col-sm-2 col-form-label">

                    </label>
                    <label for="attach" class="col-sm-10 col-form-label"
                           style="color: rgb(220, 53, 69);padding-top: 0;font-size: 14px;">
                        ( اجازه افزودن فایل: .jpg, .gif, .jpeg, .png, .bmp, .doc, .txt )
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
@endsection

@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                user: [],
                flag: true,
                form: {
                    image: '',
                    department: '',
                    subject: '',
                    body: '',
                    attachment: '',
                },
                error: {
                    department: '',
                    subject: '',
                    body: '',
                },
                allErrors: [],
            },
            methods: {
                fetchUser() {
                    let data = this;
                    axios.get(`/panel/fetch/user`).then(res => {
                        data.user = res.data;
                        data.form.image = data.user.image;
                    });
                },
                exit() {
                    this.$refs.formExit.submit();
                },
                onImageChange(e) {
                    this.form.attachment = e.target.files[0];
                },
                formSubmit(e) {
                    e.preventDefault();
                    let data = this;
                    body = this.form.body.replace(/\r?\n/g, '<br>');
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };
                    let formData = new FormData();
                    formData.append('department', this.form.department);
                    formData.append('subject', this.form.subject);
                    formData.append('attachment', this.form.attachment);
                    formData.append('body', body);
                    axios.post('/panel/ticket/form/store', formData, config)
                        .then(function (response) {
                            data.error.department = '';
                            data.error.subject = '';
                            data.error.body = '';
                            swal.fire(
                                {
                                    text: " با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                        })
                        .catch(function (error) {
                            data.error.department = '';
                            data.error.subject = '';
                            data.error.body = '';
                            data.allErrors = error.response.data.errors;

                            if (Array.isArray(error.response.data.errors.department)) {
                                data.error.department = data.allErrors.department[0];
                            }
                            if (Array.isArray(error.response.data.errors.subject)) {
                                data.error.subject = data.allErrors.subject[0];
                            }
                            if (Array.isArray(error.response.data.errors.body)) {
                                data.error.body = data.allErrors.body[0];
                            }
                        });
                },
            },
            mounted: function () {
                this.fetchUser();
            }
        });

        $("#ticket-form-btn").addClass('active-menu');
    </script>
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="/layout/style.css">
    <style>
        #panel_side > li{
            text-align: right !important;
        }

        .active-menu .fa {
            color: #c40316
        }

        .active-menu span {
            font-weight: bold;
            color: #c40316 !important;
        }

        #panel_side li:hover a, #panel_side li:hover a span {
            color: white !important;
        }

        #panel_side li a {
            color: #c9c9c9
        }

        .account-img {
            display: none
        }

        .active-menu {
            background-color: aliceblue;
        }
    </style>
@endsection

