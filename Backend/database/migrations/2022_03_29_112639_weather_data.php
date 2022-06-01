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
        Schema::create('weather_data', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->string('station_name', 10);
            $blueprint->dateTime('datetime');
            $blueprint->decimal('temp')->nullable();
            $blueprint->decimal('dew_point_temp')->nullable();
            $blueprint->decimal('station_air_pressure')->nullable();
            $blueprint->decimal('sea_level_air_pressure')->nullable();
            $blueprint->decimal('visibility')->nullable();
            $blueprint->decimal('wind_speed')->nullable();
            $blueprint->decimal('precipitation')->nullable();
            $blueprint->decimal('snow_depth')->nullable();
            $blueprint->decimal('cloud_cover_percentage')->nullable();
            $blueprint->integer('wind_direction')->nullable();
            $blueprint->boolean('frost')->default(false);
            $blueprint->boolean('rain')->default(false);
            $blueprint->boolean('snow')->default(false);
            $blueprint->boolean('hail')->default(false);
            $blueprint->boolean('thunderstorm')->default(false);
            $blueprint->boolean('tornado')->default(false);

            $blueprint->foreign('station_name')->references('name')->on('station');

            $blueprint->index(['station_name']);
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
