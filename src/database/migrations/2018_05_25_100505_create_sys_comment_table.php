<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feuser_id');
            $table->integer('product_id');
            $table->text('content');
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
        Schema::dropIfExists('sys_comment');
    }
}
