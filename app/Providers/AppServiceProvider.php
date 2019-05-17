<?php

namespace App\Providers;

use App\Models\OrderEventModel;
use App\Observers\OrderEventObserver;
use Illuminate\Support\ServiceProvider;

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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        OrderEventModel::observe(OrderEventObserver::class);
    }
}
