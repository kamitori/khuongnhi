<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('permissions')->delete();
        
		\DB::table('permissions')->insert(array (
			0 => 
			array (
				'id' => 34,
				'name' => 'create-purchaseorders',
				'display_name' => 'Tạo đơn mua hàng',
				'description' => 'Tạo đơn mua hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			1 => 
			array (
				'id' => 35,
				'name' => 'create-saleorders',
				'display_name' => 'Tạo đơn hàng',
				'description' => 'Tạo đơn hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			2 => 
			array (
				'id' => 36,
				'name' => 'create-returnpurchaseorders',
				'display_name' => 'Tạo đơn hàng trả NCC',
				'description' => 'Tạo đơn hàng trả NCC',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			3 => 
			array (
				'id' => 37,
				'name' => 'create-returnsaleorders',
				'display_name' => 'Tạo đơn hàng đại lý trả',
				'description' => 'Tạo đơn hàng đại lý trả',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			4 => 
			array (
				'id' => 38,
				'name' => 'complete-purchaseorders',
				'display_name' => 'Hoàn thành đơn mua hàng',
				'description' => 'Hoàn thành đơn mua hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			5 => 
			array (
				'id' => 39,
				'name' => 'complete-saleorders',
				'display_name' => 'Hoàn thành đơn hàng',
				'description' => 'Hoàn thành đơn hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			6 => 
			array (
				'id' => 40,
				'name' => 'complete-returnpurchaseorders',
				'display_name' => 'Hoàn thành đơn hàng trả NCC',
				'description' => 'Hoàn thành đơn hàng trả NCC',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			7 => 
			array (
				'id' => 41,
				'name' => 'complete-returnsaleorders',
				'display_name' => 'Hoàn thành đơn hàng đại lý trả',
				'description' => 'Hoàn thành đơn hàng đại lý trả',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			8 => 
			array (
				'id' => 42,
				'name' => 'edit-purchaseorders',
				'display_name' => 'Cập nhật đơn mua hàng',
				'description' => 'Cập nhật đơn mua hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			9 => 
			array (
				'id' => 43,
				'name' => 'edit-saleorders',
				'display_name' => 'Cập nhật đơn hàng',
				'description' => 'Cập nhật đơn hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			10 => 
			array (
				'id' => 44,
				'name' => 'edit-returnpurchaseorders',
				'display_name' => 'Cập nhật đơn hàng trả NCC',
				'description' => 'Cập nhật đơn hàng trả NCC',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			11 => 
			array (
				'id' => 45,
				'name' => 'edit-returnsaleorders',
				'display_name' => 'Cập nhật đơn hàng đại lý trả',
				'description' => 'Cập nhật đơn hàng đại lý trả',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			12 => 
			array (
				'id' => 46,
				'name' => 'view-purchaseorders',
				'display_name' => 'Xem đơn mua hàng',
				'description' => 'Xem đơn mua hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			13 => 
			array (
				'id' => 47,
				'name' => 'view-saleorders',
				'display_name' => 'Xem đơn hàng',
				'description' => 'Xem đơn hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			14 => 
			array (
				'id' => 48,
				'name' => 'view-returnpurchaseorders',
				'display_name' => 'Xem đơn hàng trả NCC',
				'description' => 'Xem đơn hàng trả NCC',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			15 => 
			array (
				'id' => 49,
				'name' => 'view-returnsaleorders',
				'display_name' => 'Xem đơn hàng đại lý trả',
				'description' => 'Xem đơn hàng đại lý trả',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			16 => 
			array (
				'id' => 50,
				'name' => 'delete-purchaseorders',
				'display_name' => 'Xóa đơn mua hàng',
				'description' => 'Xóa đơn mua hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			17 => 
			array (
				'id' => 51,
				'name' => 'delete-saleorders',
				'display_name' => 'Xóa đơn hàng',
				'description' => 'Xóa đơn hàng',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			18 => 
			array (
				'id' => 52,
				'name' => 'delete-returnpurchaseorders',
				'display_name' => 'Xóa đơn hàng trả NCC',
				'description' => 'Xóa đơn hàng trả NCC',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			19 => 
			array (
				'id' => 53,
				'name' => 'delete-returnsaleorders',
				'display_name' => 'Xóa đơn hàng đại lý trả',
				'description' => 'Xóa đơn hàng đại lý trả',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			20 => 
			array (
				'id' => 54,
				'name' => 'create-products',
				'display_name' => 'Tạo sản phẩm',
				'description' => 'Tạo sản phẩm',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			21 => 
			array (
				'id' => 55,
				'name' => 'delete-products',
				'display_name' => 'Xóa sản phẩm',
				'description' => 'Xóa sản phẩm',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			22 => 
			array (
				'id' => 56,
				'name' => 'sellprice-products',
				'display_name' => 'Thêm giá bán sản phẩm',
				'description' => 'Thêm giá bán sản phẩm',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			23 => 
			array (
				'id' => 57,
				'name' => 'view-products',
				'display_name' => 'Xem sản phẩm',
				'description' => 'Xem sản phẩm',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			24 => 
			array (
				'id' => 58,
				'name' => 'edit-products',
				'display_name' => 'Cập nhật sản phẩm',
				'description' => 'Cập nhật sản phẩm',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			25 => 
			array (
				'id' => 59,
				'name' => 'create-companies',
				'display_name' => 'Tạo công ty',
				'description' => 'Tạo công ty',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			26 => 
			array (
				'id' => 60,
				'name' => 'delete-companies',
				'display_name' => 'Xóa công ty',
				'description' => 'Xóa công ty',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			27 => 
			array (
				'id' => 61,
				'name' => 'view-companies',
				'display_name' => 'Xem công ty',
				'description' => 'Xem công ty',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			28 => 
			array (
				'id' => 62,
				'name' => 'edit-companies',
				'display_name' => 'Cập nhật công ty',
				'description' => 'Cập nhật công ty',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			29 => 
			array (
				'id' => 63,
				'name' => 'view-settings',
				'display_name' => 'Truy cập bảng điều khiển',
				'description' => 'Truy cập bảng điều khiển',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			30 => 
			array (
				'id' => 64,
				'name' => 'view-receipts',
				'display_name' => 'Truy cập công nợ',
				'description' => 'Truy cập công nợ',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			31 => 
			array (
				'id' => 65,
				'name' => 'view-revenues',
				'display_name' => 'Truy cập doanh thu',
				'description' => 'Truy cập doanh thu',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			32 => 
			array (
				'id' => 66,
				'name' => 'view-historys',
				'display_name' => 'Truy cập lịch sử',
				'description' => 'Truy cập lịch sử',
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
		));
	}

}
