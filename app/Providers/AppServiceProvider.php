<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         // allow registration from particular domains
         \Validator::extend('email_domain', function($attribute, $value, $parameters, $validator) {
              $allowedEmailDomains = ['corus360.com', 'resqdr.com'];
              return in_array( explode('@', $parameters[0])[1] , $allowedEmailDomains);
         });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
