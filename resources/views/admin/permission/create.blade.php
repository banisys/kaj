@extends('layouts.admin.admin')

@section('title') دسترسی ها @endsection

@section('content')

    <div class="container" id="area">
        <vue-progress-bar></vue-progress-bar>
        <div class="row">
            <div class="col-md-12">
                <form class="form-inline" method="post" enctype="multipart/form-data" @submit="formSubmit">
                    <label for="name" class="ml-3"> نام : </label>
                    <input type="text" name="name" class="form-control" v-model="form.name" autofocus id="name">

                    <label for="name" class="ml-3 mr-5"> عنوان : </label>
                    <input type="text" name="title" class="form-control" v-model="form.title" autofocus id="name">

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
                            <input type="text" name="id" class="form-control" v-model="search.id" @keyup="searchId" placeholder="جستجو بر اساس کد">
                        </td>
                        <td>
                            <input type="text" name="name" class="form-control" v-model="search.name" @keyup="searchName" placeholder="جستجو بر اساس نام">
                        </td>
                        <td>
                            <input type="text" name="title" class="form-control" v-model="search.title" @keyup="searchTitle" placeholder="جستجو بر اساس عنوان">
                        </td>
                        <td></td>

                    </tr>
                    <tr v-for="(permission,index) in permissions.data" :key="permission.id">
                        <td>@{{permission.id}}</td>
                        <td>@{{permission.name}}</td>
                        <td>@{{ permission.title }}</td>
                        <td>
                            <a @click="deletePermission(permission.id,index)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>

                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-2">
            <pagination :data="permissions" @pagination-change-page="fetchPermissions"></pagination>
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
                form: {
                    name: '',
                    title: '',
                },
                search: {
                    id: '',
                    name: '',
                    title: '',
                },
                success: false,
                permissions: '',
                error: {
                    name: '',
                    title: '',
                },
                data_results: [],
            },
            methods: {
                fetchPermissions(page = 1) {
                    this.$Progress.start();
                    let data = this;
                    axios.get('/admin/permission/fetch?page=' + page).then(res => {
                        data.permissions = res.data;
                    });
                    this.$Progress.finish();
                },
                formSubmit(e) {
                    e.preventDefault();
                    this.$Progress.start();
                    let data = this;
                    axios.post('/admin/permission/store', {
                        name: this.form.name,
                        title: this.form.title,
                    })
                        .then(function (response) {
                            data.form.name = "";
                            data.form.title = "";
                            data.error.name = "";
                            data.error.title = "";

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
                            console.log(x);

                            if (Array.isArray(x.name)) {
                                data.error.name = this.allerros.name[0];
                            }

                            if (Array.isArray(x.title)) {
                                data.error.title = this.allerros.title[0];
                            }

                        });
                    this.fetchPermissions();
                    this.$Progress.finish();

                },
                deletePermission(id, index) {
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
                            axios.get(`/admin/permission/delete/${id}`)
                                .then(() => {
                                    // this.commentsData.splice(index, 1);
                                    swal.fire(
                                        {
                                            text: "Permission با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    this.fetchPermissions();
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
                        axios.get('/admin/permission/search?page=' + page, {params: {id: this.search.id}}).then(response => {
                            data.permissions = response.data;
                        });
                    }
                    if (this.search.id.length === 0) {
                        this.fetchPermissions();
                    }
                },
                searchName(page = 1) {
                    data = this;
                    if (this.search.name.length > 0) {
                        axios.get('/admin/permission/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.permissions = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchPermissions();
                    }
                },
                searchTitle(page = 1) {
                    data = this;
                    if (this.search.title.length > 0) {
                        axios.get('/admin/permission/search?page=' + page, {params: {title: this.search.title}}).then(response => {
                            data.permissions = response.data;
                        });
                    }
                    if (this.search.title.length === 0) {
                        this.fetchPermissions();
                    }
                },
            },
            mounted: function () {
                this.fetchPermissions();
            }
        })
    </script>
@endsection

