<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->comment('学校类型');
            $table->string('no', 100)->default('')->comment('学校编号');
            $table->string('district_no', 100)->default('')->comment('学区编号');
            $table->string('name', 100)->default('')->comment('学校名称');
            $table->string('address', 255)->default('')->comment('学校地址');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示 0-否 1-是');
            $table->timestamps();
            $table->softDeletes();
            $table->index('type');
            $table->index('no');
            $table->index('district_no');
            $table->index('name');
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
        Schema::dropIfExists('schools');
    }
}
