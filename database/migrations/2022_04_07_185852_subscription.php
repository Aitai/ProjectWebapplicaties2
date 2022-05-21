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
        Schema::create('subscriptions',function(Blueprint $blueprint){
            $blueprint->uuid('id')->primary()->default('uuid()');
            $blueprint->string('name');
            $blueprint->integer('times_day')->default(0);
            $blueprint->integer('times_hour')->default(0);
            $blueprint->timestamps();
            $blueprint->softDeletes();
        });

        Schema::table('users', function(Blueprint $blueprint) {
            $blueprint->uuid('subscription_id');
            $blueprint->foreign('subscription_id')->references('id')->on('subscriptions');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
