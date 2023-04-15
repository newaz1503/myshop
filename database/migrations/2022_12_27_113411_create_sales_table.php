<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id',50);
            $table->integer('barcode');
            $table->integer('customer_id');
            $table->integer('shipping_id');
            $table->double('sub_total',2);
            $table->integer('total_quantity');
            $table->integer('product_discount');
            $table->integer('invoice_discount');
            $table->integer('vat');
            $table->integer('tax');
            $table->integer('shipping_cost');
            $table->double('grand_total');
            $table->double('total_recieve');
            $table->double('change');
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
        Schema::dropIfExists('sales');
    }
}
