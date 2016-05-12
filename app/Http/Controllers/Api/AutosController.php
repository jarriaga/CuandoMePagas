<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 4/5/16
 * Time: 9:59 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;


class AutosController extends Controller
{

    /**
     * Obtiene la lista de autos que tiene un usuario especifico
     * @param Request $request
     * @param $param
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll( Request $request,$param)
    {
        $request->request->set('idhw',$param);
        $idhw         =       $request->input('idhw');
        $pagina       =    (int) $request->input('pagina',1);
        $mostrar      =       12;

        $validator      =   Validator::make($request->all(),
            ['idhw'     =>      'required|alpha_num']
        );

        if($validator->fails()){
            return response()->json(['error'=>''],404);
        }

        $dm         =   App::make('ODM');
        $usuario    =   $dm->getRepository('App\Http\Odm\Documents\Usuario')->findOneBy(['idhw'=>$idhw]);
        //$autos      =   $usuario->getAutos();

        $autos = $dm->createQueryBuilder('App\Http\Odm\Documents\Auto')
            ->field('usuario')->references($usuario)
            ->limit($mostrar)
            ->skip(($pagina-1)*$mostrar)
            ->getQuery()
            ->execute();

        $result = [];
        //creamos el array para pasar todos los datos de los autos
        $contador=0;
        foreach($autos as $auto){
            $contador++;
            $result[]=[
                'nombre'    =>  $auto->getNombre(),
                'id'        =>  $auto->getId(),
                'foto'      =>  URL::route('mostrarAuto',['imagenId'=>$auto->getSelectedFoto()->getFilename().'.jpg','size'=>'square'])
            ];
            if($contador==$mostrar)
                break;
        }

        return response()->json(['autos'=>$result],200);

    }



}