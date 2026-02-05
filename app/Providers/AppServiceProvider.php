<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Laravel 9: usar resources/lang si existe (compatibilidad con estructura L8)
        $legacyLangPath = resource_path('lang');
        if (is_dir($legacyLangPath)) {
            $this->app->useLangPath($legacyLangPath);
        }
    }
}
