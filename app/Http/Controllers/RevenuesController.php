<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Company;
use App\Product;
use App\MProduct;
use App\User;
use App\ReceiptMonth;
use App\Saleorder;
use App\ReturnSaleorder;
use App\ReturnPurchaseorder;
use App\RevenueOther;
use App\Paid;
use Datatables;
use Illuminate\Http\Request;
use Session;
use DB;

class RevenuesController extends Controller {

	public function getIndex(){
		$min_year = ReceiptMonth::min('year');
		$tong_thu = ReceiptMonth::where('type_receipt','=','customer')->sum('sum_amount');
		$tong_chi = ReceiptMonth::where('type_receipt','=','distribute')->sum('sum_amount');
		$chi_khac = RevenueOther::sum('sum_amount');
		if(!$min_year){
			$min_year = date('Y');
		}
		$current_year = date('Y');
		$list_chart = self::getListRevenue($current_year);
		$this->layout->content = view('revenue.index',[
							"tong_thu"	=>	$tong_thu,
							"tong_chi"	=>	$tong_chi,
							"chi_khac"	=>	$chi_khac,
							"list_chart"	=>	$list_chart,
							"min_year"	=>	$min_year,
							"current_year"	=>	$current_year
						]);
	}

	public function getListRevenue($year){
		$arr_return = array();
		for($i=1;$i<13;$i++){
			$month=$i;
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			if($month<12)
				$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
			else{
				$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
			}

			$arr_return['tong_thu'][$i] = array();
			$arr_return['tong_thu'][$i]['x'] = $i;
			$arr_return['tong_chi'][$i]['x'] = $i;
			$arr_return['chi_khac'][$i]['x'] = $i;

			$arr_return['tong_thu'][$i]['y'] = Paid::where('type_paid','=','customer')
								->where('date','>=',$begin)
								->where('date','<',$end)
								->sum('sum_paid');
			$arr_return['tong_chi'][$i]['y'] = Paid::where('type_paid','=','distribute')
								->where('date','>=',$begin)
								->where('date','<',$end)
								->sum('sum_paid');
			$arr_return['chi_khac'][$i]['y'] = RevenueOther::where('date','>=',$begin)
								->where('date','<',$end)
								->sum('sum_amount');
		}
		$arr_return['tong_thu'] = array_values($arr_return['tong_thu']);
		$arr_return['tong_chi'] = array_values($arr_return['tong_chi']);
		$arr_return['chi_khac'] = array_values($arr_return['chi_khac']);
		return $arr_return ;
	}

	public function getCustomer(){
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$customers = Company::getCustomerList()->get()->toArray();
		$this->layout->content = view('revenue.revenue-customer',[
							'customers'	=>	$customers,
							'min_year'	=> 	$min_year
						]);
	}


