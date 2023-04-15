<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            // Top Header
            $table->string('theme_layout')->default('layout_one')->nullable();
            $table->tinyInteger('theader_show_language')->default(1)->nullable();
            $table->tinyInteger('theader_show_track_order')->default(1)->nullable();
            $table->tinyInteger('theader_show_help_line')->default(1)->nullable();
            $table->string('theader_help_line_number')->nullable();
            $table->string('theader_bg_color')->nullable();
            $table->string('theader_font_color')->nullable();
            // Offer banner
            $table->string('first_banner')->nullable();
            $table->string('second_banner')->nullable();
            $table->string('last_banner')->nullable();
            $table->string('top_header_banner')->nullable();
            // Popup banner image and fields
            $table->tinyInteger('is_show_popup')->nullable();
            $table->string('popup_banner')->nullable();
            $table->string('gif_banner')->nullable();
            $table->string('popup_page_url')->nullable();
            // Popular Category
            $table->string('popular_section_title')->nullable();
            $table->integer('popular_category_one')->nullable();
            $table->integer('popular_category_two')->nullable();
            $table->integer('popular_category_three')->nullable();
            // Two Column Banner
            $table->string('two_column_first_banner')->nullable();
            $table->string('two_column_second_banner')->nullable();
            // Section Wise Product
            $table->string('section_one_title')->nullable();
            $table->text('section_one_products')->nullable();

            $table->string('section_two_title')->nullable();
            $table->text('section_two_products')->nullable();

            $table->string('section_three_title')->nullable();
            $table->text('section_three_products')->nullable();
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
        Schema::dropIfExists('store_settings');
    }
}
