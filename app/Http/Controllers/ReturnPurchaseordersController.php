<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use App\MProduct;
use App\Company;
use App\Country;
use App\Province;
use App\ReceiptMonth;
use App\User;
use App\Oum;
use App\ProductStock;
use App\ReturnPurchaseorder;
use App\Purchaseorder;
use App\Paid;
use App\Log;
use App\Address;
use App\SellPrice;
use Datatables;
use Illuminate\Http\Request;
use Session;
use DB;

class ReturnPurchaseordersController extends Controller {
	/**
	* Show the profile for the given user.
	*
	* @param  int  $id
	* @return Response
	*/
	
	public function getIndex(Request $request){
		self::anyEntry($request);
	}

	public function anyClear(Request $request){
		Session::forget('product_of_rpo'.session('current_returnpurchaseorder'));
		Session::forget('current_returnpurchaseorder');
		return redirect('returnpurchaseorders');
	}

	public function anyCreate(Request $request)
	{
		$returnpurchaseorder = new ReturnPurchaseorder;
		$returnpurchaseorder->date = date("Y-m-d H:i:s");
		$returnpurchaseorder->created_by = \Auth::user()->id;
		if($returnpurchaseorder->save()){
			session(['current_returnpurchaseorder' => $returnpurchaseorder->id]);
		}
		return redirect('returnpurchaseorders');
	}

	public function anyDelete(Request $request)
	{
		$arr_return = array('status'=>'error');
		$id_returnpurchaseorder = session('current_returnpurchaseorder') !== null ? session('current_returnpurchaseorder') : 0;
		if($id_returnpurchaseorder){
			$returnpurchaseorder = ReturnPurchaseorder::find($id_returnpurchaseorder);
			if(!$returnpurchaseorder->status){
				if($returnpurchaseorder->delete()){
					// Address::where('module_id','=',$id_returnpurchaseorder)->where('module_type','=','App\\ReturnPurchaseorder')->delete();
					$list_mproduct = Mproduct::where('module_id','=',$id_returnpurchaseorder)
									->where('module_type','=','App\\ReturnPurchaseorder')
									->lists('id');
					MProduct::whereIn('id',$list_mproduct)->delete();
					Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder','Xóa đơn hàng trả nhà cung cấp số '.$returnpurchaseorder->id);
					$arr_return['status'] = 'success';
				}else{
					$arr_return['message'] = 'Delete fail !';
				}
			}else{
				header('Content-Type: text/html; charset=utf-8');
				echo  'Không thể xóa hóa đơn đã hoàn thành';die;
			}

			Session::forget('current_returnpurchaseorder');
		}else{
			$arr_return['message'] = 'Không tìm thấy hóa đơn';
		}
		return $arr_return;
	}


	public function getDeleteFromList(Request $request,$id=0)
	{
		$id_returnpurchaseorder = $id;
		if($id_returnpurchaseorder){
			$returnpurchaseorder = ReturnPurchaseorder::find($id_returnpurchaseorder);
			if(!$returnpurchaseorder->status){
				if($returnpurchaseorder->delete()){
					// Address::where('module_id','=',$id_returnpurchaseorder)->where('module_type','=','App\\ReturnPurchaseorder')->delete();
					$list_mproduct = Mproduct::where('module_id','=',$id_returnpurchaseorder)
									->where('module_type','=','App\\ReturnPurchaseorder')
									->lists('id');
					MProduct::whereIn('id',$list_mproduct)->delete();
					Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder','Xóa đơn hàng trả nhà cung cấp số '.$returnpurchaseorder->id);
				}
			}
		}
		return redirect('returnpurchaseorders/list');
	}

