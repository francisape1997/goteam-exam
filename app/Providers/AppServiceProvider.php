<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\CacheInterface;
use App\Services\RedisCacheService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // We're using redis as default cache service provider.
        $this->app->bind(CacheInterface::class, function() {
            
            return match(config('cache.default')) {
                'redis' => new RedisCacheService(),
            };
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
