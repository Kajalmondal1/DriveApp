<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


class driveUser extends Authenticatable implements JWTSubject
{
    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','created_at','updated_at','isAdmin'];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
