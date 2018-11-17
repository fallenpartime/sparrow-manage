<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique()->comment('用户ID');
            $table->integer('role_id')->default(0)->comment('角色ID');
            $table->ipAddress('ip')->nullable()->comment('登录IP');
            $table->tinyInteger('is_admin')->default(0)->comment('是否允许登录 0-否 1-是');
            $table->tinyInteger('is_owner')->default(0)->comment('是否显示为执行人 0-否 1-是');
            $table->tinyInteger('is_super')->default(0)->comment('是否超级管理员 0-否 1-是');
            $table->timestamps();
            $table->index('role_id');
            $table->index('is_admin');
            $table->index('is_owner');
            $table->index('is_super');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_infos');
    }
}