	public function anyEntry(Request $request,$id=null)
	{
		\DB::enableQueryLog();
		if(isset($id) && $id!=null){
			$id_return_purchaseorder = $id;
			$returnpurchaseorder = ReturnPurchaseorder::find($id_return_purchaseorder);
			if($returnpurchaseorder != null){
				session(['current_returnpurchaseorder' => $returnpurchaseorder['id']]);
			}else{
				return redirect('returnpurchaseorders');
			}
		}else{
			$id_return_purchaseorder = session('current_returnpurchaseorder') !== null ? session('current_returnpurchaseorder') : 0;
			if($id_return_purchaseorder){
				$returnpurchaseorder = ReturnPurchaseorder::find($id_return_purchaseorder);
				session(['current_returnpurchaseorder' => $returnpurchaseorder['id']]);
			}else{
				$returnpurchaseorder = ReturnPurchaseorder::get()->last();
				if($returnpurchaseorder){
					session(['current_returnpurchaseorder' => $returnpurchaseorder['id']]);
				}else{
					$returnpurchaseorder = new ReturnPurchaseorder;
					$returnpurchaseorder->date = date("Y-m-d H:i:s");
					$returnpurchaseorder->created_by = \Auth::user()->id;
					$returnpurchaseorder->save();
					Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder','Tạo mới đơn hàng trả nhà cung cấp số '.$returnpurchaseorder->id);
					session(['current_returnpurchaseorder' => $returnpurchaseorder->id]);
				}
			}
		}
		$address = Address::where('module_id','=',$returnpurchaseorder->id)
					->where('module_type','=','App\\ReturnPurchaseorder')->first();
		$address_province = isset($address->province_id)?$address->province_id:0;
		$country_province = Province::addSelect('provinces.name as province_name')
						->where('provinces.id','=',$address_province)
						->addSelect('countries.name as country_name')
						->leftJoin('countries','countries.id','=','provinces.country_id')
						->first();
		if($country_province){
			$country_province->toArray();
			$purchaseorder['province_name'] = $country_province['province_name'];
			$purchaseorder['country_name'] = $country_province['country_name'];
		}else{
			$purchaseorder['province_name'] = '';
			$purchaseorder['country_name'] = '';
		}
		if($address){
			$address = $address->toArray();
		}else{
			$address = array();
		}
		$returnpurchaseorder = $returnpurchaseorder->toArray();
		$returnpurchaseorder['province_name'] = isset($country_province->province_name)?$country_province->province_name:'';
		$returnpurchaseorder['country_name'] = isset($country_province->country_name)?$country_province->country_name:'';
		// var_dump(DB::getQueryLog());
		// pr($returnpurchaseorder);die;

		//Init array
		$distributes = array();
		$oums = array();
		$users = array();
		$countries = array();
		$list_product = array();

		//Get value array
		$distributes = Company::getDistributeList()->with('address')->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$users = User::get();
		$countries = Country::with('provinces')->get()->toArray();

		$arr_product = MProduct::where('module_type','=','App\\ReturnPurchaseorder')
						->where('module_id','=',$returnpurchaseorder['id'])
						->lists('product_id');

		Session::forget('product_of_rpo'.session('current_returnpurchaseorder'));
		foreach ($arr_product as $key => $value) {
			Session::put('product_of_rpo'.session('current_returnpurchaseorder').".".$value , $value);
		}

		$view_list_product = self::getListProduct();

		$arr_create = ReturnPurchaseorder::select('users.name','return_purchaseorders.created_at')
					->leftJoin('users','users.id','=','return_purchaseorders.created_by')
					->where('return_purchaseorders.id','=',$returnpurchaseorder['id'])
					->get()->first()->toArray();

		$arr_update = ReturnPurchaseorder::select('users.name','return_purchaseorders.updated_at')
					->leftJoin('users','users.id','=','return_purchaseorders.updated_by')
					->where('return_purchaseorders.id','=',$returnpurchaseorder['id'])
					->get()->first()->toArray();
		$this->layout->arr_create = $arr_create;
		$this->layout->arr_update = $arr_update;

		$this->layout->content=view('returnpurchaseorder.entry',[	'distributes'=>$distributes,
										'users'=>$users,
										'countries'=>$countries,
										'returnpurchaseorder'=>$returnpurchaseorder,
										'address'=>$address,
										'oums'=>$oums,
										'view_list_product'=>$view_list_product
									]);
	}

