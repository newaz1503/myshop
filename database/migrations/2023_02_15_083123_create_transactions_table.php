<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('status')->nullable();
            $table->string('amount')->nullable();
            $table->string('card_type')->nullable();
            $table->string('store_amount')->nullable();
            $table->string('card_no')->nullable();
            $table->string('bank_tran_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('tran_date')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
