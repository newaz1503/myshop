<?php

namespace App\Http\Controllers\Backend\Website;

use App\Http\Controllers\Base\BaseController;
use App\Models\Currency;
use App\Models\GlobalSetting;
use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    // General settings
    public function general(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
    }

    // Website settings
    public function generalSetting(Request $request)
    {

        $settings = GlobalSetting::first();
        $data = $request->all();

        if (!empty($settings)){
            $settings->update($data);
        }else{
            GlobalSetting::create($data);
        }
        return response()->json(['message' => 'Website Setting Save Successfully!']);
    }

    public function getGeneralSettings()
    {
        $settings  = GlobalSetting::first();
        if (!empty($settings['social_links'])){
            $settings['social_links'] =  json_decode($settings['social_links'],true);
        }else{
            $settings['social_links'] =  [['url'=>'https://www.facebook.com/', 'icon'=> 'fa fa-facebook']];
        }
        return response()->json($settings);
    }

    public function logoIconSetting(Request $request)
    {
        $setting  = GlobalSetting::first();
        $logo = $request->file('logo');
        $favicon = $request->file('favicon');
        $loader = $request->file('loader');

        if (!empty($logo)) {
            if ($setting->logo) {
                $this->deleteFile($setting->logo);
            }
            $data['logo'] = $this->upload($logo, 'global_settings');
        }
        if (!empty($favicon)) {
            if ($setting->favicon) {
                $this->deleteFile($setting->favicon);
            }
            $data['favicon'] = $this->upload($favicon, 'global_settings');
        }
        if (!empty($loader)) {
            if ($setting->$loader) {
                $this->deleteFile($loader->loader);
            }
            $data['loader'] = $this->upload($loader, 'global_settings');
        }
        if (!empty($loader)) {
            if ($setting->$loader) {
                $this->deleteFile($loader->loader);
            }
            $data['loader'] = $this->upload($loader, 'global_settings');
        }
        if (!empty($setting)){
            $setting->update($data);
        }else{
            GlobalSetting::create($data);
        }
        return response()->json(['message' => 'Logo & Icon Save Successfully!']);
    }

    public function storeThemeLayout(Request $request)
    {
        $setting  = StoreSetting::first();
        $data['theme_layout'] = $request->theme_layout;
        if (!empty($setting)){
            $setting->update($data);
        }else{
            StoreSetting::create($data);
        }
        return response()->json(['message' => 'Theme Layout Save Successfully!']);
    }

    public function socialMedia(Request $request)
    {
        $settings = GlobalSetting::first();
        $data['social_links'] = json_encode($request->all());
        if (!empty($settings)){
            $settings->update($data);
        }else{
            GlobalSetting::create($data);
        }
        return response()->json(['message' => 'Social Media Save Successfully!']);
    }

    public function workingDay(Request $request)
    {
        $settings = GlobalSetting::first();
        $data = $request->all();
        if (!empty($settings)){
            $settings->update($data);
        }else{
            GlobalSetting::create($data);
        }
        return response()->json(['message' => 'Working Day Save Successfully!']);
    }

    // Homepage settings
    public function homepage(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        $settings = StoreSetting::first();
        if (!empty($settings)){
            if (!empty($settings['section_one_products'])){
                $settings['section_one_products'] = Product::select('id', 'name', 'featured_image','sale_price')
                    ->whereIn('id', $this->getProductId($settings['section_one_products']))->get();
            }else{
                $settings['section_one_products'] = [];
            }
            if (!empty($settings['section_two_products'])){
                $settings['section_two_products'] = Product::select('id', 'name', 'featured_image','sale_price')
                    ->whereIn('id',$this->getProductId($settings['section_two_products']))->get();
            }else{
                $settings['section_two_products'] = [];
            }
            if (!empty($settings['section_three_products'])){
                $settings['section_three_products'] = Product::select('id', 'name', 'featured_image','sale_price')
                    ->whereIn('id',$this->getProductId($settings['section_three_products']))->get();
            }else{
                $settings['section_three_products'] = [];
            }
        }else{
            $settings = [];
        }
        return response()->json($settings);
    }

    protected function getProductId($products)
    {
        return json_decode($products,true);
    }

    // Create or Update Home page settings
    public function storeHomepage(Request $request)
    {
        $data = $request->only(
            'theader_bg_color',
            'theader_font_color',
            'theader_help_line_number',
            'theader_show_help_line',
            'theader_show_language',
            'theader_show_track_order'
        );
        $data['theader_show_language'] = $request->theader_show_language;
        $data['theader_show_help_line'] = $request->theader_show_help_line;
        $data['theader_show_help_line'] = $request->theader_show_help_line;
        $data['theader_show_track_order'] = $request->theader_show_track_order;

        $setting = StoreSetting::first();
        if ($setting) {
            $setting->update($data);
        } else {
            StoreSetting::create($data);
        }

        return response()->json(['message' => 'Top Header Setting Save Successfully!']);
    }

    public function storeOfferBanner(Request $request)
    {
        $setting = StoreSetting::first();
        $data = $request->only('first_banner', 'second_banner');
        $firstBanner = $request->file('first_banner');
        $secondBanner = $request->file('second_banner');
        $lastBanner = $request->file('last_banner');
        $topHeaderBanner = $request->file('top_header_banner');
        if (!empty($firstBanner)) {
            if ($setting->first_banner) {
                $this->deleteFile($setting->first_banner);
            }
            $data['first_banner'] = $this->upload($firstBanner, 'store/offer_banner');
        }
        if (!empty($secondBanner)) {
            if ($setting->second_banner) {
                $this->deleteFile($setting->second_banner);
            }
            $data['second_banner'] = $this->upload($secondBanner, 'store/offer_banner');
        }
        if (!empty($lastBanner)) {
            if ($setting->last_banner) {
                $this->deleteFile($setting->last_banner);
            }
            $data['last_banner'] = $this->upload($lastBanner, 'store/offer_banner');
        }
        if (!empty($topHeaderBanner)) {
            if ($setting->top_header_banner) {
                $this->deleteFile($setting->top_header_banner);
            }
            $data['top_header_banner'] = $this->upload($topHeaderBanner, 'store/offer_banner');
        }
        if ($setting) {
            $setting->update($data);
        } else {
            StoreSetting::create($data);
        }

        return response()->json(['message' => 'Offer Banner Save Successfully!']);
    }
    public function storePopupBanner(Request $request)
    {
        $setting = StoreSetting::first();
        $data = $request->only('is_show_popup', 'popup_banner','gif_banner','popup_page_url');
        $popupBanner = $request->file('popup_banner');
        $gifBanner = $request->file('gif_banner');
        if (!empty($popupBanner)) {
            if ($setting->popup_banner) {
                $this->deleteFile($setting->popup_banner);
            }
            $data['popup_banner'] = $this->upload($popupBanner, 'store/offer_banner');
        }
        if (!empty($gifBanner)) {
            if ($setting->gif_banner) {
                $this->deleteFile($setting->gif_banner);
            }
            $data['gif_banner'] = $this->upload($gifBanner, 'store/offer_banner');
        }
        if ($setting) {
            $setting->update($data);
        } else {
            StoreSetting::create($data);
        }

        return response()->json(['message' => 'Popup Banner Save Successfully!']);
    }

    public function storePopularCategory(Request $request)
    {
        $data = $request->only(
            'popular_section_title',
            'popular_category_one',
            'popular_category_two',
            'popular_category_three'
        );
        $setting = StoreSetting::first();
        if ($setting) {
            $setting->update($data);
        } else {
            StoreSetting::create($data);
        }
        return response()->json(['message' => 'Top Header Setting Save Successfully!']);
    }

    public function storeTwoColumnBanner(Request $request)
    {
        $setting = StoreSetting::first();
        $data = $request->only('two_column_first_banner', 'two_column_second_banner');
        $firstBanner = $request->file('two_column_first_banner');
        $secondBanner = $request->file('two_column_second_banner');
        if (!empty($firstBanner)) {
            if ($setting->two_column_first_banner) {
                $this->deleteFile($setting->two_column_first_banner);
            }
            $data['two_column_first_banner'] = $this->upload($firstBanner, 'store/two_column_banner');
        }
        if (!empty($secondBanner)) {
            if ($setting->two_column_second_banner) {
                $this->deleteFile($setting->two_column_second_banner);
            }
            $data['two_column_second_banner'] = $this->upload($secondBanner, 'store/two_column_banner');
        }
        if ($setting) {
            $setting->update($data);
        } else {
            StoreSetting::create($data);
        }
        return response()->json(['message' => 'Offer Banner Save Successfully!']);
    }

    public function storeSectionWiseProduct(Request $request)
    {
        $setting = StoreSetting::first();
        $data = [
            'section_one_title'     => $request->section_one_title,
            'section_two_title'     => $request->section_two_title,
            'section_three_title'   => $request->section_three_title,
        ];
        foreach ($request->section_one_products as $section_one_product) {
            $data['section_one_products'][] = $section_one_product['id'];
        }
        foreach ($request->section_two_products as $section_two_products) {
            $data['section_two_products'][] = $section_two_products['id'];
        }
        foreach ($request->section_three_products as $section_three_products) {
            $data['section_three_products'][] = $section_three_products['id'];
        }
        if (!empty($data['section_one_products'])){
            $data['section_one_products'] = json_encode($data['section_one_products']);
        }else{
            $data['section_one_products'] = [];
        }
        if (!empty( $data['section_two_products'])){
            $data['section_two_products'] = json_encode($data['section_two_products']);
        }else{
            $data['section_two_products'] = [];
        }
        if (!empty($data['section_three_products'])){
            $data['section_three_products'] = json_encode($data['section_three_products']);
        }else{
            $data['section_three_products'] = [];
        }
        if ($setting) {
            $setting->update($data);
        } else {
            StoreSetting::create($data);
        }
        return response()->json(['message' => 'Section Product Save Successfully!']);
    }



    // Footer settings
    public function footer(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        $setting = GlobalSetting::select('white_logo', 'site_description', 'footer_section_one_title', 'footer_section_one_links',
        'footer_section_two_title', 'footer_section_two_links', 'store_phone', 'store_email', 'store_address', 'show_newsletter','social_links',
         'friday_start', 'friday_end', 'satureday_start', 'satureday_end', 'getway_image')->first();
         return response()->json($setting);
    }

    public function storeFooterSettings(Request $request)
    {
        $data = $request->except('footer_section_one_links','footer_section_two_links');
        $setting = GlobalSetting::first();
        if (!empty($request->footer_section_one_links)){
            $data['footer_section_one_links'] = json_encode($request->footer_section_one_links);
        }else{
            $data['footer_section_one_links'] = null;
        }
        if (!empty($request->footer_section_two_links)){
            $data['footer_section_two_links'] = json_encode($request->footer_section_two_links);
        }else{
            $data['footer_section_two_links'] = null;
        }
        $white_logo     = $request->file('white_logo');

        $getway_image   = $request->file('getway_image');

        if (!empty($white_logo)) {
            if (!empty($setting->white_logo)) {
                $this->deleteFile($setting->white_logo);
            }
            $data['white_logo'] = $this->upload($white_logo, 'global_settings');
        }else{
            $data['white_logo'] = $this->oldFile($setting->white_logo);
        }
        if (!empty($getway_image)) {
            if (!empty($setting->getway_image)) {
                $this->deleteFile($setting->getway_image);
            }

            $data['getway_image'] = $this->upload($getway_image, 'global_settings');
        }else{
            $data['getway_image'] = $this->oldFile($setting->getway_image);;
        }
        if (!empty($setting)){
            $setting->update($data);
        }else{
            GlobalSetting::create($data);
        }
        return response()->json(['message' => 'Save Successfully!']);
    }

    public function payment_methods(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        if ($request->format() == 'json') {
            $methods = GlobalSetting::select('id','cash_on_delivery','paypal_payment','paypal_sandbox','PAYPAL_CLIENT_ID',
                'PAYPAL_CLIENT_SECRET','sslcommerz_payment','sslcommerz_sandbox','SSLCZ_STORE_ID','SSLCZ_STORE_PASSWD',
                'stripe_payment','STRIPE_KEY','STRIPE_SECRET','razorpay_payment','RAZOR_KEY','RAZOR_SECRET')->first();
            return response()->json($methods);
        }

    }

    public function payment_cashOnDelivery(Request $request)
    {
       $valid = $request->validate([
            'cash_on_delivery' => 'required'
        ],['cash_on_delivery.required' => 'Activation is required!']);
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['cash_on_delivery'] = isset($request->cash_on_delivery) ? 1 : 0;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function payment_paypal(Request $request)
    {
        $valid = $request->validate([
            'paypal_payment' => 'required',
            'PAYPAL_CLIENT_ID' => 'required',
            'PAYPAL_CLIENT_SECRET' => 'required',
        ],
            ['paypal_payment.required' => 'Activation is required!'],
            ['PAYPAL_CLIENT_ID.required' => 'Paypal Client Id is required!'],
            ['PAYPAL_CLIENT_SECRET.required' => 'Paypal Client Secret is required!']
        );
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['paypal_payment'] = isset($request->paypal_payment) ? 1 : 0;
                $data['paypal_sandbox'] = isset($request->paypal_sandbox) ? 1 : 0;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                $this->pushIntoEnv('PAYPAL_MODE', $request->paypal_payment ? 'sandbox':'live');
                $this->pushIntoEnv('PAYPAL_SANDBOX_CLIENT_ID',$request->PAYPAL_CLIENT_ID);
                $this->pushIntoEnv('PAYPAL_SANDBOX_CLIENT_SECRET',$request->PAYPAL_CLIENT_SECRET);
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function payment_sslcommerz(Request $request)
    {
        $valid = $request->validate([
            'sslcommerz_payment' => 'required',
            'SSLCZ_STORE_ID' => 'required',
            'SSLCZ_STORE_PASSWD' => 'required',
        ],
            ['sslcommerz_payment.required' => 'Activation is required!'],
            ['SSLCZ_STORE_ID.required' => 'SSLCZ Store Id is required!'],
            ['SSLCZ_STORE_PASSWD.required' => 'SSLCZ Store Password is required!']
        );
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['sslcommerz_payment'] = isset($request->sslcommerz_payment) ? 1 : 0;
                $data['sslcommerz_sandbox'] = isset($request->sslcommerz_sandbox) ? 1 : 0;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                $this->pushIntoEnv('SSLCZ_STORE_ID',$request->SSLCZ_STORE_ID);
                $this->pushIntoEnv('SSLCZ_STORE_PASSWD',$request->SSLCZ_STORE_PASSWD);
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function payment_stripe(Request $request)
    {
        $valid = $request->validate([
            'stripe_payment' => 'required',
            'STRIPE_KEY' => 'required',
            'STRIPE_SECRET' => 'required',
        ],
            ['stripe_payment.required' => 'Activation is required!'],
            ['STRIPE_KEY.required' => 'Stripe Key  required!'],
            ['STRIPE_SECRET.required' => 'Stripe Secret is required!']
        );
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['stripe_payment'] = isset($request->stripe_payment) ? 1 : 0;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                $this->pushIntoEnv('STRIPE_KEY',$request->STRIPE_KEY);
                $this->pushIntoEnv('STRIPE_SECRET',$request->STRIPE_SECRET);
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }
    public function payment_razorpay(Request $request)
    {
        $valid = $request->validate([
            'razorpay_payment' => 'required',
            'RAZOR_KEY' => 'required',
            'RAZOR_SECRET' => 'required',
        ],
            ['razorpay_payment.required' => 'Activation is required!'],
            ['RAZOR_KEY.required' => 'Razorpay Key  is required!'],
            ['RAZOR_SECRET.required' => 'Razorpay Secret is required!']
        );
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['razorpay_payment'] = isset($request->razorpay_payment) ? 1 : 0;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                $this->pushIntoEnv('RAZOR_KEY',$request->RAZOR_KEY);
                $this->pushIntoEnv('RAZOR_SECRET',$request->RAZOR_SECRET);
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }


    public function socialLogin(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        if ($request->format() == 'json') {
            $socialLogin = GlobalSetting::select('id','google_login','GOOGLE_CLIENT_ID','GOOGLE_CLIENT_SECRET','facebook_login',
                'FACEBOOK_CLIENT_ID','FACEBOOK_CLIENT_SECRET','twitter_login','TWITTER_CLIENT_ID','TWITTER_CLIENT_SECRET')->first();
            return response()->json($socialLogin);
        }
    }
    // Social Login
    public function social_google(Request $request)
    {
        $valid = $request->validate([
            'GOOGLE_CLIENT_ID' => 'required',
            'GOOGLE_CLIENT_SECRET' => 'required',
        ],
            ['GOOGLE_CLIENT_ID.required' => 'Google Client Id is required!'],
            ['GOOGLE_CLIENT_SECRET.required' => 'Google Client Secret is required!']
        );
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['google_login'] = isset($request->google_login) ? 1 : 0;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                $this->pushIntoEnv('GOOGLE_CLIENT_ID',$request->GOOGLE_CLIENT_ID);
                $this->pushIntoEnv('GOOGLE_CLIENT_SECRET',$request->GOOGLE_CLIENT_SECRET);
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function social_facebook(Request $request)
    {
        $valid = $request->validate([
            'FACEBOOK_CLIENT_ID' => 'required',
            'FACEBOOK_CLIENT_SECRET' => 'required',
        ],
            ['FACEBOOK_CLIENT_ID.required' => 'Facebook Client Id is required!'],
            ['FACEBOOK_CLIENT_SECRET.required' => 'Facebook Client Secret is required!']
        );
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['facebook_login'] = isset($request->facebook_login) ? 1 : 0;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                $this->pushIntoEnv('FACEBOOK_CLIENT_ID',$request->FACEBOOK_CLIENT_ID);
                $this->pushIntoEnv('FACEBOOK_CLIENT_SECRET',$request->FACEBOOK_CLIENT_SECRET);
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function social_twitter(Request $request)
    {
        $valid = $request->validate([
            'TWITTER_CLIENT_ID' => 'required',
            'TWITTER_CLIENT_SECRET' => 'required',
        ],
            ['TWITTER_CLIENT_ID.required' => 'Twitter Client Id is required!'],
            ['TWITTER_CLIENT_SECRET.required' => 'Twitter Client Secret is required!']
        );
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['twitter_login'] = isset($request->twitter_login) ? 1 : 0;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                $this->pushIntoEnv('TWITTER_CLIENT_ID',$request->TWITTER_CLIENT_ID);
                $this->pushIntoEnv('TWITTER_CLIENT_SECRET',$request->TWITTER_CLIENT_SECRET);
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function emailSettingsStore(Request $request)
    {
        $valid = $request->validate([
            'smtp_engine' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ]);
        if ($valid) {
            try {
                $setting =  GlobalSetting::first();
                $data = $request->all();
                $data['smtp_engine'] = $request->smtp_engine;
                $data['mail_host'] = $request->mail_host;
                $data['mail_port'] = $request->mail_port;
                $data['mail_username'] = $request->mail_username;
                $data['mail_password'] = $request->mail_password;
                $data['mail_encryption'] = $request->mail_encryption;
                $data['mail_from_address'] = $request->mail_from_address;
                $data['mail_from_name'] = $request->mail_from_name;
                if ($setting){
                    $setting->update($data);
                }else{
                    GlobalSetting::create($data);
                }
                $this->pushIntoEnv('MAIL_MAILER',$request->smtp_engine);
                $this->pushIntoEnv('MAIL_HOST',$request->mail_host);
                $this->pushIntoEnv('MAIL_PORT',$request->mail_port);
                $this->pushIntoEnv('MAIL_USERNAME',"{$request->mail_username}");
                $this->pushIntoEnv('MAIL_PASSWORD',"{$request->mail_password}");
                $this->pushIntoEnv('MAIL_ENCRYPTION',$request->mail_encryption);
                $this->pushIntoEnv('MAIL_FROM_ADDRESS',"{$request->mail_from_address}");
                $this->pushIntoEnv('MAIL_FROM_NAME',"{$request->mail_from_name}");
                return response()->json(['message'=>'Update Successfully']);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    public function emailSettings()
    {
        $settings = GlobalSetting::select('smtp_engine','mail_host',
            'smtp_password','smtp_server','smtp_port','smtp_security','smtp_auth')->first();
        return response()->json($settings);

    }
}
