<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Menu;
use App\Oum;
use App\CompanyType;
use App\ProductType;
use App\Province;
use App\Country;
use App\UserType;
use App\Role;
use App\Permission;
use App\PdfTemplate;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Requests\Admin\DeleteRequest;
use Datatables;


class SettingsController extends Controller {

	protected $layout = 'setting.setting';
	/*
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function getIndex()
	{
		// Show the page

	}

	public function anyManageUserSettings(Request $request)
	{
		return view('setting.manage-user',[]);
	}

	public function anyUserSettings(Request $request)
	{
		$users = User::select('users.*','roles.display_name as type_name','roles.id as type_id')
		->leftJoin('role_user',function($join){
			$join->on("users.id","=","role_user.user_id");
		})
		->leftJoin('roles','role_user.role_id','=','roles.id');
		$users = $users->paginate(5);
		$user_types = Role::get()->toArray();

		$view = view('setting.list-user',['user_types' => $user_types,'users'=>$users]);
		if( $request->ajax() ) {
			return $view;
		} else {
			$this->layout->content = $view;
		}
	}

	public function anyMenuSettings()
	{
		   $menus = Menu::getMenuSetting();
		return view('setting.list-menu',["menus"=>$menus]);
	}

	public function anyOtherSettings()
	{
		return view('setting.list-other',[]);
	}
	// OUM Module
	public function anyOumSettings()
	{
		$oums = Oum::orderBy('name')->get();
		return view('setting.list-oum',["oums"=>$oums]);
	}

	public function postUpdateOum(Request $request)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$id = $request->has('id')?$request->input('id'):0;
		$name =$request->has('name')? $request->input('name') : '';
		if( $id ) {
			$oum = Oum::find($id);
		} else {
			$oum = new Oum;
		}
		$oum->name = $name;
		if($oum -> save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Saving fail";
		}
		return $arr_return;
	}

	 public function getDeleteOum($id)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$oum = Oum::find($id);
		if($oum->delete()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Delete fail";
		}
		return $arr_return;
	}
//=========================================================
	// CompanyType Module
	public function anyCompanytypeSettings()
	{
		$companytypes = CompanyType::orderBy('name')->get();
		return view('setting.list-companytype',["companytypes"=>$companytypes]);
	}

	public function postUpdateCompanytype(Request $request)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$id = $request->has('id')?$request->input('id'):0;
		$name =$request->has('name')? $request->input('name') : '';
		if( $id ) {
			$companytype = CompanyType::find($id);
		} else {
			$companytype = new CompanyType;
		}
		$companytype->name = $name;
		if($companytype -> save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Saving fail";
		}
		return $arr_return;
	}

	 public function getDeleteCompanytype($id)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$companytype = CompanyType::find($id);
		if($companytype->delete()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Delete fail";
		}
		return $arr_return;
	}

//=========================================================
// ProductType Module
	public function anyProducttypeSettings()
	{
		$producttypes = ProductType::orderBy('name')->get();
		return view('setting.list-producttype',["producttypes"=>$producttypes]);
	}

	public function postUpdateProducttype(Request $request)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$id = $request->has('id')?$request->input('id'):0;
		$name =$request->has('name')? $request->input('name') : '';
		if( $id ) {
			$producttype = ProductType::find($id);
		} else {
			$producttype = new ProductType;
		}
		$producttype->name = $name;
		if($producttype -> save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Saving fail";
		}
		return $arr_return;
	}

	public function getDeleteProducttype($id)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$producttype = ProductType::find($id);
		if($producttype->delete()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Delete fail";
		}
		return $arr_return;
	}

//=========================================================
	public function getCreate()
	{

		return View('setting.create-edit-user');
	}


	public function postCreate(UserRequest $request)
	{
		$user = new User();
		$user->name = $request->name;
		$user->username = $request->username;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->confirmed = $request->confirmed;
		$user->save();
	}

/* public function postCreateCountry(Request $request, $id)
    {
        $arr_return = array();
        $province = new Province();
        $name = 'unidentified';
        $country_id = $id;
        if($province->save){
            $arr_return['status'] = 'success';
     }else{
            $arr_return['message'] = 'Saving fail';
     }
        return $arr_return;
 }*/

