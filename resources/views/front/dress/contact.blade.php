@extends('layouts.front.dress')
@section('content')
    <div id="area">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h1 style="color: #123b66;padding-bottom: 8px;">تماس با ما</h1>
                    <p style="text-align: justify;font-size:15px;line-height: 30px;" v-html="contact"></p>
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
                contact: '',
            },
            methods: {
                fetch() {
                    let _this = this;
                    axios.get('/admin/about/fetch').then(res => {
                        _this.contact = res.data.contact;
                    });
                },
            },
            mounted: function () {
                this.fetch();
            }
        });
    </script>

@endsection

@section('style')

@endsection

