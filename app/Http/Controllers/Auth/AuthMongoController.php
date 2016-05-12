<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 3/16/16
 * Time: 12:16 AM
 */

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthMongoController
{
    private static $user;

    /**
     * Regresa el usuario logueado
     */
    public static function user()
    {
        $usuario = session('auth')?unserialize( session('auth') ) :null;
        return $usuario;
    }

    /**
     * Regresa true o false si un usuario esta logueado
     */
    public static function check()
    {
        $usuario = session('auth')? unserialize( session('auth') ) :null;
        if($usuario && $usuario->getId())
            return true;

        return false;
    }

    /**
     * Cierra la sesion de un usuario
     */
    public static function logout()
    {
        Session::forget('auth');
        return true;
    }

    /**
     * Login con un usuario especifico
     * @param $usuario
     */
    public static function login($usuario)
    {
        session(['auth'=>serialize($usuario)]);
        return true;
    }

}