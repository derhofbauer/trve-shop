<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysBlogEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_blog_entry', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('abstract');
            $table->longText('content');
            $table->integer('beuser_id');
            $table->json('media')->nullable();
            $table->timestamps();

            $table->foreign('beuser_id')->references('id')->on('sys_beusers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_blog_entry');
    }
}
