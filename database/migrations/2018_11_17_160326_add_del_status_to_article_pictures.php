<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDelStatusToArticlePictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_pictures', function (Blueprint $table) {
            $table->tinyInteger('del_status')->default(0)->comment('作废处理状态 0-未处理 1-已处理');
            $table->index('del_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_pictures', function (Blueprint $table) {
            $table->dropIndex('article_pictures_del_status_index');
            $table->dropColumn('del_status');
        });
    }
}
