<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('inn');
            $table->string('kpp');
            $table->string('ogrn');
            $table->string('address');
            $table->string('account');
            $table->string('email');
            $table->string('phone');
            $table->string('director');
            $table->string('contact_person');

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
        Schema::dropIfExists('advertisers');
    }
}
