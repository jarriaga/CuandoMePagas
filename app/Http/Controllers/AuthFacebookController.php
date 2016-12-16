<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;

class AuthFacebookController extends Controller
{

	/**
	 * This method generates the URL login direction
	 * @return mixed
	 */
	public function redirectToProvider()
	{
		return Socialite::driver('facebook')->redirect();
	}


	/**
	 * Obtain the user information from Facebook in order to create a new account
	 * using the facebook api.
	 *
	 * @return Response
	 */
	public function handleProviderCallback(Request $request)
	{
		try{
			//using the socialite driver
			$user = Socialite::driver('facebook')->user();

			session()->forget('fb_name');
			session()->forget('fb_facebookid');
			session()->forget('fb_profileImage');

			//get the info from the Facebook API
			$facebookId = $user->getId();
			$name = $user->getName();
			$email = $user->getEmail();
			$image = $user->getAvatar();
			//First step validate the facebook Id and log in if exists
			$user = User::where('facebookId',$facebookId)->first();
			if($user){
				Auth::login($user);
				return redirect('/home');
			}
			//Second validation verify the email and log in if exists
			$user = User::where('email',$email)->first();
			if($user){
				$user->facebookId = $facebookId;
				$user->save();
				Auth::login($user);
				return redirect('/home');
			}

			// If the user has not provided an email then return to
			// the route facebookUpdateEmail to ask for his email
			// once the email is submitted then create the user
			if(!$email){
				session([
					'fb_facebookid'=>$facebookId,
					'fb_name'=>$name,
					'fb_profileImage'=>$image]);
					return redirect()->route('facebookUpdateEmail');
			}
			//otherwise then create a new user with the information and log in that user
			// redirect to the dashboard
			$profileImage = ($image)? $this->saveImageFromUrl($image):null;
			$user = User::create([
				'name' => $name,
				'email' => $email,
				'facebookId'=>$facebookId,
				'profileImage'=>$profileImage
			]);
			//log in the new user
			Auth::login($user);
			return redirect('/home');

		}catch(RequestException $e){
			//if something is wrong, return to the login with flash error message
			$request->session()->flash('flash-error',trans('app.FacebookPermissionsFail'));
			return redirect('/login');
		}

	}

	/**
	 * This method shows the email form just for the facebook users
	 * who doesn't has email
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function facebookUpdateEmail(Request $request)
	{
		if(!session('fb_facebookid'))
			return redirect('/');
		return view('auth.facebookemail');
	}


	/**
	 * Receives the post method with the new email for the user
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function facebookUpdateEmailPost(Request $request)
	{
		if(!session('fb_facebookid'))
			return redirect('/');

		$validator = Validator::make($request->only('email'),['email'=>'required|email']);
		if($validator->fails())
			return redirect()->route('facebookUpdateEmail')->withInput()->withErrors($validator);

		//save and create the new user
		$profileImage = (session('fb_profileImage'))? $this->saveImageFromUrl(session('fb_profileImage')):null;

		$user =  User::create([
			'name' => session('fb_name'),
			'email' => $request->input('email'),
			'facebookId'=>session('fb_facebookid'),
			'profileImage'=>$profileImage
		]);
		//log in the user
		Auth::login($user);
		//erease the session
		session()->forget('fb_name');
		session()->forget('fb_facebookid');
		session()->forget('fb_profileImage');
		return redirect('/home');
	}

	/**
	 * This method save the profile image from facebook
	 * @param $url
	 * @return string
	 */
	private function saveImageFromUrl($url)
	{
		$filename = str_random(10) . '.jpg';
		//resize to 200px
		$image = Image::make(str_replace('normal','large',$url))->fit(200);
		Storage::disk('public')->put('profiles/' . $filename, $image->stream('jpg'));
		return $filename;
	}


}
