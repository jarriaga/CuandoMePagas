<?php
/**
 * Created by PhpStorm.
 * User: jarriaga
 * Date: 9/16/15
 * Time: 3:59 PM
 * Description: This class is the conecction with the Mongo Db database and use
 * magic methods to fill the array data with collection in the derivated classes
 * Jesus Arriaga    -   jarriagabarron@gmail.com
 */
namespace App\Http\Models;


Abstract class MongoDb {

    static protected   $database;
    protected   $collection;
    protected   $nameCollection;
    protected   $fields;


    public function __construct()
    {
        $this->setConnection();
        $this->setCollection();
    }

    /**
     *  This function Define and assign the database
     */
    private function setConnection()
    {
        $cn     =   new \MongoClient();
        if(env('DB_ENV','development')=='development')
            self::$database=   $cn->selectDB("dbDevCMP01");
        else
            self::$database     =   $cn->selectDB("dbProdCMP01");
    }

    /**
     *  This function returns de database object
     */
    static public function getDatabase()
    {
        return self::$database;
    }

    /**
     * This function Assign the collection with the name assigned in the derivated class
     */
    public function setCollection()
    {
        $cl =  $this->nameCollection;
        $this->collection = self::$database->$cl;
    }

    public function getCollection()
    {
        $collection = new \MongoCollection(self::$database,$this->nameCollection);
        return $collection;
    }

    /**
     * This function add field inside the array
     * @param $property
     * @param $value
     *
     */
    function __set($property, $value)
    {

        if( $value != null )
            $this->fields[$property]    =   $value;
    }

    function __get($property)
    {
        if(isset($this->fields[$property]))
            return $this->fields[$property];
    }

} 