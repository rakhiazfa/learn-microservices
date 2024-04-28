<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function identities(): BelongsToMany
    {
        return $this->belongsToMany(Identity::class, 'identity_roles', 'role_id', 'identity_id');
    }

    public function accessRights(): BelongsToMany
    {
        return $this->belongsToMany(AccessRight::class, 'role_access_rights', 'role_id', 'access_right_id');
    }
}
