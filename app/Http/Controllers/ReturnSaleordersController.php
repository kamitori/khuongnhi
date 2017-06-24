<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use App\MProduct;
use App\Company;
use App\Country;
use App\Province;
use App\User;
use App\Oum;
use App\ProductStock;
use App\ReturnSaleorder;
use App\ReceiptMonth;
use App\Saleorder;
use App\Paid;
use App\Log;
use App\Address;
use App\SellPrice;
use Datatables;
use Illuminate\Http\Request;
use Session;
use DB;

class ReturnSaleordersController extends Controller {
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
		Session::forget('product_of_rso'.session('current_returnsaleorder'));
		Session::forget('current_returnsaleorder');
		return redirect('returnsaleorders');
	}

	public function anyCreate(Request $request)
	{
		$returnsaleorder = new ReturnSaleorder;
		$returnsaleorder->date = date("Y-m-d H:i:s");
		$returnsaleorder->created_by = \Auth::user()->id;
		if($returnsaleorder->save()){
			Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','Tạo mới đơn hàng đại lý trả số '.$returnsaleorder->id);
			session(['current_returnsaleorder' => $returnsaleorder->id]);
		}
		return redirect('returnsaleorders');
	}

	public function anyDelete(Request $request)
	{
		$arr_return = array('status'=>'error');
		$id_returnsaleorder = session('current_returnsaleorder') !== null ? session('current_returnsaleorder') : 0;
		if($id_returnsaleorder){
			$returnsaleorder = ReturnSaleorder::find($id_returnsaleorder);
			if(!$returnsaleorder->status){
				if($returnsaleorder->delete()){
					// Address::where('module_id','=',$id_returnsaleorder)->where('module_type','=','App\\ReturnSaleorder')->delete();
					$list_mproduct = Mproduct::where('module_id','=',$id_returnsaleorder)
									->where('module_type','=','App\\ReturnSaleorder')
									->lists('id');
					MProduct::whereIn('id',$list_mproduct)->delete();
					Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','Xóa đơn hàng đại lý trả số '.$returnsaleorder->id);
					$arr_return['status'] = 'success';
				}else{
					$arr_return['message'] = 'Delete fail !';
				}
			}else{
				header('Content-Type: text/html; charset=utf-8');
				echo  'Không thể xóa hóa đơn đã hoàn thành';die;
			}

			Session::forget('current_returnsaleorder');
		}else{
			$arr_return['message'] = 'Không tìm thấy hóa đơn';
		}
		return $arr_return;
	}


	public function getDeleteFromList(Request $request,$id=0)
	{
		$id_returnsaleorder = $id;
		if($id_returnsaleorder){
			$returnsaleorder = ReturnSaleorder::find($id_returnsaleorder);
			if(!$returnsaleorder->status){
				if($returnsaleorder->delete()){
					// Address::where('module_id','=',$id_returnsaleorder)->where('module_type','=','App\\ReturnSaleorder')->delete();
					$list_mproduct = Mproduct::where('module_id','=',$id_returnsaleorder)
									->where('module_type','=','App\\ReturnSaleorder')
									->lists('id');
					MProduct::whereIn('id',$list_mproduct)->delete();
					Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','Xóa đơn hàng đại lý trả số '.$returnsaleorder->id);
				}
			}
		}
		return redirect('returnsaleorders/list');
	}

	public function anyEntry(Request $request,$id=null)
	{
		\DB::enableQueryLog();
		if(isset($id) && $id!=null){
			$id_return_saleorder = $id;
			$returnsaleorder = ReturnSaleorder::find($id_return_saleorder);
			if($returnsaleorder != null){
				session(['current_returnsaleorder' => $returnsaleorder['id']]);
			}else{
				return redirect('returnsaleorders');
			}
		}else{
			$id_return_saleorder = session('current_returnsaleorder') !== null ? session('current_returnsaleorder') : 0;
			if($id_return_saleorder){
				$returnsaleorder = ReturnSaleorder::find($id_return_saleorder);
				session(['current_returnsaleorder' => $returnsaleorder['id']]);
			}else{
				$returnsaleorder = ReturnSaleorder::get()->last();
				if($returnsaleorder){
					session(['current_returnsaleorder' => $returnsaleorder['id']]);
				}else{
					$returnsaleorder = new ReturnSaleorder;
					$returnsaleorder->date = date("Y-m-d H:i:s");
					$returnsaleorder->created_by = \Auth::user()->id;
					$returnsaleorder->save();
					Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','Tạo mới đơn hàng đại lý trả số '.$returnsaleorder->id);
					session(['current_returnsaleorder' => $returnsaleorder->id]);
				}
			}
		}
		$address = Address::where('module_id','=',$returnsaleorder->id)
					->where('module_type','=','App\\ReturnSaleorder')->first();
					
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
		$returnsaleorder = $returnsaleorder->toArray();
		$returnsaleorder['province_name'] = isset($country_province->province_name)?$country_province->province_name:'';
		$returnsaleorder['country_name'] = isset($country_province->country_name)?$country_province->country_name:'';

		//Init array
		$distributes = array();
		$oums = array();
		$users = array();
		$countries = array();
		$list_product = array();

		//Get value array
		$distributes = Company::getCustomerList()->with('address')->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();
		$users = User::get();
		$countries = Country::with('provinces')->get()->toArray();

		$arr_product = MProduct::where('module_type','=','App\\ReturnSaleorder')
						->where('module_id','=',$returnsaleorder['id'])
						->lists('m_product_id_so');

		Session::forget('product_of_rso'.session('current_returnsaleorder'));
		foreach ($arr_product as $key => $value) {
			Session::put('product_of_rso'.session('current_returnsaleorder').".".$value , $value);
		}

		$view_list_product = self::getListProduct();

		$arr_create = ReturnSaleorder::select('users.name','return_saleorders.created_at')
					->leftJoin('users','users.id','=','return_saleorders.created_by')
					->where('return_saleorders.id','=',$returnsaleorder['id'])
					->get()->first()->toArray();

		$arr_update = ReturnSaleorder::select('users.name','return_saleorders.updated_at')
					->leftJoin('users','users.id','=','return_saleorders.updated_by')
					->where('return_saleorders.id','=',$returnsaleorder['id'])
					->get()->first()->toArray();
		$this->layout->arr_create = $arr_create;
		$this->layout->arr_update = $arr_update;

		$this->layout->content=view('returnsaleorder.entry',[	'distributes'=>$distributes,
										'users'=>$users,
										'countries'=>$countries,
										'returnsaleorder'=>$returnsaleorder,
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
		$id_return_saleorder = session('current_returnsaleorder') !== null ? session('current_returnsaleorder') : 0;
		if($id_return_saleorder){
			$returnsaleorder = ReturnSaleorder::find($id_return_saleorder);
			session(['current_returnsaleorder' => $returnsaleorder['id']]);
			$time = date('H:i:s', strtotime($returnsaleorder->date));
		}else{

			$returnsaleorder = new ReturnSaleorder;
			$returnsaleorder->date = date("Y-m-d H:i:s");
			$returnsaleorder->created_by = \Auth::user()->id;
			$returnsaleorder->save();
			Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','Tạo mới đơn hàng đại lý trả số '.$returnsaleorder->id);
			session(['current_returnsaleorder' => $returnsaleorder->id]);
		}
		$log = '';
		$old_company_id = $returnsaleorder->company_id;
		if($returnsaleorder->status == 0){
			$address = Address::where('module_id','=',$returnsaleorder->id)
						->where('module_type','=','App\\ReturnSaleorder')->first();
			if(!$address){
				$address = new Address;
			}
			if($request->has('company_id')  && $returnsaleorder->company_id != $request->input('company_id')){
				$old = Company::find($returnsaleorder->company_id);
				if(!$old){
					$old = (object) ['name'=>''];
				}
				$new = Company::find($request->input('company_id'));
				$log .= 'công ty từ "'.$old->name.'" thành "'.$new->name.'" ';
			}
			if($returnsaleorder->company_id == $request->input('company_id')){

				if($request->has('user_id')  && $returnsaleorder->user_id != $request->input('user_id')){
					$old = User::find($returnsaleorder->user_id);
					if(!$old){
						$old = (object) ['name'=>''];
					}
					$new = User::find($request->input('user_id'));
					$log .= 'người liên hệ từ "'.$old->name.'" thành "'.$new->name.'" ';
				}

				$old_date=date("Y-m-d",strtotime($returnsaleorder->date));
				$new_date = date("Y-m-d",strtotime($request->input('date')));
				if($request->has('date')  && $old_date != $new_date){
					$log .= 'ngày từ "'.$old_date.'" thành "'.$new_date.'" ';
				}

				if($request->has('company_phone')  && $returnsaleorder->company_phone != $request->input('company_phone')){
					$log .= 'số điện thoại từ "'.$returnsaleorder->company_phone.'" thành "'.$request->input('company_phone').'" ';
				}

				if($request->has('company_email')  && $returnsaleorder->company_email != $request->input('company_email')){
					$log .= 'email từ "'.$returnsaleorder->company_email.'" thành "'.$request->input('company_email').'" ';
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
			
			$returnsaleorder->company_id = $request->has('company_id') ? $request->input('company_id') : 0;
			$returnsaleorder->user_id = $request->has('user_id') ? $request->input('user_id') : 0;
			$returnsaleorder->date = $request->has('date') ? date("Y-m-d H:i:s",strtotime($request->input('date').' '.$time)) : date("Y-m-d H:i:s");
			$returnsaleorder->company_phone = $request->has('company_phone') ? $request->input('company_phone') : '';
			$returnsaleorder->company_email = $request->has('company_email') ? $request->input('company_email') : '';
			$address_id = isset($returnsaleorder->address_id) ? $returnsaleorder->address_id : 0;

			

			$address->module_id  = $returnsaleorder->id;
			$address->module_type  = 'App\\ReturnSaleorder';
			$address->address  = $request->has('address') ? $request->input('address') : '';
			$address->town_city  = $request->has('town_city') ? $request->input('town_city') : '';
			$address->zip_postcode  = $request->has('zip_postcode') ? $request->input('zip_postcode') : '';
			$address->country_id  = $request->has('country_id') ? $request->input('country_id') : 0;
			$address->province_id  = $request->has('province_id') ? $request->input('province_id') : 0;
			$address->save();
			$returnsaleorder->address_id = $address->id;
		}else{
			$returnsaleorder->sum_amount = 0;
			$returnsaleorder->sum_invest = 0;
		}
		$old_status = $returnsaleorder->status;
		if($returnsaleorder->status != $request->has('status')){
			$log .= 'trạng thái từ "'.($returnsaleorder->status?'Hoàn thành':'Mới').'" thành "'.($request->has('status')?'Hoàn thành':'Mới').'" ';
		}
		$returnsaleorder->status = $request->has('status')?1:0;
		$check_save_in_stock = true;
		if($returnsaleorder->status){
			$arr_mproduct = Mproduct::select('m_products.id','quantity','specification','name','m_product_id','amount','invest')
							->where('module_id', '=', $returnsaleorder->id)
							->where('module_type', '=', 'App\\ReturnSaleorder')
							->leftJoin('products','products.id','=','m_products.product_id')
							->get()->toArray();
			foreach ($arr_mproduct as $key => $mproduct) {
				$returnsaleorder->sum_amount = $returnsaleorder->sum_amount + $mproduct['amount'];
				$returnsaleorder->sum_invest = $returnsaleorder->sum_invest + $mproduct['invest'];
				// $mproduct_po = Mproduct::find();
				$product_stock = ProductStock::where('m_product_id','=',$mproduct['m_product_id'])->first();
				$product_stock->in_stock = $product_stock->in_stock + ($mproduct['quantity']*$mproduct['specification']);
				if($product_stock->in_stock < 0){ 
					$check_save_in_stock = false;
					$arr_return['message'] .= 'Số lượng sản phẩm '.$mproduct['name'].' trả về lớn hơn số lượng đã mua<br/><br/>';
				}
			}
		}else{
			if($old_status != $returnsaleorder->status){
				$arr_mproduct = Mproduct::select('m_products.id','quantity','specification','name','m_product_id')
								->where('module_id', '=', $returnsaleorder->id)
								->where('module_type', '=', 'App\\ReturnSaleorder')
								->leftJoin('products','products.id','=','m_products.product_id')
								->get()->toArray();
				foreach ($arr_mproduct as $key => $mproduct) {
					// $mproduct_po = Mproduct::find($mproduct['m_product_id']);
					$product_stock = ProductStock::where('m_product_id','=',$mproduct['m_product_id'])->first();
					$product_stock->in_stock = $product_stock->in_stock - ($mproduct['quantity']*$mproduct['specification']);
					$product_stock->save();
				}
			}
		}

		if($check_save_in_stock){
			$returnsaleorder->updated_by = \Auth::user()->id;
			if($returnsaleorder->save()){
				Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','Cập nhật '.$log.' đơn hàng đại lý trả số '.$returnsaleorder->id);
				if($returnsaleorder->status){
					foreach ($arr_mproduct as $key => $mproduct) {
						//$mproduct_po = Mproduct::find($mproduct['m_product_id']);
						$product_stock = ProductStock::where('m_product_id','=',$mproduct['m_product_id'])->first();
						$product_stock->in_stock = $product_stock->in_stock +  ($mproduct['quantity']*$mproduct['specification']);
						$product_stock->save();
					}
				}
				if($old_company_id != $returnsaleorder->company_id){
					Mproduct::where('module_id', '=', $returnsaleorder->id)
						->where('module_type', '=', 'App\\ReturnSaleorder')
						->where('company_id','=',$old_company_id)
						->delete();
				}else{
					Mproduct::where('module_id', '=', $returnsaleorder->id)
						->where('module_type', '=', 'App\\ReturnSaleorder')
						->update(['company_id' => $returnsaleorder->company_id ]);
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
		Session::forget('sort_filter_returnsaleorder');
		return redirect('returnsaleorders/list');
	}

	public function anyList(Request $request)
	{
		\DB::enableQueryLog();
		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort =(array) json_decode($arr_sort);
		}elseif( session('sort_filter_returnsaleorder.arr_sort') !== null){
			$arr_sort = session('sort_filter_returnsaleorder.arr_sort');
		}else{
			$arr_sort=array();
		}
		session('sort_filter_returnsaleorder.arr_sort', $arr_sort);


		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}elseif( session('sort_filter_returnsaleorder.arr_filter') !== null ){
			$arr_filter = session('sort_filter_returnsaleorder.arr_filter');
		}else{
			$arr_filter=[
					'id'=>'',
					'company_id'=>'',
					'date'=>'',
					'status'=>''
				       ];
		}
		session(['sort_filter_returnsaleorder.arr_sort'=>$arr_sort]);
		session(['sort_filter_returnsaleorder.arr_filter'=> $arr_filter]);

		//Init array
		$distributes = array();
		$list_id = array();
		$list_date = array();
		$list_returnsaleorder = array();

		//Get value array
		$distributes = Company::getCustomerList()->get()->toArray();
		$list_id = ReturnSaleorder::lists('id');
		$list_date = ReturnSaleorder::orderBy('date','desc')->lists('date');
		foreach ($list_date as $key => $value) {
			$list_date[$key] = date('d-m-Y',strtotime($value));
		}
		$list_date = array_unique($list_date);

		$list_returnsaleorder = ReturnSaleorder::select('return_saleorders.*','sumamount.*','companies.name as company_name')->with('company')
					->leftJoin(
							DB::raw(' (
									select module_id, module_type,sum(amount) as sum_amount 
									from m_products where module_type = "App\\ReturnSaleorder" group by  module_id 
								    ) as sumamount'), function($join){
								$join->on('return_saleorders.id', '=', 'module_id');
							}
						)->leftJoin('companies','companies.id','=','return_saleorders.company_id');
		foreach ($arr_sort as $key => $value) {
			if($key=='company_id'){
				$list_returnsaleorder = $list_returnsaleorder->orderBy('companies.name',$value);
			}else{
				$list_returnsaleorder = $list_returnsaleorder->orderBy($key,$value);
			}
		}
		if($arr_filter['id']!=''){
			$list_returnsaleorder->where('id',$arr_filter['id']);
		}else{
			foreach ($arr_filter as $key => $value) {
				if($value!=''){
					if($key=='date'){
						$now = date("Y-m-d H:i:s",strtotime($arr_filter['date']));
						$tomorow = date("Y-m-d H:i:s",strtotime($arr_filter['date'])+86400);
						$list_returnsaleorder->where('date','>=',$now)->where('date','<',$tomorow);
					}else{
						$list_returnsaleorder->where($key,$value);
					}
				}
			}
		}
		if(!count($arr_sort)){
			$list_returnsaleorder = $list_returnsaleorder->orderBy('id','desc');
		}
		if(!isset($arr_filter['status'])){
			$arr_filter['status'] = '';
		}
		$list_returnsaleorder = $list_returnsaleorder->paginate(20);
		foreach($list_returnsaleorder as $key => $rso){
			$list_returnsaleorder[$key]['date'] = date('d-m-Y',strtotime($rso['date']));
		}
		\Cache::put('list_returnsaleorder'.\Auth::user()->id, $list_returnsaleorder, 30);

		// var_dump(DB::getQueryLog());die;
		$this->layout->content=view('returnsaleorder.list', [
								'distributes'		=>	$distributes,
								'arr_sort' 		=> 	$arr_sort,
								'arr_filter' 		=> 	$arr_filter,
								'list_id' 		=>	$list_id,
								'list_date' 		=>	$list_date,
								'list_returnsaleorder'	=>	$list_returnsaleorder
							        ]);
	}

	public function postAddProductSession(Request $request){
		$arr_id = $request->has('id')?$request->input('id'):array();
		foreach ($arr_id as $key => $value) {
			Session::put('product_of_rso'.session('current_returnsaleorder').".".$value , $value);
		}
		return '';
	}

	public function postRemoveProductSession(Request $request){
		$arr_id = $request->has('id')?$request->input('id'):array();
		foreach ($arr_id as $key => $value) {
			Session::forget('product_of_rso'.session('current_returnsaleorder').".".$value);
		}
		return '';
	}

	public function anyAddProduct(Request $request){
		$arr_return = array(
			"status"=>'success'
		);
		$company_id = $request->has('company_id')?$request->input('company_id'):0;
		$module_id = session('current_returnsaleorder');
		$module_type = 'App\\ReturnSaleorder';
		$arr_product = session('product_of_rso'.session('current_returnsaleorder'));
		$arr_product_of_rso = Mproduct::where('module_id','=',$module_id)
						->where('module_type','=',$module_type)
						->lists('m_product_id_so');

		$log = "";
		foreach ($arr_product as $key => $product_id) {
			if(!in_array($product_id, $arr_product_of_rso)){
				$product = MProduct::find($product_id);
				$mproduct = new MProduct;
				$mproduct->product_id		=	$product->product_id;
				$mproduct->m_product_id	=	$product->m_product_id;
				$mproduct->m_product_id_so	=	$product->id;
				$mproduct->module_id		= 	$module_id;
				$mproduct->company_id	= 	$product->company_id;
				$mproduct->module_type	=	$module_type;
				$mproduct->specification	=	$product->specification;
				$mproduct->oum_id		=	$product->oum_id;
				$mproduct->sell_price		=	$product->sell_price;
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

		foreach ($arr_product_of_rso as $key => $product_id) {
			if(!in_array($product_id, $arr_product)){
				$mproduct = MProduct::where('module_id','=',$module_id)
						->where('module_type','=',$module_type)
						->where('product_id','=',$product_id)->first()->toArray();

				$id_product = $mproduct['product_id'];
				$quantity = $mproduct['quantity'];
				$check = MProduct::where('module_id','=',$module_id)
						->where('module_type','=',$module_type)
						->where('product_id','=',$product_id)->delete();
				$product = Product::find($mproduct['product_id']);
				if($log==""){
					$log .= "xóa sản phẩm ".$product->sku;
				}else{
					$log .= ", ".$product->sku;
				}
			}
		}
		if($log_delete !="")
			Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder',$log.' và .'.$log_delete.' đơn hàng đại lý trả số '.session('current_returnsaleorder'));
		else
			Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder',$log.' vào đơn hàng đại lý trả số '.session('current_returnsaleorder'));
		$returnsaleorder = ReturnSaleorder::find(session('current_returnsaleorder'));
		$returnsaleorder->updated_by = \Auth::user()->id;
		$returnsaleorder->save();
		self::getListProduct();
		return $arr_return;
		
	}

	public function getListProduct(){

		$id = session('current_returnsaleorder');
		$returnsaleorder = ReturnSaleorder::select('status','company_id')->where('id','=',$id)->first()->toArray();
		//Init array
		$distributes = array();
		$oums = array();
		$list_product = array();

		//Get value
		$distributes = Company::getCustomerList()->with('address')->get()->toArray();
		$oums = Oum::orderBy('name')->get()->toArray();

		$list_product = MProduct::select('m_products.*','products.sku','products.name')->where('module_type','=','App\\ReturnSaleorder')
						->where('module_id','=',$id)
						->where('company_id','=',$returnsaleorder['company_id'])
						->leftJoin('products','products.id','=','m_products.product_id')
						->addSelect('oums.name as oum_name')
						->leftJoin('oums','oums.id','=','m_products.oum_id')
						->get()->toArray();

		\Cache::put('list_product_rso'.\Auth::user()->id, $list_product, 30);

		return view('returnsaleorder.list-product',[	'distributes'=>$distributes,
							'oums'=>$oums,
							'list_product'=>$list_product,
							'returnsaleorder'=>$returnsaleorder
						]);
	}

	public function postUpdateMproduct(Request $request){
		$arr_return= array('status'=>'error','amount'=>0);
		$id = $request->has('id')?$request->input('id'):0;
		$log="";
		if($id){
			$mproduct = MProduct::find($id);
			$mproduct_po = Mproduct::find($mproduct->m_product_id);
			$mproduct_so = Mproduct::find($mproduct->m_product_id_so);

			$mproduct_rso_before = Mproduct::where('m_product_id_so','=',$mproduct_so->id)
							->where('module_type','=','App\\ReturnSaleorder')
							->where('company_id','=',$mproduct->company_id)
							->get();
			$mproduct_so->con_lai = $mproduct_so->quantity * $mproduct_so->specification;
			
			foreach ($mproduct_rso_before as $key => $value) {
				$mproduct_so->con_lai -=  $value->quantity * $value->specification;
			}
			$so_luong_con = $mproduct_so->con_lai;
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
			$mproduct->sell_price =  $request->has('sell_price')?$request->input('sell_price'):0;
			$mproduct->specification =  $request->has('specification')?$request->input('specification'):0;
			$old_quantity = $mproduct->quantity ;
			$mproduct->quantity =  $request->has('quantity')?$request->input('quantity'):0;
			$check_return = ($mproduct_so->con_lai - $mproduct->quantity*$mproduct->specification) >=0;

			$mproduct->origin_price = $mproduct_so->origin_price;
			$mproduct->amount = $mproduct->specification* $mproduct->quantity* $mproduct->sell_price;
			$mproduct->invest = $mproduct->specification* $mproduct->quantity* $mproduct->origin_price;
			// if($product_stock->in_stock >=0){
				if( $check_return ){
					if($mproduct->save()){
						$product = Product::find($mproduct->product_id);
						Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','cập nhật '.$log.' sản phẩm '.$product->sku.' đơn hàng đại lý trả số '.session('current_returnsaleorder'));
						$arr_return['status'] = 'success';
						$arr_return['amount'] = number_format( $mproduct->amount );
					}else{ 
						$arr_return['message'] = 'Saving fail !';
					}
				}else{
					$arr_return['message'] = 'Số lượng sản phẩm trả về lớn hơn số lượng còn lại trong kho <br/> Số lượng còn lại trong kho là '.$so_luong_con.' cái';
				}
			// }else{
			// 	$arr_return['message'] = 'Số lượng trả hàng lớn hơn số lượng đã bán';
			// }
		}

		//Init array
		$list_product = array();
		//Get value
		$returnsaleorder = ReturnSaleorder::find(session('current_returnsaleorder'));
		$list_product = MProduct::select('m_products.*','products.sku','products.name')->where('module_type','=','App\\ReturnSaleorder')
						->where('module_id','=',$id)
						->where('company_id','=',$returnsaleorder['company_id'])
						->leftJoin('products','products.id','=','m_products.product_id')
						->addSelect('oums.name as oum_name')
						->leftJoin('oums','oums.id','=','m_products.oum_id')
						->get()->toArray();

		\Cache::put('list_product_rso'.\Auth::user()->id, $list_product, 30);

		
		$returnsaleorder->updated_by = \Auth::user()->id;
		$returnsaleorder->save();
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
				// $product->in_stock = $product->in_stock - $quantity*$specification;
				// $product->save();
				$product = Product::find($mproduct->product_id);
				Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','Xóa sản phẩm '.$product->sku.' đơn hàng đại lý trả số '.session('current_returnsaleorder'));
				$arr_return['status'] = 'success';
			}else{
				$arr_return['message'] = 'Saving fail !';
			}
		}
		$returnsaleorder = ReturnSaleorder::find(session('current_returnsaleorder'));
		$returnsaleorder->updated_by = \Auth::user()->id;
		$returnsaleorder->save();
		self::getListProduct();
		return $arr_return;
	}

	public function anyExportPdf(){
		$id_template = 6;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'sku',
								'name',
								'oum_name',
								'specification',
								'quantity',
								'sell_price',
								'amount'
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
							'id'=>session('current_returnsaleorder')
						]
				];	
		if (\Cache::has('list_product_rso'.\Auth::user()->id)){
			$rso = ReturnSaleorder::select('return_saleorders.*','companies.name')->where('return_saleorders.id','=',session('current_returnsaleorder'))
							->leftJoin('companies','companies.id','=','return_saleorders.company_id')->get()->first();
			$month = intval(date('m',strtotime($rso->date)));
			$year = intval(date('Y',strtotime($rso->date)));
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			$end = $rso->date;
			$list_order = array();
			$key_order = 1;
			$arr_print['arr_data']['date'] = date('d-m-Y',strtotime($rso->date));
			$arr_print['arr_data']['company_name'] = $rso->name;
			$arr_print['arr_data']['phone'] = $rso->company_phone;
			$arr_print['arr_data']['address'] = '';
			$arr_dress = Address::select('addresses.*','provinces.name as province_name')
						->where('addresses.id','=',$rso->address_id)
						->leftJoin('provinces','provinces.id','=','addresses.province_id')
						->get()->first();
			$arr_print['arr_data']['address'] .= $arr_dress->address?$arr_dress->address.', ':'';
			$arr_print['arr_data']['address'] .= $arr_dress->town_city?$arr_dress->town_city.', ':'';
			$arr_print['arr_data']['address'] .= $arr_dress->province_name?$arr_dress->province_name:'';

			$receipt_month_prev = ReceiptMonth::where('type_receipt','=','customer')
								->where('company_id','=',$rso->company_id)
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
			
			$list_po = Saleorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$rso->company_id)
					->get()->toArray();
			foreach ($list_po as $key => $value) {
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
				$key_order++;
			}
			$list_rso = ReturnSaleorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$rso->company_id)
					->get()->toArray();

			foreach ($list_rso as $key => $value) {
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
				$key_order++;
			}

			$list_paid = Paid::where('date','>=',$begin)
						->where('date','<',$end)
						->where('company_id','=',$rso->company_id)
						->where('type_paid','=','customer')
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

			$arr_cache = \Cache::get('list_product_rso'.\Auth::user()->id);
			$sum_amount = 0;
			foreach ($arr_cache as $key => $value) {
				$sum_amount += $value['amount'];
			}
			if($rso->status==0){
				$arr_print['arr_data']['no_cu'] = 0;
			}
			$arr_print['arr_data']['toa_moi'] = $sum_amount;
			$arr_print['arr_data']['tong_cong'] = $arr_print['arr_data']['no_cu'] - $arr_print['arr_data']['toa_moi'];

			$arr_print['arr_data']['no_cu'] = number_format($arr_print['arr_data']['no_cu']);
			$arr_print['arr_data']['toa_moi'] = number_format(-$arr_print['arr_data']['toa_moi']);
			$arr_print['arr_data']['tong_cong'] = number_format($arr_print['arr_data']['tong_cong']);
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng cộng:','colspan'=>'6'],
				['value'=>$sum_amount]
			];
			$arr_print['arr_list']['arr_body'] = $arr_cache;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'phieu_dai_ly_tra_hang_so_'.$rso->id,'potrait');
			Log::create_log(\Auth::user()->id,'App\\ReturnSaleorder','In đơn hàng đại lý trả số '.session('current_returnsaleorder'));
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfList(){
		$id_template = 7;
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
		if (\Cache::has('list_returnsaleorder'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_returnsaleorder'.\Auth::user()->id);
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
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'danh_sach_dai_ly_tra_hang','potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportExcel(){
		if (\Cache::has('list_returnsaleorder'.\Auth::user()->id)){
			
			
			\Excel::create('Danh_san_pham', function($excel){
				$excel->sheet('Danh_san_pham', function($sheet){
					$cache = \Cache::get('list_returnsaleorder'.\Auth::user()->id);
					$sheet->row(1, array(
						 'STT',
					     'Mã HĐ',
					     'Nhà Cung Cấp',
					     'Ngày Trả Hàng',
					     'Tổng Tiền Trả Hàng',
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
					$sheet->mergeCells('A'.($index+1).':'.'I'.($index+1));
					$sheet->setCellValue('A'.($index+1),'Tổng vốn lưu:');
					$sheet->cell('A'.($index+1), function($cell){
						$cell->setAlignment('right');
						$cell->setFontWeight('bold');
					});
					$sheet->setCellValue('J'.($index+1),'=sum(J2:J'.($index).')');

					$sheet->setBorder('A1:J'.($index+1), 'thin');
				});
			})->export('xls');
			die;
		}
	}

	public function anyLog(){
		$list_log = Log::select('logs.*','users.name')
				->where('module_type','=','App\\ReturnSaleorder')
				->leftJoin('users','users.id','=','logs.user_id')
				->orderBy('id','desc')
				->paginate(50);

		$this->layout->content=view('log.log', ['list_log'=>$list_log]);
	}
}
