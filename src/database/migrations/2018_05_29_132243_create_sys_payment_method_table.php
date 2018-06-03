<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysPaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_payment_method', function (Blueprint $table) {
            $table->increments('id');
            $table->json('data');
            $table->integer('feuser_id');
            $table->timestamps();

            $table->foreign('feuser_id')->references('id')->on('sys_feusers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_payment_method');
    }
}
