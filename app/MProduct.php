<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MProduct extends Model {
	protected $table = 'm_products';
	protected $fillable = array('product_id', 'module_id', 'module_type');

	public function company()
	{
		return $this->belongsTo('App\Company','company_id');
	}
	
	public function oum()
	{
		return $this->belongsTo('App\Oum','oum_id');
	}
	public function sellprices()
	{
		return $this->hasMany('App\SellPrice','m_product_id')->orderBy('price')->orderBy('id');
	}

	public function getsellprices()
	{
		return $this->hasMany('App\SellPrice','m_product_id','m_product_id')->orderBy('price')->orderBy('id');
	}
}
