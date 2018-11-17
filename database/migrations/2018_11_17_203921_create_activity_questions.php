<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->default(0)->comment('活动ID');
            $table->tinyInteger('type')->default(0)->comment('类型 0-文字 1-图片');
            $table->string('title', 100)->default('')->comment('问题描述');
            $table->string('source')->default('')->comment('资源地址');
            $table->tinyInteger('is_checkbox')->default(0)->comment('是否多选 0-否 1-是');
            $table->timestamps();
            $table->softDeletes();
            $table->index('activity_id');
            $table->index('type');
            $table->index('is_checkbox');
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_questions');
    }
}
