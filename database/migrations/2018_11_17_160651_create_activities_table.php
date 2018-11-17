<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->comment('活动类型');
            $table->string('title')->default('')->comment('活动标题');
            $table->string('description')->default('')->comment('活动简介');
            $table->text('content')->comment('活动内容');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示 0-否 1-是');
            $table->string('list_pic')->nullable(true)->comment('列表图片地址');
            $table->timestamp('published_at')->nullable(true)->comment('发布时间');
            $table->timestamps();
            $table->softDeletes();
            $table->index('type');
            $table->index('is_show');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
