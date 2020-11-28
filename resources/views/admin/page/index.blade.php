@extends('layouts.admin.admin')
@section('content')
    <div class="container-fluid mt-4" id="area">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">دسته</th>
                        <th scope="col">عنوان</th>
                        <th scope="col">تاریخ</th>
                        <th scope="col">
                            <span>مجموع : </span>
                            <span style="background-color:rgb(0,149,47);font-weight: bold;border-radius: 20px;color: white;padding:1px 4px">@{{ pages.total }}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <select class="form-control" v-model="search.cat" @change="searchCat()">
                                <option value="" disabled hidden>انتخاب کنید...</option>
                                <option value="999999">همه دسته ها</option>
                                <option v-for="cat in cats" :value="cat.id">@{{ cat.name }}</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجو بر اساس عنوان">
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr v-for="(page,index) in pages.data">
                        <td>@{{page.cat.name}}</td>
                        <td>@{{page.name}}</td>
                        <td>@{{page.shamsi_c}}</td>
                        <td>
                            <a @click="editPage(page.id)" style="font-size: 20px;" class="ml-2">
                                <i class="fa fa-edit" style="color: #28a745"></i>
                            </a>
                            <a @click="deletePage(page.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <pagination :data="pages" @pagination-change-page="fetchPages" style="margin:auto"></pagination>
        </div>

    </div>
@endsection
@section('script')
    <script>
        var app;
        app = new Vue({
            el: '#area',
            data: {
                cats: false,
                search: {
                    name: '',
                    cat: '',
                },
                description: '',
                pages: [],
            },
            methods: {
                editPage(id) {
                    window.location.href = `/admin/page/edit/${id}`;
                },
                fetchPages(page = 1) {
                    let data = this;
                    axios.get('/admin/page/fetch/pages?page=' + page).then(res => {
                        data.pages = res.data;
                        console.log(data.pages);
                    });
                },
                searchCat(page = 1) {
                    this.search.name = '';
                    data = this;
                    if (this.search.cat > 0) {
                        axios.get('/admin/page/search?page=' + page, {
                            params: {
                                cat: this.search.cat,
                            }
                        }).then(response => {
                            data.pages = response.data;
                        });
                    }
                },
                searchName(page = 1) {
                    data = this;
                    if (this.search.name.length > 0) {
                        axios.get('/admin/page/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                            data.pages = response.data;
                        });
                    }
                    if (this.search.name.length === 0) {
                        this.fetchPages();
                    }
                },
                deletePage(id) {
                    let _this=this;
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
                            axios.get(`/admin/page/delete/${id}`).then(res => {
                                _this.fetchPages();
                            });
                        }
                    });
                },
                fetchCat() {
                    let data = this;
                    axios.get('/admin/page/fetch/cat').then(res => {
                        data.cats = res.data;

                    });
                },
            },
            mounted: function () {
                this.fetchPages();
                this.fetchCat();
            }
        });
    </script>
    <script>
        $("#side_page").addClass("menu-open");
        $("#side_page_index").addClass("active");
    </script>
@endsection

@section('style')
    <style>
        .fa {
            font-size: 1rem;
        }
    </style>
@endsection