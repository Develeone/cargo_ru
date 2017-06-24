<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSelectsBooleansToCategoriesWithCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories_with_cities', function (Blueprint $table) {
            $table->boolean('cities');
            $table->boolean('regions');
            $table->boolean('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories_with_cities', function (Blueprint $table) {
            $table->dropColumn('countries');
            $table->dropColumn('regions');
            $table->dropColumn('cities');
        });
    }
}
