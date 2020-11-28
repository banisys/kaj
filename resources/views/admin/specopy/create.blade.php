@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-5 pb-5" id="area" style="position: relative">
        <div class="row" style="border: 1px #dedede solid;padding:35px 5px 0 5px;border-radius: 10px">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2">
                                    کپی ویژگی ها از درسته ی :
                                </label>

                                <button @click="clickCatBtn" id="btn-cat">
                                    @{{ from }}
                                    <i class="right fa fa-angle-down" id="angle-down"></i>
                                </button>

                                <div v-if="flag" id="sss">
                                    <ul v-if="flag1">
                                        <li style="line-height: 35px;"
                                            @click="fetchChild(root.id,root.name)"
                                            v-for="(root,index) in roots">
                                            @{{ root.name }}
                                            <i id="angle-left" class="right fa fa-angle-left"></i>
                                        </li>
                                    </ul>
                                    <ul v-if="flag2">
                                        <li style="color: #a0a0a0" @click="back(holder.parentName)">
                                            <i class="right fa fa-angle-right"
                                               style="float: right;margin:11px 0 0 5px;"></i>
                                            @{{ holder.parentName }}
                                        </li>
                                        <li style="margin-top: 10px" v-if="!childs.length"
                                            @click="fixCat()">
                                             <span style="border-radius: 46px;color: white;margin-right: 15px;padding: 4px 13px;background-color: #007ac8;">
                                                                 @{{ holder.selfName }}
                                                            </span>
                                        </li>
                                        <li v-for="(child,index) in childs"
                                            @click="fetchChild(child.id,child.name)"
                                            style="margin-right: 10px;">
                                            @{{ child.name }}
                                            <i id="angle-left" v-if="child.children_recursive.length"
                                               class="right fa fa-angle-left"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2">
                                    به :
                                </label>

                                <button @click="clickCatBtn2" id="btn-cat">
                                    @{{ to }}
                                    <i class="right fa fa-angle-down" id="angle-down"></i>
                                </button>

                                <div v-if="fflag" id="sss">
                                    <ul v-if="fflag1">
                                        <li style="line-height: 35px;"
                                            @click="fetchChild2(root.id,root.name)"
                                            v-for="root in roots2">
                                            @{{ root.name }}
                                            <i id="angle-left" class="right fa fa-angle-left"></i>
                                        </li>
                                    </ul>
                                    <ul v-if="fflag2">
                                        <li style="color: #a0a0a0" @click="back2(holder2.parentName)">
                                            <i class="right fa fa-angle-right"
                                               style="float: right;margin:11px 0 0 5px;"></i>
                                            @{{ holder2.parentName }}
                                        </li>
                                        <li v-if="!childs2.length" style="margin-top: 10px;"
                                            @click="fixCat2()">
                                            <span style="border-radius: 46px;color: white;margin-right: 15px;padding: 4px 13px;background-color: #007ac8;">
                                                                 @{{ holder2.selfName }}
                                                            </span>
                                        </li>
                                        <li v-for="child in childs2"
                                            @click="fetchChild2(child.id,child.name)"
                                            style="margin-right: 10px;">
                                            @{{ child.name }}
                                            <i id="angle-left" v-if="child.children_recursive.length"
                                               class="right fa fa-angle-left"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-2" style="margin-top: 32px">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" @click="formSubmit">
                                    ثبت
                                </button>
                            </div>
                        </div>
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
                from: 'انتخاب کنید...',
                to: 'انتخاب کنید...',
                holder2: {
                    selfName: 'ریشه',
                    selfId: '',
                    parentName: '',
                    parentId: '',
                    grandName: 'ریشه',
                    grandId: '',
                },
                fflag: false,
                fflag1: true,
                fflag2: false,
                roots2: [],
                childs2: [],

                holder: {
                    selfName: 'ریشه',
                    selfId: '',
                    parentName: '',
                    parentId: '',
                    grandName: 'ریشه',
                    grandId: '',
                },
                flag: false,
                flag1: true,
                flag2: false,
                roots: [],
                childs: [],
            },
            methods: {
                clickCatBtn() {
                    if (this.flag === false) {
                        this.flag = true;
                    } else if (this.flag === true) {
                        this.flag = false
                    }
                },
                fetchRootCat() {
                    let data = this;
                    axios.get(`/admin/brand/fetch/cat/root`).then(res => {
                        data.roots = res.data;
                        data.roots2 = res.data;
                    });
                    this.holder.parentName = 'ریشه';
                    this.holder.parentId = '';
                    this.holder.grandName = 'ریشه';
                    this.holder.grandId = '';
                    this.holder2.parentName = 'ریشه';
                    this.holder2.parentId = '';
                    this.holder2.grandName = 'ریشه';
                    this.holder2.grandId = '';
                },
                fetchChild(id, name) {
                    let data = this;

                    this.holder.grandName = this.holder.parentName;
                    this.holder.grandId = this.holder.parentId;

                    this.holder.parentName = this.holder.selfName;
                    this.holder.parentId = this.holder.selfId;

                    this.holder.selfName = name;
                    this.holder.selfId = id;
                    axios.get(`/admin/brand/fetch/cat/child/${id}`).then(res => {
                        data.childs = res.data;
                        data.flag1 = false;
                        data.flag2 = true;
                    });
                },
                back(parent) {
                    let data = this;
                    if (parent === 'ریشه') {
                        this.flag1 = true;
                        this.flag2 = false;
                        this.holder.selfName = 'ریشه';
                        this.holder.selfId = '';
                        this.holder.parentName = '';
                        this.holder.parentId = '';
                        this.holder.grandName = '';
                        this.holder.grandId = '';
                        axios.get('/admin/mega/fetch/cat/root').then(res => {
                            data.roots = res.data;
                        });
                    } else {
                        axios.get(`/admin/mega/fetch/cat/child/${this.holder.parentId}`).then(res => {
                            data.childs = res.data;
                            data.holder.selfName = data.holder.parentName;
                            data.holder.selfId = data.holder.parentId;
                            data.holder.parentName = data.holder.grandName;
                            data.holder.parentId = data.holder.grandId;
                        });
                    }
                },
                fixCat() {
                    this.from = this.holder.selfName;
                    this.flag = false;
                },
                fixRoot() {
                    this.from = 'ریشه';
                    this.flag = false;
                },
                clickCatBtn2() {
                    if (this.fflag === false) {
                        this.fflag = true;
                    } else if (this.fflag === true) {
                        this.fflag = false
                    }
                },
                fetchChild2(id, name) {
                    let data = this;

                    this.holder2.grandName = this.holder2.parentName;
                    this.holder2.grandId = this.holder2.parentId;

                    this.holder2.parentName = this.holder2.selfName;
                    this.holder2.parentId = this.holder2.selfId;

                    this.holder2.selfName = name;
                    this.holder2.selfId = id;
                    axios.get(`/admin/brand/fetch/cat/child/${id}`).then(res => {
                        data.childs2 = res.data;
                        data.fflag1 = false;
                        data.fflag2 = true;
                    });
                },
                back2(parent) {
                    let data = this;
                    if (parent === 'ریشه') {
                        this.fflag1 = true;
                        this.fflag2 = false;
                        this.holder2.selfName = 'ریشه';
                        this.holder2.selfId = '';
                        this.holder2.parentName = '';
                        this.holder2.parentId = '';
                        this.holder2.grandName = '';
                        this.holder2.grandId = '';
                        axios.get('/admin/mega/fetch/cat/root').then(res => {
                            data.roots2 = res.data;
                        });
                    } else {
                        axios.get(`/admin/mega/fetch/cat/child/${this.holder2.parentId}`).then(res => {
                            data.childs2 = res.data;
                            data.holder2.selfName = data.holder2.parentName;
                            data.holder2.selfId = data.holder2.parentId;
                            data.holder2.parentName = data.holder2.grandName;
                            data.holder2.parentId = data.holder2.grandId;
                        });
                    }
                },
                fixCat2() {
                    this.to = this.holder2.selfName;
                    this.fflag = false;
                },
                fixRoot2() {
                    this.to = 'ریشه';
                    this.fflag = false;
                },
                formSubmit(e) {
                    e.preventDefault();

                    let formData = new FormData();
                    formData.append('from', this.from);
                    formData.append('to', this.to);

                    axios.post('/admin/specopy/store', formData)
                        .then(function (response) {
                            window.location.href = `/admin/catspec/create`;
                        });

                },
            },
            mounted: function () {
                this.fetchRootCat();
            },
            updated: function () {
                if (this.holder.parentName === this.holder.selfName) {
                    this.holder.parentName = 'ریشه';
                    this.holder.parentId = '';
                    this.holder.grandName = 'ریشه';
                    this.holder.grandId = '';
                }

                if (this.holder2.parentName === this.holder2.selfName) {
                    this.holder2.parentName = 'ریشه';
                    this.holder2.parentId = '';
                    this.holder2.grandName = 'ریشه';
                    this.holder2.grandId = '';
                }
            }
        });
    </script>

    <script>
        $("#side_specification").addClass("menu-open");
        $("#side_specopy").addClass("active");
    </script>
@endsection
@section('style')
    <style>
        li {
            list-style: none
        }

        #btn-cat {
            position: relative;
            background-color: white;
            border: 1px solid #dee2e6;
            width: 100%;
            padding: 8px 8px 0 8px;
            border-radius: 7px;
            text-align: right;
            color: #484848;
        }

        #angle-down {
            float: left;
            margin: 6px 2px;
            color: #636363;
        }

        #sss {
            position: absolute;
            list-style: none;
            top: 74px;
            z-index: 99;
            background-color: white;
            padding: 5px 15px;
            width: 100%;
            line-height: 35px;
            box-shadow: 0px 10px 21px 0px rgba(0, 0, 0, 0.75);
        }

        #angle-left {
            float: left;
            margin-top: 10px;
            color: #636363;
        }

        #sss li {
            cursor: pointer
        }

        .fa {
            font-size: 1.1rem
        }

    </style>
@endsection
