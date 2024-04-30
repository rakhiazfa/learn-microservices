<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        Cache::tags(Role::$cacheKey)->forget($role->id);
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        Cache::tags(Role::$cacheKey)->forget($role->id);
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        Cache::tags(Role::$cacheKey)->forget($role->id);
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        Cache::tags(Role::$cacheKey)->forget($role->id);
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        Cache::tags(Role::$cacheKey)->forget($role->id);
    }
}
