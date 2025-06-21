<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\AppConfig;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    private function getConfig()
    {
        // Cegah error saat tabel belum dimigrasi
        $setting = null;

        if (Schema::hasTable('app_configs')) {
            // Ambil setting dari cache jika ada, jika tidak, ambil dari DB
            $setting = Cache::rememberForever('setting', function () {
                return AppConfig::first();
            });
        }

        // Share ke seluruh view
        View::share('setting', $setting);
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->getConfig();
        Paginator::useBootstrap();
    }
}
