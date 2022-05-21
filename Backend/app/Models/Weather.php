<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weather';
    protected $primaryKey = 'name';
 //   protected $fillable = ['STN','DATE','TIME','TEMP','DEWP','STP','SLP','VISIB','WDSP','PRCP','SNDP','FRSHTT','CLDC','WNDDIR'];
    public $timestamps = false;
}
