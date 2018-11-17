<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->default('')->comment('学区名称');
            $table->string('no', 100)->default('')->comment('学区编号');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示 0-否 1-是');
            $table->timestamps();
            $table->softDeletes();
            $table->index('name');
            $table->index('no');
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
        Schema::dropIfExists('school_districts');
    }
}
