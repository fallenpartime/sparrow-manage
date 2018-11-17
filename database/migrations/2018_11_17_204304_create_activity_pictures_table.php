<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_pictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('activity_id')->default(0)->comment('活动ID');
            $table->tinyInteger('type')->default(0)->comment('类型 1-列表图片');
            $table->string('pic')->comment('图片地址');
            $table->timestamps();
            $table->softDeletes();
            $table->index('activity_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_pictures');
    }
}
