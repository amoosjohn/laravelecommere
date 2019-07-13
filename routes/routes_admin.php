<?php

Route::group(['prefix' => 'admin','middleware' => 'admin'], function() {
    $admin = "Admin\\";
    Route::get('/', $admin . 'HomeController@index');
    Route::get('/dashboard', $admin . 'HomeController@index');
    Route::get('/logout', $admin . 'HomeController@logout');
    Route::get('/password', $admin . 'HomeController@changePassword');
    Route::post('/password/update', $admin . 'HomeController@updatePassword');
    
    Route::group(['middleware' => 'super_admin'], function() {
        $admin = "Admin\\";
        Route::resource('users',  $admin.'UsersController');
        //Route::get('/user/{id}', $admin . 'UsersController@userDetail');
        //Route::get('/user/edit/{id}', $admin . 'UsersController@edit');
        //Route::post('/user/update', $admin . 'UsersController@update');
        Route::get('user/search', $admin . 'UsersController@search');
        Route::get('content', $admin . 'ContentController@index');
        Route::get('content/create', $admin . 'ContentController@create');
        Route::post('content/insert', $admin . 'ContentController@insert');
        Route::get('content/delete/{id}', $admin . 'ContentController@delete');
        Route::get('content/edit/{id}', $admin . 'ContentController@edit');
        Route::get('content/show/{id}', $admin . 'ContentController@show');
        Route::post('content/update/{id}', $admin . 'ContentController@update');
        Route::get('content/google', $admin . 'ContentController@google');
        Route::post('content/google/update/{id}', $admin . 'ContentController@updateGoogle');
        Route::get('content/shipping-rates', $admin . 'ContentController@shippingRates');
        Route::post('content/shipping-rates/update/{id}', $admin . 'ContentController@updateShippingRates');
    });
    Route::get('/admin-users', $admin . 'AdminUsersController@index');
    Route::get('/admin-user/{id}', $admin . 'AdminUsersController@userDetail');
    Route::get('/admin-users/add', $admin . 'AdminUsersController@create');
    Route::post('/admin-users/store', $admin . 'AdminUsersController@store');
    Route::get('/user/approve/{id}', $admin . 'UsersController@accept');
    Route::get('/user/disapprove/{id}', $admin . 'UsersController@reject');
    Route::get('user/edit/{id}', $admin . 'UsersController@edit');

    Route::get('categories', $admin . 'CategoriesController@index');
    Route::get('categories/create', $admin . 'CategoriesController@create');
    Route::get('categories/createSubcat', $admin . 'CategoriesController@create_sub_cat');
    Route::post('categories/storeSubcat', $admin . 'CategoriesController@store_sub_cat');
    Route::post('categories/insert', $admin . 'CategoriesController@insert');
    Route::get('categories/delete/{id}', $admin . 'CategoriesController@delete');
    Route::get('categories/edit/{id}', $admin . 'CategoriesController@edit');
    Route::get('categories/show/{id}', $admin . 'CategoriesController@show');
    Route::post('categories/update/{id}', $admin . 'CategoriesController@update');
    Route::get('categories/category', $admin . 'CategoriesController@getCategories');
    Route::get('categories/sub-category/{parent_id}', $admin . 'CategoriesController@getSubCategories');
    Route::get('commission', $admin . 'CategoriesController@commission');
    Route::post('commission/update', $admin . 'CategoriesController@commissionUpdate');
    Route::get('category', $admin . 'CategoriesController@getCategory');
    
    Route::get('import', $admin . 'HomeController@import');
    Route::post('upload', $admin . 'HomeController@upload');
    
    Route::get('/vendors', $admin . 'AdminVendorsController@index');
    Route::get('/vendor-details/{id}', $admin . 'AdminVendorsController@userDetail');
    Route::get('/vendor/create', $admin . 'AdminVendorsController@create');
    Route::get('/vendor/new', $admin . 'VendorsController@create');
    Route::post('/vendor/store', $admin . 'AdminVendorsController@store');
    Route::get('vendor/edit/{id}', $admin . 'AdminVendorsController@edit');
    Route::post('vendor/update/{id}', $admin . 'AdminVendorsController@update');
    Route::get('vendor/delete/{id}', $admin . 'AdminVendorsController@destroy');
    Route::get('vendor/status/{id}', $admin . 'AdminVendorsController@status');
    Route::get('vendor/search', $admin . 'AdminVendorsController@search');
    
    Route::get('brands', $admin . 'BrandsController@index');
    Route::get('brands/create', $admin . 'BrandsController@create');
    Route::post('brands/insert', $admin . 'BrandsController@insert');
    Route::get('brands/delete/{id}', $admin . 'BrandsController@delete');
    Route::get('brands/edit/{id}', $admin . 'BrandsController@edit');
    Route::get('brands/show/{id}', $admin . 'BrandsController@show');
    Route::post('brands/update/{id}', $admin . 'BrandsController@update');
    Route::get('brands/search', $admin . 'BrandsController@search');
    
    Route::resource('products', $admin.'ProductController');
    Route::get('product/search', $admin . 'ProductController@search');
    Route::get('product/size/delete/{id}', $admin . 'ProductController@sizeDelete');
    Route::get('product/commission', $admin . 'ProductController@commission');
    Route::post('product/massDelete', $admin . 'ProductController@massDelete');

    Route::resource('size', $admin.'SizeController');
    Route::resource('colours', $admin.'ColourController');
    
    Route::get('product/addimage/{id}', $admin . 'GalleryController@addImage');
    Route::post('product/uploadimage', $admin . 'GalleryController@uploadImage');
    Route::get('product/addmultiple/{id}', $admin . 'GalleryController@addMultipleImage');
    Route::post('product/uploadmultiple', $admin . 'GalleryController@uploadMultipleImage');
    Route::get('product/deleteimage/{id}', $admin . 'GalleryController@deleteImage');
    Route::get('product/deleteallimages/{product_id}', $admin . 'GalleryController@deleteAllImage');
    Route::get('product/loadgallery', $admin . 'GalleryController@loadGallery');
    Route::post('product/insertorder', $admin . 'GalleryController@insertOrder');
    
    Route::get('orders/search', $admin . 'OrdersController@search');
    Route::get('orders/sendmail/{id}', $admin . 'OrdersController@send');
    Route::get('orders/invoice/{id}', $admin . 'OrdersController@invoice');
    Route::resource('orders', $admin.'OrdersController'); 
    Route::resource('slider', $admin.'SliderController');
    Route::resource('sections', $admin.'SectionsController');
    Route::resource('reviews', $admin.'ReviewsController');
    Route::resource('customers', $admin.'CustomersController');
    Route::get('customer/search', $admin . 'CustomersController@search');
    Route::get('customer/status/{id}', $admin . 'CustomersController@update');
    Route::get('newsletter', $admin . 'HomeController@newsletter');
    Route::get('newsletter/delete/{id}', $admin . 'HomeController@delete');
    Route::get('newsletter/export', $admin . 'HomeController@export');
    Route::resource('coupons', $admin.'DiscountCouponsController');
    Route::resource('complaint', $admin.'ComplaintController');
    
    Route::get('payments/search', $admin.'PaymentsController@search');
    Route::resource('payments', $admin.'PaymentsController');
    Route::get('report', $admin . 'ReportController@index');
    Route::get('report/search', $admin . 'ReportController@search');
    Route::get('report/show/{id}', $admin . 'ReportController@show');
   
}
);
