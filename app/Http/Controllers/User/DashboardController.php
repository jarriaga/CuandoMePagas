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

class DashboardController extends Controller {

    /**
     * This method show the user's dashboard
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('user.dashboard');
    }

} 