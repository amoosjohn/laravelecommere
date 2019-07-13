<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('about', 'HomeController@aboutus');
Route::get('complaint', 'HomeController@complaint');
Route::post('complaint/store', 'HomeController@complaintStore');
Route::get('complain', 'HomeController@complain');
Route::get('thankyou_order', 'HomeController@thankyou_order');
Route::get('/test', function()
{
	return view('emails.welcome');

});
//Route::get('gallery', 'GalleryController@index');
Route::get('gallery', array('as'=>'gallery.index', 'uses'=>'GalleryController@index'));
//Route::get('history', array('as'=>'gallery.index', 'uses'=>'GalleryController@index'));
Route::get('history', 'HomeController@history');
Route::get('calender', 'HomeController@calender');
Route::get('location', 'HomeController@locations');
Route::get('terms-and-conditions', 'HomeController@termsConditions');
Route::get('refund-policies', 'HomeController@refundPolicies');
Route::get('return-replacement-policies', 'HomeController@returnReplacePolicy');
Route::get('vendor-agreement', 'HomeController@vendorAgreement');
Route::get('product/{id}', 'ProductController@details');
Route::get('review/{key}', 'ProductController@review');
Route::post('review/store/{key}', 'ProductController@store');

Route::get('main/{key}', 'CategoriesController@index');
Route::get('category/{key}', 'CategoriesController@category');
Route::get('brand/{key}', 'CategoriesController@brand');
Route::get('seller/{key}', 'CategoriesController@vendor');

Route::get('search', 'SearchController@index');
Route::get('query', 'SearchController@submit');
Route::get('result', 'SearchController@result');

Route::get('cart', 'CartController@index');
Route::post('cart/store', 'CartController@store');
Route::post('cart/show', 'CartController@show');
Route::get('cart/delete/{id}', 'CartController@delete');
Route::post('cart/update', 'CartController@update');
Route::post('coupons/apply', 'CartController@apply');
Route::get('coupons/remove', 'CartController@remove');
//Route::group(['middleware' => 'customer_role'], function() {
    Route::get('checkout', 'CheckoutController@index');
    Route::get('thank-you', 'CheckoutController@thankYou');
//});
Route::get('checkout/cities', 'CheckoutController@cities');
Route::post('checkout/store', 'CheckoutController@store');
Route::post('save-comment', 'CommentsController@saveComment');

Route::get('forgot-password', 'SignupController@forgot_password');
Route::post('reset', 'SignupController@reset_password');
Route::get('register/success/{id}', 'SignupController@success');
Route::get('register/verify/{confirmation_code}', 'SignupController@confirmEmail');

Route::get('changepassword', 'CustomersController@changepassword');
Route::post('postchangepassword', 'CustomersController@postchangepassword');
Route::get('profile/edit', 'CustomersController@editprofile');
Route::get('profile', 'CustomersController@profile');
Route::post('updateprofile', 'CustomersController@updateprofile');

Route::get('login', 'SignupController@login');
Route::group(['middleware' => 'logged.in'], function () {

   Route::get('admin/login', 'SignupController@adminlogin');
   Route::get('vendor/login', 'SignupController@vendorlogin');

});

Route::get('auth/logout', 'Auth\LoginController@logout');
Route::get('signup', 'SignupController@signup');
Route::post('customer/register', 'SignupController@store');
Route::get('logout', 'SignupController@signup');
Route::get('twitter/login', 'SignupController@twitter');
Route::get('twitter/callback', 'SignupController@twittercallback');

Route::post('postLogin', 'SignupController@postLogin');
Route::get('fblogin', 'SignupController@fblogin');
Route::get('signupform', 'SignupController@signupform');
Route::get('loginform', 'SignupController@loginform');
Route::get('vendor/signup', 'SignupController@vendorSignup');
Route::post('vendor/register', 'SignupController@vendorRegister');

Route::group(['prefix' => 'customer','middleware' => 'customer_role'], function() {
    Route::get('dashboard', 'DashboardController@index');
    Route::get('account', 'DashboardController@account');
    Route::post('account/update', 'DashboardController@update');
    Route::get('orders', 'DashboardController@orders');
    Route::get('orders/{id}', 'DashboardController@details');
    Route::get('ratings', 'DashboardController@ratings');
    Route::get('password', 'DashboardController@changePassword');
    Route::post('password/update', 'DashboardController@updatePassword');
}
);

//Route::get('track', 'HomeController@track');
//
//Route::get('about-us', 'HomeController@aboutus');
//Route::get('contact-us', 'ContactusController@index');
//Route::get('terms', 'HomeController@terms');
//Route::get('share/{id}', 'HomeController@share');
//
//
Route::post('contact-send', 'ContactusController@store');

Route::post('add-to-newsletter', 'ContactusController@newsletter');

Route::get('404', function()
{
    return view('errors.404', ['page_title' => 'Page not found!']);
});
Route::get('403', function()
{
    return view('errors.403', ['page_title' => 'Page not found!']);
});
Route::get('500', function()
{
    return view('errors.403', ['page_title' => 'Page not found!']);
});
Route::get('vendor/forgot', function()
{
    return view('auth.password');
});
//add-to-newsletter
//Route::get('page/{code}', 'PageController@view');

include("routes_vendor.php");
include("routes_admin.php");

Auth::routes();
//Cron Settings
Route::get('import/images', 'HomeController@importImages');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{page}', 'HomeController@show');
