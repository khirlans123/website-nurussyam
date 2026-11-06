<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

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
        // Paksa skema HTTPS saat diakses melalui ngrok, tunnel, atau proxy HTTPS agar asset/CSS/gambar tidak mixed-content
        if (
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            (isset($_SERVER['HTTP_HOST']) && (str_contains($_SERVER['HTTP_HOST'], 'ngrok') || str_contains($_SERVER['HTTP_HOST'], 'trycloudflare') || str_contains($_SERVER['HTTP_HOST'], 'localtunnel'))) ||
            app()->environment('production')
        ) {
            URL::forceScheme('https');
        }

        // Bagikan data URI logo ringan (Base64) ke layout agar logo preloader muncul seketika (0ms) tanpa tunggu download aset
        View::composer(['layouts.app', 'admin.layout', 'admin.auth.login'], function ($view) {
            static $b64 = null;
            if ($b64 === null) {
                $path = public_path('images/logo-ppns-sm.b64');
                $b64 = file_exists($path) ? trim(file_get_contents($path)) : '';
            }
            $view->with('preloaderLogoB64', $b64);
        });

        // Bagikan data konfigurasi PSB ke layout & views
        View::composer(['layouts.app', 'admin.layout', 'pendaftaran_info', 'pendaftaran', 'pendaftaran_syarat', 'home', 'admin.psb.settings'], function ($view) {
            $view->with('psbSettings', \App\Models\SiteSetting::getPsbSettings());
        });
    }
}

