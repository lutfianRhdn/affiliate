<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('province_id')->unsigned()->index();
            $table->string('city_name', 50)->index();
            $table->string('city_name_full', 100)->index();
            $table->enum('city_type', ['kabupaten', 'kota'])->nullable();
            $table->decimal('city_lat', 10, 6)->nullable()->index();
            $table->decimal('city_lon', 11, 6)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city');
    }
}