	public function postListRevenueCustomer(Request $request){
		$list_order = array();
		$company_id = $request->has('company_id')?$request->input('company_id'):0;
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		$key_order = 1;
		$list_so = Saleorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$company_id)
					->get()->toArray();
		foreach ($list_so as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  $value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  0;
			$list_order[$key_order]['lai'] =  $list_order[$key_order]['sum_amount'] - $list_order[$key_order]['sum_invest'];
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] - $list_order[$key_order]['khoang_giam'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}
		$list_rso = ReturnSaleorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$company_id)
					->get()->toArray();
		foreach ($list_rso as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  -$value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  - (abs($list_order[$key_order]['sum_amount']) - abs($list_order[$key_order]['sum_invest']));
			$list_order[$key_order]['lai'] =  0;
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] + $list_order[$key_order]['khoang_giam'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}
		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = $value['date'];
		}
		array_multisort($date,SORT_ASC,$list_order);

		$company_name = Company::find($company_id);
		$company_name = $company_name->name;

		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'company_name'=>$company_name,
					'list_order'=>$list_order
				];

		\Cache::put('list_revenue_customer'.\Auth::user()->id, $arr_cache, 30);

		return view('revenue.list-revenue-customer',[
				'list_order' => $list_order
			]);
	}

	public function getUser(){
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$users = User::get()->toArray();
		$this->layout->content = view('revenue.revenue-user',[
							'users'	=>	$users,
							'min_year'	=> $min_year
						]);
	}

	public function postListRevenueUser(Request $request){
		$list_order = array();
		$user_id = $request->has('user_id')?$request->input('user_id'):0;
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		$key_order = 1;
		$list_so = Saleorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('user_id','=',$user_id)
					->get()->toArray();
		foreach ($list_so as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  $value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  0;
			$list_order[$key_order]['lai'] =  $list_order[$key_order]['sum_amount'] - $list_order[$key_order]['sum_invest'];
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] - $list_order[$key_order]['khoang_giam'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}

		$list_rso = ReturnSaleorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('user_id','=',$user_id)
					->get()->toArray();
		foreach ($list_rso as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  -$value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  - (abs($list_order[$key_order]['sum_amount']) - abs($list_order[$key_order]['sum_invest']));
			$list_order[$key_order]['lai'] =  0;
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] + $list_order[$key_order]['khoang_giam'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}
		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = $value['date'];
		}
		array_multisort($date,SORT_ASC,$list_order);
		$user_name = User::find($user_id);
		$user_name = $user_name->name;

		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'user_name'=>$user_name,
					'list_order'=>$list_order
				];

		\Cache::put('list_revenue_user'.\Auth::user()->id, $arr_cache, 30);
		return view('revenue.list-revenue-customer',[
				'list_order' => $list_order
			]);
	}

	public function getProduct(){
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$arr_month_year = ReceiptMonth::select('year','month')
						->groupBy('year','month')
						->where('type_receipt','=','customer')
						->orderBy('year','DESC')
						->orderBy('month','DESC')
						->get()->toArray();

		$this->layout->content = view('revenue.revenue-product',[	
							'arr_month_year' 	=> 	$arr_month_year,
							'min_year'		=>	$min_year
						]);
	}

	public function postListRevenueProduct(Request $request){
		DB::enableQueryLog();
		$list_order = array();
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			if($month<12){
				$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
			}else{
				$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
			}
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		$key_order = 1;
		$arr_product = array();
		$list_so = Mproduct::select('m_products.*','products.name','products.id','saleorders.date')
					->addSelect(DB::raw(' sum(amount) as sum_amount , sum(invest) as sum_invest'))
					->leftJoin('products','products.id','=','m_products.product_id')
					->leftJoin('saleorders',function($join){
						$join->on('saleorders.id','=','m_products.module_id')
							->where('module_type','=','App\\Saleorder');
					})
					->where('saleorders.date','>=',$begin)
					->where('saleorders.date','<',$end)
					->where('saleorders.status','=',1)
					->groupBy('product_id')
					->get()->toArray();
		foreach ($list_so as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['name'] = $value['name'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  $value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  0;
			$list_order[$key_order]['lai'] =  $list_order[$key_order]['sum_amount'] - $list_order[$key_order]['sum_invest'];
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] - $list_order[$key_order]['khoang_giam'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$arr_product[$key_order] = $value['id'];
			$key_order++;
		}
		$list_rso = Mproduct::select('m_products.*','products.name','products.id','return_saleorders.date')
					->addSelect(DB::raw(' sum(amount) as sum_amount , sum(invest) as sum_invest'))
					->leftJoin('products','products.id','=','m_products.product_id')
					->leftJoin('return_saleorders',function($join){
						$join->on('return_saleorders.id','=','m_products.module_id')
							->where('module_type','=','App\\ReturnSaleorder');
					})
					->where('return_saleorders.date','>=',$begin)
					->where('return_saleorders.date','<',$end)
					->where('return_saleorders.status','=',1)
					->groupBy('product_id')
					->get()->toArray();
		foreach ($list_rso as $key => $value) {
			$check_in_array = array_search($value['id'], $arr_product);
			if($check_in_array){
				$list_order[$check_in_array]['sum_amount'] -=  $value['sum_amount'];
				$list_order[$check_in_array]['sum_invest'] -=  $value['sum_invest'];
				$list_order[$check_in_array]['khoang_giam'] -=  (abs($value['sum_amount']) - abs($value['sum_invest']));
				$list_order[$check_in_array]['loi_nhuan'] = $list_order[$check_in_array]['lai'] + $list_order[$check_in_array]['khoang_giam'];
			}else{
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['name'] = $value['name'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
				$list_order[$key_order]['sum_invest'] =  -$value['sum_invest'];
				$list_order[$key_order]['khoang_giam'] =  - (abs($list_order[$key_order]['sum_amount']) - abs($list_order[$key_order]['sum_invest']));
				$list_order[$key_order]['lai'] =  0;
				$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] + $list_order[$key_order]['khoang_giam'];
				$list_order[$key_order]['updated_at'] = $value['updated_at'];
				$key_order++;
			}
			
		}
		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = $value['date'];
		}
		array_multisort($date,SORT_ASC,$list_order);
		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'list_order'=>$list_order,
				];

		\Cache::put('list_revenue_product'.\Auth::user()->id, $arr_cache, 30);
		return view('revenue.list-revenue-product',[
				'list_order' => $list_order
			]);
	}

	public function getCustomerMonth(){
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$arr_month_year = ReceiptMonth::select('year','month')
						->groupBy('year','month')
						->where('type_receipt','=','customer')
						->orderBy('year','DESC')
						->orderBy('month','DESC')
						->get()->toArray();

		$this->layout->content = view('revenue.revenue-customer-month',[	
							'arr_month_year' 	=> 	$arr_month_year,
							'min_year'		=>	$min_year
						]);
	}

	public function postListRevenueCustomerMonth(Request $request){
		DB::enableQueryLog();
		$list_order = array();

		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		$key_order = 1;
		$arr_company = array();
		$list_so = Saleorder::select('saleorders.*','companies.name','companies.id')
					->where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->leftJoin('companies','companies.id','=','saleorders.company_id')
					->addSelect(DB::raw('sum(sum_amount) as sum_amount , sum(sum_invest) as sum_invest'))
					->groupBy('company_id')
					->get()->toArray();
		foreach ($list_so as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['name'] = $value['name'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  $value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  0;
			$list_order[$key_order]['lai'] =  $list_order[$key_order]['sum_amount'] - $list_order[$key_order]['sum_invest'];
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] - $list_order[$key_order]['khoang_giam'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$arr_product[$key_order] = $value['id'];
			$key_order++;
		}
		$list_rso = ReturnSaleorder::select('return_saleorders.*','companies.name','companies.id')
					->where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->leftJoin('companies','companies.id','=','return_saleorders.company_id')
					->addSelect(DB::raw('sum(sum_amount) as sum_amount , sum(sum_invest) as sum_invest'))
					->groupBy('company_id')
					->get()->toArray();
		foreach ($list_rso as $key => $value) {
			$check_in_array = array_search($value['id'], $arr_product);
			if($check_in_array){
				$list_order[$check_in_array]['sum_amount'] -=  $value['sum_amount'];
				$list_order[$check_in_array]['sum_invest'] -=  $value['sum_invest'];
				$list_order[$check_in_array]['khoang_giam'] -=  (abs($value['sum_amount']) - abs($value['sum_invest']));
				$list_order[$check_in_array]['loi_nhuan'] = $list_order[$check_in_array]['lai'] + $list_order[$check_in_array]['khoang_giam'];
			}else{
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['name'] = $value['name'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
				$list_order[$key_order]['sum_invest'] =  -$value['sum_invest'];
				$list_order[$key_order]['khoang_giam'] =  - (abs($list_order[$key_order]['sum_amount']) - abs($list_order[$key_order]['sum_invest']));
				$list_order[$key_order]['lai'] =  0;
				$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] + $list_order[$key_order]['khoang_giam'];
				$list_order[$key_order]['updated_at'] = $value['updated_at'];
				$key_order++;
			}
		}

		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = $value['date'];
		}
		array_multisort($date,SORT_ASC,$list_order);
		$chi_khac = RevenueOther::where('date','>=',$begin)
					->where('date','<',$end)
					->sum('sum_amount');

		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'list_order'=>$list_order,
					'chi_khac'=>$chi_khac
				];

		\Cache::put('list_revenue_customer_month'.\Auth::user()->id, $arr_cache, 30);

		return view('revenue.list-revenue-customer-month',[
				'list_order' => $list_order,
				'chi_khac'  => $chi_khac
			]);
	}

	public function getCustomerYear(){
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$this->layout->content = view('revenue.revenue-customer-year',[	
							'min_year'		=>	$min_year
						]);
	}

	public function postListRevenueCustomerYear(Request $request){
		DB::enableQueryLog();
		$list_order = array();
		$year = $request->has('year')?$request->input('year'):0;
		$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
		$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		$key_order = 1;
		$arr_company = array();
		$list_so = Saleorder::select('saleorders.*','companies.name','companies.id')
					->where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->leftJoin('companies','companies.id','=','saleorders.company_id')
					->addSelect(DB::raw('sum(sum_amount) as sum_amount , sum(sum_invest) as sum_invest'))
					->groupBy('company_id')
					->get()->toArray();
		foreach ($list_so as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['name'] = $value['name'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  $value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  0;
			$list_order[$key_order]['lai'] =  $list_order[$key_order]['sum_amount'] - $list_order[$key_order]['sum_invest'];
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] - $list_order[$key_order]['khoang_giam'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$arr_product[$key_order] = $value['id'];
			$key_order++;
		}
		$list_rso = ReturnSaleorder::select('return_saleorders.*','companies.name','companies.id')
					->where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->leftJoin('companies','companies.id','=','return_saleorders.company_id')
					->addSelect(DB::raw('sum(sum_amount) as sum_amount , sum(sum_invest) as sum_invest'))
					->groupBy('company_id')
					->get()->toArray();
		foreach ($list_rso as $key => $value) {
			$check_in_array = array_search($value['id'], $arr_product);
			if($check_in_array){
				$list_order[$check_in_array]['sum_amount'] -=  $value['sum_amount'];
				$list_order[$check_in_array]['sum_invest'] -=  $value['sum_invest'];
				$list_order[$check_in_array]['khoang_giam'] -=  (abs($value['sum_amount']) - abs($value['sum_invest']));
				$list_order[$check_in_array]['loi_nhuan'] = $list_order[$check_in_array]['lai'] + $list_order[$check_in_array]['khoang_giam'];
			}else{
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['name'] = $value['name'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
				$list_order[$key_order]['sum_invest'] =  -$value['sum_invest'];
				$list_order[$key_order]['khoang_giam'] =  - (abs($list_order[$key_order]['sum_amount']) - abs($list_order[$key_order]['sum_invest']));
				$list_order[$key_order]['lai'] =  0;
				$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] + $list_order[$key_order]['khoang_giam'];
				$list_order[$key_order]['updated_at'] = $value['updated_at'];
				$key_order++;
			}
		}

		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = $value['date'];
		}
		array_multisort($date,SORT_ASC,$list_order);
		$chi_khac = RevenueOther::where('date','>=',$begin)
					->where('date','<',$end)
					->sum('sum_amount');

		$arr_cache = [
					'year'=>$year,
					'list_order'=>$list_order,
					'chi_khac'=>$chi_khac
				];

		\Cache::put('list_revenue_customer_year'.\Auth::user()->id, $arr_cache, 30);

		return view('revenue.list-revenue-customer-year',[
				'list_order' => $list_order,
				'chi_khac'  => $chi_khac
			]);
	}

	public function getOther(){
		$min_date = RevenueOther::min('date');
		if($min_date)
			$min_year = date('Y',strtotime($min_date));
		else
			$min_year = date('Y');
		$arr_month_year = RevenueOther::select(DB::raw('YEAR(date) as year, MONTH(date) as month'))
						->groupBy('year','month')
						->orderBy('year','DESC')
						->orderBy('month','DESC')
						->get()->toArray();
		$users = User::get()->toArray();
		$this->layout->content = view('revenue.revenue-other',[	
							'arr_month_year' 	=> 	$arr_month_year,
							'min_year'		=>	$min_year,
							'users'			=>	$users
						]);
	}

	public function postListRevenueOther(Request $request)
	{
		$list_order = array();
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		$list_order = RevenueOther::select('revenue_others.*','users.name')
					->where('date','>=',$begin)
					->where('date','<',$end)
					->leftJoin('users','users.id','=','revenue_others.user_id')
					->orderBy('date')
					->get()->toArray();
		foreach ($list_order as $key => $value) {
			$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
		}		
		return view('revenue.list-revenue-other',[
				'list_order' => $list_order
			]);
	}

	public function postSaveOther(Request $request){
		$time =date('H:i:s', time());
		$arr_return = array('status' => 'error');
		$id = $request->has('id')?$request->input('id'):0;
		if($id){
			$other = RevenueOther::find($id);
		}else{
			$other = new RevenueOther;
		}

		$other->user_id = $request->has('user_id')?$request->input('user_id'):0;
		$other->sum_amount = $request->has('sum_amount')?$request->input('sum_amount'):0;
		$other->date = $request->has('date') ? date("Y-m-d H:i:s",strtotime($request->input('date').' '.$time)) : date("Y-m-d H:i:s");
		$other->ly_do = $request->has('ly_do')?$request->input('ly_do'):'';
		if($other->save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message'] = 'Saving fail';
		}
		return $arr_return;
	}

	public function postDeleteOther(Request $request){
		$arr_return = array('status' => 'error');
		$id = $request->has('id')?$request->input('id'):0;
		if($id){
			$other = RevenueOther::find($id);
			if($other->delete()){
				$arr_return['status'] = 'success';
			}else{
				$arr_return['message'] = 'Deleting fail';
			}
		}else{
			$arr_return['message'] = 'Not found';
		}
		return $arr_return;
	}

	public function getDistribute(){
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$distributes = Company::getDistributeList()->get()->toArray();
		$this->layout->content = view('revenue.revenue-distribute',[
							'distributes'	=>	$distributes,
							'min_year'		=>	$min_year
						]);
	}


	public function postListRevenueDistribute(Request $request){
		$list_order = array();
		$company_id = $request->has('company_id')?$request->input('company_id'):0;
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		$key_order = 1;
		$list_so = DB::select('
			select 
			`products`.`id`,
			`saleorders`.`date`,
			`ncc`.`company_id`,
			`products`.`name`,
			`sum_amount`,
			`sum_invest`,
			sum(amount) as sum_amount ,
			sum(invest) as sum_invest
			from `m_products` as sale
			left join `products` on `products`.`id` = `sale`.`product_id`
			left join `saleorders` on `saleorders`.`id` = `sale`.`module_id` and `module_type` = "App\\\\Saleorder" 
			left join 
			(select id,company_id 
			from m_products 
			where module_type="App\\\\Purchaseorder" 
			or module_type="in_stock") 
			as ncc
		 	on `ncc`.`id` = `sale`.`m_product_id` 
		 	where `saleorders`.`date` >=  "'.$begin.'"  
		 	and `saleorders`.`date` <  "'.$end.'"  
		 	and `saleorders`.`status` = 1 
		 	and `ncc`.`company_id` = '.$company_id.' 
		 	group by `ncc`.`company_id`');

		foreach ($list_so as $key => $value) {
			$value = (array)$value;
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['name'] = $value['name'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  $value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  0;
			$list_order[$key_order]['lai'] =  $list_order[$key_order]['sum_amount'] - $list_order[$key_order]['sum_invest'];
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] - $list_order[$key_order]['khoang_giam'];
			$arr_product[$key_order] = $value['id'];
			$key_order++;
		}

		$list_rso = DB::select('
			select 
			`products`.`id`,
			`return_saleorders`.`date`,
			`ncc`.`company_id`,
			`products`.`name`,
			`sum_amount`,
			`sum_invest`,
			sum(amount) as sum_amount ,
			sum(invest) as sum_invest
			from `m_products` as sale
			left join `products` on `products`.`id` = `sale`.`product_id`
			left join `return_saleorders` on `return_saleorders`.`id` = `sale`.`module_id` and `module_type` = "App\\\\ReturnSaleorder" 
			left join 
			(select id,company_id 
			from m_products 
			where module_type="App\\\\Purchaseorder" 
			or module_type="in_stock") 
			as ncc
		 	on `ncc`.`id` = `sale`.`m_product_id` 
		 	where `return_saleorders`.`date` >=  "'.$begin.'"  
		 	and `return_saleorders`.`date` <  "'.$end.'"  
		 	and `return_saleorders`.`status` = 1 
		 	and `ncc`.`company_id` = '.$company_id.' 
		 	group by `ncc`.`company_id`');
		foreach ($list_rso as $key => $value) {
			$value = (array)$value;
			$check_in_array = array_search($value['id'], $arr_product);
			if($check_in_array){
				$list_order[$check_in_array]['sum_amount'] -=  $value['sum_amount'];
				$list_order[$check_in_array]['sum_invest'] -=  $value['sum_invest'];
				$list_order[$check_in_array]['khoang_giam'] -=  (abs($value['sum_amount']) - abs($value['sum_invest']));
				$list_order[$check_in_array]['loi_nhuan'] = $list_order[$check_in_array]['lai'] + $list_order[$check_in_array]['khoang_giam'];
			}else{
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['name'] = $value['name'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
				$list_order[$key_order]['sum_invest'] =  -$value['sum_invest'];
				$list_order[$key_order]['khoang_giam'] =  - (abs($list_order[$key_order]['sum_amount']) - abs($list_order[$key_order]['sum_invest']));
				$list_order[$key_order]['lai'] =  0;
				$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] + $list_order[$key_order]['khoang_giam'];
				$key_order++;
			}
			
		}
		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = $value['date'];
		}
		array_multisort($date,SORT_ASC,$list_order);
		$company_name = Company::find($company_id);
		$company_name = $company_name->name;

		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'company_name'=>$company_name,
					'list_order'=>$list_order
				];
		\Cache::put('list_revenue_distribute'.\Auth::user()->id, $arr_cache, 30);
		return view('revenue.list-revenue-distribute',[
				'list_order' => $list_order
			]);
	}

	public function getDistributeMonth(){
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$arr_month_year = ReceiptMonth::select('year','month')
						->groupBy('year','month')
						->where('type_receipt','=','distribute')
						->orderBy('year','DESC')
						->orderBy('month','DESC')
						->get()->toArray();

		$this->layout->content = view('revenue.revenue-distribute-month',[	
							'arr_month_year' 	=> 	$arr_month_year,
							'min_year'		=>	$min_year
						]);
	}

	public function postListRevenueDistributeMonth(Request $request){
		DB::enableQueryLog();
		$list_order = array();

		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		$key_order = 1;
		$arr_company = array();
		$list_so = DB::select('
			select 
			`products`.`id`,
			`saleorders`.`date`,
			`ncc`.`company_id`,
			`companies`.`name`,
			`sum_amount`,
			`sum_invest`,
			sum(amount) as sum_amount ,
			sum(invest) as sum_invest
			from `m_products` as sale
			left join `products` on `products`.`id` = `sale`.`product_id`
			left join `saleorders` on `saleorders`.`id` = `sale`.`module_id` and `module_type` = "App\\\\Saleorder" 
			left join 
			(select id,company_id 
			from m_products 
			where module_type="App\\\\Purchaseorder" 
			or module_type="in_stock") 
			as ncc
		 	on `ncc`.`id` = `sale`.`m_product_id` 
		 	left join `companies` on `companies`.`id` = `ncc`.`company_id`
		 	where `saleorders`.`date` >=  "'.$begin.'"  
		 	and `saleorders`.`date` <  "'.$end.'"  
		 	and `saleorders`.`status` = 1 
		 	group by `ncc`.`company_id`');
		
		foreach ($list_so as $key => $value) {
			$value = (array)$value;
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['name'] = $value['name'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  $value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  0;
			$list_order[$key_order]['lai'] =  $list_order[$key_order]['sum_amount'] - $list_order[$key_order]['sum_invest'];
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] - $list_order[$key_order]['khoang_giam'];
			$arr_company[$key_order] = $value['company_id'];
			$key_order++;
		}

		$list_rso = DB::select('
		select 
		`products`.`id`,
		`return_saleorders`.`date`,
		`ncc`.`company_id`,
		`companies`.`name`,
		`sum_amount`,
		`sum_invest`,
		sum(amount) as sum_amount ,
		sum(invest) as sum_invest
		from `m_products` as sale
		left join `products` on `products`.`id` = `sale`.`product_id`
		left join `return_saleorders` on `return_saleorders`.`id` = `sale`.`module_id` and `module_type` = "App\\\\ReturnSaleorder" 
		left join 
		(select id,company_id 
		from m_products 
		where module_type="App\\\\Purchaseorder" 
		or module_type="in_stock") 
		as ncc
	 	on `ncc`.`id` = `sale`.`m_product_id` 
	 	left join `companies` on `companies`.`id` = `ncc`.`company_id`
	 	where `return_saleorders`.`date` >=  "'.$begin.'"  
	 	and `return_saleorders`.`date` <  "'.$end.'"  
	 	and `return_saleorders`.`status` = 1 
	 	group by `ncc`.`company_id`');
		foreach ($list_rso as $key => $value) {
			$value = (array)$value;
			$check_in_array = array_search($value['company_id'], $arr_company);
			if($check_in_array){
				$list_order[$check_in_array]['sum_amount'] -=  $value['sum_amount'];
				$list_order[$check_in_array]['sum_invest'] -=  $value['sum_invest'];
				$list_order[$check_in_array]['khoang_giam'] -=  (abs($value['sum_amount']) - abs($value['sum_invest']));
				$list_order[$check_in_array]['loi_nhuan'] = $list_order[$check_in_array]['lai'] + $list_order[$check_in_array]['khoang_giam'];
			}else{
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['name'] = $value['name'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
				$list_order[$key_order]['sum_invest'] =  -$value['sum_invest'];
				$list_order[$key_order]['khoang_giam'] =  - (abs($list_order[$key_order]['sum_amount']) - abs($list_order[$key_order]['sum_invest']));
				$list_order[$key_order]['lai'] =  0;
				$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] + $list_order[$key_order]['khoang_giam'];
				$key_order++;
			}
		}
		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = $value['date'];
		}
		array_multisort($date,SORT_ASC,$list_order);
		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'list_order'=>$list_order,
				];

		\Cache::put('list_revenue_distribute_month'.\Auth::user()->id, $arr_cache, 30);

		return view('revenue.list-revenue-distribute-month',[
				'list_order' => $list_order
			]);
	}

	public function getDistributeYear(){
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$this->layout->content = view('revenue.revenue-distribute-year',[	
							'min_year'		=>	$min_year
						]);
	}

	public function postListRevenueDistributeYear(Request $request){
		DB::enableQueryLog();
		$list_order = array();
		$year = $request->has('year')?$request->input('year'):0;
		$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
		$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		$key_order = 1;
		$arr_company = array();
		$list_so = DB::select('
			select 
			`products`.`id`,
			`saleorders`.`date`,
			`ncc`.`company_id`,
			`companies`.`name`,
			`sum_amount`,
			`sum_invest`,
			sum(amount) as sum_amount ,
			sum(invest) as sum_invest
			from `m_products` as sale
			left join `products` on `products`.`id` = `sale`.`product_id`
			left join `saleorders` on `saleorders`.`id` = `sale`.`module_id` and `module_type` = "App\\\\Saleorder" 
			left join 
			(select id,company_id 
			from m_products 
			where module_type="App\\\\Purchaseorder" 
			or module_type="in_stock") 
			as ncc
		 	on `ncc`.`id` = `sale`.`m_product_id` 
		 	left join `companies` on `companies`.`id` = `ncc`.`company_id`
		 	where `saleorders`.`date` >=  "'.$begin.'"  
		 	and `saleorders`.`date` <  "'.$end.'"  
		 	and `saleorders`.`status` = 1 
		 	group by `ncc`.`company_id`');
		
		foreach ($list_so as $key => $value) {
			$value = (array)$value;
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['name'] = $value['name'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['sum_invest'] =  $value['sum_invest'];
			$list_order[$key_order]['khoang_giam'] =  0;
			$list_order[$key_order]['lai'] =  $list_order[$key_order]['sum_amount'] - $list_order[$key_order]['sum_invest'];
			$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] - $list_order[$key_order]['khoang_giam'];
			$arr_company[$key_order] = $value['company_id'];
			$key_order++;
		}

		$list_rso = DB::select('
		select 
		`products`.`id`,
		`return_saleorders`.`date`,
		`ncc`.`company_id`,
		`companies`.`name`,
		`sum_amount`,
		`sum_invest`,
		sum(amount) as sum_amount ,
		sum(invest) as sum_invest
		from `m_products` as sale
		left join `products` on `products`.`id` = `sale`.`product_id`
		left join `return_saleorders` on `return_saleorders`.`id` = `sale`.`module_id` and `module_type` = "App\\\\ReturnSaleorder" 
		left join 
		(select id,company_id 
		from m_products 
		where module_type="App\\\\Purchaseorder" 
		or module_type="in_stock") 
		as ncc
	 	on `ncc`.`id` = `sale`.`m_product_id` 
	 	left join `companies` on `companies`.`id` = `ncc`.`company_id`
	 	where `return_saleorders`.`date` >=  "'.$begin.'"  
	 	and `return_saleorders`.`date` <  "'.$end.'"  
	 	and `return_saleorders`.`status` = 1 
	 	group by `ncc`.`company_id`');
		foreach ($list_rso as $key => $value) {
			$value = (array)$value;
			$check_in_array = array_search($value['company_id'], $arr_company);
			if($check_in_array){
				$list_order[$check_in_array]['sum_amount'] -=  $value['sum_amount'];
				$list_order[$check_in_array]['sum_invest'] -=  $value['sum_invest'];
				$list_order[$check_in_array]['khoang_giam'] -=  (abs($value['sum_amount']) - abs($value['sum_invest']));
				$list_order[$check_in_array]['loi_nhuan'] = $list_order[$check_in_array]['lai'] + $list_order[$check_in_array]['khoang_giam'];
			}else{
				$list_order[$key_order]['id'] = $value['id'];
				$list_order[$key_order]['name'] = $value['name'];
				$list_order[$key_order]['date'] =  $value['date'];
				$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
				$list_order[$key_order]['sum_invest'] =  -$value['sum_invest'];
				$list_order[$key_order]['khoang_giam'] =  - (abs($list_order[$key_order]['sum_amount']) - abs($list_order[$key_order]['sum_invest']));
				$list_order[$key_order]['lai'] =  0;
				$list_order[$key_order]['loi_nhuan'] = $list_order[$key_order]['lai'] + $list_order[$key_order]['khoang_giam'];
				$key_order++;
			}
		}

		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = $value['date'];
		}
		array_multisort($date,SORT_ASC,$list_order);

		$arr_cache = [
					'year'=>$year,
					'list_order'=>$list_order,
				];

		\Cache::put('list_revenue_distribute_year'.\Auth::user()->id, $arr_cache, 30);
		return view('revenue.list-revenue-distribute-year',[
				'list_order' => $list_order
			]);
	}


	public function anyExportPdfCustomer(){
		$id_template = 17;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'date',
								'sum_invest',
								'sum_amount',
								'khoang_giam',
								'lai',
								'ty_le_lai',
								'loi_nhuan'
								],
						'arr_head' => 	[
								['text'=>'Ngày','class'=>''],
								['text'=>'Giá vốn','class'=>'money'],
								['text'=>'Doanh thu','class'=>'money'],
								['text'=>'Khoảng giảm','class'=>'money'],
								['text'=>'Lãi','class'=>'money'],
								['text'=>'Tỷ lệ lãi','class'=>'right strong'],
								['text'=>'Lợi nhuận','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_revenue_customer'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_revenue_customer'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$arr_print['arr_data']['company_name'] = $arr_cache['company_name'];
			$total_sum_amount = 0;
			$total_sum_invest = 0;
			$total_khoang_giam = 0;
			$total_lai = 0;
			$total_loi_nhuan = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$list_order[$key]['ty_le_lai'] = number_format(($value['lai']/$value['sum_invest'])*100,2).'%';
				$total_sum_invest += $value['sum_invest'];
				$total_sum_amount += $value['sum_amount'];
				$total_lai += $value['lai'];
				$total_loi_nhuan += $value['loi_nhuan'];
				$total_khoang_giam +=  $value['khoang_giam'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_invest],
				['value'=>$total_sum_amount],
				['value'=>$total_khoang_giam],
				['value'=>$total_lai],
				['value'=>'','class'=>'center'],
				['value'=>$total_loi_nhuan]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'doanh_thu_khach_hang_'.str_replace('-','_',\Str::slug($arr_cache['company_name'])).'_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfCustomerMonth(){
		$id_template = 18;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'name',
								'sum_invest',
								'sum_amount',
								'khoang_giam',
								'lai',
								'ty_le_lai',
								'loi_nhuan'
								],
						'arr_head' => 	[
								['text'=>'Công ty','class'=>''],
								['text'=>'Giá vốn','class'=>'money'],
								['text'=>'Doanh thu','class'=>'money'],
								['text'=>'Khoảng giảm','class'=>'money'],
								['text'=>'Lãi','class'=>'money'],
								['text'=>'Tỷ lệ lãi','class'=>'right strong'],
								['text'=>'Lợi nhuận','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_revenue_customer_month'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_revenue_customer_month'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];

			$total_sum_amount = 0;
			$total_sum_invest = 0;
			$total_khoang_giam = 0;
			$total_lai = 0;
			$total_loi_nhuan = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$list_order[$key]['ty_le_lai'] = number_format(($value['lai']/$value['sum_invest'])*100,2).'%';
				$total_sum_invest += $value['sum_invest'];
				$total_sum_amount += $value['sum_amount'];
				$total_lai += $value['lai'];
				$total_loi_nhuan += $value['loi_nhuan'];
				$total_khoang_giam +=  $value['khoang_giam'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_invest],
				['value'=>$total_sum_amount],
				['value'=>$total_khoang_giam],
				['value'=>$total_lai],
				['value'=>'','class'=>'center'],
				['value'=>$total_loi_nhuan]
			];
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Chi khác:','colspan'=>'6'],
				['value'=>-$arr_cache['chi_khac']]
			];
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Lãi thực:','colspan'=>'6'],
				['value'=>$total_loi_nhuan - $arr_cache['chi_khac']]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'doanh_thu_khach_hang_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfCustomerYear(){
		$id_template = 19;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'name',
								'sum_invest',
								'sum_amount',
								'khoang_giam',
								'lai',
								'ty_le_lai',
								'loi_nhuan'
								],
						'arr_head' => 	[
								['text'=>'Công ty','class'=>''],
								['text'=>'Giá vốn','class'=>'money'],
								['text'=>'Doanh thu','class'=>'money'],
								['text'=>'Khoảng giảm','class'=>'money'],
								['text'=>'Lãi','class'=>'money'],
								['text'=>'Tỷ lệ lãi','class'=>'right strong'],
								['text'=>'Lợi nhuận','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_revenue_customer_year'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_revenue_customer_year'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];

			$arr_print['arr_data']['year'] = $arr_cache['year'];

			$total_sum_amount = 0;
			$total_sum_invest = 0;
			$total_khoang_giam = 0;
			$total_lai = 0;
			$total_loi_nhuan = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$list_order[$key]['ty_le_lai'] = number_format(($value['lai']/$value['sum_invest'])*100,2).'%';
				$total_sum_invest += $value['sum_invest'];
				$total_sum_amount += $value['sum_amount'];
				$total_lai += $value['lai'];
				$total_loi_nhuan += $value['loi_nhuan'];
				$total_khoang_giam +=  $value['khoang_giam'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_invest],
				['value'=>$total_sum_amount],
				['value'=>$total_khoang_giam],
				['value'=>$total_lai],
				['value'=>'','class'=>'center'],
				['value'=>$total_loi_nhuan]
			];
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Chi khác:','colspan'=>'6'],
				['value'=>-$arr_cache['chi_khac']]
			];
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Lãi thực:','colspan'=>'6'],
				['value'=>$total_loi_nhuan - $arr_cache['chi_khac']]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'doanh_thu_khach_hang_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfUser(){
		$id_template = 20;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'date',
								'sum_invest',
								'sum_amount',
								'khoang_giam',
								'lai',
								'ty_le_lai',
								'loi_nhuan'
								],
						'arr_head' => 	[
								['text'=>'Ngày','class'=>''],
								['text'=>'Giá vốn','class'=>'money'],
								['text'=>'Doanh thu','class'=>'money'],
								['text'=>'Khoảng giảm','class'=>'money'],
								['text'=>'Lãi','class'=>'money'],
								['text'=>'Tỷ lệ lãi','class'=>'right strong'],
								['text'=>'Lợi nhuận','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_revenue_user'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_revenue_user'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$arr_print['arr_data']['user_name'] = $arr_cache['user_name'];
			$total_sum_amount = 0;
			$total_sum_invest = 0;
			$total_khoang_giam = 0;
			$total_lai = 0;
			$total_loi_nhuan = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$list_order[$key]['ty_le_lai'] = number_format(($value['lai']/$value['sum_invest'])*100,2).'%';
				$total_sum_invest += $value['sum_invest'];
				$total_sum_amount += $value['sum_amount'];
				$total_lai += $value['lai'];
				$total_loi_nhuan += $value['loi_nhuan'];
				$total_khoang_giam +=  $value['khoang_giam'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_invest],
				['value'=>$total_sum_amount],
				['value'=>$total_khoang_giam],
				['value'=>$total_lai],
				['value'=>'','class'=>'center'],
				['value'=>$total_loi_nhuan]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'doanh_so_nhan_vien_'.str_replace('-','_',\Str::slug($arr_cache['user_name'])).'_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfProduct(){
		$id_template = 21;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'name',
								'sum_invest',
								'sum_amount',
								'khoang_giam',
								'lai',
								'ty_le_lai',
								'loi_nhuan'
								],
						'arr_head' => 	[
								['text'=>'Sản phẩm','class'=>''],
								['text'=>'Giá vốn','class'=>'money'],
								['text'=>'Doanh thu','class'=>'money'],
								['text'=>'Khoảng giảm','class'=>'money'],
								['text'=>'Lãi','class'=>'money'],
								['text'=>'Tỷ lệ lãi','class'=>'right strong'],
								['text'=>'Lợi nhuận','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_revenue_product'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_revenue_product'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];

			$total_sum_amount = 0;
			$total_sum_invest = 0;
			$total_khoang_giam = 0;
			$total_lai = 0;
			$total_loi_nhuan = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$list_order[$key]['ty_le_lai'] = number_format(($value['lai']/$value['sum_invest'])*100,2).'%';
				$total_sum_invest += $value['sum_invest'];
				$total_sum_amount += $value['sum_amount'];
				$total_lai += $value['lai'];
				$total_loi_nhuan += $value['loi_nhuan'];
				$total_khoang_giam +=  $value['khoang_giam'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_invest],
				['value'=>$total_sum_amount],
				['value'=>$total_khoang_giam],
				['value'=>$total_lai],
				['value'=>'','class'=>'center'],
				['value'=>$total_loi_nhuan]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'doanh_so_san_pham_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfDistribute(){
		$id_template = 22;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'name',
								'sum_invest',
								'sum_amount',
								'khoang_giam',
								'lai',
								'ty_le_lai',
								'loi_nhuan'
								],
						'arr_head' => 	[
								['text'=>'Sản phẩm','class'=>''],
								['text'=>'Giá vốn','class'=>'money'],
								['text'=>'Doanh thu','class'=>'money'],
								['text'=>'Khoảng giảm','class'=>'money'],
								['text'=>'Lãi','class'=>'money'],
								['text'=>'Tỷ lệ lãi','class'=>'right strong'],
								['text'=>'Lợi nhuận','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_revenue_distribute'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_revenue_distribute'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$arr_print['arr_data']['company_name'] = $arr_cache['company_name'];

			$total_sum_amount = 0;
			$total_sum_invest = 0;
			$total_khoang_giam = 0;
			$total_lai = 0;
			$total_loi_nhuan = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$list_order[$key]['ty_le_lai'] = number_format(($value['lai']/$value['sum_invest'])*100,2).'%';
				$total_sum_invest += $value['sum_invest'];
				$total_sum_amount += $value['sum_amount'];
				$total_lai += $value['lai'];
				$total_loi_nhuan += $value['loi_nhuan'];
				$total_khoang_giam +=  $value['khoang_giam'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_invest],
				['value'=>$total_sum_amount],
				['value'=>$total_khoang_giam],
				['value'=>$total_lai],
				['value'=>'','class'=>'center'],
				['value'=>$total_loi_nhuan]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'doanh_so_nha_cung_cap_'.str_replace('-','_',\Str::slug($arr_cache['company_name'])).'_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfDistributeMonth(){
		$id_template = 23;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'name',
								'sum_invest',
								'sum_amount',
								'khoang_giam',
								'lai',
								'ty_le_lai',
								'loi_nhuan'
								],
						'arr_head' => 	[
								['text'=>'Công ty','class'=>''],
								['text'=>'Giá vốn','class'=>'money'],
								['text'=>'Doanh thu','class'=>'money'],
								['text'=>'Khoảng giảm','class'=>'money'],
								['text'=>'Lãi','class'=>'money'],
								['text'=>'Tỷ lệ lãi','class'=>'right strong'],
								['text'=>'Lợi nhuận','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_revenue_distribute_month'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_revenue_distribute_month'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];

			$total_sum_amount = 0;
			$total_sum_invest = 0;
			$total_khoang_giam = 0;
			$total_lai = 0;
			$total_loi_nhuan = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$list_order[$key]['ty_le_lai'] = number_format(($value['lai']/$value['sum_invest'])*100,2).'%';
				$total_sum_invest += $value['sum_invest'];
				$total_sum_amount += $value['sum_amount'];
				$total_lai += $value['lai'];
				$total_loi_nhuan += $value['loi_nhuan'];
				$total_khoang_giam +=  $value['khoang_giam'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_invest],
				['value'=>$total_sum_amount],
				['value'=>$total_khoang_giam],
				['value'=>$total_lai],
				['value'=>'','class'=>'center'],
				['value'=>$total_loi_nhuan]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'doanh_so_nha_cung_cap_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfDistributeYear(){
		$id_template = 24;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'name',
								'sum_invest',
								'sum_amount',
								'khoang_giam',
								'lai',
								'ty_le_lai',
								'loi_nhuan'
								],
						'arr_head' => 	[
								['text'=>'Công ty','class'=>''],
								['text'=>'Giá vốn','class'=>'money'],
								['text'=>'Doanh thu','class'=>'money'],
								['text'=>'Khoảng giảm','class'=>'money'],
								['text'=>'Lãi','class'=>'money'],
								['text'=>'Tỷ lệ lãi','class'=>'right strong'],
								['text'=>'Lợi nhuận','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_revenue_distribute_year'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_revenue_distribute_year'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];

			$arr_print['arr_data']['year'] = $arr_cache['year'];

			$total_sum_amount = 0;
			$total_sum_invest = 0;
			$total_khoang_giam = 0;
			$total_lai = 0;
			$total_loi_nhuan = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$list_order[$key]['ty_le_lai'] = number_format(($value['lai']/$value['sum_invest'])*100,2).'%';
				$total_sum_invest += $value['sum_invest'];
				$total_sum_amount += $value['sum_amount'];
				$total_lai += $value['lai'];
				$total_loi_nhuan += $value['loi_nhuan'];
				$total_khoang_giam +=  $value['khoang_giam'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_invest],
				['value'=>$total_sum_amount],
				['value'=>$total_khoang_giam],
				['value'=>$total_lai],
				['value'=>'','class'=>'center'],
				['value'=>$total_loi_nhuan]
			];
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Chi khác:','colspan'=>'6'],
				['value'=>-$arr_cache['chi_khac']]
			];
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Lãi thực:','colspan'=>'6'],
				['value'=>$total_loi_nhuan - $arr_cache['chi_khac']]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'doanh_so_nha_cung_cap_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}
}