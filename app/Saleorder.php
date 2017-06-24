<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Saleorder extends Model {
	public function company()
	{
		return $this->belongsTo('App\Company','company_id');
	}
}
