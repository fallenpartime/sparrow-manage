<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAdmonitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_admonitions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->string('name', 50)->default('')->comment('用户名');
            $table->string('phone', 30)->default('')->comment('电话');
            $table->string('content', 1000)->default('')->comment('内容');
            $table->string('reply_content', 1000)->default('')->comment('答复内容');
            $table->tinyInteger('is_show')->default(0)->comment('显示状态 0-否 1-是');
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('reply_at')->nullable(true)->comment('答复时间');
            $table->index('user_id');
            $table->index('name');
            $table->index('phone');
            $table->index('is_show');
            $table->index('reply_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_admonitions');
    }
}
