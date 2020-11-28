<aside class="main-sidebar" style="background-color: #343a40">
    <div class="sidebar" style="direction: ltr;height: 100vh;padding-left: 0">
        <div style="direction: rtl">
            <br>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" id="ul-side-bar"
                    data-accordion="false">
                    {{--@can('dashboard')--}}
                    <li class="nav-item has-treeview">
                        <a href="{{url('/admin/dashboard')}}" class="nav-link" id="side_dashboard">
                            <i class="nav-icon fa fa-tachometer-alt"></i>
                            <p>
                                داشبورد
                            </p>
                        </a>

                    </li>
                    {{--@endcan--}}

                    {{--@can('category')--}}
                    <li id="side_category" class="nav-item has-treeview">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                دسته بندی ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a id="side_category_add" href="{{ url('/admin/category/create') }}"
                                   class="nav-link">
                                    <p>مدیریت دسته ها</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--@endcan--}}

                    {{--@can('brand')--}}
                    <li class="nav-item has-treeview" id="side_brand">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-backspace"></i>
                            <p>
                                برند ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item inner">
                                <a href="{{ url('/admin/brand/create') }}" class="nav-link" id="side_brand_add">

                                    <p>مدیریت برندها</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--@endcan--}}


                    {{--@can('pricing')--}}
                    <li class="nav-item has-treeview" id="side_price">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fa fa-dollar-sign"></i>
                            <p>
                                قیمت گذاری
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/effect/create') }}" class="nav-link" id="side_effect_price">

                                    <p>دسته عامل</p>
                                </a>
                            </li>
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/effect/spec/create') }}" class="nav-link"
                                   id="side_effect_spec_add">
                                    <p>عامل</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--@endcan--}}

                    {{--@can('product')--}}
                    <li id="side_product" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-box-open"></i>
                            <p>
                                محصولات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/product/index') }}" class="nav-link"
                                   id="side_product_index">

                                    <p>لیست</p>
                                </a>
                            </li>
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/product/create') }}" class="nav-link"
                                   id="side_product_add">

                                    <p>افزودن</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--@endcan--}}

                    <li id="side_exist" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-database"></i>
                            <p>
                                موجودی محصولات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/exist/index') }}" class="nav-link"
                                   id="side_exist_index">
                                    <p>لیست</p>
                                </a>
                            </li>
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/exist/product/code') }}" class="nav-link" id="side_exist_product_code">
                                    <p>کد محصول</p>
                                </a>
                            </li>
                            <!--<li class="nav-item inner">-->
                            <!--    <a href="{{ url('/admin/inventory_transactions') }}" class="nav-link"-->
                            <!--       id="side_inventory_transactions">-->
                            <!--    <p>تراکنش محصولات</p>-->
                            <!--    </a>-->
                            <!--</li>-->
                        </ul>
                    </li>

                    {{--@can('order')--}}
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fa fa-list-alt"></i>
                            <p>
                                سفارشات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/order/index') }}" class="nav-link ">

                                    <p>لیست</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--@endcan--}}

                    <li class="nav-item has-treeview" id="side_setting">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-cog"></i>
                            <p>
                                تنظیمات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/slider/create') }}" class="nav-link" id="side_slider_create">
                                    <p>اسلایدر</p>
                                </a>
                            </li>
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/index/create') }}" class="nav-link" id="side_index_add">
                                    <p>صفحه اصلی</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview" id="side_about">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-file-alt"></i>
                            <p>
                                صفحات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/about/create') }}" class="nav-link" id="side_about_edit">
                                    <p>ویرایش</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview" id="side_cart">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-cart-arrow-down"></i>
                            <p>
                                سبد خرید کاربر
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/cart/index') }}" class="nav-link" id="side_cart_index">
                                    <p>لیست</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item has-treeview" id="side_complaint">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-comment"></i>
                            <p>
                                شکایات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/complaint/index') }}" class="nav-link" id="side_complaint_create">
                                    <p>لیست</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    
                </ul>
            </nav>
        </div>
    </div>
</aside>
