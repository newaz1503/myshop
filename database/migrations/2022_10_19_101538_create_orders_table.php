<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->integer('customer_id');
            $table->integer('shipping_id');
            $table->integer('billing_id');
            $table->integer('shipping_method_id');
            $table->string('payment_method');
            $table->double('shipping_cost');
            $table->double('sub_total', 2);
            $table->double('grand_total');
            $table->string('tran_id')->nullable();
            $table->integer('coupon_code')->nullable();
            $table->integer('coupon_discount')->nullable();
            $table->integer('total_quantity');
            $table->integer('product_discount')->nullable();
            $table->integer('vat')->nullable();
            $table->integer('tax')->nullable();
            $table->enum('order_status', ['pending', 'placed_order', 'approved', 'cancel', 'delivered', 'hold'])->default('pending');
            $table->enum('payment_status', ['paid', 'unpaid','canceled','failed'])->default('unpaid');
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
        Schema::dropIfExists('orders');
    }
}
