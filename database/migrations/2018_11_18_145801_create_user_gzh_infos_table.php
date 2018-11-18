<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGzhInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gzh_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unique()->comment('用户ID');
            $table->string('openid', 100)->default('')->comment('openid');
            $table->string('unionid', 100)->default('')->comment('unionid');
            $table->tinyInteger('is_subscribe')->default(0)->comment('关注状态 0-取消关注  1-已关注');
            $table->timestamps();
            $table->index('openid');
            $table->index('unionid');
            $table->index('is_subscribe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_gzh_infos');
    }
}
