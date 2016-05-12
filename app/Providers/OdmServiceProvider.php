<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 3/7/16
 * Time: 11:07 PM
 */

namespace App\Providers;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Illuminate\Support\ServiceProvider;



class OdmServiceProvider extends ServiceProvider
{


    public function register()
    {

        $this->app->bind('ODM',function($app){
            //Configuracion para cargar el ODM  doctrine mongo
            $config = new Configuration();

            $config->setProxyDir((dirname(__FILE__) .'/../Http/Odm/Proxies'));
            $config->setProxyNamespace('Proxies');
            $config->setHydratorDir((dirname(__FILE__) .'/../Http/Odm/Hydrators'));
            $config->setHydratorNamespace('Hydrators');

            if(env('DB_ENV','development')=='development') {
                $connection = new Connection();
                $config->setDefaultDB(env('DB_NAME_DEV'));
            }else {
                $connection = new Connection(env('DB_MONGO_HOST'));
                $config->setDefaultDB(env('DB_NAME_LIVE'));
            }

            $config->setMetadataDriverImpl(AnnotationDriver::create((dirname(__FILE__) .'/../Http/Odm/Documents')));
            AnnotationDriver::registerAnnotationClasses();

            $dm = DocumentManager::create($connection, $config);

            return $dm;
        });
    }
}