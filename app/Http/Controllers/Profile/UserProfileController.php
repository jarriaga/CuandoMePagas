<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 10/6/16
 * Time: 11:46 PM
 */

namespace App\Http\Controllers\Profile;


use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Images\ProfileImage;
use App\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class UserProfileController extends Controller
{

	/**
	 * This method show the user's profile page
	 * @param $id
	 * @param Request $request
	 * @return $this
	 */
	public function getUserProfile($name, $id, Request $request)
	{
		$user = User::findOrFail($id);
		//if the user is login, review is this is the profile's owner
		$owner = (Auth::check() && Auth::user()->id == $user->id)?true:false;
		//return the view
		return view('user.profile')->with(['user'=>$user,'owner'=>$owner]);
	}

	/**
	 * This method shows the profile's edit page
	 * @param $name
	 * @param $id
	 * @param Request $request
	 * @return $this
	 */
	public function editUserProfile($name, $id, Request $request)
	{
		$user = User::findOrFail($id);
		if(Auth::user()->id != $user->id)
			abort(404);
		//get the countres names
		//$countries = include_once __DIR__.'/../../Functions/Countries.php';
		return view('user.editUserProfile')->with(['user'=>$user]);
	}


	/**
	 * This method update and save all the changes into the profile's user
	 * and return to the user's profile page
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postUpdateProfile(Request $request)
	{
		$validator = Validator::make($request->only(['name']),
				[
					'name'=>'required'
				]);


		if($validator->fails())
			return back()->withInput()->withErrors($validator);

		//Find the user if exist before update
		$user = User::findOrFail(Auth::user()->id);
		/*   save categories
		$user->categories()->detach();
		if($request->input('categories') && is_array($request->input('categories'))){
			$user->categories()->attach($request->input('categories'));
		}*/
		try{
			//If has file
			if ($request->hasFile('profilePicture') && $request->file('profilePicture')->isValid()) {
				//validate if the uploaded file is an image
				$validator = Validator::make($request->only(['profilePicture']),
					['profilePicture'=>'image']);

				if($validator->fails())
					return back()->withInput()->withErrors($validator);

				$fileName = ProfileImage::put(Input::file('profilePicture'));

				//Delete the old image
				if($user->profileImage && ProfileImage::exist($user->profileImage))
					ProfileImage::delete($user->profileImage);
			}
		}catch( \Exception $error){
			Log::error($error->getMessage());
			return back()->withInput()->withErrors(array('message' => trans('app.Error505')));
		}

		//Save the user data
		$user->name = $request->input('name',$user->name);
		$user->aboutMe = $request->input('aboutMe',$user->aboutMe);
		$user->country = $request->input('country',$user->country);
		$user->state = $request->input('state',$user->state);
		$user->city = $request->input('city',$user->city);
		$user->city2 = $request->input('city2',$user->city);
		$user->birthday = (empty($request->input('birthday')))?null:$request->input('birthday');
		$user->profileImage = isset($fileName)?$fileName:$user->profileImage;
		$user->save();


		$request->session()->flash('flash-success',trans('app.ProfileSaveSuccess') );

		return redirect()->route('getUserProfile',['name'=>str_slug($user->name),'id'=>$user->id]);
	}

}