@extends('layouts.admin.admin')

@section('content')
    <div class="container mt-5" id="area">
        <div class="row mb-4" v-if="progress">
            <progress :value="percent" max="100" style="width: 100%"></progress>
        </div>

        <div class="row index">
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12" style="border:solid #f3a395 1px">
                        <input @keyup.enter="formSubmitUrl"
                               type="text" style="display: block;width: 100%;direction:ltr" v-model="one">
                        <img :src="'/images/index/'+i1.image" style="position: relative;">
                        <input type="file" style="position: absolute;bottom: 5px;right: 10px;opacity: .5"
                               @change="formSubmit($event,1)">
                    </div>
                    <div class="col-md-12 mt-4" style="border:solid #f3a395 1px">
                        <input @keyup.enter="formSubmitUrl"
                               type="text" style="display: block;width: 100%;direction:ltr" v-model="tow">
                        <img :src="'/images/index/'+i2.image" style="position: relative">
                        <input type="file" style="position: absolute;bottom: 5px;right: 10px;opacity: .5"
                               @change="formSubmit($event,2)">
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="border:solid #f3a395 1px">
                <div class="row">
                    <div class="col-12">
                        <input @keyup.enter="formSubmitUrl"
                               type="text" style="display: block;width: 100%;direction:ltr" v-model="three">
                        <img :src="'/images/index/'+i3.image" style="position: relative">
                        <input type="file" style="position: absolute;bottom: 5px;right: 10px;opacity: .5"
                               @change="formSubmit($event,3)">
                    </div>

                    <div class="col-md-12" style="border:solid #f3a395 1px">
                        <input @keyup.enter="formSubmitUrl"
                               type="text" style="display: block;width: 100%;direction:ltr" v-model="four">
                        <img :src="'/images/index/'+i4.image" style="position: relative">
                        <input type="file" style="position: absolute;bottom: 5px;right: 10px;opacity: .5"
                               @change="formSubmit($event,4)">
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-12 mt-4" style="border:solid #f3a395 1px">
                        <input @keyup.enter="formSubmitUrl"
                               type="text" style="display: block;width: 100%;direction:ltr" v-model="five">
                        <img :src="'/images/index/'+i5.image" style="position: relative">
                        <input type="file" style="position: absolute;bottom: 5px;right: 10px;opacity: .5"
                               @change="formSubmit($event,5)">
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#area',
            data: {
                one: '',
                tow: '',
                three: '',
                four: '',
                five: '',
                i1: '',
                i2: '',
                i3: '',
                i4: '',
                i5: '',
                progress: false,
                percent: 0,
            },
            methods: {
                formSubmit(e, index) {
                    e.preventDefault();

                    let _this = this;
                    this.progress = true;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };

                    var formData = new FormData;

                    formData.append('image', e.target.files[0]);
                    formData.append('index', index);

                    axios.post('/admin/index/image/store', formData,
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
                        _this.percent = 0;
                        _this.progress = false;
                        _this.fetchImage();
                    });
                },
                formSubmitUrl(e) {
                    e.preventDefault();
                    let _this = this;
                    var formData = new FormData;

                    formData.append('one', _this.one);
                    formData.append('tow', _this.tow);
                    formData.append('three', _this.three);
                    formData.append('four', _this.four);
                    formData.append('five', _this.five);

                    axios.post('/admin/index/url/store', formData
                    ).then(function (res) {
                        swal.fire(
                            {
                                text: " با موفقیت ثبت شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                    });
                },
                fetchImage() {
                    let _this = this;
                    axios.get('/admin/index/fetch/image').then(res => {
                        console.log(res.data)
                        _this.i1 = res.data.i1;
                        _this.i2 = res.data.i2;
                        _this.i3 = res.data.i3;
                        _this.i4 = res.data.i4;
                        _this.i5 = res.data.i5;

                        _this.one = res.data.i1.url;
                        _this.tow = res.data.i2.url;
                        _this.three = res.data.i3.url;
                        _this.four = res.data.i4.url;
                        _this.five = res.data.i5.url;
                    })
                },
            },
            mounted: function () {
                this.fetchImage();
            }
        })
    </script>

    <script>
        $("#side_setting").addClass("menu-open");
        $("#side_index_add").addClass("active");
    </script>
@endsection

@section('style')
    <style>
        .index img {
            width: 100% !important;
        }

        input[type=text] {
            border: solid 1px #c7c7c7;
            border-radius: 4px;
            padding-left: 6px;
            margin-top: 5px;
        }

    </style>
@endsection

