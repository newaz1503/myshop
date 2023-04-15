<?php

use App\Http\Controllers\Backend\OrderController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\ForgotPasswordController;
Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'HomeController@home');
    Route::get('global-data', 'LibController@index');
    Route::get('get-menus', 'HomeController@menus');
    Route::get('get-home-page', 'HomeController@homePage');
    Route::get('countries', 'LibController@countries');
    Route::get('states', 'LibController@states');
    Route::get('cities', 'LibController@cities');
    // Home page data
    Route::get('parent-categories', 'HomeController@categories');
    Route::get('sliders', 'HomeController@sliders');
    Route::get('services', 'HomeController@services');
    Route::get('banner-categories', 'HomeController@bannerCategories');
    Route::get('banner-categories-12', 'HomeController@bannerCategoriesHome3');
    Route::get('banner-categories-8', 'HomeController@bannerCategoriesHome8');
    Route::get('banner-todays-deal', 'HomeController@bannerTodaysDeal');
    Route::get('top-brands', 'HomeController@topBrands');
    Route::get('top-categories', 'HomeController@topCategories');
    Route::get('get-brands', 'HomeController@brands');
    Route::get('get-sectionOne', 'HomeController@sectionOne');
    Route::get('get-sectionTwo', 'HomeController@sectionTwo');
    Route::get('get-sectionThree', 'HomeController@sectionThree');
    Route::get('category-product', 'HomeController@categoryProducts');
    Route::get('get-campaigns', 'HomeController@campaigns');
    Route::get('brand-product/{slug}', 'HomeController@brandProducts');
    Route::get('global-search', 'HomeController@globalSearch');
    Route::get('topselling-products', 'HomeController@TopSellingProducts');
    Route::get('hot-products', 'HomeController@HotProducts');
    // Pages
    Route::get('get-products', 'PageController@allProducts');
    Route::get('product/details/{slug}', 'PageController@productDetails');
    Route::get('allbrands', 'PageController@allbrand');
    Route::get('all-categories', 'PageController@allcategories');
    Route::get('coupons', 'PageController@allCoupons');
    Route::get('faq', 'PageController@allfaq');
    Route::get('about-us', 'PageController@about');
    Route::post('coupon/apply', 'PageController@couponApply');
    Route::post('subscriber-store', 'SubscriberController@subscriber_store');
    Route::get('admin/mail-to-subscribers', 'SubscriberController@subscriber_send');
    // Content page
    Route::view('content-page/{slug}', 'layouts.frontend_app');
    Route::view('contact-us', 'layouts.frontend_app');
    Route::get('get-page-content/{slug}', 'PageController@getPageContent');
    Route::get('get-product-details/{id}', 'HomeController@getProductDetails');
    //View pages
    Route::view('/brands', 'layouts.frontend_app');
    Route::view('/categories', 'layouts.frontend_app');
    Route::view('/campaigns', 'layouts.frontend_app');
    Route::view('/campaign/{id}/details', 'layouts.frontend_app');
    Route::view('/products', 'layouts.frontend_app');
    Route::view('/product/{slug}/details', 'layouts.frontend_app');
    Route::get('/sectionwiseproduct/{slug}', 'PageController@sectionWiseProducts');

    Route::get('global-footer', 'LibController@footer');
    Route::post('contact-store', 'ContactController@contact_store');
});

