<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_uuid', 40);
            $table->smallInteger('is_completed');
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('new_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_headers');
    }
}
