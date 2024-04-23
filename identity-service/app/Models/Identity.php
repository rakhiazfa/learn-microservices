<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Identity extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'registrationNumber',
        'avatar',
        'name',
        'placeOfBirth',
        'dateOfBirth',
        'gender',
        'email',
        'password',
        'isActive',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dateOfBirth' => 'date',
            'password' => 'hashed',
            'isActive' => 'boolean',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
