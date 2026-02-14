<?php

namespace App\Providers;

use Symfony\Component\HttpFoundation\Request;
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

        $appUrl = (string) config('app.url');
        if ($appUrl !== '') {
            URL::forceRootUrl($appUrl);
            if (str_starts_with($appUrl, 'https://')) {
                URL::forceScheme('https');
            }
        }

        if (! $this->app->runningInConsole()) {
            $proto = request()->header('x-forwarded-proto');
            if ($proto === 'https' || request()->secure()) {
                URL::forceScheme('https');
            }
        }
    }
}
