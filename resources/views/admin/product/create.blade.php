@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-4" id="area">
        <div class="row mb-4" v-if="progress">
            <progress :value="percent" max="100" style="width: 100%"></progress>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"
                         style="padding-bottom: 0;background-color: #343a40;border-bottom: 0px;padding-left: 0;">
                        <ul class="nav nav-pills yy">
                            <li class="nav-item">
                                <a class="nav-link active" href="#public"
                                   data-toggle="tab">ویژگی های عمومی</a></li>
                            <li class="nav-item">
                                <a class="nav-link" href="#specification" data-toggle="tab">ویژگی
                                    های
                                    اختصاصی
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#gallery" data-toggle="tab">
                                    تصاویر</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#pricing" data-toggle="tab">
                                    قیمت گذاری </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#coloring" data-toggle="tab">
                                    رنگبندی </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#description" data-toggle="tab">
                                    نقد و بررسی</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#seo" data-toggle="tab">
                                    بهینه سازی</a>
                            </li>
                            <li class="nav-item" style="margin: auto;margin-left:0px;">
                                <button type="submit" @click="formSubmit"
                                        style="background-color: #099020;border: unset;color: white;width:60px;height: 40px;border-top-right-radius: 10px;">
                                    ثبت
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="public">
                                <div class="container">
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>دسته بندی :</label>
                                                <br>
                                                <button @click="clickCatBtn" id="btn-cat">
                                                    @{{ form.catName }}
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
                                                        <li v-if="!childs.length" style="margin-top: 10px;"
                                                            @click="fixCat()">
                                                            <span
                                                                style="border-radius: 46px;color: white;margin-right: 15px;padding: 4px 13px;background-color: #007ac8;">
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
                                            <span style="color: red"> @{{ error.cat }} </span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label for="exampleFormControlSelect3">برند :</label>
                                                <select class="form-control" id="exampleFormControlSelect3"
                                                        v-model="form.brand" @change="changeBrand()">
                                                    <option value="" disabled hidden>انتخاب کنید...</option>
                                                    <option v-for="brand in brands" :value="brand.id">
                                                        @{{ brand.name }} - @{{ brand.name_f }}
                                                    </option>
                                                    <option value="" v-if="flag_brand">دسته بندی را انتخاب کنید
                                                    </option>
                                                </select>
                                            </div>
                                            <span style="color: red"> @{{ error.brand }} </span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label">نام :</label>
                                                <input type="text" class="form-control"
                                                       v-model="form.name">
                                            </div>
                                            <span style="color: red"> @{{ error.name }} </span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label" style="max-width: 100%;">قیمت
                                                    پایه :</label>
                                                <input type="number" class="form-control" v-model="form.price">
                                            </div>
                                            <span style="color: red"> @{{ error.price }} </span>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label" style="max-width: 100%;">قیمت پس
                                                    از تخفیف
                                                    :</label>
                                                <input @keyup="calDiscount"
                                                       type="number" class="form-control" v-model="form.afterDiscount">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 4px">
                                                <label class="col-md-4 control-label">تخفیف :</label>
                                                <input @keyup="calDiscountPrice" type="number" class="form-control"
                                                       v-model="form.discount">
                                            </div>
                                            <span style="color: red"> @{{ error.discount }} </span>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label for="exampleFormControlSelect3">وضعیت :</label>
                                                <select class="form-control" id="exampleFormControlSelect3"
                                                        v-model="form.status">
                                                    <option value="" disabled hidden>انتخاب کنید...</option>
                                                    <option value="1">نمایش در سایت</option>
                                                    <option value="0">عدم نمایش در سایت</option>
                                                </select>
                                            </div>
                                            <span style="color: red"> @{{ error.status }} </span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label>پیشنهاد ویژه :</label>
                                                <select class="form-control"
                                                        v-model="form.suggest">
                                                    <option value="" disabled hidden>انتخاب کنید...</option>
                                                    <option value="1">هست</option>
                                                    <option value="0">نیست</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label" style="max-width: 100%;">
                                                    شناسه محصول :
                                                </label>
                                                <input type="number" class="form-control" v-model="form.code">
                                            </div>
                                            <span style="color: red"> @{{ error.code }} </span>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <div class="form-group float-left">
                                                <img id="blah" class="ml-3"/>
                                                <label for="fileImage" id="label_file" class="btn btn-success"
                                                       style="font-weight: lighter;margin-bottom: 0;vertical-align: top;">
                                                    (600 * 600) تصویر شاخص
                                                </label>
                                                <span style="color: red"> @{{ error.image }} </span>
                                                <input type="file" onchange="readURL(this);" style="display:none;"
                                                       id="fileImage"
                                                       name="fileImage" @change="onImageChange">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="specification">
                                <div class="alert alert-primary" role="alert" v-if="flag_spec">
                                    لطفا ابتدا دسته بندی را انتخاب کنید...
                                </div>

