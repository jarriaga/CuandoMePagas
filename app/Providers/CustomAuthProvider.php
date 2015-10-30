<?php
/**
 * Created by PhpStorm.
 * User: jarriaga
 * Date: 10/7/15
 * Time: 12:26 AM
 */

namespace App\Providers;


use App\Http\Models\User;
use Illuminate\Support\ServiceProvider;
use App\Auth\CustomUserProvider;

class CustomAuthProvider extends ServiceProvider{


    public function boot()
    {
        $this->app['auth']->extend('custom',function()
        {
           return new CustomUserProvider(new User());
        });
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}