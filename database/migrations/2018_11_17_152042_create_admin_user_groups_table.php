<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_no')->default(0)->unique()->comment('分组编号');
            $table->string('name', 100)->unique()->comment('分组名称');
            $table->string('tip', 50)->nullable(false)->unique()->comment('分组提示');
            $table->text('actions')->nullable()->comment('权限');
            $table->timestamps();
            $table->index('group_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_groups');
    }
}
