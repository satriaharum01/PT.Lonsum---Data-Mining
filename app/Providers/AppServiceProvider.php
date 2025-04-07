<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\KonstantaCalculator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(KonstantaCalculator::class, function ($app, $params) {
            return new KonstantaCalculator(
                $params['alpha'],
                $params['level'],
                $params['level1'],
                $params['level2']
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
