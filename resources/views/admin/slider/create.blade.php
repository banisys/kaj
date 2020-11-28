@extends('layouts.admin.admin')

@section('content')
    <div class="container" id="area">
        <div class="row mb-4" v-if="progress">
            <progress :value="percent" max="100" style="width: 100%"></progress>
        </div>
        <div class="row">
            <table class="table table-striped">
                <tbody>
                <tr v-for="(item, index) in slidesDemo">
                    <td>
                        <img style="width:200px" :src="'/images/slider/'+item.image">
                    </td>
                    <td>@{{item.url}}</td>
                    <td>
                        <a @click="deleteSlide(item.id)">
                            <i class="fa fa-times" style="color: #dc3545;
                font-size: 19px;"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="form-group">

                    <button class="btn btn-info mb-2" @click.stop.prevent="addRow()">
                        افزودن اسلاید
                    </button>
                    <button class="btn btn-primary" type="submit" @click="formSubmit" style="float:left">
                        ثبت
                    </button>

                    <ul style="list-style:none;">
                        <li v-for="(slide, index) in slides">

                            <input type="file" @change="onInputChange"
                                   class="form-control col-md-3 mb-2 ml-2"
                                   style="display: inline-block">

                            <input type="text" v-model="slide.url"
                                   placeholder="URL"
                                   class="form-control col-md-4 mb-2 ml-2"
                                   style="display: inline-block;direction: ltr">

                            <a @click="deleteRow(index)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/ckeditor/ckeditor.js')}}"></script>
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                slides: [],
                slidesDemo: [],
                files: [],
                images: [],
                progress: false,
                percent: 0,
            },
            methods: {
                addImage(file) {
                    this.files.push(file);
                    const reader = new FileReader();
                    reader.onload = (e) => this.images.push(e.target.result);
                    reader.readAsDataURL(file);
                },
                deleteImage(index) {
                    this.images.splice(index, 1);
                    this.files.splice(index, 1);
                },
                getFileSize(size) {
                    const fSExt = ['Bytes', 'KB', 'MB', 'GB'];
                    let i = 0;

                    while (size > 900) {
                        size /= 1024;
                        i++;
                    }
                    return `${(Math.round(size * 100) / 100)} ${fSExt[i]}`;
                },
                addRow() {
                    this.slides.push({});
                },
                deleteRow(index) {
                    this.colors.splice(index, 1)
                },
                onInputChange(e) {
                    const files = e.target.files;
                    Array.from(files).forEach(file => this.addImage(file));
                },
                formSubmit(e) {
                    e.preventDefault();
                    let _this = this;
                    this.progress = true;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };

                    var formData = new FormData;
                    slides = JSON.stringify(_this.slides);

                    this.files.forEach(file => {
                        formData.append('pics[]', file, file.name);
                    });

                    formData.append('urls', slides);

                    axios.post('/admin/slider/store', formData,
                        {
                            headers: {'content-type': 'multipart/form-data'},
                            onUploadProgress: function (uploadEvent) {
                                _this.percent = Math.round((uploadEvent.loaded / uploadEvent.total) * 100);
                            }
                        }
                    ).then(function (res) {
                        swal.fire(
                            {
                                text: " با موفقیت ثبت شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        _this.getSlider();
                        _this.percent = 0;
                        _this.progress = false;
                        _this.slides = [];
                        _this.images = [];
                        _this.files = [];
                    }).catch(function (error) {

                    });
                },
                getSlider() {
                    let _this = this;
                    axios.get(`/admin/slider/fetch/slide`).then(res => {
                        _this.slidesDemo = res.data;
                    });
                },
                deleteSlide(id) {
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
                            axios.get(`/admin/slider/delete/${id}`)
                                .then(() => {
                                    swal.fire(
                                        {
                                            text: "با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    _this.getSlider();
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
            },
            mounted: function () {
                this.getSlider();
            }
        })
    </script>


    <script>
        $("#side_setting").addClass("menu-open");
        $("#side_slider_create").addClass("active");
    </script>
@endsection

@section('style')

@endsection

