<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('is_open')->after('is_show')->default(0)->comment('是否开放 0-否 1-是');
            $table->integer('read_count')->after('list_pic')->default(0)->comment('阅读数');
            $table->integer('like_count')->after('read_count')->default(0)->comment('点赞数');
            $table->integer('join_count')->after('like_count')->default(0)->comment('参与人数');
            $table->timestamp('opened_at')->nullable(true)->comment('活动开启时间');
            $table->index('is_open');
            $table->index('opened_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropIndex('activities_is_open_index');
            $table->dropIndex('activities_opened_at_index');
            $table->dropColumn('is_open');
            $table->dropColumn('read_count');
            $table->dropColumn('like_count');
            $table->dropColumn('join_count');
            $table->dropColumn('opened_at');
        });
    }
}
