<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 3/23/16
 * Time: 9:45 PM
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Auth\AuthMongoController;
use App\Http\Controllers\Controller;
use App\Http\Odm\Documents\Auto;
use App\Http\Odm\Documents\FotoAuto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;

class ColeccionPrivadaController extends Controller
{
    /**
     * Coleccion privada index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $dm         =       App::make('ODM');
        $usuario =  $dm->getRepository('App\Http\Odm\Documents\Usuario')->findOneBy(['id'=>AuthMongoController::user()->getId()]);
        return view('user.coleccion.coleccionPrivada')
            ->with(['last5autos'=>$usuario->getLast5autos(),'numeroAutos'=>$usuario->getNumeroAutos()]);
    }

    /**
     * Agregar auto nuevo page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function agregarCarro()
    {
        $dm         =       App::make('ODM');
        $usuario =  $dm->getRepository('App\Http\Odm\Documents\Usuario')->findOneBy(['id'=>AuthMongoController::user()->getId()]);
        //Doctrine manager
        return view('user.coleccion.agregarCarro')->with(['last5autos'=>$usuario->getLast5autos(),'numeroAutos'=>$usuario->getNumeroAutos()]);
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), ['foto'      =>      'image|required', 'idFile'    =>      'numeric']);
        if($validator->fails()){
            return response()->json(['error'=>'fail'],400);
        }
        $manager    =   new ImageManager();
        $image      =   $manager->make($request->file('foto'))->orientate();
        $filename   =   AuthMongoController::user()->getId().'-'.$request->input('idFile');
        $image->widen(600);
        Storage::disk('local')->put('temp/new-cars/'.$filename.'.jpg',$image->stream());
        return response()->json(['ok'=>'saved'],200);
    }

    /**
     * Elimina una imagen recien creada
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeImage(Request $request)
    {
        $validator = Validator::make($request->all(), ['idFile'    =>      'numeric']);

        if($validator->fails())
            return response()->json(['error'=>'fail'],400);

        $filename   =   AuthMongoController::user()->getId().'-'.$request->input('idFile');
        Storage::delete('temp/new-cars/'.$filename.'.jpg');

        return response()->json(['ok'=>$request->input('idFile')],200);
    }


    /**
     * Metodo que agrega un auto nuevo a la colección
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function agregarCarroAction(Request $request)
    {
        //Leemos las fotos
        $filesFotos     =       explode(",",$request->input('files'));
        if(!$request->input('nombre'))
            abort(404);
        //Doctrine manager
        $dm         =       App::make('ODM');
        //Creamos el auto y su detalle
        $auto       =       new Auto();
        $auto->setNombre($request->input('nombre',null));
        $auto->setEmpaque($request->input('empaque',null));
        $auto->setDescripcion($request->input('descripcion',null));
        $auto->setMarca($request->input('marca',null));
        //creamos las fotos de los autos
        foreach($filesFotos as $f){
            $filename   =   AuthMongoController::user()->getId().'-'.str_replace('foto-','',$f);
            try{
                Storage::move('temp/new-cars/'.$filename.'.jpg','public/autos/'.$filename.'.jpg');
            }catch( \ErrorException $e ){

            }
            $foto   =   new FotoAuto();
            $foto->setFilename($filename);
            $foto->setSelected(false);
            $auto->setFotos($foto);
        }
        //asignamos el auto al usuario correspondiente
        $usuario =  $dm->getRepository('App\Http\Odm\Documents\Usuario')->findOneBy(['id'=>AuthMongoController::user()->getId()]);
        $auto->setUsuario($usuario);
        $auto->createdAt();
        $auto->updatedAt();
        //salvamos el auto
        $dm->persist($auto);
        $dm->flush();
        Session::flash('notify',[
            'type'=>'success',
            'text'=>'El Auto fue creado exitosamente'
        ]);
        return  redirect()->route('agregarCarro');
    }

    /**
     * Muestra la informacion de un auto especifico y que pertenezca
     * al Usuario dueño de ese auto
     * @param $idAuto
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function mostrarUnAutoPrivado($idAuto)
    {
        $validator  =   Validator::make(['idAuto'=>$idAuto],
            [
                'idAuto'    =>  'required|alpha_num'
            ]
        );

        if($validator->fails()) {
            Session::flash('notify',[
                'type'=>'error',
                'text'=>'No existe el auto'
            ]);
            return redirect()->route('coleccionPrivada');
        }

        $dm     =       App::make('ODM');

        $usuario    =   $dm->getRepository('App\Http\Odm\Documents\Usuario')
            ->findOneBy(['id'=>AuthMongoController::user()->getId()]);
        $auto = $dm->createQueryBuilder('App\Http\Odm\Documents\Auto')
            ->field('usuario')->references($usuario)
            ->field('id')->equals($idAuto)
            ->getQuery()
            ->getSingleResult();

        if(!$auto){
            Session::flash('notify',[
                'type'=>'error',
                'text'=>'No existe el auto'
            ]);
            return redirect()->route('coleccionPrivada');
        }

        return view('user.coleccion.mostrarAutoPrivado')->with(['auto'=>$auto]);

    }
}