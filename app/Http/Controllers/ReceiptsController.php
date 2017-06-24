<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Company;
use App\Purchaseorder;
use App\Paid;
use App\User;
use App\ReceiptMonth;
use App\Saleorder;
use App\ReturnSaleorder;
use App\ReturnPurchaseorder;
use Datatables;
use Illuminate\Http\Request;
use Session;
use DB;

class ReceiptsController extends Controller {

	public function getIndex(){
		self::getDistribute();
	}

	public function getDistribute()
	{
		$distributes = array();
		$user = array();
		$distributes = Company::getDistributeList()->get()->toArray();
		$users = User::get()->toArray();
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$this->layout->content = view('receipt.distribute',[
							'distributes'	=>	$distributes,
							'users'			=>	$users,
							'min_year' 	=>	$min_year
								]);
	}

	public function postListReceiptDistribute(Request $request)
	{
		$list_order = array();
		$company_id = $request->has('company_id')?$request->input('company_id'):0;
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			if($month != 12){
				$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
			}else{
				$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
			}
			
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		
		$list_po = Purchaseorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$company_id)
					->get()->toArray();
		$key_order = 1;
		foreach ($list_po as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['paid'] =  0;
			$list_order[$key_order]['no_cu'] =  0;
			$list_order[$key_order]['con_lai'] =  0;
			$list_order[$key_order]['hinh_thuc'] =  'Đơn hàng nhập';
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}
		$list_rpo = ReturnPurchaseorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$company_id)
					->get()->toArray();
		foreach ($list_rpo as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
			$list_order[$key_order]['paid'] =  0;
			$list_order[$key_order]['no_cu'] =  0;
			$list_order[$key_order]['con_lai'] =  0;
			$list_order[$key_order]['hinh_thuc'] =  'Trả hàng nhập';
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}

		$list_paid = Paid::where('date','>=',$begin)
					->where('date','<',$end)
					->where('company_id','=',$company_id)
					->where('type_paid','=','distribute')
					->get()->toArray();
		foreach ($list_paid as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  0;
			$list_order[$key_order]['paid'] =  $value['sum_paid'];
			$list_order[$key_order]['no_cu'] =  0;
			$list_order[$key_order]['con_lai'] =  0;
			$list_order[$key_order]['hinh_thuc'] =  $value['hinh_thuc'];
			$list_order[$key_order]['company_id'] =  $value['company_id'];
			$list_order[$key_order]['user_id'] =  $value['user_id'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}

		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = strtotime($value['date']);
			$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
		}
		if($month!='all'){
			$receipt_month_prev = ReceiptMonth::
							where(function($query){
								$query->where('type_receipt','=','distribute')
										->orWhere('type_receipt','=','no_dau_ky_distribute');
							})
							->where('company_id','=',$company_id)
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
		}else{
			$receipt_month_prev = ReceiptMonth::
							where(function($query){
								$query->where('type_receipt','=','distribute')
										->orWhere('type_receipt','=','no_dau_ky_distribute');
							})
							->where('company_id','=',$company_id)
							->where(function($query) use ($month,$year){
								$query->where(function($query2) use ($month,$year){
									$query2->where('month','=',12)
										->where('year','=',$year-1);
								})->orWhere(function($query2) use ($month,$year){
									$query2->where('year','=',$year-1);
								});
							})
							->orderBy('year','desc')
							->orderBy('month','desc')
							->limit(1);
		}
		$receipt_month_prev = $receipt_month_prev->first();
		if($month!='all' && $receipt_month_prev){
			$receipt_current = ReceiptMonth::where('year','=',$year)
					->where('month','=',$month)
					->where('company_id','=',$company_id)
					->where('type_receipt','=','distribute')
					->first();
			if($receipt_current){
				$receipt_current->no_cu = $receipt_month_prev->con_lai;
				$receipt_current->con_lai = $receipt_current->sum_amount + $receipt_current->no_cu - $receipt_current->paid;
				$receipt_current->save();
			}
		}
		
		array_multisort($date,SORT_ASC,$list_order);
		foreach ($list_order as $key => $value) {
			if($key==0){
				if(isset($receipt_month_prev)){
					$receipt_month_prev= $receipt_month_prev->toArray();
					$list_order[$key]['no_cu']=$receipt_month_prev['con_lai'];
				}
			}else{
				$list_order[$key]['no_cu']=isset($list_order[$key-1])?$list_order[$key-1]['con_lai']:0;
			}
			$list_order[$key]['con_lai']=$list_order[$key]['sum_amount'] - $list_order[$key]['paid'] + $list_order[$key]['no_cu'];
		}

		$company_name = Company::find($company_id);
		$company_name = $company_name->name;

		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'company_name'=>$company_name,
					'list_order'=>$list_order
				];

		\Cache::put('list_receipt_distribute'.\Auth::user()->id, $arr_cache, 30);

		return view('receipt.list-receipt-distribute',[
					'list_order' =>$list_order
			]);
	}

	public function getCustomer()
	{
		$customers = array();
		$user = array();

		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$customers = Company::getCustomerList()->get()->toArray();
		$users = User::get()->toArray();
		$this->layout->content = view('receipt.customer',[
							'customers'	=>	$customers,
							'users'		=>	$users,
							'min_year'	=> $min_year
								]);
	}

	public function postListReceiptCustomer(Request $request)
	{
		\DB::enableQueryLog();
		$list_order = array();
		$company_id = $request->has('company_id')?$request->input('company_id'):0;
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		if($month!='all'){
			$begin = date('Y-m-d H:i:s',strtotime('1'.'-'.$month.'-'.$year));
			if($month != 12){
				$end = date('Y-m-d H:i:s',strtotime('1'.'-'.($month+1).'-'.$year));
			}else{
				$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
			}
			
		}else{
			$begin = date('Y-m-d H:i:s',strtotime('1-1-'.$year));
			$end = date('Y-m-d H:i:s',strtotime('1-1-'.($year+1)));
		}
		
		$list_so = Saleorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$company_id)
					->get()->toArray();
		$key_order = 1;
		foreach ($list_so as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  $value['sum_amount'];
			$list_order[$key_order]['paid'] =  0;
			$list_order[$key_order]['no_cu'] =  0;
			$list_order[$key_order]['con_lai'] =  0;
			$list_order[$key_order]['hinh_thuc'] =  'Đơn hàng mua';
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}

		// pr(DB::getQueryLog());die;
		$list_rso = ReturnSaleorder::where('date','>=',$begin)
					->where('date','<',$end)
					->where('status','=',1)
					->where('company_id','=',$company_id)
					->get()->toArray();
		foreach ($list_rso as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  -$value['sum_amount'];
			$list_order[$key_order]['paid'] =  0;
			$list_order[$key_order]['no_cu'] =  0;
			$list_order[$key_order]['con_lai'] =  0;
			$list_order[$key_order]['hinh_thuc'] =  'Trả hàng mua';
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}

		$list_paid = Paid::where('date','>=',$begin)
					->where('date','<',$end)
					->where('company_id','=',$company_id)
					->where('type_paid','=','customer')
					->get()->toArray();
		foreach ($list_paid as $key => $value) {
			$list_order[$key_order]['id'] = $value['id'];
			$list_order[$key_order]['date'] =  $value['date'];
			$list_order[$key_order]['sum_amount'] =  0;
			$list_order[$key_order]['paid'] =  $value['sum_paid'];
			$list_order[$key_order]['no_cu'] =  0;
			$list_order[$key_order]['con_lai'] =  0;
			$list_order[$key_order]['hinh_thuc'] =  $value['hinh_thuc'];
			$list_order[$key_order]['company_id'] =  $value['company_id'];
			$list_order[$key_order]['user_id'] =  $value['user_id'];
			$list_order[$key_order]['updated_at'] = $value['updated_at'];
			$key_order++;
		}
		$date = array();
		foreach ($list_order as $key => $value) {
			$date[$key] = strtotime($value['date']);
			$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
		}
		array_multisort($date,SORT_ASC,$list_order);
		if($month!='all'){
			$receipt_month_prev = ReceiptMonth::
								where(function($query){
									$query->where('type_receipt','=','customer')
										->orWhere('type_receipt','=','no_dau_ky_customer');
								})
								->where('company_id','=',$company_id)
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
		}else{
			$receipt_month_prev = ReceiptMonth::
								where(function($query){
									$query->where('type_receipt','=','customer')
										->orWhere('type_receipt','=','no_dau_ky_customer');
								})
								->where('company_id','=',$company_id)
								->where(function($query) use ($month,$year){
									$query->where(function($query2) use ($month,$year){
										$query2->where('year','=',$year-1);
									});
								})
								->orderBy('year','desc')
								->orderBy('month','desc')
								->limit(1);
			$receipt_month_prev = $receipt_month_prev->first();
		}
		if($month!='all' && $receipt_month_prev){
			$receipt_current = ReceiptMonth::where('year','=',$year)
					->where('month','=',$month)
					->where('company_id','=',$company_id)
					->where('type_receipt','=','customer')
					->get()->first();
			if($receipt_current){
				$receipt_current->no_cu = $receipt_month_prev->con_lai;
				$receipt_current->con_lai = $receipt_current->sum_amount + $receipt_current->no_cu - $receipt_current->paid;
				$receipt_current->save();
			}
		}
		foreach ($list_order as $key => $value) {
			if($key==0){
				if(isset($receipt_month_prev)){
					$receipt_month_prev = $receipt_month_prev->toArray();
					$list_order[$key]['no_cu']=$receipt_month_prev['con_lai'];
				}
			}else{
				$list_order[$key]['no_cu']=isset($list_order[$key-1])?$list_order[$key-1]['con_lai']:0;
			}
			$list_order[$key]['con_lai']=$list_order[$key]['sum_amount'] - $list_order[$key]['paid'] + $list_order[$key]['no_cu'];
		}
		$company_name = Company::find($company_id);
		$company_name = $company_name->name;

		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'company_name'=>$company_name,
					'list_order'=>$list_order
				];

		\Cache::put('list_receipt_customer'.\Auth::user()->id, $arr_cache, 30);

		return view('receipt.list-receipt-customer',[
					'list_order' =>$list_order
			]);
	}

	public function getDistributeMonth()
	{
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

		// pr($arr_month_year);die;
		$this->layout->content = view('receipt.distribute-month',[
							'arr_month_year' 	=> 	$arr_month_year,
							'min_year'		=>	$min_year
								]);
	}

	public function postListReceiptDistributeMonth(Request $request){
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		$month = intval($month);
		$year = intval($year);
		$list_order = ReceiptMonth::select('receipt_months.*','companies.name as company_name','companies.id as company_id')
					->where('year','=',$year)
					->where('month','=',$month)
					->where('type_receipt','=','distribute')
					->leftJoin('companies','companies.id','=','receipt_months.company_id')
					->orderBy('companies.name')
					->get()->toArray();
		foreach ($list_order as $key => $value) {
			ReceiptMonth::where('year','=',$value['year'])
					->where('month','=',$value['month'])
					->where('company_id','=',$value['company_id'])
					->where('type_receipt','=',$value['type_receipt'])
					->update([
							'con_lai' => ($value['sum_amount'] - $value['paid'] + $value['no_cu'])
						]);
			$list_order[$key]['con_lai']=$list_order[$key]['sum_amount'] - $list_order[$key]['paid'] + $list_order[$key]['no_cu'];
		}

		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'list_order'=>$list_order
				];

		\Cache::put('list_receipt_distribute_month'.\Auth::user()->id, $arr_cache, 30);

		return view('receipt.list-receipt-distribute-month',[
					'list_order' =>$list_order
			]);
	}

	public function getCustomerMonth()
	{
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

		// pr($arr_month_year);die;
		$this->layout->content = view('receipt.customer-month',[
							'arr_month_year' 	=> 	$arr_month_year,
							'min_year'		=>	$min_year
								]);
	}

	public function postListReceiptCustomerMonth(Request $request){
		$month = $request->has('month')?$request->input('month'):0;
		$year = $request->has('year')?$request->input('year'):0;
		$month = intval($month);
		$year = intval($year);
		$list_order = ReceiptMonth::select('receipt_months.*','companies.name as company_name','companies.id as company_id')
					->where('year','=',$year)
					->where('month','=',$month)
					->where('type_receipt','=','customer')
					->leftJoin('companies','companies.id','=','receipt_months.company_id')
					->orderBy('companies.name')
					->get()->toArray();
		foreach ($list_order as $key => $value) {
			ReceiptMonth::where('year','=',$value['year'])
					->where('month','=',$value['month'])
					->where('company_id','=',$value['company_id'])
					->where('type_receipt','=',$value['type_receipt'])
					->update([
							'con_lai' => ($value['sum_amount'] - $value['paid'] + $value['no_cu'])
						]);
			$list_order[$key]['con_lai']=$list_order[$key]['sum_amount'] - $list_order[$key]['paid'] + $list_order[$key]['no_cu'];
		}

		$arr_cache = [
					'month'=>$month,
					'year'=>$year,
					'list_order'=>$list_order
				];

		\Cache::put('list_receipt_customer_month'.\Auth::user()->id, $arr_cache, 30);

		return view('receipt.list-receipt-customer-month',[
					'list_order' =>$list_order
			]);
	}

	public function getDistributeYear()
	{
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$this->layout->content = view('receipt.distribute-year',[
							'min_year'		=>	$min_year
								]);
	}

	public function postListReceiptDistributeYear(Request $request){
		// \DB::enableQueryLog();
		$year = $request->has('year')?$request->input('year'):0;
		$year = intval($year);
		$list_order = ReceiptMonth::select(
						'companies.name as company_name',
						'companies.id as company_id'
						)
					->addSelect(DB::raw('sum(sum_amount) as sum_amount,sum(paid) as paid'))
					->where('year','=',$year)
					->where('type_receipt','=','distribute')
					->leftJoin('companies','companies.id','=','receipt_months.company_id')
					->groupBy('companies.id')
					->orderBy('companies.name')
					->get()->toArray();
		foreach ($list_order as $key => $value) {
			$receipt_month_last = 	ReceiptMonth::where('year','=',$year-1)
								->where('type_receipt','=','distribute')
								->where('company_id','=',$value['company_id'])
								->orderBy('month','DESC')
								->first();
			if(!$receipt_month_last){
				$receipt_month_last = 	ReceiptMonth::where('year','=',$year)
								->where('type_receipt','=','distribute')
								->where('company_id','=',$value['company_id'])
								->orderBy('month')
								->first();
			}
			$receipt_month_last = $receipt_month_last->toArray();
			$list_order[$key]['no_cu'] = $receipt_month_last['con_lai'];
			$list_order[$key]['con_lai']=$list_order[$key]['sum_amount'] - $list_order[$key]['paid'] + $list_order[$key]['no_cu'];
		}
		// pr(DB::getQueryLog());die;
		$arr_cache = [
					'year'=>$year,
					'list_order'=>$list_order
				];

		\Cache::put('list_receipt_distribute_year'.\Auth::user()->id, $arr_cache, 30);
		return view('receipt.list-receipt-distribute-year',[
					'list_order' =>$list_order
			]);
	}

	public function getCustomerYear()
	{
		$min_year = ReceiptMonth::min('year');
		if($min_year==0){
			$min_year = intval(date('Y'));
		}
		$this->layout->content = view('receipt.customer-year',[
							'min_year'		=>	$min_year
								]);
	}

	public function postListReceiptCustomerYear(Request $request){
		$year = $request->has('year')?$request->input('year'):0;
		$year = intval($year);
		$list_order = ReceiptMonth::select(
						'companies.name as company_name',
						'companies.id as company_id'
						)
					->addSelect(DB::raw('sum(sum_amount) as sum_amount,sum(paid) as paid'))
					->where('year','=',$year)
					->where('type_receipt','=','customer')
					->leftJoin('companies','companies.id','=','receipt_months.company_id')
					->groupBy('companies.id')
					->orderBy('companies.name')
					->get()->toArray();
		foreach ($list_order as $key => $value) {
			$receipt_month_last = 	ReceiptMonth::where('year','=',$year-1)
								->where('type_receipt','=','customer')
								->where('company_id','=',$value['company_id'])
								->orderBy('month','DESC')
								->first();
			if(!$receipt_month_last){
				$receipt_month_last = 	ReceiptMonth::where('year','=',$year)
								->where('type_receipt','=','customer')
								->where('company_id','=',$value['company_id'])
								->orderBy('month')
								->first();
			}
			$receipt_month_last = $receipt_month_last->toArray();
			$list_order[$key]['no_cu'] = $receipt_month_last['con_lai'];
			$list_order[$key]['con_lai']=$list_order[$key]['sum_amount'] - $list_order[$key]['paid'] + $list_order[$key]['no_cu'];
		}
		$arr_cache = [
					'year'=>$year,
					'list_order'=>$list_order
				];

		\Cache::put('list_receipt_customer_year'.\Auth::user()->id, $arr_cache, 30);
		return view('receipt.list-receipt-customer-year',[
					'list_order' =>$list_order
			]);
	}



	public function postSavePaid(Request $request)
	{
		$time =date('H:i:s', time());
		$arr_return = array('status' => 'error');
		$id = $request->has('id')?$request->input('id'):0;
		if($id){
			$paid = Paid::find($id);
		}else{
			$paid = new Paid;
		}
		$paid->company_id = $request->has('company_id')?$request->input('company_id'):0;
		$paid->user_id = $request->has('user_id')?$request->input('user_id'):0;
		$paid->sum_paid = $request->has('sum_paid')?$request->input('sum_paid'):0;
		$paid->type_paid = $request->has('type_paid')?$request->input('type_paid'):'';
		$paid->date = $request->has('date') ? date("Y-m-d H:i:s",strtotime($request->input('date').' '.$time)) : date("Y-m-d H:i:s");
		$paid->hinh_thuc = $request->has('hinh_thuc')?$request->input('hinh_thuc'):'';
		if($paid->save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message'] = 'Saving fail';
		}
		return $arr_return;
	}

	public function postDeletePaid(Request $request)
	{
		$arr_return = array('status' => 'error');
		$id = $request->has('id')?$request->input('id'):0;
		if($id){
			$paid = Paid::find($id);
			if($paid->delete()){
				$arr_return['status'] = 'success';
			}else{
				$arr_return['message'] = 'Deleting fail';
			}
		}else{
			$arr_return['message'] = 'Not found';
		}
		return $arr_return;
	}

	public function postSaveNoDauKyDistribute(Request $request){

		$time =date('H:i:s', time());
		$arr_return = array('status' => 'error');
		$company_id = $request->has('company_id')?$request->input('company_id'):0;
		$sum_no_dau_ky = $request->has('sum_no_dau_ky')?$request->input('sum_no_dau_ky'):0;
		$type_no_dau_ky = $request->has('type_no_dau_ky')?$request->input('type_no_dau_ky'):0;
		$check = ReceiptMonth::where('company_id',"=",$company_id)
							->where('type_receipt',"=",$type_no_dau_ky)
							->count();
		if($check){
			$arr_return['message'] = 'Công nợ đầu của công ty đã thêm rồi';
		}else{
			$receipt = new ReceiptMonth;
			$receipt->company_id = $company_id;
			$receipt->sum_amount = $sum_no_dau_ky;
			$receipt->con_lai = $sum_no_dau_ky;
			$receipt->type_receipt = $type_no_dau_ky;
			$receipt->save();
			$arr_return['status'] = 'success';
		}
		$list_receipt = ReceiptMonth::where('company_id',$company_id)
										->where('type_receipt','distribute')
										->orWhere('type_receipt','no_dau_ky_distribute')
										->orderBy('year','asc')->orderBy('month','asc')
										->get()->toArray();
		foreach ($list_receipt as $key => $value) {
			if($key!=0){
				if($list_receipt[$key-1]['type_receipt'] == 'no_dau_ky_distribute')
					ReceiptMonth::where('id','=',$value['id'])->update([
																'no_cu'=>$list_receipt[$key-1]['sum_amount'],
																'con_lai'=>$value['sum_amount']+$list_receipt[$key-1]['con_lai']-$value['paid'],
																]);
				else
					ReceiptMonth::where('id','=',$value['id'])->update([
																'no_cu'=>$list_receipt[$key-1]['con_lai'],
																'con_lai'=>$value['sum_amount']+$list_receipt[$key-1]['con_lai']-$value['paid'],
																]);
			}
		}
		return $arr_return;
	}

	public function getUpdateReceiptDistribute($company_id){
		$list_receipt = ReceiptMonth::where('company_id',$company_id)
										->where('type_receipt','distribute')
										->orWhere('type_receipt','no_dau_ky_distribute')
										->orderBy('year','asc')->orderBy('month','asc')
										->get()->toArray();
		foreach ($list_receipt as $key => $value) {
			if($key!=0){
				if($list_receipt[$key-1]['type_receipt'] == 'no_dau_ky_distribute')
					ReceiptMonth::where('id','=',$value['id'])->update([
																'no_cu'=>$list_receipt[$key-1]['sum_amount'],
																'con_lai'=>$value['sum_amount']+$list_receipt[$key-1]['con_lai']-$value['paid'],
																]);
				else
					ReceiptMonth::where('id','=',$value['id'])->update([
																'no_cu'=>$list_receipt[$key-1]['con_lai'],
																'con_lai'=>$value['sum_amount']+$list_receipt[$key-1]['con_lai']-$value['paid'],
																]);
			}
		}
		echo 'done';die;
	}

	public function postSaveNoDauKyCustomer(Request $request){

		$time =date('H:i:s', time());
		$arr_return = array('status' => 'error');
		$company_id = $request->has('company_id')?$request->input('company_id'):0;
		$sum_no_dau_ky = $request->has('sum_no_dau_ky')?$request->input('sum_no_dau_ky'):0;
		$type_no_dau_ky = $request->has('type_no_dau_ky')?$request->input('type_no_dau_ky'):0;
		$check = ReceiptMonth::where('company_id',"=",$company_id)
							->where('type_receipt',"=",$type_no_dau_ky)
							->count();
		if($check){
			$arr_return['message'] = 'Công nợ đầu của công ty đã thêm rồi';
		}else{
			$receipt = new ReceiptMonth;
			$receipt->company_id = $company_id;
			$receipt->sum_amount = $sum_no_dau_ky;
			$receipt->con_lai = $sum_no_dau_ky;
			$receipt->type_receipt = $type_no_dau_ky;
			$receipt->save();
			$arr_return['status'] = 'success';
		}
		$list_receipt = ReceiptMonth::where('company_id',$company_id)
										->where('type_receipt','customer')
										->orWhere('type_receipt','no_dau_ky_customer')
										->orderBy('year','asc')->orderBy('month','asc')
										->get()->toArray();
		foreach ($list_receipt as $key => $value) {
			if($key!=0){
				if($list_receipt[$key-1]['type_receipt'] == 'no_dau_ky_customer')
					ReceiptMonth::where('id','=',$value['id'])->update([
																'no_cu'=>$list_receipt[$key-1]['sum_amount'],
																'con_lai'=>$value['sum_amount']+$list_receipt[$key-1]['con_lai']-$value['paid'],
																]);
				else
					ReceiptMonth::where('id','=',$value['id'])->update([
																'no_cu'=>$list_receipt[$key-1]['con_lai'],
																'con_lai'=>$value['sum_amount']+$list_receipt[$key-1]['con_lai']-$value['paid'],
																]);
			}
		}
		return $arr_return;
	}

	public function getUpdateReceiptCustomer($company_id){
		$list_receipt = ReceiptMonth::where('company_id',$company_id)
										->where('type_receipt','customer')
										->orWhere('type_receipt','no_dau_ky_customer')
										->orderBy('year','asc')->orderBy('month','asc')
										->get()->toArray();
		foreach ($list_receipt as $key => $value) {
			if($key!=0){
				if($list_receipt[$key-1]['type_receipt'] == 'no_dau_ky_customer')
					ReceiptMonth::where('id','=',$value['id'])->update([
																'no_cu'=>$list_receipt[$key-1]['sum_amount'],
																'con_lai'=>$value['sum_amount']+$list_receipt[$key-1]['con_lai']-$value['paid'],
																]);
				else
					ReceiptMonth::where('id','=',$value['id'])->update([
																'no_cu'=>$list_receipt[$key-1]['con_lai'],
																'con_lai'=>$value['sum_amount']+$list_receipt[$key-1]['con_lai']-$value['paid'],
																]);
			}
		}
		echo 'done';die;
	}


	public function anyExportPdfDistribute(){
		$id_template = 11;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'date',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'Ngày','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_distribute'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_distribute'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$arr_print['arr_data']['company_name'] = $arr_cache['company_name'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai = $value['con_lai'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_amount],
				['value'=>$total_sum_paid],
				['value'=>'','class'=>'center'],
				['value'=>$total_con_lai]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'cong_no_khach_hang_'.str_replace('-','_',\Str::slug($arr_cache['company_name'])).'_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfDistributeMonth(){
		$id_template = 12;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'company_name',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_distribute_month'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_distribute_month'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai += $value['con_lai'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_amount],
				['value'=>$total_sum_paid],
				['value'=>'','class'=>'center'],
				['value'=>$total_con_lai]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'cong_no_nha_cung_cap_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfDistributeYear(){
		$id_template = 13;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'company_name',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_distribute_year'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_distribute_year'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai = +$value['con_lai'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_amount],
				['value'=>$total_sum_paid],
				['value'=>'','class'=>'center'],
				['value'=>$total_con_lai]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'cong_no_nha_cung_cap_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfCustomer(){
		$id_template = 16;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'date',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'Ngày','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_customer'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_customer'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$arr_print['arr_data']['company_name'] = $arr_cache['company_name'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai = $value['con_lai'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_amount],
				['value'=>$total_sum_paid],
				['value'=>'','class'=>'center'],
				['value'=>$total_con_lai]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'cong_no_khach_hang_'.str_replace('-','_',\Str::slug($arr_cache['company_name'])).'_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfCustomerMonth(){
		$id_template = 15;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'company_name',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_customer_month'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_customer_month'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai += $value['con_lai'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_amount],
				['value'=>$total_sum_paid],
				['value'=>'','class'=>'center'],
				['value'=>$total_con_lai]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'cong_no_khach_hang_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportPdfCustomerYear(){
		$id_template = 14;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'company_name',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_customer_year'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_customer_year'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai += $value['con_lai'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_amount],
				['value'=>$total_sum_paid],
				['value'=>'','class'=>'center'],
				['value'=>$total_con_lai]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintPdf($arr_print,$id_template,'cong_no_khach_hang_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}



	// Xuất excel 


	public function anyExportExcelDistribute(){
		$id_template = 11;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'date',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai',
								'hinh_thuc'
								],
						'arr_head' => 	[
								['text'=>'STT','class'=>''],
								['text'=>'Ngày','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money'],
								['text'=>'Thanh toán','class'=>'']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_distribute'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_distribute'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$arr_print['arr_data']['company_name'] = $arr_cache['company_name'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai = $value['con_lai'];
			}
			$arr_print['arr_list']['arr_sum'][] = [
				['value'=>'Tổng:','colspan'=>'1'],
				['value'=>$total_sum_amount],
				['value'=>$total_sum_paid],
				['value'=>'','class'=>'center'],
				['value'=>$total_con_lai]
			];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintExcel($arr_print,$id_template,'cong_no_ncc_'.str_replace('-','_',\Str::slug($arr_cache['company_name'])).'_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportExcelDistributeMonth(){
		$id_template = 12;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'company_name',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'STT','class'=>''],
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_distribute_month'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_distribute_month'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai += $value['con_lai'];
			}
			// $arr_print['arr_list']['arr_sum'][] = [
			// 	['value'=>'Tổng:','colspan'=>'1'],
			// 	['value'=>$total_sum_amount],
			// 	['value'=>$total_sum_paid],
			// 	['value'=>'','class'=>'center'],
			// 	['value'=>$total_con_lai]
			// ];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintExcel($arr_print,$id_template,'cong_no_ncc_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportExcelDistributeYear(){
		$id_template = 13;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'company_name',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'STT','class'=>''],
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_distribute_year'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_distribute_year'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai = +$value['con_lai'];
			}
			// $arr_print['arr_list']['arr_sum'][] = [
			// 	['value'=>'Tổng:','colspan'=>'1'],
			// 	['value'=>$total_sum_amount],
			// 	['value'=>$total_sum_paid],
			// 	['value'=>'','class'=>'center'],
			// 	['value'=>$total_con_lai]
			// ];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintExcel($arr_print,$id_template,'cong_no_ncc_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportExcelCustomer(){
		$id_template = 16;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'date',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai',
								'hinh_thuc'
								],
						'arr_head' => 	[
								['text'=>'STT','class'=>''],
								['text'=>'Ngày','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money'],
								['text'=>'Thanh toán','class'=>'']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_customer'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_customer'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			// pr($list_order);die;
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$arr_print['arr_data']['company_name'] = $arr_cache['company_name'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$list_order[$key]['date'] = date('d-m-Y',strtotime($value['date']));
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai = $value['con_lai'];
			}
			// $arr_print['arr_list']['arr_sum'][] = [
			// 	['value'=>'Tổng:','colspan'=>'1'],
			// 	['value'=>$total_sum_amount],
			// 	['value'=>$total_sum_paid],
			// 	['value'=>'','class'=>'center'],
			// 	['value'=>$total_con_lai]
			// ];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintExcel($arr_print,$id_template,'cong_no_kh_'.str_replace('-','_',\Str::slug($arr_cache['company_name'])).'_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	} 

	public function anyExportExcelCustomerMonth(){
		$id_template = 15;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'company_name',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'STT','class'=>''],
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_customer_month'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_customer_month'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['month'] = $arr_cache['month'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai += $value['con_lai'];
			}
			// $arr_print['arr_list']['arr_sum'][] = [
			// 	['value'=>'Tổng:','colspan'=>'1'],
			// 	['value'=>$total_sum_amount],
			// 	['value'=>$total_sum_paid],
			// 	['value'=>'','class'=>'center'],
			// 	['value'=>$total_con_lai]
			// ];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintExcel($arr_print,$id_template,'cong_no_kh_thang_'.$arr_cache['month'].'_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	public function anyExportExcelCustomerYear(){
		$id_template = 14;
		$arr_print = 	[
				'arr_list' =>	[
						'arr_key' => 	[
								'company_name',
								'sum_amount',
								'paid',
								'no_cu',
								'con_lai'
								],
						'arr_head' => 	[
								['text'=>'STT','class'=>''],
								['text'=>'Nhà cung cấp','class'=>''],
								['text'=>'Tổng tiền toa','class'=>'money'],
								['text'=>'Tiền thanh toán','class'=>'money'],
								['text'=>'Nợ cũ','class'=>'money'],
								['text'=>'Còn lại','class'=>'money']
								],
						'arr_body'=>[],
						'arr_sum'=>[]
						],
				'arr_data'=>	[

						]
				];	
		if (\Cache::has('list_receipt_customer_year'.\Auth::user()->id)){
			$arr_cache = \Cache::get('list_receipt_customer_year'.\Auth::user()->id);
			$list_order = $arr_cache['list_order'];
			$arr_print['arr_data']['year'] = $arr_cache['year'];
			$total_sum_amount = 0;
			$total_sum_paid = 0;
			$total_con_lai = 0;
			foreach ($list_order as $key => $value) {
				$total_sum_amount += $value['sum_amount'];
				$total_sum_paid += $value['paid'];
				$total_con_lai += $value['con_lai'];
			}
			// $arr_print['arr_list']['arr_sum'][] = [
			// 	['value'=>'Tổng:','colspan'=>'1'],
			// 	['value'=>$total_sum_amount],
			// 	['value'=>$total_sum_paid],
			// 	['value'=>'','class'=>'center'],
			// 	['value'=>$total_con_lai]
			// ];
			$arr_print['arr_list']['arr_body'] = $list_order;
			$link = ExportsController::getCreatePrintExcel($arr_print,$id_template,'cong_no_kh_nam_'.$arr_cache['year'],'potrait');
			return redirect($link);
		}
		die;
	}

	
	
}	