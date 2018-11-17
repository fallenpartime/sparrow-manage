<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nick_name', 100)->default('')->comment('用户昵称');
            $table->string('openid', 100)->default('')->comment('openid');
            $table->string('unionid')->default('')->comment('unionid');
            $table->string('phone', 30)->default('')->comment('用户电话');
            $table->string('face')->default('')->comment('用户头像');
            $table->timestamp('last_login_at')->nullable(true)->comment('最后登录时间');
            $table->timestamps();
            $table->softDeletes();
            $table->index('nick_name');
            $table->index('openid');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
