@extends('layouts.admin.admin')

@section('title') سطح دسترسی @endsection

@section('content')

    <div class="container" id="area">
        <div class="row">
            <div class="col-md-12">
                <form class="form-inline" method="post" enctype="multipart/form-data" @submit="formSubmit">
                    <label for="name" class="ml-3"> نام : </label>
                    <input type="text" name="name" class="form-control" v-model="form.name" autofocus id="name">

                    <label for="name" class="ml-3 mr-5"> عنوان : </label>
                    <input type="text" name="title" class="form-control" v-model="form.title" autofocus id="name">

                    <label for="name" class="ml-3 mr-5"> </label>

                    <select multiple="multiple" id="select-permission">
                        <option v-for="permission in permissions" :value="permission.id">
                            @{{ permission.title }}
                        </option>
                    </select>


                    <div class="form-check">
                        <button type="submit" class="btn btn-primary">ثبت</button>
                    </div>
                </form>
            </div>

        </div>

        <div class="row mt-2">
            <div class="col-md-3">
                <span style="color: red"> @{{ error.name }} </span>
            </div>
            <div class="col-md-3 mr-3">
                <span style="color: red"> @{{ error.title }} </span>
            </div>
            <div class="col-md-3 mr-5">
                <span style="color: red"> @{{ error.permissions }} </span>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">کد</th>
                        <th scope="col">نام</th>
                        <th scope="col">عنوان</th>
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
                                   @keyup="searchName" placeholder="جستجو بر اساس نام">
                        </td>
                        <td>
                            <input type="text" name="title" class="form-control" v-model="search.title"
                                   @keyup="searchTitle" placeholder="جستجو بر اساس عنوان">
                        </td>
                        <td></td>

                    </tr>
                    <tr v-for="(role,index) in roles.data" :key="role.id">
                        <td>@{{role.id}}</td>
                        <td>@{{role.name}}</td>
                        <td>@{{ role.title }}</td>
                        <td>
                            <a @click="showRole(role.id)" style="font-size: 20px;">
                                <i class="fa fa-eye ml-3" style="color: #17a2b8;"></i>
                            </a>
                            <a @click="editRole(role.id,index)" style="font-size: 20px;">
                                <i class="fa fa-edit ml-3" style="color: #17a2b8;"></i>
                            </a>
                            <a @click="deleteRole(role.id,index)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>

                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="row mt-2">
            <pagination :data="roles" @pagination-change-page="fetchRoles"></pagination>
        </div>

        <div class="panel-footer" v-if="data_results.length">
            <ul class="list-group">
                <li class="list-group-item" v-for="result in data_results">@{{ result.name }}</li>
            </ul>
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
                    name: '', title: '', permissions: [], roles: '',
                },
                search: {
                    name: '', title: '', permissions: [], roles: '',
                },
                permissions: '',
                val_permission: '',
                roles: '',
                error: {
                    name: '', title: '', permissions: ''
                },
                data_results: [],
            },
            methods: {
                fetchRoles(page = 1) {

                    this.$Progress.start();
                    let data = this;
                    axios.get('/admin/role/fetch?page=' + page).then(res => {
                        data.roles = res.data;
                    });
                    this.$Progress.finish();
                },
                fetchPermissions() {
                    let data = this;
                    axios.get('/admin/role/getPermission').then(res => {
                        data.permissions = res.data;
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    this.$Progress.start();
                    let data = this;
                    var permissions = $('#select-permission').val();
                    axios.post('/admin/role/store', {
                        name: this.form.name,
                        title: this.form.title,
                        permissions: permissions
                    }).then(function (response) {
                        data.form.name = "";
                        data.form.title = "";
                        $('option', $("#select-permission")).each(function (element) {
                            $(this).removeAttr('selected').prop('selected', false);
                        });
                        $("#select-permission").multiselect('refresh');
                        data.error.name = "";
                        data.error.title = "";
                        data.error.permissions = "";

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
                            data.error.title = "";
                            this.allerros = error.response.data.errors;
                            x = error.response.data.errors;

                            if (Array.isArray(x.name)) {
                                data.error.name = this.allerros.name[0];
                            }

                            if (Array.isArray(x.title)) {
                                data.error.title = this.allerros.title[0];
                            }

                            if (Array.isArray(x.permissions)) {
                                data.error.permissions = this.allerros.permissions[0];
                            }

                        });
                    this.fetchRoles();
                    this.$Progress.finish();

                },
                editRole(id, index) {
                    let data = this;
                    this.form.name = this.roles.data[index].name;
                    this.form.title = this.roles.data[index].title;
                    // this.stat2 = true;
                    axios.get(`/admin/role/fetchPermission/${id}`).then(function (res) {
                        data.val_permission = res.data;
                    }).catch(function (error) {
                    });
                },
                showRole(id) {
                    let data = this;

                    axios.get(`/admin/role/fetchPermission/${id}`).then(function (res) {
                        data.val_permission = res.data;

                        swal.fire({
                            title: '<strong>دسترسی ها</strong>',
                            type: 'info',
                            html: data.val_permission,
                            showCloseButton: false,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText:
                                'باشه',
                        })
                        // console.log(data.val_permission);
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
                deleteRole(id, index) {
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

                            axios.get(`/admin/role/delete/${id}`)
                                .then(() => {

                                    swal.fire(
                                        {
                                            text: "Permission با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    this.fetchRoles();
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
                        axios.get('/admin/role/search?page=' + page, {params: {id: this.search.id}}).then(response => {
                            data.roles = response.data;
                        });
                    }
                    if (this.search.id.length === 0) {
                        this.fetchRoles();
                    }
                },
                searchName(page = 1) {
                    data = this;
                    if (this.search.name.length > 0) {
                        axios.get('/admin/role/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.roles = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchRoles();
                    }
                },
                searchTitle(page = 1) {
                    data = this;
                    if (this.search.title.length > 0) {
                        axios.get('/admin/role/search?page=' + page, {params: {title: this.search.title}}).then(response => {
                            data.roles = response.data;
                        });
                    }
                    if (this.search.title.length === 0) {
                        this.fetchRoles();
                    }
                },
            },
            mounted: function () {
                this.fetchRoles();
                this.fetchPermissions();

            }
        })
    </script>
    <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
        setTimeout(function () {
            $(document).ready(function () {
                $('#select-permission').multiselect({
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
            width: 235px !important;
        }

        .multiselect-container label {
            display: block !important;
            text-align: right !important;
            color: #717171 !important;
            margin-top: 5px!important;

        }

        .multiselect {
            width: 210px !important;
            text-align: right !important;
            background-color: white;
            min-height: 26px !important;
        }

        .dropdown-toggle::after {
            display: none!important;
        }
    </style>
@endsection

