<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status')->default('0');
            $table->text('invoice')->nullable();
            $table->text('delivery_address')->nullable();
            $table->integer('feuser_id');
            $table->text('payment_method')->nullable();
            $table->timestamps();

            $table->foreign('feuser_id')->references('id')->on('sys_feusers');
        });
        Schema::create('sys_order_product_mm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('product_quantity')->default(1);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('sys_order');
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
        Schema::dropIfExists('sys_order');
        Schema::dropIfExists('sys_order_product_mm');
    }
}
