<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 10/6/16
 * Time: 11:46 PM
 */

namespace App\Http\Controllers\Profile;


use App\Http\Controllers\Controller;
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
		$countries = include_once __DIR__.'/../../Functions/Countries.php';
		return view('user.editUserProfile')->with(['user'=>$user,'countries'=>$countries]);
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
		$user->categories()->detach();
		if($request->input('categories') && is_array($request->input('categories'))){
			$user->categories()->attach($request->input('categories'));
		}
		//dd($request->all());
		try{
			//If has file
			if ($request->hasFile('profilePicture') && $request->file('profilePicture')->isValid()) {
				//validate if the uploaded file is an image
				$validator = Validator::make($request->only(['profilePicture']),
					['profilePicture'=>'image']);

				if($validator->fails())
					return back()->withInput()->withErrors($validator);

				//save temp file
				$filename = Storage::putFile('public/profiles', Input::file('profilePicture'));
				//resize to 200px
				$image = Image::make ( storage_path().'/app/'.$filename )->orientate();
				$image =$image->fit(200);
				//delete the temp file
				Storage::delete($filename);
				//save the new user file
				$filename = str_random(10) . '.jpg';
				Storage::disk('public')->put('profiles/' . $filename, $image->stream('jpg', 70));

				//Delete the old image
				if($user->profileImage && Storage::disk('public')->exists('profiles/'.$user->profileImage))
					Storage::disk('public')->delete('profiles/'.$user->profileImage);
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
		$user->profileImage = isset($filename)?$filename:$user->profileImage;
		$user->save();


		$request->session()->flash('flash-success',trans('app.ProfileSaveSuccess') );

		return redirect()->route('getUserProfile',['name'=>str_slug($user->name),'id'=>$user->id]);
	}

}