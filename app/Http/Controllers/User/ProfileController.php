<?php
/**
 * Created by PhpStorm.
 * User: jarriaga - jarriagabarron@gmail.com
 * Description: This class handle the profile section
 * Date: 10/21/15
 * Time: 1:16 PM
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Models\User;

class ProfileController extends Controller{

    /**
     * This method show the user's profile
     * @return \Illuminate\View\View
     */
    public function getIndex($username)
    {
        //We get the user information and remove the password and token from the response
        $user_profile   =   User::findBy(
            ['username'    =>  $username],
            ['password'  =>  false,'token'  =>  false,  'token' =>  false]
        );
        if(!$user_profile)
            Abort(404);
        //var_dump($user_profile);
        return view('user.profile',['user_profile'  =>  $user_profile]);
    }

} 