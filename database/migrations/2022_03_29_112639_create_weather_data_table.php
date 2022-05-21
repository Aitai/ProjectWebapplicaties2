<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->increments('id');

            $table->mediumInteger('station_name');
//            $table->foreign('station_name')->references('name')->on('station');

            $table->dateTime('datetime');
            $table->decimal('temp')->nullable();
            $table->decimal('dew_point_temp')->nullable();
            $table->decimal('station_air_pressure')->nullable();
            $table->decimal('sea_level_air_pressure')->nullable();
            $table->decimal('visibility')->nullable();
            $table->decimal('wind_speed')->nullable();
            $table->decimal('precipitation')->nullable();
            $table->decimal('snow_depth')->nullable();
            $table->decimal('cloud_cover_percentage')->nullable();
            $table->integer('wind_direction')->nullable();
            $table->boolean('frost')->default(false);
            $table->boolean('rain')->default(false);
            $table->boolean('snow')->default(false);
            $table->boolean('hail')->default(false);
            $table->boolean('thunderstorm')->default(false);
            $table->boolean('tornado')->default(false);

            $table->index(['station_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_data');
    }
};
