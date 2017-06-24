<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Contracts\Routing\ResponseFactory;
use Zizaco\Entrust\EntrustPermission;
use Auth;
use Request;


use App\AssignedRoles;

class Permission extends EntrustPermission implements Middleware {

	/**
	* The Guard implementation.
	*
	* @var Guard
	*/
	protected $auth;
	
	/**
	* Create a new filter instance.
	*
	* @param  Guard  $auth
	* @return void
	*/
	public function __construct(Guard $auth)
	{
	//$this->auth = $auth;
	}
	
	/**
	* Handle an incoming request.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \Closure  $next
	* @return mixed
	*/
	public function handle($request, Closure $next)
	{
		list($controller, $method) = explode('@', $request->route()->getActionName());
		if( !$this->checkPermission($controller, $method) ){
			if(Request::ajax()){
						return [
							"status" => "error",
							"message" => "Tài khoản không có quyền thực thi lệnh này"
							] ;
					}else{
					
						return '<h1>Tài khoản không có quyền vào trang này.</h1><script>setTimeout(function(){window.location = "'.URL.'"},2500)</script>';
					}
		}
		return $next($request);
	}
	
	public function checkPermission($controller, $method)
	{
		$add    = false;
		$update = false;
		$delete = false;
		$admin = Auth::user();
		$controller =  strtolower(str_replace(['App\Http\Controllers','\\','Controller'], '', $controller));
		if($method == 'anyCreateRole'){
			return true;
		}
		if( Request::is($controller."*") ){
			if(strpos($method, 'anyDelete') !== false){
				if( $admin->can("delete-$controller") ){
					return true;
				}else{
					return false;
				}
			}elseif(strpos($method, 'anyCreate') !== false){
				if( $admin->can("create-$controller") ){
					return true;
				}else{
					return false;
				}
			}elseif(strpos($method, 'anyLog') !== false){
				if( $admin->can("view-history") ){
					return true;
				}else{
					return false;
				}
			}else{
				if( $admin->can("view-$controller") )
					return true;
			}
		}
		return false;
	}

}