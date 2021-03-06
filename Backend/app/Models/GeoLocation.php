<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GeoLocation extends Model
{
    public $timestamps = false;
    protected $table = 'geolocation';


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'country_code');
    }

    public function station(): HasOne
    {
        return $this->hasOne(Station::class, 'name', 'station_name');
    }
}
