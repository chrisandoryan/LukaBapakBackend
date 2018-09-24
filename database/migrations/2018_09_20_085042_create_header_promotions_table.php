<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeaderPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_promotions', function (Blueprint $table) {
            $table->increments('id');
            // $table->string('seller_uuid', 40);
            $table->string('promo_name', 128);
            $table->date('valid_until');
            $table->foreign('seller_uuid')->references('uuid')->on('new_users');
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
        Schema::dropIfExists('header_promotions');
    }
}
