@extends('layouts.admin.admin')
@section('title') تیکت ها @endsection
@section('content')
    <div class="container" id="area">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr style="text-align:right">
                        <th scope="col">کد تیکت</th>
                        <th scope="col">مرتبط با</th>
                        <th scope="col">دپارتمان</th>
                        <th scope="col">وضعیت</th>
                        <th scope="col">تاریخ</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(ticket,index) in tickets.data" style="text-align: right;">
                        <td>@{{ticket.id}}</td>
                        <td>
                            <select v-if="tickets.data[index].for"
                                    class="form-control"
                                    @change="setAdmin(ticket.id,$event)"
                                    v-model="tickets.data[index].for">
                                <option value="" disabled hidden>انتخاب کنید...</option>
                                <option v-for="admin in admins" :value="admin.id">
                                    @{{ admin.name }}
                                </option>
                            </select>
                            <select v-else class="form-control" @change="setAdmin(ticket.id,$event)"
                                    v-model="holder">
                                <option value="" disabled hidden>انتخاب کنید...</option>
                                <option v-for="admin in admins" :value="admin.id">
                                    @{{ admin.name }}
                                </option>
                            </select>

                        </td>
                        <td>@{{ticket.department}}</td>
                        <td>@{{ticket.status}}</td>
                        <td>@{{ticket.shamsi_c}}</td>
                        <td>
                            <a @click="detail(ticket.group)" style="font-size: 20px;" class="ml-2">
                                <i class="fa fa-eye" style="color: #a9a9a9"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2 mr-3">
            {{--<pagination :data="tickets" @pagination-change-page="fetchTickets"></pagination>--}}
        </div>
    </div>
@endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                tickets: [],
                tickets2: [],
                admins: [],
                flag: false,
                holder: '',
            },
            methods: {
                fetchTickets(page = 1) {
                    let data = this;
                    axios.get('/admin/ticket/fetch?page=' + page).then(res => {
                        data.tickets = res.data;
                        console.log(data.tickets);
                        console.log(data.tickets);
                    });
                },
                detail(group) {
                    window.location.href = `/admin/ticket/detail/${group}`;
                },
                fetchAdmins() {
                    let data = this;
                    axios.get('/admin/ticket/fetch/admin').then(res => {
                        data.admins = res.data;
                    });
                },
                setAdmin(id, event) {
                    let obj = this;
                    axios.post('/admin/ticket/routing/set/admin', {
                        admin_id: event.target.value,
                        ticket_id: id,
                    }).then(function () {
                        swal.fire(
                            {
                                text: "تغییرات با موفقیت اعمال شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        obj.fetchTickets();
                        obj.flag = false;
                    });
                },
            },
            mounted: function () {
                this.fetchTickets();
                this.fetchAdmins();
            }
        });

        $("#ticket-list-btn").addClass('active-menu');
    </script>
@endsection

@section('style')

@endsection
