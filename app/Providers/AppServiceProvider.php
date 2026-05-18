<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

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
        // Jalankan view composer untuk semua file blade (*)
        View::composer('*', function ($view) {
            // Cek apakah ada user yang sedang login saat ini
            if (Auth::check()) {
                // Ambil data setting yang memiliki business_id yang sama dengan user yang login
                $setting = Setting::where('business_id', Auth::user()->business_id)->first();

                // Kirim variabel $setting ke semua view/layout/komponen
                $view->with('setting', $setting);
            }
        });
    }
}
