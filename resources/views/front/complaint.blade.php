@extends('layouts.front.dress')
@section('content')
    <div class="container my-5" style="direction: rtl;text-align: right" id="area">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>نام:</label>
                    <input type="text" class="form-control" v-model="name">
                </div>

                <div class="form-group">
                    <label>شماره همراه:</label>
                    <input type="text" class="form-control" v-model="mobile">
                </div>

                <div class="form-group">
                    <label>متن پیام</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="8"
                              v-model="ticket"></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-success" @click="formSubmit"
                            style="float: left;width: 140px;">
                        ارسال
                    </button>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

@endsection

@section('script')
    <script src="/carpet/js/jquery.elevateZoom-3.0.8.min.js"></script>
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                name: '',
                mobile: '',
                ticket: '',
            },
            methods: {
                formSubmit(e) {
                    e.preventDefault();
                    let _this = this;
                    axios.post('/complaint/store', {
                        name: this.name,
                        mobile: this.mobile,
                        ticket: this.ticket,
                    }).then(function (response) {
                        swal.fire(
                            {
                                text: "پیام شما با موفقیت ثبت شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        _this.name = '';
                        _this.mobile = '';
                        _this.ticket = '';
                    });
                },
            },
            mounted: function () {

            },
        });
    </script>

@endsection

@section('style')

@endsection

