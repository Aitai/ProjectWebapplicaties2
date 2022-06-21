<?php

namespace App\Models;

use App\Traits\Blendable;
use App\Traits\EncryptPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;

class Station extends Model
{
    use  Authorizable, HasFactory, EncryptPassword, Blendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'longitude', 'latitude', 'elevation'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * All visable attribute when toArray is called.
     *
     * @var string[]
     */
    protected $visible = ['name', 'longitude', 'latitude', 'elevation'];

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    protected $table = 'station';


    public function weatherData(): HasMany
    {
        return $this->hasMany(WeatherData::class, 'station_name', 'name');
    }

    public function nearestLocation(): HasOne
    {
        return $this->hasOne(NearestLocation::class, 'station_name', 'name');
    }

    public function geoLocation(): HasOne
    {
        return $this->hasOne(GeoLocation::class, 'station_name', 'name');
    }


    public function isActive(): bool
    {
        if (count($this->weatherData)) {
            $last_date = last($this->weatherData->all())['datetime'];
        } else {
            return false;
        }

        if ($last_date < date("Y-m-d H:i:s", strtotime("-1 day"))) {
            return false;
        }
        return true;
    }

    public function averageMeasurements(): array
    {
        $weatherData = $this->weatherData;

        $averages = [];

        $avg_fields = [
            'temp',
            'dew_point_temp',
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


        foreach ($avg_fields as $row) {

            $averages[] = [$row => round($weatherData->avg($row), 1)];
        }

        return $averages;
    }

    public static function isInRange($lat, $lng): bool
    {
        $tehranLat = 35.709081;
        $tehranLng = 51.377954;
        $distance = (6371 * acos(cos(deg2rad($lat)) * cos(deg2rad($tehranLat)) * cos(deg2rad($tehranLng) - deg2rad($lng)) + sin(deg2rad($lat)) * sin(deg2rad($tehranLat))));
        return $distance <= 2000;
    }
}
