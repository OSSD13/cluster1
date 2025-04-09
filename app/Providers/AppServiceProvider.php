<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $host = request()->getHost();

        if (str_contains($host, 'se.buu.ac.th')) {
            // ถ้าเข้าโดเมนมหาลัย
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
            config(['app.asset_url' => config('app.url') . '/cluster3']); // แก้ตรงนี้
        } else {
            // กรณีเข้า IP
            URL::forceRootUrl('http://' . $host . ':1303');
            config(['app.asset_url' => null]);
        }
    }
}
