<?php

use Illuminate\Support\Facades\Route;

// ==========ADMIN LOGIN==========
Route::post('login-admin', 'Auth\AdminLoginController@login');
Route::get('login-check', 'Auth\AdminLoginController@loginCheck')->name('admin.loginCheck');



Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    /* -----TABLE SORTING FOR GLOBALLY------*/
    Route::get('table-sorting', 'Base\SortingController@sorting');
    Route::get('get-last-sorting', 'Base\SortingController@lastSorting');
});

Route::group(['namespace' => 'Backend', 'middleware' => 'auth:admin'], function () {
    Route::view('ckfinder-custom', 'ckfinder');
    /*-----SYSTEM PORTION-----*/
    Route::get('systems-update', 'System\RoleController@systemsRoleUpdate');
    Route::get('get-menus/{any?}', 'System\MenuController@menus');
    Route::get('initialize-systems', 'System\LibController@systems');
    Route::get('get-permissions', 'System\RoleController@getPermissions');
    /*-----ADMIN PORTION-----*/
    Route::post('check-old-password', 'AdminController@checkOldPassword');
    Route::post('change-password', 'AdminController@passwordChange');
    Route::get('get-dashboard-menus', 'System\MenuController@dashboardMenu');

    /*-----DASHBOARD PATH-----*/
    Route::view('dashboard', 'layouts.backend_app')->name('admin.dashboard');
    Route::view('sitemap', 'layouts.backend_app');
    // Topsale Report
    Route::get('/report/top-sale', 'ReportController@topsale')->name('topsale');
    // Date Wise Sale Report


    /* -----Frontend Parent Menu && Content------*/
    Route::get('parent-menus', 'Website\FrontMenuController@getParentMenu');
    Route::get('get-content', 'PageController@getPagesForMenu');
    Route::get('get-album/{type}', 'Website\Gallery\AlbumController@album');

    // List for another page
    Route::get('categories', 'CategoryController@categoryList');
    Route::get('get-sub-categories/{id}', 'CategoryController@subCategoryList');
    Route::get('get-child-categories/{id}', 'CategoryController@childCategoryList');
    Route::get('brands', 'BrandController@brandList');
    Route::get('vendors', 'DatalistController@vendorList');
    Route::get('attributes', 'DatalistController@attributes');
    Route::get('attribute-value/{id}', 'DatalistController@attributeValues');
    //    Route::get('units',        'BrandController@unitList');
    Route::get('product-list', 'DatalistController@productList');
    Route::get('sale-products', 'DatalistController@saleProducts');
    Route::get('countries', 'DatalistController@countries');
    Route::get('states', 'DatalistController@states');
    Route::get('cities', 'DatalistController@cities');
    Route::get('customers', 'DatalistController@customers');
    Route::get('store-country', 'DatalistController@storeCountry');
    // Shipping info
    Route::post('shipping/store', 'ShippingController@storeShippingInfo');
    Route::get('shipping-info/list', 'ShippingController@getShippingInfo');
    Route::get('shipping-info/customer/{id}', 'ShippingController@getCustomerShippingInfo');
    Route::post('shipping-info/destroy', 'ShippingController@destroyShippingInfo');
    Route::get('sale-product', 'SaleController@saleProduct')->name('sale.product');
    Route::get('get-sales-invoice/{id}', 'SaleController@getInvoice');

    // Admin order statistics
    Route::get('admin-order-statistics', 'AdminController@AdminOrderStatistics');
    // Admin Order Report
    Route::get('admin-order-report', 'AdminController@AdminOrderReport');
    // Admin POS Order Report
    Route::get('admin-pos-order-report', 'AdminController@AdminPosOrderReport');
    // Admin Routes
    Route::get('admin-topsale', 'ReportController@topsale');
    // Date Wise Sale Report
    Route::get('date-wise-sale', 'ReportController@datewisessales');
    //Due Customers
    Route::get('unpaid-customers', 'ReportController@unpaidCustomers');
    //Registered And POS Customers
    Route::get('customer-typewise-sale', 'ReportController@customertypewisesale');
    // Admin Pie Chart data for Current Month
    Route::get('admin-month-chart', 'AdminController@AdminMonthChart');


    /*-----PERMITTED USER CAN ACCESS THIS PAGE-----*/
    Route::group(['middleware' => ['auth.access']], function () {
        /*-----MODULE PORTION-----*/
        Route::match(['get', 'post'], 'module/create', 'System\ModuleController@create')
            ->name('module.create');
        /*-----BACK-END-----*/
        Route::resource('role', 'System\RoleController');
        Route::resource('menu', 'System\MenuController');
        Route::resource('admin', 'AdminController');
        Route::resource('siteSetting', 'System\SiteSettingController');

        /*-----FRONT-END-----*/
        Route::resource('frontMenu', 'Website\FrontMenuController');
        Route::resource('slider', 'Website\Gallery\SliderController');
        /*-----CONTENT PORTION-----*/

        Route::get('content/{content}', 'Website\ContentController@show')->name('content.show');
        Route::get('content/{slug}/create', 'Website\ContentController@create')->name('content.create');
        Route::get('content-file/{slug}', 'Website\ContentController@create')->name('content.file');
        Route::post('content', 'Website\ContentController@store')->name('content.store');
        Route::post('content-file/{content}', 'Website\ContentController@storeFile')->name('content.storeFile');
        Route::delete('content/{contentFile}', 'Website\ContentController@destroy')->name('content.destroy');

        /*-----USER PORTION-----*/
        Route::resource('user', 'UserController');
        /*-----PAYMENTS PORTION-----*/
        Route::resource('accountHead', 'MasterSetup\AccountHeadController');
        Route::resource('invoice', 'InvoiceController');
        Route::resource('page', 'PageController');
        // Settings
        Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
            // General settings
            Route::get('general', 'Website\SettingController@general')->name('general');
            Route::get('general-settings', 'Website\SettingController@getGeneralSettings')->name('getGeneralSettings');
            Route::post('general/website-settings', 'Website\SettingController@generalSetting')->name('generalSetting');
            Route::post('general/logo-icon', 'Website\SettingController@logoIconSetting')->name('logoIconSetting');
            Route::post('general/social-media', 'Website\SettingController@socialMedia')->name('socialMedia');
            Route::post('general/working-day', 'Website\SettingController@workingDay')->name('workingDay');

            Route::get('homepage', 'Website\SettingController@homepage')->name('homepage');
            Route::post('homepage/theme-layout', 'Website\SettingController@storeThemeLayout')->name('storeThemeLayout');
            Route::post('homepage/store', 'Website\SettingController@storeHomepage')->name('storeHomepage');
            Route::post('homepage/offer-banner', 'Website\SettingController@storeOfferBanner')->name('storeOfferBanner');
            Route::post('homepage/popup-banner', 'Website\SettingController@storePopupBanner')->name('storePopupBanner');
            Route::post('homepage/popular-category', 'Website\SettingController@storePopularCategory')->name('storePopularCategory');
            Route::post('homepage/two-column-banner', 'Website\SettingController@storeTwoColumnBanner')->name('storeTwoColumnBanner');
            Route::post('homepage/section-product', 'Website\SettingController@storeSectionWiseProduct')->name('storeSectionWiseProduct');

            Route::get('social-login', 'Website\SettingController@socialLogin')->name('socialLogin');
            Route::post('social/google', 'Website\SettingController@social_google')->name('social_google');
            Route::post('social/facebook', 'Website\SettingController@social_facebook')->name('social_facebook');
            Route::post('social/twitter', 'Website\SettingController@social_twitter')->name('social_twitter');

            Route::get('payment-methods', 'Website\SettingController@payment_methods')->name('payment_methods');
            Route::post('payment/cash-on-delivery', 'Website\SettingController@payment_cashOnDelivery')->name('payment_cashOnDelivery');
            Route::post('payment/paypal', 'Website\SettingController@payment_paypal')->name('payment_paypal');
            Route::post('payment/sslcommerz', 'Website\SettingController@payment_sslcommerz')->name('payment_sslcommerz');
            Route::post('payment/stripe', 'Website\SettingController@payment_stripe')->name('payment_stripe');
            Route::post('payment/razorpay', 'Website\SettingController@payment_razorpay')->name('payment_razorpay');

            Route::get('footer', 'Website\SettingController@footer')->name('footer');
            Route::post('footer/store', 'Website\SettingController@storeFooterSettings')->name('storeFooterSettings');
            Route::get('email/setting', 'Website\SettingController@emailSettings')->name('emailSettings');
            Route::post('email/setting/store', 'Website\SettingController@emailSettingsStore')->name('emailSettingsStore');
        });

        Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
            Route::get('topsale', 'ReportController@topsale')->name('topsale');
            Route::get('datewisesale', 'ReportController@datewisesale')->name('datewisesale');
            Route::get('unpaidcustomers', 'ReportController@unpaidcustomers')->name('unpaidcustomers');
            Route::get('customertypewisesale', 'ReportController@customertypewisesale')->name('customertypewisesale');
        });

        // Ecommerce route here
        Route::get('product/stockout', 'ProductController@stockout')->name('product.stockout');
        Route::get('product/bulkexport', 'ProductController@bulkexport')->name('product.bulkexport');
        Route::resource('product', 'ProductController');
        Route::resource('campaignOffer', 'CampaignOfferController');
        Route::resource('order', 'OrderController');
        Route::resource('category', 'CategoryController');
        Route::resource('brand', 'BrandController');
        Route::resource('vendor', 'VendorController');
        Route::resource('sale', 'SaleController');
        //Ecommerce setup
        Route::resource('attribute',   'AttributeController');
        Route::resource('service', 'ServiceController');
        Route::resource('coupon', 'CouponController');
        Route::resource('shipping', 'ShippingController');
        Route::resource('state', 'StateController');
        Route::resource('tax', 'TaxController');
        Route::resource('currency', 'CurrencyController');
        Route::resource('faq', 'FaqController');
        Route::resource('subscriber', 'SubscriberController');
        // PARENT MENU FOR PERMISSION (only for 2nd level parent menu)
        Route::get('cparent', 'PMenuController@content')->name('content.content');
        Route::get('gparent', 'PMenuController@galleryImages')->name('gallery.galleryImages');
    });
});
