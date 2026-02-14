<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Request::setTrustedProxies(['*'], Request::HEADER_X_FORWARDED_ALL);

        if (! $this->app->runningInConsole()) {
            $proto = request()->header('x-forwarded-proto');
            if ($proto === 'https' || request()->secure()) {
                URL::forceScheme('https');
            }
        }
    }
}
