<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->default(0)->comment('文章类型 1-新闻 2-教育之声 2-工作动态');
            $table->string('title', 255)->default('')->comment('标题');
            $table->text('content')->nullable()->comment('文章内容');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示 0-否 1-是');
            $table->string('list_pic')->nullable()->comment('列表图片地址');
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
        Schema::dropIfExists('articles');
    }
}
