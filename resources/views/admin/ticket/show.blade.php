@extends('layouts.admin.admin')
@section('content')
    <div class="container" id="area">
        <div class="row" v-for="(ticket,index) in tickets">
            <div class="col-md-12 mb-4">
                <div class="container" style="border: 1px solid #e4e4e4">

                    <div class="row" :class="{ admin: ticket.admin_id }"
                         style="border-bottom: 1px solid #e4e4e4;padding: 6px 0;background-color:rgba(196, 228, 255, 0.65)">
                        <div class="col-md-12">
                            <template v-if="ticket.user">
                                <span style="float: right">@{{ ticket.user.name }}</span>
                            </template>
                            <template v-if="ticket.admin">

                                <span style="float: right">
                                    @{{ ticket.admin.name }}
                                </span>
                            </template>
                            <span style="float: left">- @{{ ticket.shamsi_c }}</span>
                            <span style="float: left;font-size: 14px;color: #9a9a9a;">@{{ clock(ticket.created_at) }}</span>

                            <a @click="downloadAttachment(ticket.attachment)"
                               style="font-size: 20px;float: left;margin-left: 10px" v-if="ticket.attachment">
                                <i class="fa fa-paperclip" style="color:#008000c2;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row" style="background-color: white">
                        <div class="col-md-12">
                            <p style="text-align: right;padding:6px 10px;margin-bottom: unset;"
                               v-html="ticket.body"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-3">
        <div class="row">
            <div class="form-group row" style="width: 100%">
                <label style="padding-top: 0" class="col-sm-1 col-form-label" for="depart">دپارتمان
                    : </label>
                <div class="col-sm-11" style="text-align: right">
                    <input type="hidden" v-model="form.department" class="form-control" id="subject"
                           readonly>
                    <span style="font-weight: bold">@{{ form.department }}</span>
                </div>
            </div>

            <div class="form-group row" style="width: 100%">
                <label style="padding-top: 0" for="subject" class="col-sm-1 col-form-label">موضوع : </label>
                <div class="col-sm-11" style="text-align: right">
                    <input type="hidden" v-model="form.subject" class="form-control" id="subject" readonly>
                    <span style="font-weight: bold">@{{ form.subject }}</span>
                </div>
            </div>

            <div class="form-group row" style="width: 100%">
                <label style="padding-top: 0" for="subject" class="col-sm-1 col-form-label">وضعیت : </label>
                <div class="col-sm-2" style="text-align: right">
                    <select class="form-control" id="depart" v-model="form.status">
                        <option value="" disabled hidden>انتخاب کنید...</option>
                        <option value="پاسخ داده شد">پاسخ داده شد</option>
                        <option value="در انتظار پاسخ">در انتظار پاسخ</option>
                        <option value="بسته شد">بسته شد</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" style="width: 100%">
                <label for="body" class="col-sm-1 col-form-label">متن پیام :</label>
                <div class="col-sm-11">
                    <textarea class="form-control" id="body" rows="9" v-model="form.body"></textarea>
                </div>
            </div>

            <div class="form-group row" style="width: 100%">
                <label for="attach" class="col-sm-1 col-form-label">ضمیمه ها :</label>
                <div class="col-sm-11">
                    <input type="file" id="attach" @change="onImageChange" style="float: right">
                    <button type="submit" class="btn btn-primary" @click="formSubmit"
                            style="float: left;width: 80px;background-color: #56718c;border-color: #56718c">
                        ثبت
                    </button>
                </div>
            </div>
            <div class="form-group row" style="text-align: right;width: 100%">
                <label for="attach" class="col-sm-1 col-form-label">

                </label>
                <label for="attach" class="col-sm-11 col-form-label"
                       style="color: rgb(220, 53, 69);padding-top: 0;font-size: 14px;">
                    ( اجازه افزودن فایل: .jpg, .gif, .jpeg, .png, .bmp, .doc, .txt )
                </label>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                tickets: [],
                form: {
                    image: '',
                    department: '',
                    subject: '',
                    body: '',
                    attachment: '',
                    status: '',
                },
            },
            methods: {
                fetchTicket() {
                    let data = this;
                    parts = window.location.href.split('/');
                    group = parts.pop() || parts.pop();
                    axios.get(`/admin/ticket/fetch/detail/${group}`).then(res => {
                        data.tickets = res.data;
                        data.form.department = data.tickets[0].department;
                        data.form.subject = data.tickets[0].subject;
                    });
                },
                clock(created_at) {
                    x = created_at.split(" ");
                    return x[1];
                },
                downloadAttachment(attachment) {
                    window.open(`/uploads/attachment/${attachment}`, '_blank');
                },
                formSubmit(e) {
                    e.preventDefault();
                    let data = this;
                    parts = window.location.href.split('/');
                    group = parts.pop() || parts.pop();
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };
                    let formData = new FormData();
                    body = this.form.body.replace(/\r?\n/g, '<br />');
                    formData.append('department', this.form.department);
                    formData.append('subject', this.form.subject);
                    formData.append('attachment', this.form.attachment);
                    formData.append('status', this.form.status);
                    formData.append('body', body);
                    formData.append('group', group);
                    axios.post('/admin/ticket/form/store', formData)
                        .then(function (response) {
                            swal.fire(
                                {
                                    text: " با موفقیت ثبت شد !",
                                    type: "success",
                                    confirmButtonText: 'باشه',
                                }
                            );
                            data.fetchTicket();
                        })
                        .catch(function (error) {

                        });
                },
                onImageChange(e) {
                    this.form.attachment = e.target.files[0];
                },
            },
            mounted: function () {
                this.fetchTicket();
            }
        });
    </script>
@endsection

@section('style')
    <style>
        .admin {
            background-color: #ffef636b !important
        }
    </style>
@endsection
