<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WeatherData extends Model
{
    protected $table = 'weather_data';

    protected $primaryKey = 'id';

    protected $fillable = [
        'station_name',
        'datetime',
        'temp',
        'dew_point_temperature',
        'station_air_pressure',
        'sea_level_air_pressure',
        'visibility',
        'wind_speed',
        'precipitation',
        'snow_depth',
        'cloud_cover_percentage',
        'wind_direction',
        'frost',
        'rain',
        'snow',
        'hail',
        'thunderstorm',
        'tornado'
    ];

    public $timestamps = false;

    public static function getPeakTemperatures() : array
    {
        $arr = DB::select("SELECT MAX(temp) as max_temp, CAST(datetime AS DATE) AS date FROM weather_data WHERE datetime >= (CURDATE() - INTERVAL 4 WEEK) GROUP BY date ORDER BY date DESC;");
        $dates = array();
        $values = array();
        foreach ($arr as $item) {
            $dates[] = $item->date;
            $values[] = $item->max_temp;
        }
        return ['dates' => $dates, 'temps' => $values];
    }
}
