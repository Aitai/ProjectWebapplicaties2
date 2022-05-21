<?php

namespace App\Models;

use App\Traits\Blendable;
use App\Traits\EncryptPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, EncryptPassword, Blendable, SoftDeletes;

    const USER_ROLE_ADMIN   = 0;
    const USER_ROLE_USER = 1;
    const USER_ROLE_STATION = 2;

    const SUBSCRIPTION_BASIC = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email','subscription_id' ,'password','role'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'deleted_at','created_by','updated_by','deleted_by'];

    /**
     * All visable attribute when toArray is called.
     *
     * @var string[]
     */
    protected $visible = ['id','email','role','created_at','updated_at'];

    public $incrementing = false;
    protected $keyType = 'string';

    public function maintenances(){
        return $this->hasMany(Maintenance::class,'created_by','id');
    }

    public function stations(){
        return $this->hasMany(Station::class,'created_by','id');
    }

    public function subscription(){
        return $this->hasOne(Subscription::class,'id','subscription_id');
    }
}
