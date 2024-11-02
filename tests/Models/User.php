<?php

namespace Natyka\Test\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Natyka\Contracts\Rating;
use Natyka\Traits\CanBeRated;
use Natyka\Traits\CanRate;

class User extends Authenticatable implements Rating
{
    use CanBeRated, CanRate;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function name(): string
    {
        return $this->name;
    }
}
