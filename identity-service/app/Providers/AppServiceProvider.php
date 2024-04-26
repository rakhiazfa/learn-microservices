<?php

namespace App\Providers;

use App\Services\IdentityService;
use App\Services\RabbitMQService;
use App\Services\RoleService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RabbitMQService::class);
        $this->app->singleton(IdentityService::class);
        $this->app->singleton(RoleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
