<?php

Route::group(['prefix' => 'vendor','middleware' => 'vendor_role'], function() {
        $vendor = "Vendors\\";
        
        Route::get('/', $vendor . 'HomeController@index');
        Route::get('/view-profile', $vendor . 'HomeController@view_profile');
        Route::get('/info_edit/{id}', $vendor . 'HomeController@edit_profile');
        
        Route::post('/info_updated/{id}', $vendor . 'HomeController@update_profile');
         
        //// FOR Contacts 
        Route::get('/all-contacts', $vendor . 'HomeController@all_contacts');  
        
        /// FOR Users  
        Route::get('users', $vendor . 'UsersController@index');
        Route::get('users/create', $vendor . 'UsersController@create');
        Route::post('users/store', $vendor . 'UsersController@store');  
        Route::get('users/edit/{id}', $vendor . 'UsersController@edit');
        Route::post('users/update/{id}', $vendor . 'UsersController@update'); //delete
        Route::get('user/delete/{id}', $vendor . 'UsersController@delete');
          
        Route::get('brands', $vendor . 'BrandsController@index');
        Route::get('brands/create', $vendor . 'BrandsController@create');
        Route::post('brands/insert', $vendor . 'BrandsController@insert');
        Route::get('brands/delete/{id}', $vendor . 'BrandsController@delete');
        Route::get('brands/edit/{id}', $vendor . 'BrandsController@edit');
        Route::get('brands/show/{id}', $vendor . 'BrandsController@show');
        Route::post('brands/update/{id}', $vendor . 'BrandsController@update');
        
        Route::get('product/search', $vendor . 'ProductController@search');
        Route::get('product/size/delete/{id}', $vendor . 'ProductController@sizeDelete');
        Route::get('product/commission', $vendor . 'ProductController@commission');
        Route::post('product/massDelete', $vendor . 'ProductController@massDelete');
        Route::resource('products', $vendor.'ProductController');
        
        
        Route::get('product/addimage/{id}', $vendor . 'GalleryController@addImage');
        Route::post('product/uploadimage', $vendor . 'GalleryController@uploadImage');
        Route::get('product/deleteimage/{id}', $vendor . 'GalleryController@deleteImage');
        Route::get('product/deleteallimages/{product_id}', $vendor . 'GalleryController@deleteAllImage');
        Route::get('product/loadgallery', $vendor . 'GalleryController@loadGallery');
        Route::post('product/insertorder', $vendor . 'GalleryController@insertOrder');
        
        Route::get('commission', $vendor . 'HomeController@commission');
        Route::get('/logout', $vendor . 'HomeController@logout');
        Route::get('categories', $vendor . 'HomeController@getCategories');
        
        Route::resource('reviews', $vendor.'ReviewsController');
        Route::get('orders/search', $vendor . 'OrdersController@search');
        Route::get('orders/sendmail/{id}', $vendor . 'OrdersController@send');
        Route::get('orders/invoice/{id}', $vendor . 'OrdersController@invoice');
        Route::resource('orders', $vendor.'OrdersController');
        
        Route::get('product/import', $vendor . 'ImportController@import');
        Route::post('product/upload', $vendor . 'ImportController@upload');
        Route::get('import/images', $vendor . 'ImportController@importImages');
        Route::post('product/prices', $vendor . 'ImportController@importPrices');
        
        Route::get('product/export', $vendor . 'ExportController@export');
        Route::get('product/category/export', $vendor . 'ExportController@exportCategory');
        Route::get('csv/delete', $vendor . 'ExportController@delete');
        
        Route::get('report', $vendor . 'ReportController@index');
        Route::get('report/show', $vendor . 'ReportController@show');
        
}
);
