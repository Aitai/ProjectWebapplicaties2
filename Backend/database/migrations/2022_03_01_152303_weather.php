<?php

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
        Schema::create('timezones', function (Blueprint $blueprint){
            $blueprint->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $blueprint->integer('offset');
            $blueprint->text('description');
            $blueprint->uuid('created_by')->index();
            $blueprint->uuid('updated_by')->index()->nullable();
            $blueprint->timestamps();
            $blueprint->softDeletes();

            $blueprint->foreign('created_by')->references('id')->on('users');
            $blueprint->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('stations', function (Blueprint $blueprint){
            $blueprint->integer('id')->primary();
            $blueprint->string('name');
            $blueprint->float('latitude')->nullable();
            $blueprint->float('longitude')->nullable();
            $blueprint->string('country')->nullable();
            $blueprint->uuid('timezone_id')->nullable()->index();
            $blueprint->uuid('created_by')->nullable()->index();
            $blueprint->uuid('updated_by')->index()->nullable();
            $blueprint->timestamps();
            $blueprint->softDeletes();

            $blueprint->foreign('timezone_id')->references('id')->on('timezones');
            $blueprint->foreign('created_by')->references('id')->on('users');
            $blueprint->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('measurements', function (Blueprint $blueprint){
            $blueprint->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $blueprint->integer('STN');
            $blueprint->date('DATE');
            $blueprint->time('TIME');
            $blueprint->double('TEMP');
            $blueprint->double('DEWP');
            $blueprint->double('STP');
            $blueprint->double('SLP');
            $blueprint->double('VISIB');
            $blueprint->double('WDSP');
            $blueprint->double('PRCP');
            $blueprint->double('SNDP');
            $blueprint->double('CLDC');
            $blueprint->double('WNDDIR');
            $blueprint->char('FRSHTT',6);
        });

        /**
         * de volgende twee sql regeles valiaderen de temperature voor dat deze wordt opgeslagen. E
         * r is voor gekozen om dat in de database te checken omdat die geoptimaliseerd is voor dit soort berekeningen.
         * Eerst wordt er een database functie aangemaakt die het pertage verschillen tussen de niueuw en de laatste 30 uitrekenend toegevoegd
         * Die wordt gebruiker in een trigger als het blijt dat het verschill grooter van 19 procent is krijg je een 45000 error terug van de database
         */
     //   DB::unprepared('create definer = root@`%` procedure validTemperatureCheck(IN stationID char(36), IN newThmperature double, OUT valid tinyint(1)) begin declare temperatureAvg int; select (round((avg(temperature)/newThmperature)*100) > 20) into temperatureAvg from measurements where station_id collate utf8mb4_general_ci = stationID order by created_by asc limit 30; if(temperatureAvg is null or temperatureAvg > 19) then select false into valid; else select true into valid; end if; end');
      //  DB::unprepared('create definer = root@`%` trigger trigger_validate_temperature_before_insert before insert on measurements for each row begin set @stationID = null; set @newThmperature = 0.0; call validTemperatureCheck(new.station_id, new.temperature, @valid); if(@valid < 0) then signal sqlstate \'45000\' set message_text = \'Invalid record\'; end if; end;');
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop trigger if exists trigger_validate_temperature_before_insert');
        DB::unprepared('drop procedure if exists validTemperatureCheck');

        Schema::dropDatabaseIfExists('timezones');
        Schema::dropDatabaseIfExists('measurements');
        Schema::dropDatabaseIfExists('stations');
    }
};
