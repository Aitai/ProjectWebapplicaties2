<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnusedStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::delete("DELETE FROM geolocation WHERE station_name IN (SELECT name FROM station WHERE 
            ( 6371 * acos( cos( radians(35.709081) ) 
            * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(51.377954) ) + sin( radians(35.709081) ) 
            * sin( radians( latitude ) ) ) ) > 2000)");

        DB::delete("DELETE FROM nearestlocation WHERE station_name IN (SELECT name FROM station WHERE 
                ( 6371 * acos( cos( radians(35.709081) ) 
                * cos( radians( latitude ) ) 
                * cos( radians( longitude ) - radians(51.377954) ) + sin( radians(35.709081) ) 
                * sin( radians( latitude ) ) ) ) > 2000)");

        DB::delete("DELETE FROM station WHERE 
                ( 6371 * acos( cos( radians(35.709081) ) 
                * cos( radians( latitude ) ) 
                * cos( radians( longitude ) - radians(51.377954) ) + sin( radians(35.709081) ) 
                * sin( radians( latitude ) ) ) ) > 2000");

    }
}
