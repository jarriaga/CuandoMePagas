<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 3/13/16
 * Time: 2:26 PM
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Auth\AuthMongoController;
use App\Http\Controllers\Controller;
use App\Http\Odm\Documents\Usuario;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Tracy\Debugger;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{

    /**
     * Metodo que muestra la pagina de registro
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAction(Request $request)
    {
        $fb             =       $this->fbInit();
        $helper         =       $fb->getRedirectLoginHelper();
        $permissions    =       ['email','user_friends'];
        $loginUrl       =       $helper->getLoginUrl(URL::to('/').'/facebook',$permissions);
        $error          =       ($request->session()->get('error',null))?'Debes aceptar los permisos de facebook para registrarte':null;
        return view('user.signup',['loginUrl'=>$loginUrl,'reject_app'=>$error]);
    }


    /**
     * Metodo para crear un nuevo usuario en el sistema
     * @param Request $request
     * @return $this
     */
    public function signUpAction(Request $request)
    {
        //  Reglas y mensajes de validador
        $validator  =    Validator::make(
            $request->all(),
            [   'email'             =>      'required|email',
                'firstname'         =>      'required',
                'password'          =>      'required'
            ],
            [
                'email.required'    =>      'El email es requerido',
                'email.email'       =>      'El email que ingresaste no es valido',
                'firstname.required'=>      'Debe ingresar un nombre',
                'password.required' =>      'El password debe ser ingresado'
            ]);
        //  Si falla entonces retornamos los errores
        if($validator->fails())
            return  redirect()->route('signUpPage')->withErrors($validator)->withInput();
        //arreglo de los datos del usuario
        $dataUsuario  = [
                            'email'         =>  trim($request->input('email')),
                            'firstname'     =>  $request->input('firstname'),
                            'password'      =>  $request->input('password'),
                            'activationCode'=>  str_random(32)
                        ];
        $usuario    =   $this->returnUser($dataUsuario);
        //si el usuario no esta lo insertamos en la base
        if(!$usuario){
            if($nuevoUsuario = $this->createUserEmail($dataUsuario)){
                Session::flash('notify',[
                    'type'=>'success',
                    'text'=>'Tu cuenta ha sido creada exitosamente'
                ]);
                //si la cuenta se crea, retornamos a la pagina de AVISO DE ACTIVACION
                return redirect()->route('aviso-verificarCuenta');
            }
            Session::flash('notify',[
                'type'=>'error',
                'text'=>'Hubo un error al registrarte al sistema'
            ]);
            return redirect()->route('signUpPage')->withInput();
        }
        $validator->getMessageBag()->add('email', 'El usuario ya esta registrado.');
        return redirect()->route('signUpPage')->withInput()->withErrors($validator);
    }

    /**
     * Metodo que nos muestra la pagina de login
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logInPage(Request $request)
    {
        $fb             =       $this->fbInit();
        $helper         =       $fb->getRedirectLoginHelper();
        $permissions    =       ['email','user_friends'];
        $loginUrl       =       $helper->getLoginUrl(URL::to('/').'/facebook',$permissions);
        $error          =       ($request->session()->get('error',null))?'Debes aceptar los permisos de facebook para registrarte':null;
        return view('user.login',['loginUrl'=>$loginUrl,'reject_app'=>$error]);
    }

    /**
     * Metodo que recibe el POST de la pagina de login via formulario
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function logInAction(Request $request)
    {
        $validator  =   Validator::make($request->all(),
            [
                'email'             =>      'required|email',
                'password'          =>      'required'
            ],
            [
                'email.required'    =>      'El email es requerido',
                'email.email'       =>      'El email no es valido',
                'password.required' =>      'El password es requerido'
            ]
        );
        //Si no pasa la validacion retorna el error
        if( $validator->fails()  )
            return  redirect()->route('logInPage')->withErrors($validator)->withInput();
        //  Cargamos el Doctrine mongo
        $dm     =   App::make('ODM');
        //buscamos el usuario por el correo
        $usuario = $dm
                            ->getRepository('App\Http\Odm\Documents\Usuario')
                            ->findOneBy( ['email'=> trim($request->input('email')),'accountEnable'=>true] );
        // si el usuario es encontrado y checamos que el password sea valido entonces hacemos logIn
        if( $usuario &&  Hash::check($request->input('password'),$usuario->getPassword()) ){
            if(!$usuario->getIdhw()){
                $usuario->setIdhw(str_random(10));
                $dm->persist($usuario);
                $dm->flush();
            }
            //loguear al usuario y redireccionar a la pagina de perfil
            AuthMongoController::login($usuario);
            return redirect()->route('homepage');
        }
        //Retornamos el error si no fue valido el password o no se encontro el usuario
        $validator->getMessageBag()->add('email', 'El usuario y/o contraseña es incorrecta.');
        return redirect()->route('logInPage')->withInput()->withErrors($validator);
    }

    /**
     * Metodo para hacer logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logOutAction()
    {
        AuthMongoController::logout();
        return  redirect()->route('homepage');
    }


    /**
     * Metodo que nos muestra la pagina "olvidaste tu contraseña"
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forgotPassword(Request $request)
    {
        if($request->input('send',0)){
            return view('user.instruccionesForgot');
        }
        return view('user.forgotPassword');
    }


    /**
     * Metodo que procesa y envia el email al usuario para recuperar su password
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forgotPasswordAction(Request $request)
    {
        $validator  =   Validator::make($request->all(),
            [
                'email'         =>      'required|email'
            ],
            [
                'email.required'    =>      'Por favor ingresa tu email',
                'email.email'       =>      'El email no es valido'
            ]
        );

        if($validator->fails())
            return  redirect()->route('forgotPage')->withErrors($validator)->withInput();

        //  Cargamos el Doctrine mongo
        $dm     =   App::make('ODM');
        //buscamos el usuario por el codigo de activacion
        $usuario = $dm
            ->getRepository('App\Http\Odm\Documents\Usuario')
            ->findOneBy( ['email'=>trim($request->input('email')),'accountEnable'=>true] );

        if(!$usuario) {
            return redirect('/forgot-password?send=1');
        }
        //Create a forgotCode
        $codigoForgot   =   str_random(24);
        $usuario->setForgotCode( $codigoForgot );
        $usuario->setForgotAt();
        $dm->persist($usuario);
        $dm->flush();
        //Send email
        Mail::send('email.forgotInstruction',
            ['firstname' => $usuario->getFirstname(), 'code' => $codigoForgot,'hostname'=>URL::to('/')],
            function ($message) use ($usuario) {
                $message->from('no-reply@hotwheelsmx.com', 'Hot Wheels MX');
                $message->to($usuario->getEmail(), $usuario->getFirstname());
                $message->subject('Olvidaste tu Password?');
            });
        return redirect('/forgot-password?send=1');
    }


    /**
     * Metodo que muestra el formulario para resetear el codigo, tambien maneja el mensaje de confirmacion
     * y el mensaje de error
     * @param $codigoForgot
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPassword($codigoForgot)
    {
        $validator = Validator::make(['codigo'=>$codigoForgot],[
            'codigo' => 'required|alpha_num'
        ]);
        //si falla la validacion abortamos
        if($validator->fails())
            abort(404);
        //si recibimos OK, mostramos mensaje de confirmacion
        if($codigoForgot==='ok')
            return  view('user.resetPasswordOk');
        //si recibimos error, abortamos y no se encontro la pagina
        if($codigoForgot==='error')
            abort(404);
        // de otra forma retornamos el formulario de password y el codigo
        return view('user.resetPassword',['code'=>$codigoForgot]);
    }


    /**
     * Metodo que verifica el codigo para resetear password y actualiza el nuevo
     * password en la base de datos
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resetPasswordAction(Request $request)
    {
        $validator = Validator::make($request->all(),
                [
                    'password'          =>      'required|same:retype_password',
                    'retype_password'   =>      'required'
                ],
                [
                    'password.required'         =>      'El password es requerido',
                    'retype_password.required'  =>      'Confirma el password',
                    'password.same'             =>      'El password no coincide'
                ]
            );
        //si falla la validacion abortamos
        if($validator->fails())
            return  redirect()->route('resetPage',['codigoForgot'=>$request->input('code')])->withErrors($validator)->withInput();

        $actualDate     =   new   \DateTime('NOW');
        $actualDate->modify('-1 day');
        //  Cargamos el Doctrine mongo
        $dm         =   App::make('ODM');
        $usuario    =   $dm->getRepository('App\Http\Odm\Documents\Usuario')
            ->findOneBy(
                [
                    'forgotCode'=>$request->input('code'),
                    'forgotAt'=>['$gt'=>$actualDate]
                ]);
        //si se encontro el usuario entonces
        if($usuario){
            //actualizamos password, update, removemos codigo y fecha, y guardamos
            $usuario->updatedAt();
            $usuario->setPassword(Hash::make($request->input('password')));
            $usuario->setForgotCode(null);
            $usuario->removeForgotAt();
            $dm->persist($usuario);
            $dm->flush();
        }else{
            //si no se encontro el usuario, mandamos error
            return redirect('/reset-password/error');
        }
        // si tod estuvo bien, retornamos el mensaje de OK
        return redirect('/reset-password/ok');
    }


    /**
     * Metodo que busca si existe un usuario especifico por su email
     * @param null $request
     * @param null $facebookData
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function returnUser($data = null, $facebookData = null)
    {
        $dm     =   App::make('ODM');
        if($facebookData){
            //si existen datos de facebook entonces verificamos con facebook primero
            $existeUsuario = $dm->getRepository('App\Http\Odm\Documents\Usuario')->findOneBy(['facebookID'=> $data['facebookID']]);
            if($existeUsuario)
                return $existeUsuario;
        }
        $existeUsuario = $dm->getRepository('App\Http\Odm\Documents\Usuario')->findOneBy( ['email' =>  $data['email']] );
        return  $existeUsuario;
    }


    /**
     * Crea un nuevo usuario basado en el registro via email
     * @param $data
     * @return bool
     */
    private function createUserEmail($data)
    {
        try{
            //  Cargamos el Doctrine mongo
            $dm     =   App::make('ODM');
            //si no existe el usuario lo creamos
            //  Creamos un nuevo documento
            $usuarioNuevo    =   new Usuario();
            $usuarioNuevo->setEmail(     (isset($data['email']))?$data['email']:null     );
            if(isset($data['facebookID']))
                $usuarioNuevo->setFacebookID($data['facebookID']);
            $usuarioNuevo->setFirstname( $data['firstname']    );
            if(!isset($data['facebookID']))
            $usuarioNuevo->setPassword(  Hash::make( $data['password']) );
            if(!isset($data['facebookID']))
            $usuarioNuevo->setActivationCode( $data['activationCode'] );
            if(!isset($data['facebookID']))
                $usuarioNuevo->setAccountEnable(false);
            else
                $usuarioNuevo->setAccountEnable(true);

            $usuarioNuevo->setIdhw(str_random(10));

            //  Guardamos y limpiamos
            $usuarioNuevo->createdAt();
            $dm->persist($usuarioNuevo);
            $dm->flush();

            //Si se registro por EMAIL enviamos los datos de activacion
            if(!isset($data['facebookID'])) {
                Mail::send('email.activacionCuenta',
                    ['activationCode' => $data['activationCode'], 'email' => $data['email'], 'firstname' => $data['firstname'],'hostname'=>URL::to('/')],
                    function ($message) use ($data) {
                        $message->from('no-reply@hotwheelsmx.com', 'Hot Wheels MX');
                        $message->to($data['email'], $data['firstname']);
                        $message->subject('Activa tu cuenta ahora');
                    });
            }else {
                //Si se registro via Facebook , enviamos un correo de agradecimiento
                Mail::send('email.graciasRegistro',
                    ['email' => $data['email'], 'firstname' => $data['firstname'],'hostname'=>URL::to('/')],
                    function ($message) use ($data) {
                        $message->from('no-reply@hotwheelsmx.com', 'Hot Wheels MX');
                        $message->to($data['email'], $data['firstname']);
                        $message->subject('Hey, gracias por registrarte');
                    });
            }
            return $usuarioNuevo;
        }catch(\ErrorException $e){
            return false;
        }
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
            'default_graph_version' =>  'v2.5',
        ]);

    }

    /**
     * Metodo que muestra el aviso de verificacion de cuenta
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avisoVerificacion()
    {
        return view('user.verificarCuenta');
    }

    /**
     * Metodo que activa un usuario identificado con su codigo de activacion
     * @param $codigoDeActivacion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activar($codigoDeActivacion)
    {
        $validator = Validator::make(['codigo'=>$codigoDeActivacion],[
            'codigo' => 'required|alpha_num'
        ]);
        //si falla la validacion abortamos
        if($validator->fails())
            abort(404);

        //  Cargamos el Doctrine mongo
        $dm     =   App::make('ODM');
        //buscamos el usuario por el codigo de activacion
        $existeUsuario = $dm->getRepository('App\Http\Odm\Documents\Usuario')->findBy( ['activationCode'=>$codigoDeActivacion,'accountEnable'=>false] );
        //si el usuario no existe con ese codigo abortamos
        if(!$existeUsuario)
            abort(404);

        $existeUsuario[0]->setAccountEnable(true);
        $existeUsuario[0]->setActivationCode(null);
        $dm->flush();

        Session::flash('notify',[
            'type'=>'success',
            'text'=>'Tu cuenta esta activada, ahora puedes ingresar'
        ]);
        //si la cuenta se crea, retornamos a la pagina de AVISO DE ACTIVACION
        return redirect()->route('logInPage');
    }

    /**
     * SignUp accion para loguear o crear usuario con Facebook
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function signUpActionFacebook(Request $request)
    {
        $fb             =       $this->fbInit();
        $helper         =       $fb->getRedirectLoginHelper();
        //validamos si se aceptó la aplicacion
        if($helper->getError()){
            $request->session()->flash('error','reject_app');
            return redirect()->route('signUpPage');
        }
        //Obtenemos el token
        try{
            $token      =       $helper->getAccessToken();
            //Obtenemos los parametros de la consulta opengraph
            $response = $fb->get('/me?fields=id,name,first_name,last_name,email', $token);
        }catch(FacebookResponseException $e){
            $request->session()->flash('error','reject_app');
            return redirect()->route('signUpPage');
        }catch(FacebookSDKException $e){
            $request->session()->flash('error','reject_app');
            return redirect()->route('signUpPage');
        }
        //leemos la respuesta de facebook y la asignamos al arreglo de datos
        $fbResponse = $response->getGraphUser();
        $dataUsuario   =   [
            'facebookID'    =>  $fbResponse['id'],
            'firstname'     =>  isset($fbResponse['first_name'])?$fbResponse['first_name']:null,
            'email'         =>  isset($fbResponse['email'])?$fbResponse['email']:null
        ];

        $usuario    =   $this->returnUser($dataUsuario);
        //si el usuario no esta lo insertamos en la base
        $loguearUsuario = false;
        if(!$usuario){
            if($usuario = $this->createUserEmail($dataUsuario)){
                Session::flash('notify',[
                    'type'=>'success',
                    'text'=>'Tu cuenta ha sido creada exitosamente'
                ]);
                // Bandera de logueo
                $loguearUsuario =   true;
            }else {
                Session::flash('notify', [
                    'type' => 'error',
                    'text' => 'Hubo un error al registrarte al sistema'
                ]);
                return redirect()->route('signUpPage')->withInput();
            }
        }
        //Si el usuario tiene facebookID, se encontró por email
        if(!$usuario->getFacebookID()) {
            //  Cargamos el Doctrine mongo
            $dm = App::make('ODM');
            //actualizamos el facebookID
            $usuario->setFacebookID($dataUsuario['facebookID']);
            $usuario->setActivationCode(null);
            $usuario->updatedAt();
            //salvamos
            $dm->persist($usuario);
            $dm->flush();
        }

        if($loguearUsuario || $usuario){
            if(!$usuario->getIdhw()){
                $dm = App::make('ODM');
                $usuario->setIdhw(str_random(10));
                $dm->persist($usuario);
                $dm->flush();
            }
            AuthMongoController::login($usuario);
            //loguear al usuario y redireccionar a la pagina de perfil
            return redirect()->route('homepage');
        }

        Session::flash('notify', [
            'type' => 'error',
            'text' => 'Hubo un error al registrarte al sistema'
        ]);
        return redirect()->route('signUpPage')->withInput();
    }




}