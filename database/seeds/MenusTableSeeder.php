<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('menus')->delete();
        
		\DB::table('menus')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'CRM',
				'icon_class' => 'fa fa-university',
				'link' => '',
				'order_no' => 1,
				'parent_id' => 0,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Công ty',
				'icon_class' => 'fa fa-university',
				'link' => 'companies',
				'order_no' => 1,
				'parent_id' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'Liên hệ',
				'icon_class' => 'fa fa-envelope-o',
				'link' => 'contacts',
				'order_no' => 2,
				'parent_id' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'Giao tiếp',
				'icon_class' => 'fa fa-wechat',
				'link' => 'comunications',
				'order_no' => 3,
				'parent_id' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'Tài liệu',
				'icon_class' => 'fa fa-file',
				'link' => 'files',
				'order_no' => 4,
				'parent_id' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'Công nợ',
				'icon_class' => 'fa fa-usd',
				'link' => '',
				'order_no' => 5,
				'parent_id' => 0,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			6 => 
			array (
				'id' => 7,
				'name' => 'Tài khoản',
				'icon_class' => 'fa fa-credit-card',
				'link' => 'accounts',
				'order_no' => 5,
				'parent_id' => 6,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			7 => 
			array (
				'id' => 8,
				'name' => 'Công nợ NCC',
				'icon_class' => 'fa fa-calculator',
				'link' => 'receipts/distribute',
				'order_no' => 6,
				'parent_id' => 6,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:57:25',
			),
			8 => 
			array (
				'id' => 9,
				'name' => 'Doanh thu',
				'icon_class' => 'fa fa-usd',
				'link' => 'revenues',
				'order_no' => 8,
				'parent_id' => 6,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			9 => 
			array (
				'id' => 10,
				'name' => 'Kho',
				'icon_class' => 'fa fa-cubes',
				'link' => '',
				'order_no' => 9,
				'parent_id' => 0,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			10 => 
			array (
				'id' => 11,
				'name' => 'Sản phẩm',
				'icon_class' => 'fa fa-cube',
				'link' => 'products',
				'order_no' => 9,
				'parent_id' => 10,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			11 => 
			array (
				'id' => 12,
				'name' => 'Đại lý trả',
				'icon_class' => 'fa fa-undo',
				'link' => 'returnsaleorders',
				'order_no' => 10,
				'parent_id' => 10,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-24 15:40:00',
			),
			12 => 
			array (
				'id' => 13,
				'name' => 'Đơn hàng',
				'icon_class' => 'fa fa-file-text-o',
				'link' => 'saleorders',
				'order_no' => 11,
				'parent_id' => 10,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			13 => 
			array (
				'id' => 14,
				'name' => 'Mua hàng',
				'icon_class' => 'fa fa-cart-plus',
				'link' => 'purchaseorders',
				'order_no' => 12,
				'parent_id' => 10,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-14 10:54:09',
			),
			14 => 
			array (
				'id' => 15,
				'name' => 'Trả hàng NCC',
				'icon_class' => 'fa fa-undo',
				'link' => 'returnpurchaseorders',
				'order_no' => 13,
				'parent_id' => 10,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-07-24 15:40:15',
			),
			15 => 
			array (
				'id' => 16,
				'name' => 'Công nợ KH',
				'icon_class' => 'fi fi-016',
				'link' => 'receipts/customer',
				'order_no' => 7,
				'parent_id' => 6,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-07-14 10:54:03',
				'updated_at' => '2015-07-14 10:57:37',
			),
		));
	}

}
