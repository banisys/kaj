@extends('layouts.admin.admin')
@section('title') مدیران @endsection
@section('content')
    <div class="container" id="area">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" @submit="formSubmit">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-md-12 control-label">نام کاربری :</label>
                                    <input id="name" type="text" class="form-control" name="name" v-model="form.name"
                                           autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">ایمیل :</label>
                                    <input id="email" type="email" class="form-control" name="email"
                                           v-model="form.email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sss">نقش :</label>
                                    <select class="form-control" id="sss" v-model="form.roles">
                                        <option value="" disabled hidden>انتخاب کنید...</option>
                                        <option v-for="role in roles" :value="role.id">
                                            @{{ role.title }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <span style="color: red"> @{{ error.name }} </span>
                            </div>
                            <div class="col-md-4 ">
                                <span style="color: red"> @{{ error.email }} </span>
                            </div>
                            <div class="col-md-4">
                                <span style="color: red"> @{{ error.roles }} </span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="password" class="col-md-4 control-label">کلمه عبور :</label>
                                    <input id="password" type="password" class="form-control" v-model="form.password">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">تکرار کلمه عبور
                                        :</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" v-model="form.password_confirmation">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-md-12" style="text-align: right">
                                    <div class="form-group" style="margin-top:32px">

                                        <button type="submit" class="btn btn-primary" style="width: 100%">
                                            ثبت نام
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <span style="color: red"> @{{ error.password }} </span>
                            </div>

                        </div>
                    </div>
                </form>

            </div>

        </div>

        <div class="row mt-4">
            <div class="col-md-12">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">کد</th>
                        <th scope="col">نام کاربری</th>
                        <th scope="col">ایمیل</th>
                        <th scope="col"></th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" name="id" class="form-control" v-model="search.id" @keyup="searchId"
                                   placeholder="جستجو بر اساس کد">
                        </td>
                        <td>
                            <input type="text" name="name" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجو بر اساس نام کاربری">
                        </td>
                        <td>
                            <input type="text" name="title" class="form-control" v-model="search.email"
                                   @keyup="searchEmail" placeholder="جستجو بر اساس ایمیل">
                        </td>
                        <td></td>

                    </tr>
                    <tr v-for="(admin,index) in admins.data" :key="admin.id">
                        <td>@{{admin.id}}</td>
                        <td>@{{admin.name}}</td>
                        <td>@{{ admin.email }}</td>
                        <td>
                            <a @click="showRole(admin.id)" style="font-size: 20px;">
                                <i class="fa fa-eye ml-3" style="color: #007bff;"></i>
                            </a>
                            <a @click="editAdmin(admin.id,index)" style="font-size: 20px;">
                                <i class="fa fa-edit ml-3" style="color: #17a2b8;"></i>
                            </a>
                            <a @click="deleteAdmin(admin.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="row mt-2">
            <pagination :data="admins" @pagination-change-page="fetchAdmins"></pagination>
        </div>

    </div>
@endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                stat1: true,
                stat2: false,
                form: {
                    name: '', email: '', roles: '', password: '', password_confirmation: '',
                },
                search: {
                    name: '', title: '', permissions: [], roles: '',
                },
                admins: '',
                val_role: '',
                roles: '',
                error: {
                    name: '', email: '', roles: '', password: '', password_confirmation: '',
                },
                data_results: [],
            },
            methods: {
                fetchAdmins(page = 1) {

                    this.$Progress.start();
                    let data = this;
                    axios.get('/admin/fetch?page=' + page).then(res => {
                        data.admins = res.data;
                        console.log(data.admins);
                    });
                    this.$Progress.finish();
                },
                fetchRoles() {
                    let data = this;
                    axios.get('/admin/get-roles').then(res => {
                        data.roles = res.data;
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    let data = this;
                    axios.post('/admin/register', {
                        name: this.form.name,
                        email: this.form.email,
                        password: this.form.password,
                        password_confirmation: this.form.password_confirmation,
                        roles: this.form.roles
                    }).then(function (response) {
                        data.form.name = "";
                        data.form.email = "";
                        data.form.password = "";
                        data.form.password_confirmation = "";
                        $('option', $("#select-role")).each(function (element) {
                            $(this).removeAttr('selected').prop('selected', false);
                        });
                        $("#select-role").multiselect('refresh');
                        data.error.name = "";
                        data.error.email = "";
                        data.error.role = "";
                        data.error.password = "";
                        data.error.password_confirmation = "";

                        swal.fire(
                            {
                                text: "Permission با موفقیت ثبت شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                    })
                        .catch(function (error) {
                            data.error.name = "";
                            data.error.email = "";
                            data.error.role = "";
                            data.error.password = "";
                            data.error.password_confirmation = "";
                            this.allerros = error.response.data.errors;
                            x = error.response.data.errors;

                            if (Array.isArray(x.name)) {
                                data.error.name = this.allerros.name[0];
                            }

                            if (Array.isArray(x.email)) {
                                data.error.email = this.allerros.email[0];
                            }

                            if (Array.isArray(x.roles)) {
                                data.error.roles = this.allerros.roles[0];
                            }

                            if (Array.isArray(x.password)) {
                                data.error.password = this.allerros.password[0];
                            }
                        });
                    this.fetchAdmins();
                },
                editAdmin(id, index) {
                    let data = this;
                    this.form.name = this.admins.data[index].name;
                    this.form.email = this.admins.data[index].email;
                    axios.get(`/admin/role/fetchPermission/${id}`).then(function (res) {
                        data.val_permission = res.data;
                    }).catch(function (error) {
                    });
                },
                showRole(id) {
                    let data = this;

                    axios.get(`/admin/fetchRole/${id}`).then(function (res) {
                        data.val_role = res.data;

                        swal.fire({
                            title: '<strong>نقش ها</strong>',
                            type: 'info',
                            html: data.val_role,
                            showCloseButton: false,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText:
                                'باشه',
                        })
                    }).catch(function (error) {
                    });
                },
                iterate(id) {

                    var arrayLength = this.permissions.length;
                    var arrayLength2 = this.val_permission.length;

                    for (var i = 0; i < arrayLength; i++) {

                        for (var j = 0; j < arrayLength2; j++) {

                            if (this.permissions[j].id === this.val_permission[j].id) {
                                return true;
                            }
                        }
                    }
                },
                deleteAdmin(id) {
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

                            axios.get(`/admin/delete/${id}`)
                                .then(() => {

                                    swal.fire(
                                        {
                                            text: "Permission با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    this.fetchAdmins();
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
                        axios.get('/admin/search?page=' + page, {params: {id: this.search.id}}).then(response => {
                            data.admins = response.data;
                        });
                    }
                    if (this.search.id.length === 0) {
                        this.fetchAdmins();
                    }
                },
                searchName(page = 1) {
                    data = this;
                    if (this.search.name.length > 0) {
                        axios.get('/admin/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.admins = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchAdmins();
                    }
                },
                searchEmail(page = 1) {
                    data = this;
                    if (this.search.email.length > 0) {
                        axios.get('/admin/search?page=' + page, {params: {email: this.search.email}}).then(response => {
                            data.admins = response.data;
                        });
                    }
                    if (this.search.email.length === 0) {
                        this.fetchAdmins();
                    }
                },
            },
            mounted: function () {
                this.fetchRoles();
                this.fetchAdmins();
            }
        })
    </script>
    <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
        setTimeout(function () {
            $(document).ready(function () {
                $('#select-role').multiselect({
                    nonSelectedText: 'انتخاب دسترسی',
                    nSelectedText: ' - تعداد انتخاب',
                    allSelectedText: 'تمام گزینه ها انتخاب شد',
                    numberDisplayed: 2
                });
            });
        }, 1000);
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
            width: 326px !important;
            text-align: right !important;
            background-color: white;
            min-height: 26px !important;
        }

        .dropdown-toggle::after {
            display: none !important;
        }
    </style>
@endsection