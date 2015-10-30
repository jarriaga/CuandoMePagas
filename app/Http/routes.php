<?php

//Public Routes

Route::get('/',['as'    =>  'homepage', function () {   return view('home.index');    }]);
Route::get('/profile/{username}',['as'  =>  'profile',  'uses'  =>  'User\ProfileController@getIndex']);

//Routes for non Authenticated users
Route::group(['middleware'  =>  'guest'],   function(){
        Route::get('/signup',['as'=>'signup','uses'=>'User\AuthController@getIndex']);
        Route::post('/signup/save',['as'=>'saveUser','uses'=>'User\AuthController@postSaveUser']);
        Route::get('/facebook',['as'=>'facebookCallback','uses'=>'User\AuthController@getLoginFacebook']);
        Route::get('/login',['as'=>'login','uses'=>'User\AuthController@getLogin']);
        Route::post('/auth/login',['as'=>'authLogin','uses'=>'User\AuthController@postAuthLogin']);
        Route::get('/forget-password',['as'=>'forgetPassword','uses'=>'User\AuthController@getForgetPassword']);
        Route::post('/forget-password',['as'=>'postForgetPassword','uses'=>'User\AuthController@postForgetPassword']);
        Route::get('/reset-password/code/{code}',['as'=>'resetPassword','uses'=>'User\AuthController@getResetPassword']);
        Route::post('/reset-password/',['as'=>'postResetPassword','uses'=>'User\AuthController@postResetPassword']);
    });


//Routes when the user is Authenticated
Route::group(['middleware'  =>  'auth'],    function(){
    Route::get('/logout',['as'=>'logout','uses'=>'User\AuthController@getUserLogout']);
    Route::get('/dashboard',['as'   =>  'dashboard',    'uses'  =>  'User\DashboardController@getIndex']);

    });


