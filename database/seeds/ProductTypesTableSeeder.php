<?php

use Illuminate\Database\Seeder;

class ProductTypesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_types')->delete();
        
		\DB::table('product_types')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Quần áo',
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-06-10 08:10:34',
				'updated_at' => '2015-06-10 08:10:34',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Đồ dùng',
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-06-10 08:10:45',
				'updated_at' => '2015-06-10 08:10:45',
			),
		));
	}

}
