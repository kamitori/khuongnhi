<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {

	public static function getAddressByCompanyId($company_id)
	{
		return Address::select('id','address','zip_postcode','town_city','module_id','module_type','province_id','country_id')
						->where('module_type','=','App\\Company')
						->where('module_id','=',$company_id)
						->first();
	}

	public function module_id()
	{
		return $this->morphTo();
	}

}
