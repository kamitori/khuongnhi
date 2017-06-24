<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductType;
use App\MProduct;
use App\Company;
use App\Country;
use App\Province;
use App\User;
use App\Oum;
use App\ProductStock;
use App\Purchaseorder;
use App\ReturnPurchaseorder;
use App\Saleorder;
use App\ReturnSaleorder;
use App\Paid;
use App\ReceiptMonth;
use App\Address;
use App\SellPrice;
use DB;
use Auth;

class AutosController extends Controller {
	protected $layout = 'layout.index';
	protected $auth_check = 0;

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		Auth::loginUsingId(1, true);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		echo "TEST AUTO";die;
	}

	static public function anyUpdateReceiptMonth(){
		$year = intval(date('Y'));
		$month = intval(date('m'));

		// Customer
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

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// Distribute
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
		date_default_timezone_set('Asia/Saigon');
		file_put_contents("log.data", date('d-m-Y G:i:s')."\n");
		return date('d-m-Y G:i:s')."\n";
	}

	static public function anyUpdateReceiptMonthCompany(){
		$list_company = Company::get()->toArray();
		foreach ($list_company as $key2 => $value2) {
			$company_id = $value2['id'];
			echo $company_id;
			$list_distribute = ReceiptMonth::where("company_id","=",$company_id)
									  ->where('type_receipt','=','distribute')
									  ->orderBy('year','ASC')
									  ->orderBy('month','ASC')
									  ->get()->toArray();
			if(count($list_distribute)){
				foreach ($list_distribute as $key => $value) {
					if($key==0){
						$current = ReceiptMonth::where("id","=",$value['id'])->first();
						$current->con_lai = $current->sum_amount - $current->paid + $current->no_cu;
						$current->save();
					}else{
						$current = ReceiptMonth::where("id","=",$value['id'])->first();
						$current->no_cu = $list_distribute[$key-1]['con_lai'];
						$current->con_lai = $current->sum_amount - $current->paid + $current->no_cu;
						$current->save();
					}
				}
			}

			$list_customer = ReceiptMonth::where("company_id","=",$company_id)
									  ->where('type_receipt','=','customer')
									  ->orderBy('year','ASC')
									  ->orderBy('month','ASC')
									  ->get()->toArray();
			// if($company_id==70){
			// 	echo "<br/><br/>";
			// 	pr($list_customer);die;
			// }
			if(count($list_customer)){
				foreach ($list_customer as $key => $value) {
					if($key==0){
						$current = ReceiptMonth::where("id","=",$value['id'])->first();
						$current->con_lai = $current->sum_amount - $current->paid + $current->no_cu;
						$current->save();
					}else{
						$current = ReceiptMonth::where("id","=",$value['id'])->first();
						$current->no_cu = $list_customer[$key-1]['con_lai'];
						$current->con_lai = $current->sum_amount - $current->paid + $current->no_cu;
						$current->save();
					}
				}
			}
		}
		file_put_contents("log.data", date('d-m-Y G:i:s')."\n");
		echo "Done!";
		die;
	}

}