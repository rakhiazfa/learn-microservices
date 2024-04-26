<?php

namespace App\Models;

use App\Casts\Encrypted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Identity extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'registration_number',
        'avatar',
        'name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'email',
        'password',
        'is_active',
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
            'registration_number' => Encrypted::class,
            'date_of_birth' => 'date',
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

    public function personalAccessTokens(): HasMany
    {
        return $this->hasMany(PersonalAccessToken::class, 'identity_id');
    }
}
