<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 3/13/16
 * Time: 2:29 PM
 */

namespace App\Http\Controllers\Image;


use App\Http\Controllers\Auth\AuthMongoController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{

    /**
     * Esta funcion muestra una imagen rendereada al tamaño especifico
     * @param $imageId
     * @param $size
     * @return mixed
     */
    public function mostrarAuto($imageId,$size)
    {
        $filename   =   AuthMongoController::user()->getId().'-'.$imageId;
        // Crea una instancia de Intervention
        $image    =   new ImageManager();
        // Obtenemos la imagen del storage
        $image = $image->make(Storage::get('/public/autos/'.$filename));
        //cambiamos el tamaño de la imagen
        switch($size){
            case 'thumbnail' :
                $image->fit(100,100);
                break;
            case 'square'   :
                $image->fit(220,220);
                break;
            case '400'      :
                $image->fit(400);
                break;
        }
        //retornamos el valor de la imagen
        return $image->response();
    }

}