<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('cart_id')->unsigned();
            $table->string('delivery_address', 255);
            $table->string('phone_number', 16);
            $table->integer('city_id')->unsigned();
            $table->string('postal_code', 32);
            $table->integer('payment_method')->unsigned();
            $table->date('payment_date');
            $table->date('payment_approved_date');
            $table->date('completed_date');
            $table->foreign('payment_method')->references('id')->on('payment_methods');
            $table->foreign('city_id')->references('id')->on('cities');
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
