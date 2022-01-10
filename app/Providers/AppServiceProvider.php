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

        Validator::extend("sum", function ($attribute, $value, $parameters) {
            $expected = floatval(array_shift($parameters));
            $otherParameters = request()->only($parameters);
            return floatval(array_sum(array_merge(array_values($otherParameters), [$value]))) === $expected;
        });

        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });
    }
}