{{--                                <div class="alert alert-primary" role="alert" v-if="flag_spec_exist">--}}
{{--                                    برای این دسته ، ویژگی وجود ندارد .--}}
{{--                                </div>--}}

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect3">خلاصه ویژگی ها :</label>
                                            <textarea type="text" name="editor2"></textarea>
                                        </div>
                                        <span style="color: red;"> @{{ error.short_desc }} </span>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div v-for="catspec in catspecs">
                                            <p style="color: #0c5460;font-weight: bold;font-size: 20px;margin-bottom: 15px">
                                                @{{ catspec.name }}</p>
                                            <div class="form-inline" v-for="specification in catspec.specifications"
                                                 :key="specification.id">
                                                <div class="col-md-12 form-group" style="margin:10px 0 15px 0">
                                                    <label class="col-md-2 col-form-label" for="name">@{{
                                                        specification.name}}
                                                        :</label>
                                                    <input type="text" class="form-control col-md-10 gg"
                                                           :name="specification.name" :id="specification.id"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="gallery">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="uploader"
                                             @dragenter="OnDragEnter"
                                             @dragleave="OnDragLeave"
                                             @dragover.prevent
                                             @drop="onDrop"
                                             :class="{ dragging: isDragging }">
                                            <div class="upload-control" v-show="images.length">
                                                <label for="file"
                                                       style="background-color: #838383;border: unset;padding: 5px">انتخاب
                                                    عکس</label>
                                            </div>
                                            <div v-show="!images.length">
                                                <i class="fa fa-cloud-upload"></i><br><br>
                                                <p style="font-weight: bold">سایز عکس : 725*1100</p>
                                                <div class="file-input">
                                                    <label for="file">انتخاب عکس</label>
                                                    <input type="file" id="file" @change="onInputChange" multiple>
                                                </div>
                                            </div>
                                            <div class="images-preview" v-show="images.length">
                                                <div class="img-wrapper" v-for="(image, index) in images"
                                                     :key="index" style="position: relative">
                                                    <a @click="deleteImage(index)">
                                                        <i class="fa fa-times del"></i>
                                                    </a>
                                                    <img :src="image">
                                                    <div class="details">
                                                        <span class="name" v-text="files[index].name"></span>
                                                        <span class="size"
                                                              v-text="getFileSize(files[index].size)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span style="color: red;margin-top: 12px;"> @{{ error.pics }} </span>
                                </div>
                            </div>
                            <div class="tab-pane" id="pricing">
                                <div class="alert alert-primary" role="alert" v-if="flag_price">
                                    لطفا ابتدا <span style="font-weight: bold;color: red">«دسته بندی»</span> و <span
                                        style="font-weight: bold;color: red">«برند»</span> محصول را انتخاب کنید...
                                </div>

                                <div class="alert alert-primary" role="alert" v-if="flag_price_exist">
                                    برای این دسته و ویژگی ، قیمت گذاری وجود ندارد .
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div v-for="effect_price in effect_prices">
                                            <span style="color: #0c5460;font-weight: bold;font-size: 20px">@{{ effect_price.name }}</span>
                                            <div class="form-inline"
                                                 v-for="effect_spec in effect_price.effect_specs"
                                                 :key="effect_spec.id">
                                                <div class="col-md-12 form-group" style="margin:20px 0 35px 0">
                                                    <label class="col-md-2 col-form-label" for="name">@{{
                                                        effect_spec.name}}
                                                        :</label>
                                                    <input type="number" class="form-control col-md-10 ee" value="0"
                                                           :name="effect_spec.name" :id="effect_spec.id"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="coloring">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-info mb-2" @click.stop.prevent="addRow()">
                                                افزودن
                                                رنگ
                                            </button>
                                            <span class="mr-1" style="color: red"> @{{ error.colors }} </span>
                                            <ul style="list-style:none;">
                                                <li v-for="(color, index) in colors">
                                                    <input type="text" v-model="color.name"
                                                           placeholder="نام رنگ"
                                                           class="form-control col-md-2 mb-2 ml-2"
                                                           style="display: inline-block">
                                                    <input type="text" v-model="color.price"
                                                           placeholder="قیمت"
                                                           class="form-control col-md-2 mb-2 ml-2"
                                                           style="display: inline-block">
                                                    <input type="file" @change="onInputChange2($event,color.index)"
                                                           multiple
                                                           class="form-control col-md-4 mb-2 ml-2"
                                                           style="display: inline-block">
                                                    <input type="color" v-model="color.code"
                                                           class="form-control col-md-1 ml-2"
                                                           style="display: inline-block;width: 40px;padding: 0;vertical-align: middle;">
                                                    <a @click="deleteRow(index)" style="font-size: 20px;">
                                                        <i class="fa fa-times" style="color: #dc3545"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="description">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect3">نقد و بررسی :</label>
                                            <textarea type="text" name="editor1"></textarea>
                                        </div>
                                        <span style="color: red;"> @{{ error.description }} </span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="seo">
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4 mb-4">
                                        <div class="form-group" style="margin-bottom: 7px">
                                            <label class="col-md-4 control-label" style="max-width: 100%">عنوان صفحه
                                                :</label>
                                            <input type="text" class="form-control" v-model="form.seo_title">
                                        </div>
                                        <span style="color: red;"> @{{ error.seo_title }} </span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group" style="margin-bottom: 7px">
                                            <label class="col-md-4 control-label" style="max-width: 100%">کلمات
                                                کلیدی :</label>
                                            <input type="text" class="form-control" data-role="tagsinput" id="key">
                                        </div>
                                        <span style="color: red;"> @{{ error.seo_key }} </span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">متای توضیحات :</label>
                                            <textarea type="number" class="form-control"
                                                      v-model="form.seo_description"
                                                      rows="8"></textarea>
                                        </div>
                                        <span style="color: red;"> @{{ error.seo_description }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                form: {
                    name: '',
                    discount: 0,
                    price: '',
                    roles: '',
                    image: '',
                    brand: '',
                    catName: 'انتخاب کنید...',
                    cat: '',
                    status: '',
                    seo_title: '',
                    seo_key: '',
                    seo_description: '',
                    afterDiscount: '',
                    code: '',
                    suggest: '',
                },
                error: {},
                cats: [],
                catspecs: '',
                specifications: '',
                specifications_val: {},
                effect_val: {},
                colors: [],
                product_id: '',
                brands: [],
                attachments: [],
                counter: [],
                isDragging: false,
                dragCount: 0,
                files: [],
                images: [],
                effect_prices: [],
                color_images: [],
                flag_brand: true,
                flag_spec: true,
                flag_spec_exist: false,
                flag_price: true,
                flag_price_exist: false,
                percent: 0,
                progress: false,
                colorCounter: 0,
                holder2: '',
                // tree
                categories: [],
                output: '',
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
                calDiscount() {
                    if (this.form.price == '') {
                        swal.fire(
                            {
                                text: 'لطفا ابتدا قیمت پایه را وارد کنید .',
                                type: 'warning',
                                confirmButtonText: 'باشه',
                            }
                        );
                        this.form.afterDiscount = '';
                    } else {
                        per = this.form.price / 100;

                        x = this.form.afterDiscount / per;
                        y = 100 - x;
                        this.form.discount = Math.round(y);
                    }
                },
                calDiscountPrice() {
                    if (this.form.price == '') {
                        swal.fire(
                            {
                                text: 'لطفا ابتدا قیمت پایه را وارد کنید .',
                                type: 'warning',
                                confirmButtonText: 'باشه',
                            }
                        );
                        this.form.discount = 0;
                    } else {
                        per = this.form.price / 100;
                        x = 100 - this.form.discount;
                        y = x * per;

                        this.form.afterDiscount = Math.round(y);
                    }
                },
                OnDragEnter(e) {
                    e.preventDefault();
                    this.dragCount++;
                    this.isDragging = true;
                    return false;
                },
                OnDragLeave(e) {
                    e.preventDefault();
                    this.dragCount--;
                    if (this.dragCount <= 0)
                        this.isDragging = false;
                },
                onInputChange(e) {
                    const files = e.target.files;
                    Array.from(files).forEach(file => this.addImage(file));
                },
                onInputChange2(e) {
                    const files = e.target.files;
                    let x = [];
                    Array.from(files).forEach(file => x.push(file));
                    this.color_images[this.colorCounter] = x;
                    this.colorCounter++;
                },
                onDrop(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.isDragging = false;
                    const files = e.dataTransfer.files;
                    Array.from(files).forEach(file => this.addImage(file));
                },
                addImage(file) {
                    if (!file.type.match('image.*')) {
                        this.$toastr.e(`${file.name} is not an image`);
                        return;
                    }
                    this.files.push(file);
                    const reader = new FileReader();
                    reader.onload = (e) => this.images.push(e.target.result);
                    reader.readAsDataURL(file);
                },
                addImage2(file) {
                    this.color_images.push(file);
                },
                deleteImage(index) {
                    this.images.splice(index, 1);
                    this.files.splice(index, 1);
                },
                getFileSize(size) {
                    const fSExt = ['Bytes', 'KB', 'MB', 'GB'];
                    let i = 0;

                    while (size > 900) {
                        size /= 1024;
                        i++;
                    }
                    return `${(Math.round(size * 100) / 100)} ${fSExt[i]}`;
                },
                addRow() {
                    this.colors.push({});
                },
                deleteRow(index) {
                    this.colors.splice(index, 1)
                },
                onImageChange(e) {
                    this.form.image = e.target.files[0];
                },
                fieldChange(e) {
                    let selectedFiles = e.target.files;
                    if (!selectedFiles.length) {
                        return false;
                    }
                    for (let i = 0; i < selectedFiles.length; i++) {
                        this.attachments.push(selectedFiles[i]);
                    }
                },
                fetchCat() {
                    let data = this;
                    axios.get('/admin/catspec/cat').then(res => {
                        data.cats = res.data;

                    });
                },
                fetchBrand(y) {
                    let data = this;
                    axios.get(`/admin/brand/fetch/${y}`).then(res => {
                        data.brands = res.data;
                        data.flag_brand = false;
                    });
                },
                changeCat() {
                    this.effect_prices = [];
                    this.flag_spec_exist = false;
                    y = this.form.cat;
                    this.fetchBrand(y);
                    let data = this;
                    axios.get(`/admin/product/catspec/${y}`).then(res => {
                        data.catspecs = res.data.catspecs;
                        data.flag_spec = false;

                        if (typeof data.catspecs[0] === 'undefined') {
                            data.flag_spec_exist = true;
                        }

                        if (data.effect_prices.length) {
                            data.flag_price = false;
                        }

                    });
                },
                changeBrand() {
                    this.flag_price_exist = false;
                    cat = this.form.cat;
                    brand = this.form.brand;
                    let data = this;
                    axios.get(`/admin/product/effect/price/${cat}/${brand}`).then(res => {
                        data.effect_prices = res.data;

                        if (data.effect_prices.length) {
                            data.flag_price = false;
                        } else {
                            data.flag_price_exist = true;
                            data.flag_price = false;
                        }

                    });
                },
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
                    });
                    this.holder.parentName = 'ریشه';
                    this.holder.parentId = '';
                    this.holder.grandName = 'ریشه';
                    this.holder.grandId = '';
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
                async fixCat() {
                    let _this = this;
                    this.form.catName = this.holder.selfName;
                    this.flag = false;
                    await axios.get(`/admin/product/fetch/cat/id/${this.holder.selfName}`).then(res => {
                        _this.form.cat = res.data;
                    });
                    this.changeCat();
                },
                fixRoot() {
                    this.form.catName = 'ریشه';
                    this.flag = false;
                },
                formSubmit(e) {
                    e.preventDefault();
                    var _this = this;
                    let data = this;
                    this.progress = true;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };
                    $('input[type="text"].gg').each(function () {
                        data.specifications_val[$(this).attr("name")] = $(this).val();
                    });
                    specifications = JSON.stringify(data.specifications_val);

                    $('input[type="number"].ee').each(function () {
                        data.effect_val[$(this).attr("name")] = $(this).val();
                    });

                    effects = JSON.stringify(data.effect_val);

                    colors = JSON.stringify(data.colors);


                    var formData = new FormData;

                    this.color_images.forEach(function (value, index) {
                        _this.holder2 = index;
                        value.forEach(function (image, index) {
                            formData.append('color_images[]', image, _this.holder2 + '.' + image.name.split('.').pop());
                        });
                    });

                    seo_key = $("#key").val();
                    short_desc = CKEDITOR.instances["editor2"].getData();
                    description = CKEDITOR.instances["editor1"].getData();

                    this.files.forEach(file => {
                        formData.append('pics[]', file, file.name);
                    });

                    formData.append('image', this.form.image);
                    formData.append('name', this.form.name);
                    formData.append('brand', this.form.brand);
                    formData.append('code', this.form.code);
                    formData.append('price', this.form.price);
                    formData.append('status', this.form.status);
                    formData.append('suggest', this.form.suggest);
                    formData.append('discount', this.form.discount);
                    formData.append('description', description);
                    formData.append('short_desc', short_desc);
                    formData.append('cat', this.form.cat);
                    formData.append('specifications', specifications);
                    formData.append('effects', effects);
                    formData.append('colors', colors);
                    formData.append('seo_title', this.form.seo_title);
                    formData.append('seo_key', seo_key);
                    formData.append('seo_description', this.form.seo_description);

                    axios.post('/admin/product/store', formData,
                        {
                            headers: {'content-type': 'multipart/form-data'},
                            onUploadProgress: function (uploadEvent) {
                                _this.percent = Math.round((uploadEvent.loaded / uploadEvent.total) * 100);
                            }
                        }
                    ).then(function (res) {

                        window.location.href = `/admin/product/edit/${res.data}`;

                    }).catch(function (error) {
                        data.progress = false;
                        data.error.name = "";
                        data.error.description = "";
                        data.error.short_desc = "";
                        data.error.price = "";
                        data.error.image = "";
                        data.error.brand = "";
                        data.error.price = "";
                        data.error.status = "";
                        data.error.discount = "";
                        data.error.cat = "";
                        data.error.seo_title = "";
                        data.error.seo_key = "";
                        data.error.seo_description = "";
                        this.allerros = error.response.data.errors;
                        x = error.response.data.errors;
                        if (Array.isArray(x.name)) {
                            data.error.name = this.allerros.name[0];
                        }
                        if (Array.isArray(x.cat)) {
                            data.error.cat = this.allerros.cat[0];
                        }
                        if (Array.isArray(x.price)) {
                            data.error.price = this.allerros.price[0];
                        }
                        if (Array.isArray(x.discount)) {
                            data.error.discount = this.allerros.discount[0];
                        }
                        if (Array.isArray(x.brand)) {
                            data.error.brand = this.allerros.brand[0];
                        }
                        if (Array.isArray(x.status)) {
                            data.error.status = this.allerros.status[0];
                        }
                        if (Array.isArray(x.description)) {
                            data.error.description = this.allerros.description[0];
                        }
                        if (Array.isArray(x.colors)) {
                            data.error.colors = this.allerros.colors[0];
                        }
                        if (Array.isArray(x.image)) {
                            data.error.image = this.allerros.image[0];
                        }
                        if (Array.isArray(x.short_desc)) {
                            data.error.short_desc = this.allerros.short_desc[0];
                        }
                        if (Array.isArray(x.seo_title)) {
                            data.error.seo_title = this.allerros.seo_title[0];
                        }
                        if (Array.isArray(x.seo_description)) {
                            data.error.seo_description = this.allerros.seo_description[0];
                        }
                        if (Array.isArray(x.seo_key)) {
                            data.error.seo_key = this.allerros.seo_key[0];
                        }
                        if (Array.isArray(x.pics)) {
                            data.error.pics = this.allerros.pics[0];
                        }
                    });
                },
            },
            mounted: function () {
                this.fetchCat()
                this.fetchRootCat()
            },
            updated: function () {
                if (this.holder.parentName === this.holder.selfName) {
                    this.holder.parentName = 'ریشه'
                    this.holder.parentId = ''
                    this.holder.grandName = 'ریشه'
                    this.holder.grandId = ''
                }
            }
        })
    </script>
    <script src="{{ asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.min.js')}}"></script>
    <script>
        CKEDITOR.replace('editor1', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 500
        });
        CKEDITOR.replace('editor2', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 250,
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(300);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $("#side_product").addClass("menu-open");
        $("#side_product_add").addClass("active");
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css" type="text/css"/>
    <style>
        .bootstrap-tagsinput .tag {
            border-radius: 5px;
            padding: 1px 8px;
        }

        .bootstrap-tagsinput {
            width: 100%;

            padding-top: 9px;
        }

        .yy .active {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
            color: #101010 !important;
            background-color: #ffffff !important;
            font-weight: bold;
        }

        .nav-pills .nav-link {
            color: #c2c7d0;
        }

        #cke_editor1, #cke_editor2 {
            width: 99%
        }

    </style>
    <style>
        .del {
            color: rgb(220, 53, 69);
            position: absolute !important;
            left: 3px !important;
            bottom: 4px !important;
            font-size: 23px !important;
        }

        .uploader {
            width: 100%;
            background: #ffffff;
            color: #a8a8a8;
            padding: 40px 15px;
            text-align: center;
            border-radius: 15px;
            border: 3px dashed #a8a8a8;
            font-size: 20px;
            position: relative;
        }

        .uploader.dragging {
            background: #fff;
            color: #cecece;
            border: 3px dashed #cecece;
        }

        .uploader.dragging .file-input label {
            background: #a8a8a8;
            color: #545454;
        }

        .uploader i {
            font-size: 85px;
        }

        .uploader .file-input {
            width: 200px;
            margin: auto;
            height: 68px;
            position: relative;
        }

        .uploader .file-input label, .uploader .file-input input {
            background: #a8a8a8;
            color: #ffffff;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            padding: 10px;
            border-radius: 4px;
            margin-top: 7px;
            cursor: pointer;
        }

        .uploader .file-input input {
            opacity: 0;
            z-index: -2;
        }

        .uploader .images-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .uploader .images-preview .img-wrapper {
            width: 160px;
            display: flex;
            flex-direction: column;
            margin: 10px;
            height: 150px;
            justify-content: space-between;
            background: #fff;
            box-shadow: 5px 5px 20px #3e3737;
        }

        .uploader .images-preview .img-wrapper img {
            max-height: 105px;
        }

        .uploader .images-preview .details {
            font-size: 12px;
            background: #fff;
            color: #000;
            display: flex;
            flex-direction: column;
            align-items: self-start;
            padding: 3px 6px;
        }

        .uploader .images-preview .details .name {
            overflow: hidden;
            height: 18px;
        }

        .uploader .upload-control {
            position: absolute;
            width: 100%;
            background: #fff;
            top: 0;
            left: 0;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            padding: 10px;
            padding-bottom: 4px;
            text-align: right;
        }

        .uploader .upload-control button, .uploader .upload-control label {
            background: #cecece;
            border: 2px solid #cecece;
            border-radius: 3px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .uploader .upload-control label {
            padding: 2px 5px;
            margin-right: 10px;
        }

        .nav-pills .nav-link:not(.active):hover {
            color: #ffffff !important;
        }
    </style>

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
            top: 71px;
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

