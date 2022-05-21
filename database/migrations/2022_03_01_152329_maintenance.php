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
        Schema::create('maintenances', function (Blueprint $blueprint){
            $blueprint->uuid('id')->primary()->default('uuid()');
            $blueprint->uuid('station_id')->index();
            $blueprint->uuid('created_by')->index();
            $blueprint->uuid('updated_by')->index()->nullable();
            $blueprint->timestamps();
            $blueprint->softDeletes();

            $blueprint->foreign('created_by')->references('id')->on('users');
            $blueprint->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropDatabaseIfExists('maintenance');
    }
};
