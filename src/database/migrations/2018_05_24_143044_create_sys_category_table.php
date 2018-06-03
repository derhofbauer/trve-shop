<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('sys_product_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('media')->nullable();
            $table->timestamps();
        });
        Schema::create('sys_product_category_mm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('category_id');

            $table->foreign('product_id')->references('id')->on('sys_product');
            $table->foreign('category_id')->references('id')->on('sys_product_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('sys_category');
        Schema::dropIfExists('sys_product_cartegory_mm');
    }
}
