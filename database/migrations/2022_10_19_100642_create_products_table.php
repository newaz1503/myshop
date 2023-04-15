<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('brand_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string( 'name');
            $table->string( 'slug');
            $table->string( 'product_code');
            $table->string( 'sku_code');
            $table->string( 'barcode');
            $table->integer( 'rating')->default(0);
            $table->text(   'featured_image');
            $table->double('purchase_price')->default(0.00);
            $table->double('sale_price')->default(0.00);
            $table->integer('quantity')->nullable();
            $table->string( 'vat_type')->default('flat');
            $table->double( 'vat_amount')->default(0.00);
            $table->string( 'tax_type')->default('flat');
            $table->double( 'tax_amount')->default(0.00);
            $table->string( 'unit')->nullable();
            $table->string( 'discount_type')->default('flat');
            $table->double( 'discount_amount')->default(0.00);
            $table->longText('product_gallery')->nullable();
            $table->string( 'short_description')->nullable();
            $table->text(   'description')->nullable();
            $table->longText('specifications')->nullable();
            $table->tinyInteger( 'hot')->default(0);
            $table->tinyInteger( 'top_selling')->default(0);
            $table->tinyInteger( 'trending_product')->default(0);
            $table->string( 'meta_keyword')->nullable();
            $table->string( 'meta_description')->nullable();
            $table->integer('sorting')->default(0);
            $table->enum(   'status', ['active', 'deactive'])->default('active');
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
        Schema::dropIfExists('products');
    }
}