	public function postUpdate(Request $request)
	{
		$arr_return = array(
					'status' => 'error',
					'message'=>''
				);
		$time =date('H:i:s', time());
		$id_return_purchaseorder = session('current_returnpurchaseorder') !== null ? session('current_returnpurchaseorder') : 0;
		if($id_return_purchaseorder){
			$returnpurchaseorder = ReturnPurchaseorder::find($id_return_purchaseorder);
			session(['current_returnpurchaseorder' => $returnpurchaseorder['id']]);
			$time = date('H:i:s', strtotime($returnpurchaseorder->date));
		}else{

			$returnpurchaseorder = new ReturnPurchaseorder;
			$returnpurchaseorder->date = date("Y-m-d H:i:s");
			$returnpurchaseorder->created_by = \Auth::user()->id;
			$returnpurchaseorder->save();
			Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder','Tạo mới đơn hàng trả nhà cung cấp số '.$returnpurchaseorder->id);
			session(['current_returnpurchaseorder' => $returnpurchaseorder->id]);
		}
		$log = '';
		$old_company_id = $returnpurchaseorder->company_id;
		if($returnpurchaseorder->status == 0){
			$address = Address::where('module_id','=',$returnpurchaseorder->id)
						->where('module_type','=','App\\ReturnPurchaseorder')->first();
			if(!$address){
				$address = new Address;
			}
			if($request->has('company_id')  && $returnpurchaseorder->company_id != $request->input('company_id')){
				$old = Company::find($returnpurchaseorder->company_id);
				if(!$old){
					$old = (object) ['name'=>''];
				}
				$new = Company::find($request->input('company_id'));
				$log .= 'công ty từ "'.$old->name.'" thành "'.$new->name.'" ';
			}
			if($returnpurchaseorder->company_id == $request->input('company_id')){

				if($request->has('user_id')  && $returnpurchaseorder->user_id != $request->input('user_id')){
					$old = User::find($returnpurchaseorder->user_id);
					if(!$old){
						$old = (object) ['name'=>''];
					}
					$new = User::find($request->input('user_id'));
					$log .= 'người liên hệ từ "'.$old->name.'" thành "'.$new->name.'" ';
				}

				$old_date=date("Y-m-d",strtotime($returnpurchaseorder->date));
				$new_date = date("Y-m-d",strtotime($request->input('date')));
				if($request->has('date')  && $old_date != $new_date){
					$log .= 'ngày từ "'.$old_date.'" thành "'.$new_date.'" ';
				}

				if($request->has('company_phone')  && $returnpurchaseorder->company_phone != $request->input('company_phone')){
					$log .= 'số điện thoại từ "'.$returnpurchaseorder->company_phone.'" thành "'.$request->input('company_phone').'" ';
				}

				if($request->has('company_email')  && $returnpurchaseorder->company_email != $request->input('company_email')){
					$log .= 'email từ "'.$returnpurchaseorder->company_email.'" thành "'.$request->input('company_email').'" ';
				}
				if($request->has('address')  && $address->address != $request->input('address')){
					$log .= 'địa chỉ từ "'.$address->address.'" thành "'.$request->input('address').'" ';
				}
				if($request->has('town_city')  && $address->town_city != $request->input('town_city')){
					$log .= 'quận huyện từ "'.$address->town_city.'" thành "'.$request->input('town_city').'" ';
				}

				if($request->has('province_id')  && $address->province_id != $request->input('province_id')){
					$old = Province::find($address->province_id);
					$new = Province::find($request->input('province_id'));
					if(!$old){
						$old = (object) ['name'=>''];
					}
					$log .= 'tỉnh thành từ "'.$old->name.'" thành "'.$new->name.'" ';
				}
				if($request->has('country_id')  && $address->country_id != $request->input('country_id')){
					$old = Country::find($address->country_id);
					$new = Country::find($request->input('country_id'));
					if(!$old){
						$old = (object) ['name'=>''];
					}
					$log .= 'quốc gia từ "'.$old->name.'" thành "'.$new->name.'" ';
				}
			}
			$returnpurchaseorder->company_id = $request->has('company_id') ? $request->input('company_id') : 0;
			$returnpurchaseorder->user_id = $request->has('user_id') ? $request->input('user_id') : 0;
			$returnpurchaseorder->date = $request->has('date') ? date("Y-m-d H:i:s",strtotime($request->input('date').' '.$time)) : date("Y-m-d H:i:s");
			$returnpurchaseorder->company_phone = $request->has('company_phone') ? $request->input('company_phone') : '';
			$returnpurchaseorder->company_email = $request->has('company_email') ? $request->input('company_email') : '';
			$address_id = isset($returnpurchaseorder->address_id) ? $returnpurchaseorder->address_id : 0;

			

			$address->module_id  = $returnpurchaseorder->id;
			$address->module_type  = 'App\\ReturnPurchaseorder';
			$address->address  = $request->has('address') ? $request->input('address') : '';
			$address->town_city  = $request->has('town_city') ? $request->input('town_city') : '';
			$address->zip_postcode  = $request->has('zip_postcode') ? $request->input('zip_postcode') : '';
			$address->country_id  = $request->has('country_id') ? $request->input('country_id') : 0;
			$address->province_id  = $request->has('province_id') ? $request->input('province_id') : 0;
			$address->save();
			$returnpurchaseorder->address_id = $address->id;
		}else{
			$returnpurchaseorder->sum_amount = 0;
			$returnpurchaseorder->sum_invest = 0;
		}
		$old_status = $returnpurchaseorder->status;
		$returnpurchaseorder->status = $request->has('status')?1:0;
		$check_save_in_stock = true;
		if($returnpurchaseorder->status){
			$arr_mproduct = Mproduct::select('m_products.id','quantity','specification','name','m_product_id','invest','amount')
							->where('module_id', '=', $returnpurchaseorder->id)
							->where('module_type', '=', 'App\\ReturnPurchaseorder')
							->leftJoin('products','products.id','=','m_products.product_id')
							->get()->toArray();
			foreach ($arr_mproduct as $key => $mproduct) {
				$returnpurchaseorder->sum_amount = $returnpurchaseorder->sum_amount + $mproduct['amount'];
				$returnpurchaseorder->sum_invest = $returnpurchaseorder->sum_invest + $mproduct['invest'];
				$mproduct_po = Mproduct::find($mproduct['m_product_id']);
				$product_stock = ProductStock::where('m_product_id','=',$mproduct_po->id)->first();
				$product_stock->in_stock = $product_stock->in_stock -  ($mproduct['quantity']*$mproduct['specification']);
				if($product_stock->in_stock < 0){
					$check_save_in_stock = false;
					$arr_return['message'] .= 'Số lượng sản phẩm '.$mproduct['name'].' nhập vào lớn hơn số lượng đã nhập<br/><br/>';
				}
			}
		}else{
			if($old_status != $returnpurchaseorder->status){
				$arr_mproduct = Mproduct::select('m_products.id','quantity','specification','name','m_product_id')
								->where('module_id', '=', $returnpurchaseorder->id)
								->where('module_type', '=', 'App\\ReturnPurchaseorder')
								->leftJoin('products','products.id','=','m_products.product_id')
								->get()->toArray();
				foreach ($arr_mproduct as $key => $mproduct) {
					$mproduct_po = Mproduct::find($mproduct['m_product_id']);
					$product_stock = ProductStock::where('m_product_id','=',$mproduct_po->id)->first();
					$product_stock->in_stock = $product_stock->in_stock + ($mproduct['quantity']*$mproduct['specification']);
					$product_stock->save();
				}
			}
		}

		if($check_save_in_stock){
			$returnpurchaseorder->updated_by = \Auth::user()->id;
			if($returnpurchaseorder->save()){
				Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder','Cập nhật '.$log.' đơn hàng trả nhà cung cấp số '.$returnpurchaseorder->id);
				if($returnpurchaseorder->status){
					foreach ($arr_mproduct as $key => $mproduct) {
						$mproduct_po = Mproduct::find($mproduct['m_product_id']);
						$product_stock = ProductStock::where('m_product_id','=',$mproduct_po->id)->first();
						$product_stock->in_stock = $product_stock->in_stock -  ($mproduct['quantity']*$mproduct['specification']);
						$product_stock->save();
					}
				}

				if($old_company_id != $returnpurchaseorder->company_id){
					Mproduct::where('module_id', '=', $returnpurchaseorder->id)
						->where('module_type', '=', 'App\\ReturnPurchaseorder')
						->where('company_id','=',$old_company_id)
						->delete();
				}else{
					Mproduct::where('module_id', '=', $returnpurchaseorder->id)
						->where('module_type', '=', 'App\\ReturnPurchaseorder')
						->update(['company_id' => $returnpurchaseorder->company_id ]);
				}
				$arr_return['status']= 'success';
			}else{
				$arr_return['message']= 'Saving fail !';
			}
		}
		return $arr_return;
	}

