<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Identity extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * @var string
     */
    public static string $cacheKey = 'identities';

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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'identity_roles', 'identity_id', 'role_id');
    }

    public function scopeDateOfBirth(Builder $query, $date): Builder
    {
        return $query->where('date_of_birth', '=', Carbon::parse($date));
    }
}
