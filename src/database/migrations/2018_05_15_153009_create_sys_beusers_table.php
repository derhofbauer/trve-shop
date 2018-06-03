<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysBeusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            foreach (\App\SysRole::getPermissions() as $permission) {
                $table->boolean($permission);
            }
            $table->timestamps();
        });
        Schema::create('sys_beusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->integer('role_id')->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('sys_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_role');
        Schema::dropIfExists('sys_beusers');
    }
}
