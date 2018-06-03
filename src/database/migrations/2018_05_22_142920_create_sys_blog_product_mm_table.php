<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysBlogProductMmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_blog_product_mm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_entry_id');
            $table->integer('product_id');
            $table->timestamps();

            $table->foreign('blog_entry_id')->references('id')->on('sys_blog_entry');
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
        Schema::dropIfExists('sys_blog_product_mm');
    }
}
