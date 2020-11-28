@extends('layouts.admin.admin')
@section('content')
    <div class="container pb-5 pt-4" id="area">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">درباره ما</label>
                    <textarea class="form-control"
                              name="editor1"
                              rows="12"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">تماس با ما</label>
                    <textarea class="form-control"
                              name="editor2"
                              rows="12"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">شرایط تحویل کالا</label>
                    <textarea class="form-control"
                              name="editor3"
                              rows="12"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">قوانین استفاده از سایت</label>
                    <textarea class="form-control"
                              name="editor4"
                              rows="12"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">پرداخت آنلاین</label>
                    <textarea class="form-control"
                              name="editor5"
                              rows="12"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" @click="formSubmit" class="float-left"
                        style="background-color: #099020;border: unset;color: white;width:60px;height: 40px;border-radius: 5px">
                    ثبت
                </button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/ckeditor/ckeditor.js')}}"></script>
    <script>
        new Vue({
            el: '#area',
            data: {
                about: '',
                contact: '',
                rolls: '',
                delivery: '',
                online: '',
            },
            methods: {
                fetch() {
                    let _this = this;
                    axios.get('/admin/about/fetch').then(res => {
                        CKEDITOR.instances["editor1"].setData(res.data.about);
                        CKEDITOR.instances["editor2"].setData(res.data.contact);
                        CKEDITOR.instances["editor3"].setData(res.data.rolls);
                        CKEDITOR.instances["editor4"].setData(res.data.delivery);
                        CKEDITOR.instances["editor5"].setData(res.data.online);
                    });
                },
                formSubmit(e) {
                    e.preventDefault();
                    var _this = this;

                    var formData = new FormData;

                    about = CKEDITOR.instances["editor1"].getData();
                    contact = CKEDITOR.instances["editor2"].getData();
                    rolls = CKEDITOR.instances["editor3"].getData();
                    delivery = CKEDITOR.instances["editor4"].getData();
                    online = CKEDITOR.instances["editor5"].getData();

                    formData.append('about', about);
                    formData.append('contact', contact);
                    formData.append('rolls', rolls);
                    formData.append('delivery', delivery);
                    formData.append('online', online);

                    axios.post('/admin/about/update', formData
                    ).then(function (res) {
                        swal.fire(
                            {
                                text: "با موفقیت ثبت شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        _this.fetch();
                    });
                },
            },
            mounted: function () {
                this.fetch();
            }
        });
    </script>

    <script>
        $("#side_about").addClass("menu-open");
        $("#side_about_edit").addClass("active");
    </script>

    <script>
        CKEDITOR.replace('editor1', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 250
        });
        CKEDITOR.replace('editor2', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 250,
        });
        CKEDITOR.replace('editor3', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 250,
        });
        CKEDITOR.replace('editor4', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 250,
        });
        CKEDITOR.replace('editor5', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 250,
        });
    </script>
@endsection
@section('style')

@endsection
