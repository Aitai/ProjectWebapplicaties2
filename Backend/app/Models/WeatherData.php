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
        return  DB::select("SELECT MAX(WD.temp) as max_temp, CAST(WD.datetime AS DATE) AS date, GL.town FROM weather_data AS WD INNER JOIN geolocation AS GL ON WD.station_name = GL.station_name WHERE WD.datetime >= (CURDATE() - INTERVAL 4 WEEK) GROUP BY date ORDER BY date DESC;");
    }
}
