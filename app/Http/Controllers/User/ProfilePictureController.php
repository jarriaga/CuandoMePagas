<?php
/**
 * Created by PhpStorm.
 * User: jarriaga
 * Date: 12/2/15
 * Time: 5:09 PM
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class ProfilePictureController extends Controller{

    /**
     *  This method receive the photo profile and save in storage and update the user database
     * @param Request $request
     * @return $this
     */
    public function postUpload(Request $request)
    {
        $urlBack = (str_replace($request->server('HTTP_ORIGIN'),'',$request->server('HTTP_REFERER')));
        //validate the image
        $validator  =   Validator::make($request->all(),[
           'image'  =>  'required|image|max:200'
        ],['required'   =>  'Por favor selecciona un archivo',
            'image'     =>  'Debes seleccionar una imagen',
            'max'       =>  'La foto debe ser menor a 200kb']);

        //if fail then return with errors
        if($validator->fails()){
            Session::flash('notify',[
                'type'=>'error',
                'text'=>$validator->errors()->first()
            ]);
            return redirect($urlBack);
        }
        $profile    =   str_random(12);

        $manager    =   new ImageManager();
        $image      =   $manager->make($request->file('image'));
        $image->resize(100,100);
        $image->save(storage_path()."/app/profile/".$profile.".jpg");
        //Update the profile picture and save in storage
        Session::flash('notify',[
            'type'=>'success',
            'text'=>'La foto de perfil se ha actualizado correctamente'
        ]);
        return redirect($urlBack)->withErrors($validator);
    }

} 