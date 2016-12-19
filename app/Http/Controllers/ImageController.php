<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 12/18/16
 * Time: 12:35 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;


class ImageController
{

	static private $environment ;

	private static function setEnvironment(){
		return self::$environment = 'local' == env('APP_ENV') ?env('S3_STORAGE_DEV'):env('S3_STORAGE_LIVE');
	}


	/**
	 * Save file into a s3 bucket
	 * @param $path
	 * @param $file
	 */
	public static function save($folder,$name, $filename)
	{
		//dd($file);
		Storage::disk('s3')->putFileAs(self::setEnvironment().$folder,new File($filename),$name,'public');

	//	Storage::disk('s3')->put('/'.self::setEnvironment().$path,	$file,'public');
	}


	public static function  getUrl($filename)
	{
		return Storage::url(self::setEnvironment().$filename);
	}

	/**
	 * check if a file exist on S3 bucket
	 * @param $path
	 * @return mixed
	 */

	public static function exist($path)
	{
		return Storage::disk('s3')->exists($path);
	}

	public static function delete($path)
	{
		Storage::disk('s3')->delete($path);
	}

}