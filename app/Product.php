<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\Purchaseorder;
use App\Saleorder;
use App\Oum;
use App\ProductType;
use DB;
use App\SellPrice;

class Product extends Model{
	public function scopeGetMinSellPrice($query){
		return $query->addSelect('price')->leftJoin(
					DB::raw(' ( select product_id,min(price) as price from sell_prices group by  product_id ) as sellprice'), 
					'products.id', '=', 'product_id'
				);	
	}
	public function type()
	{
		return $this->belongsTo('App\ProductType','product_type');
	}
	
	

	public function scopeWithPO($query,$po_id=0)
	{
		return $query->addSelect(
				'products.id',
				'products.sku',
				'products.name',
				'm_products.id as m_id',
				'm_products.sell_price',
				'm_products.oum_id',
				'products.specification',
				'm_products.origin_price',
				'amount',
				'amount_interest',
				'quantity'
				)
				->leftJoin('m_products','m_products.product_id','=','products.id')
				->where('module_type','=','App\\Purchaseorder')
				->where('module_id','=',$po_id);
	}

	public function scopeWithSO($query,$so_id=0)
	{
		return $query->addSelect(
				'products.id',
				'products.sku',
				'products.name',
				'm_products.id as m_id',
				'm_products.sell_price',
				'm_products.oum_id',
				'products.specification',
				'm_products.origin_price',
				'amount',
				'amount_interest',
				'quantity'
				)
				->leftJoin('m_products','m_products.product_id','=','products.id')
				->where('module_type','=','App\\Saleorder')
				->where('module_id','=',$so_id);
	}

}
