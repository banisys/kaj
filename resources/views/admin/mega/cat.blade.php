@extends('layouts.admin.admin')
@section('title') دسته مگامنو @endsection
@section('content')
    <div class="container" id="area">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" @submit="formSubmit">
                    <div class="container">
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="name" type="text" class="form-control" name="name"
                                           placeholder="نام دسته..."
                                           v-model="form.name">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fileImage" id="label_file" class="btn btn-success"
                                           style="font-weight: lighter;margin-bottom: 0">آیکون</label>
                                    <input type="file" onchange="readURL(this);" style="display:none;" id="fileImage"
                                           name="fileImage" @change="onImageChange">
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

        <div class="row mt-5">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">نام دسته</th>
                        <th scope="col">آیکون</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(megaCat,index) in megaCats.data">
                        <td>@{{megaCat.name}}</td>
                        <td>
                            <img style="width:50px" v-if="megaCat.image" :src="'/images/mega/'+megaCat.image">
                        </td>

                        <td>
                            <a @click="deleteMegaCat(megaCat.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-2">
            <pagination :data="megaCats" @pagination-change-page="fetchMegaCats"></pagination>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                form: {
                    name: '',
                    image: '',
                },
                megaCats: [],
                pic: '',
            },
            methods: {
                onImageChange(e) {
                    this.form.image = e.target.files[0];
                },
                fetchMegaCats(page = 1) {
                    axios.get('/admin/mega/cat/fetch?page=' + page).then(res => {
                        this.$data.megaCats = res.data;
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    let data = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };
                    let formData = new FormData();
                    formData.append('name', this.form.name);
                    formData.append('image', this.form.image);

                    axios.post('/admin/mega/store/mega/cat', formData, config)
                        .then(function (response) {
                            swal.fire(
                                {
                                    text: " با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                            data.fetchMegaCats();
                        })
                        .catch(function (error) {

                        });
                },
                deleteMegaCat(id) {
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
                            axios.get(`/admin/mega/cat/delete/${id}`)
                                .then(() => {
                                    swal.fire(
                                        {
                                            text: " با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    this.fetchMegaCats();
                                }).catch(() => {
                                swal.fire(
                                    {
                                        text: "درخواست شما انجام نشد !",
                                        type: "error",
                                        confirmButtonText: 'باشه',
                                    }
                                );
                            });

                        }
                    });
                },
            },
            mounted: function () {
                this.fetchMegaCats();
            }
        });
    </script>
    <script>
        $("#side_mega").addClass("menu-open");
        $("#side_maga_cat").addClass("active");
    </script>
@endsection
@section('style')@endsection
