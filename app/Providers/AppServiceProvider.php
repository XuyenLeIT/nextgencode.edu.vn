<?php

namespace App\Providers;

use App\Models\Carausel;
use Illuminate\Support\Facades\View;
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
        $carausels = Carausel::all();
        View::share(["carausels"=>$carausels]);
    }
}
