<?php

namespace App\Http\Controllers\Complaint;

use App\Complaint;
use App\Http\Controllers\Images\ComplaintImage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;

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
		$validator = Validator::make(Input::all(),[
			'story'=>'required',
			'typeComplaint'=>'required',
			'name'=>'required',
			'amount'=>'required',
			'dateLoan'=>'required',
			'image'=>'image'
			]);

		if($validator->fails()){
			return back()->withErrors($validator)->withInput();
		}

		if( $request->hasFile('image') && $request->file('image')->isValid() ){
			$file = Input::file('image');
			$storageFile = ComplaintImage::put($file);
		}

		$user = \App\User::find(Auth::user()->id);
		$user->complaints()->create(array_merge(Input::all(),['photo'=>(isset($storageFile))?$storageFile:null]));

		return redirect()->route('getUserProfile',['name'=>str_slug(Auth::user()->name),'id'=>Auth::user()->id]);

	}

	public function createComplaint( Request $request)
	{
		return view('complaint.create');
	}

}