	public function anyListClear(Request $request)
	{
		Session::forget('sort_filter_returnpurchaseorder');
		return redirect('returnpurchaseorders/list');
	}

	public function anyList(Request $request)
	{
		\DB::enableQueryLog();
		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort =(array) json_decode($arr_sort);
		}elseif( session('sort_filter_returnpurchaseorder.arr_sort') !== null){
			$arr_sort = session('sort_filter_returnpurchaseorder.arr_sort');
		}else{
			$arr_sort=array();
		}
		session('sort_filter_returnpurchaseorder.arr_sort', $arr_sort);


		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}elseif( session('sort_filter_returnpurchaseorder.arr_filter') !== null ){
			$arr_filter = session('sort_filter_returnpurchaseorder.arr_filter');
		}else{
			$arr_filter=[
					'id'=>'',
					'company_id'=>'',
					'date'=>'',
					'status'=>''
				       ];
		}
		session(['sort_filter_returnpurchaseorder.arr_sort'=>$arr_sort]);
		session(['sort_filter_returnpurchaseorder.arr_filter'=> $arr_filter]);

		//Init array
		$distributes = array();
		$list_id = array();
		$list_date = array();
		$list_returnpurchaseorder = array();

		//Get value array
		$distributes = Company::getDistributeList()->get()->toArray();
		$list_id = ReturnPurchaseorder::lists('id');
		$list_date = ReturnPurchaseorder::orderBy('date','desc')->lists('date');
		foreach ($list_date as $key => $value) {
			$list_date[$key] = date('d-m-Y',strtotime($value));
		}
		$list_date = array_unique($list_date);

		$list_returnpurchaseorder = ReturnPurchaseorder::select('suminvest.sum_invest','return_purchaseorders.*','companies.name as company_name')->with('company')
					->leftJoin(
							DB::raw(' (
									select module_id, module_type,sum(invest) as sum_invest 
									from m_products where module_type = "App\\ReturnPurchaseorder" group by  module_id 
								    ) as suminvest'), function($join){
								$join->on('return_purchaseorders.id', '=', 'module_id');
							}
						)
					->leftJoin('companies','companies.id','=','return_purchaseorders.company_id');
		foreach ($arr_sort as $key => $value) {
			if($key=='company_id'){
				$list_returnpurchaseorder = $list_returnpurchaseorder->orderBy('companies.name',$value);
			}else{
				$list_returnpurchaseorder = $list_returnpurchaseorder->orderBy($key,$value);
			}
		}
		if($arr_filter['id']!=''){
			$list_returnpurchaseorder->where('id',$arr_filter['id']);
		}else{
			foreach ($arr_filter as $key => $value) {
				if($value!=''){
					if($key=='date'){
						$now = date("Y-m-d H:i:s",strtotime($arr_filter['date']));
						$tomorow = date("Y-m-d H:i:s",strtotime($arr_filter['date'])+86400);
						$list_returnpurchaseorder->where('date','>=',$now)->where('date','<',$tomorow);
					}else{
						$list_returnpurchaseorder->where($key,$value);
					}
				}
			}
		}
		if(!count($arr_sort)){
			$list_returnpurchaseorder = $list_returnpurchaseorder->orderBy('id','desc');
		}
		if(!isset($arr_filter['status'])){
			$arr_filter['status'] = '';
		}
		
		$list_returnpurchaseorder = $list_returnpurchaseorder->paginate(20);
		foreach($list_returnpurchaseorder as $key => $rpo){
			$list_returnpurchaseorder[$key]['date'] = date('d-m-Y',strtotime($rpo['date']));
		}
		\Cache::put('list_returnpurchaseorder'.\Auth::user()->id, $list_returnpurchaseorder, 30);


		// var_dump(DB::getQueryLog());die;
		$this->layout->content=view('returnpurchaseorder.list', [
								'distributes'			=>	$distributes,
								'arr_sort' 			=> 	$arr_sort,
								'arr_filter' 			=> 	$arr_filter,
								'list_id' 				=>	$list_id,
								'list_date' 			=>	$list_date,
								'list_returnpurchaseorder'	=>	$list_returnpurchaseorder
							        ]);
	}

	public function postAddProductSession(Request $request){
		$arr_id = $request->has('id')?$request->input('id'):array();
		foreach ($arr_id as $key => $value) {
			Session::put('product_of_rpo'.session('current_returnpurchaseorder').".".$value , $value);
		}
		return '';
	}

	public function postRemoveProductSession(Request $request){
		$arr_id = $request->has('id')?$request->input('id'):array();
		foreach ($arr_id as $key => $value) {
			Session::forget('product_of_rpo'.session('current_returnpurchaseorder').".".$value);
		}
		return '';
	}

	public function anyAddProduct(Request $request){
		$arr_return = array(
			"status"=>'success'
		);
		$company_id = $request->has('company_id')?$request->input('company_id'):0;
		$module_id = session('current_returnpurchaseorder');
		$module_type = 'App\\ReturnPurchaseorder';
		$arr_product = session('product_of_rpo'.session('current_returnpurchaseorder'));
		$arr_product_of_rpo = Mproduct::where('module_id','=',$module_id)
						->where('module_type','=',$module_type)
						->lists('m_product_id');

		$log = "";
		foreach ($arr_product as $key => $m_product_id) {
			if(!in_array($m_product_id, $arr_product_of_rpo)){
				$product = MProduct::find($m_product_id);
				$mproduct = new MProduct;
				$mproduct->product_id	=	$product->product_id;
				$mproduct->m_product_id	=	$product->id;
				$mproduct->module_id	= 	$module_id;
				$mproduct->company_id	= 	$product->company_id;
				$mproduct->module_type	=	$module_type;
				$mproduct->specification	=	$product->specification;
				$mproduct->oum_id		=	$product->oum_id;
				$mproduct->origin_price	=	$product->origin_price;
				$mproduct->save();
				$product = Product::find($mproduct->product_id);
				if($log==""){
					$log .= "Thêm sản phẩm ".$product->sku;
				}else{
					$log .= ", ".$product->sku;
				}
			}
		}

		$log_delete = "";
		foreach ($arr_product_of_rpo as $key => $m_product_id) {
			if(!in_array($m_product_id, $arr_product)){
				$mproduct = MProduct::where('module_id','=',$module_id)
						->where('module_type','=',$module_type)
						->where('m_product_id','=',$m_product_id)->first()->toArray();

				$m_product_id_delete = $mproduct['m_product_id'];
				$quantity = $mproduct['quantity'];
				$check = MProduct::where('module_id','=',$module_id)
						->where('module_type','=',$module_type)
						->where('m_product_id','=',$m_product_id_delete)->delete();
				$product = Product::find($mproduct['product_id']);
				if($log==""){
					$log .= "xóa sản phẩm ".$product->sku;
				}else{
					$log .= ", ".$product->sku;
				}
			}
		}
		if($log_delete !="")
			Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder',$log.' và .'.$log_delete.' đơn hàng trả nhà cung cấp số '.session('current_returnpurchaseorder'));
		else
			Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder',$log.' vào đơn hàng trả nhà cung cấp số '.session('current_returnpurchaseorder'));
		$returnpurchaseorder = ReturnPurchaseorder::find(session('current_returnpurchaseorder'));
		$returnpurchaseorder->updated_by = \Auth::user()->id;
		$returnpurchaseorder->save();
		self::getListProduct();
		return $arr_return;
	}

	public function getListProduct(){
		$id = session('current_returnpurchaseorder');
		$returnpurchaseorder = ReturnPurchaseorder::select('status','company_id')->where('id','=',$id)->first()->toArray();
		//Init array
		$distributes = array();
		$oums = array();
		$list_product = array();

		//Get value
		$distributes = Company::getDistributeList()->with('address')->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$list_product = MProduct::select('m_products.*','products.sku','products.name')->where('module_type','=','App\\ReturnPurchaseorder')
						->where('module_id','=',$id)
						->where('company_id','=',$returnpurchaseorder['company_id'])
						->leftJoin('products','products.id','=','m_products.product_id')
						->addSelect('oums.name as oum_name')
						->leftJoin('oums','oums.id','=','m_products.oum_id')
						->get()->toArray();


		Session::forget('product_of_rpo'.session('current_returnpurchaseorder'));
		foreach ($list_product as $key => $value) {
			Session::put('product_of_rpo'.session('current_returnpurchaseorder').".".$value['m_product_id'] , $value['m_product_id']);
		}

		\Cache::put('list_product_rpo'.\Auth::user()->id, $list_product, 30);
		return view('returnpurchaseorder.list-product',[	'distributes'=>$distributes,
							'oums'=>$oums,
							'list_product'=>$list_product,
							'returnpurchaseorder'=>$returnpurchaseorder
						]);
	}

	public function postUpdateMproduct(Request $request){
		$arr_return= array('status'=>'error','invest'=>0);
		$id = $request->has('id')?$request->input('id'):0;
		$log="";
		if($id){
			$mproduct = MProduct::find($id);
			$mproduct_po = Mproduct::find($mproduct->m_product_id);
			if($request->has('oum_id')  && $mproduct->oum_id != $request->input('oum_id')){
				$old = Oum::find($mproduct->oum_id);
				$new = Oum::find($request->input('oum_id'));
				if($old){
					$log .= 'đơn vị từ "'.$old->name.'" thành "'.$new->name.'" ';
				}else{
					$log .= 'đơn vị từ " " thành "'.$new->name.'" ';
				}
			}
			if($request->has('sell_price')  && $mproduct->sell_price != $request->input('sell_price')){
				$log .= 'giá bán từ "'.$mproduct->sell_price.'" thành "'.$request->input('sell_price').'" ';
			}
			if($request->has('specification')  && $mproduct->specification != $request->input('specification')){
				$log .= 'quy cách từ "'.$mproduct->specification.'" thành "'.$request->input('specification').'" ';
			}
			if($request->has('quantity')  && $mproduct->quantity != $request->input('quantity')){
				$log .= 'số lượng từ "'.$mproduct->quantity.'" thành "'.$request->input('quantity').'" ';
			}
			$mproduct->oum_id =  $request->has('oum_id')?$request->input('oum_id'):0;
			$mproduct->origin_price =  $request->has('origin_price')?$request->input('origin_price'):0;
			$mproduct->specification =  $request->has('specification')?$request->input('specification'):0;
			$old_quantity = $mproduct->quantity ;
			$mproduct->quantity =  $request->has('quantity')?$request->input('quantity'):0;
			$product_stock = ProductStock::where('m_product_id','=',$mproduct_po->id)->first();
			$so_luong_con = $product_stock->in_stock;
			$product_stock->in_stock = $product_stock->in_stock - ($mproduct->quantity*$mproduct->specification);
			$mproduct->invest = $mproduct->specification* $mproduct->quantity* $mproduct->origin_price;
			if($product_stock->in_stock >=0){
				if( !$mproduct->status){
					if($mproduct->save()){
						$product = Product::find($mproduct->product_id);
						Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder','cập nhật '.$log.' sản phẩm '.$product->sku.' đơn hàng trả nhà cung cấp số '.session('current_returnpurchaseorder'));
						$arr_return['status'] = 'success';
						$arr_return['invest'] = number_format( $mproduct->invest );
					}else{
						$arr_return['message'] = 'Saving fail !';
					}
				}else{
					$arr_return['message'] = 'Đơn hàng đã hoàn thành không thể cập nhật';
				}
			}else{
				$arr_return['message'] = 'Số lượng trả '.$mproduct->name.' lớn hơn số lượng đã nhập<br/> Số lượng đã nhập là '.$so_luong_con.' cái';
			}
		}

		$id = session('current_returnpurchaseorder');
		//Init array
		$list_product = array();

		//Get value
		$returnpurchaseorder = ReturnPurchaseorder::find(session('current_returnpurchaseorder'));
		$list_product = MProduct::select('m_products.*','products.sku','products.name')->where('module_type','=','App\\ReturnPurchaseorder')
						->where('module_id','=',$id)
						->where('company_id','=',$returnpurchaseorder['company_id'])
						->leftJoin('products','products.id','=','m_products.product_id')
						->addSelect('oums.name as oum_name')
						->leftJoin('oums','oums.id','=','m_products.oum_id')
						->get()->toArray();
		\Cache::put('list_product_rpo'.\Auth::user()->id, $list_product, 30); 
		$returnpurchaseorder->updated_by = \Auth::user()->id;
		$returnpurchaseorder->save();
		self::getListProduct();
		return $arr_return;
	}

	public function postDeleteProduct(Request $request){
		$arr_return= array('status'=>'error');
		$id = $request->has('id')?$request->input('id'):0;
		if($id){
			$mproduct = MProduct::find($id);
			$id_product = $mproduct->m_product_id;
			$quantity = $mproduct->quantity;
			$specification = $mproduct->specification;
			$check  = MProduct::where('id','=',$id)->delete();
			if($check){
				// $product = ProductStock::find($id_product);
				// $product->in_stock = $product->in_stock + $quantity*$specification;
				// $product->save();
				$product = Product::find($mproduct->product_id);
				Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder','Xóa sản phẩm '.$product->sku.' đơn hàng trả nhà cung cấp số '.session('current_returnpurchaseorder'));
				$arr_return['status'] = 'success';
			}else{
				$arr_return['message'] = 'Saving fail !';
			}
		}
		$returnpurchaseorder = ReturnPurchaseorder::find(session('current_returnpurchaseorder'));
		$returnpurchaseorder->updated_by = \Auth::user()->id;
		$returnpurchaseorder->save();
		self::getListProduct();
		return $arr_return;
	}

	public function anyExportPdf(){
		$id_template = 3;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'sku',
								'name',
								'oum_name',
								'specification',
								'quantity',
								'origin_price',
								'invest'
								],
						'arr_head' => 	[
								['text'=>'Mã','class'=>''],
								['text'=>'Tên sản phẩm','class'=>''],
								['text'=>'Đơn vị','class'=>'center'],
								['text'=>'Quy cách','class'=>'center'],
								['text'=>'Số lượng','class'=>'center'],
								['text'=>'Đơn giá','class'=>'money'],
								['text'=>'Thành tiền','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[
							'id'=>session('current_returnpurchaseorder')
						]
				];	
		if (\Cache::has('list_product_rpo'.\Auth::user()->id)){
			$rpo = ReturnPurchaseorder::select('return_purchaseorders.*','companies.name')->where('return_purchaseorders.id','=',session('current_returnpurchaseorder'))
							->leftJoin('companies','companies.id','=','return_purchaseorders.company_id')->get()->first();
			$month = intval(date('m',strtotime($rpo->date)));
			$year = intval(date('Y',strtotime($rpo->date)));
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			$end = $rpo->date;
			$list_order = array();
			$key_order = 1;
			$arr_print['arr_data']['date'] = date('d-m-Y',strtotime($rpo->date));
			$arr_print['arr_data']['company_name'] = $rpo->name;
			$arr_print['arr_data']['phone'] = $rpo->company_phone;
			$arr_print['arr_data']['address'] = '';
			$arr_dress = Address::select('addresses.*','provinces.name as province_name')
						->where('addresses.id','=',$rpo->address_id)
						->leftJoin('provinces','provinces.id','=','addresses.province_id')
						->get()->first();
			$arr_print['arr_data']['address'] .= $arr_dress->address?$arr_dress->address.', ':'';
			$arr_print['arr_data']['address'] .= $arr_dress->town_city?$arr_dress->town_city.', ':'';
			$arr_print['arr_data']['address'] .= $arr_dress->province_name?$arr_dress->province_name:'';

			$receipt_month_prev = ReceiptMonth::where('type_receipt','=','distribute')
								->where('company_id','=',$rpo->company_id)
								->where(function($query) use ($month,$year){
									$query->where(function($query2) use ($month,$year){
										$query2->where('month','<',$month)
											->where('year','=',$year);
									})->orWhere(function($query2) use ($month,$year){
										$query2->where('year','<',$year);
									});
								})
								->orderBy('year','desc')
								->orderBy('month','desc')
								->limit(1);
			$receipt_month_prev = $receipt_month_prev->first();

			if($receipt_month_prev){
				$arr_print['arr_data']['no_cu'] = $receipt_month_prev->con_lai;
			}else{
				$arr_print['arr_data']['no_cu'] = 0;
			}
			
			$list_po = Purchaseorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$rpo->company_id)
					->get()->toArray();
			foreach ($list_po as $key => $value) {
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
				$key_order++;
			}
			$list_rpo = ReturnPurchaseorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$rpo->company_id)
					->get()->toArray();

			foreach ($list_rpo as $key => $value) {
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
				$key_order++;
			}

			$list_paid = Paid::where('date','>=',$begin)
						->where('date','<',$end)
						->where('company_id','=',$rpo->company_id)
						->where('type_paid','=','distribute')
						->get()->toArray();
			foreach ($list_paid as $key => $value) {
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_paid'];
				$key_order++;
			}
			$date = array();
			foreach ($list_order as $key => $value) {
				$date[$key] = $value['date'];
			}
			array_multisort($date,SORT_ASC,$list_order);
			foreach ($list_order as $key => $value) {
				$arr_print['arr_data']['no_cu']+=$value['sum_amount'];
			}

			$arr_cache = \Cache::get('list_product_rpo'.\Auth::user()->id);
			$sum_invest = 0;
			foreach ($arr_cache as $key => $value) {
				$sum_invest += $value['invest'];
			}
			if($rpo->status==0){
				$arr_print['arr_data']['no_cu'] = 0;
			}
			$arr_print['arr_data']['toa_moi'] = $sum_invest;
			$arr_print['arr_data']['tong_cong'] = $arr_print['arr_data']['no_cu'] - $arr_print['arr_data']['toa_moi'];

			$arr_print['arr_data']['no_cu'] = number_format($arr_print['arr_data']['no_cu']);
			$arr_print['arr_data']['toa_moi'] = number_format(-$arr_print['arr_data']['toa_moi']);
			$arr_print['arr_data']['tong_cong'] = number_format($arr_print['arr_data']['tong_cong']);
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng cộng:','colspan'=>'6'],
				['value'=>$sum_invest]
			];
			$arr_print['arr_list']['arr_body'] = $arr_cache;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'phieu_tra_hang_ncc_so_'.$rpo->id,'potrait');
			Log::create_log(\Auth::user()->id,'App\\ReturnPurchaseorder','In đơn hàng trả nhà cung cấp số '.session('current_returnpurchaseorder'));
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfList(){
		$id_template = 10;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'id',
								'company_name',
								'date',
								'status',
								'sum_amount'
								],
						'arr_head' => 	[
								['text'=>'Mã HĐ','class'=>''],
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Ngày trả hàng','class'=>''],
								['text'=>'Tình trạng','class'=>''],
								['text'=>'Tổng tiền','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_returnpurchaseorder'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_returnpurchaseorder'.\Auth::user()->id);
			$total_sum_amount = 0;
			foreach ($arr_cache as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				
				if($value['status']){
					$arr_cache[$key]['status'] = 'Hoàn thành';
				}else{
					$arr_cache[$key]['status'] = 'Mới';
				}
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng cộng:','colspan'=>'4'],
				['value'=>$total_sum_amount],
			];
			$arr_print['arr_list']['arr_body'] = $arr_cache;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'danh_sach_tra_hang_ncc','potrait');
			return redirect($link);
		}
		die;
	}

	public function anyLog(){
		$list_log = Log::select('logs.*','users.name')
				->where('module_type','=','App\\ReturnPurchaseorder')
				->leftJoin('users','users.id','=','logs.user_id')
				->orderBy('id','desc')
				->paginate(50);

		$this->layout->content=view('log.log', ['list_log'=>$list_log]);
	}
}
