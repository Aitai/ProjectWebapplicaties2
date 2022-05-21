<?php

namespace App\Models;

use App\Traits\Blendable;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use Blendable;


    protected $keyType = 'string';
    protected $fillable = ['name','times_day','times_hour'];
}
