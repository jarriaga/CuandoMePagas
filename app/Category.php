<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

	protected $fillable = [
		'name', 'parent','description','icon','status'
	];


	public function Users()
	{
		return $this->belongsToMany('App\User');
	}

}
