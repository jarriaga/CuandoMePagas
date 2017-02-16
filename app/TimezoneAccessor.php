<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 2/16/17
 * Time: 12:35 AM
 */

namespace  App;

use Carbon\Carbon;

trait TimezoneAccessor
{
	public function getMutatedTimestampValue($value)
	{

		$timezone = config('app.timezone');

		return Carbon::parse($value)
			->toDateString();
	}

	public function getCreatedAtAttribute($value)
	{
		return $this->getMutatedTimestampValue($value);
	}

	public function getUpdatedAtAttribute($value)
	{
		return $this->getMutatedTimestampValue($value);
	}

	 public function setCreatedAtAttribute($value)
        {
                $this->attributes['created_at']=$this->getMutatedTimestampValue($value);
        }

        public function setUpdatedAtAttribute($value)
        {
                $this->attributes['updated_at']= $this->getMutatedTimestampValue($value);
        }
}
