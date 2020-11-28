<?php

Auth::routes();

Route::namespace('Auth')->group(function () {
    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/validation/register', 'RegisterController@registerValidation');
    Route::post('/validation/login', 'LoginController@loginValidation');
    Route::post('/register/store', 'RegisterController@registerStore');
    Route::post('/login/store', 'LoginController@loginStore');
    Route::get('/register', 'RegisterController@register');
    Route::post('/login/send/code', 'LoginController@sendCode');
    Route::post('/login/check/code', 'LoginController@checkCode');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::namespace('Front')->group(function () {

    Route::get('/', 'IndexController@index')->name('home');
    Route::get('/test', 'IndexController@test');
    Route::get('/detail/{slug}/{color?}', 'IndexController@detail');
    Route::get('/fetch/product/{slug}', 'IndexController@fetch');
    Route::get('/fetch/product/galleries/{slug}', 'IndexController@fetchGalleries');
    Route::get('/fetch/color/galleries/{slug}/{color}', 'IndexController@fetchColorGalleries');
    Route::get('/fetch/effect/{slug}', 'IndexController@fetchEffect');
    Route::get('/fetch/color/{slug}', 'IndexController@fetchColor');
    Route::get('/fetch/effect/price/{slug}', 'IndexController@fetchEffectPrice');
    Route::get('/cart', 'IndexController@cart');
    Route::post('/cart/store', 'IndexController@storeCart');
    Route::get('/cart/delete/{id}', 'IndexController@deleteCart');
    Route::get('/fetch/cart', 'IndexController@fetchCart');
    Route::get('/fetch/cart/result/price', 'IndexController@fetchResultPrice');
    Route::post('/cart/total', 'IndexController@cartTotal');
    Route::get('/fetch/cart/sum/total', 'IndexController@sumTotal');
    Route::get('/fetch/cart/sum/price', 'IndexController@sumPrice');
    Route::get('/cart/fetch/number', 'IndexController@fetchCartNumber');

    Route::get('/shipping', 'ShippingController@index')->middleware('auth:web');
    Route::get('/fetch/date', 'ShippingController@fetchDate');
    Route::get('/fetch/shipping/sum/total', 'ShippingController@sumTotal');
    Route::post('/valid/shipping', 'ShippingController@validShipping');
    Route::post('/off', 'ShippingController@off');
    Route::get('/factor/fetch/order/{id}', 'ShippingController@fetchOrder');
    Route::post('/order/store', 'ShippingController@store');
    Route::post('/order/epay/store/session', 'ShippingController@epayStoreSession');
    Route::get('/order/epay/redirect/zarinpal', 'ShippingController@redirectToZarinpal');
    Route::get('/order/epay/redirect/sadad', 'ShippingController@redirectToSadad');
    Route::get('/order/return/zarinpal', 'ShippingController@returnFromZarinpal');
    Route::post('/order/return/sadad', 'ShippingController@returnFromSadad');

    Route::get('/panel/orders', 'PanelController@index')->middleware('auth:web');
    Route::get('/panel/account', 'PanelController@account')->middleware('auth:web');
    Route::get('/panel/fetch/user', 'PanelController@fetchUser')->middleware('auth:web');
    Route::post('/panel/account/store', 'PanelController@store')->middleware('auth:web');

    Route::get('/panel/ticket/form', 'TicketController@showForm')->middleware('auth:web');
    Route::post('/panel/ticket/form/store', 'TicketController@storeForm')->middleware('auth:web');
    Route::get('/panel/ticket/list', 'TicketController@list')->middleware('auth:web');
    Route::get('/panel/ticket/fetch', 'TicketController@fetchTicket')->middleware('auth:web');
    Route::get('/panel/ticket/detail/{group}', 'TicketController@detailTicket')->middleware('auth:web');
    Route::get('/panel/ticket/fetch/detail/{group}', 'TicketController@fetchDetailTicket')->middleware('auth:web');
    Route::post('/panel/ticket/detail/form/store', 'TicketController@storeFormDetail')->middleware('auth:web');

    Route::get('/order/fetch', 'PanelController@fetchOrders')->middleware('auth:web');

    Route::get('/fetch/product/spec/{slug}', 'IndexController@fetchSpec');
    Route::get('/fetch/product/category/{slug}', 'IndexController@fetchCat');
    Route::get('/fetch/product/category2/{slug}', 'IndexController@fetchCat2');
    Route::get('/fetch/product/catspec/{slug}', 'IndexController@fetchCatspec');
    Route::get('/product/fetch/value/{slug}', 'IndexController@fetchValue');

    Route::get('/offs/fetch', 'PanelController@fetchOffs');
    Route::get('/panel/offs', 'PanelController@offs');

    Route::post('/comment/store', 'IndexController@storeComment');
    Route::post('/comment/reply/store', 'IndexController@storeReplyComment');
    Route::get('/fetch/parent/comment/{slug}', 'IndexController@fetchParentComment');
    Route::get('/fetch/reply/{id}', 'IndexController@fetchReply');

    Route::get('/autocomplete/search', 'IndexController@autocompleteSearch');
    Route::get('/search/{cat}/{name}', 'IndexController@search');
    Route::post('/fetch/search/product', 'IndexController@fetchSearchProduct');
    Route::post('/fetch/search/product/cat', 'IndexController@fetchSearchProductCat');
    Route::get('/fetch/search/cats', 'IndexController@fetchSearchCat');

    Route::get('/search/{cat}', 'IndexController@searchByCat');

    Route::get('/filter/fetch/{cat}', 'FilterController@fetchFilters');

//    ================================ Balance =====================================

    Route::get('/fetch/products', 'BalanceController@fetchProducts');
    Route::get('/fetch/products/parent/cat/{cat}', 'BalanceController@fetchProductsParentCat');
    Route::post('/filter/search/products', 'BalanceController@searchByKey');
    Route::post('/filter/search/cat/brand', 'BalanceController@searchByBrandFilter');
    Route::post('/filter/convert', 'BalanceController@filterConvert');

    Route::get('/fetch/products/{cat}', 'BalanceController@fetchProductsCat');
    Route::get('/fetch/brands/{cat}', 'BalanceController@fetchBrandsCat');
    Route::get('/fetch/all/brands', 'BalanceController@fetchBrands');
    Route::get('/fetch/all/brands/related/{cat}', 'BalanceController@fetchBrandsRelated');

    Route::post('/search/brand/cat', 'BalanceController@searchByBrandCat');
    Route::post('/search/brands', 'BalanceController@searchByBrand');

    Route::get('/auto/search/{type}/{name}', 'BalanceController@autoSearch');
    Route::get('/brands/{name}', 'BalanceController@brands');

    Route::get('/fetch/brand/products/{brandName}', 'BalanceController@fetchProductsBrand');
    Route::get('/fetch/brand/cat/{brandName}', 'BalanceController@fetchCatsBrand');

    Route::get('/favourites', 'BalanceController@favourites');
    Route::get('/add/fav/{id}', 'BalanceController@addFav');
    Route::get('/fetch/favs', 'BalanceController@fetchFavs');
    Route::get('/fav/delete/{id}', 'BalanceController@deleteFav');

    Route::get('/related/product/{slug}', 'BalanceController@related');


    Route::get('/mega/cat/fetch', 'BalanceController@fetchMegaCat');
    Route::get('/megas/fetch', 'BalanceController@fetchMegas');

    Route::post('/check/color/exist/{slug}', 'BalanceController@checkColorExist');
    Route::post('/check/effect/exist/{slug}', 'BalanceController@checkEffectExist');
    Route::post('/check/product/exist/{slug}', 'BalanceController@checkProductExist');
    Route::post('/check/product/exist/effect/not/set/{slug}', 'BalanceController@checkProductExistIfEffectNotSet');
    Route::post('/check/product/exist/color/not/set/{slug}', 'BalanceController@checkProductExistIfColorNotSet');
    Route::post('/check/product/exist/nothing/set/{slug}', 'BalanceController@checkProductExistIfNothingSet');
    Route::post('/test/test', 'BalanceController@testTest');
    Route::get('/fetch/effect/price/{slug}', 'IndexController@fetchEffectPriceDetail');
    Route::get('/fetch/effect/spec/{slug}', 'IndexController@fetchEffectSpecDetail');
    Route::get('/fetch/slider', 'IndexController@fetchSlider');


//    ================================ Online =====================================
    Route::get('/fetch/new/products', 'OnlineController@newProducts');
    Route::get('/category/fetch/cat/root', 'OnlineController@fetchRootCat');

//    ================================ Online =====================================
    Route::get('/about-us', 'IndexController@about');
    Route::get('/contact-us', 'IndexController@contact');
    Route::get('/rolls', 'IndexController@rolls');
    Route::get('/delivery', 'IndexController@delivery');
    Route::get('/online/online', 'IndexController@online');
    Route::get('/search/brand/{cat}/{brand}', 'IndexController@searchBrand');

    Route::get('/complaint', 'IndexController@complaint');
    Route::post('/complaint/store', 'IndexController@complaintStore');

//    ================================ Kaj =====================================
    Route::get('/fetch/suggests', 'KajController@fetchSuggests');
    Route::get('/fetch/state', 'ShippingController@fetchState');
    Route::get('/fetch/city/{id}', 'ShippingController@fetchCity');
    Route::get('/fetch/user/info', 'ShippingController@userInfo');

});

