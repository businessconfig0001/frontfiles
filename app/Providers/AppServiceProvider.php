<?php

namespace FrontFiles\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Fixes the error:
        //SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes
        Schema::defaultStringLength(191);

        //Custom validation rule for checking if the file an allowed type
        \Validator::extend('allowed_file', 'FrontFiles\Rules\AllowedFile@passes');

        //Custom validation rule for checking if the user has enough space left for this file
        \Validator::extend('has_enough_space', 'FrontFiles\Rules\AllowedFile@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->environment() !== 'production')
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }
}
