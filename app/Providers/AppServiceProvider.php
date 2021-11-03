<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

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
        Validator::extend('notspecial_spaces', function ($attribute, $value) {
            return preg_match('/^[0-9a-zA-Z\pL\s]+$/u', $value); 

        });
    }
}