 public function getListProvince(Request $request, $country_id)
    {
        $provinces = Province::getProvinceByCountry($country_id);
        $countries = Country::getCountry();
        return view('setting.list-province',["provinces"=>$provinces,"countries" => $countries]);
        /*$html='<ul>';
            foreach($provinces as $key => $province){
                $html.= '<li>';
                    $html.=$province['name'];
                $html.='</li>';
         }
        $html.='</ul>';
        return $html;*/
 }

 public function postUpdateProvince(Request $request)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$id = $request->has('id')?$request->input('id'):0;
		$name =$request->has('name')? $request->input('name') : '';
		$country_id = $request->has('country_id') ? $request->input('country_id') : '';
		if( $id ) {
			$province = Province::find($id);
		} else {
			$province = new Province;
		}
		$province->name = $name;
		$province->country_id = $country_id;
		if($province -> save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Saving fail";
		}
		return $arr_return;
	}

	public function getDeleteProvince($id)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$province = Province::find($id);
		if($province->delete()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Delete fail";
		}
		return $arr_return;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $user
	 * @return Response
	 */
	public function postUpdateUser(Request $request)
	{
		$arr_return = array(
								"status"=>"error"
							);
		$id = $request->has('id')?$request->input('id'):0;
		$password = $request->has('password')? $request->input('password') : '';
		$passwordConfirmation = $request->has('password_confirmation')? $request->input('password_confirmation') : '';
		$email = $request->has('email')? $request->input('email') : '';
		$name =$request->has('name')? $request->input('name') : '';
		$confirmed = $request->has('confirmed')? 1 : 0;
		$type_id = $request->has('type_id')?$request->input('type_id'):0;
		if( $id ) {
			$user = User::find($id);
		} else {
			$user = new User;
		}
		if (!empty($password)) {
				if ($password === $passwordConfirmation) {
					$user ->password = bcrypt($password);
				}else{
					$arr_return['message']= "Password comfirm wrong";
				}
			}
		$user->name = $name;
		$user->confirmed = $confirmed;
		$user->email = $email;
		$user->user_type_id = $type_id;
		if($user -> save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Saving fail";
		}
		return $arr_return;
	}

	public function getDeleteUser($id)
	{
		$arr_return = array(
								"status"=>"error"
							);
		$user = User::find($id);
		if($user->delete()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message']= "Delete fail";
		}
		return $arr_return;
	}

	public function anyProvinceSettings()
	{
		$countries = Country::getCountry();
		return View('setting.list-province-country',["countries" => $countries]);
	}

	public function postCreateCountry(Request $request)
	{
		$arr_return = array();
		$country = new Country();
		$name = $request->has('name') ? $request->input('name') : '';
		$country->name = $name;
		if($country->save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message'] = 'Saving fail';
		}
		return $arr_return;
	}


	public function postUpdateMenu(Request $request)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$id = $request->has('id')?$request->input('id') : 0;

		if($id){
			$menu = Menu::find($id);
		}else{
			$menu = new Menu;
		}

		$menu->name = $request->has('name')?$request->input('name'):'';
		$menu->link = $request->has('link')?$request->input('link'):'';
		$menu->parent_id = $request->has('parent_id')?$request->input('parent_id'):'';
		$menu->icon_class = $request->has('icon_class')?$request->input('icon_class'):'';
		// $menu->order_no = $request->has('order_no')?$request->input('order_no'):0;
		$menu->active = $request->has('active')?1:0;
		if($menu->save()){
			$arr_return['status'] = 'success';
		}else{
			$arr_return['message'] = 'Saving fail';
		}
		return $arr_return;

	}

	public function postUpdateOrderMenu(Request $request)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$data = $request->has('data')?$request->input('data') : array();
		pr($data);
		$order = 1;
		$check=true;
		foreach ($data as $key => $value) {
			$menu = Menu::find($value['id']);
			$menu->order_no = $order;
			echo $order;
			$check = $check && $menu->save();
			if(isset($value['children'])){
				foreach ($value['children'] as $key2 => $value2) {
					$menu = Menu::find($value2['id']);
													$menu->parent_id = $value['id'];
					$menu->order_no = $order;
					$order++;
					$check = $check && $menu->save();
				}
			}
		}

		if($check){
			$arr_return = array(
				"status"=>"success"
			);
		}else{
			$arr_return = array(
				"status"=>"Error update order"
			);
		}
		return $arr_return;
	}

	public function postDeleteMenu(Request $request)
	{
		$arr_return = array(
			"status"=>"error"
		);
		$id = $request->has('id')?$request->input('id') : 0;
		$menu = Menu::find($id);
		if($menu){
			if($menu->delete()){
				$arr_return['status'] = 'success';
			}else{
				$arr_return['message'] = 'Saving fail';
			}
		}else{
			$arr_return['message'] = 'Menu not found';
		}
		return $arr_return;
	}
 public function postCreateProvince(Request $request)
    {
        $arr_return = array();
        $province = new Province();
        $name = $request->has('name') ? $request->input('name') : '';
        $country_id = $request->has('popup_country') ? $request->input('popup_country') : '';
        $province->name = $name;
        $province->country_id = $country_id;
        if($province->save()){
            $arr_return['status'] = 'success';
     }else{
            $arr_return['message'] = 'Saving fail';
     }
        return $arr_return;
 }

