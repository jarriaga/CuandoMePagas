<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{

	use TimezoneAccessor;


	protected $fillable = ['story','typeComplaint','name','amount','dateLoan','country',
		'state','city','city2','published','facebook','twitter','photo','email'];


	protected $dateFormat = 'U';


	public function setDateLoanAttribute($value)
	{
		$this->attributes['dateLoan'] = Carbon::createFromFormat('d/m/Y',$value)->toDateString();
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function getDateInDays()
	{
		$date = Carbon::createFromFormat('Y-m-d',$this->dateLoan);
		return $date->diffInDays(Carbon::now());
	}

	public function getDateFormat()
	{
		Carbon::setLocale('es');
		$date = Carbon::createFromFormat('Y-m-d',$this->dateLoan);
		return $date->toFormattedDateString();
	}

	public function getDatePickerFormat()
	{
		Carbon::setLocale('es');
		$dateLoan = Carbon::createFromFormat('Y-m-d',$this->dateLoan);
		return $dateLoan->day.'/'.$dateLoan->month.'/'.$dateLoan->year;
	}
}
