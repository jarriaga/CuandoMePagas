<?php

namespace App\Http\Controllers\Complaint;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 12/31/16
 * Time: 12:50 PM
 */
class ComplaintController extends Controller
{


	public function postCreate(Request $request)
	{
			dd(Input::all());
	}

	public function createComplaint($id, Request $request)
	{
		$user = User::findOrFail($id);
		//if the user is login, review is this is the profile's owner
		$owner = (Auth::check() && Auth::user()->id == $user->id)?true:false;
		//return the view
		return view('complaint.create')->with(['user'=>$user,'owner'=>$owner]);
	}

}