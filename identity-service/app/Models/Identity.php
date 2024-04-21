<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'registration_number',
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
}
