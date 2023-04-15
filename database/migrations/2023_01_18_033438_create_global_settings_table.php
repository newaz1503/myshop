<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('website_title')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('store_email')->nullable();
            $table->string('store_address')->nullable();
            $table->string('primary_color')->nullable();
            $table->text('site_meta_title')->nullable();
            $table->text('site_meta_description')->nullable();
            $table->text('site_meta_keywords')->nullable();

            $table->string('active_theme')->default('theme_one');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('loader')->nullable();

            $table->text('social_links')->nullable();
            $table->string('friday_start')->nullable();
            $table->string('friday_end')->nullable();
            $table->string('satureday_start')->nullable();
            $table->string('satureday_end')->nullable();

            $table->string('site_description')->nullable();
            $table->string('show_newsletter')->nullable();
            $table->string('footer_section_one_title')->nullable();
            $table->string('footer_section_one_links')->nullable();

            $table->string('footer_section_two_title')->nullable();
            $table->string('footer_section_two_links')->nullable();
            $table->string('white_logo')->nullable();
            $table->string('getway_image')->nullable();

            $table->tinyInteger('cash_on_delivery')->default(0);

            $table->tinyInteger('paypal_payment')->default(0);
            $table->tinyInteger('paypal_sandbox')->default(0);
            $table->string('PAYPAL_CLIENT_ID')->nullable();
            $table->string('PAYPAL_CLIENT_SECRET')->nullable();

            $table->tinyInteger('sslcommerz_payment')->default(0);
            $table->tinyInteger('sslcommerz_sandbox')->default(0);
            $table->string('SSLCZ_STORE_ID')->nullable();
            $table->string('SSLCZ_STORE_PASSWD')->nullable();

            $table->tinyInteger('stripe_payment')->default(0);
            $table->string('STRIPE_KEY')->default(0);
            $table->string('STRIPE_SECRET')->nullable();

            $table->tinyInteger('razorpay_payment')->default(0);
            $table->string('RAZOR_KEY')->default(0);
            $table->string('RAZOR_SECRET')->nullable();

            $table->tinyInteger('google_login')->default(0);
            $table->string('GOOGLE_CLIENT_ID')->nullable();
            $table->string('GOOGLE_CLIENT_SECRET')->nullable();

            $table->tinyInteger('facebook_login')->default(0);
            $table->string('FACEBOOK_CLIENT_ID')->nullable();
            $table->string('FACEBOOK_CLIENT_SECRET')->nullable();

            $table->tinyInteger('twitter_login')->default(0);
            $table->string('TWITTER_CLIENT_ID')->nullable();
            $table->string('TWITTER_CLIENT_SECRET')->nullable();
            // Email setting
            $table->string('smtp_engine')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->nullable();
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_settings');
    }
}
