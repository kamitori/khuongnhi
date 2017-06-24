<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model {

	//get province with country
	public static function getProvinceByCountry($country_id)
	{
		$arr_provinces = Province::where('country_id',$country_id)->get()->toArray();
		return $arr_provinces;
	}
}
