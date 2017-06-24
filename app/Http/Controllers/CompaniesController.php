<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Company;
use App\Address;
use App\Province;
use App\CompanyType;
use App\Country;
use App\Oum;
use App\ProductType;
use App\Product;
use Datatables;
use Illuminate\Http\Request;
use Session;
use DB;

class CompaniesController extends Controller{
	//protected $layout = 'layout.index';

	public function getIndex(Request $request)
	{
		 self::anyEntry($request);
	}

	public function anyEntry(Request $request,$id=null)
	{
		\DB::enableQueryLog();
		if(isset($id) && $id!=null){
			$company = Company::find($id);
			if($company != null){
				session(['current_company' => $company->id]);
			}else{
				return redirect('companies');
			}
		}else{	
			$id = session('current_company') !== null ? session('current_company') : 0;
			$address_id = session('current_address') !== null ? session('current_address') : 0;
			if($id){
				$company = Company::find($id);
				session(["current_company" => $company->id]);
			}else{
				$company = Company::get()->last();
				if($company){
					session(["current_company" => $company->id]);
				}else{
					$company = new Company;
					$company->save();
					session(['current_company' => $company->id]);
				}
			}
		}

		$address = Address::where('module_id','=',$company->id)
					->where('module_type','=','App\\Company')->first();
		$address_province = isset($address->province_id)?$address->province_id:0;
		$country_province = Province::addSelect('provinces.name as province_name')
						->where('provinces.id','=',$address_province)
						->addSelect('countries.name as country_name')
						->leftJoin('countries','countries.id','=','provinces.country_id')
						->first();
		if($country_province){
			$country_province->toArray();
			$company['province_name'] = $country_province['province_name'];
			$company['country_name'] = $country_province['country_name'];
		}else{
			$company['province_name'] = '';
			$company['country_name'] = '';
		}

		$countries = array();
		$company_type = array();

		$countries = Country::with('provinces')->get()->toArray();
		$company_type = CompanyType::get()->toArray();


		$company->toArray();
		$this->layout->content = view('company.entry',[
		                              'company' 	=> $company,
		                              'address'		=> $address,
		                              'countries'	=> $countries,
		                              'company_type'=> $company_type
		                              ]);
	}

	public function anyCreate(Request $request)
	{
		$company = new Company;
		if($company->save()){
			session(['current_company' => $company->id]);
		}
		// $address = new Address;
		// $address->module_id =  $company->id;
		// $address->module_type = 'App\\Company';
		// if($address->save()){
		// 	session(['current_address' => $address->id]);
		// }
		return redirect('companies');
	}

	public function anyUpdate(Request $request)
	{
		$arr_return = array('status' => 'error');
		$id = session('current_company') !== null ? session('current_company') : 0;
		$address_id = session('current_address') !== null ? session('current_address') : 0;
		if($id){
			$company = Company::find($id);
			$address = Address::getAddressByCompanyId($id);
			session(['current_company' => $company['id'],'current_address' => $address['id']]);
		}else{
			$company = Company::get()->last();
			$address = Address::getAddressByCompanyId($company->id);
			if($company && $address){
				session(['current_company' => $company->id,'current_address' => $address->id]);
			}else{
				$company = new Company;
				$company->save();
				$address = new Address;
				$address->save();
				session(['current_company' => $company->id,'current_address' => $address->id]);
			}
		}

		$company->name = $request->has('name') ? $request->input('name') : '';
		$company->phone = $request->has('phone') ? $request->input('phone') : '';
		$company->company_type_id = $request->has('company_type') ? $request->input('company_type') : 0;
		$company->fax = $request->has('fax') ? $request->input('fax') : '';
		$company->email = $request->has('email') ? $request->input('email') : '';
		$company->web = $request->has('web') ? $request->input('web') : '';
		$company->is_customer = $request->has('is_customer') ? 1:0 ;
		$company->is_distribute = $request->has('is_distribute') ? 1:0;

		$address->address = $request->has('address') ? $request->input('address') : '';
		$address->town_city = $request->has('town_city') ? $request->input('town_city') : '';
		$address->province_id = $request->has('province_id') ? $request->input('province_id') : 0;
		$address->country_id = $request->has('country_id') ? $request->input('country_id') : 0;

		if($company->save()){
			$arr_return['status'] = 'success';
			$arr_return['name'] = $company->name;
		}else{
			$arr_return['message'] = 'Saving fail';
		}
		if($address->save()){
			$arr_return['status'] = 'success';
			$arr_return['name'] = $address->name;
		}else{
			$arr_return['message'] = 'Saving fail';
		}
		return $arr_return;
	}

