<?php

namespace App\Models;

use App\Casts\Uppercase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AccessRight extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public static string $cacheKey = 'access_rights';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'method',
        'uri',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'method' => Uppercase::class,
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_access_rights', 'access_right_id', 'role_id');
    }
}
