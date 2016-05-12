<?php
/**
 * Created by PhpStorm.
 * User: jarriaga
 * Date: 9/17/15
 * Time: 8:00 PM
 * Description: This class is used to handle records into the collection User
 * Jesus Arriaga    -   jarriagabarron@gmail.com
 */

namespace App\Http\Models;

class Estado extends MongoDb{

    protected   $nameCollection = 'estados';
    protected   $fields;

    /**
     * this function return the list of states of Mexico
     * @return mixed
     */
    public static function findByAll()
    {
        $instance   =   new static;
        $estados    =   $instance->collection->find();
        return $estados;
    }

    public static function findBy(  $array  =   null    )
    {
        $instance   =   new static;
        $regionEdo    =   $instance->collection->find($array);
        return  $regionEdo;
    }

    /**
     * Retorna solo los estados
     * @return \MongoCursor
     */
    public function getSoloEstados()
    {
       $data    =    $this->getCollection()->find([],['identificador'=>1,'nombre'=>1]);
        return  $data;
    }


    /**
     * Funcion que retorna las regiones de un estado dado
     * @param $idEstado
     * @return array|bool
     */
    public function getEstadoyRegiones($idEstado)
    {
        $data       =    $this->getCollection()->find(['_id'=>new \MongoId($idEstado)],['region'=>1]);
        if(!$data->count())
            return false;

        $array = $data->next();
        $result=[];
        foreach($array['region'] as $region){
            $result[]=["id"=>$region['_idMunicipio']->{'$id'},"nombre"=>$region["nombre"],"status"=>$region["status"]];
        }
        return  $result;
    }


    public function updateStatusRegion($idEstado, $idMunicipio, $status)
    {
        $update =   $this->getCollection()->update(
            [   '_id'                   =>     new \MongoId($idEstado),
                'region._idMunicipio'   =>     new \MongoId($idMunicipio)
            ],
            [
                '$set'                  =>      ['region.$.status'   => ($status)?0:1]
            ]
        );

        return  $update;

    }

}
