<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('activity_id')->default(0)->comment('活动ID');
            $table->integer('question_id')->default(0)->comment('问题ID');
            $table->tinyInteger('type')->default(0)->comment('类型 0-文字 1-图片');
            $table->string('title',100)->default('')->comment('问题描述');
            $table->string('source')->default('')->comment('资源地址');
            $table->timestamps();
            $table->softDeletes();
            $table->index('activity_id');
            $table->index('question_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_answers');
    }
}
