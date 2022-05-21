<?php

namespace App\Models;

use App\Traits\Blendable;
use App\Traits\EncryptPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;

class Measurement extends Model
{
     protected $fillable = ['STN','TEMP','TEMP','DEWP','STP','SLP','VISIB','WDSP','PRCP','SNDP','FRSHTT','CLDC','WNDDIR'];
    public $timestamps = false;
    //Geeft het timezone object terug
    public function station(): HasOne
    {
        return $this->hasOne(Stations::class, 'STN', 'id');
    }
}