public function postMenuInfo(Request $request)
   {
		$arr_return = array();
		$id = $request->has('id')?$request->input('id') : 0;
		if($id){
				$menu = Menu::find($id);
				$arr_return = $menu;
		}
		return $arr_return;
}

public function anyUserTypeSettings()
   {
   		$usertypes = Role::orderBy('name')->get();
   		return view('setting.list-user-type',["usertypes" => $usertypes]);
}

public function postUpdateUserTypeSettings(Request $request)
   {
   		$arr_return = array("status" => "error");
   		$id= $request->has('id')?$request->input('id'):0;
   		$name = $request->has('name')?$request->input('name'):'';
   		$description = $request->has('description')?$request->input('description'):'';
   		$main = $request->has('main')?$request->input('main'):'';
   		if($id){
   			$usertype = Role::find($id);
   		}else{
   			$usertype = new Role;
   		}
   		$usertype->name = str_replace('-','_',\Str::slug($name));
   		$usertype->display_name = $name;
   		$usertype->description = $description;
   		$usertype->main = $main;
   		if($usertype->save()){
   			$arr_return['status'] = 'success';
   		}else{
   			$arr_return['message'] = 'saving fail';
   		}
   		return $arr_return;
}

public function anyDeleteUserType($id)
   {
   		$arr_return = array('status' => 'error');
   		$usertype = UserType::find($id);
   		if($usertype->delete()){
   			$arr_return['status'] = 'success';
   		}else{
   			$arr_return['message'] = 'Delete fail';
   		}
   		return $arr_return;
}

// =========== Permission =============
public function anyPermisionSettings(){
   	$roles = Role::orderBy('main','name')->get()->toArray();
   	$permissions = Permission::select('permissions.*')
   				->addSelect(\DB::raw('right(`name`,length(`name`)-instr(`name`,"-")) as controller'))
   				->orderBy('controller','id')
   				->get()
   				->toArray();
   	return view('setting.list-permission',[
   						"roles" 		=> 	$roles,
   						"permissions"	=>	$permissions
   					]);
}

public function postPermissionDetail(Request $request){
	$id = $request->has('id')?$request->get('id'):0;
	$permissions  = \DB::select('select * from `permission_role` where `role_id`= :id',['id'=>$id]);
	return $permissions;
}

public function postSavePermission(Request $request){
	$arr_return = ['status'=>'error'];
	$check = true;
	$role_id = $request->has('role_id')?$request->get('role_id'):0;
	$permission_id = $request->has('permission_id')?$request->get('permission_id'):array();
	$list_has_role = \DB::table('permission_role')->where('role_id','=',$role_id)->lists('permission_id');
	$arr_delete = array();
	$arr_insert = array();
	foreach ($permission_id as $key => $value) {
		if(!in_array($value, $list_has_role))
			$arr_insert[] = ['role_id'=>$role_id,'permission_id'=>$value];
	}
	foreach ($list_has_role as $key => $value) {
		if(!in_array($value, $permission_id))
			$arr_delete[] = $value;
	}
	//pr($arr_delete);
	// die;
	if(count($arr_insert)){
		$tmp = \DB::table('permission_role')->insert($arr_insert);
		$check = $check && $tmp;
	}
	if(count($arr_delete)){
		$tmp = \DB::table('permission_role')->where('role_id','=',$role_id)->whereIn('permission_id',$arr_delete)->delete();
		$check = $check && $tmp;
	}
	if($check){
		$arr_return['status'] = 'success';
	}else{
		$arr_return['message'] = 'Error';
	}
	return $arr_return;
}



   // ========== PDF Setting ===========
