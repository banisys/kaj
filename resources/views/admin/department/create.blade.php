@extends('layouts.admin.admin')

@section('title')  دپارتمان پشتیبانی سایت @endsection

{{--@section('breadcrumb')--}}
{{--    <li class="breadcrumb-item"><a href="#">خانه1</a></li>--}}
{{--    <li class="breadcrumb-item"><a href="#">خانه2</a></li>--}}
{{--    <li class="breadcrumb-item"><a href="#">خانه3</a></li>--}}
{{--    <li class="breadcrumb-item"><a href="#">خانه4</a></li>--}}
{{--@endsection--}}

@section('content')


    <div class="container" id="area">

        <vue-progress-bar></vue-progress-bar>


        <div class="row">


            <div class="col-md-12">
                <form class="form-horizontal" @submit="formSubmit">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-md-12 control-label">نام  :</label>
                                    <input id="name" type="text" class="form-control" placeholder="عنوان دپارتمان پشتیبانی" name="name" v-model="form.name"
                                           autofocus>
                                    <span style="color:red">@{{ error.name }}</span>
                                </div>
                            </div>

                            <div class="col-md-2" style="margin-top: 32px">

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        ثبت
                                    </button>
                                </div>
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

                        <th scope="col">نام</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"> </th>
                        <th scope="col">  </th>
                        <th scope="col"></th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <td>
                            <input type="text" name="name" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجو بر اساس نام">
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td></td>
                        <td></td>


                    </tr>
                    <tr v-for="depart in departs.data" :key="depart.id" >

                        <td>@{{depart.name}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>

                            <a @click="deleteDepartment(depart.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2">
                        <pagination :data="departs" @pagination-change-page="fetchDepartment"></pagination>
        </div>

    </div>
@endsection
@section('script')

    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                departs:'',
                form: {
                    name: '',
                },
                search: {
                    name: '',
                },
                error: {
                    name: '',
                },
            },
            methods: {
                fetchDepartment(page = 1) {
                    this.$Progress.start();
                    let data = this;
                    axios.get('/admin/department/fetchDepartment?page=' + page).then(res => {
                        data.departs = res.data;
                        console.log(data.departs);
                    });
                    this.$Progress.finish();
                },
                formSubmit(e) {
                    e.preventDefault();
                    let data = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };
                    let formData = new FormData();
                    formData.append('name', this.form.name);
                    axios.post('/admin/department/store', formData, config)
                        .then(function (response) {
                            data.form.name = "";
                            data.error.name = "";
                            swal.fire(
                                {
                                    text: "تخفیف با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                            data.fetchDepartment();
                        })
                        .catch(function (error) {
                            data.error.name = "";
                            this.allerros = error.response.data.errors;
                            x = error.response.data.errors;
                            if (Array.isArray(x.name)) {
                                data.error.name = this.allerros.name[0];
                            }
                        });
                },
                deleteDepartment(id) {
                    let data = this;
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

                            axios.get(`/admin/department/delete/${id}`)
                                .then(() => {
                                    swal.fire(
                                        {
                                            text: "تخفیف با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    data.fetchDepartment();
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
                searchName(page = 1) {
                    data = this;
                    if (this.search.name) {
                        axios.get('/admin/department/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.departs = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchDepartment();
                    }
                }
            },
            mounted: function () {
                this.fetchDepartment();


            }
        });
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
        .modal-content{    max-height: calc(100vh - -3.5rem) !important;height: 100vh }
    </style>
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
