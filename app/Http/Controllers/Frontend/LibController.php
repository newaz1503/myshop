<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\GlobalSetting;
use App\Models\State;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class LibController extends Controller
{
    public function index()
    {
        $settings = StoreSetting::select(
            'id','theme_layout','first_banner', 'second_banner', 'last_banner', 'top_header_banner', 'theader_bg_color', 'theader_font_color',
            'theader_help_line_number', 'theader_show_help_line', 'theader_show_language',
            'theader_show_track_order', 'two_column_first_banner', 'two_column_second_banner',
            'is_show_popup','popup_banner','gif_banner','popup_page_url'
        )->first();
        $global_setting = GlobalSetting::first();
        $settings['currency_symbol'] = $global_setting->currency;
        $settings['app_name'] = $global_setting->app_name;
        $settings['logo'] = $global_setting->logo;
        $settings['facebook_login'] = $global_setting->facebook_login;
        $settings['google_login'] = $global_setting->google_login;
        $settings['twitter_login'] = $global_setting->twitter_login;
        return response()->json($settings);
    }

    public function footer()
    {
        $footer_data = GlobalSetting::select('white_logo', 'site_description', 'footer_section_one_title', 'footer_section_one_links',
            'footer_section_two_title', 'footer_section_two_links', 'store_phone', 'store_email', 'store_address', 'show_newsletter', 'social_links',
            'friday_start', 'friday_end', 'satureday_start', 'satureday_end', 'getway_image')->first();
        return response()->json($footer_data);
    }


    public function countries()
    {
        $countries = Country::all();
        return response()->json($countries);
    }


    public function states(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        return response()->json($states);
    }

    public function cities(Request $request)
    {
        $query = City::where('country_id', $request->country_id);
        if ($request->state_id) {
            $query->where('state_id', $request->state_id);
        }
        $states = $query->get();
        return response()->json($states);
    }


}
