<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

	public static function getDistributeList(){
		return Company::where("is_distribute","=",1)->orderBy('name');
	}

	public static function getCustomerList(){
		return Company::where("is_customer","=",1)->orderBy('name');
	}

	public function address(){
		return $this->morphMany('App\Address','module');
	}
}
