@extends('layouts.admin.admin')
@section('content')
    <div class="container mt-4" id="area">
        <div class="row mb-4" v-if="progress">
            <progress :value="percent" max="100" style="width: 100%"></progress>
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
                                <img v-for="pic in pics" :src="'/images/gallery/'+pic.image"
                                     style="width: 50%;display:block;margin: 25px auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="card">
                        <div class="card-header"
                             style="padding-bottom: 0;background-color: #343a40;border-bottom: 0px;padding-left: 0;">
                            <ul class="nav nav-pills yy">
                                <li class="nav-item"><a class="nav-link active" href="#public"
                                                        data-toggle="tab">ویژگی های عمومی</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#specification" data-toggle="tab">ویژگی
                                        های
                                        اختصاصی</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#gallery" data-toggle="tab">گالری
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
                                            style="background-color:#28a745;border: unset;color: white;width:60px;height: 40px;border-top-right-radius: 10px;">
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
                                                <div class="form-group" style="margin-bottom: 0">
                                                    <label for="exampleFormControlSelect1">دسته بندی :</label>
                                                    <select class="form-control" id="exampleFormControlSelect1"
                                                            readonly="readonly" style="pointer-events: none;"
                                                            v-model="form.cat"
                                                            @change="changeCat()">
                                                        <option value="" disabled hidden>انتخاب کنید...</option>
                                                        <option v-for="cat in cats" :value="cat.id">
                                                            @{{ cat.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <span style="color: red"> @{{ error.cat }} </span>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 0">
                                                    <label for="exampleFormControlSelect3">برند :</label>
                                                    <select class="form-control" id="exampleFormControlSelect3"
                                                            v-model="form.brand">
                                                        <option value="" disabled hidden>انتخاب کنید...</option>
                                                        <option v-for="brand in brands" :value="brand.name">
                                                            @{{ brand.name }}
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
                                                    <input type="number" class="form-control"
                                                           @keyup="changePrice" v-model="form.price">
                                                </div>
                                                <span style="color: red"> @{{ error.price }} </span>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 0">
                                                    <label class="col-md-4 control-label" style="max-width: 100%;">قیمت
                                                        پس
                                                        از تخفیف
                                                        :</label>
                                                    <input @keyup="calDiscount" type="number" class="form-control"
                                                           v-model="form.afterDiscount">
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
                                                <div class="form-group" style="display: block;float: left">
                                                    <img style="width:300px;height: 300px" id="blah" class="ml-2"
                                                         :src="'/images/product/'+form.image"/>
                                                    <span style="color: red"> @{{ error.image }} </span>
                                                    <label for="fileImage" id="label_file" class="btn btn-success mr-1"
                                                           style="font-weight: lighter;margin-bottom: 0;vertical-align: top;">
                                                        تصویر شاخص</label>
                                                    <input type="file" onchange="readURL(this);" style="display:none;"
                                                           id="fileImage"
                                                           name="fileImage" @change="onImageChange">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="specification">
                                    <div class="row mt-4">
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
                                                <span style="color: #0c5460;font-weight: bold;font-size: 20px">@{{ catspec.name }}</span>
                                                <div class="form-inline" v-for="specification in catspec.specifications"
                                                     :key="specification.id">
                                                    <div class="col-md-12 form-group" style="margin:20px 0 35px 0">
                                                        <label class="col-md-2 col-form-label" for="name">@{{
                                                            specification.name}}
                                                            :</label>
                                                        <input type="text" class="form-control col-md-10 gg"
                                                               :value="getValue(specification.name)"
                                                               :name="specification.name" :id="specification.id"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="gallery">
                                    <div class="row mt-3">
                                        <div class="container">
                                            <div class="row">
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
                                                            <p style="font-weight: bold">عکس ها را در اینجا رها کنید</p>
                                                            <div class="file-input">
                                                                <label for="file">انتخاب عکس</label>
                                                                <input type="file" id="file" @change="onInputChange"
                                                                       multiple>
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
                                                                    <span class="name"
                                                                          v-text="files[index].name"></span>
                                                                    <span class="size"
                                                                          v-text="getFileSize(files[index].size)"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <span
                                                        style="color: red;margin-top: 12px;"> @{{ error.pics }} </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mt-4 mb-4" v-for="img in gallery">
                                                    <img style="position: relative;width:100%;height:180px"
                                                         class="img-fluid" :src="'/images/gallery/'+img.image">
                                                    <a @click="deleteGallery(img.id)">
                                                        <i class="fa fa-times del2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="pricing">
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div v-for="effect_price in effect_prices">
                                                <span style="color: #0c5460;font-weight: bold;font-size: 20px">@{{ effect_price.name }}</span>
                                                <div class="form-inline"
                                                     v-for="effect_spec in effect_price.effect_specs"
                                                     :key="effect_spec.id">
                                                    <div class="col-md-12 form-group" style="margin:20px 0 35px 0">
                                                        <label class="col-md-1 col-form-label" for="name">@{{
                                                            effect_spec.name}}
                                                            :</label>
                                                        <input type="text" class="form-control col-md-11 ee"
                                                               :value="getEffectVal(effect_spec.name)"
                                                               :name="effect_spec.name" :id="effect_spec.id"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="coloring">
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">نام</th>
                                                <th scope="col">قیمت</th>
                                                <th scope="col">رنگ</th>
                                                <th scope="col"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(color, index) in colors_demo">
                                                <td>@{{color.name}}</td>
                                                <td>@{{color.price}}</td>
                                                <td>
                                                    <span :style="{backgroundColor: color.code}"
                                                          style="width: 30px;height:30px;display: block;border-radius:800px;border: solid 1px grey">
                                                    </span>
                                                </td>
                                                <td>
                                                    <a @click="showImage(color.id)" style="font-size: 20px;">
                                                        <i class="fa fa-image ml-3" style="color: #17a2b8;"></i>
                                                    </a>
                                                    <a @click="deleteColorImage(color.id)">
                                                        <i class="fa fa-times" style="color: #dc3545;
                                                            font-size: 19px;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
                                                        <input type="file" @change="onInputChange2" multiple
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
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group" style="margin-bottom: 7px">
                                                <label class="col-md-4 control-label" style="max-width: 100%">عنوان صفحه
                                                    :</label>
                                                <input type="text" class="form-control" v-model="form.seo_title">
                                            </div>
                                            <span style="color: red;"> @{{ error.seo_title }} </span>
                                        </div>
                                        <div class="col-md-6">
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
                </form>
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
                    name: null,
                    discount: null,
                    price: null,
                    roles: null,
                    image: null,
                    brand: null,
                    cat: null,
                    tags: null,
                    status: null,
                    seo_title: null,
                    seo_key: null,
                    seo_description: null,
                    afterDiscount: null,
                    code: null,
                },
                error: {name: '', short_desc: ''},
                cats: [],
                catspecs: '',
                specifications: '',
                specifications_val: {},
                colors: [],
                product_id: '',
                brands: [],
                attachments: [],
                counter: [],
                isDragging: false,
                dragCount: 0,
                files: [],
                images: [],
                product: '',
                values: [],
                gallery: [],
                effect_prices: '',
                effect_val: {},
                effect_values: [],
                color_images: [],
                color_images_demo: [],
                colors_demo: [],
                pics: [],
                showModal: false,
                holder: '',
                colorCounter: 0,
                progress: false,
                percent: 0,
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
                changePrice() {
                    this.form.afterDiscount = null;
                    this.form.discount = null;
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
                    this.colors.push({
                        name: '',
                        code: ''
                    });
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
                fetchBrand() {
                    let data = this;
                    axios.get(`/admin/product/fetch/brands/${window.id}`).then(res => {
                        data.brands = res.data;
                    });
                },
                changeCat() {
                    y = this.form.cat;
                    let data = this;
                    axios.get(`/admin/product/catspec/${y}`).then(res => {
                        data.catspecs = res.data.catspecs;
                    });
                },
                async fetchProduct(id) {
                    let data = this;
                    await axios.get(`/admin/product/${id}`).then(res => {
                        data.product = res.data;
                        data.form.name = data.product.name;
                        data.form.code = data.product.code;
                        data.form.cat = data.product.cat_id;
                        this.changeCat(data.product.cat_id);
                        data.form.price = data.product.price;
                        data.form.discount = data.product.discount;
                        data.form.brand = data.product.brand;
                        data.form.status = data.product.status;
                        data.form.suggest = data.product.suggest;
                        data.form.exist = data.product.exist;
                        data.form.seo_title = data.product.seo_title;
                        data.form.seo_description = data.product.seo_description;
                        $('#key').tagsinput('add', data.product.seo_key);
                        $('#tags').tagsinput('add', data.product.tags);
                        data.form.image = data.product.image;
                        CKEDITOR.instances["editor2"].setData(data.product.short_desc);
                        CKEDITOR.instances["editor1"].setData(data.product.description);
                    });
                    this.calDiscountPrice();
                },
                getValues() {
                    parts = window.location.href.split('/');
                    pro = parts.pop() || parts.pop();
                    data = this;
                    axios.get(`/admin/product/fetch/value/${pro}`).then(res => {
                        data.values = res.data;
                    });
                },
                getEffectValues(id) {
                    data = this;
                    axios.get(`/admin/product/fetch/effect/values/${id}`).then(res => {
                        data.effect_values = res.data;
                    });
                },
                getColors() {
                    parts = window.location.href.split('/');
                    pro = parts.pop() || parts.pop();
                    data = this;
                    axios.get(`/admin/product/fetch/colors/${pro}`).then(res => {
                        data.colors_demo = res.data;
                    });
                },
                getGallery() {
                    parts = window.location.href.split('/');
                    pro = parts.pop() || parts.pop();
                    data = this;
                    axios.get(`/admin/product/fetch/gallery/${pro}`).then(res => {
                        data.gallery = res.data;
                    });
                },
                getValue(key) {
                    result = this.values.filter(value => value.key === key);
                    if (result.length) {
                        return result[0].value;
                    }
                },
                getEffectVal(key) {
                    result = this.effect_values.filter(value => value.key === key);
                    if (result.length) {
                        return result[0].value;
                    } else {
                        return 0;
                    }
                },
                deleteGallery(id) {
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
                            axios.get(`/admin/product/delete/gallery/${id}`).then(res => {
                                parts = window.location.href.split('/');
                                pro = parts.pop() || parts.pop();
                                this.getGallery(pro);
                            });
                        }
                    });
                },
                deleteColorImage(id) {
                    data = this;
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
                            axios.get(`/admin/product/delete/color/image/${id}`).then(res => {
                                parts = window.location.href.split('/');
                                pro = parts.pop() || parts.pop();
                                data.getColors(pro);
                            });
                        }
                    });
                },
                fetchEffectPrices(id) {
                    let data = this;
                    axios.get(`/admin/product/effect/price/${id}`).then(res => {
                        data.effect_prices = res.data;

                    });
                },
                onInputChange2(e) {
                    const files = e.target.files;
                    let x = [];
                    Array.from(files).forEach(file => x.push(file));
                    this.color_images[this.colorCounter] = x;
                    this.colorCounter++;
                },
                addImage2(file) {
                    this.color_images.push(file);
                },
                showImage(id) {
                    let data = this;
                    this.showModal = true;
                    this.pic = true;
                    axios.get(`/admin/product/color/image/${id}`).then(function (res) {
                        data.pics = res.data;
                    });
                },
                formSubmit(e) {
                    e.preventDefault();

                    if (this.form.discount == null) {
                        swal.fire(
                            {
                                text: "تخفیف یا قیمت پس از تخفیف را وارد کنید .",
                                type: "warning",
                                confirmButtonText: 'باشه',
                            }
                        );
                        return false;
                    }

                    let data = this;

                    this.progress = true;

                    $('input[type="text"].gg').each(function () {
                        data.specifications_val[$(this).attr("name")] = $(this).val();
                    });
                    specifications = JSON.stringify(data.specifications_val);

                    $('input[type="text"].ee').each(function () {
                        data.effect_val[$(this).attr("name")] = $(this).val();
                    });

                    effects = JSON.stringify(data.effect_val);

                    colors = JSON.stringify(data.colors);
                    tags = $("#tags").val();
                    seo_key = $("#key").val();
                    short_desc = CKEDITOR.instances["editor2"].getData();
                    console.log(short_desc);
                    description = CKEDITOR.instances["editor1"].getData();
                    let formData = new FormData();

                    this.color_images.forEach(function (value, index) {
                        data.holder = index;
                        value.forEach(function (image, index) {
                            formData.append('color_images[]', image, data.holder + '.' + image.name.split('.').pop());
                        });
                    });

                    this.files.forEach(file => {
                        formData.append('pics[]', file, file.name);
                    });
                    formData.append('image', this.form.image);
                    formData.append('code', this.form.code);
                    formData.append('name', this.form.name);
                    formData.append('brand', this.form.brand);
                    formData.append('price', this.form.price);
                    formData.append('status', this.form.status);
                    formData.append('suggest', this.form.suggest);
                    formData.append('discount', this.form.discount);
                    formData.append('description', description);
                    formData.append('short_desc', short_desc);
                    formData.append('cat', this.form.cat);
                    formData.append('specifications', specifications);
                    formData.append('colors', colors);
                    formData.append('tags', tags);
                    formData.append('seo_title', this.form.seo_title);
                    formData.append('seo_key', seo_key);
                    formData.append('seo_description', this.form.seo_description);
                    formData.append('effects', effects);

                    parts = window.location.href.split('/');
                    id = parts.pop() || parts.pop();
                    axios.post(`/admin/product/update/${id}`, formData,
                        {
                            headers: {'content-type': 'multipart/form-data'},
                            onUploadProgress: function (uploadEvent) {
                                data.percent = Math.round((uploadEvent.loaded / uploadEvent.total) * 100);
                            }
                        }
                    ).then(function (res) {
                        swal.fire(
                            {
                                text: "تغییرات با موفقیت اعمال شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        data.progress = false;
                        data.fetchProduct(id);
                        data.getValues(id);
                        data.getColors(id);
                        data.getGallery(id);
                        // data.fetchColorImage(id);
                        data.getColors(id);
                        data.getEffectValues(id);
                        data.images = [];
                        data.files = [];
                        data.colors = [];
                    }).catch(function (error) {
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
                        data.error.exist = "";
                        data.error.tags = "";
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
                        if (Array.isArray(x.tags)) {
                            data.error.tags = this.allerros.tags[0];
                        }
                        if (Array.isArray(x.status)) {
                            data.error.status = this.allerros.status[0];
                        }
                        if (Array.isArray(x.exist)) {
                            data.error.exist = this.allerros.exist[0];
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
                formSubmit2() {
                    let data = this;

                    $('input[type="text"].gg').each(function () {
                        data.specifications_val[$(this).attr("name")] = $(this).val();
                    });
                    specifications = JSON.stringify(data.specifications_val);

                    $('input[type="text"].ee').each(function () {
                        data.effect_val[$(this).attr("name")] = $(this).val();
                    });

                    effects = JSON.stringify(data.effect_val);

                    colors = JSON.stringify(data.colors);
                    tags = $("#tags").val();
                    seo_key = $("#key").val();
                    short_desc = CKEDITOR.instances["editor2"].getData();

                    description = CKEDITOR.instances["editor1"].getData();
                    let formData = new FormData();

                    this.color_images.forEach(function (value, index) {
                        data.holder = index;
                        value.forEach(function (image, index) {
                            formData.append('color_images[]', image, data.holder + '.' + image.name.split('.').pop());
                        });
                    });

                    this.files.forEach(file => {
                        formData.append('pics[]', file, file.name);
                    });
                    formData.append('image', this.form.image);
                    formData.append('code', this.form.code);
                    formData.append('name', this.form.name);
                    formData.append('brand', this.form.brand);
                    formData.append('price', this.form.price);
                    formData.append('status', this.form.status);
                    formData.append('discount', this.form.discount);
                    formData.append('description', description);
                    formData.append('short_desc', short_desc);
                    formData.append('cat', this.form.cat);
                    formData.append('specifications', specifications);
                    formData.append('colors', colors);
                    formData.append('tags', tags);
                    formData.append('seo_title', this.form.seo_title);
                    formData.append('seo_key', seo_key);
                    formData.append('seo_description', this.form.seo_description);
                    formData.append('effects', effects);

                    parts = window.location.href.split('/');
                    id = parts.pop() || parts.pop();
                    axios.post(`/admin/product/update/${id}`, formData,
                        {
                            headers: {'content-type': 'multipart/form-data'},
                            onUploadProgress: function (uploadEvent) {
                                data.percent = Math.round((uploadEvent.loaded / uploadEvent.total) * 100);
                            }
                        }
                    ).then(function (res) {
                        swal.fire(
                            {
                                text: "تغییرات با موفقیت اعمال شد !",
                                type: "success",
                                confirmButtonText: 'باشه',
                            }
                        );
                        data.progress = false;
                        data.fetchProduct(id);
                        data.getValues(id);
                        data.getColors(id);
                        data.getGallery(id);
                        // data.fetchColorImage(id);
                        data.getColors(id);
                        data.getEffectValues(id);
                        data.images = [];
                        data.files = [];
                        data.colors = [];
                    }).catch(function (error) {
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
                        data.error.exist = "";
                        data.error.tags = "";
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
                        if (Array.isArray(x.tags)) {
                            data.error.tags = this.allerros.tags[0];
                        }
                        if (Array.isArray(x.status)) {
                            data.error.status = this.allerros.status[0];
                        }
                        if (Array.isArray(x.exist)) {
                            data.error.exist = this.allerros.exist[0];
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
            async mounted() {
                parts = window.location.href.split('/');
                window.id = parts.pop() || parts.pop();
                await this.fetchCat();
                await this.fetchBrand();
                await this.fetchProduct(window.id);
                await this.getValues(window.id);
                await this.getColors(window.id);
                await this.getGallery(window.id);
                await this.fetchEffectPrices(window.id);
                await this.getEffectValues(window.id);
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
    </script>
@endsection

@section('style')
    {{--<link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>--}}
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css" type="text/css"/>
    <style>
        .bootstrap-tagsinput .tag {
            border-radius: 5px;
            padding: 1px 8px;
        }

        .bootstrap-tagsinput {
            width: 100%;
            height: 39px;
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

        .del2 {
            color: rgb(220, 53, 69);
            position: absolute !important;
            left: 12px !important;
            top: 4px !important;
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
        .modal-mask {
            position: fixed !important;
            z-index: 9998 !important;
            top: 0 !important;
            left: 18% !important;
            height: 100vh !important;
            background-color: rgba(0, 0, 0, .5) !important;
            display: table !important;
            transition: opacity .3s ease !important;
        }

        .modal-content {
            max-height: calc(100vh - -3.5rem) !important;
            height: 100vh
        }
    </style>
@endsection

