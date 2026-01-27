<?php

namespace App\Providers;

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
        // APP_URLがhttpsで始まる場合はHTTPSを強制
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
        
        // 強制的にベースURLを設定
        URL::forceRootUrl(config('app.url'));
    }
}
