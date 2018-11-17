<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUserAdmonitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_admonitions', function (Blueprint $table) {
            $table->string('reply_owner', 50)->default('')->comment('答复执行人');
            $table->integer('reply_userid')->default(0)->comment('答复执行人ID');
            $table->index('reply_owner');
            $table->index('reply_userid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_admonitions', function (Blueprint $table) {
            $table->dropIndex('user_admonitions_reply_owner_index');
            $table->dropIndex('user_admonitions_reply_userid_index');
            $table->dropColumn('reply_owner');
            $table->dropColumn('reply_userid');
        });
    }
}
