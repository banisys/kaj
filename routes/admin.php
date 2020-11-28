<?php

Route::prefix('admin')->group(function () {
    Route::get('login', 'Auth\Admin\LoginController@login')->name('admin.auth.login');
    Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
    Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('register', 'AdminController@create')->name('register');
    Route::post('register', 'AdminController@store')->name('store');

    Route::get('/dashboard', 'AdminController@dashboard');

//  ==================================== Permission =============================
    Route::get('/permission/create', 'PermissionController@create');
    Route::post('/permission/store', 'PermissionController@store');
    Route::get('/permission/fetch', 'PermissionController@fetch');
    Route::get('/permission/delete/{id}', 'PermissionController@delete');
    Route::get('/permission/search', 'PermissionController@search');

//  ==================================== Role ====================================
    Route::get('/role/create', 'RoleController@create');
    Route::post('/role/store', 'RoleController@store');
    Route::get('/role/fetch', 'RoleController@fetch');
    Route::get('/role/delete/{id}', 'RoleController@delete');
    Route::get('/role/search', 'RoleController@search');
    Route::get('/role/getPermission', 'RoleController@getPermission');
    Route::get('/role/fetchPermission/{id}', 'RoleController@fetchPermission');
    Route::get('/get-roles', 'AdminController@getRoles');
    Route::get('/fetch', 'AdminController@fetch');
    Route::get('/search', 'AdminController@search');
    Route::get('/fetchRole/{id}', 'AdminController@fetchRole');
    Route::get('/delete/{id}', 'AdminController@delete');

//  ==================================== Product ====================================
    Route::get('/product/create', 'ProductController@create');
    Route::get('/product/index', 'ProductController@index');
    Route::get('/product/edit/{id}', 'ProductController@edit');
    Route::get('/product/effect/price/{id}', 'ProductController@fetchEffectPriceId');
    Route::get('/product/{id}', 'ProductController@fetchProduct');
    Route::get('/product/catspec/{id}', 'ProductController@fechCatspec');
    Route::post('/product/store', 'ProductController@store');
    Route::post('/product/update/{id}', 'ProductController@update');
    Route::get('/product/aaa/fetch', 'ProductController@fetch');
    Route::get('/product/fetch/value/{pro}', 'ProductController@fetchValue');
    Route::get('/product/fetch/effect/values/{id}', 'ProductController@fetchEffectVal');
    Route::get('/product/fetch/colors/{pro}', 'ProductController@fetchColors');
    Route::get('/product/fetch/gallery/{pro}', 'ProductController@fetchGallery');
    Route::get('/product/delete/gallery/{id}', 'ProductController@deleteGallery');
    Route::get('/product/delete/color/image/{id}', 'ProductController@deleteColorImage');
    Route::get('/product/delete/{id}', 'ProductController@delete');
    Route::get('/product/a/search', 'ProductController@search');
    Route::get('/product/fetch/count', 'ProductController@proCount');
    Route::get('/product/effect/price/{cat}/{brand}', 'ProductController@fetchEffectPrice');
    Route::get('/product/color/image/{id}', 'ProductController@colorImageShow');
    Route::get('/product/fetch/cat/id/{name}', 'ProductController@getCatId');
    Route::get('/product/fetch/brands/{product_id}', 'ProductController@fetchBrands');
    Route::post('/product/edit/price', 'ProductController@editPrice');


//  ==================================== Specification ====================================
    Route::get('/specification/create', 'SpecificationController@create');
    Route::get('/specification/catspec/{name}', 'SpecificationController@fechCatspec');
    Route::post('/specification/store', 'SpecificationController@store');
    Route::get('/specification/fetch', 'SpecificationController@fetch');
    Route::get('/specification/search', 'SpecificationController@search');
    Route::get('/specification/delete/{id}', 'SpecificationController@delete');

//  ==================================== CatSpec ====================================
    Route::get('/catspec/create', 'CatspecController@create');
    Route::get('/catspec/cat', 'CatspecController@fechCat');
    Route::post('/catspec/store', 'CatspecController@store');
    Route::get('/catspec/fetch', 'CatspecController@fetch');
    Route::get('/catspec/delete/{id}', 'CatspecController@delete');
    Route::get('/catspec/search', 'CatspecController@search');

//  ==================================== Specopy ====================================
    Route::get('/specopy/create', 'SpecopyController@create');
    Route::post('/specopy/store', 'SpecopyController@store');


//  ==================================== Brand ====================================
    Route::get('/brand/create', 'BrandController@create');
    Route::post('/brand/store', 'BrandController@store');
    Route::get('/brand/fetch', 'BrandController@fetch');
    Route::get('/brand/fetch/all', 'BrandController@fetchAll');
    Route::get('/brand/fetch/{cat}', 'BrandController@fetchBrandCat');
    Route::get('/brand/search', 'BrandController@search');
    Route::get('/brand/image/{id}', 'BrandController@image');
    Route::get('/brand/description/{id}', 'BrandController@description');
    Route::get('/brand/delete/{id}', 'BrandController@delete');
    Route::post('/brand/edit/cat', 'BrandController@editCat');
    Route::get('/brand/fetch/cat/child/{id}', 'BrandController@fetchRootChild');
    Route::get('/brand/fetch/cat/root', 'BrandController@fetchRootCat');

//  ==================================== Category ====================================
    Route::get('/category', 'CategoryController@index');
    Route::get('/category/create', 'CategoryController@create');
    Route::post('/category/store', 'CategoryController@store');
    Route::get('/category/fetch', 'CategoryController@fetch');
    Route::get('/category/fetch/test', 'CategoryController@fetchTest');
    Route::get('/category/fetchall', 'CategoryController@fetchall');
    Route::get('/category/fetchsubcat/{id}', 'CategoryController@fetchsubcat');
    Route::get('/category/fetchsubsubcat/{id}', 'CategoryController@fetchsubsubcat');
    Route::get('/category/fetchsubs/{id}', 'CategoryController@fetchsubs');
    Route::get('/category', 'CategoryController@index');
    Route::get('/category/delete/{id}', 'CategoryController@delete');
    Route::get('/category/search', 'CategoryController@search');
    Route::get('/category/showedit/{id}', 'CategoryController@showedit');
    Route::get('/category/fetnewcat/{id}', 'CategoryController@fetnewcat');
    Route::post('/category/update', 'CategoryController@update');
    Route::get('/category/fetch/cat/root/{type}', 'CategoryController@fetchRootCat');
    Route::get('/category/fetch/cat/child/{id}/{type}', 'CategoryController@fetchRootChild');
    Route::get('/category/fetch/brand', 'CategoryController@fetchBrands');
    Route::post('/category/edit', 'CategoryController@edit');
    Route::get('category/search/brand/{brand}', 'CategoryController@searchBrand');

//  ==================================== Effect ====================================
    Route::get('/effect/create', 'Effect_priceController@create');
    Route::get('/effect/brand/{id}', 'Effect_priceController@fechBrand');
    Route::post('/effect/store', 'Effect_priceController@store');
    Route::get('/effect/fetch', 'Effect_priceController@fetch');
    Route::get('/effect/delete/{id}', 'Effect_priceController@delete');
    Route::get('/effect/search', 'Effect_priceController@search');

//  ==================================== EffectSpec ====================================
    Route::get('/effect/spec/create', 'Effect_specController@create');
    Route::get('/effect/spec/brand/{brand_id}/{cat_id}', 'Effect_specController@fetchEffectPrice');
    Route::get('/effect/spec/fetch', 'Effect_specController@fetch');
    Route::post('/effect/spec/store', 'Effect_specController@store');
    Route::get('/effect/spec/search', 'Effect_specController@search');
    Route::get('/effect/spec/delete/{id}', 'Effect_specController@delete');

//  ==================================== Order ====================================
    Route::get('/order/index', 'OrderController@index');
    Route::get('/order/fetch', 'OrderController@fetch');
    Route::post('/change/status/{id}', 'OrderController@changeStatus');
    Route::get('/order/search', 'OrderController@search');
    Route::get('/order/delete/{id}', 'OrderController@delete');
    Route::get('/fetch/order/{id}', 'OrderController@fetchOrder');
    Route::get('/factor/sum/value/{id}', 'OrderController@fetchOrderValue');
    Route::get('/factor/confirm/{id}', 'OrderController@factorConfirm');
    Route::get('/order/not-confirm/fetch', 'OrderController@fetchNotConfirm');
    Route::get('/order/confirm/fetch', 'OrderController@fetchConfirm');

//  ==================================== Off ====================================
    Route::get('/off', 'OffController@create');
    Route::get('/off/fetchOffs', 'OffController@fetchOffs');
    Route::get('/off/fetchCat', 'OffController@fetchCat');
    Route::get('/off/fetchBrands', 'OffController@fetchBrands');
    Route::post('/off/store', 'OffController@store');
    Route::get('/off/delete/{id}', 'OffController@delete');
    Route::get('/off/search', 'OffController@search');
    Route::get('/off/edit/{id}', 'OffController@edit');
    Route::get('/off/fetch/detail/{id}', 'OffController@fetchDetail');
    Route::get('/department', 'DepartmentController@create');
    Route::get('/department/fetchDepartment', 'DepartmentController@fetchDepartment');
    Route::post('/department/store', 'DepartmentController@store');
    Route::get('/department/delete/{id}', 'DepartmentController@delete');
    Route::get('/department/search', 'DepartmentController@search');

//  ==================================== Filter ====================================
    Route::get('/filter/cat', 'FilterController@filterCatCreate');
    Route::post('/filter/cat/store', 'FilterController@storeFilterCat');
    Route::get('/filter/cat/fetch', 'FilterController@fetchFilterCat');
    Route::get('/filter/cat/delete/{id}', 'FilterController@delete');
    Route::get('/filter', 'FilterController@filterCreate');
    Route::get('/filter/cat/{cat_id}', 'FilterController@FilterCat');
    Route::get('/filter/fetch', 'FilterController@fetchFilter');
    Route::post('/filter/store', 'FilterController@storeFilter');
    Route::get('/filter/delete/{id}', 'FilterController@deleteFilter');
    Route::get('/filter/fetch/cat/{id}', 'FilterController@fetchFilterCat2');

//  ==================================== Mega ====================================
    Route::get('/mega/create', 'MegaController@create');
    Route::get('/mega/fetch/cat/root', 'MegaController@fetchRootCat');
    Route::get('/mega/fetch/cat/child/{id}', 'MegaController@fetchRootChild');
    Route::get('/mega/fetch/brands', 'MegaController@fetchBrands');
    Route::post('/mega/store', 'MegaController@store');
    Route::get('/megas/fetch', 'MegaController@fetchMegas');
    Route::get('/mega/delete/{id}', 'MegaController@delete');

//  ==================================== MegaCat ====================================
    Route::get('/mega/cat/create', 'MegaController@megaCat');
    Route::post('/mega/store/mega/cat', 'MegaController@storeMegaCats');
    Route::get('/mega/cat/fetch', 'MegaController@fetchMegaCats');
    Route::get('/mega/cat/delete/{id}', 'MegaController@deleteCat');
    Route::get('/mega/fetch/megacats', 'MegaController@megaCats');

//  ==================================== Ticket ====================================
    Route::get('/ticket/index', 'TicketController@index');
    Route::get('/ticket/fetch', 'TicketController@fetchTicket');
    Route::get('/ticket/detail/{group}', 'TicketController@detailTicket');
    Route::get('/ticket/fetch/detail/{group}', 'TicketController@fetchDetailTicket');
    Route::post('/ticket/form/store', 'TicketController@storeForm');
    Route::get('/ticket/new/fetch', 'TicketController@fetchNewTicket');
    Route::get('/ticket/fetch/admin', 'TicketController@fetchAdmin');
    Route::post('/ticket/routing/set/admin', 'TicketController@setAdmin');
    Route::get('/ticket/my/index', 'TicketController@indexMy');
    Route::get('/ticket/my/fetch', 'TicketController@fetchMyTicket');

//  ==================================== Page ====================================
    Route::get('/page/create', 'PageController@create');
    Route::get('/page/fetch/cat', 'PageController@fetchCat');
    Route::post('/page/store', 'PageController@store');
    Route::get('/page/index', 'PageController@index');
    Route::get('/page/fetch/pages', 'PageController@fetchPages');
    Route::get('/page/search', 'PageController@search');
    Route::get('/page/delete/{id}', 'PageController@delete');
    Route::get('/page/edit/{id}', 'PageController@edit');
    Route::get('/page/{id}', 'PageController@fetchPage');
    Route::post('/page/update/{id}', 'PageController@update');
    Route::get('/page/delete/title/{id}', 'PageController@deleteTitle');

//  ==================================== Blog ====================================
    Route::get('/blog/create', 'BlogController@create');
    Route::get('/blog/fetch/cat', 'BlogController@fetchCat');
    Route::post('/blog/store', 'BlogController@store');
    Route::get('/blog/index', 'BlogController@index');
    Route::get('/blog/fetch/blogs', 'BlogController@fetchBlogs');
    Route::get('/blog/search', 'BlogController@search');
    Route::get('/blog/delete/{id}', 'BlogController@delete');
    Route::get('/blog/edit/{id}', 'BlogController@edit');
    Route::get('/blog/{id}', 'BlogController@fetchBlog');
    Route::post('/blog/update/{id}', 'BlogController@update');
    Route::get('/blog/delete/title/{id}', 'BlogController@deleteTitle');

//  ==================================== Image ====================================
    Route::get('/image/create', 'ImageController@create');
    Route::post('/image/store', 'ImageController@store');

//  ==================================== Exist ====================================
    Route::get('/exist/index', 'ExistController@index');
    Route::get('/exist/set/{id}', 'ExistController@set');
    Route::get('/exist/fetch/colors/{id}', 'ExistController@fetchColors');
    Route::get('/exist/fetch/effects/{id}', 'ExistController@fetchEffects');
    Route::get('/exist/get/slug/{id}', 'ExistController@getSlug');
    Route::post('/exist/store/num', 'ExistController@storeNum');
    Route::get('/exist/fetch/{id}', 'ExistController@fetchExist');
    Route::get('/exist/delete/{id}', 'ExistController@delete');
    Route::get('/exist/product/code', 'ExistController@productCode');
    Route::post('/exist/search/product/code', 'ExistController@productCodeSearch');
    Route::post('/exist/product/code/change/num', 'ExistController@changeNum');
    Route::get('/exist/fetch/effect/{id}', 'ExistController@fetchEffect');
    Route::get('/exist/fetch/effect/price/{id}', 'ExistController@fetchEffectPrice');
    Route::get('/exist/fetch/effect/spec/{id}', 'ExistController@fetchEffectSpec');
    
//  ==================================== InventoryTransaction ======================
    Route::get('/inventory_transactions', 'InventoryTransactionController@index');

//  ==================================== Slider ====================================
    Route::get('/slider/create', 'SliderController@create');
    Route::post('/slider/store', 'SliderController@store');
    Route::get('/slider/fetch/slide', 'SliderController@slideFetch');
    Route::get('/slider/delete/{id}', 'SliderController@delete');

//  ==================================== About ====================================
    Route::get('/about/create', 'AboutController@create');
    Route::post('/about/update', 'AboutController@update');
    Route::get('/about/fetch', 'AboutController@fetch');
    
    //  ==================================== Cart ====================================
    Route::get('/cart/index', 'CartController@index');
    Route::post('/cart/search/mobile', 'CartController@cartSearch');
    Route::get('/carts', 'CartController@newindex');
    
    
    
//  ==================================== Complaint ====================================
    Route::get('/complaint/index', 'IndexController@showComplaint');
    Route::get('/complaint/fetch', 'IndexController@fetchComplaint');
    Route::get('/complaint/ticket/{id}', 'IndexController@showTicketComplaint');

});

//  ==================================== Other =================================
Route::get('/factor/{id}', 'Admin\OrderController@factor')->middleware('factor');
Route::get('/admin/fetch/order/value/{id}', 'Admin\OrderController@fetchOrderValue');
Route::get('/admin/order/sum/price/{id}', 'Admin\OrderController@sumPrice');
Route::get('/admin/order/fetch/number/{id}', 'Admin\OrderController@fetchNumber');

//  ==================================== Index ====================================
Route::get('/admin/index/create', 'Admin\IndexController@create');
Route::post('/admin/index/image/store', 'Admin\IndexController@imageStore');
Route::post('/admin/index/url/store', 'Admin\IndexController@urlStore');
Route::get('/admin/index/fetch/image', 'Admin\IndexController@fetchImage');

Route::get('/admin/about/fetch', 'Admin\AboutController@fetch');
