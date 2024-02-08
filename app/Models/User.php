<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected  $table = 'users';

//    protected $fillable = [
//        'firstname', 'lastname'
//    ];



    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    /**
     * @var mixed
     */
    public function getJWTIdentifier(){
        return $this->getKey();

    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($passAttr){
        try {
            if (isset($passAttr)) {
                $password = Hash::make($passAttr);
                $this->attributes['password'] = $password;
            }
        }catch (\Exception $exception) {
            $attribute['password'] = "";
        }
    }
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

}
