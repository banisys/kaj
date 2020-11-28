@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-4" id="area">
        <div class="row mb-4" v-if="progress">
            <progress :value="percent" max="100" style="width: 100%"></progress>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="card">
                        <div class="card-header"
                             style="padding-bottom: 0;background-color: #343a40;border-bottom: 0px;padding-left: 0;">
                            <ul class="nav nav-pills yy">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#gallery" data-toggle="tab">گالری
                                        تصاویر</a>
                                </li>
                                <li class="nav-item" style="margin: auto;margin-left:0px;">
                                    <button type="submit" @click="formSubmit"
                                            style="background-color: #099020;border: unset;color: white;width:60px;height: 40px;border-top-right-radius: 10px;">
                                        ثبت
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="gallery">
                                    <div class="row mt-1">
                                        <div class="col-md-12">
                                            <div class="uploader"
                                                 @dragenter="OnDragEnter"
                                                 @dragleave="OnDragLeave"
                                                 @dragover.prevent
                                                 @drop="onDrop"
                                                 :class="{ dragging: isDragging }">
                                                <div class="upload-control" v-show="images.length">
                                                    <label for="file"
                                                           style="background-color: #838383;border: unset;padding: 5px">انتخاب
                                                        عکس</label>
                                                </div>
                                                <div v-show="!images.length">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    <div class="file-input">
                                                        <label for="file">انتخاب عکس</label>
                                                        <input type="file" id="file" @change="onInputChange" multiple>
                                                    </div>
                                                </div>
                                                <div class="images-preview" v-show="images.length">
                                                    <div class="img-wrapper" v-for="(image, index) in images"
                                                         :key="index" style="position: relative">
                                                        <a @click="deleteImage(index)">
                                                            <i class="fa fa-times del"></i>
                                                        </a>
                                                        <img :src="image">
                                                        <div class="details">
                                                            <span class="name" v-text="files[index].name"></span>
                                                            <span class="size"
                                                                  v-text="getFileSize(files[index].size)"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span style="color: red;margin-top: 12px;"> @{{ error.pics }} </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
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
                error: {name: '', short_desc: ''},
                attachments: [],
                counter: [],
                isDragging: false,
                dragCount: 0,
                files: [],
                images: [],
                percent: 0,
                progress: false,
            },
            methods: {
                OnDragEnter(e) {
                    e.preventDefault();
                    this.dragCount++;
                    this.isDragging = true;
                    return false;
                },
                OnDragLeave(e) {
                    e.preventDefault();
                    this.dragCount--;
                    if (this.dragCount <= 0)
                        this.isDragging = false;
                },
                onInputChange(e) {
                    const files = e.target.files;
                    Array.from(files).forEach(file => this.addImage(file));
                },
                onDrop(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.isDragging = false;
                    const files = e.dataTransfer.files;
                    Array.from(files).forEach(file => this.addImage(file));
                },
                addImage(file) {
                    if (!file.type.match('image.*')) {
                        this.$toastr.e(`${file.name} is not an image`);
                        return;
                    }
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
                formSubmit(e) {
                    e.preventDefault();
                    var _this = this;
                    let data = this;
                    this.progress = true;
                    var formData = new FormData;

                    this.files.forEach(file => {
                        formData.append('pics[]', file, file.name);
                    });

                    axios.post('/admin/image/store', formData,
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
                        data.images = [];
                        data.files = [];
                    }).catch(function (error) {
                        data.progress = false;
                        this.allerros = error.response.data.errors;
                        x = error.response.data.errors;

                        if (Array.isArray(x.pics)) {
                            data.error.pics = this.allerros.pics[0];
                        }
                    });
                },
            },
            mounted: function () {
            }
        })
    </script>
    <script>
        $("#side_image").addClass("menu-open");
        $("#side_image_add").addClass("active");
    </script>
@endsection

@section('style')
    <style>
        .bootstrap-tagsinput .tag {
            border-radius: 5px;
            padding: 1px 8px;
        }

        .bootstrap-tagsinput {
            width: 100%;

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

