<?php

namespace App\Observers;

use App\Models\AccessRight;
use Illuminate\Support\Facades\Cache;

class AccessRightObserver
{
    /**
     * Handle the AccessRight "created" event.
     */
    public function created(AccessRight $accessRight): void
    {
        Cache::tags(AccessRight::$cacheKey)->forget($accessRight->id);
    }

    /**
     * Handle the AccessRight "updated" event.
     */
    public function updated(AccessRight $accessRight): void
    {
        Cache::tags(AccessRight::$cacheKey)->forget($accessRight->id);
    }

    /**
     * Handle the AccessRight "deleted" event.
     */
    public function deleted(AccessRight $accessRight): void
    {
        Cache::tags(AccessRight::$cacheKey)->forget($accessRight->id);
    }

    /**
     * Handle the AccessRight "restored" event.
     */
    public function restored(AccessRight $accessRight): void
    {
        Cache::tags(AccessRight::$cacheKey)->forget($accessRight->id);
    }

    /**
     * Handle the AccessRight "force deleted" event.
     */
    public function forceDeleted(AccessRight $accessRight): void
    {
        Cache::tags(AccessRight::$cacheKey)->forget($accessRight->id);
    }
}
