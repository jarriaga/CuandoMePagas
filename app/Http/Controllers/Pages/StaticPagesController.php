<?php
/**
 * Created by PhpStorm.
 * User: jarriaga
 * Date: 11/2/15
 * Time: 4:57 PM
 */

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class StaticPagesController extends Controller {

    public function getAboutPage()
    {
        return view('static_pages.about');
    }

} 