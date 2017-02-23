<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



/** Routes for Logged in users ******************************/
Route::group(['middleware'=>'auth'],function(){

    Route::get('/search', 'HomeController@index')->name('search');


    Route::get('/profile/{name}/{id}/edit','Profile\\UserProfileController@editUserProfile')->name('editUserProfile');
    Route::post('/profile/user/update','Profile\\UserProfileController@postUpdateProfile')->name('postUpdateProfile');
    Route::get('/complaint/create','Complaint\\ComplaintController@createComplaint')->name('createComplaint');
    Route::post('/complaint/create','Complaint\\ComplaintController@postCreate')->name('postCreateComplaint');
    Route::get('/complaint/edit/{id}','Complaint\\ComplaintController@editComplaint')->name('editComplaint');
    Route::post('/complaint/edit/{id}','Complaint\\ComplaintController@postEditComplaint')->name('postEditComplaint');
    Route::get('/complaint/{id}','Complaint\\ComplaintController@viewComplaint')->name('viewComplaint');
    Route::post('/complaint/delete/{id}','Complaint\\ComplaintController@postDeleteComplaint')->name('postDeleteComplaint');

});



Route::group(['middleware'=>'guest'],function(){
    Route::get('/auth/facebook/','AuthFacebookController@redirectToProvider')->name('facebookLogin');
    Route::get('/auth/facebook/callback','AuthFacebookController@handleProviderCallback')->name('facebookCallback');
    Route::get('/auth/facebook/email','AuthFacebookController@facebookUpdateEmail')->name('facebookUpdateEmail');
    Route::post('/auth/facebook/email','AuthFacebookController@facebookUpdateEmailPost')->name('facebookUpdateEmailPost');
});

Route::get('/profile/{name}/{id}','Profile\\UserProfileController@getUserProfile')->name('getUserProfile');

Auth::routes();



