<?php

namespace App\Providers;

use App\Services\AccessRightService;
use App\Services\AuthService;
use App\Services\IdentityService;
use App\Services\RabbitMQService;
use App\Services\RoleService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RabbitMQService::class);
        $this->app->singleton(AccessRightService::class);
        $this->app->singleton(RoleService::class);
        $this->app->singleton(IdentityService::class);
        $this->app->singleton(AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        DB::listen(function ($query) {
            Log::channel('query')->info(
                $query->sql,
                [
                    'bindings' => $query->bindings,
                    'time' => $query->time
                ]
            );
        });
    }
}
