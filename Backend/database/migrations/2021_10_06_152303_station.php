<?php

// This file implements ProjectSemester2Stations.sql provided on BlackBoard.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $blueprint){
            $blueprint->string('country_code', 2)->primary();
            $blueprint->string('country', 45);
        });

        Schema::create('station', function (Blueprint $blueprint){
            $blueprint->string('name', 10)->primary();
            $blueprint->float('longitude');
            $blueprint->float('latitude');
            $blueprint->float('elevation');
        });

        Schema::create('geolocation', function (Blueprint $blueprint){
            $blueprint->increments('id');
            $blueprint->string('station_name', 10);
            $blueprint->string('country_code', 2);
            $blueprint->string('island', 100)->nullable();
            $blueprint->string('county', 100)->nullable();
            $blueprint->string('place', 100)->nullable();
            $blueprint->string('hamlet', 100)->nullable();
            $blueprint->string('town', 100)->nullable();
            $blueprint->string('municipality', 100)->nullable();
            $blueprint->string('state_district', 100)->nullable();
            $blueprint->string('administrative', 100)->nullable();
            $blueprint->string('state', 100)->nullable();
            $blueprint->string('village', 100)->nullable();
            $blueprint->string('region', 100)->nullable();
            $blueprint->string('province', 100)->nullable();
            $blueprint->string('city', 100)->nullable();
            $blueprint->string('locality', 100)->nullable();
            $blueprint->string('postcode', 100)->nullable();
            $blueprint->string('country', 100)->nullable();

            $blueprint->foreign('station_name')->references('name')->on('station');
            $blueprint->foreign('country_code')->references('country_code')->on('country');
        });

        Schema::create('nearestlocation', function (Blueprint $blueprint){
            $blueprint->increments('id');
            $blueprint->string('station_name', 10);
            $blueprint->string('name', 100)->nullable();
            $blueprint->string('administrative_region1', 100)->nullable();
            $blueprint->string('administrative_region2', 100)->nullable();
            $blueprint->string('country_code', 2);
            $blueprint->float('longitude');
            $blueprint->float('latitude');

            $blueprint->foreign('station_name')->references('name')->on('station');
            $blueprint->foreign('country_code')->references('country_code')->on('country');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropDatabaseIfExists('country');
        Schema::dropDatabaseIfExists('geolocation');
        Schema::dropDatabaseIfExists('nearestlocation');
        Schema::dropDatabaseIfExists('station');
    }
};
