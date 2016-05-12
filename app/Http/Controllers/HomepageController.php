<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 3/16/16
 * Time: 1:39 AM
 */

namespace App\Http\Controllers;



use App\Http\Controllers\Auth\AuthMongoController;
use Illuminate\Support\Facades\Hash;

class HomepageController extends Controller
{

    public function index()
    {
       return view('home.index');
    }


}