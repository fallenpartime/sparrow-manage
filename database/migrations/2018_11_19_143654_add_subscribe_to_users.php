<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscribeToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_subscribe')->default(0)->comment('是否关注 0-否 1-是');
            $table->timestamp('subscribed_at')->nullable(true)->comment('关注时间');
            $table->index('is_subscribe');
            $table->index('subscribed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_is_subscribe_index');
            $table->dropIndex('users_subscribed_at_index');
            $table->dropColumn('is_subscribe');
            $table->dropColumn('subscribed_at');
        });
    }
}
