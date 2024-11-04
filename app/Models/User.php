<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends NeoEloquent implements JWTSubject, AuthenticatableContract
{
    use Authenticatable;

    protected $label = 'User'; // Neo4j label for User node
    protected $fillable = ['name', 'email', 'password'];

    // JWTSubject implementation
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
