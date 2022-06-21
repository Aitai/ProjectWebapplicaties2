<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NearestLocation extends Model
{
    protected $table = 'nearestlocation';

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'country_code');
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'name', 'station_name');
    }


}
