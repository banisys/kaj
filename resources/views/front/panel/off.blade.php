@extends('layouts.front.online')
@section('content')

    <div class="clearfix container mb-5" id="area" style="max-width: 1140px">
        <div class="col-lg-9 float-right pl-0 content">
            <div class="col-md-12 orders pl-0 mt-5 text-center">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">کد تخفیف</th>
                        <th scope="col">دسته بندی</th>
                        <th scope="col">برند</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(off,index) in offs">
                        <td>@{{ off.code}}</td>
                        <td>@{{ ifZeroCat(off.category)}}</td>
                        <td>@{{ ifZeroBrand(off.brand)}}</td>
                    </tr>
                    </tbody>
                </table>
                <div v-if="!offs.length"
                     class="alert alert-info" role="alert" style="text-align: center">
                    کد تخفیفی برای شما وجود ندارد !
                </div>
            </div>
        </div>
        @include('layouts.front.aside')
    </div>


@endsection

@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                offs: [],
                user: [],
                form: {
                    image: '',
                },
                flag: true,
            },
            methods: {
                fetchOffs() {
                    let data = this;
                    axios.get('/offs/fetch').then(res => {
                        data.offs = res.data;
                    });
                },
                ifZeroCat(data) {
                    if (data === "0") {
                        return "همه دسته ها"
                    } else {
                        return data;
                    }
                },
                ifZeroBrand(data) {
                    if (data === "0") {
                        return "همه برند ها"
                    } else {
                        return data;
                    }
                },
                fetchUser() {
                    let data = this;
                    axios.get(`/panel/fetch/user`).then(res => {
                        data.user = res.data;
                        data.form.image = data.user.image;
                        console.log(data.form.image);
                    });
                },
                exit() {
                    this.$refs.formExit.submit();
                },
            },
            mounted: function () {
                this.fetchOffs();
                this.fetchUser();
            }
        });

        $("#off-btn").addClass('active-menu');
    </script>
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="/layout/style.css">
    <style>
        #panel_side > li{
            text-align: right !important;
        }

        .admin {
            background-color: #ffef636b !important
        }

        .active-menu .fa {
            color: #c40316
        }

        .active-menu  {
            background-color: aliceblue;
        }

        .active-menu span {
            font-weight: bold;
            color: #c40316 !important;
        }

        #panel_side li:hover a, #panel_side li:hover a span {
            color: white !important;
        }

        #panel_side li a {
            color: #c9c9c9
        }

        .account-img {
            display: none
        }
    </style>
@endsection

