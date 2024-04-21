<?php

namespace App\Providers;

use App\Models\Identity;
use App\Observers\IdentityObserver;
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
        Identity::observe(IdentityObserver::class);
    }
}
