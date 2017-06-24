<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('roles')->delete();
        
		\DB::table('roles')->insert(array (
			0 => 
			array (
				'id' => 4,
				'name' => 'admin',
				'display_name' => 'Quản trị web',
				'description' => 'Toàn quyền trên hệ thống',
				'main' => 1,
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			1 => 
			array (
				'id' => 5,
				'name' => 'user',
				'display_name' => 'Nhân viên',
				'description' => 'User chỉ được thực thi những quyền chỉ định',
				'main' => 1,
				'created_at' => '2015-08-14 09:22:55',
				'updated_at' => '2015-08-14 09:22:55',
			),
			2 => 
			array (
				'id' => 6,
				'name' => 'test_quyen',
				'display_name' => 'Test quyền',
				'description' => 'cái này để test',
				'main' => 0,
				'created_at' => '2015-08-14 09:26:29',
				'updated_at' => '2015-08-14 09:26:29',
			),
		));
	}

}
