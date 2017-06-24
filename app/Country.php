<?php namespace App;
use App\Province;
use Illuminate\Database\Eloquent\Model;

class Country extends Model {

	public static function getCountry()
	{
		$arr_country = Country::select('name','id')->get()->toArray();
		return $arr_country;
	}

	public function  provinces(){
		return $this->hasMany('App\Province','country_id');
	}
}
