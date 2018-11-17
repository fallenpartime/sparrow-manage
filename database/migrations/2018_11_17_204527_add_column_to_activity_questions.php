<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToActivityQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_questions', function (Blueprint $table) {
            $table->tinyInteger('is_show')->default(0)->after('source')->comment('显示状态 0-否 1-是');
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
        Schema::table('activity_questions', function (Blueprint $table) {
            $table->dropIndex('activity_questions_is_show_index');
            $table->dropColumn('is_show');
        });
    }
}
