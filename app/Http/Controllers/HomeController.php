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

class HomeController extends Controller {
	protected $layout = 'layout.index';

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
		$this->middleware('auth');
		$this->middleware('admin');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$new_so = Saleorder::where('status','=','0')->count();
		$new_rso = ReturnSaleorder::where('status','=','0')->count();
		$new_po = Purchaseorder::where('status','=','0')->count();
		$new_rpo = ReturnPurchaseorder::where('status','=','0')->count();
		$tong_san_pham = Product::count();
		$begin = date('Y-m-d H:i:s',strtotime(date('d-m-Y')));
		$end = date('Y-m-d H:i:s',strtotime(date('d-m-Y'))-15*86400);

		$doanh_so = Saleorder::addSelect(\DB::raw('sum(sum_amount) as y'))
							->addSelect(\DB::raw('Date(date) as x'))
							->where('status',1)
							->groupBy('x')
							->orderBy('x','desc')
							->limit(7)
							->get()->toArray();
		$arr_x = array();
		foreach ($doanh_so as $key => $value) {
			$arr_x[] = $value['x'];
			$doanh_so[$key]['x'] = date('m-d-Y',strtotime($value['x'])); 
		}
		array_multisort($arr_x,SORT_ASC,$doanh_so);
		$doanh_so = json_encode($doanh_so);

		$this->layout->content = view('dashboard.dashboard',[
							'new_so'	=>	$new_so,
							'new_rso'	=>	$new_rso,
							'new_po'	=>	$new_po,
							'new_rpo'	=>	$new_rpo,
							'tong_san_pham'=>	$tong_san_pham, 
							'doanh_so'	=>	$doanh_so
						]);
	}

}