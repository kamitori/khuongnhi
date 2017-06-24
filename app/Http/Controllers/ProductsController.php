<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use App\MProduct;
use App\ProductStock;
use App\Company;
use App\Oum;
use App\SellPrice;
use App\ProductType;
use App\Purchaseorder;
use App\ReturnPurchaseorder;
use App\ReturnSaleorder;
use App\Saleorder;
use App\ReceiptMonth;
use App\Log;
use App\TonDauThang;
use Datatables;
use Illuminate\Http\Request;
use Session;
use DB;

class ProductsController extends Controller {

	/**
	 * Show the profile for the given user.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function getIndex(Request $request){
		self::anyEntry($request);
	}
	public function getSku(Request $request,$sku){
		$product = Product::where('sku','=',$sku)->get()->first();
		if($product)
			self::anyEntry($request,$product->id);
		else
			return redirect(URL.'/products');
	}
	public function anyEntry(Request $request,$id=null)
	{
		if(isset($id) && $id!=null){
			$id_product = $id;
			$product = Product::find($id_product)->toArray();
			session(['current_product' => $product['id']]);
		}else{
			$id_product = session('current_product') !== null ? session('current_product') : 0;
			if($id_product){
				$product = Product::find($id_product)->toArray();
				if(count($product)){
					session(['current_product' => $product['id']]);
				}else{
					$product = Product::get()->last();
					if($product){
						$product= $product->toArray();
						session(['current_product' => $product['id']]);
					}else{
						$product = new Product;
						$product->created_by = \Auth::user()->id;
						$product->save();
						Log::create_log(\Auth::user()->id,'App\\Product','Tạo mới sản phẩm số '.$product->id);
						session(['current_product' => $product->id]);
						$product->toArray();
					}
				}
			}else{
				$product = Product::get()->last();
				if($product){
					$product= $product->toArray();
					session(['current_product' => $product['id']]);
				}else{
					$product = new Product;
					$product->created_by = \Auth::user()->id;
					$product->save();
					Log::create_log(\Auth::user()->id,'App\\Product','Tạo mới sản phẩm số '.$product->id);
					session(['current_product' => $product->id]);
					$product->toArray();
				}
			}
		}



		//Init array
		$distributes = array();
		$oums = array();
		$producttypes = array();
		$list_instock = array();


		//Get value array
		$distributes = Company::getDistributeList()->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$producttypes = ProductType::get()->toArray();
		if($product['check_in_stock']){
			$list_instock = MProduct::select('m_products.*','product_stocks.in_stock')
						->with('company')->with('oum')
						->where('m_products.product_id','=',session('current_product'))
						->where('module_type','=','in_stock')
						->leftJoin('product_stocks','product_stocks.m_product_id','=','m_products.id')
						->get()->toArray();
		}
		
		$view_list_po = self::getListPo($request);
		$view_list_so = self::getListSo($request);
		$companies = array();
		$companies = Company::orderBy('name')->get()->toArray();
		$arr_create = Product::select('users.name','products.created_at')
					->leftJoin('users','users.id','=','products.created_by')
					->where('products.id','=',$product['id'])
					->get()->first()->toArray();

		$arr_update = Product::select('users.name','products.updated_at')
					->leftJoin('users','users.id','=','products.updated_by')
					->where('products.id','=',$product['id'])
					->get()->first()->toArray();
		$this->layout->arr_create = $arr_create;
		$this->layout->arr_update = $arr_update;
		$list_month =ReceiptMonth::select('month','year')
									->distinct()->where('month','>',0)
									->orderBy('year','DESC')
									->orderBy('month','DESC')
									->get()->toArray();
		
		$this->layout->content=view('product.entry', ['distributes'=>$distributes,
								'oums'=>$oums,
								'producttypes'=>$producttypes,
								'product' => $product,
								'view_list_po'	=> $view_list_po,
								'view_list_so'	=> $view_list_so,
								'list_instock' => $list_instock,
								'companies'	=> $companies,
								'list_month' => $list_month
							        ]);
	}

	public function anyCreate(Request $request)
	{
		$product = new Product;
		$product->created_by = \Auth::user()->id;
		if($product->save()){
			Log::create_log(\Auth::user()->id,'App\\Product','Tạo mới sản phẩm số '.$product->id);
			session(['current_product' => $product->id]);
		}
		return redirect('products');
	}

	public function postCreateProduct(Request $request)
	{
		$arr_return = array('status' => 'error');
		$product = new Product;
		$product->name = $request->has('name') ? $request->input('name') : '';
		$product->sku = $request->has('sku') ? $request->input('sku') : '';
		$product->product_type = $request->has('product_type') ? $request->input('product_type') : 0;
		$product->status=0;
		$product->created_by = \Auth::user()->id;
		if($product->save()){
			Log::create_log(\Auth::user()->id,'App\\Product','Tạo mới sản phẩm số '.$product->id);
			$arr_return = array('status' => 'success');
		}else{
			$arr_return = array('message' => 'Creating fail!');
		}
		return $arr_return;
	}

	public function anyDelete(Request $request)
	{
		$arr_return = [
			'status'		=>	'error'
		];
		$id_product = session('current_product') !== null ? session('current_product') : 0;
		if($id_product){

			$product = MProduct::where('product_id','=',$id_product)
						->leftJoin('purchaseorders',function($join){
							$join->on('m_products.module_id','=','purchaseorders.id');
						})
						->where('module_type','=','App\\Purchaseorder')
						->first();
			if($product){
				$arr_return['message'] = 'Sản phẩm đã được tạo hóa đơn.<br/> Xin vui lòng xóa hết hóa đơn để có thể xóa sản phẩm.';
			}else{
				$product = Product::find($id_product);
				if($product->delete()){
					Log::create_log(\Auth::user()->id,'App\\Product','Xóa sản phẩm số '.$id_product);
					MProduct::where('product_id','=',$id_product)->delete();
					SellPrice::where('product_id','=',$id_product)->delete();
					ProductStock::where('product_id','=',$id_product)->delete();
				}
				Session::forget('current_product');
				$arr_return['status'] = 'success';
			}


		}else{
			$arr_return['message'] = 'Không tìm thấy sản phẩm';
		}
		return $arr_return;

	}
	public function getClear(Request $request)
	{
		Session::forget('current_product');
		return redirect('products');
	}

	public function postUpdate(Request $request)
	{
		$arr_return = array(
					'status' => 'error'
				);
		$id_product = session('current_product') !== null ? session('current_product') : 0;
		if($id_product){
			$product = Product::find($id_product);
			session(['current_product' => $product['id']]);
		}else{
			$product = new Product;
			$product->save();
			session(['current_product' => $product->id]);
		}
		$log = '';
		if($product->status == 0){
			if($request->has('name')  && $product->name != $request->input('name')){
				$log .= 'tên sản phẩm từ "'.$product->name.'" thành "'.$request->input('name').'" ';
			}
			if($request->has('sku')  && $product->sku != $request->input('sku')){
				$log .= 'SKU từ "'.$product->sku.'" thành "'.$request->input('sku').'" ';
			}
			if($product->product_type && $request->has('product_type')  && $product->product_type != $request->input('product_type')){
				$old = ProductType::find($product->product_type);
				$new = ProductType::find($request->input('product_type'));
				$log .= 'loại sản phẩm từ "'.$old->name .'" thành "'.$new->name .'" ';
			}
			$product->name = $request->has('name') ? $request->input('name') : '';
			$product->sku = $request->has('sku') ? $request->input('sku') : '';
			$product->product_type = $request->has('product_type') ? $request->input('product_type') : 0;
			
		}
		if($product->status != $request->has('status')){
			$log .= 'trạng thái từ "'.($product->status?'Hoàn thành':'Mới').'" thành "'.($request->has('status')?'Hoàn thành':'Mới').'" ';
		}
		$product->status = $request->has('status')?1:0;
		
		$product->updated_by = \Auth::user()->id;
		if($product->save()){
			Log::create_log(\Auth::user()->id,'App\\Product','Cập nhật '.$log.' sản phẩm số '.$product->id);
			$arr_return['status']= 'success';
			$arr_return['name']= $product->name;
		}else{
			$arr_return['message']= 'Saving fail !';
		}
		return $arr_return;
	}

	public function postSaveSellPrice(Request $request)
	{
		$arr_return = array(
					'status' => 'error'
		);
		$id = $request->has('id')?$request->input('id'):0;
		$log = '';
		if($id){
			$sell_price = SellPrice::find($id);
		}else{
			$sell_price = new SellPrice;
			$log= "Tạo mới giá bán cho sản phẩm số ".session('current_product').' - '.$request->input('product_id');
			Log::create_log(\Auth::user()->id,'App\\Product',$log);
		}
		$check_log = false;
		if($log==''){
			if($request->has('name')  && $sell_price->name != $request->input('name')){
				$log .= ' tên giá bán từ "'.$sell_price->name.'" thành "'.$request->input('name').'" ';
			}
			if($request->has('price')  && $sell_price->price != intval(str_replace(",","",$request->input('price')))){
				$log .= ' giá bán từ "'.$sell_price->price.'" thành "'.intval(str_replace(",","",$request->input('price'))).'" ';
			}
			$check_log = true;
		}

		$sell_price->m_product_id = $request->has('product_id')?$request->input('product_id'):0;
		$sell_price->product_id = session('current_product');
		$sell_price->name =  $request->has('name')?$request->input('name'):'';
		$sell_price->price =  $request->has('price') ? intval(str_replace(",","",$request->input('price'))) : 0;
		
		if($sell_price->save()){
			if($check_log){
				if($log==""){
					$log = 'giá bán';
				}
				Log::create_log(\Auth::user()->id,'App\\Product','Cập nhật '.$log.' sản phẩm số '.session('current_product').' - '.$request->input('product_id'));
			}
			$arr_return['status']= 'success';
		}else{
			$arr_return['message']= 'Saving fail !';
		}
		return $arr_return;
	}

	public function getListSellPrice(Request $request)
	{
		$mproduct_id =  $request->has('mproduct_id')?$request->input('mproduct_id'):0;
		$list_price = array();
		$view_list_price ='';
		$list_price = SellPrice::where('m_product_id','=',$mproduct_id)->get()->toArray();
		$view_list_price = view('product.list-sellprice',['list_price' => $list_price]);
		return $view_list_price;
	}

	public function postDeleteSellPrice(Request $request)
	{
		$arr_return = array(
					'status' => 'error'
		);
		$id = $request->has('id')?$request->input('id'):0;
		$sell_price = SellPrice::find($id);
		if($sell_price->delete()){
			$arr_return['status']= 'success';
		}else{
			$arr_return['message']= 'Saving fail !';
		}
		return $arr_return;
	}

	public function anyList(Request $request)
	{
		\DB::enableQueryLog();
		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort =(array) json_decode($arr_sort);
		}elseif( session('sort_filter_product.arr_sort') !== null){
			$arr_sort = session('sort_filter_product.arr_sort');
		}else{
			$arr_sort=array();
		}
		session('sort_filter_product.arr_sort', $arr_sort);


		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}elseif( session('sort_filter_product.arr_filter') !== null ){
			$arr_filter = session('sort_filter_product.arr_filter');
		}else{
			$arr_filter=[
					'sku'=>'',
					'like_name'=>'',
					'name'=>'',
					'company_id'=>'',
					'oum_id'=>'',
					'status'=>''
				       ];
		}
		session(['sort_filter_product.arr_sort'=>$arr_sort]);
		session(['sort_filter_product.arr_filter'=> $arr_filter]);

		//Init array
		$distributes = array();
		$oums = array();
		$producttypes = array();
		$list_sku = array();

		//Get value array
		$distributes = Company::getDistributeList()->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$producttypes = ProductType::get()->toArray();
		$list_all_product = Product::select('sku','name')->orderBy('sku')->get()->toArray();
		DB::enableQueryLog();
		$list_product = MProduct::select(
					'products.id',
					'products.name',
					'products.sku',
					'm_products.product_id',
					'm_products.oum_id',
					'm_products.specification',
					'm_products.origin_price',
					// 'product_stocks.in_stock',
					'companies.name as company_name',
					'oums.name as oum_name',
					'm_products.module_id'
		                                )
					->addSelect(DB::raw('product_stocks.in_stock/m_products.specification as real_in_stock'))
					->addSelect(DB::raw('sum(product_stocks.in_stock) as in_stock'))
					->leftJoin('oums','oums.id','=','m_products.oum_id')
					->leftJoin('products','products.id','=','m_products.product_id')
					->leftJoin('purchaseorders',function($join){
						$join->on('purchaseorders.id','=','m_products.module_id')
						->where('purchaseorders.status','=',1);
					})
					// ->where(function ($query){
					// 	$query->where('purchaseorders.status', '=', 1)
					// 		->orWhere('m_products.module_type', '=', 'in_stock');
					// })
					->where(function ($query){
						$query->where('m_products.module_type', '=', 'App\\Purchaseorder')
							->orWhere('m_products.module_type', '=', 'in_stock');
					})
					->groupBy('products.id','m_products.company_id','m_products.oum_id','m_products.specification','m_products.origin_price')
					->leftJoin('companies','companies.id','=','m_products.company_id')
					->leftJoin('product_stocks','m_products.id','=','product_stocks.m_product_id');

		foreach ($arr_filter as $key => $value) {
			if($value!=''){
				if($arr_filter['sku']!=''){
					$list_product->where('products.sku',$arr_filter['sku']);
				}elseif($key == 'like_name'){
					$list_product->where('products.name','LIKE',"%".$arr_filter['like_name']."%");
					$arr_filter['name']='';
				}elseif($key == 'name' && $arr_filter['name']!=''){
					$list_product->where('products.name',$arr_filter['name']);
				}elseif($key == 'company_id'){
					$list_product->where('m_products.company_id',$arr_filter['company_id']);
				}elseif($key == 'status'){
					$list_product->where('products.status',$arr_filter['status']);
				}elseif($key == 'oum_id'){
					$list_product->where('m_products.oum_id',$arr_filter['oum_id']);
				}else{
					$a=1;
				}

			}
		}

		foreach ($arr_sort as $key => $value) {
			if($key=='company_id'){
				$list_product = $list_product->orderBy('companies.name',$value);
			}elseif($key=='oum_id'){
				$list_product = $list_product->orderBy('oums.name',$value);
			}elseif($key=='id'){
				$list_product = $list_product->orderBy('products.id',$value);
			}elseif($key=='specification'){
				$list_product = $list_product->orderBy('m_products.specification',$value);
			}elseif($key=='in_stock'){
				$list_product = $list_product->orderBy('real_in_stock',$value);
			}else{
				$list_product = $list_product->orderBy($key,$value);
			}
		}
		$list_product = $list_product->orderBy('products.id','asc');
		if(!isset($arr_filter['status'])){
			$arr_filter['status'] = '';
		}
		\Cache::put('list_product'.\Auth::user()->id, $list_product->get()->toArray(), 30);
		$sum_invest =  0;
		// pr($list_product->get()->toArray() );die;
		foreach ($list_product->get()->toArray() as $key => $value) {
			$sum_invest += $value['origin_price'] * $value['in_stock'];
		}

		$list_product = $list_product->paginate(100);
		// pr(DB::getQueryLog());die;
		// pr($list_product->toArray());die;

		

		$this->layout->content=view('product.list', [
								'distributes'		=>$distributes,
								'oums'			=>$oums,
								'producttypes'		=>$producttypes,
								'list_product'		=> $list_product,
								'list_all_product'		=>$list_all_product,
								'arr_sort' 		=> $arr_sort,
								'arr_filter' 		=> $arr_filter,
								'sum_invest'		=>$sum_invest
							        ]);
	}

	public function getDeleteFromList(Request $request,$id=0)
	{
		$id_product = $id;
		if($id_product){
			$product = Product::find($id_product);
			$product->delete();
			SellPrice::where('product_id','=',$id_product)->delete();
			Session::forget('current_product');
		}
		return redirect('products/list');
	}

	public function anyListClear(Request $request)
	{
		Session::forget('sort_filter_product');
		Session::forget('sort_filter_product_ton_dau_thang');
		return redirect('products/list');
	}

	public function anyListPopup(Request $request,$module=null)
	{
		\DB::enableQueryLog();
		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort =(array) json_decode($arr_sort);
		}else{
			$arr_sort=array();
		}



		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}else{
			$arr_filter=[
					'sku'=>'',
					'name'=>'',
					'product_type'=>'',
					'status'=>''
				       ];
		}

		//Init array
		$producttypes = array();
		$list_sku = array();

		//Get value array
		$producttypes = ProductType::get()->toArray();
		$list_all_product = Product::select('sku','name')->get()->toArray();

		$list_product = Product::select('products.*')->with('type');

		foreach ($arr_sort as $key => $value) {
			if($key=='id'){
				$list_product = $list_product->orderBy('products.id',$value);
			}else{
				$list_product = $list_product->orderBy($key,$value);
			}
		}
		if(count($arr_sort)==0){
			$list_product = $list_product->orderBy('products.id','asc');
		}

		foreach ($arr_filter as $key => $value) {
			if($value!=''){
				if($arr_filter['sku']!=''){
					$list_product->where('products.sku',$arr_filter['sku']);
				}elseif($arr_filter['name']!=''){
					$list_product->where('products.name',$arr_filter['name']);
				}elseif($key == 'status'){
					$list_product->where('products.status',$arr_filter['status']);
				}else{
					$list_product->where($key,$value);
				}

			}
		}
		if(!isset($arr_filter['status'])){
			$arr_filter['status'] = '';
		}


		$list_product = $list_product->groupBy('products.id')->paginate(50);
		// echo $module;die;
		return view('popup.choose_product_'.$module, [
								'producttypes'=>$producttypes,
								'list_product' => $list_product,
								'list_all_product'=>$list_all_product,
								'arr_sort' => $arr_sort,
								'arr_filter' => $arr_filter,
							        ]);
		die;
	}

	public function getListPo(Request $request)
	{
		\DB::enableQueryLog();
		$list_order = array();
		$id_product = session('current_product') !== null ? session('current_product') : 0;
		$type = $request->has('type')? $request->input('type'): 'all';
		$company_id = $request->has('company_id')? $request->input('company_id'): 'all';
		$month_year = $request->has('month_year')? $request->input('month_year'): 'all';
		if($type=='all' || $type=='po'){
			$list_po = Purchaseorder::select('purchaseorders.date','purchaseorders.id','m_products.quantity','m_products.specification','oums.name as oum_name','companies.name as company_name','m_products.id as product_id','product_stocks.in_stock')
				->leftJoin('m_products',function($join){
					$join->on('m_products.module_id','=','purchaseorders.id')
						->where('module_type','=','App\\Purchaseorder');
				})
				->leftJoin('products','m_products.product_id','=','products.id')
				->leftJoin('companies','m_products.company_id','=','companies.id')
				->leftJoin('oums','m_products.oum_id','=','oums.id')
				->leftJoin('product_stocks','product_stocks.m_product_id','=','m_products.id')
				->where('products.id','=',$id_product)
				->where('purchaseorders.status','=',1)
				->orderBy('date','desc');
			if($company_id != 'all')
				$list_po = 	$list_po->where('companies.id','=',$company_id);
			if($month_year != 'all'){
				$month = explode('-',$month_year);
				$list_po = 	$list_po->whereRaw("MONTH(`purchaseorders`.`date`)=".$month[0])
									->whereRaw("YEAR(`purchaseorders`.`date`)=".$month[1]);

			}
			$list_po =	$list_po->get()->toArray();
			// $query = \DB::getQueryLog();
			// print_r($query[count($query)-1]);
			// pr($list_po);die;

			foreach ($list_po as $key => $value) {
				$arr_tmp = array();
				$arr_tmp['company_name'] = $value['company_name'];
				$arr_tmp['oum_name'] = $value['oum_name'];
				$arr_tmp['specification'] = $value['specification'];
				$arr_tmp['quantity'] = $value['quantity'];
				$arr_tmp['id'] = $value['id'];
				$arr_tmp['product_id'] = $value['product_id'];
				$arr_tmp['date'] = $value['date'];
				$arr_tmp['in_stock'] = $value['in_stock'];
				$arr_tmp['type'] = 'po';
				$list_order[] = $arr_tmp;
			}
		}

		if($type=='all' || $type=='rpo'){
			$list_rpo = ReturnSaleorder::select('return_saleorders.date','return_saleorders.id','m_products.quantity','m_products.specification','oums.name as oum_name','companies.name as company_name','m_products.id as product_id')
				->leftJoin('m_products',function($join){
					$join->on('m_products.module_id','=','return_saleorders.id')
						->where('module_type','=','App\\ReturnSaleorder');
				})
				->leftJoin('products','m_products.product_id','=','products.id')
				->leftJoin('companies','m_products.company_id','=','companies.id')
				->leftJoin('oums','m_products.oum_id','=','oums.id')
				->where('products.id','=',$id_product)
				->where('return_saleorders.status','=',1)
				->orderBy('date','desc');
			if($company_id != 'all')
				$list_rpo = $list_rpo->where('companies.id','=',$company_id);
			if($month_year != 'all'){
				$month = explode('-',$month_year);
				$list_rpo = 	$list_rpo->whereRaw("MONTH(`return_saleorders`.`date`)=".$month[0])
									->whereRaw("Year(`return_saleorders`.`date`)=".$month[1]);

			}
			$list_rpo =	$list_rpo->get()->toArray();
			foreach ($list_rpo as $key => $value) {
				$arr_tmp = array();
				$arr_tmp['company_name'] = $value['company_name'];
				$arr_tmp['oum_name'] = $value['oum_name'];
				$arr_tmp['specification'] = $value['specification'];
				$arr_tmp['quantity'] = $value['quantity'];
				$arr_tmp['id'] = $value['id'];
				$arr_tmp['date'] = $value['date'];
				$arr_tmp['in_stock'] = 0;
				$arr_tmp['type'] = 'rpo';
				$list_order[] = $arr_tmp;
			}
		}
		$product = Product::find($id_product)->toArray();

		if(($type=='all' || $type=='in_stock') && $month_year == 'all'){
			if($product['check_in_stock']){
				$list_instock = MProduct::select('m_products.*','product_stocks.in_stock')
							->with('company')->with('oum')
							->where('m_products.product_id','=',session('current_product'))
							->where('module_type','=','in_stock')
							->leftJoin('product_stocks','product_stocks.m_product_id','=','m_products.id');
				if($company_id != 'all'){
					$list_instock = $list_instock->where('m_products.company_id','=',$company_id);
				}
				$list_instock = $list_instock->get()->toArray();
				foreach ($list_instock as $key => $value) {
					$arr_tmp = array();
					$arr_tmp['company_name'] = $value['company']['name'];
					$arr_tmp['oum_name'] = $value['oum']['name'];
					$arr_tmp['specification'] = $value['specification'];
					$arr_tmp['quantity'] = $value['quantity'];
					$arr_tmp['id'] = $value['id'];
					$arr_tmp['product_id'] = $value['product_id'];
					$arr_tmp['date'] = $value['created_at'];
					$arr_tmp['in_stock'] = $value['in_stock'];
					$arr_tmp['type'] = 'in_stock';
					$list_order[] = $arr_tmp;
				}
			}
			
		}
		$arr_date = array();
		foreach ($list_order as $key => $value) {
			$arr_date[] = $value['date'];
		}
		array_multisort($arr_date,SORT_DESC,$list_order);
		return view('product.list-po',[
				'list_order'		=>	$list_order ,
				'product'		=>	$product
			]);
	}

	public function getListSo(Request $request)
	{
		$list_order = array();
		$id_product = session('current_product') !== null ? session('current_product') : 0;
		$type = $request->has('type')? $request->input('type'): 'all';
		$company_id = $request->has('company_id')? $request->input('company_id'): 'all';
		$month_year = $request->has('month_year')? $request->input('month_year'): 'all';
		if($type=='all' || $type=='so'){
			$list_so = Saleorder::select('saleorders.date','saleorders.id','m_products.quantity','m_products.specification','oums.name as oum_name','companies.name as company_name','m_products.id as product_id')
				->leftJoin('m_products',function($join){
					$join->on('m_products.module_id','=','saleorders.id')
						->where('module_type','=','App\\Saleorder');
				})
				->leftJoin('products','m_products.product_id','=','products.id')
				->leftJoin('companies','m_products.company_id','=','companies.id')
				->leftJoin('oums','m_products.oum_id','=','oums.id')
				->where('products.id','=',$id_product)
				->where('saleorders.status','=',1)
				->orderBy('date','desc');
			if($company_id != 'all')
				$list_so = $list_so->where('companies.id','=',$company_id);
			if($month_year != 'all'){
				$month = explode('-',$month_year);
				$list_so = 	$list_so->whereRaw("MONTH(`saleorders`.`date`)=".$month[0])
									->whereRaw("Year(`saleorders`.`date`)=".$month[1]);
			}
			$list_so = $list_so->get()->toArray();

			foreach ($list_so as $key => $value) {
				$arr_tmp = array();
				$arr_tmp['company_name'] = $value['company_name'];
				$arr_tmp['oum_name'] = $value['oum_name'];
				$arr_tmp['specification'] = $value['specification'];
				$arr_tmp['quantity'] = $value['quantity'];
				$arr_tmp['id'] = $value['id'];
				$arr_tmp['date'] = $value['date'];
				$arr_tmp['type'] = 'so';
				$list_order[] = $arr_tmp;
			}
		}
		if($type=='all' || $type=='rpo'){
			$list_rpo = ReturnPurchaseorder::select('return_purchaseorders.date','return_purchaseorders.id','m_products.quantity','m_products.specification','oums.name as oum_name','companies.name as company_name','m_products.id as product_id')
				->leftJoin('m_products',function($join){
					$join->on('m_products.module_id','=','return_purchaseorders.id')
						->where('module_type','=','App\\ReturnPurchaseorder');
				})
				->leftJoin('products','m_products.product_id','=','products.id')
				->leftJoin('companies','m_products.company_id','=','companies.id')
				->leftJoin('oums','m_products.oum_id','=','oums.id')
				->where('products.id','=',$id_product)
				->where('return_purchaseorders.status','=',1)
				->orderBy('date','desc');
			if($company_id != 'all')
				$list_rpo  = $list_rpo->where('companies.id','=',$company_id);
			if($month_year != 'all'){
				$month = explode('-',$month_year);
				$list_rpo = 	$list_rpo->whereRaw("MONTH(`return_purchaseorders`.`date`)=".$month[0])
									->whereRaw("Year(`return_purchaseorders`.`date`)=".$month[1]);
			}
			$list_rpo = $list_rpo->get()->toArray();

			foreach ($list_rpo as $key => $value) {
				$arr_tmp = array();
				$arr_tmp['company_name'] = $value['company_name'];
				$arr_tmp['oum_name'] = $value['oum_name'];
				$arr_tmp['specification'] = $value['specification'];
				$arr_tmp['quantity'] = $value['quantity'];
				$arr_tmp['id'] = $value['id'];
				$arr_tmp['date'] = $value['date'];
				$arr_tmp['type'] = 'rpo';
				$list_order[] = $arr_tmp;
			}
		}
		$product = Product::find($id_product)->toArray();
		return view('product.list-so',[
				'list_order'		=>	$list_order ,
				'product'	=>	$product
			]);
	}

	public function postSaveInstock(Request $request)
	{
		$instock  = $request->has('instock') ? $request->input('instock') : '';
		$instock = json_decode($instock);
		$product_id = session('current_product') !== null ? session('current_product') : 0;
		$check = true;
		foreach ($instock as $key => $value) {
				$mproduct = new MProduct;
				$mproduct->product_id	=	$product_id;
				$mproduct->module_id	= 	0;
				$mproduct->company_id	= 	$value->company_id;
				$mproduct->module_type	=	'in_stock';
				$mproduct->specification	=	$value->specification;
				$mproduct->oum_id		=	$value->oum_id;
				$mproduct->origin_price	=	intval(str_replace(",","",$value->origin_price));
				$mproduct->quantity		=	$value->quantity;
				$mproduct->invest		=	intval(str_replace(",","",$value->origin_price))*intval($value->quantity)*intval($value->specification);
				$check = $check && $mproduct->save();
		}
		$check = $check && Product::where('id','=',$product_id)->update(['check_in_stock'=>1]);
		if($check){
			Log::create_log(\Auth::user()->id,'App\\Product','Thêm tồn kho ban đầu cho sản phẩm số '.$product_id);
			$arr_return['status'] = 'success';
		}else{
			$arr_return['status'] = 'error';
			$arr_return['message'] = 'Error Saving';
		}
		return $arr_return;
	}

	public function anyListPopupSo(Request $request)
	{
		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort = (array)json_decode($arr_sort);
		}else{
			$arr_sort = array();
		}

		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}else{
			$arr_filter =[
						'sku' => '',
						'name' => '',
						'company_id' => '',
						'oum_id' => '',
						];
		}
		session(['sort_filter_product_so.arr_sort' => $arr_sort]);
		session(['sort_filter_product_so.arr_filter'=> $arr_filter]);

		$distributes = array();
		$oums = array();
		$list_sku = array();

		$distributes = Company::getDistributeList()->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$list_all_product = Product::select('sku','name')->get()->toArray();

		$list_product = MProduct::select(
					'm_products.id',
					'products.name',
					'products.sku',
					'm_products.product_id',
					'm_products.oum_id',
					'm_products.specification',
					'm_products.origin_price',
					'm_products.invest',
					'product_stocks.in_stock',
					'companies.name as company_name',
					'oums.name as oum_name',
					'm_products.module_id'
		                                )
					->addSelect(DB::raw('product_stocks.in_stock/m_products.specification as real_in_stock'))
					->leftJoin('oums','oums.id','=','m_products.oum_id')
					->leftJoin('products','products.id','=','m_products.product_id')
					->leftJoin('purchaseorders',function($join){
						$join->on('purchaseorders.id','=','m_products.module_id')
						->where('purchaseorders.status','=',1);
					})
					->where(function ($query){
						$query->where('purchaseorders.status', '=', 1)
							->orWhere('m_products.module_type', '=', 'in_stock');
					})
					->where('product_stocks.in_stock','>',0)
					->leftJoin('companies','companies.id','=','m_products.company_id')
					->leftJoin('product_stocks','m_products.id','=','product_stocks.m_product_id');

		foreach ($arr_filter as $key => $value) {
			if($value!=''){
				if($arr_filter['sku']!=''){
					$list_product->where('products.sku',$arr_filter['sku']);
				}elseif($key == 'like_name'){
					$list_product->where('products.name','LIKE',"%".$arr_filter['like_name']."%");
					$arr_filter['name']='';
				}elseif($key == 'name' && $arr_filter['name']!=''){
					$list_product->where('products.name',$arr_filter['name']);
				}elseif($key == 'company_id'){
					$list_product->where('m_products.company_id',$arr_filter['company_id']);
				}elseif($key == 'status'){
					$list_product->where('products.status',$arr_filter['status']);
				}elseif($key == 'oum_id'){
					$list_product->where('m_products.oum_id',$arr_filter['oum_id']);
				}else{
					$a=1;
				}

			}
		}
		$sum_invest =  $list_product->sum('invest');
		foreach ($arr_sort as $key => $value) {
			if($key=='company_id'){
				$list_product = $list_product->orderBy('companies.name',$value);
			}elseif($key=='oum_id'){
				$list_product = $list_product->leftJoin('oums','oums.id','=','m_products.oum_id')->orderBy('oums.name',$value);
			}elseif($key=='id'){
				$list_product = $list_product->orderBy('products.id',$value);
			}elseif($key=='specification'){
				$list_product = $list_product->orderBy('m_products.specification',$value);
			}elseif($key=='in_stock'){
				$list_product = $list_product->orderBy('real_in_stock',$value);
			}else{
				$list_product = $list_product->orderBy($key,$value);
			}
		}
		$list_product = $list_product->orderBy('products.id','asc');
		if(!isset($arr_filter['status'])){
			$arr_filter['status'] = '';
		}
		
		$list_product = $list_product->paginate(20);

		return view('popup.choose_product_so', [
								'distributes'		=>$distributes,
								'oums'			=>$oums,
								'list_product'		=> $list_product,
								'list_all_product'	=>$list_all_product,
								'arr_sort' 		=> $arr_sort,
								'arr_filter' 		=> $arr_filter,
							        ]);
	}

	public function anyListPopupRpo(Request $request)
	{
		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort = (array)json_decode($arr_sort);
		}else{
			$arr_sort = array();
		}

		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}else{
			$arr_filter =[
						'sku' => '',
						'name' => '',
						'company_id' => '',
						'oum_id' => '',
						];
		}
		session(['sort_filter_product_rpo.arr_sort' => $arr_sort]);
		session(['sort_filter_product_rpo.arr_filter'=> $arr_filter]);

		$distributes = array();
		$oums = array();
		$list_sku = array();

		$distributes = Company::getDistributeList()->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$list_all_product = Product::select('sku','name')->get()->toArray();

		$current_rpo = ReturnPurchaseorder::find(session('current_returnpurchaseorder'));

		$list_product = MProduct::select('products.name',
		                                'products.sku',
		                                'm_products.id',
		                                'm_products.oum_id',
		                                'm_products.specification',
		                                'product_stocks.in_stock',
		                                'companies.name as company_name',
		                                'm_products.module_id'
		                                )
					->with('oum')
					->leftJoin('products','products.id','=','m_products.product_id')
					->leftJoin('purchaseorders',function($join){
						$join->on('purchaseorders.id','=','m_products.module_id')
						->where('purchaseorders.status','=',1);
					})
					->where(function ($query){
						$query->where('m_products.module_type','=','App\\Purchaseorder')
							->orWhere('m_products.module_type', '=', 'in_stock');
					})
					->where('product_stocks.in_stock','>',0)
					->leftJoin('companies','companies.id','=','m_products.company_id')
					->leftJoin('product_stocks','m_products.id','=','product_stocks.m_product_id')
					->where('m_products.company_id','=',$current_rpo->company_id);

		if(count($arr_sort)==0){
			$list_product = $list_product->orderBy('products.id','asc');
		}

			foreach ($arr_filter as $key => $value) {
				if($value!=''){
					if($arr_filter['sku']!=''){
						$list_product->where('products.sku',$arr_filter['sku']);
					}elseif($arr_filter['name']!=''){
						$list_product->where('products.name',$arr_filter['name']);
					}elseif($key == 'company_id'){
						$list_product->where('m_products.company_id',$arr_filter['company_id']);
					}elseif($key == 'oum_id'){
						$list_product->where('products.oum_id',$arr_filter['oum_id']);
					}else{
						$list_product->where($key,$value);
					}

				}
			}
		$list_product = $list_product->paginate(20);
		return view('popup.choose_product_rpo', [
								'distributes'		=>$distributes,
								'oums'			=>$oums,
								'list_product'		=> $list_product,
								'list_all_product'		=>$list_all_product,
								'arr_sort' 		=> $arr_sort,
								'arr_filter' 		=> $arr_filter
							        ]);
	}


	public function anyListPopupRso(Request $request)
	{
		DB::enableQueryLog();
		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort = (array)json_decode($arr_sort);
		}else{
			$arr_sort = array();
		}

		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}else{
			$arr_filter =[
						'sku' => '',
						'name' => '',
						'company_id' => '',
						'oum_id' => '',
						];
		}
		session(['sort_filter_product_rso.arr_sort' => $arr_sort]);
		session(['sort_filter_product_rso.arr_filter'=> $arr_filter]);

		$distributes = array();
		$oums = array();
		$list_sku = array();

		$distributes = Company::getDistributeList()->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$list_all_product = Product::select('sku','name')->get()->toArray();

		$current_rso = ReturnSaleorder::find(session('current_returnsaleorder'));

		$list_product = MProduct::select('products.name',
		                                'products.sku',
		                                'm_products.id',
		                                'm_products.oum_id',
		                                'm_products.specification',
		                                'm_products.quantity',
		                                'companies.name as company_name',
		                                'm_products.module_id'
		                                )
					->with('oum')
					->leftJoin('products','products.id','=','m_products.product_id')
					->leftJoin('saleorders',function($join){
						$join->on('saleorders.id','=','m_products.module_id')
						->where('saleorders.status','=',1);
					})
					->where('m_products.module_type','=','App\\Saleorder')
					->where('saleorders.status','=',1)
					->leftJoin('companies','companies.id','=','m_products.company_id')
					->where('m_products.company_id','=',$current_rso->company_id);

		$list_product_id_so = MProduct::select('m_products.id')
					->leftJoin('saleorders',function($join){
						$join->on('saleorders.id','=','m_products.module_id')
						->where('saleorders.status','=',1);
					})
					->where('m_products.module_type','=','App\\Saleorder')
					->where('saleorders.status','=',1)
					->where('m_products.company_id','=',$current_rso->company_id)
					->lists('m_products.id');

		$list_product_rso = MProduct::select('m_products.id',
		                                'm_products.m_product_id_so',
		                                'm_products.specification',
		                                'm_products.quantity'
		                                )
					->leftJoin('return_saleorders',function($join){
						$join->on('return_saleorders.id','=','m_products.module_id')
						->where('return_saleorders.status','=',1);
					})
					->where('m_products.module_type','=','App\\ReturnSaleorder')
					->where('return_saleorders.status','=',1)
					->whereIn('m_product_id_so',$list_product_id_so)
					->where('m_products.company_id','=',$current_rso->company_id)->get();
		if(count($arr_sort)==0){
			$list_product = $list_product->orderBy('products.id','asc');
		}

			foreach ($arr_filter as $key => $value) {
				if($value!=''){
					if($arr_filter['sku']!=''){
						$list_product->where('products.sku',$arr_filter['sku']);
					}elseif($arr_filter['name']!=''){
						$list_product->where('products.name',$arr_filter['name']);
					}elseif($key == 'company_id'){
						$list_product->where('m_products.company_id',$arr_filter['company_id']);
					}elseif($key == 'oum_id'){
						$list_product->where('products.oum_id',$arr_filter['oum_id']);
					}else{
						$list_product->where($key,$value);
					}

				}
			}
		$list_product = $list_product->paginate(20);
		foreach ($list_product as $key => $value) {
			$list_product[$key]->so_le = 0;
			foreach ($list_product_rso as $key1 => $value1) {
				if($value1->m_product_id_so==$value->id){
					$so_luong_con = ($list_product[$key]->quantity * $list_product[$key]->specification) + $list_product[$key]->so_le - ($value1->quantity * $value1->specification);
					$list_product[$key]->quantity = floor($so_luong_con/$list_product[$key]->specification);
					$list_product[$key]->so_le = $so_luong_con%$list_product[$key]->specification;
				}
			}
		}
		// pr($list_product->toArray());
		// die;
		// echo $current_rso->company_id;
		// print_r(DB::getQueryLog());
		// pr($list_product->toArray());die;
		return view('popup.choose_product_rso', [
								'distributes'		=> $distributes,
								'oums'			=> $oums,
								'list_product'		=> $list_product,
								'list_all_product'		=> $list_all_product,
								'arr_sort' 		=> $arr_sort,
								'arr_filter' 		=> $arr_filter
							        ]);
	}

	public function anySearchProduct(Request $request){
		$arr_return = array();
		$key = $request->has('key')?$request->input('key'):'';
		$key = '%'.$key.'%';
		$module_id = session('current_purchaseorder');
		$module_type = 'App\\Purchaseorder';
		$arr_product_of_po = Mproduct::where('module_id','=',$module_id)
						->where('module_type','=',$module_type)
						->lists('product_id');

		$arr_return = Product::select('id','sku','name')
				->where(function($query) use ($key){
					$query->where('sku','like',$key)
						->orWhere('name','like',$key);
				})
				->whereNotIn('id',$arr_product_of_po)
				->orderBy('sku')
				->limit(15)
				->get()->toArray();
		return $arr_return;
	}

	public function anySearchProductByKey(Request $request){
		$arr_return = array();
		$key = $request->has('key')?$request->input('key'):'';
		$key = '%'.$key.'%';
		
		$arr_return = Product::select('id','sku','name')
				->where(function($query) use ($key){
					$query->where('sku','like',$key)
						->orWhere('name','like',$key);
				})
				->limit(15)
				->get()->toArray();
		return $arr_return;
	}

	public function anySearchProductStock(Request $request){
		//DB::enableQueryLog();
		$arr_return = array();
		$key = $request->has('key')?$request->input('key'):'';
		$key = '%'.$key.'%';
		$module_id = session('current_saleorder');
		$module_type = 'App\\Saleorder';
		$arr_product_of_so = Mproduct::where('module_id','=',$module_id)
						->where('module_type','=',$module_type)
						->lists('m_product_id');
		$arr_product_of_so = array_values($arr_product_of_so);
		// pr($arr_product_of_so);die;
		$arr_return = MProduct::select(
					'm_products.id',
					'products.name',
					'products.sku',
					'm_products.product_id',
					'm_products.oum_id',
					'm_products.specification',
					'm_products.origin_price',
					'm_products.invest',
					'product_stocks.in_stock',
					'companies.name as company_name',
					'oums.name as oum_name',
					'm_products.module_id',
					'purchaseorders.date'
		                                )
					->addSelect(DB::raw('product_stocks.in_stock/m_products.specification as real_in_stock'))
					->leftJoin('oums','oums.id','=','m_products.oum_id')
					->leftJoin('products','products.id','=','m_products.product_id')
					->leftJoin('purchaseorders',function($join){
						$join->on('purchaseorders.id','=','m_products.module_id')
						->where('purchaseorders.status','=',1);
					})
					->where(function ($query){
						$query->where('purchaseorders.status', '=', 1)
							->orWhere('m_products.module_type', '=', 'in_stock');
					})
					->where('product_stocks.in_stock','>',0)
					->where(function($query) use ($key){
						$query->where('products.sku','like',$key)
						->orWhere('products.name','like',$key);
					})
					->whereNotIn('m_products.id',$arr_product_of_so)
					->leftJoin('companies','companies.id','=','m_products.company_id')
					->leftJoin('product_stocks','m_products.id','=','product_stocks.m_product_id')
					->orderBy('products.name')
					->orderBy('purchaseorders.date')
					->limit(15)
					->get()->toArray();

		//pr(DB::getQueryLog());die;

		foreach ($arr_return as $key => $value) {
			if($value['date']==''){
				$arr_return[$key]['date'] = 'Tồn kho';
			}else{
				$arr_return[$key]['date'] = date('d/m/Y',strtotime($value['date']));
			}
			
		}
		return $arr_return;
	}


	public function anyExportPdf(){
		$id_template = 2;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'sku',
								'name',
								'company_name',
								'oum_name',
								'specification',
								'ton_kho',
								'origin_price',
								'invest'
								],
						'arr_head' => 	[
								['text'=>'Mã','class'=>''],
								['text'=>'Tên sản phẩm','class'=>''],
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Đơn vị','class'=>''],
								['text'=>'Quy cách','class'=>''],
								['text'=>'Tồn kho','class'=>''],
								['text'=>'Giá gốc','class'=>'money'],
								['text'=>'Vốn lưu','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_product'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_product'.\Auth::user()->id);
			$sum_invest = 0;
			foreach ($arr_cache as $key => $value) {
				$sum_invest += $value['origin_price']*$value['in_stock'];
				$arr_cache[$key]['ton_kho'] = floor($value['in_stock'] / $value['specification']).' '.$value['oum_name'];
				$arr_cache[$key]['invest'] = $value['origin_price']*$value['in_stock'];
				if($value['in_stock']%$value['specification'] && $value['specification']!=1){
					$sodu = $value['in_stock']%$value['specification'];
					$arr_cache[$key]['ton_kho'] .= ' + '.$sodu.' '.'cái';
				}
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng vốn lưu:','colspan'=>'7'],
				['value'=>$sum_invest]
			];
			$arr_print['arr_list']['arr_body'] = $arr_cache;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'danh_sach_san_pham','landscape');
			return redirect($link);
		}
		die;
	}

	public function anyLog(){
		$list_log = Log::select('logs.*','users.name')
				->where('module_type','=','App\Product')
				->leftJoin('users','users.id','=','logs.user_id')
				->orderBy('id','desc')
				->paginate(50);
		$this->layout->content=view('log.log', ['list_log'=>$list_log]);
	}


	public function getCreateTonDauThang(){
		$list_month = ReceiptMonth::select('month','year')
									->distinct()->where('month','>',0)
									->orderBy('year','ASC')
									->orderBy('month','ASC')
									->get()->toArray();
		foreach ($list_month as $key => $value) {
			$check = TonDauThang::where('month','=',$value['month'])
								->where('year','=',$value['year'])
								->get()->first();
			if(!$check){
				if($key==0){
					$arr_insert = array();
					$list_instock = Mproduct::where('module_type','=','in_stock')
									->get()->toArray();

					foreach ($list_instock as $key2 => $value2) {
						$arr_insert[$key2]['m_product_id'] = $value2['id'];
						$arr_insert[$key2]['quantity'] = $value2['quantity']*$value2['specification'];
						$arr_insert[$key2]['month'] = $value['month'];
						$arr_insert[$key2]['year'] = $value['year'];
					}
					TonDauThang::insert($arr_insert);
				}else{
					$arr_insert = array();
					$list_prev_month = TonDauThang::where('month','=',$list_month[$key-1]['month'])
												->where('year','=',$list_month[$key-1]['year'])
												->get();
					foreach ($list_prev_month as $key2 => $value2) {
						$arr_insert[$value2['m_product_id']]['m_product_id'] = $value2['m_product_id']; 
						$arr_insert[$value2['m_product_id']]['quantity'] = $value2['quantity']; 
						$arr_insert[$value2['m_product_id']]['month'] = $list_month[$key]['month']; 
						$arr_insert[$value2['m_product_id']]['year'] = $list_month[$key]['year']; 
					}
					$list_product_po = Mproduct::select('m_products.*')
												->where('module_type','=','App\\Purchaseorder')
												->leftJoin('purchaseorders','module_id','=','purchaseorders.id')
												->whereRaw('MONTH(`purchaseorders`.`date`)='.$list_month[$key-1]['month'])
												->whereRaw('YEAR(`purchaseorders`.`date`)='.$list_month[$key-1]['year'])
				 	                         ->get()->toArray();
					foreach ($list_product_po as $key2 => $value2) {
						$arr_insert[$value2['m_product_id']]['m_product_id'] = $value2['id'];
						$arr_insert[$value2['m_product_id']]['quantity'] = $value2['quantity']*$value2['specification'];
						$arr_insert[$value2['m_product_id']]['month'] = $value['month'];
						$arr_insert[$value2['m_product_id']]['year'] = $value['year'];
					}

					$list_product_rpo = Mproduct::select('m_products.*')
												->where('module_type','=','App\\ReturnPurchaseorder')
												->leftJoin('return_purchaseorders','module_id','=','return_purchaseorders.id')
												->whereRaw('MONTH(`return_purchaseorders`.`date`)='.$list_month[$key-1]['month'])
												->whereRaw('YEAR(`return_purchaseorders`.`date`)='.$list_month[$key-1]['year'])
				 	                         ->get()->toArray();
				 	foreach ($list_product_rpo as $key2 => $value2) {
						if(isset($arr_insert[$value2['m_product_id']])){
							$arr_insert[$value2['m_product_id']]['quantity'] -= $value2['quantity']*$value2['specification'];
						}
					}

					$list_product_so = Mproduct::select('m_products.*')
												->where('module_type','=','App\\Saleorder')
												->leftJoin('saleorders','module_id','=','saleorders.id')
												->whereRaw('MONTH(`saleorders`.`date`)='.$list_month[$key-1]['month'])
												->whereRaw('YEAR(`saleorders`.`date`)='.$list_month[$key-1]['year'])
				 	                         ->get()->toArray();
				 	foreach ($list_product_so as $key2 => $value2) {
						if(isset($arr_insert[$value2['m_product_id']])){
							$arr_insert[$value2['m_product_id']]['quantity'] -= $value2['quantity']*$value2['specification'];
						}
					}

					$list_product_rpo = Mproduct::select('m_products.*')
												->where('module_type','=','App\\ReturnPurchaseorder')
												->leftJoin('return_purchaseorders','module_id','=','return_purchaseorders.id')
												->whereRaw('MONTH(`return_purchaseorders`.`date`)='.$list_month[$key-1]['month'])
												->whereRaw('YEAR(`return_purchaseorders`.`date`)='.$list_month[$key-1]['year'])
				 	                         ->get()->toArray();
				 	foreach ($list_product_rpo as $key2 => $value2) {
						if(isset($arr_insert[$value2['m_product_id']])){
							$arr_insert[$value2['m_product_id']]['quantity'] += $value2['quantity']*$value2['specification'];
						}
					}
					TonDauThang::insert($arr_insert);
				}
			}
		}
		echo "Done !";
		die;
	}

	public function anyTonDauThang(Request $request){


		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort =(array) json_decode($arr_sort);
		}elseif( session('sort_filter_product_ton_dau_thang.arr_sort') !== null){
			$arr_sort = session('sort_filter_product_ton_dau_thang.arr_sort');
		}else{
			$arr_sort=array();
		}
		session('sort_filter_product_ton_dau_thang.arr_sort', $arr_sort);

		$list_month = ReceiptMonth::select('month','year')
									->distinct()->where('month','>',0)
									->orderBy('year','ASC')
									->orderBy('month','ASC')
									->get()->toArray();
		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}elseif( session('sort_filter_product_ton_dau_thang.arr_filter') !== null ){
			$arr_filter = session('sort_filter_product_ton_dau_thang.arr_filter');
		}else{
			$arr_filter=[
					'sku'=>'',
					'like_name'=>'',
					'name'=>'',
					'company_id'=>'',
					'oum_id'=>''
				       ];
			if(count($list_month)){
				$arr_filter['month'] = $list_month[0]['month'].'-'.$list_month[0]['year'];
			}
		}

		session(['sort_filter_product_ton_dau_thang.arr_sort'=>$arr_sort]);
		session(['sort_filter_product_ton_dau_thang.arr_filter'=> $arr_filter]);

		$list_all_product = Product::select('sku','name')->orderBy('sku')->get()->toArray();
		$list_month = array();
		//Init array
		$distributes = array();
		$oums = array();
		$producttypes = array();
		$list_sku = array();
		//Get value array
		$distributes = Company::getDistributeList()->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$producttypes = ProductType::get()->toArray();
		$list_all_product = Product::select('sku','name')->orderBy('sku')->get()->toArray();

		$list_product = TonDauThang::select(
					'products.id',
					'products.name',
					'products.sku',
					'ton_dau_thangs.quantity',
					'ton_dau_thangs.month',
					'ton_dau_thangs.year',
					'm_products.oum_id',
					'm_products.specification',
					'm_products.origin_price',
					'companies.name as company_name',
					'oums.name as oum_name'
		            )
					->addSelect(DB::raw('product_stocks.in_stock/m_products.specification as real_in_stock'))
					->leftJoin('m_products','m_products.id','=','ton_dau_thangs.m_product_id')
					->leftJoin('products','products.id','=','m_products.product_id')
					->leftJoin('oums','oums.id','=','m_products.oum_id')	
					->leftJoin('companies','companies.id','=','m_products.company_id')
					->leftJoin('product_stocks','m_products.id','=','product_stocks.m_product_id')
					->groupBy('products.id','m_products.company_id','m_products.oum_id','m_products.specification','m_products.origin_price')
					->where('ton_dau_thangs.quantity','>',0);

					
		foreach ($arr_filter as $key => $value) {
			if($value!=''){
				if($arr_filter['sku']!=''){
					$list_product->where('products.sku',$arr_filter['sku']);
				}
				if($key == 'like_name'){
					$list_product->where('products.name','LIKE',"%".$arr_filter['like_name']."%");
					$arr_filter['name']='';
				}
				if($key == 'name' && $arr_filter['name']!=''){
					$list_product->where('products.name',$arr_filter['name']);
				}
				if($key == 'company_id'){
					$list_product->where('m_products.company_id',$arr_filter['company_id']);
				}
				if($key == 'status'){
					$list_product->where('products.status',$arr_filter['status']);
				}
				if($key == 'oum_id'){
					$list_product->where('m_products.oum_id',$arr_filter['oum_id']);
				}
				if($key == 'month' && $arr_filter['month'] !=''){
					$month_year = explode('-',$arr_filter['month']);
					$list_product->where('ton_dau_thangs.month','=',$month_year[0])
								->where('ton_dau_thangs.year','=',$month_year[1]);
				}
			}
		}

		foreach ($arr_sort as $key => $value) {
			if($key=='company_id'){
				$list_product = $list_product->orderBy('companies.name',$value);
			}elseif($key=='oum_id'){
				$list_product = $list_product->orderBy('oums.name',$value);
			}elseif($key=='id'){
				$list_product = $list_product->orderBy('products.id',$value);
			}elseif($key=='specification'){
				$list_product = $list_product->orderBy('m_products.specification',$value);
			}elseif($key=='quantity'){
				$list_product = $list_product->orderBy('ton_dau_thangs.quantity',$value);
			}else{
				$list_product = $list_product->orderBy($key,$value);
			}
		}
		$list_month = ReceiptMonth::select('month','year')
									->distinct()->where('month','>',0)
									->orderBy('year','ASC')
									->orderBy('month','ASC')
									->get()->toArray();
		$list_product = $list_product->orderBy('products.id','asc');
		\Cache::put('list_product'.\Auth::user()->id, $list_product->get()->toArray(), 30);
		$sum_invest =  0;

		foreach ($list_product->get()->toArray() as $key => $value) {
			$sum_invest += $value['origin_price'] * $value['quantity'];
		}
		$list_product = $list_product->paginate(100);

		$this->layout->content=view('product.list-ton-dau-thang', [
								'distributes'			=> $distributes,
								'oums'					=> $oums,
								'producttypes'			=> $producttypes,
								'list_product'			=> $list_product,
								'list_all_product'		=> $list_all_product,
								'arr_sort' 				=> $arr_sort,
								'arr_filter' 			=> $arr_filter,
								'sum_invest'			=> $sum_invest,
								'list_month'			=> $list_month
							        ]);
	}

	public function anyExportExcel(){
		if (\Cache::has('list_product'.\Auth::user()->id)){
			
			
			\Excel::create('Danh_san_pham', function($excel){
				$excel->sheet('Danh_san_pham', function($sheet){
					$cache = \Cache::get('list_product'.\Auth::user()->id);
					$sheet->row(1, array(
						 'STT',
					     'Mã',
					     'SKU',
					     'Tên Sản Phẩm',
					     'Nhà Cung Cấp',
					     'Đơn Vị',
					     'Quy Cách',
					     'Tồn Kho',
					     'Giá Gốc',
					     'Vốn Lưu'
					));
					$sheet->setColumnFormat(array(
					    'I' => '#,##0',
					    'J'	=> '#,##0'
					));
					$sheet->cell('A1:J1', function($cell){
						$cell->setFontWeight('bold');
					});
					$index=0;
					foreach ($cache as $key => $value) {
						$index++;
						$arr_tmp = array();
						$arr_tmp[] = $index;
						$arr_tmp[] = isset($value['product_id'])?$value['product_id']:$value['id'];
						$arr_tmp[] = $value['sku'];
						$arr_tmp[] = $value['name'];
						$arr_tmp[] = $value['company_name'];
						$arr_tmp[] = $value['oum_name'];
						$arr_tmp[] = $value['specification'];
						if(isset($value['quantity'])){
							$value['in_stock'] = $value['quantity'];
						}
						if($value['in_stock'] % $value['specification'] ==0){
							$arr_tmp[] = ($value['in_stock'] / $value['specification']).' '.$value['oum_name'];
						}else{
							$arr_tmp[] = ($value['in_stock'] / $value['specification']).' '.$value['oum_name'].' + '.($value['in_stock'] % $value['specification']).' cái';
						}
						
						$arr_tmp[] = $value['origin_price'];
						$arr_tmp[] = $value['origin_price']*$value['in_stock'];
						$sheet->appendRow($arr_tmp);
					}

					$sheet->mergeCells('A'.($index+2).':'.'I'.($index+2));
					$sheet->setCellValue('A'.($index+2),'Tổng vốn lưu:');
					$sheet->cell('A'.($index+2), function($cell){
						$cell->setAlignment('right');
						$cell->setFontWeight('bold');
					});
					$sheet->setCellValue('J'.($index+2),'=sum(J2:J'.($index+1).')');

					$sheet->setBorder('A1:J'.($index+2), 'thin');
				});
			})->export('xls');
			die;
		}
	}

	public function anyImportProduct(){
		
		\Excel::load('kho-2015.xls', function($reader) {
		    $results = $reader->get();
		    $company = Company::getDistributeList()->get()->toArray();
		    $arr_company = array();
		    foreach ($company as $key => $value) {
		    	$arr_company[$value['name']] = $value['id'];
		    }
		    // pr($arr_company);die;
		    $arr_oum = array();
		    $oums = Oum::orderBy('name')->get()->toArray();
		    foreach ($oums as $key => $value) {
		    	$arr_oum[$value['name']] = $value['id'];
		    }
		 	foreach ($results as $row) {

		 	 	$product = new Product;
				$product->name = $row['ten_san_pham'];
				$product->sku = $row['sku'];
				// $name_product = $row['ten_san_pham'];
				// $check1 = is_numeric(mb_strpos($name_product, "Áo"));
				// $check2 = is_numeric(mb_strpos($name_product, 'Váy'));
				// $check3 = is_numeric(mb_strpos($name_product, 'Quần'));
				// $check3 = is_numeric(mb_strpos($name_product, 'Đầm'));
				// $check4 = is_numeric(mb_strpos($name_product, 'Bộ')) && is_numeric(mb_strpos($name_product, 'ton'));
				// $check5 = is_numeric(mb_strpos($name_product, 'Bộ')) && is_numeric(mb_strpos($name_product, 'bo'));
				// $check6 = is_numeric(mb_strpos($name_product, 'Bộ')) && is_numeric(mb_strpos($name_product, 'thun'));
				// $check = $check1 || $check2 || $check3 || $check4 || $check5 || $check6;
				if($row['loai_san_pham'] == "Đồ dùng"){
					$product->product_type = 2;
				}else{
					$product->product_type = 1;
				}
				$product->status=0;
				$product->created_by = \Auth::user()->id;
				if($product->save()){
					$mproduct = new MProduct;
					$mproduct->product_id	=	$product->id;
					$mproduct->module_id	= 	0;
					$mproduct->company_id	= 	$arr_company[$row['nha_cung_cap']];
					$mproduct->module_type	=	'in_stock';
					$mproduct->specification	=	$row['quy_cach'];
					$mproduct->oum_id		=	$arr_oum[$row['don_vi_ban']];
					$mproduct->origin_price	=	intval(str_replace(",","",$row['gia_goc']));
					$mproduct->quantity		=	$row['so_luong'];
					$mproduct->invest		=	intval(str_replace(",","",$row['gia_goc']))*intval($row['so_luong'])*intval($row['quy_cach']);
					if($mproduct->save()){
						Product::where('id','=',$product->id)->update(['check_in_stock'=>1]);
						if(intval($row['gia_npp'])>0){
							$sell_price = new SellPrice;
							$sell_price->name = "Giá NPP";
							$sell_price->price = intval($row['gia_npp']);
							$sell_price->product_id = $product->id;
							$sell_price->m_product_id = $mproduct->id;
							$sell_price->save();
						}
						if(intval($row['dai_ly'])>0){
							$sell_price = new SellPrice;
							$sell_price->name = "Giá đại lý";
							$sell_price->price = intval($row['dai_ly']);
							$sell_price->product_id = $product->id;
							$sell_price->m_product_id = $mproduct->id;
							$sell_price->save();
						}
						if(intval($row['shop'])>0){
							$sell_price = new SellPrice;
							$sell_price->name = "Giá bán shop";
							$sell_price->price = intval($row['shop']);
							$sell_price->product_id = $product->id;
							$sell_price->m_product_id = $mproduct->id;
							$sell_price->save();
						}
						if(intval($row['ban_le'])>0){
							$sell_price = new SellPrice;
							$sell_price->name = "Giá bán lẻ";
							$sell_price->price = intval($row['ban_le']);
							$sell_price->product_id = $product->id;
							$sell_price->m_product_id = $mproduct->id;
							$sell_price->save();
						}
					}
				}
		 	}
		 	echo "Done";
		 	die;
		});	
	}


	public function anyAddTrigger(){
		//  Delete Old Trigger
		DB::unprepared('DROP TRIGGER `tr_Create_Company_Address`');
		DB::unprepared('DROP TRIGGER `tr_Delete_Company_Address`');

		DB::unprepared('DROP TRIGGER `tr_Create_PO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Create_SO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Create_RPO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Create_RSO_Address`');

		DB::unprepared('DROP TRIGGER `tr_Delete_PO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Delete_SO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Delete_RPO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Delete_RSO_Address`');

		DB::unprepared('DROP TRIGGER `tr_Create_Mproduct_Productstock`');
		DB::unprepared('DROP TRIGGER `tr_Delete_Mproduct_Productstock`');

		DB::unprepared('DROP TRIGGER `tr_Update_Mproduct_Order`');
		DB::unprepared('DROP TRIGGER `tr_Update_Mproduct_Order_Before`');


		DB::unprepared('DROP TRIGGER `tr_Create_Paid_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Delete_Paid_Receipt_Month`');


		DB::unprepared('DROP TRIGGER `tr_Update_Paid_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Update_PO_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Update_RPO_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Update_SO_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Update_RSO_Receipt_Month`');


		// Create company  --> create address
				DB::unprepared("
					CREATE TRIGGER tr_Create_Company_Address AFTER INSERT ON `companies` FOR EACH ROW
					BEGIN
						INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
						VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\Company', '0', '0', NOW(), NOW());
					END
				");

				DB::unprepared("
					CREATE TRIGGER tr_Delete_Company_Address AFTER DELETE ON `companies` FOR EACH ROW
					BEGIN
						DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\Company';
					END
				");

		// Create order --> create address & create receipt month
				DB::unprepared("
					CREATE TRIGGER tr_Create_PO_Address AFTER INSERT ON `purchaseorders` FOR EACH ROW
					BEGIN
						INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
						VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\Purchaseorder', '0', '0', NOW(), NOW());

					END
				");
				DB::unprepared("
					CREATE TRIGGER tr_Create_SO_Address AFTER INSERT ON `saleorders` FOR EACH ROW
					BEGIN
						INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
						VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\Saleorder', '0', '0', NOW(), NOW());
						
					END
				");
				DB::unprepared("
					CREATE TRIGGER tr_Create_RPO_Address AFTER INSERT ON `return_purchaseorders` FOR EACH ROW
					BEGIN
						INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
						VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\ReturnPurchaseorder', '0', '0', NOW(), NOW());
						
					END
				");
				DB::unprepared("
					CREATE TRIGGER tr_Create_RSO_Address AFTER INSERT ON `return_saleorders` FOR EACH ROW
					BEGIN
						INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
						VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\ReturnSaleorder', '0', '0', NOW(), NOW());
						
					END
				");

		// Delete order --> delete address

				DB::unprepared("
					CREATE TRIGGER tr_Delete_PO_Address AFTER DELETE ON `purchaseorders` FOR EACH ROW
					BEGIN
						DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\Purchaseorder';
					END
				");
				DB::unprepared("
					CREATE TRIGGER tr_Delete_SO_Address AFTER DELETE ON `saleorders` FOR EACH ROW
					BEGIN
						DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\Saleorder';
					END
				");
				DB::unprepared("
					CREATE TRIGGER tr_Delete_RPO_Address AFTER DELETE ON `return_purchaseorders` FOR EACH ROW
					BEGIN
						DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\ReturnPurchaseorder';
					END
				");
				DB::unprepared("
					CREATE TRIGGER tr_Delete_RSO_Address AFTER DELETE ON `return_saleorders` FOR EACH ROW
					BEGIN
						DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\ReturnSaleorder';
					END
				");

		// Create mproduct --> create product stock
				DB::unprepared("
					CREATE TRIGGER tr_Create_Mproduct_Productstock AFTER INSERT ON `m_products` FOR EACH ROW
					BEGIN
						DECLARE status_po INT;
						IF(NEW.module_type = 'App\\\\Purchaseorder') THEN
							SET status_po = (SELECT `status` from `purchaseorders` where `id`=New.module_id);
							IF(status_po=1) THEN
								INSERT INTO `product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
								VALUES (NULL, NEW.id, NEW.product_id, NEW.quantity*NEW.specification, '0', '0', NOW(), NOW());
							ELSE
								INSERT INTO `product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
								VALUES (NULL, NEW.id, NEW.product_id, '0', '0', '0', NOW(), NOW());
							END IF;
						END IF;
						
						IF(NEW.module_type = 'in_stock') THEN
							INSERT INTO `product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
							VALUES (NULL, NEW.id, NEW.product_id, NEW.quantity*NEW.specification, '0', '0', NOW(), NOW());
						END IF;
					END
				");

				DB::unprepared("
					CREATE TRIGGER tr_Delete_Mproduct_Productstock AFTER DELETE ON `m_products` FOR EACH ROW
					BEGIN
						DELETE  FROM `product_stocks` WHERE `m_product_id`=OLD.id;
					END
				");

		// Update Mproduct --> update Amount or Invest
				DB::unprepared("
					CREATE TRIGGER tr_Update_Mproduct_Order AFTER UPDATE ON `m_products` 
					FOR EACH ROW
					BEGIN
					IF NEW.module_type = 'App\\\\Purchaseorder' THEN
					
						UPDATE `purchaseorders` o
						INNER JOIN
						(
						SELECT `module_id`, SUM(`invest`) sum_amount
						FROM `m_products`
						WHERE `module_type` = 'App\\\\Purchaseorder'
						GROUP BY `module_id`
						) i ON o.id = i.module_id
						SET o.sum_amount = i.sum_amount
						WHERE o.id = NEW.module_id
						AND o.status = 1;
					END IF; 
					IF NEW.module_type = 'App\\\\ReturnPurchaseorder' THEN
					
						UPDATE `return_purchaseorders` o
						INNER JOIN
						(
						SELECT `module_id`, SUM(`invest`) sum_amount
						FROM `m_products`
						WHERE `module_type` = 'App\\\\ReturnPurchaseorder'
						GROUP BY `module_id`
						) i ON o.id = i.module_id
						SET o.sum_amount = i.sum_amount
						WHERE o.id = NEW.module_id
						AND o.status = 1;
					END IF; 
					IF NEW.module_type = 'App\\\\Saleorder' THEN
					
						UPDATE `saleorders` o
						INNER JOIN
						(
						SELECT `module_id`, SUM(`amount`) sum_amount
						FROM `m_products`
						WHERE `module_type` = 'App\\\\Saleorder'
						GROUP BY `module_id`
						) i ON o.id = i.module_id
						SET o.sum_amount = i.sum_amount
						WHERE o.id = NEW.module_id
						AND o.status = 1;
					END IF; 
					IF NEW.module_type = 'App\\\\ReturnSaleorder' THEN
					
						UPDATE `return_saleorders` o
						INNER JOIN
						(
						SELECT `module_id`, SUM(`amount`) sum_amount
						FROM `m_products`
						WHERE `module_type` = 'App\\\\ReturnSaleorder'
						GROUP BY `module_id`
						) i ON o.id = i.module_id
						SET o.sum_amount = i.sum_amount
						WHERE o.id = NEW.module_id
						AND o.status = 1;
					END IF; 
					END
				");

		// Update Mproduct
				DB::unprepared("
					CREATE TRIGGER tr_Update_Mproduct_Order_Before BEFORE UPDATE ON `m_products` 
					FOR EACH ROW
					BEGIN
						IF(NEW.specification <> OLD.specification OR NEW.quantity <> OLD.quantity OR NEW.origin_price <> OLD.origin_price OR NEW.sell_price <> OLD.sell_price) THEN
							SET NEW.amount = NEW.specification * NEW.quantity * NEW.sell_price;
							SET NEW.invest = NEW.specification * NEW.quantity * NEW.origin_price;
						END IF;
					END
				");

		// Create Paid --> Create receipt month
				DB::unprepared("
					CREATE TRIGGER tr_Create_Paid_Receipt_Month AFTER INSERT ON `Paids` 
					FOR EACH ROW
					BEGIN
						IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt=NEW.type_paid and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
							INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), NEW.type_paid, '0', NEW.sum_paid, '0', '0', NOW(), NOW(),NEW.company_id);
						ELSE
							UPDATE `receipt_months` SET 
							`paid`=`paid` + (NEW.sum_paid),
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE `month` = MONTH(NEW.date)
							AND `year` = YEAR(NEW.date)
							AND `type_receipt` = NEW.type_paid
							AND `company_id` = NEW.company_id;
						END IF;
					END
				");
		// Delete Paid --> Decrease receipt month
				DB::unprepared("
					CREATE TRIGGER tr_Delete_Paid_Receipt_Month AFTER DELETE ON `Paids` 
					FOR EACH ROW
					BEGIN
						UPDATE `receipt_months` SET 
							`paid`=`paid` - (OLD.sum_paid),
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE `month` = MONTH(OLD.date)
							AND `year` = YEAR(OLD.date)
							AND `type_receipt` = OLD.type_paid
							AND `company_id` = OLD.company_id;
					END
				");
		// Update order --> update receipt month
				DB::unprepared("
					CREATE TRIGGER tr_Update_Paid_Receipt_Month AFTER UPDATE ON `Paids` 
					FOR EACH ROW
					BEGIN
						UPDATE `receipt_months` SET 
						`paid`=`paid` + (NEW.sum_paid - OLD.sum_paid),
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE `month` = MONTH(NEW.date)
						AND `year` = YEAR(NEW.date)
						AND `type_receipt` = NEW.type_paid
						AND `company_id` = NEW.company_id;
					END
				");

				DB::unprepared("
					CREATE TRIGGER tr_Update_PO_Receipt_Month AFTER UPDATE ON `purchaseorders` 
					FOR EACH ROW
					BEGIN
						IF(NEW.status =1 AND OLD.status =0) THEN
							IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='distribute'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
								INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'distribute', NEW.sum_amount, '0', '0', NEW.sum_amount, NOW(), NOW(),NEW.company_id);
							ELSE

								UPDATE `receipt_months` SET 
								`sum_amount`=`sum_amount` + NEW.sum_amount,
								`con_lai`= `sum_amount`+`no_cu`- `paid`
								WHERE  `month` = MONTH(NEW.date)
								AND `year` = YEAR(NEW.date)
								AND `type_receipt` = 'distribute'
								AND `company_id` = NEW.company_id;

							END IF;
						END IF;
						IF(NEW.status =0 AND OLD.status =1) THEN
							UPDATE `receipt_months` SET 
								`sum_amount`=`sum_amount` - OLD.sum_amount,
								`con_lai`= `sum_amount`+`no_cu`- `paid`
								WHERE  `month` = MONTH(OLD.date)
								AND `year` = YEAR(OLD.date)
								AND `type_receipt` = 'distribute'
								AND `company_id` = OLD.company_id;
						END IF;
					END
				");
				DB::unprepared("
					CREATE TRIGGER tr_Update_RPO_Receipt_Month AFTER UPDATE ON `return_purchaseorders` 
					FOR EACH ROW
					BEGIN
						IF(NEW.status =1 AND OLD.status =0) THEN
							IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='distribute'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
								INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'distribute', NEW.sum_amount, '0', '0', '0', NOW(), NOW(),NEW.company_id);
							ELSE
								UPDATE `receipt_months` SET 
								`sum_amount`=`sum_amount` - NEW.sum_amount,
								`con_lai`= `sum_amount`+`no_cu`- `paid`
								WHERE  `month` = MONTH(NEW.date)
								AND `year` = YEAR(NEW.date)
								AND `type_receipt` = 'distribute'
								AND `company_id` = NEW.company_id;
							END IF;
						END IF;
						IF(NEW.status =0 AND OLD.status =1) THEN
							UPDATE `receipt_months` SET 
								`sum_amount`=`sum_amount` + OLD.sum_amount,
								`con_lai`= `sum_amount`+`no_cu`- `paid`
								WHERE  `month` = MONTH(OLD.date)
								AND `year` = YEAR(OLD.date)
								AND `type_receipt` = 'distribute'
								AND `company_id` = OLD.company_id;
						END IF;
					END
				");

				DB::unprepared("
					CREATE TRIGGER tr_Update_SO_Receipt_Month AFTER UPDATE ON `saleorders` 
					FOR EACH ROW
					BEGIN
						IF(NEW.status =1 AND OLD.status =0) THEN
							IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='customer'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
								INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'customer', NEW.sum_amount, '0', '0', NEW.sum_amount, NOW(), NOW(),NEW.company_id);
							ELSE

								UPDATE `receipt_months` SET 
								`sum_amount`=`sum_amount` + NEW.sum_amount,
								`con_lai`= `sum_amount`+`no_cu`- `paid`
								WHERE  `month` = MONTH(NEW.date)
								AND `year` = YEAR(NEW.date)
								AND `type_receipt` = 'customer'
								AND `company_id` = NEW.company_id;

							END IF;
						END IF;
						IF(NEW.status =0 AND OLD.status =1) THEN
							UPDATE `receipt_months` SET 
								`sum_amount`=`sum_amount` - OLD.sum_amount,
								`con_lai`= `sum_amount`+`no_cu`- `paid`
								WHERE  `month` = MONTH(OLD.date)
								AND `year` = YEAR(OLD.date)
								AND `type_receipt` = 'customer'
								AND `company_id` = OLD.company_id;
						END IF;
					END
				");

				DB::unprepared("
					CREATE TRIGGER tr_Update_RSO_Receipt_Month AFTER UPDATE ON `return_saleorders` 
					FOR EACH ROW
					BEGIN
						IF(NEW.status =1 AND OLD.status =0) THEN
							IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='customer'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
								INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'customer', NEW.sum_amount, '0', '0', '0', NOW(), NOW(),NEW.company_id);
							ELSE

								UPDATE `receipt_months` SET 
								`sum_amount`=`sum_amount` - NEW.sum_amount,
								`con_lai`= `sum_amount`+`no_cu`- `paid`
								WHERE  `month` = MONTH(NEW.date)
								AND `year` = YEAR(NEW.date)
								AND `type_receipt` = 'customer'
								AND `company_id` = NEW.company_id;

							END IF;
						END IF;
						IF(NEW.status =0 AND OLD.status =1) THEN
							UPDATE `receipt_months` SET 
								`sum_amount`=`sum_amount` + OLD.sum_amount,
								`con_lai`= `sum_amount`+`no_cu`- `paid`
								WHERE  `month` = MONTH(OLD.date)
								AND `year` = YEAR(OLD.date)
								AND `type_receipt` = 'customer'
								AND `company_id` = OLD.company_id;
						END IF;
					END
				");
			echo "done";die;	
	}

	public function anyImportPrice(){
		set_time_limit(0);
		\Excel::load('gia.xls', function($reader) {
		    	$results = $reader->get();
		 	foreach ($results as $row) {
		 		$row = $row->toArray();
		 		$sku  = $row['sku'];
		 		$product = Product::where('sku','=',$sku)->first();
		 		$mproducts = MProduct::where('product_id','=',$product->id)
		 						->where(function ($query){
									$query->where('module_type','in_stock')
		 						          ->orwhere('module_type','App\\Purchaseorder');
								})
		 						->get();
		 		foreach ($mproducts as $key => $value) {
					$sell_price = new SellPrice;
					$sell_price->name = "Giá hot cấp 2";
					$sell_price->price = intval($row['gia_hot_cap_2']);
					$sell_price->product_id = $product->id;
					$sell_price->m_product_id = $value->id;
					$sell_price->save();
		 		}
		 	 }
		});
		echo "done";
		die;	
	}
}