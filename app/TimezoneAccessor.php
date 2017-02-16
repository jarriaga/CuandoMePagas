<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 2/16/17
 * Time: 12:35 AM
 */

namespace  App;

trait TimezoneAccessor
{
	public function getMutatedTimestampValue($value)
	{

		$timezone = config('app.timezone');

		if (Auth::check() && Auth::user()->timezone) {
			$timezone = Auth::user()->timezone;
		}
		return Carbon::parse($value)
			->timezone($timezone);
	}

	public function getCreatedAtAttribute($value)
	{
		return $this->getMutatedTimestampValue($value);
	}

	public function getUpdatedAtAttribute($value)
	{
		return $this->getMutatedTimestampValue($value);
	}
}