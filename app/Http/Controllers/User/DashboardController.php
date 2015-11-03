<?php
/**
 * Created by PhpStorm.
 * User: jarriaga - jarriagabarron@gmail.com
 * Description: this class handle the dashboard section to show all metrics, info,
 * and more features for you league as admin or player
 * Date: 10/21/15
 * Time: 1:18 PM
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\User;

class DashboardController extends Controller {

    /**
     * This method show the user's dashboard
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        //We get the user information and remove the password and token from the response
        $user_profile   =   User::findBy(
            ['_id'    =>  Auth::user()->_id],
            ['password'  =>  false,'token'  =>  false,  'token' =>  false]
        );
        if(!$user_profile)
            Abort(404);

        return view('user.dashboard',['user_profile'  =>  $user_profile]);
    }

} 