public function anyPdfSettings(){
   	$pdf_templates = PdfTemplate::orderBy('name')->get()->toArray();
   	return view('setting.list-pdf-template',["pdf_templates" => $pdf_templates]);
}

public function getGetTemplate($id){
   	$pdf = PdfTemplate::find($id);
   	if($pdf)
   		return $pdf;
   	else
   		return array();
}

public function anySaveTemplate(Request $request){
   	$arr_return = array('status' => 'error');
   	$id = $request->has('id')?$request->input('id'):0;
   	$pdf = PdfTemplate::find($id);
   	if($pdf){
   		$pdf->template = $request->has('template')?$request->input('template'):'';
   		$pdf->oriental = $request->has('oriental')?$request->input('oriental'):'';
   		if($pdf->save()){
   			$arr_return['status'] = 'success';
   		}else{
   			$arr_return['message'] = 'Saving fail';
   		}
   	}
   	else
   		$arr_return['message'] = 'Not found';
   	return $arr_return;
}
   // =============================

public function anyCreateRole(){
   	// Create Role
	$admin_role = new Role();
	$admin_role->name         = 'admin';
	$admin_role->display_name = 'Quản trị web'; // optional
	$admin_role->description  = 'Toàn quyền trên hệ thống'; // optional
	$admin_role->main = 1;
	$admin_role->save();

	$user_role = new Role();
	$user_role->name         = 'user';
	$user_role->display_name = 'Nhân viên'; // optional
	$user_role->description  = 'User chỉ được thực thi những quyền chỉ định'; // optional
	$user_role->main = 1;
	$user_role->save();


 	//////////////////////////////   Create Permission    //////////////////////////////

	// tạo order
	$createpo = new Permission();
	$createpo->name         = 'create-purchaseorders';
	$createpo->display_name = 'Tạo đơn mua hàng'; // optional
	$createpo->description  = 'Tạo đơn mua hàng'; // optional
	$createpo->save();

	$createso = new Permission();
	$createso->name         = 'create-saleorders';
	$createso->display_name = 'Tạo đơn hàng'; // optional
	$createso->description  = 'Tạo đơn hàng'; // optional
	$createso->save();

	$createrpo = new Permission();
	$createrpo->name         = 'create-returnpurchaseorders';
	$createrpo->display_name = 'Tạo đơn hàng trả NCC'; // optional
	$createrpo->description  = 'Tạo đơn hàng trả NCC'; // optional
	$createrpo->save();

	$createrso = new Permission();
	$createrso->name         = 'create-returnsaleorders';
	$createrso->display_name = 'Tạo đơn hàng đại lý trả'; // optional
	$createrso->description  = 'Tạo đơn hàng đại lý trả'; // optional
	$createrso->save();

	// hoàn thành order
	$completepo = new Permission();
	$completepo->name         = 'complete-purchaseorders';
	$completepo->display_name = 'Hoàn thành đơn mua hàng'; // optional
	$completepo->description  = 'Hoàn thành đơn mua hàng'; // optional
	$completepo->save();

	$completeso = new Permission();
	$completeso->name         = 'complete-saleorders';
	$completeso->display_name = 'Hoàn thành đơn hàng'; // optional
	$completeso->description  = 'Hoàn thành đơn hàng'; // optional
	$completeso->save();

	$completerpo = new Permission();
	$completerpo->name         = 'complete-returnpurchaseorders';
	$completerpo->display_name = 'Hoàn thành đơn hàng trả NCC'; // optional
	$completerpo->description  = 'Hoàn thành đơn hàng trả NCC'; // optional
	$completerpo->save();

	$completerso = new Permission();
	$completerso->name         = 'complete-returnsaleorders';
	$completerso->display_name = 'Hoàn thành đơn hàng đại lý trả'; // optional
	$completerso->description  = 'Hoàn thành đơn hàng đại lý trả'; // optional
	$completerso->save();

	// Cập nhật order
	$editpo = new Permission();
	$editpo->name         = 'edit-purchaseorders';
	$editpo->display_name = 'Cập nhật đơn mua hàng'; // optional
	$editpo->description  = 'Cập nhật đơn mua hàng'; // optional
	$editpo->save();

	$editso = new Permission();
	$editso->name         = 'edit-saleorders';
	$editso->display_name = 'Cập nhật đơn hàng'; // optional
	$editso->description  = 'Cập nhật đơn hàng'; // optional
	$editso->save();

	$editrpo = new Permission();
	$editrpo->name         = 'edit-returnpurchaseorders';
	$editrpo->display_name = 'Cập nhật đơn hàng trả NCC'; // optional
	$editrpo->description  = 'Cập nhật đơn hàng trả NCC'; // optional
	$editrpo->save();

	$editrso = new Permission();
	$editrso->name         = 'edit-returnsaleorders';
	$editrso->display_name = 'Cập nhật đơn hàng đại lý trả'; // optional
	$editrso->description  = 'Cập nhật đơn hàng đại lý trả'; // optional
	$editrso->save();

	// view order
	$viewpo = new Permission();
	$viewpo->name         = 'view-purchaseorders';
	$viewpo->display_name = 'Xem đơn mua hàng'; // optional
	$viewpo->description  = 'Xem đơn mua hàng'; // optional
	$viewpo->save();

	$viewso = new Permission();
	$viewso->name         = 'view-saleorders';
	$viewso->display_name = 'Xem đơn hàng'; // optional
	$viewso->description  = 'Xem đơn hàng'; // optional
	$viewso->save();

	$viewrpo = new Permission();
	$viewrpo->name         = 'view-returnpurchaseorders';
	$viewrpo->display_name = 'Xem đơn hàng trả NCC'; // optional
	$viewrpo->description  = 'Xem đơn hàng trả NCC'; // optional
	$viewrpo->save();

	$viewrso = new Permission();
	$viewrso->name         = 'view-returnsaleorders';
	$viewrso->display_name = 'Xem đơn hàng đại lý trả'; // optional
	$viewrso->description  = 'Xem đơn hàng đại lý trả'; // optional
	$viewrso->save();


	// Xóa order
	$deletepo = new Permission();
	$deletepo->name         = 'delete-purchaseorders';
	$deletepo->display_name = 'Xóa đơn mua hàng'; // optional
	$deletepo->description  = 'Xóa đơn mua hàng'; // optional
	$deletepo->save();

	$deleteso = new Permission();
	$deleteso->name         = 'delete-saleorders';
	$deleteso->display_name = 'Xóa đơn hàng'; // optional
	$deleteso->description  = 'Xóa đơn hàng'; // optional
	$deleteso->save();

	$deleterpo = new Permission();
	$deleterpo->name         = 'delete-returnpurchaseorders';
	$deleterpo->display_name = 'Xóa đơn hàng trả NCC'; // optional
	$deleterpo->description  = 'Xóa đơn hàng trả NCC'; // optional
	$deleterpo->save();

	$deleterso = new Permission();
	$deleterso->name         = 'delete-returnsaleorders';
	$deleterso->display_name = 'Xóa đơn hàng đại lý trả'; // optional
	$deleterso->description  = 'Xóa đơn hàng đại lý trả'; // optional
	$deleterso->save();

	// Tạo mới, hoàn thành, xóa sản phẩm, thêm giá bán
	
	$createproduct = new Permission();
	$createproduct->name         = 'create-products';
	$createproduct->display_name = 'Tạo sản phẩm'; // optional
	$createproduct->description  = 'Tạo sản phẩm'; // optional
	$createproduct->save();

	$deleteproduct = new Permission();
	$deleteproduct->name         = 'delete-products';
	$deleteproduct->display_name = 'Xóa sản phẩm'; // optional
	$deleteproduct->description  = 'Xóa sản phẩm'; // optional
	$deleteproduct->save();

	$sellpriceproduct = new Permission();
	$sellpriceproduct->name         = 'sellprice-products';
	$sellpriceproduct->display_name = 'Thêm giá bán sản phẩm'; // optional
	$sellpriceproduct->description  = 'Thêm giá bán sản phẩm'; // optional
	$sellpriceproduct->save();

	$viewproduct = new Permission();
	$viewproduct->name         = 'view-products';
	$viewproduct->display_name = 'Xem sản phẩm'; // optional
	$viewproduct->description  = 'Xem sản phẩm'; // optional
	$viewproduct->save();

	$editproduct = new Permission();
	$editproduct->name         = 'edit-products';
	$editproduct->display_name = 'Cập nhật sản phẩm'; // optional
	$editproduct->description  = 'Cập nhật sản phẩm'; // optional
	$editproduct->save();

	// Tạo mới, hoàn thành, xóa công ty
	
	$createcompany = new Permission();
	$createcompany->name         = 'create-companies';
	$createcompany->display_name = 'Tạo công ty'; // optional
	$createcompany->description  = 'Tạo công ty'; // optional
	$createcompany->save();

	$deletecompany = new Permission();
	$deletecompany->name         = 'delete-companies';
	$deletecompany->display_name = 'Xóa công ty'; // optional
	$deletecompany->description  = 'Xóa công ty'; // optional
	$deletecompany->save();

	$viewcompany = new Permission();
	$viewcompany->name         = 'view-companies';
	$viewcompany->display_name = 'Xem công ty'; // optional
	$viewcompany->description  = 'Xem công ty'; // optional
	$viewcompany->save();

	$editcompany = new Permission();
	$editcompany->name         = 'edit-companies';
	$editcompany->display_name = 'Cập nhật công ty'; // optional
	$editcompany->description  = 'Cập nhật công ty'; // optional
	$editcompany->save();

	// Setting
	$viewsetting = new Permission();
	$viewsetting->name         = 'view-settings';
	$viewsetting->display_name = 'Truy cập bảng điều khiển'; // optional
	$viewsetting->description  = 'Truy cập bảng điều khiển'; // optional
	$viewsetting->save();

	//Công nợ
	$viewreceipt = new Permission();
	$viewreceipt->name         = 'view-receipts';
	$viewreceipt->display_name = 'Truy cập công nợ'; // optional
	$viewreceipt->description  = 'Truy cập công nợ'; // optional
	$viewreceipt->save();

	//Doanh thu
	$viewrevenue = new Permission();
	$viewrevenue->name         = 'view-revenues';
	$viewrevenue->display_name = 'Truy cập doanh thu'; // optional
	$viewrevenue->description  = 'Truy cập doanh thu'; // optional
	$viewrevenue->save();

	//Doanh thu
	$viewhistory = new Permission();
	$viewhistory->name         = 'view-historys';
	$viewhistory->display_name = 'Truy cập lịch sử'; // optional
	$viewhistory->description  = 'Truy cập lịch sử'; // optional
	$viewhistory->save();

	// Add permission to role

	$admin_role->attachPermissions(array(
						$createpo,
						$createso,
						$createrpo,
						$createrso,
						$completepo,
						$completeso,
						$completerpo,
						$completerso,
						$editpo,
						$editso,
						$editrpo,
						$editrso,
						$viewpo,
						$viewso,
						$viewrpo,
						$viewrso,
						$deletepo,
						$deleteso,
						$deleterpo,
						$deleterso,
						$createproduct,
						$deleteproduct,
						$sellpriceproduct,
						$viewproduct,
						$editproduct,
						$createcompany,
						$deletecompany,
						$viewcompany,
						$editcompany,
						$viewsetting,
						$viewreceipt,
						$viewrevenue,
						$viewhistory
					));

	$user_role->attachPermissions(array(
						$createpo,
						$createso,
						$createrpo,
						$createrso,
						// $completepo,
						// $completeso,
						// $completerpo,
						// $completerso,
						$editpo,
						$editso,
						$editrpo,
						$editrso,
						$viewpo,
						$viewso,
						$viewrpo,
						$viewrso,
						// $deletepo,
						// $deleteso,
						// $deleterpo,
						// $deleterso,
						$createproduct,
						$deleteproduct,
						$sellpriceproduct,
						$viewproduct,
						$editproduct,
						$createcompany,
						$deletecompany,
						$viewcompany,
						$editcompany,
						// $viewsetting,
						// $viewreceipt,
						// $viewrevenue
						// $viewhistory
					));
	echo "done";
	die;
}


}