// USER LOGIN
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('login-check', 'Auth\LoginController@loginCheck');
Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// OAuth Login Facebook, Twitter, Google
//Google
Route::get('/login/google', 'Auth\LoginController@redirectToGoogle')->name('login.google');
Route::get('/login/google/callback', 'Auth\LoginController@handleGoogleCallback');
//Facebook
Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebook')->name('login.facebook');
Route::get('/login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
//Github
Route::get('/login/twitter', 'Auth\LoginController@redirectToTwitter')->name('login.github');
Route::get('/login/twitter/callback', 'Auth\LoginController@handleTwitterCallback');

Route::group(['namespace' => 'Frontend', 'middleware' => 'auth'], function () {
    Route::get('checkout', 'CheckoutController@checkoutView')->name('checkout');
    Route::get('get-shipping-address', 'CheckoutController@getShippingAddress');
    Route::post('shipping/store', 'CheckoutController@storeShippingInfo');
    Route::post('shipping-info/destroy', 'CheckoutController@destroyShippingInfo');
    Route::post('shipping/update/{id}', 'CheckoutController@updateShippingInfo');
    Route::get('get-shipping-method', 'CheckoutController@getShippingMethod');
    Route::get('get-shipping-cost/{id}', 'CheckoutController@getShippingCost');
    Route::get('get-payment-method', 'CheckoutController@getPaymentMethod');
    Route::post('placeorder', [OrderController::class, 'store']);
});


// Payment
/*
 * Paypal Payment routes
 */
Route::get('process-transaction', 'Payment\PayPalController@processTransaction')->name('paypal.processTransaction');
Route::get('success-transaction', 'Payment\PayPalController@successTransaction')->name('successTransaction');
Route::get('cancel-transaction', 'Payment\PayPalController@cancelTransaction')->name('cancelTransaction');
/*
 * Stripe Payment routes
 */
Route::view('/stripe/checkout', 'layouts.frontend_app');
Route::get('/stripe/create-session', 'Payment\StripePaymentController@getStripeSession')->name('stripe.createsession');
Route::get('/stripe/success', 'Payment\StripePaymentController@success')->name('stripe.success');
Route::get('/stripe/cancel', 'Payment\StripePaymentController@cancel')->name('stripe.cancel');
/*
 * SSLCOMMERZ Payment routes
 */
Route::post('/success', 'Payment\SslCommerzPaymentController@success');
Route::post('/fail', 'Payment\SslCommerzPaymentController@fail');
Route::post('/cancel', 'Payment\SslCommerzPaymentController@cancel');
Route::post('/ipn', 'Payment\SslCommerzPaymentController@ipn');

Route::get('/payment-complete/{id}', 'Payment\PaymentController@completePayment')->name('payment_success');
Route::get('/payment-failed/{id}', 'Payment\PaymentController@paymentFailed')->name('payment_failed');
Route::get('/payment-canceled/{id}', 'Payment\PaymentController@paymentCanceled')->name('payment_canceled');



// USER DASHBOARD
Route::group(['namespace' => 'Frontend', 'prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::view('dashboard', 'layouts.frontend_app')->name('user.dashboard');
    Route::view('profile', 'layouts.frontend_app');
    Route::view('order-history', 'layouts.frontend_app');
    Route::view('return-history', 'layouts.frontend_app');
    Route::view('wisthlist', 'layouts.frontend_app');
    Route::view('change-password', 'layouts.frontend_app');
    Route::view('trackorder', 'layouts.frontend_app');
    Route::view('trackreport', 'layouts.frontend_app');

    Route::get('get-profile-info', 'UserController@profileInfo');
    // ===========Wishlist add=====================
    Route::post('/addToWishlist/{id}', 'HomeController@AddToWishlist');
    Route::get('/order-statistics', 'UserController@Orderstatus');
    Route::get('/recent-order', 'UserController@Recentorder');
    Route::get('/canceled-order', 'UserController@Canceledorder');
    Route::get('/allorders', 'UserController@Allorders');
    Route::get('/invoice/{id}', 'UserController@viewInvoice')->name('user.viewInvoice');
    Route::get('/profile-info', 'UserController@Profiledetails');
    Route::get('/wishlist-products', 'UserController@Wishlistdetails');
    Route::post('/removeFromWishlist/{id}', 'UserController@DeleteFromWishlist');
    Route::post('/removeOrder/{id}', 'UserController@DeleteOrder');
    Route::post('/profileUpdate', 'UserController@UpdateProfile');
    Route::post('/trackorder', 'UserController@TrackOrder');
    Route::post('/storereview', 'UserController@AddRatingReview');
    Route::get('/productreviews/{id}', 'UserController@GetProductReview');
    Route::post('/changepassword', 'UserController@ChangePassword');
    Route::post('/shippingInfo/makeDefault', 'UserController@addressMakeDefault');
});
// get all review for the product
Route::get('user/productreviews/{id}', 'Frontend\UserController@GetProductReview');
// get Product Campaign Details
Route::get('get-campaign-details/{id}', 'Frontend\UserController@CampaignDetails');

// ==========ADMIN LOGIN==========
Route::get('/admin/login', 'Auth\AdminLoginController@login')->name('admin.loginme');

// AUTH VERIFY FALSE
Auth::routes(['verify' => false]);

// FOR STORAGE LINKED IN PUBLIC FOLDER
Route::get('/sym', function () {
    File::link(storage_path('app/public'), public_path('storage'));
    return response()->json("Link Create Successfully!");
});

// CACHE CLEAR
Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return response()->json("Cache Cleared Successfully!");
});
