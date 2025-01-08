<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

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
        if (config('app.debug') && config('mail.to')) {
            Mail::alwaysTo(config('mail.to'));
        }

        // Parse the Accept-Language header
        $acceptLanguage = request()->header('Accept-Language', 'en'); // Default to English
        $locale = strtok($acceptLanguage, ','); // Extract the first language (e.g., 'en_US')

        // Validate and set the locale
        if (preg_match('/^[a-zA-Z_]+$/', $locale)) {
            App::setLocale($locale);
        } else {
            App::setLocale('en'); // Fallback to 'en' if the locale is invalid
        }
    }
}
