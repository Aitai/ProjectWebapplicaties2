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
        Schema::create('corrected_weather_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('weather_data_id')->unsigned();
            $table->string('type');
            $table->string('original_value')->nullable();

            // No foreign key on 'weather_data_id', errors with BEFORE INSERT trigger
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corrected_weather_data');
    }
};
