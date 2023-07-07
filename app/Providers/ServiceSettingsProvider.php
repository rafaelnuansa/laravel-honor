<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class ServiceSettingsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = Setting::first();

        // Bagikan data pengaturan ke semua tampilan
        view()->share('settings', $settings);

        // Juga bisa Anda gunakan di controller dengan mengganti 'view' dengan 'app'
        // $this->app->singleton('settings', function () use ($settings) {
        //     return $settings;
        // });
    }
}
