<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_rating', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feuser_id');
            $table->integer('product_id');
            $table->integer('rating');
            $table->timestamps();

            $table->foreign('feuser_id')->references('id')->on('sys_feusers');
            $table->foreign('product_id')->references('id')->on('sys_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_rating');
    }
}
