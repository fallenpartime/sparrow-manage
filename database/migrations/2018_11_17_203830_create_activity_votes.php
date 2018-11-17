<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityVotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('activity_id')->default(0)->comment('活动ID');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->tinyInteger('type')->default(0)->comment('类型 1-选择 2-其他自填');
            $table->integer('question_id')->default(0)->comment('问题ID');
            $table->bigInteger('answer_id')->default(0)->comment('答案ID');
            $table->string('other')->default('')->comment('其他自填');
            $table->timestamps();
            $table->softDeletes();
            $table->index('activity_id');
            $table->index('user_id');
            $table->index('type');
            $table->index('question_id');
            $table->index('answer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_votes');
    }
}
