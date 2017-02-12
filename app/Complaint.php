<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{

	protected $fillable = ['story','typeComplaint','name','amount','dateLoan','country',
		'state','city','city2','published','facebook','twitter','photo'];



	public function setDateLoanAttribute($value)
	{
		$this->attributes['dateLoan'] = Carbon::createFromFormat('d/m/Y',$value);
	}



	public function setFacebookAttribute($value)
	{
		if(!empty($value)){
			$this->attributes['facebook'] = json_encode($value);
		}else{
			$this->attributes['facebook']='';
		}
	}



	public function setTwitterAttribute($value)
	{
		if(!empty($value)){
			$this->attributes['twitter'] = json_encode($value);;
		}else{
			$this->attributes['twitter'];
		}
	}

	public function user()
	{
		return $this->belongsToMany('App\User');
	}
}
