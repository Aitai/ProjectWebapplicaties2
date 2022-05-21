<?php

namespace App\Models;

use App\Traits\Blendable;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use Blendable;

    protected $fillable = ['name','datetime','description'];
}
