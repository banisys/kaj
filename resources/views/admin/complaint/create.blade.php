@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-5 pb-5" id="area" style="position: relative">
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">موبایل</th>
                        <th scope="col">متن پیام</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(contact,index) in contacts">
                        <td>@{{contact.name}}</td>
                        <td>@{{contact.mobile}}</td>

                        <td>
                            <a @click="showDescription(contact.id)" style="font-size: 20px;">
                                <i class="fa fa-comment-alt ml-3" style="color: #17a2b8;"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

                <div v-if="showModal">
                    <transition name="modal">
                        <div class="modal-mask">
                            <div class="modal-dialog-scrollable" role="document" style="max-width:100%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" @click="showModal = false">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="text-align: center">

                                        <p>@{{ ticket }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
    </div>
@endsection
@section('script')
    <script>
        new Vue({
            el: '#area',
            data: {
                contacts: [],
                showModal: false,
                ticket: '',
            },
            methods: {
                fetch() {
                    let _this = this;
                    axios.get(`/admin/complaint/fetch`).then(res => {
                        _this.contacts = res.data;
                        console.log(_this.contacts);
                    });
                },
                showDescription(id) {
                    let _this = this;
                    this.showModal = true;

                    axios.get(`/admin/complaint/ticket/${id}`).then(function (res) {
                        _this.ticket = res.data;
                    });
                },
            },
            mounted: function () {
                this.fetch();
            }
        });
    </script>

    <script>
        $("#side_complaint").addClass("menu-open");
        $("#side_complaint_create").addClass("active");
    </script>
@endsection
@section('style')

@endsection
