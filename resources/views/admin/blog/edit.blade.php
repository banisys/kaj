@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-4" id="area">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"
                         style="padding-bottom: 0;background-color: #343a40;border-bottom: 0px;padding-left: 0;">
                        <ul class="nav nav-pills yy">
                            <li class="nav-item"><a class="nav-link active" href="#public"
                                                    data-toggle="tab">عمومی</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#seo" data-toggle="tab">
                                    بهینه سازی</a>
                            </li>
                            <li class="nav-item" style="margin: auto;margin-left:0px;">
                                <button type="submit" @click="formSubmit"
                                        style="background-color:#28a745;border: unset;color: white;width:60px;height: 40px;border-top-right-radius: 10px;">
                                    ثبت
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="public">
                                <div class="container">
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label for="exampleFormControlSelect1">دسته بندی :</label>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                        v-model="form.cat">
                                                    <option value="" disabled hidden>انتخاب کنید...</option>
                                                    <option v-for="cat in cats" :value="cat.id">
                                                        @{{ cat.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <span style="color: red"> @{{ error.cat }} </span>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label">عنوان :</label>
                                                <input type="text" class="form-control" @keyup="createUrl"
                                                       v-model="form.name">
                                            </div>
                                            <span style="color: red"> @{{ error.name }} </span>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label">url :</label>
                                                <input type="text" class="form-control" v-model="form.url">
                                            </div>
                                            <span style="color: red"> @{{ error.name }} </span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="form-group" style="margin-bottom:7px">
                                                <label for="exampleFormControlSelect3">متن صفحه :</label>
                                                <textarea type="text" name="editor1" class="cke_rtl"></textarea>
                                            </div>
                                            <span style="color: red;"> @{{ error.short_desc }} </span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <table class="table table-striped">
                                                <tbody>
                                                <tr v-for="(title, index) in hhh">
                                                    <td style="font-weight: bold">عنوان @{{ index+1 }} :</td>
                                                    <td>@{{title}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="form-group">
                                                <button class="btn btn-info mb-3" @click.stop.prevent="addRow()">
                                                    افزودن عنوان محتوا
                                                </button>
                                                <ul style="list-style:none;">
                                                    <li v-for="(title, index) in titles">
                                                        <lable class="ml-2" style="font-weight: bold">
                                                            عنوان @{{ index+1 }} :
                                                        </lable>
                                                        <input type="text"
                                                               v-model="title.name"
                                                               class="form-control col-md-9 mb-2 ml-2"
                                                               style="display: inline-block">
                                                        <a @click="deleteRow(index)" style="font-size:19px;">
                                                            <i class="fa fa-times" style="color: #dc3545"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="display: block;float: left">
                                                <img v-if="form.image" :src="'/images/blog/'+form.image"
                                                     style="width: 300px" id="blah" class="ml-2"/>
                                                <span style="color: red"> @{{ error.image }} </span>
                                                <label for="fileImage" id="label_file" class="btn btn-success mr-1"
                                                       style="font-weight: lighter;margin-bottom: 0;vertical-align: top;">تصویر
                                                </label>
                                                <input type="file" onchange="readURL(this);" style="display:none;"
                                                       id="fileImage"
                                                       name="fileImage" @change="onImageChange">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="seo">
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group" style="margin-bottom: 7px">
                                            <label class="col-md-4 control-label" style="max-width: 100%">عنوان صفحه
                                                :</label>
                                            <input type="text" class="form-control" v-model="form.seo_title">
                                        </div>
                                        <span style="color: red;"> @{{ error.seo_title }} </span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="margin-bottom: 7px">
                                            <label class="col-md-4 control-label" style="max-width: 100%">کلمات
                                                کلیدی :</label>
                                            <input type="text" class="form-control" data-role="tagsinput" id="key">
                                        </div>
                                        <span style="color: red;"> @{{ error.seo_key }} </span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">متای توضیحات :</label>
                                            <textarea type="number" class="form-control"
                                                      v-model="form.seo_description"
                                                      rows="8"></textarea>
                                        </div>
                                        <span style="color: red;"> @{{ error.seo_description }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                form: {
                    name: '',
                    image: '',
                    cat: '',
                    seo_title: '',
                    seo_key: '',
                    seo_description: '',
                },
                error: {name: '', description: ''},
                cats: [],
                blog_id: '',
                counter: [],
                isDragging: false,
                dragCount: 0,
                images: [],
                blog: [],
                pic: '',
                titles: [],
                hhh: [],
            },
            methods: {
                onImageChange(e) {
                    this.form.image = e.target.files[0];
                },
                fetchCat() {
                    let data = this;
                    axios.get('/admin/blog/fetch/cat').then(res => {
                        data.cats = res.data;
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    let data = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };

                    seo_key = $("#key").val();
                    description = CKEDITOR.instances["editor1"].getData();
                    titles = JSON.stringify(data.titles);

                    let formData = new FormData();

                    formData.append('image', this.form.image);
                    formData.append('name', this.form.name);
                    formData.append('url', this.form.url);
                    formData.append('discount', this.form.discount);
                    formData.append('description', description);
                    formData.append('cat', this.form.cat);
                    formData.append('seo_title', this.form.seo_title);
                    formData.append('seo_key', seo_key);
                    formData.append('seo_description', this.form.seo_description);
                    formData.append('titles', titles);

                    parts = window.location.href.split('/');
                    id = parts.pop() || parts.pop();
                    axios.post(`/admin/blog/update/${id}`, formData, config).then(function (res) {
                        swal.fire(
                            {
                                text: "تغییرات با موفقیت اعمال شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        data.fetchBlog(id);
                        data.images = [];
                        data.titles = [];
                    }).catch(function (error) {
                        data.error.name = "";
                        data.error.description = "";
                        data.error.image = "";
                        data.error.cat = "";
                        data.error.seo_title = "";
                        data.error.seo_key = "";
                        data.error.seo_description = "";
                        this.allerros = error.response.data.errors;
                        x = error.response.data.errors;
                        if (Array.isArray(x.name)) {
                            data.error.name = this.allerros.name[0];
                        }
                        if (Array.isArray(x.cat)) {
                            data.error.cat = this.allerros.cat[0];
                        }
                        if (Array.isArray(x.image)) {
                            data.error.image = this.allerros.image[0];
                        }
                        if (Array.isArray(x.seo_title)) {
                            data.error.seo_title = this.allerros.seo_title[0];
                        }
                        if (Array.isArray(x.seo_description)) {
                            data.error.seo_description = this.allerros.seo_description[0];
                        }
                        if (Array.isArray(x.seo_key)) {
                            data.error.seo_key = this.allerros.seo_key[0];
                        }
                        if (Array.isArray(x.pics)) {
                            data.error.pics = this.allerros.pics[0];
                        }
                    });
                },
                fetchBlog(id) {
                    let data = this;
                    axios.get(`/admin/blog/${id}`).then(res => {
                        data.blog = res.data;
                        data.hhh = JSON.parse(data.blog.titles);
                        data.form.name = data.blog.name;
                        data.form.url = data.blog.url;
                        data.form.cat = data.blog.cat_id;
                        data.form.seo_title = data.blog.seo_title;
                        data.form.seo_description = data.blog.seo_description;
                        $('#key').tagsinput('add', data.blog.seo_key);
                        data.form.image = data.blog.image;
                        CKEDITOR.instances["editor1"].setData(data.blog.description);
                    });
                },
                createUrl() {
                    this.form.url = this.form.name.replace(/ /g, "-");
                },
                addRow() {
                    this.titles.push({});
                },
                deleteRow(index) {
                    this.titles.splice(index, 1)
                },
                deleteTitle(id) {
                    data = this;
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
                            axios.get(`/admin/product/delete/color/image/${id}`).then(res => {
                                parts = window.location.href.split('/');
                                pro = parts.pop() || parts.pop();
                                // data.fetchColorImage(pro);
                            });
                        }
                    });
                },
            },
            mounted: function () {
                parts = window.location.href.split('/');
                id = parts.pop() || parts.pop();
                this.fetchCat();
                this.fetchBlog(id);
            }
        });
    </script>
    <script src="{{ asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.min.js')}}"></script>
    <script>
        CKEDITOR.replace('editor1', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 250
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(300);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $("#side_blog").addClass("menu-open");
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css" type="text/css"/>
    <style>
        .bootstrap-tagsinput .tag {
            border-radius: 5px;
            padding: 1px 8px;
        }

        .bootstrap-tagsinput {
            width: 100%;
            height: 39px;
            padding-top: 9px;
        }

        .yy .active {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
            color: #101010 !important;
            background-color: #ffffff !important;
            font-weight: bold;
        }

        .nav-pills .nav-link {
            color: #c2c7d0;
        }

        #cke_editor1, #cke_editor2 {
            width: 99%
        }
    </style>
    <style>
        .del {
            color: rgb(220, 53, 69);
            position: absolute !important;
            left: 3px !important;
            bottom: 4px !important;
            font-size: 23px !important;
        }

        .del2 {
            color: rgb(220, 53, 69);
            position: absolute !important;
            left: 12px !important;
            top: 4px !important;
            font-size: 23px !important;
        }

        .uploader {
            width: 100%;
            background: #ffffff;
            color: #a8a8a8;
            padding: 40px 15px;
            text-align: center;
            border-radius: 15px;
            border: 3px dashed #a8a8a8;
            font-size: 20px;
            position: relative;
        }

        .uploader.dragging {
            background: #fff;
            color: #cecece;
            border: 3px dashed #cecece;
        }

        .uploader.dragging .file-input label {
            background: #a8a8a8;
            color: #545454;
        }

        .uploader i {
            font-size: 85px;
        }

        .uploader .file-input {
            width: 200px;
            margin: auto;
            height: 68px;
            position: relative;
        }

        .uploader .file-input label, .uploader .file-input input {
            background: #a8a8a8;
            color: #ffffff;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            padding: 10px;
            border-radius: 4px;
            margin-top: 7px;
            cursor: pointer;
        }

        .uploader .file-input input {
            opacity: 0;
            z-index: -2;
        }

        .uploader .images-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .uploader .images-preview .img-wrapper {
            width: 160px;
            display: flex;
            flex-direction: column;
            margin: 10px;
            height: 150px;
            justify-content: space-between;
            background: #fff;
            box-shadow: 5px 5px 20px #3e3737;
        }

        .uploader .images-preview .img-wrapper img {
            max-height: 105px;
        }

        .uploader .images-preview .details {
            font-size: 12px;
            background: #fff;
            color: #000;
            display: flex;
            flex-direction: column;
            align-items: self-start;
            padding: 3px 6px;
        }

        .uploader .images-preview .details .name {
            overflow: hidden;
            height: 18px;
        }

        .uploader .upload-control {
            position: absolute;
            width: 100%;
            background: #fff;
            top: 0;
            left: 0;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            padding: 10px;
            padding-bottom: 4px;
            text-align: right;
        }

        .uploader .upload-control button, .uploader .upload-control label {
            background: #cecece;
            border: 2px solid #cecece;
            border-radius: 3px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .uploader .upload-control label {
            padding: 2px 5px;
            margin-right: 10px;
        }

        .nav-pills .nav-link:not(.active):hover {
            color: #ffffff !important;
        }
    </style>
@endsection

