<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTelentToSchoolsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('telent', 50)->after('is_show')->default('')->comment('办公电话');
            $table->tinyInteger('property')->after('telent')->default(0)->comment('学校性质：0-未知 1-公立 2-私立');
            $table->index('telent');
            $table->index('property');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropIndex('schools_property_index');
            $table->dropIndex('schools_telent_index');
            $table->dropColumn('property');
            $table->dropColumn('telent');
        });
    }
}
