<?php

namespace App\Http\Controllers\Complaint;

use App\Complaint;
use App\Http\Controllers\Images\ComplaintImage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

	/**
	 *
	 * Receives the post request and creates the new complaint
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function postCreate(Request $request)
	{
		$validator = Validator::make(Input::all(),[
			'story'=>'required',
			'typeComplaint'=>'required',
			'name'=>'required',
			'amount'=>'required',
			'dateLoan'=>'required',
			'image'=>'image|required'
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


	/**
	 * Show a create complaint template
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */

	public function createComplaint( Request $request)
	{
		return view('complaint.create');
	}


	/**
	 * Shows a complaint given the ID
	 * @param $id
	 * @param Request $request
	 * @return $this
	 */
	public function viewComplaint($id, Request $request)
	{
		$complaint = Complaint::findOrFail($id);
		return view('complaint.view')->with(['complaint'=>$complaint]);
	}

	/**
	 * Shows edits form given the ID
	 * @param $id
	 * @param Request $request
	 * @return $this
	 */
	public function editComplaint($id, Request $request)
	{
		$complaint = Complaint::findOrFail($id);
		if($complaint->user->id != Auth::user()->id){
			abort(404);
		}
		return view('complaint.edit')->with(['complaint'=>$complaint]);
	}


	/**
	 * Update a complaint previously edited
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postEditComplaint($id, Request $request)
	{
		$complaint = Complaint::findOrFail($id);
		if($complaint->user->id != Auth::user()->id){abort(404);}
		//validation
		$validator = Validator::make(Input::all(),[
			'story'=>'required',
			'typeComplaint'=>'required',
			'name'=>'required',
			'amount'=>'required',
			'dateLoan'=>'required',
			'image'=>'image'
		]);
		//validator
		if($validator->fails()){
			return back()->withErrors($validator)->withInput();
		}
		//save new complaint
		$storageFile = null;
		if( $request->hasFile('image') && $request->file('image')->isValid() ){
			$file = Input::file('image');
			//save new image
			$storageFile = ComplaintImage::put($file);
			//delete old image
			ComplaintImage::delete($complaint->photo);
			$complaint->photo 			= $storageFile;
		}
		//Update complaint model
		$complaint->story 			= $request->input('story',$complaint->story);
		$complaint->typeComplaint 	= $request->input('typeComplaint',$complaint->typeComplaint);
		$complaint->name 			= $request->input('name',$complaint->name);
		$complaint->amount			= $request->input('amount',$complaint->amount);
		$complaint->dateLoan		= $request->input('dateLoan',$complaint->dateLoan);
		$complaint->country			= $request->input('country',$complaint->country);
		$complaint->state			= $request->input('state',$complaint->state);
		$complaint->city			= $request->input('city',$complaint->city);
		$complaint->city2			= $request->input('city2',$complaint->city2);
		$complaint->facebook		= $request->input('facebook',$complaint->facebook);
		$complaint->twitter			= $request->input('twitter',$complaint->twitter);
		$complaint->email			= $request->input('email',$complaint->email);
		$complaint->save();

		return redirect()->route('getUserProfile',['name'=>str_slug(Auth::user()->name),'id'=>Auth::user()->id]);
	}


	/**
	 * Delete complaint
	 * @param $id
	 * @param Request $request
	 * @return mixed
	 */
	public function postDeleteComplaint($id,Request $request)
	{
		$complaint = Complaint::findOrFail($id);
		if($complaint->user->id != Auth::user()->id){abort(404);}

		$complaint->delete();
		return response()->json(['deleted with success'],Response::HTTP_OK);
	}
}