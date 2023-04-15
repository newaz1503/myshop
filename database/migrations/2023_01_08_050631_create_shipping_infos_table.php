<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('shipping_type')->default('Home Address');
            $table->enum('address_type',['shipping','billing'])->default('shipping');
            $table->tinyInteger('default_shipping')->default(0);
            $table->tinyInteger('default_billing')->default(0);
            $table->integer('country_id');
            $table->integer('state_id')->nullable();
            $table->integer('city_id');
            $table->string('address');
            $table->integer('postal_code')->nullable();
            $table->string('mobile');
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
        Schema::dropIfExists('shipping_infos');
    }
}
