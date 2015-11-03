<?php
/**
 * Created by PhpStorm.
 * User: jarriaga - jarriagabarron@gmail.com
 * This is Signup Controller to handle login signup
 * Date: 10/2/15
 * Time: 1:00 AM
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Models\User;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller {

    /**
     * Url method GET signup form
     * @return \Illuminate\View\View
     */
    public function getIndex(Request $request)
    {

        $fb             =       $this->fbInit();
        $helper         =       $fb->getRedirectLoginHelper();
        $permissions    =       ['email'];
        $loginUrl       =       $helper->getLoginUrl('http://'.$_SERVER['SERVER_NAME'].'/facebook',$permissions);
        $error          =       ($request->session()->get('error',null))?'Debes aceptar los permisos de facebook para registrarte':null;
        return view('user.signup',['loginUrl'=>$loginUrl,'reject_app'=>$error]);
    }

    /**
     * Url method POST receive all request and process a new user registration
     * @param SignupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSaveUser(SignupRequest $request)
    {
        $user       =       new User();
        $user->fill($request->all());
        if(!$user->save())
            new \Exception('No se pudo crear la cuenta');

        Auth::login($user);
        return redirect()->route('homepage');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function getLoginFacebook(Request $request)
    {
        $fb             =       $this->fbInit();
        $helper         =       $fb->getRedirectLoginHelper();
        //validate if accept the app
        if($helper->getError()){
            $request->session()->flash('error','reject_app');
            return redirect()->route('signup');
        }

        try{
            $token      =       $helper->getAccessToken();
            $response = $fb->get('/me?fields=id,name,first_name,last_name,email', $token);
        }catch(FacebookResponseException $e){
            $request->session()->flash('error','reject_app');
            return redirect()->route('signup');
        }catch(FacebookSDKException $e){
            $request->session()->flash('error','reject_app');
            return redirect()->route('signup');
        }

        $fbResponse = $response->getGraphUser();
        $data   =   [
            'facebook_id'   =>  $fbResponse['id'],
            'firstname'     =>  isset($fbResponse['first_name'])?$fbResponse['first_name']:null,
            'lastname'      =>  isset($fbResponse['last_name'])?$fbResponse['last_name']:null,
            'email'         =>  isset($fbResponse['email'])?$fbResponse['email']:null,
        ];

        //find by Id Facebook, if found then login that user
        if($result = User::findByFacebookId($fbResponse['id']))
        {
            Auth::loginUsingId($result->getAuthIdentifier());
            return redirect()->intended('/profile/'.$result->username);
        }
        //find by email, if found then login that user
        if($data['email']   &&  $result = User::findBy(['email'=>$data['email']])){
            $result->facebook_id = $data['id'];
            Auth::loginUsingId($result->getAuthIdentifier());
            return redirect()->intended('/profile/'.$result->username);
        }
        //if the user is new then a new user is created and logged in
        $user       =       new User();
        $user->fill($data);
        if(!$user->save())
            new \Exception('No se pudo crear la cuenta');
        Auth::login($user);
        return redirect()->intended('/profile/'.$result->username);
    }

    /**
     * This method logout a user and redirect to the homepage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getUserLogout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }

    /**
     * This method initialize the facebook SDK
     * @return Facebook
     */
    private function fbInit()
    {
        session_start();
        return new Facebook([
            'app_id'        =>      env('FB_API_ID'),
            'app_secret'    =>      env('FB_API_SECRET'),
            'default_graph_version' =>  'v2.4',
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getLogin(Request $request)
    {
        $fb             =       $this->fbInit();
        $helper         =       $fb->getRedirectLoginHelper();
        $permissions    =       ['email'];
        $loginUrl       =       $helper->getLoginUrl('http://'.$_SERVER['SERVER_NAME'].'/facebook',$permissions);
        $error          =       ($request->session()->get('error',null))?'Debes aceptar los permisos de facebook para registrarte':null;
        return view('user.login',['loginUrl'=>$loginUrl,'reject_app'=>$error]);
    }


    /**.
     * This method receive the user credentials in order to log in
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAuthLogin(LoginRequest $request)
    {
       $array  =   $request->all();
       if (Auth::attempt(['email' => $array['email'], 'password' => $array['password']]))
            return redirect()->intended('/profile/'.$result->username);

        Session::flash('notify',[
            'type'=>'error',
            'text'=>'El usuario y/o password es incorrecto'
        ]);
        return  redirect()->route('login')->withInput($request->except('password'));

    }

    /**
     * This method shows the forget password form
     * @return \Illuminate\View\View
     */
    public function getForgetPassword()
    {
        return view('user.forgetPassword');
    }

    /**
     * This method create the token & expire time, send the email and return
     * to the initial view
     * @param ForgetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postForgetPassword(ForgetRequest $request)
    {
        //we have the user
        $user   =   User::findBy(['email'=>$request->input('email')]);
        //If the user not exists then return the error
        if(!$user) {
            Session::flash('notify', [
                'type' => 'error',
                'text' => 'El email que ingresaste no esta registrado en el sistema'
            ]);
            return redirect()->route('forgetPassword');
        }
        //create the resetpassword field with the token and 1 hour plus expiration
        $user->resetPassword = [
            'reset_token' => str_random(52),
            'expiresAt' => new \MongoDate(time()+3600)
        ];
        //save the user
        $user->save();
        //send the email with the informacion
        Mail::send('mailing.resetpassword',['nombre'=>$user->firstname,'reset_token'=>'http://'.$_SERVER['SERVER_NAME'].'/reset-password/code/'.$user->resetPassword['reset_token']], function($message) use ($user){
            $message->from('no-reply@mg.cuandomepagas.com','CuandoMePagas.com');
            $message->to($user->email);
            $message->subject('Olvidaste tu password');
        });

        Session::flash('notify',[
            'type'=>'success',
            'text'=>'Revisa tu email, te hemos enviado los pasos para crear tu nuevo password'
        ]);
        return redirect()->route('login');
    }


    public function getResetPassword($code)
    {
        $code   =   FILTER_VAR($code,FILTER_SANITIZE_STRING);
        $code   =   strip_tags($code);
        $code   =   htmlspecialchars($code);

        $validator =    Validator::make(['code'=>$code],['code'=>'alpha_num']);
        if($validator->fails())
            abort(404);

        //Find the user using the reset_token code and
        //only if the expiration date is lower than the new date
        $user   =   User::findBy(   [
            'resetPassword.reset_token'     =>      $code ,
            'resetPassword.expiresAt'       =>      [   '$gt'   =>  new \MongoDate(time())   ] ]);

        if(!$user)
            abort(404);

        return  view('user.resetPassword',['code'=>$code]);
        //var_dump($user);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postResetPassword(ResetPasswordRequest $request)
    {
        $code   =   $request->input('code');

        $validator =    Validator::make(['code'=>$code],['code'=>'alpha_num']);
        if($validator->fails())
            abort(404);
        //Find the user using the reset_token code and
        //only if the expiration date is lower than the new date
        $user   =   User::findBy(   [
            'resetPassword.reset_token'     =>      $code ,
            'resetPassword.expiresAt'       =>      [   '$gt'   =>  new \MongoDate(time())   ] ]);

        if(!$user)
            abort(404);

        // Save new password & remove reset password token
        $user->password = Hash::make($request->input('password'));
        $user->resetPassword = null;
        $user->save();

        Session::flash('notify',[
            'type'=>'success',
            'text'=>'Tu password se ha cambiado exitosamente'
        ]);

        return redirect()->route('login');
    }

}