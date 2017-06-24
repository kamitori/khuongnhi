<?php
use App\Menu;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/exports/try','ExportsController@getTry');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



Route::get('/',[ 'middleware' => 'auth','uses' =>'HomeController@index']);
Route::get('/logout',function(){
	return redirect('/auth/logout');
});
// Route::get('/view', function () {
// 	$menus = Menu::getMenu() ;
// 	return view('layout.index')->with([
// 					"content"=>view("example"),
// 					"menus"=>$menus
// 					]);
// });

// Route::get('/login', function () {
// 	return view('login');
// });

Route::get('/home', 'HomeController@index');
Route::get('/auto', 'AutosController@index');

Route::get('/{controller}/{id}',['middleware' => 'auth', function($controller,$id){
		$controller = str_replace('-', ' ', strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $controller)));
		$controller = str_replace(' ',  '', Str::title($controller));
		$controller = 'App\\Http\\Controllers\\'.$controller.'Controller';
		$app = app();
		$controller = $app->make($controller);
		$request = new Request;
		$arr_param = array($request,$id);
		return $controller->callAction('anyEntry', $arr_param);
}])->where([
	'controller' => '[^/]+',
	'id'=>'[0-9]+'
	]);
Route::controllers([
	   'settings' => 'SettingsController',
		]);
Route::controllers([
	   'companies' => 'CompaniesController',
		]);
Route::controllers([
	   'products' => 'ProductsController',
		]);
Route::controllers([
	   'purchaseorders' => 'PurchaseordersController',
		]);
Route::controllers([
	   'returnpurchaseorders' => 'ReturnPurchaseordersController',
		]);
Route::controllers([
	   'saleorders' => 'SaleordersController',
		]);
Route::controllers([
	   'returnsaleorders' => 'ReturnSaleordersController',
		]);
Route::controllers([
	   'receipts' => 'ReceiptsController',
		]);
Route::controllers([
	   'revenues' => 'RevenuesController',
		]);
Route::controllers([
	   'exports' => 'ExportsController',
		]);
Route::controllers([
	   'users' => 'UsersController',
		]);
Route::controllers([
	   'auto' => 'AutosController',
		]);
