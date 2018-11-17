<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->nullable(false)->unique()->comment('用户名');
            $table->string('phone', 20)->nullable(false)->unique()->comment('用户密码');
            $table->string('pwd', 50)->nullable()->comment('密码');
            $table->string('salt', 50)->nullable()->comment('加点盐');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
