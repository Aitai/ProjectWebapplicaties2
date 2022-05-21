<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
