<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_no')->default(0)->unique()->comment('角色编号');
            $table->string('name', 100)->unique()->comment('角色名称');
            $table->string('index_action')->nullable()->comment('登录action');
            $table->text('actions')->nullable()->comment('权限');
            $table->timestamps();
            $table->index('role_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_roles');
    }
}
