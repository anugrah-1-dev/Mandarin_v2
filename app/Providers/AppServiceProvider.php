<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Customer_Service;
use App\Models\Logo;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();
        // Pastikan View facade di-import
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $view->with('contactServices', Customer_Service::all());
                $view->with('navLogo1', Logo::where('key', 'logo1')->first());
                $view->with('navLogo2', Logo::where('key', 'logo2')->first());
                $view->with('popupPoster', Logo::where('key', 'popup_poster')->first());
            } catch (\Throwable $e) {
                $view->with('contactServices', collect());
                $view->with('navLogo1', null);
                $view->with('navLogo2', null);
                $view->with('popupPoster', null);
            }
        });
    }
}
