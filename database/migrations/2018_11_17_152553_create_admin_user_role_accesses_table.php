<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserRoleAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_role_accesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_no')->default(0)->comment('分组编号');
            $table->integer('role_no')->default(0)->comment('角色编号');
            $table->integer('leader_no')->default(0)->comment('主管角色编号');
            $table->tinyInteger('is_leader')->default(0)->comment('是否分组主管角色');
            $table->timestamps();
            $table->unique(['group_no', 'role_no']);
            $table->index('group_no');
            $table->index('role_no');
            $table->index('leader_no');
            $table->index('is_leader');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_role_accesses');
    }
}
