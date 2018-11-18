<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unique()->comment('用户ID');
            $table->string('province', 50)->default('')->comment('所属省份');
            $table->string('city', 50)->default('')->comment('城市');
            $table->tinyInteger('gender')->default(0)->comment('1 男 2 女');
            $table->timestamps();
            $table->index('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
}
