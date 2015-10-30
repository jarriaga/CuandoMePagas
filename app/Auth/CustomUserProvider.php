<?php
/**
 * Created by PhpStorm.
 * User: jarriaga
 * Date: 10/6/15
 * Time: 7:20 PM
 * Jesus Arriaga - Custom User Driver for authentication with mongoDB
 * jarriagabarron@gmail.com
 */

namespace App\Auth;



use App\Http\Models\MongoDb;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Hash;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Str;

class CustomUserProvider    implements UserProvider{

    protected $model;

    public function __construct(UserContract $model)
    {
        $this->model    =   $model;
    }

    /**
     * Retrieve a user by their unique identifier.
     * This is used by Auth::login()
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $collection = new \MongoCollection(MongoDb::getDatabase(),"users");
        $user =     $collection->findOne(['_id'=> new \MongoId($identifier)]);
        return $this->getGenericUser($user);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return New Exception('No implementado');
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(UserContract $user, $token)
    {
        return New Exception('No implementado');
    }

    /**
     * Retrieve a user by the given credentials.
     * This is used by Auth::attemp()
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $collection = new \MongoCollection(MongoDb::getDatabase(),"users");
        $query = array();
        foreach ($credentials as $key => $value) {
            if (! Str::contains($key, 'password')) {
                $query[$key]=$value;
            }
        }
        $user   =   $collection->findOne($query);
        return  $this->getGenericUser($user);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        if(!$user->getAuthPassword())
            return false;

        if(Hash::check($credentials['password'],$user->getAuthPassword()))
            return true;
        else
            return false;
    }

    /**
     * Get the generic user.
     *
     * @param  mixed  $user
     * @return \Illuminate\Auth\GenericUser|null
     */
    protected function getGenericUser($user)
    {
        if ($user !== null) {
            $user['id'] = $user['_id']->{'$id'};
            if(!isset($user['password']))
                $user['password'] = null;
            return new GenericUser((array) $user);
        }
    }
}