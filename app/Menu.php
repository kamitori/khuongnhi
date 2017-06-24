<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

	public static function getMenu(){
		$arr_menu = Menu::where("active",1)->orderBy('order_no')->get()->toArray();
		$menus= array();
		foreach ($arr_menu as $key => $menu) {
			if($menu['parent_id']==0){
				$menus[$menu['id']] = $menu;
				$menus[$menu['id']]['children'] = array();
			}
		}

		foreach ($arr_menu as $key => $menu) {
			if(isset($menus[$menu['parent_id']])){
				$menus[$menu['parent_id']]['children'][] = $menu;
			}
		}
		return $menus;
	}

	public static function getMenuSetting(){
		$arr_menu = Menu::orderBy('order_no')->get()->toArray();
		$menus= array();
		foreach ($arr_menu as $key => $menu) {
			if($menu['parent_id']==0){
				$menus[$menu['id']] = $menu;
				$menus[$menu['id']]['children'] = array();
			}
		}

		foreach ($arr_menu as $key => $menu) {
			if(isset($menus[$menu['parent_id']])){
				$menus[$menu['parent_id']]['children'][] = $menu;
			}
		}
		return $menus;
	}

}
