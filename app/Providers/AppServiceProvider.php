<?php

namespace App\Providers;

use App\Http\Models\User;
use Illuminate\Support\Facades\Validator;
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
        //this custom validator
        Validator::extend('unique_email',function($attribute, $value, $parameters){
            $user               =       new User();
            $userCollection =       $user->getCollection();
            $result         =       $userCollection->findOne(['email'=>$value],['email']);
            if(!$result)
                return true;

            return false;
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