	public function anyDelete(Request $request)
	{
		$id = session('current_company') !== null ? session('current_company') : 0;
		if($id){
			$company = Company::find($id);
			$company->delete();
			Session::forget('current_company');
		}
		return redirect('companies');
	}

	public function anyList(Request $request)
	{
		if($request->has('input-sort')){
			$arr_sort = $request->input('input-sort');
			$arr_sort =(array) json_decode($arr_sort);
		}elseif( session('sort_filter_company.arr_sort') !== null){
			$arr_sort = session('sort_filter_company.arr_sort');
		}else{
			$arr_sort=array();
		}
		session('sort_filter_company.arr_sort', $arr_sort);


		if($request->has('input-filter')){
			$arr_filter = $request->input('input-filter');
		}elseif( session('sort_filter_company.arr_filter') !== null ){
			$arr_filter = session('sort_filter_company.arr_filter');
		}else{
			$arr_filter=[
					'name'=>'',
					'province_id' => ''
				       ];
		}
		session(['sort_filter_company.arr_sort'=>$arr_sort]);
		session(['sort_filter_company.arr_filter'=> $arr_filter]);

		//Init array
		$list_provinces = Province::get()->toArray();
		//Get value array
		$list_all_companies = Company::select('id','name')->get()->toArray();

		$list_company = Company::select('addresses.*','companies.*','provinces.name as province_name')
						->leftJoin('addresses', function($join){
							$join->on("companies.id","=","addresses.module_id")->where('module_type','=','App\\Company');
						});
		$list_company->addSelect('provinces.name as province_name')->leftJoin('provinces', function($join){
										$join->on("addresses.province_id","=","provinces.id");
									});
		
		foreach ($arr_sort as $key => $value) {
			if($key=='id')
				$list_company->orderBy('companies.id', $value);
			elseif($key=='phone')
				$list_company->orderBy('companies.phone', $value);
			elseif($key=='address')
				$list_company->orderBy('addresses.address', $value);
			elseif($key=='town_city')
				$list_company->orderBy('addresses.town_city', $value);
			elseif($key=='province_name')
				$list_company->orderBy('provinces.name', $value);
			else
				$list_company->orderBy($key, $value);
		}
		if(!count($arr_sort))
			$list_company->orderBy('companies.name', 'asc');

		if($arr_filter['name']!=''){
			$list_company->where('companies.name', $arr_filter['name']);
		}else{
			foreach ($arr_filter as $key => $value) {
				if($value!=''){
					$list_company->where($key,$value);
				}
			}
		}
		$list_company = $list_company->paginate(50);
		$this->layout->content=view('company.list', [
								'list_company' => $list_company,
								'list_all_companies'=>$list_all_companies,
								'arr_sort' => $arr_sort,
								'arr_filter' => $arr_filter,
								'list_provinces' => $list_provinces
							        ]);
	}

	public function anyListClear(Request $request)
	{
		Session::forget('sort_filter_company');
		return redirect('companies/list');
	}

	public function getDeleteFromList(Request $request,$id=0)
	{
		$id_company = $id;
		if($id_company){
			$company = Company::find($id_company);
			if(!$company->status){
				if($company->delete()){
					Log::create_log(\Auth::user()->id,'App\\Company','Xóa công ty số '.$company->name);
				}
			}
		}
		return redirect('returnsaleorders/list');
	}

}