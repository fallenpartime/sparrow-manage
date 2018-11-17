<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable(false)->unique()->comment('权限名称');
            $table->enum('type', [1,2,3])->nullable(false)->comment('类型 1-一级 2-二级 3-三级');
            $table->integer('parent_id')->default(0)->comment('上级ID');
            $table->string('ts_action', 100)->nullable(false)->unique()->comment('权限标示');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_actions');
    }
}
