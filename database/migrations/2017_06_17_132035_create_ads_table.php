<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('block_id');
            $table->unsignedInteger('advertiser_id');
            $table->string('img_link');
            $table->string('redirect_url');
            $table->dateTime('start_date');
            $table->dateTime('finish_date');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
