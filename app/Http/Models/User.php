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
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends MongoDb  implements Authenticatable{

    protected   $nameCollection = 'users';
    protected   $fields;

    /**
     * This function Save the document in the collection
     */
    public function save()
    {   if(!count($this->fields))
            return false;
        try{
            //if the object was found then we can update the document
            if(isset($this->fields['_id'])){
                $this->fields['dates']['updatedAt']= new \MongoDate();
                $this->collection->update(['_id'=>$this->fields['_id']],$this->fields);
                return true;
            }
            //if the object is new request, then we save and login a new account
            //just for the authentication object Auth::class
            $this->collection->insert($this->fields);
            $this->fields['id'] = $this->fields['_id']->{'$id'};
            return true;
        }catch( \MongoCursorException $e ){
            return false;
        }
    }

    /**
     * Fill all new parameters for User model
     * @param $data
     */
    public function fill($data)
    {
        $this->_id              =   isset($data['_id'])?$data['_id']:null;
        $this->firstname        =   isset($data['firstname'])?$data['firstname']:null;
        $this->lastname         =   isset($data['lastname'])?$data['lastname']:null;
        $this->username         =   isset($data['username'])?$data['username']:'user-'.str_random(12);
        $this->email            =   isset($data['email'])?$data['email']:null;
        if(isset($data['password']) && !isset($data['_id']))
            $this->password     =   Hash::make($data['password']);
        else
            $this->password     =   isset($data['password'])?$data['password']:null;

        $this->facebook_id      =   isset($data['facebook_id'])?$data['facebook_id']:null;

        if(isset($data['token']) && !isset($data['_id']))
            $this->token            =   isset($data['token'])?$data['token']:self::generateToken($data['email']);
        else
            $this->token            =   isset($data['token'])?$data['token']:null;

        $this->roles            =   isset($data['roles'])?$data['roles']:['user'=>true];
        $this->dates            =   isset($data['dates'])?$data['dates']:['createAt'=> new \MongoDate()];
    }

    /**
     * Create a new token based on the email
     * @param $email
     * @return mixed
     */
    public static function generateToken($email){
        return hash('sha256',$email.uniqid('token',true));
    }

    /**
     * @param $facebook_id
     * @return null|User
     */
    public static function findByFacebookId($facebook_id)
    {
        $instance   =    new static;
        if($result     =    $instance->collection->findOne(['facebook_id'=>$facebook_id]))
            $instance->fill($result);
        else
            return null;
        return $instance;
    }

    /**
     * @param array $params1
     * @param array $params2
     * @param array $params3
     * @return null|User
     */
    public static function findBy(Array $params1,Array $params2 = [], Array $params3 = [])
    {
        if(count($params1)) {
            $instance = new static;
            if($result = $instance->collection->findOne($params1,$params2,$params3)){
                $instance->fill($result);
                return $instance;
            }
        }
        return null;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->fields['_id']->{'$id'};
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
        return $this->fields['password'];
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
