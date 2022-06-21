<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Country extends Model
{
    protected $table = 'country';
    public $timestamps = false;

    public function nearestLocations(): HasMany
    {
        return $this->hasMany(NearestLocation::class, 'country_code', 'country_code');
    }

    public function geoLocations(): HasMany
    {
        return $this->hasMany(GeoLocation::class, 'country_code', 'country_code');
    }
}
