<?php

namespace App\Providers;

use App\Models\AccessRight;
use App\Models\Identity;
use App\Models\Role;
use App\Observers\AccessRightObserver;
use App\Observers\IdentityObserver;
use App\Observers\RoleObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        AccessRight::observe(AccessRightObserver::class);
        Role::observe(RoleObserver::class);
        Identity::observe(IdentityObserver::class);
    }
}
