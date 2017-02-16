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


abstract class ImageController
{

	static private $environment ;

	private static function setEnvironment(){
		return self::$environment = 'local' == env('APP_ENV') ?env('S3_STORAGE_DEV'):env('S3_STORAGE_LIVE');
	}


	/**
	 * Save an image in their respective folder depends of the subclasses
	 *
	 * @param $folder
	 * @param $filename
	 * @param $file
	 * @return mixed
	 */
	public static function put($file,$folder,$filename)
	{
		return Storage::disk('s3')->put(self::setEnvironment().$folder.$filename,$file);
	}


	/**
	 *	Get Image Url from s3 bucket
	 *
	 * @param $filename
	 * @return mixed
	 */

	public static function  getUrl($filename)
	{
		return Storage::disk('s3')->url(self::setEnvironment().$filename);
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


	/**
	 * Delete file from s3 bucket
	 * @param $path
	 */
	public static function delete($path)
	{
		return Storage::disk('s3')->delete($path);
	}

}