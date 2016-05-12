<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    //Solo para usuarios registrados
    Route::group(['middleware' => ['auth.mongo']], function(){
        Route::get('/logout',
            [
                'as'        =>      'logout',
                'uses'      =>      'User\RegisterController@logOutAction'
            ]
        );

        Route::get('/coleccion-privada',
            [
                'as'        =>      'coleccionPrivada',
                'uses'      =>      'User\ColeccionPrivadaController@index'
            ]
        );
        Route::get('/coleccion-privada/agregar',
            [
                'as'        =>      'agregarCarro',
                'uses'      =>      'User\ColeccionPrivadaController@agregarCarro'
            ]
        );
        Route::post('/upload/image/',
            [
                'as'        =>      'uploadImage',
                'uses'      =>      'User\ColeccionPrivadaController@uploadImage'
            ]
        );
        Route::post('/remove/image/',
            [
                'as'        =>      'removeImage',
                'uses'      =>      'User\ColeccionPrivadaController@removeImage'
            ]
        );
        Route::post('/coleccion-privada/action',
            [
                'as'        =>      'agregarAutoAction',
                'uses'      =>      'User\ColeccionPrivadaController@agregarCarroAction'

            ]
        );
        Route::get('/coleccion-privada/auto/{idAuto}',
            [
                'as'        =>      'mostrarAutoPrivado',
                'uses'      =>      'User\ColeccionPrivadaController@MostrarUnAutoPrivado'
            ]
        );
    });

    //Solo para usuarios NO LOGUEADOS
    Route::group(['middleware'=>['guest']],function(){

        Route::get('/signup',
            [   'as'        =>      'signUpPage',
                'uses'      =>      'User\RegisterController@indexAction'
            ]
        );

        Route::post('/signup/save',
            [
                'as'        =>      'postCreateUser',
                'uses'      =>      'User\RegisterController@signUpAction'
            ]
        );

        Route::get('/aviso-verificar',
            [
                'as'        =>      'aviso-verificarCuenta',
                'uses'      =>      'User\RegisterController@avisoVerificacion'
            ]
        );

        Route::get('/activar/{codigoDeActivacion}',
            [
                'as'        =>      'activar',
                'uses'      =>      'User\RegisterController@activar'
            ]
        );
        Route::get('/facebook',
            [
                'as'        =>      'facebookAction',
                'uses'      =>      'User\RegisterController@signUpActionFacebook'
            ]
        );

        Route::get('/login',
            [
                'as'        =>      'logInPage',
                'uses'      =>      'User\RegisterController@logInPage'
            ]
        );
        Route::post('/login/action',
            [
                'as'        =>      'logInAction',
                'uses'      =>      'User\RegisterController@logInAction'
            ]
        );
        Route::get('/forgot-password',
            [
                'as'        =>      'forgotPage',
                'uses'      =>      'User\RegisterController@forgotPassword'
            ]
        );
        Route::post('/forgot-password/action',
            [
                'as'        =>      'forgotPageAction',
                'uses'      =>      'User\RegisterController@forgotPasswordAction'
            ]
        );

        Route::get('/reset-password/{codigoForgot}',
            [
                'as'        =>      'resetPage',
                'uses'      =>      'User\RegisterController@resetPassword'
            ]
        );
        Route::post('/reset-password/action',
            [
                'as'        =>      'resetAction',
                'uses'      =>      'User\RegisterController@resetPasswordAction'
            ]
        );

    });


  // Rutas Abiertas a todos  Logueados y no logueados


    Route::get('/',[
        'as'        =>      'homepage',
        'uses'      =>      'HomepageController@index'
    ]);

    Route::get('/imagen/auto/{imageId}/{size}',[
        'as'        =>      'mostrarAuto',
        'uses'      =>      'Image\ImageController@mostrarAuto'
    ]);

    Route::post('/coleccion/{idhw}/autos',[
        'as'        =>      'coleccionAutos',
        'uses'      =>      'Api\AutosController@getAll'
    ]);




});
